<?php

namespace App\Http\Controllers\Kecamatan;

use App\Enums\SubmissionStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Submission\CompleteSubmissionRequest;
use App\Http\Requests\Submission\ReviewSubmissionRequest;
use App\Http\Requests\Submission\ScheduleBiometricRequest;
use App\Models\Service;
use App\Models\Submission;
use App\Services\SubmissionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubmissionController extends Controller
{
    public function __construct(
        protected SubmissionService $submissionService
    ) {}

    /**
     * Tampilkan daftar seluruh permohonan masuk di wilayah kecamatan admin.
     * Menerapkan Scope Isolasi Multi-Tenant berdasarkan user->kecamatan_id.
     */
    public function index(Request $request): View
    {
        $admin = $request->user();
        $status = $request->query('status');
        $serviceId = $request->query('service_id');
        $search = $request->query('search');

        $submissions = Submission::forKecamatan($admin->kecamatan_id)
            ->with(['service', 'user.desa'])
            ->when($status, fn($q) => $q->where('status', $status))
            ->when($serviceId, fn($q) => $q->where('service_id', $serviceId))
            ->when($search, function($q) use ($search) {
                $q->where(function($sub) use ($search) {
                    $sub->where('nomor_tiket', 'ilike', "%{$search}%")
                        ->orWhereHas('user', function($u) use ($search) {
                            $u->where('name', 'ilike', "%{$search}%")
                              ->orWhere('nik', 'ilike', "%{$search}%");
                        });
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $services = Service::where('is_active', true)->orderBy('urutan')->get();

        // Counter statistik untuk tabs di dashboard kecamatan
        $counts = [
            'total'             => Submission::forKecamatan($admin->kecamatan_id)->count(),
            'submitted'         => Submission::forKecamatan($admin->kecamatan_id)->where('status', SubmissionStatus::Submitted)->count(),
            'in_review'         => Submission::forKecamatan($admin->kecamatan_id)->where('status', SubmissionStatus::InReview)->count(),
            'revision_required' => Submission::forKecamatan($admin->kecamatan_id)->where('status', SubmissionStatus::RevisionRequired)->count(),
            'processed'         => Submission::forKecamatan($admin->kecamatan_id)->where('status', SubmissionStatus::Processed)->count(),
            'completed'         => Submission::forKecamatan($admin->kecamatan_id)->where('status', SubmissionStatus::Completed)->count(),
        ];

        return view('kecamatan.submissions.index', compact('submissions', 'services', 'counts', 'status', 'serviceId', 'search'));
    }

    /**
     * Halaman kerja verifikasi berkas permohonan.
     */
    public function show(Submission $submission, Request $request): View
    {
        $this->authorize('review', $submission);

        $submission->load([
            'service.requirements',
            'documents.requirement',
            'user.desa',
            'kecamatan',
        ]);

        return view('kecamatan.submissions.show', compact('submission'));
    }

    /**
     * Simpan hasil verifikasi berkas dan perbarui status pengajuan.
     */
    public function review(ReviewSubmissionRequest $request, Submission $submission): RedirectResponse
    {
        $this->authorize('review', $submission);

        $this->submissionService->reviewSubmission(
            $submission,
            $request->user(),
            $request->validated()
        );

        $statusLabel = $submission->fresh()->status->label();

        return redirect()
            ->route('kecamatan.submissions.show', $submission)
            ->with('success', "Status permohonan berhasil diperbarui menjadi '{$statusLabel}'.");
    }

    /**
     * Tetapkan jadwal dan nomor antrean biometrik e-KTP.
     */
    public function scheduleBiometric(ScheduleBiometricRequest $request, Submission $submission): RedirectResponse
    {
        $this->authorize('review', $submission);

        $this->submissionService->scheduleBiometric(
            $submission,
            $request->input('jadwal_biometrik'),
            $request->input('nomor_antrean')
        );

        return redirect()
            ->route('kecamatan.submissions.show', $submission)
            ->with('success', 'Jadwal perekaman biometrik e-KTP dan nomor antrean berhasil ditetapkan.');
    }

    /**
     * Selesaikan permohonan dan terbitkan e-dokumen hasil.
     */
    public function complete(CompleteSubmissionRequest $request, Submission $submission): RedirectResponse
    {
        $this->authorize('review', $submission);

        $this->submissionService->completeSubmission(
            $submission,
            $request->file('output_file'),
            $request->input('completion_notes')
        );

        return redirect()
            ->route('kecamatan.submissions.show', $submission)
            ->with('success', "Permohonan {$submission->nomor_tiket} telah berhasil diselesaikan.");
    }

    /**
     * Tolak permohonan dengan alasan jelas.
     */
    public function reject(Request $request, Submission $submission): RedirectResponse
    {
        $this->authorize('review', $submission);

        $request->validate([
            'alasan_penolakan' => ['required', 'string', 'min:10', 'max:2000'],
        ], [
            'alasan_penolakan.required' => 'Alasan penolakan permohonan wajib diisi.',
            'alasan_penolakan.min'      => 'Mohon berikan alasan penolakan yang jelas (minimal 10 karakter).',
        ]);

        $this->submissionService->rejectSubmission(
            $submission,
            $request->input('alasan_penolakan')
        );

        return redirect()
            ->route('kecamatan.submissions.show', $submission)
            ->with('warning', "Permohonan {$submission->nomor_tiket} telah ditolak.");
    }

    /**
     * Cetak dokumen resmi Formulir F-1.01 Biodata Keluarga sesuai format standar Ditjen Dukcapil.
     */
    public function printF101(Submission $submission): View
    {
        $this->authorize('review', $submission);

        $submission->load(['service', 'kecamatan', 'user.desa']);
        $f101 = $submission->form_data['f101'] ?? null;

        return view('submissions.print-f101', compact('submission', 'f101'));
    }
}
