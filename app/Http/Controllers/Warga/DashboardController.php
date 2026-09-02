<?php

namespace App\Http\Controllers\Warga;

use App\Enums\SubmissionStatus;
use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user()->load(['kecamatan', 'desa']);

        // Data statistik pengajuan milik warga
        $stats = [
            'total'             => $user->submissions()->count(),
            'active'            => $user->submissions()->whereIn('status', [
                SubmissionStatus::Submitted,
                SubmissionStatus::InReview,
                SubmissionStatus::Processed,
            ])->count(),
            'revision_required' => $user->submissions()->where('status', SubmissionStatus::RevisionRequired)->count(),
            'completed'         => $user->submissions()->where('status', SubmissionStatus::Completed)->count(),
        ];

        // 5 Pengajuan terbaru
        $recentSubmissions = $user->submissions()
            ->with(['service', 'kecamatan'])
            ->latest()
            ->take(5)
            ->get();

        // 8 Layanan Utama untuk shortcut
        $services = Service::where('is_active', true)
            ->orderBy('urutan')
            ->get();

        return view('warga.dashboard', compact('user', 'stats', 'recentSubmissions', 'services'));
    }
}
