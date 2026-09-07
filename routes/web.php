<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Desa\DashboardController as DesaDashboardController;
use App\Http\Controllers\Desa\SubmissionController as DesaSubmissionController;
use App\Http\Controllers\Kecamatan\DashboardController as KecamatanDashboardController;
use App\Http\Controllers\Kecamatan\SubmissionController as KecamatanSubmissionController;
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboardController;
use App\Http\Controllers\SuperAdmin\ServiceController as SuperAdminServiceController;
use App\Http\Controllers\Warga\DashboardController as WargaDashboardController;
use App\Http\Controllers\Warga\SubmissionController as WargaSubmissionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Portal Layanan Publik Terintegrasi Kab. Tasikmalaya
|--------------------------------------------------------------------------
*/

// ── Halaman Utama (Landing Page) ──────────────────────────────────────────────
Route::get('/', function () {
    $services = \Illuminate\Support\Facades\Schema::hasTable('services')
        ? \App\Models\Service::where('is_active', true)->orderBy('urutan')->get()
        : collect();

    return view('welcome', compact('services'));
});

use App\Http\Controllers\Auth\RegisterController;

// ── Auth Routes ───────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ── Protected Routes (Auth Required) ──────────────────────────────────────────
Route::middleware('auth')->group(function () {

    // Gateway /dashboard — mendistribusikan user ke workspace role-nya masing-masing
    Route::get('/dashboard', function () {
        return match (auth()->user()->role) {
            \App\Enums\UserRole::SuperAdmin      => redirect()->route('superadmin.dashboard'),
            \App\Enums\UserRole::AdminKecamatan  => redirect()->route('kecamatan.dashboard'),
            \App\Enums\UserRole::AdminDesa       => redirect()->route('desa.dashboard'),
            default                              => redirect()->route('warga.dashboard'),
        };
    })->name('dashboard');

    // ── Akses Dokumen Berkas Aman (Policy & Tenant Protected) ─────────────────
    Route::get('/dokumen/{document}/lihat', [\App\Http\Controllers\DocumentController::class, 'show'])->name('documents.show');
    Route::get('/dokumen/{document}/unduh', [\App\Http\Controllers\DocumentController::class, 'download'])->name('documents.download');

    // ─────────────────────────────────────────────────────────────────────────
    // 1. WORKSPACE: WARGA / MASYARAKAT
    // ─────────────────────────────────────────────────────────────────────────
    Route::middleware('role:warga')
        ->prefix('warga')
        ->name('warga.')
        ->group(function () {
            // Dashboard Warga
            Route::get('/dashboard', [WargaDashboardController::class, 'index'])->name('dashboard');

            // Pengajuan Layanan (Submissions)
            Route::get('/permohonan', [WargaSubmissionController::class, 'index'])->name('submissions.index');
            Route::get('/permohonan/buat', [WargaSubmissionController::class, 'create'])->name('submissions.create');
            Route::post('/permohonan', [WargaSubmissionController::class, 'store'])->name('submissions.store');
            Route::get('/permohonan/{submission}', [WargaSubmissionController::class, 'show'])->name('submissions.show');
            Route::post('/permohonan/{submission}/kirim-draft', [WargaSubmissionController::class, 'submitDraft'])->name('submissions.submit-draft');
            Route::post('/permohonan/{submission}/revisi', [WargaSubmissionController::class, 'updateRevision'])->name('submissions.update-revision');
            Route::get('/permohonan/{submission}/unduh-hasil', [WargaSubmissionController::class, 'downloadOutput'])->name('submissions.download-output');
            Route::get('/permohonan/{submission}/cetak-f101', [WargaSubmissionController::class, 'printF101'])->name('submissions.print-f101');

            // Profil Saya (User Profile)
            Route::get('/profil', [\App\Http\Controllers\Warga\ProfileController::class, 'edit'])->name('profile.edit');
            Route::put('/profil', [\App\Http\Controllers\Warga\ProfileController::class, 'update'])->name('profile.update');
            Route::put('/profil/password', [\App\Http\Controllers\Warga\ProfileController::class, 'updatePassword'])->name('profile.password');
            Route::get('/desas/{kecamatan}', function (\App\Models\Kecamatan $kecamatan) {
                return response()->json($kecamatan->desas()->orderBy('nama_desa')->get(['id', 'nama_desa']));
            })->name('desas.by-kecamatan');
        });

    // ─────────────────────────────────────────────────────────────────────────
    // 2. WORKSPACE: KASI PELAYANAN (ADMIN DESA)
    // ─────────────────────────────────────────────────────────────────────────
    Route::middleware('role:admin_desa')
        ->prefix('desa')
        ->name('desa.')
        ->group(function () {
            // Dashboard Desa
            Route::get('/dashboard', [DesaDashboardController::class, 'index'])->name('dashboard');

            // Pengajuan Masuk Desa
            Route::get('/verifikasi', [DesaSubmissionController::class, 'index'])->name('submissions.index');
            Route::get('/verifikasi/{submission}', [DesaSubmissionController::class, 'show'])->name('submissions.show');
            Route::get('/verifikasi/{submission}/cetak-f101', [DesaSubmissionController::class, 'printF101'])->name('submissions.print-f101');
            Route::post('/verifikasi/{submission}/verifikasi', [DesaSubmissionController::class, 'verify'])->name('submissions.verify');
        });

    // ─────────────────────────────────────────────────────────────────────────
    // 3. WORKSPACE: ADMIN KECAMATAN (39 KECAMATAN SCOPED)
    // ─────────────────────────────────────────────────────────────────────────
    Route::middleware('role:admin_kecamatan')
        ->prefix('kecamatan')
        ->name('kecamatan.')
        ->group(function () {
            // Dashboard Kecamatan
            Route::get('/dashboard', [KecamatanDashboardController::class, 'index'])->name('dashboard');

            // Verifikasi & Pengelolaan Pengajuan Warga di Wilayahnya
            Route::get('/verifikasi', [KecamatanSubmissionController::class, 'index'])->name('submissions.index');
            Route::get('/verifikasi/{submission}', [KecamatanSubmissionController::class, 'show'])->name('submissions.show');
            Route::get('/verifikasi/{submission}/cetak-f101', [KecamatanSubmissionController::class, 'printF101'])->name('submissions.print-f101');
            Route::post('/verifikasi/{submission}/tinjau', [KecamatanSubmissionController::class, 'review'])->name('submissions.review');
            Route::post('/verifikasi/{submission}/jadwal-biometrik', [KecamatanSubmissionController::class, 'scheduleBiometric'])->name('submissions.schedule-biometric');
            Route::post('/verifikasi/{submission}/selesaikan', [KecamatanSubmissionController::class, 'complete'])->name('submissions.complete');
            Route::post('/verifikasi/{submission}/tolak', [KecamatanSubmissionController::class, 'reject'])->name('submissions.reject');
        });

    // ─────────────────────────────────────────────────────────────────────────
    // 3. WORKSPACE: SUPER ADMIN (DISKOMINFO / KABUPATEN TASIKMALAYA)
    // ─────────────────────────────────────────────────────────────────────────
    Route::middleware('role:super_admin')
        ->prefix('superadmin')
        ->name('superadmin.')
        ->group(function () {
            // Dashboard Global Analytics
            Route::get('/dashboard', [SuperAdminDashboardController::class, 'index'])->name('dashboard');

            // Manajemen Master Layanan & Persyaratan Dokumen
            Route::get('/layanan', [SuperAdminServiceController::class, 'index'])->name('services.index');
            Route::get('/layanan/{service}/edit', [SuperAdminServiceController::class, 'edit'])->name('services.edit');
            Route::put('/layanan/{service}', [SuperAdminServiceController::class, 'update'])->name('services.update');
            Route::patch('/layanan/{service}/toggle', [SuperAdminServiceController::class, 'toggle'])->name('services.toggle');

            // Manajemen Persyaratan Dokumen Layanan
            Route::post('/layanan/{service}/persyaratan', [SuperAdminServiceController::class, 'storeRequirement'])->name('services.requirements.store');
            Route::put('/layanan/{service}/persyaratan/{requirement}', [SuperAdminServiceController::class, 'updateRequirement'])->name('services.requirements.update');
            Route::delete('/layanan/{service}/persyaratan/{requirement}', [SuperAdminServiceController::class, 'destroyRequirement'])->name('services.requirements.destroy');
        });
});
