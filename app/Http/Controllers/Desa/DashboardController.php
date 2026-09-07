<?php

namespace App\Http\Controllers\Desa;

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
        $admin = $request->user()->load(['desa', 'kecamatan']);
        $desaId = $admin->desa_id;

        // Statistik pengajuan untuk wilayah desa ini
        $stats = [
            'total'             => Submission::forDesa($desaId)->count(),
            'needs_action'      => Submission::forDesa($desaId)
                ->where('status', SubmissionStatus::SubmittedDesa)
                ->count(),
            'forwarded'         => Submission::forDesa($desaId)
                ->whereNotNull('verified_desa_at')
                ->count(),
            'revision_required' => Submission::forDesa($desaId)
                ->where('status', SubmissionStatus::RevisionRequired)
                ->count(),
            'completed'         => Submission::forDesa($desaId)
                ->where('status', SubmissionStatus::Completed)
                ->count(),
        ];

        // Daftar permohonan yang mendesak butuh tindakan verifikasi desa
        $pendingSubmissions = Submission::forDesa($desaId)
            ->with(['service', 'user'])
            ->where('status', SubmissionStatus::SubmittedDesa)
            ->latest()
            ->take(8)
            ->get();

        // Riwayat permohonan yang baru saja diverifikasi oleh pihak desa
        $recentVerified = Submission::forDesa($desaId)
            ->with(['service', 'user'])
            ->whereNotNull('verified_desa_at')
            ->latest('verified_desa_at')
            ->take(5)
            ->get();

        return view('desa.dashboard', compact('admin', 'stats', 'pendingSubmissions', 'recentVerified'));
    }
}
