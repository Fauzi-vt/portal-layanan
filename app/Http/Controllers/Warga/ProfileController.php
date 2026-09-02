<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Kecamatan;
use App\Models\Desa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profil pengguna.
     */
    public function edit(Request $request): View
    {
        $user = $request->user()->load(['kecamatan', 'desa']);
        $kecamatans = Kecamatan::orderBy('nama_kecamatan')->get();
        $desas = $user->kecamatan_id 
            ? Desa::where('kecamatan_id', $user->kecamatan_id)->orderBy('nama_desa')->get()
            : collect();

        return view('warga.profile', compact('user', 'kecamatans', 'desas'));
    }

    /**
     * Perbarui data profil pengguna.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone'         => ['nullable', 'string', 'max:20'],
            'kecamatan_id'  => ['nullable', 'exists:kecamatans,id'],
            'desa_id'       => ['nullable', 'exists:desas,id'],
            'alamat_detail' => ['nullable', 'string', 'max:500'],
        ], [
            'name.required'     => 'Nama lengkap wajib diisi.',
            'email.required'    => 'Alamat email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'email.unique'      => 'Email ini sudah digunakan oleh akun lain.',
            'kecamatan_id.exists' => 'Kecamatan yang dipilih tidak valid.',
            'desa_id.exists'    => 'Desa yang dipilih tidak valid.',
        ]);

        $user->update($validated);

        return redirect()->route('warga.profile.edit')
            ->with('success', 'Profil Anda berhasil diperbarui.');
    }

    /**
     * Perbarui kata sandi pengguna.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'confirmed', Password::min(8)],
        ], [
            'current_password.required'         => 'Kata sandi saat ini wajib diisi.',
            'current_password.current_password' => 'Kata sandi saat ini tidak sesuai.',
            'password.required'                 => 'Kata sandi baru wajib diisi.',
            'password.confirmed'                => 'Konfirmasi kata sandi baru tidak cocok.',
            'password.min'                      => 'Kata sandi baru minimal 8 karakter.',
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('warga.profile.edit')
            ->with('success', 'Kata sandi berhasil diubah.');
    }
}
