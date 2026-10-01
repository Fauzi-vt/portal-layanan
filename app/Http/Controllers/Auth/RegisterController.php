<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\Kecamatan;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function showRegistrationForm(Request $request): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        $intendedService = null;

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

        return view('auth.register', compact('intendedService'));
    }

    public function register(Request $request): RedirectResponse
    {
        $request->validate([
            'nama_depan'            => ['required', 'string', 'max:100'],
            'nama_belakang'         => ['nullable', 'string', 'max:100'],
            'email'                 => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password'              => ['required', 'string', 'min:6'],
            'password_confirmation' => ['required', 'same:password'],
        ], [
            'nama_depan.required'            => 'Nama depan wajib diisi.',
            'email.required'                 => 'Alamat email wajib diisi.',
            'email.unique'                   => 'Email ini sudah terdaftar di sistem.',
            'password.required'              => 'Password wajib diisi.',
            'password.min'                   => 'Password minimal 6 karakter.',
            'password_confirmation.same'     => 'Konfirmasi password tidak cocok dengan password.',
        ]);

        $fullName = trim($request->input('nama_depan') . ' ' . $request->input('nama_belakang'));

        // Default kecamatan ke Manonjaya atau yang pertama
        $defaultKecamatan = Kecamatan::where('kode_kecamatan', 'KEC-017')->first() ?? Kecamatan::first();

        $user = User::create([
            'name'         => $fullName,
            'email'        => $request->input('email'),
            'password'     => Hash::make($request->input('password')),
            'role'         => UserRole::Warga,
            'kecamatan_id' => $defaultKecamatan?->id,
        ]);

        Auth::login($user);

        return redirect()->intended(route('warga.dashboard'))->with('success', 'Akun Anda berhasil dibuat. Selamat datang di Portal Layanan Publik!');
    }
}
