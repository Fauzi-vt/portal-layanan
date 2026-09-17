@extends('layouts.superadmin')

@section('title', 'Kelola Layanan Publik — Super Admin Diskominfo')

@section('breadcrumb')
    <span>Kelola Layanan Publik</span>
@endsection

@section('content')
<div class="space-y-6">

    {{-- ═══════════════════════════════════════════════════════════════════════════
         1. EXECUTIVE HEADER
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="space-y-1">
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-bold bg-blue-100 text-[#0a2558] border border-blue-200">
                    Master Katalog Layanan
                </span>
                <span class="text-slate-400 text-xs">•</span>
                <span class="text-xs text-slate-500 font-medium">Kabupaten Tasikmalaya</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">
                Kelola Layanan Publik & Persyaratan
            </h1>
            <p class="text-xs text-slate-500 max-w-2xl leading-relaxed">
                Konfigurasi master layanan administrasi kependudukan Kabupaten Tasikmalaya, alur proses (Full Digital / Hybrid), mekanisme verifikasi desa, dan persyaratan dokumen dinamis.
            </p>
        </div>

        <div class="flex items-center gap-2.5 shrink-0">
            <a href="{{ route('superadmin.dashboard') }}"
               class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 border border-slate-200 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Dashboard Global</span>
            </a>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         2. AGGREGATE SUMMARY METRICS
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-[11px] text-slate-500 font-bold uppercase tracking-wider">Total Layanan</p>
                <p class="text-2xl font-extrabold text-slate-900 mt-1">{{ $services->count() }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-[#0a2558] flex items-center justify-center font-bold text-sm border border-blue-100">
                📄
            </div>
        </div>

        <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-[11px] text-emerald-700 font-bold uppercase tracking-wider">Layanan Aktif</p>
                <p class="text-2xl font-extrabold text-emerald-800 mt-1">{{ $services->where('is_active', true)->count() }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-sm border border-emerald-100">
                ✅
            </div>
        </div>

        <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-[11px] text-amber-700 font-bold uppercase tracking-wider">Layanan Hybrid</p>
                <p class="text-2xl font-extrabold text-amber-800 mt-1">{{ $services->where('jenis_proses.value', 'hybrid')->count() }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold text-sm border border-amber-100">
                🏛️
            </div>
        </div>

        <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-[11px] text-indigo-700 font-bold uppercase tracking-wider">Jalur Lewat Desa</p>
                <p class="text-2xl font-extrabold text-indigo-800 mt-1">{{ $services->where('requires_desa_approval', true)->count() }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-sm border border-indigo-100">
                🏡
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         3. SEARCH & FILTER TOOLBAR
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-xs">
        <form method="GET" action="{{ route('superadmin.services.index') }}" class="flex flex-col sm:flex-row items-center justify-between gap-3">
            <div class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto flex-1">
                {{-- Search --}}
                <div class="relative w-full sm:w-80">
                    <input type="text"
                           name="search"
                           value="{{ $search }}"
                           placeholder="Cari kode atau nama layanan..."
                           class="w-full text-xs rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-[#0a2558] focus:ring-blue-500 pl-8 pr-3 py-2 text-slate-800">
                    <svg class="w-4 h-4 text-slate-400 absolute left-2.5 top-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>

                {{-- Filter Status --}}
                <select name="status" class="w-full sm:w-44 text-xs rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-[#0a2558] focus:ring-blue-500 py-2 text-slate-700">
                    <option value="">Semua Status</option>
                    <option value="1" {{ $status === '1' ? 'selected' : '' }}>Hanya Aktif</option>
                    <option value="0" {{ $status === '0' ? 'selected' : '' }}>Hanya Nonaktif</option>
                </select>

                <button type="submit" class="w-full sm:w-auto px-4 py-2 rounded-xl text-xs font-bold text-white bg-[#0a2558] hover:bg-[#1a3a70] transition-colors">
                    Filter
                </button>

                @if ($search || $status !== null && $status !== '')
                    <a href="{{ route('superadmin.services.index') }}" class="w-full sm:w-auto text-center px-3 py-2 rounded-xl text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         4. DAFTAR MASTER LAYANAN PUBLIK
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
            <div>
                <h3 class="font-bold text-slate-900 text-xs uppercase tracking-wider">Katalog Layanan Publik</h3>
                <p class="text-[11px] text-slate-400 mt-0.5">Daftar layanan terkonfigurasi pada portal</p>
            </div>
            <span class="text-xs text-slate-500 font-semibold px-2.5 py-1 rounded-full bg-slate-100 border border-slate-200">
                {{ $services->count() }} Layanan
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50/80 text-slate-500 font-semibold border-b border-slate-200 uppercase tracking-wider text-[11px]">
                    <tr>
                        <th class="py-3.5 px-5">Urutan</th>
                        <th class="py-3.5 px-5">Layanan</th>
                        <th class="py-3.5 px-5">Jenis Alur</th>
                        <th class="py-3.5 px-5">Verifikasi Desa</th>
                        <th class="py-3.5 px-5 text-center">Persyaratan</th>
                        <th class="py-3.5 px-5 text-center">Total Tiket</th>
                        <th class="py-3.5 px-5 text-center">Status Publik</th>
                        <th class="py-3.5 px-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($services as $service)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            {{-- Urutan --}}
                            <td class="py-4 px-5 font-mono font-bold text-slate-400 text-xs">
                                #{{ $service->urutan }}
                            </td>

                            {{-- Info Layanan --}}
                            <td class="py-4 px-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-blue-50 text-[#0a2558] flex items-center justify-center font-bold text-sm shrink-0 border border-blue-100">
                                        {{ $service->ikon ? '🏛️' : '📄' }}
                                    </div>
                                    <div class="min-w-0">
                                        <div class="flex items-center gap-2">
                                            <span class="font-bold text-slate-900 text-xs truncate">{{ $service->nama_layanan }}</span>
                                            <span class="font-mono text-[10px] px-2 py-0.5 rounded bg-slate-100 text-slate-600 font-semibold shrink-0">
                                                {{ $service->kode_layanan }}
                                            </span>
                                        </div>
                                        <p class="text-[11px] text-slate-500 line-clamp-1 mt-0.5 max-w-md">{{ $service->deskripsi }}</p>
                                    </div>
                                </div>
                            </td>

                            {{-- Jenis Alur --}}
                            <td class="py-4 px-5 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $service->jenis_proses->badgeColor() }}">
                                    {{ $service->jenis_proses->label() }}
                                </span>
                            </td>

                            {{-- Verifikasi Desa --}}
                            <td class="py-4 px-5 whitespace-nowrap">
                                @if ($service->requires_desa_approval)
                                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-amber-800 bg-amber-50 px-2.5 py-1 rounded-full border border-amber-200">
                                        <span>🏡</span> Wajib Desa
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-teal-800 bg-teal-50 px-2.5 py-1 rounded-full border border-teal-200">
                                        <span>⚡</span> Langsung Kec.
                                    </span>
                                @endif
                            </td>

                            {{-- Persyaratan --}}
                            <td class="py-4 px-5 text-center whitespace-nowrap">
                                <span class="font-bold text-slate-800 text-xs">{{ $service->requirements_count }}</span>
                                <span class="text-[10px] text-slate-400 block">dokumen</span>
                            </td>

                            {{-- Total Tiket --}}
                            <td class="py-4 px-5 text-center whitespace-nowrap">
                                <span class="font-bold text-slate-800 text-xs">{{ number_format($service->submissions_count) }}</span>
                                <span class="text-[10px] text-slate-400 block">pengajuan</span>
                            </td>

                            {{-- Status Publik Toggle --}}
                            <td class="py-4 px-5 text-center whitespace-nowrap">
                                <form action="{{ route('superadmin.services.toggle', $service) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                            title="Klik untuk mengubah status aktif"
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold transition-all hover:scale-105 {{ $service->is_active ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' : 'bg-rose-100 text-rose-800 border border-rose-200' }}">
                                        {{ $service->is_active ? '● Aktif' : '○ Nonaktif' }}
                                    </button>
                                </form>
                            </td>

                            {{-- Aksi --}}
                            <td class="py-4 px-5 text-right whitespace-nowrap">
                                <a href="{{ route('superadmin.services.edit', $service) }}"
                                   class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl font-bold text-xs text-[#0a2558] bg-blue-50 hover:bg-blue-100 border border-blue-200 transition-colors">
                                    <span>⚙️ Kelola</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-10 text-slate-400 text-xs">
                                Tidak ada layanan yang cocok dengan kriteria pencarian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
