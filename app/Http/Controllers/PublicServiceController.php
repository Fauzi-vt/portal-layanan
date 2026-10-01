<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PublicServiceController extends Controller
{
    /**
     * Tampilkan katalog layanan publik atau alihkan ke section layanan pada beranda.
     */
    public function index(): RedirectResponse
    {
        return redirect()->to(url('/#layanan'));
    }

    /**
     * Tampilkan rincian informasi resmi layanan publik (persyaratan, alur, dokumen)
     * sebelum warga/masyarakat melakukan pengajuan.
     */
    public function show(string $serviceCode): View
    {
        $service = Service::with([
            'requirements' => function ($query) {
                $query->orderBy('urutan', 'asc');
            }
        ])
        ->where('kode_layanan', $serviceCode)
        ->where('is_active', true)
        ->firstOrFail();

        // Rekomendasi layanan lainnya untuk kemudahan navigasi publik
        $relatedServices = Service::where('is_active', true)
            ->where('id', '!=', $service->id)
            ->orderBy('urutan', 'asc')
            ->take(4)
            ->get();

        return view('layanan.show', compact('service', 'relatedServices'));
    }
}
