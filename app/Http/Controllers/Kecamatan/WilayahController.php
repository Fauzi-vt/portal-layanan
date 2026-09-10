<?php

namespace App\Http\Controllers\Kecamatan;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class WilayahController extends Controller
{
    /**
     * Tampilkan profil kantor kecamatan dan daftar desa di wilayah kerja ini.
     */
    public function index(Request $request): View
    {
        $kecamatan = auth()->user()->kecamatan;

        if (!$kecamatan) {
            abort(403, 'Akun Anda tidak terikat dengan data wilayah kecamatan manapun.');
        }

        $search = trim($request->get('q', ''));
        $desaQuery = $kecamatan->desas();

        if ($search) {
            $desaQuery->where(function ($q) use ($search) {
                $q->where('nama_desa', 'like', "%{$search}%")
                  ->orWhere('kode_desa', 'like', "%{$search}%");
            });
        }

        $desas = $desaQuery->orderBy('nama_desa')->paginate(15)->withQueryString();

        $stats = [
            'total_desa' => $kecamatan->total_desa,
            'total_rw'   => $kecamatan->total_rw,
            'total_rt'   => $kecamatan->total_rt,
            'total_warga'=> $kecamatan->users()->where('role', \App\Enums\UserRole::Warga)->count(),
        ];

        return view('kecamatan.wilayah.index', compact('kecamatan', 'desas', 'stats', 'search'));
    }

    /**
     * Perbarui Profil & Metadata Kantor Kecamatan.
     */
    public function updateProfil(Request $request): RedirectResponse
    {
        $kecamatan = auth()->user()->kecamatan;

        if (!$kecamatan) {
            abort(403, 'Akun Anda tidak terikat dengan data wilayah kecamatan manapun.');
        }

        $validated = $request->validate([
            'alamat_kantor'  => ['required', 'string'],
            'telepon'        => ['nullable', 'string', 'max:20'],
            'email'          => ['nullable', 'email', 'max:100'],
            'jam_operasional'=> ['nullable', 'string', 'max:100'],
            'jumlah_desa'    => ['nullable', 'integer', 'min:0'],
            'jumlah_rw'      => ['nullable', 'integer', 'min:0'],
            'jumlah_rt'      => ['nullable', 'integer', 'min:0'],
        ]);

        $kecamatan->update($validated);

        return redirect()->route('kecamatan.wilayah.index')
            ->with('success', "Informasi profil dan kewilayahan Kecamatan {$kecamatan->nama_kecamatan} berhasil diperbarui.");
    }

    /**
     * Tambah Desa Baru di bawah Kecamatan ini.
     */
    public function storeDesa(Request $request): RedirectResponse
    {
        $kecamatan = auth()->user()->kecamatan;

        if (!$kecamatan) {
            abort(403, 'Akun Anda tidak terikat dengan data wilayah kecamatan manapun.');
        }

        $validated = $request->validate([
            'kode_desa' => ['required', 'string', 'max:15', 'unique:desas,kode_desa'],
            'nama_desa' => ['required', 'string', 'max:100'],
            'jumlah_rw' => ['nullable', 'integer', 'min:0'],
            'jumlah_rt' => ['nullable', 'integer', 'min:0'],
        ]);

        $validated['kecamatan_id'] = $kecamatan->id;

        $desa = Desa::create($validated);

        return redirect()->route('kecamatan.wilayah.index')
            ->with('success', "Desa {$desa->nama_desa} berhasil ditambahkan ke wilayah Kecamatan {$kecamatan->nama_kecamatan}.");
    }

    /**
     * Perbarui Data Desa di bawah Kecamatan ini.
     */
    public function updateDesa(Request $request, Desa $desa): RedirectResponse
    {
        $kecamatan = auth()->user()->kecamatan;

        if (!$kecamatan || $desa->kecamatan_id !== $kecamatan->id) {
            abort(403, 'Anda tidak memiliki hak akses mengedit desa di luar wilayah kecamatan Anda.');
        }

        $validated = $request->validate([
            'kode_desa' => ['required', 'string', 'max:15', Rule::unique('desas', 'kode_desa')->ignore($desa->id)],
            'nama_desa' => ['required', 'string', 'max:100'],
            'jumlah_rw' => ['nullable', 'integer', 'min:0'],
            'jumlah_rt' => ['nullable', 'integer', 'min:0'],
        ]);

        $desa->update($validated);

        return redirect()->route('kecamatan.wilayah.index')
            ->with('success', "Data Desa {$desa->nama_desa} berhasil diperbarui.");
    }

    /**
     * Hapus Desa.
     */
    public function destroyDesa(Desa $desa): RedirectResponse
    {
        $kecamatan = auth()->user()->kecamatan;

        if (!$kecamatan || $desa->kecamatan_id !== $kecamatan->id) {
            abort(403, 'Anda tidak memiliki hak akses menghapus desa di luar wilayah kecamatan Anda.');
        }

        if ($desa->warga()->exists()) {
            return back()->with('error', "Desa {$desa->nama_desa} tidak dapat dihapus karena masih terdaftar warga aktif di desa ini.");
        }

        $nama = $desa->nama_desa;
        $desa->delete();

        return redirect()->route('kecamatan.wilayah.index')
            ->with('success', "Desa {$nama} berhasil dihapus dari wilayah kecamatan.");
    }
}
