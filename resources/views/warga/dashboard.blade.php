@extends('layouts.warga')

@section('title', 'Dashboard — Portal Layanan Publik')

@section('content')
{{-- ═══════════════════════════════════════════════════════════════════════════
     PAGE HEADING (H1 — semantic, screen-reader first)
═══════════════════════════════════════════════════════════════════════════ --}}
<h1 class="sr-only">Dashboard Warga</h1>

<div class="space-y-6 sm:space-y-8">

    {{-- ═══════════════════════════════════════════════════════════════════════════
         WELCOME BANNER
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="relative overflow-hidden rounded-2xl p-6 sm:p-8 text-white shadow-lg" style="background: linear-gradient(135deg, #0a2558 0%, #1a3a70 50%, #1e5799 100%)">
        {{-- Background decoration --}}
        <div class="absolute -top-8 -right-8 w-48 h-48 rounded-full bg-white/5 pointer-events-none" aria-hidden="true"></div>
        <div class="absolute -bottom-10 -left-4 w-40 h-40 rounded-full bg-white/5 pointer-events-none" aria-hidden="true"></div>
        <div class="absolute top-4 right-24 w-20 h-20 rounded-full bg-white/5 pointer-events-none" aria-hidden="true"></div>

        <div class="relative flex flex-col sm:flex-row sm:items-center sm:justify-between gap-5">
            <div>
                <p class="text-blue-200 text-xs sm:text-sm font-semibold uppercase tracking-wider mb-1">Selamat Datang di Portal Layanan</p>
                {{-- Nama user sebagai teks sambutan, bukan h1 --}}
                <p class="text-2xl sm:text-3xl font-bold tracking-tight text-white">{{ $user->name }}</p>
                <p class="text-blue-100 text-sm sm:text-base mt-2 font-medium flex items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 bg-white/10 backdrop-blur-xs px-3 py-1 rounded-lg">
                        <i data-lucide="map-pin" class="w-4 h-4 text-blue-200" aria-hidden="true"></i>
                        Kecamatan {{ $user->kecamatan?->nama_kecamatan ?? '-' }}
                    </span>
                </p>
            </div>
            <a href="{{ route('warga.submissions.create') }}"
               class="inline-flex items-center justify-center gap-2.5 px-6 py-3.5 rounded-xl text-sm sm:text-base font-bold bg-white text-[#0a2558] hover:bg-blue-50 transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5 shrink-0 focus:ring-4 focus:ring-white/30">
                <i data-lucide="file-plus-2" class="w-5 h-5 text-[#0a2558]" aria-hidden="true"></i>
                Tambah Permohonan
            </a>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         1. KPI CARDS — data real dari $stats (backend DashboardController)
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5" role="list" aria-label="Ringkasan status permohonan">

        {{-- KPI 1: Sedang Diproses
             Source: $stats['active'] = submitted + in_review + processed --}}
        <a href="{{ route('warga.submissions.index', ['status' => 'submitted']) }}"
           role="listitem"
           class="group relative overflow-hidden bg-white rounded-2xl p-6 border border-slate-200/90 shadow-sm hover:shadow-md transition-all hover:-translate-y-0.5 focus:ring-2 focus:ring-sky-500"
           aria-label="Sedang Diproses: {{ $stats['active'] ?? 0 }} pengajuan. Lihat daftar permohonan aktif.">
            <div class="absolute inset-0 bg-gradient-to-br from-sky-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity" aria-hidden="true"></div>
            <div class="relative flex items-start justify-between gap-4">
                <div class="space-y-1">
                    <p class="text-xs sm:text-sm font-bold text-slate-500 uppercase tracking-wide">Sedang Diproses</p>
                    <p class="text-3xl sm:text-4xl font-extrabold text-slate-900 leading-tight">
                        {{ $stats['active'] ?? 0 }}
                    </p>
                    <p class="text-xs sm:text-sm text-slate-600 font-medium">Pengajuan yang sedang berjalan</p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-sky-500 text-white flex items-center justify-center flex-shrink-0 shadow-md shadow-sky-200 group-hover:scale-105 transition-transform" aria-hidden="true">
                    <i data-lucide="loader-circle" class="w-7 h-7"></i>
                </div>
            </div>
            <div class="relative mt-5 pt-3.5 border-t border-slate-100 flex items-center justify-between text-sky-700 text-xs sm:text-sm font-semibold">
                <span>Lihat daftar permohonan</span>
                <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform" aria-hidden="true"></i>
            </div>
        </a>

        {{-- KPI 2: Permohonan Selesai
             Source: $stats['completed'] = completed --}}
        <a href="{{ route('warga.submissions.index', ['status' => 'completed']) }}"
           role="listitem"
           class="group relative overflow-hidden bg-white rounded-2xl p-6 border border-slate-200/90 shadow-sm hover:shadow-md transition-all hover:-translate-y-0.5 focus:ring-2 focus:ring-emerald-500"
           aria-label="Permohonan Selesai: {{ $stats['completed'] ?? 0 }} pengajuan. Lihat permohonan yang sudah selesai.">
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity" aria-hidden="true"></div>
            <div class="relative flex items-start justify-between gap-4">
                <div class="space-y-1">
                    <p class="text-xs sm:text-sm font-bold text-slate-500 uppercase tracking-wide">Permohonan Selesai</p>
                    <p class="text-3xl sm:text-4xl font-extrabold text-slate-900 leading-tight">
                        {{ $stats['completed'] ?? 0 }}
                    </p>
                    <p class="text-xs sm:text-sm text-slate-600 font-medium">Pengajuan telah selesai diproses</p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-emerald-500 text-white flex items-center justify-center flex-shrink-0 shadow-md shadow-emerald-200 group-hover:scale-105 transition-transform" aria-hidden="true">
                    <i data-lucide="badge-check" class="w-7 h-7"></i>
                </div>
            </div>
            <div class="relative mt-5 pt-3.5 border-t border-slate-100 flex items-center justify-between text-emerald-700 text-xs sm:text-sm font-semibold">
                <span>Lihat permohonan selesai</span>
                <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform" aria-hidden="true"></i>
            </div>
        </a>

        {{-- KPI 3: Perlu Tindakan
             Source: $stats['revision_required'] = rejected + revision_required
             Label netral karena mencakup dua jenis status berbeda --}}
        <a href="{{ route('warga.submissions.index', ['status' => 'rejected']) }}"
           role="listitem"
           class="group relative overflow-hidden bg-white rounded-2xl p-6 border border-slate-200/90 shadow-sm hover:shadow-md transition-all hover:-translate-y-0.5 focus:ring-2 focus:ring-amber-500"
           aria-label="Perlu Tindakan: {{ $stats['revision_required'] ?? 0 }} pengajuan. Lihat pengajuan yang memerlukan perhatian Anda.">
            <div class="absolute inset-0 bg-gradient-to-br from-amber-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity" aria-hidden="true"></div>
            <div class="relative flex items-start justify-between gap-4">
                <div class="space-y-1">
                    <p class="text-xs sm:text-sm font-bold text-slate-500 uppercase tracking-wide">Perlu Tindakan</p>
                    <p class="text-3xl sm:text-4xl font-extrabold text-slate-900 leading-tight">
                        {{ $stats['revision_required'] ?? 0 }}
                    </p>
                    <p class="text-xs sm:text-sm text-slate-600 font-medium">Pengajuan yang memerlukan perhatian Anda</p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-amber-500 text-white flex items-center justify-center flex-shrink-0 shadow-md shadow-amber-200 group-hover:scale-105 transition-transform" aria-hidden="true">
                    <i data-lucide="circle-alert" class="w-7 h-7"></i>
                </div>
            </div>
            <div class="relative mt-5 pt-3.5 border-t border-slate-100 flex items-center justify-between text-amber-700 text-xs sm:text-sm font-semibold">
                <span>Lihat pengajuan ini</span>
                <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform" aria-hidden="true"></i>
            </div>
        </a>

    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         2. INFO AKUN (disederhanakan — NIK tidak ditampilkan di Dashboard)
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm overflow-hidden">
        <div class="px-6 py-4 sm:py-5 border-b border-slate-100 flex items-center gap-3 bg-slate-50/50">
            <div class="w-9 h-9 rounded-xl bg-[#0a2558]/10 flex items-center justify-center flex-shrink-0" aria-hidden="true">
                <i data-lucide="user-round" class="w-5 h-5 text-[#0a2558]"></i>
            </div>
            <div>
                <h2 class="text-base sm:text-lg font-bold text-slate-900">Informasi Akun</h2>
                <p class="text-xs sm:text-sm text-slate-500">Data terdaftar pada Portal Layanan Publik</p>
            </div>
            <a href="{{ route('warga.profile.edit') }}"
               class="ml-auto inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold text-[#0a2558] bg-[#0a2558]/5 hover:bg-[#0a2558]/10 transition-colors border border-[#0a2558]/10">
                <i data-lucide="pencil" class="w-3.5 h-3.5" aria-hidden="true"></i>
                Edit Profil
            </a>
        </div>

        <div class="p-6 sm:p-8">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 sm:gap-6">

                {{-- Nama --}}
                <div class="space-y-1">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Nama Lengkap</p>
                    <p class="text-sm sm:text-base font-semibold text-slate-900">{{ $user->name ?: '-' }}</p>
                </div>

                {{-- Email --}}
                <div class="space-y-1">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Email Akun</p>
                    <p class="text-sm sm:text-base font-semibold text-slate-900 break-all">{{ $user->email ?: '-' }}</p>
                </div>

                {{-- Domisili --}}
                <div class="space-y-1">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Domisili</p>
                    <p class="text-sm sm:text-base font-semibold text-slate-900">
                        @if ($user->desa)
                            Desa {{ $user->desa->nama_desa }},
                            Kec. {{ $user->kecamatan?->nama_kecamatan ?? '-' }}
                        @elseif ($user->kecamatan)
                            Kec. {{ $user->kecamatan->nama_kecamatan }}
                        @else
                            -
                        @endif
                    </p>
                </div>

            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         3. LAYANAN PUBLIK — memanfaatkan $services dari controller
         Hanya layanan aktif, data real dari Service model
    ═══════════════════════════════════════════════════════════════════════════ --}}
    @if ($services->isNotEmpty())
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm overflow-hidden">
        <div class="px-6 py-4 sm:py-5 border-b border-slate-100 flex items-center gap-3 bg-slate-50/50">
            <div class="w-9 h-9 rounded-xl bg-[#0a2558]/10 flex items-center justify-center flex-shrink-0" aria-hidden="true">
                <i data-lucide="layout-grid" class="w-5 h-5 text-[#0a2558]"></i>
            </div>
            <div>
                <h2 class="text-base sm:text-lg font-bold text-slate-900">Layanan Publik</h2>
                <p class="text-xs sm:text-sm text-slate-500">Pilih layanan yang ingin Anda ajukan.</p>
            </div>
        </div>

        <div class="p-6 sm:p-8">
            <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3" role="list" aria-label="Daftar layanan publik tersedia">
                @foreach ($services as $service)
                <li>
                    {{-- CTA menuju halaman create dengan query param service --}}
                    <a href="{{ route('warga.submissions.create', ['service' => $service->kode_layanan]) }}"
                       class="group flex items-start gap-3.5 p-4 rounded-xl border border-slate-200 hover:border-[#0a2558]/30 hover:bg-slate-50 transition-all focus:ring-2 focus:ring-[#0a2558]/30">
                        <div class="w-9 h-9 rounded-lg bg-[#0a2558]/8 flex items-center justify-center flex-shrink-0 group-hover:bg-[#0a2558]/15 transition-colors" aria-hidden="true">
                            <i data-lucide="file-text" class="w-4.5 h-4.5 text-[#0a2558]"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-bold text-[#0a2558] font-mono tracking-wide">{{ $service->kode_layanan }}</p>
                            <p class="text-xs sm:text-sm font-semibold text-slate-800 mt-0.5 leading-snug line-clamp-2">{{ $service->nama_layanan }}</p>
                        </div>
                        <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300 group-hover:text-[#0a2558] flex-shrink-0 mt-0.5 transition-colors" aria-hidden="true"></i>
                    </a>
                </li>
                @endforeach
            </ul>

            <div class="mt-5 pt-4 border-t border-slate-100 text-center">
                <a href="{{ route('warga.submissions.create') }}"
                   class="inline-flex items-center gap-2 text-sm font-semibold text-[#0a2558] hover:underline">
                    <i data-lucide="plus-circle" class="w-4 h-4" aria-hidden="true"></i>
                    Ajukan layanan lainnya
                </a>
            </div>
        </div>
    </div>
    @endif

    {{-- ═══════════════════════════════════════════════════════════════════════════
         4. PENGAJUAN TERBARU
         Data: $recentSubmissions — dibatasi controller ->take(5)
         Bukan full datatable: tidak ada pagination, tidak ada server-side filter
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm overflow-hidden"
         x-data="{
             search: '',
             matches(text) {
                 return !this.search || text.toLowerCase().includes(this.search.toLowerCase());
             }
         }">

        {{-- Section Header --}}
        <div class="px-6 py-4 sm:py-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-slate-50/50">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-[#0a2558]/10 flex items-center justify-center flex-shrink-0" aria-hidden="true">
                    <i data-lucide="clipboard-list" class="w-5 h-5 text-[#0a2558]"></i>
                </div>
                <div>
                    <h2 class="text-base sm:text-lg font-bold text-slate-900">Pengajuan Terbaru</h2>
                    <p class="text-xs sm:text-sm text-slate-500">
                        Menampilkan hingga 5 pengajuan terbaru Anda
                    </p>
                </div>
            </div>

            {{-- Controls: Search + Lihat Semua --}}
            <div class="flex items-center gap-3 flex-wrap">
                {{-- Client-side search (hanya filter dari data terbaru yang sudah dimuat) --}}
                <div class="relative">
                    <label for="dashboard-search" class="sr-only">Cari dari pengajuan terbaru</label>
                    <i data-lucide="search" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" aria-hidden="true"></i>
                    <input
                        id="dashboard-search"
                        type="search"
                        x-model="search"
                        placeholder="Cari dari pengajuan terbaru..."
                        aria-label="Cari dari pengajuan terbaru"
                        class="pl-9 pr-3.5 py-2 rounded-xl border border-slate-200 bg-white text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 w-44 sm:w-52 transition-all font-medium"
                    >
                </div>

                {{-- Lihat Semua — menggunakan route existing --}}
                <a href="{{ route('warga.submissions.index') }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs sm:text-sm font-bold text-[#0a2558] bg-[#0a2558]/5 hover:bg-[#0a2558]/10 border border-[#0a2558]/10 transition-colors whitespace-nowrap">
                    Lihat Semua
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5" aria-hidden="true"></i>
                </a>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm" aria-label="Daftar pengajuan terbaru">
                <thead>
                    <tr class="bg-slate-100/70 border-b border-slate-200 text-slate-700">
                        <th scope="col" class="py-3.5 px-4 text-xs font-bold uppercase tracking-wider whitespace-nowrap">
                            No. Tiket
                        </th>
                        <th scope="col" class="py-3.5 px-4 text-xs font-bold uppercase tracking-wider whitespace-nowrap">
                            Kode Layanan
                        </th>
                        <th scope="col" class="py-3.5 px-4 text-xs font-bold uppercase tracking-wider whitespace-nowrap">
                            Nama Layanan
                        </th>
                        <th scope="col" class="py-3.5 px-4 text-xs font-bold uppercase tracking-wider whitespace-nowrap hidden md:table-cell">
                            Instansi
                        </th>
                        <th scope="col" class="py-3.5 px-4 text-xs font-bold uppercase tracking-wider text-center whitespace-nowrap">
                            Status
                        </th>
                        <th scope="col" class="py-3.5 px-4 text-xs font-bold uppercase tracking-wider whitespace-nowrap hidden lg:table-cell">
                            Diperbarui
                        </th>
                        <th scope="col" class="py-3.5 px-4 text-xs font-bold uppercase tracking-wider text-right whitespace-nowrap">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($recentSubmissions as $sub)
                        @php
                            // Null-safe: siapkan string untuk filter search
                            $searchText = implode(' ', array_filter([
                                $sub->nomor_tiket,
                                $sub->service?->kode_layanan,
                                $sub->service?->nama_layanan,
                                $sub->status->label(),
                                $sub->kecamatan?->nama_kecamatan,
                            ]));
                        @endphp
                        <tr x-show="matches('{{ e($searchText) }}')"
                            class="hover:bg-blue-50/40 transition-colors group">
                            <td class="py-4 px-4 font-mono font-bold text-blue-700 text-sm whitespace-nowrap">
                                {{ $sub->nomor_tiket }}
                            </td>
                            <td class="py-4 px-4 font-semibold text-slate-800 whitespace-nowrap">
                                {{ $sub->service?->kode_layanan ?? '-' }}
                            </td>
                            <td class="py-4 px-4 text-slate-900 font-medium max-w-[220px]">
                                <span class="line-clamp-2 leading-relaxed">{{ $sub->service?->nama_layanan ?? '(Layanan tidak ditemukan)' }}</span>
                            </td>
                            <td class="py-4 px-4 text-slate-600 font-medium whitespace-nowrap hidden md:table-cell">
                                Kec. {{ $sub->kecamatan?->nama_kecamatan ?? '-' }}
                            </td>
                            <td class="py-4 px-4 text-center whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $sub->status->badgeColor() }}">
                                    {{ $sub->status->label() }}
                                </span>
                            </td>
                            <td class="py-4 px-4 text-slate-500 font-medium whitespace-nowrap hidden lg:table-cell text-xs">
                                {{ $sub->updated_at->isoFormat('D MMM Y, HH:mm') }}
                            </td>
                            <td class="py-4 px-4 text-right whitespace-nowrap">
                                <a href="{{ route('warga.submissions.show', $sub) }}"
                                   class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl font-bold text-xs sm:text-sm text-blue-700 bg-blue-50 hover:bg-blue-100 border border-blue-200 transition-all group-hover:shadow-sm"
                                   aria-label="Lihat detail permohonan {{ $sub->nomor_tiket }}">
                                    <i data-lucide="eye" class="w-4 h-4" aria-hidden="true"></i>
                                    <span>Detail</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-16 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center" aria-hidden="true">
                                        <i data-lucide="inbox" class="w-8 h-8 text-slate-400"></i>
                                    </div>
                                    <div>
                                        <p class="text-base font-bold text-slate-700">Belum ada riwayat permohonan</p>
                                        <p class="text-sm text-slate-500 mt-1">Mulai ajukan permohonan layanan publik Anda sekarang</p>
                                    </div>
                                    <a href="{{ route('warga.submissions.create') }}"
                                       class="mt-2 inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#0a2558] text-white text-sm font-bold hover:bg-[#0d3070] transition-colors shadow-sm">
                                        <i data-lucide="file-plus-2" class="w-4 h-4" aria-hidden="true"></i>
                                        Tambah Permohonan Baru
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Table Footer — jujur: menampilkan 5 terbaru, link ke semua --}}
        @if ($recentSubmissions->isNotEmpty())
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/80 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs text-slate-500">
            <p>
                Menampilkan <span class="font-semibold text-slate-700">{{ $recentSubmissions->count() }}</span>
                pengajuan terbaru Anda.
            </p>
            <a href="{{ route('warga.submissions.index') }}"
               class="inline-flex items-center gap-1.5 font-semibold text-[#0a2558] hover:underline">
                Lihat seluruh riwayat permohonan
                <i data-lucide="arrow-right" class="w-3.5 h-3.5" aria-hidden="true"></i>
            </a>
        </div>
        @endif

    </div>

</div>
@endsection
