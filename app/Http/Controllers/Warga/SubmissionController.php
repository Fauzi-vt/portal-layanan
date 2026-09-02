<?php

namespace App\Http\Controllers\Warga;

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

        $submissions = $request->user()->submissions()
            ->with(['service', 'kecamatan'])
            ->when($statusFilter, fn($q) => $q->where('status', $statusFilter))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('warga.submissions.index', compact('submissions', 'statusFilter'));
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
        $kecamatans = Kecamatan::orderBy('nama_kecamatan')->get();
        $user = $request->user()->load(['kecamatan', 'desa']);

        return view('warga.submissions.create', compact('service', 'services', 'kecamatans', 'user'));
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
        ]);

        return view('warga.submissions.show', compact('submission'));
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

        if (! $submission->output_document_path || ! Storage::disk('public')->exists($submission->output_document_path)) {
            return back()->with('error', 'Dokumen hasil belum tersedia atau file tidak ditemukan.');
        }

        return Storage::disk('public')->download(
            $submission->output_document_path,
            "{$submission->nomor_tiket}_{$submission->service->kode_layanan}_Dokumen_Hasil.pdf"
        );
    }
}
