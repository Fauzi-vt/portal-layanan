<?php

namespace App\Http\Controllers\Desa;

use App\Enums\SubmissionStatus;
use App\Http\Controllers\Controller;
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
     * Tampilkan daftar pengajuan permohonan warga di wilayah desa admin.
     * Menerapkan Scope Isolasi Multi-Tenant berdasarkan user->desa_id.
     */
    public function index(Request $request): View
    {
        $admin = $request->user();
        $status = $request->query('status');
        $serviceId = $request->query('service_id');
        $search = $request->query('search');

        $submissions = Submission::forDesa($admin->desa_id)
            ->with(['service', 'user'])
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

        // Counter tabs
        $counts = [
            'total'             => Submission::forDesa($admin->desa_id)->count(),
            'needs_action'      => Submission::forDesa($admin->desa_id)->where('status', SubmissionStatus::SubmittedDesa)->count(),
            'forwarded'         => Submission::forDesa($admin->desa_id)->whereIn('status', [
                SubmissionStatus::Submitted,
                SubmissionStatus::InReview,
                SubmissionStatus::Processed,
            ])->count(),
            'revision_required' => Submission::forDesa($admin->desa_id)->where('status', SubmissionStatus::RevisionRequired)->count(),
            'completed'         => Submission::forDesa($admin->desa_id)->where('status', SubmissionStatus::Completed)->count(),
        ];

        return view('desa.submissions.index', compact('submissions', 'services', 'counts', 'status', 'serviceId', 'search'));
    }

    /**
     * Meja verifikasi berkas permohonan di tingkat desa.
     */
    public function show(Submission $submission, Request $request): View
    {
        $this->authorize('view', $submission);

        $submission->load([
            'service.requirements',
            'documents.requirement',
            'user.desa',
            'user.kecamatan',
            'verifiedByDesa',
            'histories.user',
        ]);

        return view('desa.submissions.show', compact('submission'));
    }

    /**
     * Proses hasil verifikasi Kasi Pelayanan Desa.
     */
    public function verify(Submission $submission, Request $request): RedirectResponse
    {
        $this->authorize('review', $submission);

        $validated = $request->validate([
            'action'  => ['required', 'in:approve,revision,reject'],
            'catatan' => ['nullable', 'string', 'max:1000'],
        ], [
            'action.required' => 'Pilihan aksi verifikasi wajib ditentukan.',
            'action.in'       => 'Pilihan aksi verifikasi tidak valid.',
        ]);

        $this->submissionService->verifyByDesa(
            $submission,
            $request->user(),
            $validated['action'],
            $validated['catatan'] ?? null
        );

        $messages = [
            'approve'  => "Permohonan {$submission->nomor_tiket} berhasil disetujui & diteruskan ke antrean Kecamatan.",
            'revision' => "Permohonan {$submission->nomor_tiket} telah dikembalikan ke warga dengan instruksi perbaikan.",
            'reject'   => "Permohonan {$submission->nomor_tiket} telah ditolak.",
        ];

        return redirect()
            ->route('desa.submissions.index')
            ->with('success', $messages[$validated['action']] ?? 'Verifikasi berhasil disimpan.');
    }

    /**
     * Cetak dokumen fisik Formulir F-1.15 resmi.
     */
    public function printF101(Submission $submission): View
    {
        $this->authorize('view', $submission);

        $submission->load(['user.desa', 'user.kecamatan', 'service', 'kecamatan', 'desa']);
        $f101 = $submission->form_data['f101'] ?? null;

        return view('submissions.print-f101', compact('submission', 'f101'));
    }
}
