<?php

namespace App\Http\Controllers\Kecamatan;

use App\Enums\SubmissionStatus;
use App\Http\Controllers\Controller;
use App\Models\Submission;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $admin = $request->user()->load('kecamatan');
        $kecamatanId = $admin->kecamatan_id;

        // Statistik ringkasan wilayah kecamatan
        $stats = [
            'total'             => Submission::forKecamatan($kecamatanId)->count(),
            'needs_action'      => Submission::forKecamatan($kecamatanId)->whereIn('status', [
                SubmissionStatus::Submitted,
                SubmissionStatus::InReview,
            ])->count(),
            'revision_required' => Submission::forKecamatan($kecamatanId)->where('status', SubmissionStatus::RevisionRequired)->count(),
            'processed'         => Submission::forKecamatan($kecamatanId)->where('status', SubmissionStatus::Processed)->count(),
            'completed_today'   => Submission::forKecamatan($kecamatanId)
                ->where('status', SubmissionStatus::Completed)
                ->whereDate('updated_at', Carbon::today())
                ->count(),
        ];

        // Pengajuan mendesak yang butuh verifikasi (Submitted & In Review)
        $pendingSubmissions = Submission::forKecamatan($kecamatanId)
            ->with(['service', 'user.desa'])
            ->whereIn('status', [SubmissionStatus::Submitted, SubmissionStatus::InReview])
            ->latest()
            ->take(8)
            ->get();

        // Jadwal biometrik e-KTP hari ini
        $todayBiometrics = Submission::forKecamatan($kecamatanId)
            ->with(['user', 'service'])
            ->whereNotNull('jadwal_biometrik')
            ->whereDate('jadwal_biometrik', Carbon::today())
            ->orderBy('jadwal_biometrik')
            ->get();

        return view('kecamatan.dashboard', compact('admin', 'stats', 'pendingSubmissions', 'todayBiometrics'));
    }
}
