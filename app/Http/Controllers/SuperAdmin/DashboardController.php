<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Enums\SubmissionStatus;
use App\Http\Controllers\Controller;
use App\Models\Kecamatan;
use App\Models\Service;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        // Metrik global 39 Kecamatan di Kabupaten Tasikmalaya
        $stats = [
            'total_kecamatans'   => Kecamatan::count(),
            'total_services'     => Service::count(),
            'total_citizens'     => User::where('role', \App\Enums\UserRole::Warga)->count(),
            'total_submissions'  => Submission::count(),
            'completed_all'      => Submission::where('status', SubmissionStatus::Completed)->count(),
            'in_progress'        => Submission::whereIn('status', [
                SubmissionStatus::Submitted,
                SubmissionStatus::InReview,
                SubmissionStatus::Processed,
            ])->count(),
        ];

        // 10 Pengajuan terbaru se-Kabupaten
        $recentSubmissions = Submission::with(['service', 'kecamatan', 'user'])
            ->latest()
            ->take(10)
            ->get();

        // Top 5 Kecamatan dengan permohonan terbanyak
        $topKecamatans = Kecamatan::withCount('submissions')
            ->orderByDesc('submissions_count')
            ->take(5)
            ->get();

        // Distribusi Pengajuan per Jenis Layanan
        $servicesBreakdown = Service::withCount('submissions')
            ->orderByDesc('submissions_count')
            ->get();

        return view('superadmin.dashboard', compact('stats', 'recentSubmissions', 'topKecamatans', 'servicesBreakdown'));
    }
}
