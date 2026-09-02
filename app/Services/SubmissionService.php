<?php

namespace App\Services;

use App\Enums\DocumentValidationStatus;
use App\Enums\SubmissionStatus;
use App\Models\Service;
use App\Models\Submission;
use App\Models\SubmissionDocument;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SubmissionService
{
    public function __construct(
        protected DocumentUploadService $uploadService
    ) {}

    /**
     * Buat permohonan baru oleh Warga.
     *
     * @param User $citizen
     * @param array $data ['service_id', 'kecamatan_id', 'form_data', 'documents' => [...], 'submit_now' => bool]
     * @return Submission
     */
    public function createSubmission(User $citizen, array $data): Submission
    {
        return DB::transaction(function () use ($citizen, $data) {
            $service = Service::with('requirements')->findOrFail($data['service_id']);
            $kecamatanId = $data['kecamatan_id'] ?? $citizen->kecamatan_id;

            if (! $kecamatanId) {
                throw ValidationException::withMessages([
                    'kecamatan_id' => 'Kecamatan tujuan permohonan wajib dipilih.',
                ]);
            }

            // Generate nomor tiket
            $ticketNumber = Submission::generateTicketNumber($kecamatanId);

            // Status awal: draft atau langsung submitted jika diminta
            $isDirectSubmit = !empty($data['submit_now']);
            $initialStatus = $isDirectSubmit ? SubmissionStatus::Submitted : SubmissionStatus::Draft;

            $submission = Submission::create([
                'nomor_tiket'     => $ticketNumber,
                'user_id'         => $citizen->id,
                'kecamatan_id'    => $kecamatanId,
                'service_id'      => $service->id,
                'status'          => $initialStatus,
                'form_data'       => $data['form_data'] ?? null,
                'catatan_petugas' => null,
            ]);

            // Simpan berkas yang diunggah
            if (!empty($data['documents']) && is_array($data['documents'])) {
                $this->uploadRequirementDocuments($submission, $service, $data['documents']);
            }

            return $submission->load(['service.requirements', 'documents.requirement', 'kecamatan', 'user']);
        });
    }

    /**
     * Kirimkan permohonan yang masih berstatus draft ke status submitted.
     */
    public function submitDraft(Submission $submission): Submission
    {
        if ($submission->status !== SubmissionStatus::Draft) {
            throw new \DomainException('Hanya permohonan dalam status Draft yang dapat diajukan.');
        }

        // Validasi kelengkapan dokumen wajib
        $this->assertRequiredDocumentsUploaded($submission);

        $submission->update([
            'status' => SubmissionStatus::Submitted,
        ]);

        return $submission;
    }

    /**
     * Warga mengirimkan perbaikan/revisi dokumen setelah status revision_required.
     */
    public function submitRevision(Submission $submission, array $newDocuments): Submission
    {
        if (! $submission->status->isEditableByCitizen()) {
            throw new \DomainException('Permohonan tidak dalam status yang membutuhkan revisi.');
        }

        return DB::transaction(function () use ($submission, $newDocuments) {
            $service = $submission->service;

            // Upload berkas perbaikan baru
            if (!empty($newDocuments)) {
                $this->uploadRequirementDocuments($submission, $service, $newDocuments);
            }

            // Ubah kembali status ke submitted untuk ditinjau ulang petugas
            $submission->update([
                'status'          => SubmissionStatus::Submitted,
                'catatan_petugas' => "Revisi berkas telah diunggah oleh pemohon pada: " . Carbon::now()->isoFormat('D MMMM Y, HH:mm') . " WIB.",
            ]);

            return $submission->fresh(['documents.requirement', 'service', 'kecamatan']);
        });
    }

    /**
     * Verifikasi & Peninjauan Berkas oleh Petugas Admin Kecamatan.
     *
     * @param Submission $submission
     * @param User $reviewer
     * @param array $reviewData [
     *    'status'           => 'in_review' | 'revision_required' | 'processed',
     *    'catatan_petugas'  => string|null,
     *    'document_reviews' => [ requirement_id => ['status' => 'valid'|'invalid', 'note' => string|null] ]
     * ]
     * @return Submission
     */
    public function reviewSubmission(Submission $submission, User $reviewer, array $reviewData): Submission
    {
        return DB::transaction(function () use ($submission, $reviewData) {
            // Update validasi per butir dokumen
            if (!empty($reviewData['document_reviews']) && is_array($reviewData['document_reviews'])) {
                foreach ($reviewData['document_reviews'] as $reqId => $docReview) {
                    $doc = SubmissionDocument::where('submission_id', $submission->id)
                        ->where('service_requirement_id', $reqId)
                        ->first();

                    if ($doc) {
                        $doc->update([
                            'status_validasi' => $docReview['status'] ?? DocumentValidationStatus::Pending->value,
                            'catatan_dokumen' => $docReview['note'] ?? null,
                        ]);
                    }
                }
            }

            $newStatus = SubmissionStatus::from($reviewData['status']);

            $submission->update([
                'status'          => $newStatus,
                'catatan_petugas' => $reviewData['catatan_petugas'] ?? $submission->catatan_petugas,
            ]);

            return $submission->fresh(['documents.requirement', 'service', 'kecamatan', 'user']);
        });
    }

    /**
     * Atur jadwal dan antrean rekam biometrik e-KTP.
     */
    public function scheduleBiometric(Submission $submission, Carbon|string $datetime, ?string $queueNumber = null): Submission
    {
        $jadwal = $datetime instanceof Carbon ? $datetime : Carbon::parse($datetime);

        // Jika nomor antrean tidak disediakan, auto-generate antrean harian: A-001, A-002, dst.
        if (! $queueNumber) {
            $countToday = Submission::where('kecamatan_id', $submission->kecamatan_id)
                ->whereDate('jadwal_biometrik', $jadwal->toDateString())
                ->count();

            $nextNumber = str_pad((string)($countToday + 1), 3, '0', STR_PAD_LEFT);
            $queueNumber = "A-{$nextNumber}";
        }

        $submission->update([
            'jadwal_biometrik' => $jadwal,
            'nomor_antrean'    => $queueNumber,
            'status'           => SubmissionStatus::Processed,
            'catatan_petugas'  => "Jadwal rekam biometrik e-KTP ditetapkan pada {$jadwal->isoFormat('dddd, D MMMM Y - HH:mm')} WIB di Kantor Kecamatan {$submission->kecamatan->nama_kecamatan}. Nomor antrean Anda: {$queueNumber}.",
        ]);

        return $submission;
    }

    /**
     * Selesaikan permohonan dan lampirkan e-dokumen hasil.
     */
    public function completeSubmission(Submission $submission, ?UploadedFile $outputFile = null, ?string $completionNotes = null): Submission
    {
        return DB::transaction(function () use ($submission, $outputFile, $completionNotes) {
            $outputPath = $submission->output_document_path;

            if ($outputFile) {
                $outputPath = $this->uploadService->storeOutputDocument($outputFile, $submission->id);
            }

            $submission->update([
                'status'               => SubmissionStatus::Completed,
                'output_document_path' => $outputPath,
                'catatan_petugas'      => $completionNotes ?? 'Permohonan telah selesai diproses. Anda dapat mengunduh dokumen hasil atau mengambil berkas fisik di kantor kecamatan.',
            ]);

            return $submission->fresh();
        });
    }

    /**
     * Tolak permohonan dengan alasan jelas.
     */
    public function rejectSubmission(Submission $submission, string $reason): Submission
    {
        $submission->update([
            'status'          => SubmissionStatus::Rejected,
            'catatan_petugas' => $reason,
        ]);

        return $submission;
    }

    // ─────────────────────────────────────────────
    // Helper Internal
    // ─────────────────────────────────────────────

    private function uploadRequirementDocuments(Submission $submission, Service $service, array $files): void
    {
        foreach ($files as $requirementId => $file) {
            if ($file instanceof UploadedFile) {
                $requirement = $service->requirements()->find($requirementId);
                if ($requirement) {
                    $this->uploadService->storeRequirementDocument($file, $submission->id, $requirement);
                }
            }
        }
    }

    private function assertRequiredDocumentsUploaded(Submission $submission): void
    {
        $requiredReqIds = $submission->service->requiredDocuments()->pluck('id')->toArray();
        $uploadedReqIds = $submission->documents()->pluck('service_requirement_id')->toArray();

        $missing = array_diff($requiredReqIds, $uploadedReqIds);

        if (!empty($missing)) {
            throw ValidationException::withMessages([
                'documents' => 'Masih ada dokumen persyaratan wajib yang belum diunggah.',
            ]);
        }
    }
}
