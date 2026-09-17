@extends('layouts.superadmin')

@section('title', 'Dashboard Operasional — Super Admin Diskominfo')

@section('breadcrumb')
    <span>Dashboard Operasional</span>
@endsection

@section('content')
<div class="space-y-8"
     x-data="{
         searchQuery: '',
         statusFilter: 'all',
         selectedSubmission: null,
         detailModalOpen: false,

         openDetail(item) {
             this.selectedSubmission = item;
             this.detailModalOpen = true;
             this.$nextTick(() => this.$refs.modalClose?.focus());
         },

         filterRow(item) {
             const query = this.searchQuery.toLowerCase().trim();
             const matchesSearch = query === '' ||
                 (item.tiket && item.tiket.toLowerCase().includes(query)) ||
                 (item.pemohon && item.pemohon.toLowerCase().includes(query)) ||
                 (item.layanan && item.layanan.toLowerCase().includes(query)) ||
                 (item.kecamatan && item.kecamatan.toLowerCase().includes(query));

             if (!matchesSearch) return false;

             if (this.statusFilter === 'all') return true;
             if (this.statusFilter === 'in_progress') {
                 return ['submitted', 'submitted_desa', 'in_review', 'processed'].includes(item.statusRaw);
             }
             if (this.statusFilter === 'completed') {
                 return item.statusRaw === 'completed';
             }
             if (this.statusFilter === 'attention') {
                 return ['revision_required', 'rejected', 'draft'].includes(item.statusRaw);
             }
             return true;
         }
     }">

    {{-- ═══════════════════════════════════════════════════════════════════════════
         1. COMPACT EXECUTIVE HEADER (Rule 6 & 7)
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="bg-white rounded-2xl border border-slate-200 p-5 sm:p-6 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="space-y-1">
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-bold bg-blue-100 text-[#0a2558] border border-blue-200">
                    Diskominfo
                </span>
                <span class="text-slate-400 text-xs">•</span>
                <span class="text-xs text-slate-500 font-medium">Kabupaten Tasikmalaya</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">
                Dashboard
            </h1>
            <p class="text-xs text-slate-500 max-w-2xl leading-relaxed">
                Ringkasan operasional Portal Layanan Publik Kabupaten Tasikmalaya
            </p>
        </div>

        {{-- Action Buttons: Only real routes / actions (Rule 7 & 15) --}}
        <div class="flex items-center gap-2.5 shrink-0">
            <a href="{{ route('superadmin.dashboard') }}"
               class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 border border-slate-200 transition-colors"
               aria-label="Segarkan Data Dashboard">
                <svg class="w-3.5 h-3.5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                <span>Refresh</span>
            </a>

            <a href="{{ route('superadmin.services.index') }}"
               class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-semibold text-[#0a2558] bg-blue-50 hover:bg-blue-100 border border-blue-200 transition-colors"
               aria-label="Buka Katalog Layanan">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span>Katalog Layanan</span>
            </a>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         2. SYSTEM OVERVIEW (Rule 6 & 8)
         Strictly from backend: $stats['total_kecamatans'], $stats['total_services'], $stats['total_citizens']
         No fake growth percentages, no fake online/terhubung claim (Rule 4 & 8)
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="space-y-3">
        <div class="flex items-center justify-between px-1">
            <h2 class="text-xs font-bold uppercase tracking-wider text-slate-500">
                Gambaran Sistem
            </h2>
            <span class="text-[11px] text-slate-400 font-medium">Infrastruktur & Master Entitas</span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

            {{-- 1. Total Kecamatan (Rule 4 & 8) --}}
            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs flex items-center justify-between transition-all hover:border-slate-300">
                <div class="space-y-1">
                    <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Total Kecamatan</p>
                    <p class="text-2xl sm:text-3xl font-extrabold text-slate-900">
                        {{ number_format($stats['total_kecamatans']) }}
                    </p>
                    <p class="text-[11px] text-slate-500">Wilayah administrasi terdaftar</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-blue-50 text-[#0a2558] flex items-center justify-center shrink-0 border border-blue-100">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
            </div>

            {{-- 2. Total Layanan (Rule 8) --}}
            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs flex items-center justify-between transition-all hover:border-slate-300">
                <div class="space-y-1">
                    <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Total Layanan</p>
                    <p class="text-2xl sm:text-3xl font-extrabold text-slate-900">
                        {{ number_format($stats['total_services']) }}
                    </p>
                    <p class="text-[11px] text-slate-500">Katalog master layanan publik</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-indigo-50 text-indigo-700 flex items-center justify-center shrink-0 border border-indigo-100">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                </div>
            </div>

            {{-- 3. Total Warga (Rule 8) --}}
            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs flex items-center justify-between transition-all hover:border-slate-300">
                <div class="space-y-1">
                    <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Total Warga</p>
                    <p class="text-2xl sm:text-3xl font-extrabold text-slate-900">
                        {{ number_format($stats['total_citizens']) }}
                    </p>
                    <p class="text-[11px] text-slate-500">Akun warga terdaftar di portal</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center shrink-0 border border-slate-200">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>

        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         3. OPERATIONAL STATUS (Rule 6 & 9)
         Strictly from backend: $stats['total_submissions'], $stats['in_progress'], $stats['completed_all']
         No fake percentage / completion rate
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="space-y-3">
        <div class="flex items-center justify-between px-1">
            <h2 class="text-xs font-bold uppercase tracking-wider text-slate-500">
                Status Operasional
            </h2>
            <span class="text-[11px] text-slate-400 font-medium">Monitoring Progres Pengajuan</span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

            {{-- Total Pengajuan --}}
            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs flex items-center justify-between transition-all hover:border-slate-300">
                <div class="space-y-1">
                    <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Total Pengajuan</p>
                    <p class="text-2xl sm:text-3xl font-extrabold text-slate-900">
                        {{ number_format($stats['total_submissions']) }}
                    </p>
                    <p class="text-[11px] text-slate-500">Akumulasi seluruh berkas masuk</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center shrink-0 border border-sky-100">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>

            {{-- Sedang Diproses --}}
            <div class="bg-white rounded-2xl p-5 border border-amber-200/80 shadow-xs flex items-center justify-between transition-all hover:border-amber-300">
                <div class="space-y-1">
                    <p class="text-[11px] font-bold text-amber-800 uppercase tracking-wider">Sedang Diproses</p>
                    <p class="text-2xl sm:text-3xl font-extrabold text-amber-900">
                        {{ number_format($stats['in_progress']) }}
                    </p>
                    <p class="text-[11px] text-amber-700">Verifikasi desa & proses kecamatan</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0 border border-amber-200">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            {{-- Selesai --}}
            <div class="bg-white rounded-2xl p-5 border border-emerald-200/80 shadow-xs flex items-center justify-between transition-all hover:border-emerald-300">
                <div class="space-y-1">
                    <p class="text-[11px] font-bold text-emerald-800 uppercase tracking-wider">Selesai</p>
                    <p class="text-2xl sm:text-3xl font-extrabold text-emerald-900">
                        {{ number_format($stats['completed_all']) }}
                    </p>
                    <p class="text-[11px] text-emerald-700">Layanan tuntas diterbitkan</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 border border-emerald-200">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

        </div>
    </div>

    {{-- NOTE on Rule 10 (PERLU PERHATIAN):
         Per Rule 10, because the backend controller does not provide global attention metrics
         (e.g., total revision_required or rejected across all records), this widget is
         intentionally OMITTED to prevent displaying ungrounded or misleading data. --}}

    {{-- ═══════════════════════════════════════════════════════════════════════════
         4. ANALYTICS (Rule 6 & 11)
         A. Distribusi Layanan ($servicesBreakdown)
         B. Aktivitas Kecamatan ($topKecamatans)
         Built purely with HTML, Tailwind CSS v4, and Alpine.js (no heavy libraries)
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">

        {{-- A. Distribusi Layanan --}}
        <div class="bg-white rounded-2xl p-5 sm:p-6 border border-slate-200 shadow-xs space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800">
                        Distribusi Layanan
                    </h3>
                    <p class="text-[11px] text-slate-400">Pengajuan per master layanan publik</p>
                </div>
                <a href="{{ route('superadmin.services.index') }}"
                   class="text-[11px] font-semibold text-[#0a2558] hover:text-blue-900 transition-colors">
                    Lihat Semua Katalog &rarr;
                </a>
            </div>

            <div class="space-y-4 max-h-[380px] overflow-y-auto pr-1">
                @forelse ($servicesBreakdown as $srv)
                    @php
                        $servicePercentage = $stats['total_submissions'] > 0
                            ? round(($srv->submissions_count / $stats['total_submissions']) * 100, 1)
                            : 0;
                    @endphp
                    <div class="space-y-1.5 text-xs">
                        <div class="flex items-center justify-between gap-2">
                            <div class="flex items-center gap-2 truncate pr-2 min-w-0">
                                <span class="font-bold text-slate-800 truncate">{{ $srv->nama_layanan }}</span>
                                <span class="font-mono text-[10px] px-1.5 py-0.5 rounded bg-slate-100 text-slate-600 font-semibold shrink-0">
                                    {{ $srv->kode_layanan }}
                                </span>
                            </div>
                            <div class="text-right shrink-0">
                                <span class="font-extrabold text-slate-900">{{ number_format($srv->submissions_count) }}</span>
                                <span class="text-[11px] text-slate-400 font-medium">({{ $servicePercentage }}%)</span>
                            </div>
                        </div>

                        {{-- Progress Bar Proporsi Pengajuan --}}
                        <div class="w-full h-2 rounded-full bg-slate-100 overflow-hidden">
                            <div class="h-full bg-[#0a2558] rounded-full transition-all duration-500"
                                 style="width: {{ $servicePercentage }}%">
                            </div>
                        </div>

                        <div class="flex items-center gap-2 text-[10px] text-slate-400">
                            <span>Alur: <strong class="text-slate-600">{{ $srv->jenis_proses?->label() ?? '-' }}</strong></span>
                            <span>•</span>
                            <span>Verifikasi Desa: <strong class="text-slate-600">{{ $srv->requires_desa_approval ? 'Wajib' : 'Langsung Kecamatan' }}</strong></span>
                        </div>
                    </div>
                @empty
                    <div class="py-8 text-center text-slate-400 text-xs">
                        Belum ada data katalog layanan.
                    </div>
                @endforelse
            </div>
        </div>

        {{-- B. Aktivitas Kecamatan --}}
        <div class="bg-white rounded-2xl p-5 sm:p-6 border border-slate-200 shadow-xs space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800">
                        Aktivitas Kecamatan
                    </h3>
                    <p class="text-[11px] text-slate-400">Kecamatan dengan volume pengajuan terbanyak</p>
                </div>
                <a href="{{ route('superadmin.wilayah.index') }}"
                   class="text-[11px] font-semibold text-[#0a2558] hover:text-blue-900 transition-colors">
                    Master Wilayah &rarr;
                </a>
            </div>

            <div class="space-y-3 max-h-[380px] overflow-y-auto pr-1">
                @forelse ($topKecamatans as $idx => $kec)
                    @php
                        $kecPercentage = $stats['total_submissions'] > 0
                            ? round(($kec->submissions_count / $stats['total_submissions']) * 100, 1)
                            : 0;
                    @endphp
                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80 flex items-center justify-between gap-3 text-xs hover:bg-slate-100/70 transition-colors">
                        <div class="flex items-center gap-3 min-w-0">
                            <span class="w-7 h-7 rounded-lg bg-white border border-slate-200 font-extrabold text-slate-700 flex items-center justify-center text-xs shrink-0 shadow-2xs">
                                {{ $idx + 1 }}
                            </span>
                            <div class="min-w-0 truncate">
                                <p class="font-bold text-slate-900 truncate">Kecamatan {{ $kec->nama_kecamatan }}</p>
                                <p class="text-[11px] text-slate-500 font-mono">{{ $kec->kode_kecamatan }}</p>
                            </div>
                        </div>

                        <div class="text-right shrink-0">
                            <p class="font-extrabold text-slate-900">
                                {{ number_format($kec->submissions_count) }}
                                <span class="text-[11px] font-normal text-slate-500">Pengajuan</span>
                            </p>
                            <p class="text-[10px] text-[#0a2558] font-semibold">{{ $kecPercentage }}% dari total kab.</p>
                        </div>
                    </div>
                @empty
                    <div class="py-8 text-center text-slate-400 text-xs">
                        Belum ada aktivitas kecamatan yang tercatat.
                    </div>
                @endforelse
            </div>
        </div>

    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         5. PENGAJUAN TERBARU (Rule 6, 12, 13, 14, 15)
         Source: $recentSubmissions (10 items from controller)
         Columns: Pemohon, Layanan, Kecamatan, Tanggal, Status, Aksi
         Search/Filter: Pure client-side filtering on the 10 loaded items (Rule 14)
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">

        {{-- Table Header & Explanation --}}
        <div class="p-5 sm:p-6 border-b border-slate-200 space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900 flex items-center gap-2">
                        <span>Pengajuan Terbaru</span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-[#0a2558] border border-blue-200">
                            10 Data Terakhir
                        </span>
                    </h3>
                    <p class="text-[11px] text-slate-500 mt-0.5">
                        Menampilkan 10 pengajuan terbaru yang masuk ke sistem. Pencarian & filter di bawah beroperasi pada 10 data terkini tersebut.
                    </p>
                </div>
            </div>

            {{-- Filter & Search Controls (Rule 14: Client-side only) --}}
            <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-1">
                {{-- Search Box --}}
                <div class="relative w-full sm:w-80">
                    <label for="search-input" class="sr-only">Cari pengajuan</label>
                    <input id="search-input"
                           type="text"
                           x-model="searchQuery"
                           placeholder="Cari pemohon, nomor tiket, layanan..."
                           class="w-full text-xs rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-[#0a2558] focus:ring-1 focus:ring-blue-500 pl-8 pr-3 py-2 text-slate-800 transition-colors">
                    <svg class="w-4 h-4 text-slate-400 absolute left-2.5 top-2.5 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>

                {{-- Status Filter Buttons --}}
                <div class="flex items-center gap-1.5 w-full sm:w-auto overflow-x-auto pb-1 sm:pb-0" role="tablist" aria-label="Filter Status">
                    <button type="button"
                            @click="statusFilter = 'all'"
                            :class="statusFilter === 'all' ? 'bg-[#0a2558] text-white font-bold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 font-semibold'"
                            class="px-3 py-1.5 rounded-lg text-[11px] transition-colors whitespace-nowrap focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Semua (10)
                    </button>
                    <button type="button"
                            @click="statusFilter = 'in_progress'"
                            :class="statusFilter === 'in_progress' ? 'bg-[#0a2558] text-white font-bold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 font-semibold'"
                            class="px-3 py-1.5 rounded-lg text-[11px] transition-colors whitespace-nowrap focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Sedang Proses
                    </button>
                    <button type="button"
                            @click="statusFilter = 'completed'"
                            :class="statusFilter === 'completed' ? 'bg-[#0a2558] text-white font-bold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 font-semibold'"
                            class="px-3 py-1.5 rounded-lg text-[11px] transition-colors whitespace-nowrap focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Selesai
                    </button>
                    <button type="button"
                            @click="statusFilter = 'attention'"
                            :class="statusFilter === 'attention' ? 'bg-[#0a2558] text-white font-bold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 font-semibold'"
                            class="px-3 py-1.5 rounded-lg text-[11px] transition-colors whitespace-nowrap focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Perlu Perbaikan / Lainnya
                    </button>
                </div>
            </div>
        </div>

        {{-- Table: Pemohon, Layanan, Kecamatan, Tanggal, Status, Aksi (Rule 12 & 13) --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50/80 text-slate-500 font-semibold border-b border-slate-200 uppercase tracking-wider text-[11px]">
                    <tr>
                        <th scope="col" class="py-3 px-5">Pemohon</th>
                        <th scope="col" class="py-3 px-5">Layanan</th>
                        <th scope="col" class="py-3 px-5">Kecamatan</th>
                        <th scope="col" class="py-3 px-5">Tanggal</th>
                        <th scope="col" class="py-3 px-5">Status</th>
                        <th scope="col" class="py-3 px-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($recentSubmissions as $sub)
                        @php
                            $jsData = [
                                'tiket'     => $sub->nomor_tiket,
                                'pemohon'   => $sub->user?->name ?? 'Warga (Anonim)',
                                'nik'       => $sub->user?->nik ?? '-',
                                'telepon'   => $sub->user?->phone ?? '-',
                                'kecamatan' => 'Kec. ' . ($sub->kecamatan?->nama_kecamatan ?? '-'),
                                'layanan'   => $sub->service?->nama_layanan ?? '-',
                                'kodeLayanan' => $sub->service?->kode_layanan ?? '-',
                                'alur'      => $sub->service?->jenis_proses?->label() ?? '-',
                                'statusRaw' => $sub->status->value,
                                'statusLabel' => $sub->status->label(),
                                'statusBadge' => $sub->status->badgeColor(),
                                'tanggal'   => $sub->created_at ? $sub->created_at->translatedFormat('d M Y, H:i') . ' WIB' : '-',
                                'diff'      => $sub->created_at ? $sub->created_at->diffForHumans() : '-',
                                'catatanPetugas' => $sub->catatan_petugas ?? null,
                                'catatanDesa'    => $sub->catatan_desa ?? null,
                            ];
                        @endphp

                        <tr x-show="filterRow({{ json_encode($jsData) }})"
                            class="hover:bg-slate-50/70 transition-colors">

                            {{-- 1. Pemohon (Rule 12) — NIK dihapus dari tabel; tetap tersedia di $jsData untuk modal --}}
                            <td class="py-3.5 px-5">
                                <div class="space-y-0.5">
                                    <span class="font-bold text-slate-900 block truncate max-w-[180px]">
                                        {{ $sub->user?->name ?? 'Warga (Anonim)' }}
                                    </span>
                                    <div class="flex items-center gap-1.5 text-[10px] text-slate-500 font-mono">
                                        <span>{{ $sub->nomor_tiket }}</span>
                                    </div>
                                </div>
                            </td>

                            {{-- 2. Layanan (Rule 12) --}}
                            <td class="py-3.5 px-5">
                                <div class="space-y-0.5">
                                    <span class="font-semibold text-slate-800 block truncate max-w-[220px]">
                                        {{ $sub->service?->nama_layanan ?? '-' }}
                                    </span>
                                    <span class="text-[10px] text-slate-400">
                                        {{ $sub->service?->jenis_proses?->label() ?? '-' }}
                                    </span>
                                </div>
                            </td>

                            {{-- 3. Kecamatan (Rule 12) --}}
                            <td class="py-3.5 px-5 font-medium text-slate-700 whitespace-nowrap">
                                Kec. {{ $sub->kecamatan?->nama_kecamatan ?? '-' }}
                            </td>

                            {{-- 4. Tanggal (Rule 12) --}}
                            <td class="py-3.5 px-5 text-slate-500 whitespace-nowrap text-[11px]">
                                <span class="block text-slate-700 font-medium">{{ $sub->created_at ? $sub->created_at->format('d/m/Y') : '-' }}</span>
                                <span class="text-[10px] text-slate-400">{{ $sub->created_at ? $sub->created_at->diffForHumans() : '-' }}</span>
                            </td>

                            {{-- 5. Status (Rule 12 & 13) --}}
                            <td class="py-3.5 px-5 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $sub->status->badgeColor() }}">
                                    {{ $sub->status->label() }}
                                </span>
                            </td>

                            {{-- 6. Aksi (Rule 12 & 15: Read-only modal preview) --}}
                            <td class="py-3.5 px-5 text-right whitespace-nowrap">
                                <button type="button"
                                        @click="openDetail({{ json_encode($jsData) }})"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-semibold text-[#0a2558] hover:text-blue-900 bg-blue-50 hover:bg-blue-100 border border-blue-200 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        aria-label="Lihat detail pengajuan {{ $sub->nomor_tiket }}">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <span>Detail</span>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400 text-xs">
                                Belum ada riwayat pengajuan di dalam sistem.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         MODAL PREVIEW DETAIL PENGAJUAN (READ-ONLY MONITORING)
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div x-show="detailModalOpen"
         x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs"
         @keydown.escape.window="detailModalOpen = false"
         role="dialog"
         aria-modal="true"
         aria-labelledby="modal-title">

        <div class="bg-white rounded-2xl border border-slate-200 shadow-2xl max-w-lg w-full overflow-hidden"
             @click.outside="detailModalOpen = false">

            {{-- Modal Header --}}
            <div class="px-6 py-4 bg-slate-50 border-b border-slate-200 flex items-center justify-between">
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-[#0a2558]">Rincian Pengajuan</span>
                    <h3 id="modal-title" class="text-sm font-bold text-slate-900 font-mono" x-text="selectedSubmission?.tiket"></h3>
                </div>
                <button type="button"
                        x-ref="modalClose"
                        @click="detailModalOpen = false"
                        class="p-1.5 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-200 transition-colors"
                        aria-label="Tutup Rincian">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Modal Body --}}
            <div class="p-6 space-y-4 text-xs">
                <div class="grid grid-cols-2 gap-3 p-3.5 rounded-xl bg-slate-50 border border-slate-200">
                    <div>
                        <span class="text-[10px] text-slate-500 font-semibold block">Pemohon:</span>
                        <p class="font-bold text-slate-900 text-xs" x-text="selectedSubmission?.pemohon"></p>
                        <p class="text-[11px] text-slate-500 font-mono" x-text="'NIK: ' + selectedSubmission?.nik"></p>
                        <p class="text-[11px] text-slate-500" x-text="'Telp: ' + selectedSubmission?.telepon"></p>
                    </div>
                    <div>
                        <span class="text-[10px] text-slate-500 font-semibold block">Wilayah:</span>
                        <p class="font-bold text-slate-900 text-xs" x-text="selectedSubmission?.kecamatan"></p>
                        <span class="text-[10px] text-slate-500 font-semibold block mt-1">Waktu:</span>
                        <p class="text-[11px] text-slate-700" x-text="selectedSubmission?.tanggal"></p>
                    </div>
                </div>

                <div class="space-y-1">
                    <span class="text-[10px] text-slate-500 font-semibold block">Layanan & Alur:</span>
                    <p class="font-bold text-slate-900 text-xs" x-text="selectedSubmission?.layanan"></p>
                    <p class="text-[11px] text-slate-500" x-text="'Kode: ' + selectedSubmission?.kodeLayanan + ' • Alur: ' + selectedSubmission?.alur"></p>
                </div>

                <div class="space-y-1">
                    <span class="text-[10px] text-slate-500 font-semibold block">Status Saat Ini:</span>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold border"
                          :class="selectedSubmission?.statusBadge"
                          x-text="selectedSubmission?.statusLabel">
                    </span>
                </div>

                <template x-if="selectedSubmission?.catatanPetugas">
                    <div class="space-y-1 pt-1">
                        <span class="text-[10px] text-slate-500 font-semibold block">Catatan Petugas Kecamatan:</span>
                        <div class="p-2.5 rounded-xl bg-amber-50 border border-amber-200 text-amber-900 text-[11px]"
                             x-text="selectedSubmission?.catatanPetugas">
                        </div>
                    </div>
                </template>

                <template x-if="selectedSubmission?.catatanDesa">
                    <div class="space-y-1 pt-1">
                        <span class="text-[10px] text-slate-500 font-semibold block">Catatan Verifikasi Desa:</span>
                        <div class="p-2.5 rounded-xl bg-slate-100 border border-slate-200 text-slate-800 text-[11px]"
                             x-text="selectedSubmission?.catatanDesa">
                        </div>
                    </div>
                </template>
            </div>

            {{-- Modal Footer --}}
            <div class="px-6 py-3 bg-slate-50 border-t border-slate-200 flex justify-end">
                <button type="button"
                        @click="detailModalOpen = false"
                        class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-700 bg-white hover:bg-slate-100 border border-slate-200 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Tutup
                </button>
            </div>
        </div>
    </div>

</div>
@endsection
