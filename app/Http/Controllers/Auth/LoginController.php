<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     * Tampilkan form login.
     */
    public function showLoginForm(Request $request): View|RedirectResponse
    {
        if (Auth::check()) {
            return $this->redirectByRole();
        }

        $intendedService = null;

        // Deteksi konteks layanan publik yang sedang ingin diajukan
        if ($request->has('service')) {
            $serviceCode = $request->query('service');
            $intendedService = \App\Models\Service::where('kode_layanan', $serviceCode)
                ->where('is_active', true)
                ->first();

            if ($intendedService) {
                session()->put('url.intended', route('warga.submissions.create', ['service' => $intendedService->kode_layanan]));
            }
        } elseif (session()->has('url.intended')) {
            $intendedUrl = session('url.intended');
            $parsed = parse_url($intendedUrl);
            if (isset($parsed['query'])) {
                parse_str($parsed['query'], $queryParams);
                if (!empty($queryParams['service'])) {
                    $intendedService = \App\Models\Service::where('kode_layanan', $queryParams['service'])
                        ->where('is_active', true)
                        ->first();
                }
            }
        }

        return view('auth.login', compact('intendedService'));
    }

    /**
     * Proses login (Mendukung Login via Email ataupun 16 Digit NIK).
     */
    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'login'    => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'login.required'    => 'Alamat Email atau NIK 16 digit wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $loginInput = trim($request->input('login'));
        $password = $request->input('password');
        $remember = $request->boolean('remember');

        // Tentukan apakah user memasukkan Email atau NIK
        $fieldType = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'nik';

        $credentials = [
            $fieldType => $loginInput,
            'password' => $password,
        ];

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return $this->redirectByRole();
        }

        return back()
            ->withInput($request->only('login', 'remember'))
            ->withErrors([
                'login' => 'Kombinasi Email/NIK atau password yang Anda masukkan tidak sesuai.',
            ]);
    }

    /**
     * Logout.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar dari sistem.');
    }

    /**
     * Redirect ke dashboard berdasarkan role.
     */
    private function redirectByRole(): RedirectResponse
    {
        $user = Auth::user();

        return match ($user->role) {
            UserRole::SuperAdmin      => redirect()->route('superadmin.dashboard'),
            UserRole::AdminKecamatan  => redirect()->route('kecamatan.dashboard'),
            UserRole::AdminDesa       => redirect()->route('desa.dashboard'),
            default                   => redirect()->intended(route('warga.dashboard')),
        };
    }
}
