<?php

namespace App\Http\Controllers\Desa;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class WilayahController extends Controller
{
    /**
     * Tampilkan profil dan data kewilayahan desa saat ini.
     */
    public function index(): View
    {
        $desa = auth()->user()->desa;

        if (!$desa) {
            abort(403, 'Akun Anda tidak terikat dengan wilayah desa manapun.');
        }

        $stats = [
            'total_rw'    => $desa->jumlah_rw ?? 0,
            'total_rt'    => $desa->jumlah_rt ?? 0,
            'total_warga' => $desa->warga()->count(),
        ];

        return view('desa.wilayah.index', compact('desa', 'stats'));
    }

    /**
     * Perbarui data kewilayahan desa (Jumlah RW, RT, dan identitas).
     */
    public function update(Request $request): RedirectResponse
    {
        $desa = auth()->user()->desa;

        if (!$desa) {
            abort(403, 'Akun Anda tidak terikat dengan wilayah desa manapun.');
        }

        $validated = $request->validate([
            'kode_desa' => ['required', 'string', 'max:15', Rule::unique('desas', 'kode_desa')->ignore($desa->id)],
            'nama_desa' => ['required', 'string', 'max:100'],
            'jumlah_rw' => ['required', 'integer', 'min:0'],
            'jumlah_rt' => ['required', 'integer', 'min:0'],
        ]);

        $desa->update($validated);

        return redirect()->route('desa.wilayah.index')
            ->with('success', "Data kewilayahan Desa {$desa->nama_desa} berhasil diperbarui.");
    }
}
