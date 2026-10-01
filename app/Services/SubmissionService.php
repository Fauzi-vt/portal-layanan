<?php

namespace App\Services;

use App\Enums\DocumentValidationStatus;
use App\Enums\SubmissionStatus;
use App\Models\Service;
use App\Models\Submission;
use App\Models\SubmissionDocument;
use App\Models\SubmissionHistory;
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

            // Tentukan status awal jika submit langsung
            $isDirectSubmit = !empty($data['submit_now']);
            if ($isDirectSubmit) {
                $initialStatus = $service->requires_desa_approval
                    ? SubmissionStatus::SubmittedDesa
                    : SubmissionStatus::Submitted;
            } else {
                $initialStatus = SubmissionStatus::Draft;
            }

            $submission = Submission::create([
                'nomor_tiket'     => $ticketNumber,
                'user_id'         => $citizen->id,
                'kecamatan_id'    => $kecamatanId,
                'desa_id'         => $citizen->desa_id,
                'service_id'      => $service->id,
                'status'          => $initialStatus,
                'form_data'       => $data['form_data'] ?? null,
                'catatan_petugas' => null,
            ]);

            $this->recordHistory(
                $submission,
                $citizen,
                'created',
                null,
                $initialStatus,
                $isDirectSubmit ? 'Permohonan baru diajukan langsung oleh pemohon.' : 'Draft permohonan baru disimpan oleh pemohon.'
            );

            // Simpan berkas yang diunggah
            if (!empty($data['documents']) && is_array($data['documents'])) {
                $this->uploadRequirementDocuments($submission, $service, $data['documents']);
            }

            return $submission->load(['service.requirements', 'documents.requirement', 'kecamatan', 'desa', 'user']);
        });
    }

    /**
     * Update permohonan yang masih berstatus draft.
     */
    public function updateDraft(Submission $submission, array $data): Submission
    {
        return DB::transaction(function () use ($submission, $data) {
            if ($submission->status !== SubmissionStatus::Draft) {
                throw new \DomainException('Hanya permohonan dalam status Draft yang dapat diubah.');
            }

            $updateData = [];
            
            if (isset($data['kecamatan_id'])) {
                $updateData['kecamatan_id'] = $data['kecamatan_id'];
            }
            
            if (array_key_exists('form_data', $data)) {
                $updateData['form_data'] = $data['form_data'];
            }

            if (!empty($updateData)) {
                $submission->update($updateData);
            }

            // Simpan berkas yang diunggah
            if (!empty($data['documents']) && is_array($data['documents'])) {
                $this->uploadRequirementDocuments($submission, $submission->service, $data['documents']);
            }

            return $submission->fresh(['service.requirements', 'documents.requirement', 'kecamatan', 'desa', 'user']);
        });
    }

    /**
     * Kirimkan permohonan yang masih berstatus draft ke status submitted / submitted_desa.
     */
    public function submitDraft(Submission $submission): Submission
    {
        if ($submission->status !== SubmissionStatus::Draft) {
            throw new \DomainException('Hanya permohonan dalam status Draft yang dapat diajukan.');
        }

        // Validasi kelengkapan dokumen wajib
        $this->assertRequiredDocumentsUploaded($submission);

        $targetStatus = $submission->service->requires_desa_approval
            ? SubmissionStatus::SubmittedDesa
            : SubmissionStatus::Submitted;

        $oldStatus = $submission->status;
        $submission->update([
            'status'  => $targetStatus,
            'desa_id' => $submission->desa_id ?? $submission->user->desa_id,
        ]);

        $this->recordHistory(
            $submission,
            $submission->user,
            'submitted',
            $oldStatus,
            $targetStatus,
            'Permohonan diajukan dari status draft.'
        );

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

            // Jika butuh desa dan belum diverifikasi desa, kembalikan ke meja desa
            $nextStatus = ($service->requires_desa_approval && is_null($submission->verified_desa_at))
                ? SubmissionStatus::SubmittedDesa
                : SubmissionStatus::Submitted;

            $oldStatus = $submission->status;
            $submission->update([
                'status'          => $nextStatus,
                'catatan_petugas' => "Revisi berkas telah diunggah oleh pemohon pada: " . Carbon::now()->isoFormat('D MMMM Y, HH:mm') . " WIB.",
            ]);

            $this->recordHistory(
                $submission,
                $submission->user,
                'revision_submitted',
                $oldStatus,
                $nextStatus,
                'Pemohon telah mengunggah berkas perbaikan/revisi.'
            );

            return $submission->fresh(['documents.requirement', 'service', 'kecamatan', 'desa']);
        });
    }

    /**
     * Verifikasi berkas oleh Kasi Pelayanan Desa (Admin Desa).
     */
    public function verifyByDesa(Submission $submission, User $adminDesa, string $action, ?string $catatan = null): Submission
    {
        return DB::transaction(function () use ($submission, $adminDesa, $action, $catatan) {
            $now = Carbon::now();
            $namaDesa = $adminDesa->desa?->nama_desa ?? 'Pemerintah Desa';
            $oldStatus = $submission->status;

            if ($action === 'approve') {
                // Berkas disetujui pihak Desa -> Diteruskan ke Antrean Kecamatan
                $submission->update([
                    'status'              => SubmissionStatus::Submitted,
                    'verified_by_desa_id' => $adminDesa->id,
                    'verified_desa_at'    => $now,
                    'catatan_desa'        => $catatan ?: "Berkas lengkap dan telah diverifikasi oleh {$namaDesa}. Diteruskan ke Kecamatan.",
                    'catatan_petugas'     => "Diverifikasi oleh {$namaDesa} pada " . $now->isoFormat('D MMMM Y, HH:mm') . " WIB.",
                ]);
                $this->recordHistory($submission, $adminDesa, 'verified_desa_approved', $oldStatus, SubmissionStatus::Submitted, $catatan ?: "Diverifikasi & disetujui oleh {$namaDesa}.");
            } elseif ($action === 'revision') {
                // Berkas kurang lengkap / perlu perbaikan dari warga
                $submission->update([
                    'status'          => SubmissionStatus::RevisionRequired,
                    'catatan_desa'    => $catatan,
                    'catatan_petugas' => "[Kasi Pelayanan Desa]: " . ($catatan ?: 'Mohon perbaiki berkas persyaratan yang belum sesuai.'),
                ]);
                $this->recordHistory($submission, $adminDesa, 'verified_desa_revision', $oldStatus, SubmissionStatus::RevisionRequired, $catatan ?: 'Desa meminta perbaikan berkas.');
            } elseif ($action === 'reject') {
                // Berkas ditolak di tingkat desa
                $submission->update([
                    'status'          => SubmissionStatus::Rejected,
                    'catatan_desa'    => $catatan,
                    'catatan_petugas' => "[Ditolak Desa]: " . ($catatan ?: 'Permohonan tidak memenuhi persyaratan administrasi desa.'),
                ]);
                $this->recordHistory($submission, $adminDesa, 'verified_desa_rejected', $oldStatus, SubmissionStatus::Rejected, $catatan ?: 'Permohonan ditolak di tingkat desa.');
            } else {
                throw new \InvalidArgumentException("Aksi verifikasi desa '{$action}' tidak valid.");
            }

            return $submission->fresh(['documents.requirement', 'service', 'kecamatan', 'desa', 'user', 'verifiedByDesa']);
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
        return DB::transaction(function () use ($submission, $reviewer, $reviewData) {
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

            $oldStatus = $submission->status;
            $newStatus = SubmissionStatus::from($reviewData['status']);

            $submission->update([
                'status'          => $newStatus,
                'catatan_petugas' => $reviewData['catatan_petugas'] ?? $submission->catatan_petugas,
            ]);

            $this->recordHistory(
                $submission,
                $reviewer,
                'reviewed_kecamatan',
                $oldStatus,
                $newStatus,
                $reviewData['catatan_petugas'] ?? "Status diverifikasi menjadi: {$newStatus->label()}"
            );

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

        $oldStatus = $submission->status;
        $submission->update([
            'jadwal_biometrik' => $jadwal,
            'nomor_antrean'    => $queueNumber,
            'status'           => SubmissionStatus::Processed,
            'catatan_petugas'  => "Jadwal rekam biometrik e-KTP ditetapkan pada {$jadwal->isoFormat('dddd, D MMMM Y - HH:mm')} WIB di Kantor Kecamatan {$submission->kecamatan->nama_kecamatan}. Nomor antrean Anda: {$queueNumber}.",
        ]);

        $this->recordHistory(
            $submission,
            auth()->user(),
            'biometric_scheduled',
            $oldStatus,
            SubmissionStatus::Processed,
            "Jadwal perekaman biometrik e-KTP ditetapkan pada {$jadwal->isoFormat('dddd, D MMMM Y - HH:mm')} WIB (Nomor antrean: {$queueNumber})."
        );

        return $submission;
    }

    /**
     * Selesaikan permohonan dan lampirkan e-dokumen hasil.
     */
    public function completeSubmission(Submission $submission, ?UploadedFile $outputFile = null, ?string $completionNotes = null): Submission
    {
        return DB::transaction(function () use ($submission, $outputFile, $completionNotes) {
            $oldStatus = $submission->status;
            $outputPath = $submission->output_document_path;

            if ($outputFile) {
                $outputPath = $this->uploadService->storeOutputDocument($outputFile, $submission->id);
            }

            $submission->update([
                'status'               => SubmissionStatus::Completed,
                'output_document_path' => $outputPath,
                'catatan_petugas'      => $completionNotes ?? 'Permohonan telah selesai diproses. Anda dapat mengunduh dokumen hasil atau mengambil berkas fisik di kantor kecamatan.',
            ]);

            $this->recordHistory(
                $submission,
                auth()->user(),
                'completed',
                $oldStatus,
                SubmissionStatus::Completed,
                $completionNotes ?? 'Permohonan selesai dan dokumen hasil diterbitkan.'
            );

            return $submission->fresh();
        });
    }

    /**
     * Tolak permohonan dengan alasan jelas.
     */
    public function rejectSubmission(Submission $submission, string $reason): Submission
    {
        $oldStatus = $submission->status;
        $submission->update([
            'status'          => SubmissionStatus::Rejected,
            'catatan_petugas' => $reason,
        ]);

        $this->recordHistory(
            $submission,
            auth()->user(),
            'rejected',
            $oldStatus,
            SubmissionStatus::Rejected,
            $reason
        );

        return $submission;
    }

    // ─────────────────────────────────────────────
    // Helper Internal
    // ─────────────────────────────────────────────

    /**
     * Catat histori perubahan status permohonan ke tabel submission_histories (Audit Trail).
     */
    private function recordHistory(
        Submission $submission,
        ?User $actor,
        string $action,
        string|SubmissionStatus|null $oldStatus,
        string|SubmissionStatus $newStatus,
        ?string $catatan = null
    ): void {
        SubmissionHistory::create([
            'submission_id' => $submission->id,
            'user_id'       => $actor?->id,
            'action'        => $action,
            'old_status'    => $oldStatus instanceof SubmissionStatus ? $oldStatus->value : $oldStatus,
            'new_status'    => $newStatus instanceof SubmissionStatus ? $newStatus->value : $newStatus,
            'catatan'       => $catatan,
        ]);
    }
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
        $requiredReqs = $submission->service->requiredDocuments()->get();
        $uploadedReqIds = $submission->documents()->pluck('service_requirement_id')->toArray();

        $formData = $submission->form_data ?? [];
        $hasOnlineForm = !empty($formData['f101']['nama_pemohon'])
            || !empty($formData['f101']['nama_kepala_keluarga'])
            || !empty($formData['kk_add']['nama_kepala_keluarga'])
            || !empty($formData['kk_del']['nama_kepala_keluarga'])
            || !empty($formData['pindah_satu_desa']['nama_kepala'])
            || !empty($formData['pindah_antar_desa']['nama_kepala'])
            || !empty($formData['pindah_antar_kecamatan']['nama_kepala']);

        $missing = [];
        foreach ($requiredReqs as $req) {
            $isF1Doc = str_contains($req->nama_persyaratan, 'F-1.01')
                || str_contains($req->nama_persyaratan, 'F-1.15')
                || str_contains($req->nama_persyaratan, 'Formulir');

            if ($isF1Doc && $hasOnlineForm) {
                continue;
            }

            if (!in_array($req->id, $uploadedReqIds)) {
                $missing[] = $req->id;
            }
        }

        if (!empty($missing)) {
            throw ValidationException::withMessages([
                'documents' => 'Masih ada dokumen persyaratan wajib yang belum diunggah.',
            ]);
        }
    }
}
