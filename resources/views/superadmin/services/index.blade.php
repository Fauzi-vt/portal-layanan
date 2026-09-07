@extends('layouts.app')

@section('title', 'Kelola Master Layanan Publik — Diskominfo Kab. Tasikmalaya')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

    {{-- ═══════════════════════════════════════════════════════════════════════════
         1. HEADER BANNER
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="bg-gradient-to-r from-purple-950 via-slate-900 to-indigo-950 rounded-3xl p-6 sm:p-8 text-white portal-shadow relative overflow-hidden">
        <div class="absolute right-0 top-0 w-96 h-96 bg-purple-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-purple-500/20 text-purple-300 border border-purple-500/30">
                    <span>👑 Super Administrator Diskominfo</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                    Manajemen Katalog Layanan & Persyaratan
                </h1>
                <p class="text-xs sm:text-sm text-slate-300">
                    Kelola konfigurasi 9 layanan publik Kabupaten Tasikmalaya, alur proses (Digital / Hybrid), jalur desa, serta dokumen persyaratan secara dinamis.
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('superadmin.dashboard') }}" class="px-4 py-2.5 rounded-xl text-xs font-bold text-white bg-white/10 hover:bg-white/20 backdrop-blur-sm transition-colors border border-white/20">
                    &larr; Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>

    {{-- Feedback Notifications --}}
    @if (session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center gap-3">
            <span class="text-lg">✓</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if (session('error'))
        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold flex items-center gap-3">
            <span class="text-lg">⚠️</span>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    {{-- ═══════════════════════════════════════════════════════════════════════════
         2. STATS & FILTERS
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl p-4 border border-slate-200 portal-shadow">
            <p class="text-xs text-slate-500 font-semibold uppercase">Total Layanan</p>
            <p class="text-2xl font-extrabold text-purple-700 mt-1">{{ $services->count() }}</p>
        </div>
        <div class="bg-white rounded-2xl p-4 border border-slate-200 portal-shadow">
            <p class="text-xs text-slate-500 font-semibold uppercase">Layanan Aktif</p>
            <p class="text-2xl font-extrabold text-emerald-600 mt-1">{{ $services->where('is_active', true)->count() }}</p>
        </div>
        <div class="bg-white rounded-2xl p-4 border border-slate-200 portal-shadow">
            <p class="text-xs text-slate-500 font-semibold uppercase">Layanan Hybrid</p>
            <p class="text-2xl font-extrabold text-amber-600 mt-1">{{ $services->where('jenis_proses.value', 'hybrid')->count() }}</p>
        </div>
        <div class="bg-white rounded-2xl p-4 border border-slate-200 portal-shadow">
            <p class="text-xs text-slate-500 font-semibold uppercase">Jalur Lewat Desa</p>
            <p class="text-2xl font-extrabold text-indigo-600 mt-1">{{ $services->where('requires_desa_approval', true)->count() }}</p>
        </div>
    </div>

    {{-- Filter & Search Form --}}
    <div class="bg-white rounded-2xl p-4 border border-slate-200 portal-shadow flex flex-col sm:flex-row items-center justify-between gap-4">
        <form method="GET" action="{{ route('superadmin.services.index') }}" class="w-full flex flex-col sm:flex-row items-center gap-3">
            <div class="relative w-full sm:w-72">
                <input type="text"
                       name="search"
                       value="{{ $search }}"
                       placeholder="Cari kode atau nama layanan..."
                       class="w-full text-xs rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-purple-500 focus:ring-purple-500 pl-8 pr-3 py-2">
                <span class="absolute left-2.5 top-2.5 text-slate-400 text-xs">🔍</span>
            </div>

            <select name="status" class="w-full sm:w-44 text-xs rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-purple-500 focus:ring-purple-500 py-2">
                <option value="">Semua Status</option>
                <option value="1" {{ $status === '1' ? 'selected' : '' }}>Hanya Aktif</option>
                <option value="0" {{ $status === '0' ? 'selected' : '' }}>Hanya Nonaktif</option>
            </select>

            <button type="submit" class="w-full sm:w-auto px-4 py-2 rounded-xl text-xs font-bold text-white bg-purple-700 hover:bg-purple-800 transition-colors">
                Filter
            </button>

            @if ($search || $status !== null && $status !== '')
                <a href="{{ route('superadmin.services.index') }}" class="w-full sm:w-auto text-center px-3 py-2 rounded-xl text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors">
                    Reset
                </a>
            @endif
        </form>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         3. DAFTAR MASTER LAYANAN
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="bg-white rounded-3xl border border-slate-200 portal-shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
            <h3 class="font-bold text-slate-800 text-sm">Katalog Layanan Publik</h3>
            <span class="text-xs text-slate-500 font-medium">{{ $services->count() }} Layanan Terdaftar</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200 text-slate-500 font-semibold uppercase tracking-wider text-[11px]">
                        <th class="py-3.5 px-6">Urutan</th>
                        <th class="py-3.5 px-6">Layanan</th>
                        <th class="py-3.5 px-6">Jenis Proses</th>
                        <th class="py-3.5 px-6">Verifikasi Desa</th>
                        <th class="py-3.5 px-6 text-center">Persyaratan</th>
                        <th class="py-3.5 px-6 text-center">Permohonan</th>
                        <th class="py-3.5 px-6 text-center">Status</th>
                        <th class="py-3.5 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($services as $service)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="py-4 px-6 font-mono font-bold text-slate-400">
                                #{{ $service->urutan }}
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-purple-50 text-purple-700 flex items-center justify-center font-bold text-base shrink-0">
                                        {{ $service->ikon ? '🏛️' : '📄' }}
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <span class="font-bold text-slate-900 text-xs">{{ $service->nama_layanan }}</span>
                                            <span class="font-mono text-[10px] px-2 py-0.5 rounded bg-slate-100 text-slate-600 font-semibold">{{ $service->kode_layanan }}</span>
                                        </div>
                                        <p class="text-[11px] text-slate-500 line-clamp-1 mt-0.5">{{ $service->deskripsi }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $service->jenis_proses->badgeColor() }}">
                                    {{ $service->jenis_proses->label() }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                @if ($service->requires_desa_approval)
                                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-amber-700 bg-amber-50 px-2 py-0.5 rounded-md border border-amber-200">
                                        <span>🏡</span> Wajib Desa
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-teal-700 bg-teal-50 px-2 py-0.5 rounded-md border border-teal-200">
                                        <span>⚡</span> Langsung Kec.
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center">
                                <span class="font-bold text-slate-800">{{ $service->requirements_count }}</span>
                                <span class="text-[10px] text-slate-400 block">dokumen</span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <span class="font-bold text-slate-800">{{ $service->submissions_count }}</span>
                                <span class="text-[10px] text-slate-400 block">total tiket</span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <form action="{{ route('superadmin.services.toggle', $service) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                            title="Klik untuk mengubah status aktif"
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold transition-transform hover:scale-105 {{ $service->is_active ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' : 'bg-rose-100 text-rose-800 border border-rose-200' }}">
                                        {{ $service->is_active ? '● Aktif' : '○ Nonaktif' }}
                                    </button>
                                </form>
                            </td>
                            <td class="py-4 px-6 text-right space-x-1">
                                <a href="{{ route('superadmin.services.edit', $service) }}"
                                   class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl font-bold text-xs text-purple-700 bg-purple-50 hover:bg-purple-100 border border-purple-200 transition-colors">
                                    <span>⚙️ Kelola & Persyaratan</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-12 text-slate-400">
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
