@extends('layouts.app')

@section('title', 'Dashboard Kasi Pelayanan Desa — Desa ' . ($admin->desa?->nama_desa ?? ''))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

    {{-- ═══════════════════════════════════════════════════════════════════════════
         1. DESA OFFICIAL IDENTITY BANNER
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="bg-gradient-to-r from-amber-950 via-slate-900 to-stone-900 rounded-3xl p-6 sm:p-8 text-white portal-shadow relative overflow-hidden">
        <div class="absolute right-0 top-0 w-96 h-96 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-amber-500/20 text-amber-300 border border-amber-500/30">
                    <span>🏡 Ruang Kerja Kasi Pelayanan Desa</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                    Desa {{ $admin->desa?->nama_desa ?? '-' }}
                </h1>
                <p class="text-xs sm:text-sm text-slate-300 flex flex-wrap items-center gap-x-4 gap-y-1">
                    <span>Petugas: <strong class="text-white">{{ $admin->name }}</strong></span>
                    <span>Kecamatan: <strong class="text-amber-300">{{ $admin->kecamatan?->nama_kecamatan ?? '-' }}</strong></span>
                    <span>Kode Desa: <strong class="font-mono text-amber-300">{{ $admin->desa?->kode_desa ?? '-' }}</strong></span>
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('desa.submissions.index') }}" class="inline-flex items-center gap-2 px-5 py-3 rounded-xl font-bold text-xs sm:text-sm text-slate-900 bg-amber-400 hover:bg-amber-300 shadow-lg shadow-amber-500/20 transition-all transform hover:-translate-y-0.5">
                    <span>Buka Meja Verifikasi Desa</span>
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         2. OPERATIONAL METRICS
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        <div class="bg-white rounded-2xl p-5 border border-slate-200 portal-shadow flex items-center justify-between">
            <div>
                <p class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Total Permohonan</p>
                <p class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1">{{ $stats['total'] }}</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center font-bold text-lg">
                📥
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border-2 border-amber-300 portal-shadow flex items-center justify-between bg-amber-50/20">
            <div>
                <p class="text-xs text-amber-700 font-bold uppercase tracking-wider">Menunggu Verifikasi Desa</p>
                <p class="text-2xl sm:text-3xl font-extrabold text-amber-800 mt-1">{{ $stats['needs_action'] }}</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold text-lg">
                ⏳
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 portal-shadow flex items-center justify-between">
            <div>
                <p class="text-xs text-blue-600 font-semibold uppercase tracking-wider">Diteruskan ke Kec.</p>
                <p class="text-2xl sm:text-3xl font-extrabold text-blue-700 mt-1">{{ $stats['forwarded'] }}</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-lg">
                🏛️
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 portal-shadow flex items-center justify-between">
            <div>
                <p class="text-xs text-emerald-600 font-semibold uppercase tracking-wider">Layanan Selesai</p>
                <p class="text-2xl sm:text-3xl font-extrabold text-emerald-700 mt-1">{{ $stats['completed'] }}</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-lg">
                ✅
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         3. PERMOHONAN WARGA MENUNGGU AKSI VERIFIKASI DESA
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Antrean Permohonan Masuk Desa --}}
        <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-200 portal-shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-amber-500 animate-pulse"></span>
                    <h2 class="text-base font-bold text-slate-900">Permohonan Warga Menunggu Verifikasi Desa</h2>
                </div>
                <a href="{{ route('desa.submissions.index', ['status' => 'submitted_desa']) }}" class="text-xs font-bold text-amber-700 hover:text-amber-900">
                    Lihat Semua &rarr;
                </a>
            </div>

            @if ($pendingSubmissions->isEmpty())
                <div class="p-12 text-center space-y-2">
                    <div class="w-14 h-14 mx-auto rounded-full bg-amber-50 text-amber-600 flex items-center justify-center text-2xl">
                        ✨
                    </div>
                    <p class="font-bold text-slate-700">Semua Permohonan Beres!</p>
                    <p class="text-xs text-slate-500">Tidak ada permohonan warga Desa {{ $admin->desa?->nama_desa }} yang sedang menunggu verifikasi awal.</p>
                </div>
            @else
                <div class="divide-y divide-slate-100 overflow-x-auto">
                    @foreach ($pendingSubmissions as $sub)
                        <div class="p-4 sm:px-6 hover:bg-slate-50/80 transition-colors flex items-center justify-between gap-4">
                            <div class="space-y-1 min-w-0">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="font-mono text-xs font-bold text-slate-800">{{ $sub->nomor_tiket }}</span>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold {{ $sub->status->badgeColor() }}">
                                        {{ $sub->status->label() }}
                                    </span>
                                </div>
                                <p class="text-sm font-bold text-slate-900 truncate">
                                    {{ $sub->service->nama_layanan }}
                                </p>
                                <p class="text-xs text-slate-500 flex items-center gap-2">
                                    <span>👤 {{ $sub->user->name }}</span>
                                    <span>•</span>
                                    <span>NIK: {{ $sub->user->nik ?? '-' }}</span>
                                    <span>•</span>
                                    <span>📅 {{ $sub->created_at->isoFormat('D MMM Y, HH:mm') }} WIB</span>
                                </p>
                            </div>

                            <a href="{{ route('desa.submissions.show', $sub) }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-bold text-amber-900 bg-amber-100 hover:bg-amber-200 transition-colors shrink-0">
                                <span>Periksa Berkas</span>
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Panel Riwayat Verifikasi Terakhir --}}
        <div class="space-y-6">
            <div class="bg-white rounded-3xl border border-slate-200 portal-shadow p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="font-bold text-slate-900 text-sm flex items-center gap-2">
                        <span>📋</span>
                        <span>Verifikasi Terakhir oleh Desa</span>
                    </h3>
                </div>

                @if ($recentVerified->isEmpty())
                    <p class="text-xs text-slate-500 py-6 text-center">Belum ada riwayat verifikasi yang diproses oleh Kasi Pelayanan.</p>
                @else
                    <div class="space-y-3">
                        @foreach ($recentVerified as $verifiedSub)
                            <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 space-y-1">
                                <div class="flex items-center justify-between">
                                    <span class="font-mono text-xs font-semibold text-slate-700">{{ $verifiedSub->nomor_tiket }}</span>
                                    <span class="text-[11px] text-emerald-600 font-semibold">✓ Diteruskan</span>
                                </div>
                                <p class="text-xs font-bold text-slate-800 truncate">{{ $verifiedSub->service->nama_layanan }}</p>
                                <p class="text-[11px] text-slate-500 flex items-center justify-between">
                                    <span>{{ $verifiedSub->user->name }}</span>
                                    <span>{{ $verifiedSub->verified_desa_at?->diffForHumans() }}</span>
                                </p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Info Pedoman Pelayanan Desa --}}
            <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-3xl border border-amber-200 p-6 space-y-2">
                <h4 class="font-bold text-amber-900 text-sm flex items-center gap-2">
                    <span>💡</span>
                    <span>Tugas Kasi Pelayanan Desa</span>
                </h4>
                <p class="text-xs text-amber-800 leading-relaxed">
                    Periksa kesesuaian dokumen warga (KTP, KK, Formulir F-1.01 atau surat pengantar). Jika berkas sudah absah, klik <strong>"Setujui & Teruskan"</strong> agar berkas masuk ke meja verifikasi Kecamatan.
                </p>
            </div>
        </div>
    </div>

</div>
@endsection
