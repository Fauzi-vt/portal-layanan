<?php

namespace App\Http\Controllers\Warga;

use App\Enums\SubmissionStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Submission\StoreSubmissionRequest;
use App\Http\Requests\Submission\UpdateRevisionRequest;
use App\Models\Kecamatan;
use App\Models\Service;
use App\Models\Submission;
use App\Services\SubmissionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SubmissionController extends Controller
{
    public function __construct(
        protected SubmissionService $submissionService
    ) {}

    /**
     * Tampilkan daftar seluruh riwayat pengajuan milik warga yang login.
     */
    public function index(Request $request): View
    {
        $statusFilter = $request->query('status');
        $user = $request->user();

        // Hitung badge counter untuk tab & navigasi
        $counts = [
            'all'       => $user->submissions()->count(),
            'submitted' => $user->submissions()->whereIn('status', [
                SubmissionStatus::Submitted,
                SubmissionStatus::InReview,
                SubmissionStatus::Processed,
            ])->count(),
            'rejected'  => $user->submissions()->whereIn('status', [
                SubmissionStatus::Rejected,
                SubmissionStatus::RevisionRequired,
            ])->count(),
            'completed' => $user->submissions()->where('status', SubmissionStatus::Completed)->count(),
        ];

        $submissions = $user->submissions()
            ->with(['service', 'kecamatan'])
            ->when($statusFilter, function ($query, $status) {
                return match ($status) {
                    'submitted', 'dikirim', 'proses' => $query->whereIn('status', [
                        SubmissionStatus::Submitted,
                        SubmissionStatus::InReview,
                        SubmissionStatus::Processed,
                    ]),
                    'rejected', 'ditolak', 'revisi' => $query->whereIn('status', [
                        SubmissionStatus::Rejected,
                        SubmissionStatus::RevisionRequired,
                    ]),
                    'completed', 'terbit', 'selesai' => $query->where('status', SubmissionStatus::Completed),
                    default => $query->where('status', $status),
                };
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('warga.submissions.index', compact('submissions', 'statusFilter', 'counts'));
    }

    /**
     * Formulir pembuatan permohonan baru untuk jenis layanan tertentu.
     */
    public function create(Request $request): View
    {
        $serviceCode = $request->query('service');
        $service = null;

        if ($serviceCode) {
            $service = Service::with('requirements')
                ->where('kode_layanan', $serviceCode)
                ->where('is_active', true)
                ->first();
        }

        $services = Service::where('is_active', true)->orderBy('urutan')->get();
        $kecamatans = Kecamatan::with('desas')->orderBy('nama_kecamatan')->get();
        $user = $request->user()->load(['kecamatan', 'desa']);
        $desas = $user->kecamatan_id
            ? \App\Models\Desa::where('kecamatan_id', $user->kecamatan_id)->orderBy('nama_desa')->get()
            : collect();

        return view('warga.submissions.create', compact('service', 'services', 'kecamatans', 'desas', 'user'));
    }

    /**
     * Simpan permohonan baru.
     */
    public function store(StoreSubmissionRequest $request): RedirectResponse
    {
        $submission = $this->submissionService->createSubmission(
            $request->user(),
            $request->validated()
        );

        $message = $submission->status === \App\Enums\SubmissionStatus::Submitted
            ? "Permohonan berhasil dikirim dengan Nomor Tiket: {$submission->nomor_tiket}."
            : "Draft permohonan berhasil disimpan dengan Nomor Tiket: {$submission->nomor_tiket}.";

        return redirect()
            ->route('warga.submissions.show', $submission)
            ->with('success', $message);
    }

    /**
     * Detail pelacakan status permohonan secara real-time.
     */
    public function show(Submission $submission, Request $request): View
    {
        $this->authorize('view', $submission);

        $submission->load([
            'service.requirements',
            'documents.requirement',
            'kecamatan',
            'user.desa',
            'histories.user',
        ]);

        return view('warga.submissions.show', compact('submission'));
    }

    /**
     * Edit draft permohonan.
     */
    public function edit(Submission $submission, Request $request): View|\Illuminate\Http\RedirectResponse
    {
        $this->authorize('update', $submission);

        if ($submission->status !== \App\Enums\SubmissionStatus::Draft) {
            return redirect()->route('warga.submissions.show', $submission)
                ->with('error', 'Hanya permohonan berstatus Draft yang dapat diubah.');
        }

        $submission->load([
            'service.requirements',
            'documents.requirement',
        ]);

        $service = $submission->service;
        $kecamatans = \App\Models\Kecamatan::with('desas')->orderBy('nama_kecamatan')->get();
        $user = $request->user()->load(['kecamatan', 'desa']);
        $desas = $user->kecamatan_id
            ? \App\Models\Desa::where('kecamatan_id', $user->kecamatan_id)->orderBy('nama_desa')->get()
            : collect();

        return view('warga.submissions.edit', compact('submission', 'service', 'kecamatans', 'desas', 'user'));
    }

    /**
     * Simpan perubahan draft permohonan.
     */
    public function update(\App\Http\Requests\Submission\UpdateDraftRequest $request, Submission $submission): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('update', $submission);

        if ($submission->status !== \App\Enums\SubmissionStatus::Draft) {
            return redirect()->route('warga.submissions.show', $submission)
                ->with('error', 'Hanya permohonan berstatus Draft yang dapat diubah.');
        }

        $this->submissionService->updateDraft(
            $submission,
            $request->validated()
        );

        return redirect()
            ->route('warga.submissions.show', $submission)
            ->with('success', 'Perubahan pada draft berhasil disimpan.');
    }

    /**
     * Kirim draft pengajuan ke status submitted.
     */
    public function submitDraft(Submission $submission): RedirectResponse
    {
        $this->authorize('update', $submission);

        try {
            $this->submissionService->submitDraft($submission);
            return back()->with('success', 'Permohonan Anda berhasil diajukan dan sedang mengantre verifikasi.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $firstError = collect($e->errors())->flatten()->first() ?: 'Masih ada dokumen persyaratan wajib yang belum diunggah.';
            return back()->withErrors($e->errors())->with('error', $firstError);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Warga mengunggah perbaikan/revisi berkas.
     */
    public function updateRevision(UpdateRevisionRequest $request, Submission $submission): RedirectResponse
    {
        $this->authorize('update', $submission);

        $this->submissionService->submitRevision(
            $submission,
            $request->file('documents', [])
        );

        return redirect()
            ->route('warga.submissions.show', $submission)
            ->with('success', 'Berkas perbaikan Anda telah berhasil dikirim ulang ke verifikator kecamatan.');
    }

    /**
     * Unduh file e-dokumen hasil setelah pengajuan selesai.
     */
    public function downloadOutput(Submission $submission)
    {
        $this->authorize('view', $submission);

        // Jika status selesai, pastikan file fisik dokumen hasil ada pada storage
        if ($submission->isCompleted()) {
            $hasLocal = $submission->output_document_path && Storage::disk('local')->exists($submission->output_document_path);
            $hasPublic = $submission->output_document_path && Storage::disk('public')->exists($submission->output_document_path);

            if (! $hasLocal && ! $hasPublic) {
                $uploadService = app(\App\Services\DocumentUploadService::class);
                $generatedPath = $uploadService->generateDefaultOutputPdf($submission);
                $submission->update(['output_document_path' => $generatedPath]);
            }
        }

        $activeDisk = ($submission->output_document_path && Storage::disk('local')->exists($submission->output_document_path))
            ? 'local'
            : 'public';

        if (! $submission->output_document_path || ! Storage::disk($activeDisk)->exists($submission->output_document_path)) {
            if ($submission->form_data && isset($submission->form_data['f101'])) {
                return redirect()->route('warga.submissions.print-f101', $submission);
            }

            return back()->with('error', 'Dokumen hasil belum tersedia atau file tidak ditemukan.');
        }

        return Storage::disk($activeDisk)->download(
            $submission->output_document_path,
            "{$submission->nomor_tiket}_{$submission->service->kode_layanan}_Dokumen_Hasil.pdf"
        );
    }

    /**
     * Cetak dokumen resmi Formulir F-1.01 Biodata Keluarga pemohon.
     */
    public function printF101(Submission $submission): View
    {
        $this->authorize('view', $submission);

        $submission->load(['service', 'kecamatan', 'user.desa']);
        $f101 = $submission->form_data['f101'] ?? null;

        return view('submissions.print-f101', compact('submission', 'f101'));
    }
}
