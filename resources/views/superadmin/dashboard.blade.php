@extends('layouts.app')

@section('title', 'Monitoring & Analytics Global (39 Kecamatan) — Diskominfo Kab. Tasikmalaya')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

    {{-- ═══════════════════════════════════════════════════════════════════════════
         1. SUPER ADMIN GLOBAL MONITORING BANNER
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="bg-gradient-to-r from-purple-950 via-slate-900 to-indigo-950 rounded-3xl p-6 sm:p-8 text-white portal-shadow relative overflow-hidden">
        <div class="absolute right-0 top-0 w-96 h-96 bg-purple-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-purple-500/20 text-purple-300 border border-purple-500/30">
                    <span>👑 Super Administrator Diskominfo</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                    Monitoring Pelayanan Publik 39 Kecamatan
                </h1>
                <p class="text-xs sm:text-sm text-slate-300 flex flex-wrap items-center gap-x-4 gap-y-1">
                    <span>Kabupaten: <strong class="text-white">Tasikmalaya, Jawa Barat</strong></span>
                    <span>Total Wilayah: <strong class="text-purple-300">39 Kecamatan Terhubung</strong></span>
                    <span>Waktu Server: <strong class="text-purple-300">{{ now()->isoFormat('D MMMM Y, HH:mm') }} WIB</strong></span>
                </p>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         2. GLOBAL AGGREGATE METRICS
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        <div class="bg-white rounded-2xl p-5 border border-slate-200 portal-shadow flex items-center justify-between">
            <div>
                <p class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Cakupan Kecamatan</p>
                <p class="text-2xl sm:text-3xl font-extrabold text-purple-700 mt-1">{{ $stats['total_kecamatans'] }}</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center font-bold text-lg">
                🏛️
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 portal-shadow flex items-center justify-between">
            <div>
                <p class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Total Warga Terdaftar</p>
                <p class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1">{{ $stats['total_citizens'] }}</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center font-bold text-lg">
                👥
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 portal-shadow flex items-center justify-between">
            <div>
                <p class="text-xs text-sky-600 font-semibold uppercase tracking-wider">Total Permohonan</p>
                <p class="text-2xl sm:text-3xl font-extrabold text-sky-700 mt-1">{{ $stats['total_submissions'] }}</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center font-bold text-lg">
                📊
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 portal-shadow flex items-center justify-between">
            <div>
                <p class="text-xs text-emerald-600 font-semibold uppercase tracking-wider">Permohonan Selesai</p>
                <p class="text-2xl sm:text-3xl font-extrabold text-emerald-700 mt-1">{{ $stats['completed_all'] }}</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-lg">
                ✅
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         3. DISTRIBUSI LAYANAN & PERFORMA KECAMATAN
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- Distribusi 8 Layanan --}}
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 portal-shadow space-y-6">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h2 class="text-sm font-bold text-slate-900">Distribusi Pengajuan per Jenis Layanan</h2>
                <span class="text-xs text-slate-500 font-medium">8 Master Layanan</span>
            </div>

            <div class="space-y-4">
                @foreach ($servicesBreakdown as $srv)
                    <div class="space-y-1.5 text-xs">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-slate-800">{{ $srv->nama_layanan }}</span>
                            <span class="font-bold text-slate-900">{{ $srv->submissions_count }} Pengajuan</span>
                        </div>
                        <div class="w-full h-2 rounded-full bg-slate-100 overflow-hidden">
                            @php
                                $percent = $stats['total_submissions'] > 0 ? ($srv->submissions_count / $stats['total_submissions']) * 100 : 0;
                            @endphp
                            <div class="h-full bg-gradient-to-r from-teal-500 to-indigo-600 rounded-full" style="width: {{ $percent }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Top Kecamatan Teraktif --}}
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 portal-shadow space-y-6">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h2 class="text-sm font-bold text-slate-900">Aktivitas Wilayah Teratas</h2>
                <span class="text-xs text-slate-500 font-medium">Top Kecamatan</span>
            </div>

            <div class="space-y-3">
                @foreach ($topKecamatans as $idx => $kec)
                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 flex items-center justify-between text-xs">
                        <div class="flex items-center gap-3">
                            <span class="w-7 h-7 rounded-xl bg-purple-100 text-purple-800 font-bold flex items-center justify-center text-xs">
                                #{{ $idx + 1 }}
                            </span>
                            <div>
                                <p class="font-bold text-slate-900">Kecamatan {{ $kec->nama_kecamatan }}</p>
                                <p class="text-[11px] text-slate-500 font-mono">{{ $kec->kode_kecamatan }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="font-bold text-purple-900">{{ $kec->submissions_count }} Permohonan</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         4. LOG PENGAJUAN TERBARU SE-KABUPATEN
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="bg-white rounded-3xl border border-slate-200 portal-shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-sm font-bold text-slate-900">Aktivitas Pengajuan Seluruh 39 Kecamatan</h2>
            <span class="text-xs text-slate-400">Terupdate Real-Time</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 font-semibold border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4">Nomor Tiket</th>
                        <th class="px-6 py-4">Wilayah Kecamatan</th>
                        <th class="px-6 py-4">Pemohon</th>
                        <th class="px-6 py-4">Jenis Layanan</th>
                        <th class="px-6 py-4">Waktu</th>
                        <th class="px-6 py-4">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($recentSubmissions as $sub)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-6 py-4 font-mono font-bold text-slate-900">
                                {{ $sub->nomor_tiket }}
                            </td>
                            <td class="px-6 py-4 font-semibold text-slate-800">
                                Kec. {{ $sub->kecamatan->nama_kecamatan }}
                            </td>
                            <td class="px-6 py-4 text-slate-700">
                                {{ $sub->user->name }}
                            </td>
                            <td class="px-6 py-4 font-medium text-slate-800">
                                {{ $sub->service->nama_layanan }}
                            </td>
                            <td class="px-6 py-4 text-slate-500">
                                {{ $sub->created_at->diffForHumans() }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $sub->status->badgeColor() }}">
                                    {{ $sub->status->label() }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                Belum ada riwayat aktivitas pengajuan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
