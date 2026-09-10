<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use App\Models\Kecamatan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class WilayahController extends Controller
{
    /**
     * Tampilkan data master wilayah (39 Kecamatan & seluruh Desa se-Kabupaten Tasikmalaya).
     */
    public function index(Request $request): View
    {
        $search = trim($request->get('q', ''));
        $tab = $request->get('tab', 'kecamatan');
        $selectedKecamatanId = $request->get('kecamatan_id');

        $kecamatanQuery = Kecamatan::withCount('desas');
        if ($search && $tab === 'kecamatan') {
            $kecamatanQuery->where(function ($q) use ($search) {
                $q->where('nama_kecamatan', 'like', "%{$search}%")
                  ->orWhere('kode_kecamatan', 'like', "%{$search}%");
            });
        }
        $kecamatans = $kecamatanQuery->orderBy('nama_kecamatan')->paginate(15)->withQueryString();

        $allKecamatans = Kecamatan::orderBy('nama_kecamatan')->get(['id', 'nama_kecamatan', 'kode_kecamatan']);

        $desaQuery = Desa::with('kecamatan');
        if ($selectedKecamatanId) {
            $desaQuery->where('kecamatan_id', $selectedKecamatanId);
        }
        if ($search && $tab === 'desa') {
            $desaQuery->where(function ($q) use ($search) {
                $q->where('nama_desa', 'like', "%{$search}%")
                  ->orWhere('kode_desa', 'like', "%{$search}%")
                  ->orWhereHas('kecamatan', function ($kq) use ($search) {
                      $kq->where('nama_kecamatan', 'like', "%{$search}%");
                  });
            });
        }
        $desas = $desaQuery->orderBy('nama_desa')->paginate(20)->withQueryString();

        // Statistik Agregat
        $stats = [
            'total_kecamatan' => Kecamatan::count(),
            'total_desa'      => Desa::count(),
            'total_rw'        => Kecamatan::all()->sum->total_rw,
            'total_rt'        => Kecamatan::all()->sum->total_rt,
        ];

        return view('superadmin.wilayah.index', compact('kecamatans', 'desas', 'allKecamatans', 'stats', 'search', 'tab', 'selectedKecamatanId'));
    }

    /**
     * Tambah Kecamatan Baru.
     */
    public function storeKecamatan(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kode_kecamatan' => ['required', 'string', 'max:10', 'unique:kecamatans,kode_kecamatan'],
            'nama_kecamatan' => ['required', 'string', 'max:100'],
            'alamat_kantor'  => ['nullable', 'string'],
            'telepon'        => ['nullable', 'string', 'max:20'],
            'email'          => ['nullable', 'email', 'max:100'],
            'jam_operasional'=> ['nullable', 'string', 'max:100'],
            'jumlah_desa'    => ['nullable', 'integer', 'min:0'],
            'jumlah_rw'      => ['nullable', 'integer', 'min:0'],
            'jumlah_rt'      => ['nullable', 'integer', 'min:0'],
        ]);

        Kecamatan::create($validated);

        return redirect()->route('superadmin.wilayah.index', ['tab' => 'kecamatan'])
            ->with('success', "Kecamatan {$validated['nama_kecamatan']} berhasil ditambahkan ke database.");
    }

    /**
     * Perbarui Data Kecamatan.
     */
    public function updateKecamatan(Request $request, Kecamatan $kecamatan): RedirectResponse
    {
        $validated = $request->validate([
            'kode_kecamatan' => ['required', 'string', 'max:10', Rule::unique('kecamatans', 'kode_kecamatan')->ignore($kecamatan->id)],
            'nama_kecamatan' => ['required', 'string', 'max:100'],
            'alamat_kantor'  => ['nullable', 'string'],
            'telepon'        => ['nullable', 'string', 'max:20'],
            'email'          => ['nullable', 'email', 'max:100'],
            'jam_operasional'=> ['nullable', 'string', 'max:100'],
            'jumlah_desa'    => ['nullable', 'integer', 'min:0'],
            'jumlah_rw'      => ['nullable', 'integer', 'min:0'],
            'jumlah_rt'      => ['nullable', 'integer', 'min:0'],
        ]);

        $kecamatan->update($validated);

        return redirect()->route('superadmin.wilayah.index', ['tab' => 'kecamatan'])
            ->with('success', "Data Kecamatan {$kecamatan->nama_kecamatan} berhasil diperbarui.");
    }

    /**
     * Hapus Kecamatan.
     */
    public function destroyKecamatan(Kecamatan $kecamatan): RedirectResponse
    {
        if ($kecamatan->submissions()->exists()) {
            return back()->with('error', "Kecamatan {$kecamatan->nama_kecamatan} tidak dapat dihapus karena memiliki riwayat permohonan warga.");
        }

        $nama = $kecamatan->nama_kecamatan;
        $kecamatan->delete();

        return redirect()->route('superadmin.wilayah.index', ['tab' => 'kecamatan'])
            ->with('success', "Kecamatan {$nama} berhasil dihapus.");
    }

    /**
     * Tambah Desa Baru.
     */
    public function storeDesa(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kecamatan_id' => ['required', 'exists:kecamatans,id'],
            'kode_desa'    => ['required', 'string', 'max:15', 'unique:desas,kode_desa'],
            'nama_desa'    => ['required', 'string', 'max:100'],
            'jumlah_rw'    => ['nullable', 'integer', 'min:0'],
            'jumlah_rt'    => ['nullable', 'integer', 'min:0'],
        ]);

        $desa = Desa::create($validated);

        return redirect()->route('superadmin.wilayah.index', ['tab' => 'desa', 'kecamatan_id' => $desa->kecamatan_id])
            ->with('success', "Desa {$desa->nama_desa} berhasil ditambahkan.");
    }

    /**
     * Perbarui Data Desa.
     */
    public function updateDesa(Request $request, Desa $desa): RedirectResponse
    {
        $validated = $request->validate([
            'kecamatan_id' => ['required', 'exists:kecamatans,id'],
            'kode_desa'    => ['required', 'string', 'max:15', Rule::unique('desas', 'kode_desa')->ignore($desa->id)],
            'nama_desa'    => ['required', 'string', 'max:100'],
            'jumlah_rw'    => ['nullable', 'integer', 'min:0'],
            'jumlah_rt'    => ['nullable', 'integer', 'min:0'],
        ]);

        $desa->update($validated);

        return redirect()->route('superadmin.wilayah.index', ['tab' => 'desa', 'kecamatan_id' => $desa->kecamatan_id])
            ->with('success', "Data Desa {$desa->nama_desa} berhasil diperbarui.");
    }

    /**
     * Hapus Desa.
     */
    public function destroyDesa(Desa $desa): RedirectResponse
    {
        if ($desa->warga()->exists()) {
            return back()->with('error', "Desa {$desa->nama_desa} tidak dapat dihapus karena masih terdaftar warga aktif di desa ini.");
        }

        $nama = $desa->nama_desa;
        $kecId = $desa->kecamatan_id;
        $desa->delete();

        return redirect()->route('superadmin.wilayah.index', ['tab' => 'desa', 'kecamatan_id' => $kecId])
            ->with('success', "Desa {$nama} berhasil dihapus.");
    }
}
