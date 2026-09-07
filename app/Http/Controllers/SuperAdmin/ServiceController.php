<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Enums\ServiceProcessType;
use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceRequirement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ServiceController extends Controller
{
    /**
     * Tampilkan katalog seluruh master layanan publik.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $status = $request->query('status');

        $services = Service::query()
            ->withCount(['requirements', 'submissions'])
            ->when($search, function ($q) use ($search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('nama_layanan', 'ilike', "%{$search}%")
                        ->orWhere('kode_layanan', 'ilike', "%{$search}%")
                        ->orWhere('deskripsi', 'ilike', "%{$search}%");
                });
            })
            ->when($status !== null && $status !== '', function ($q) use ($status) {
                $q->where('is_active', $status === '1');
            })
            ->orderBy('urutan', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        return view('superadmin.services.index', compact('services', 'search', 'status'));
    }

    /**
     * Form edit master layanan dan manajemen persyaratannya.
     */
    public function edit(Service $service): View
    {
        $service->load([
            'requirements' => function ($q) {
                $q->orderBy('urutan', 'asc')->withCount('submissionDocuments');
            }
        ]);

        return view('superadmin.services.edit', compact('service'));
    }

    /**
     * Perbarui data master layanan.
     */
    public function update(Request $request, Service $service): RedirectResponse
    {
        $validated = $request->validate([
            'nama_layanan'           => ['required', 'string', 'max:255'],
            'deskripsi'              => ['required', 'string'],
            'jenis_proses'           => ['required', Rule::enum(ServiceProcessType::class)],
            'requires_desa_approval' => ['nullable', 'boolean'],
            'is_active'              => ['nullable', 'boolean'],
            'urutan'                 => ['required', 'integer', 'min:0'],
        ]);

        $service->update([
            'nama_layanan'           => $validated['nama_layanan'],
            'deskripsi'              => $validated['deskripsi'],
            'jenis_proses'           => $validated['jenis_proses'],
            'requires_desa_approval' => $request->boolean('requires_desa_approval'),
            'is_active'              => $request->boolean('is_active'),
            'urutan'                 => $validated['urutan'],
        ]);

        return redirect()
            ->route('superadmin.services.edit', $service)
            ->with('success', "Konfigurasi layanan '{$service->nama_layanan}' berhasil diperbarui.");
    }

    /**
     * Aktifkan / Nonaktifkan layanan secara cepat.
     */
    public function toggle(Service $service): RedirectResponse
    {
        $service->update([
            'is_active' => !$service->is_active,
        ]);

        $statusStr = $service->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Layanan '{$service->nama_layanan}' berhasil {$statusStr}.");
    }

    /**
     * Tambah persyaratan dokumen baru untuk layanan ini.
     */
    public function storeRequirement(Request $request, Service $service): RedirectResponse
    {
        $validated = $request->validate([
            'nama_persyaratan' => ['required', 'string', 'max:255'],
            'deskripsi'        => ['nullable', 'string', 'max:1000'],
            'is_required'      => ['nullable', 'boolean'],
            'urutan'           => ['required', 'integer', 'min:0'],
            'accepted_formats' => ['required', 'array', 'min:1'],
            'accepted_formats.*' => ['string', 'in:pdf,jpg,jpeg,png'],
            'max_size_kb'      => ['required', 'integer', 'min:100', 'max:20480'],
        ]);

        $service->requirements()->create([
            'nama_persyaratan' => $validated['nama_persyaratan'],
            'deskripsi'        => $validated['deskripsi'] ?? null,
            'is_required'      => $request->boolean('is_required'),
            'urutan'           => $validated['urutan'],
            'accepted_formats' => $validated['accepted_formats'],
            'max_size_kb'      => $validated['max_size_kb'],
        ]);

        return back()->with('success', "Persyaratan dokumen '{$validated['nama_persyaratan']}' berhasil ditambahkan.");
    }

    /**
     * Update persyaratan dokumen yang sudah ada.
     */
    public function updateRequirement(Request $request, Service $service, ServiceRequirement $requirement): RedirectResponse
    {
        abort_if($requirement->service_id !== $service->id, 404);

        $validated = $request->validate([
            'nama_persyaratan' => ['required', 'string', 'max:255'],
            'deskripsi'        => ['nullable', 'string', 'max:1000'],
            'is_required'      => ['nullable', 'boolean'],
            'urutan'           => ['required', 'integer', 'min:0'],
            'accepted_formats' => ['required', 'array', 'min:1'],
            'accepted_formats.*' => ['string', 'in:pdf,jpg,jpeg,png'],
            'max_size_kb'      => ['required', 'integer', 'min:100', 'max:20480'],
        ]);

        $requirement->update([
            'nama_persyaratan' => $validated['nama_persyaratan'],
            'deskripsi'        => $validated['deskripsi'] ?? null,
            'is_required'      => $request->boolean('is_required'),
            'urutan'           => $validated['urutan'],
            'accepted_formats' => $validated['accepted_formats'],
            'max_size_kb'      => $validated['max_size_kb'],
        ]);

        return back()->with('success', "Persyaratan dokumen '{$requirement->nama_persyaratan}' berhasil diperbarui.");
    }

    /**
     * Hapus persyaratan dokumen.
     */
    public function destroyRequirement(Service $service, ServiceRequirement $requirement): RedirectResponse
    {
        abort_if($requirement->service_id !== $service->id, 404);

        if ($requirement->submissionDocuments()->exists()) {
            return back()->with('error', "Persyaratan '{$requirement->nama_persyaratan}' tidak dapat dihapus karena sudah ada berkas pengajuan warga yang merujuknya. Anda dapat menonaktifkan sifat wajibnya (is_required = false) jika tidak diperlukan lagi.");
        }

        $nama = $requirement->nama_persyaratan;
        $requirement->delete();

        return back()->with('success', "Persyaratan dokumen '{$nama}' berhasil dihapus.");
    }
}
