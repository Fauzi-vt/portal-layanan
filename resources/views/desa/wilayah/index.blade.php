@extends('layouts.app')

@section('title', 'Data Kewilayahan — Desa ' . $desa->nama_desa)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

    {{-- ═══════════════════════════════════════════════════════════════════════════
         1. BANNER HEADER
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="bg-gradient-to-r from-amber-950 via-slate-900 to-yellow-950 rounded-3xl p-6 sm:p-8 text-white portal-shadow relative overflow-hidden">
        <div class="absolute right-0 top-0 w-96 h-96 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-amber-500/20 text-amber-300 border border-amber-500/30">
                    <span>🏡 Kasi Pelayanan Desa {{ $desa->nama_desa }}</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                    Data Kewilayahan RT & RW Desa
                </h1>
                <p class="text-xs sm:text-sm text-slate-300">
                    Kecamatan <strong class="text-white">{{ $desa->kecamatan?->nama_kecamatan ?? '-' }}</strong> &bull; Kabupaten Tasikmalaya
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('desa.dashboard') }}" class="px-4 py-2.5 rounded-xl text-xs font-bold text-white bg-white/10 hover:bg-white/20 backdrop-blur-sm transition-colors border border-white/20">
                    &larr; Dashboard Desa
                </a>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         2. STATS CARDS
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-3 gap-4 sm:gap-6">
        <div class="bg-white rounded-2xl p-5 border border-slate-200 portal-shadow flex items-center justify-between">
            <div>
                <p class="text-xs text-amber-600 font-semibold uppercase tracking-wider">Total RW</p>
                <p class="text-2xl sm:text-3xl font-extrabold text-amber-700 mt-1">{{ number_format($stats['total_rw']) }}</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold text-lg">
                🏘️
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 portal-shadow flex items-center justify-between">
            <div>
                <p class="text-xs text-emerald-600 font-semibold uppercase tracking-wider">Total RT</p>
                <p class="text-2xl sm:text-3xl font-extrabold text-emerald-700 mt-1">{{ number_format($stats['total_rt']) }}</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-lg">
                🏠
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 portal-shadow flex items-center justify-between">
            <div>
                <p class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Warga Terdaftar</p>
                <p class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1">{{ number_format($stats['total_warga']) }}</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center font-bold text-lg">
                👥
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         3. FORM EDIT DATA KEWILAYAHAN DESA
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="bg-white rounded-2xl border border-slate-200 portal-shadow p-6 sm:p-8 space-y-6">
        <div>
            <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                <span>📝</span>
                <span>Form Pembaruan Data Kewilayahan Desa</span>
            </h3>
            <p class="text-xs text-slate-500 mt-1">
                Data RW dan RT ini akan otomatis tersinkronisasi ke total kecamatan dan landing page portal layanan masyarakat Diskominfo Kab. Tasikmalaya.
            </p>
        </div>

        <form action="{{ route('desa.wilayah.update') }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Kecamatan Induk</label>
                    <input type="text" value="{{ $desa->kecamatan?->nama_kecamatan ?? '-' }}" disabled
                           class="w-full px-3.5 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-100 font-semibold text-slate-600 cursor-not-allowed">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Kode Desa Kemendagri *</label>
                    <input type="text" name="kode_desa" value="{{ old('kode_desa', $desa->kode_desa) }}" required
                           class="w-full px-3.5 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 font-mono">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Desa / Kelurahan *</label>
                <input type="text" name="nama_desa" value="{{ old('nama_desa', $desa->nama_desa) }}" required
                       class="w-full px-3.5 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 font-bold">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-3 border-t border-slate-100">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Jumlah Rukun Warga (RW) *</label>
                    <input type="number" name="jumlah_rw" value="{{ old('jumlah_rw', $desa->jumlah_rw) }}" min="0" required
                           class="w-full px-3.5 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500">
                    <p class="text-[11px] text-slate-400 mt-1">Total jumlah kepengurusan RW aktif di desa ini.</p>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Jumlah Rukun Tetangga (RT) *</label>
                    <input type="number" name="jumlah_rt" value="{{ old('jumlah_rt', $desa->jumlah_rt) }}" min="0" required
                           class="w-full px-3.5 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500">
                    <p class="text-[11px] text-slate-400 mt-1">Total jumlah RT aktif dari seluruh RW di desa ini.</p>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-end">
                <button type="submit" class="px-6 py-2.5 rounded-xl text-xs font-bold text-white bg-amber-600 hover:bg-amber-700 transition-all shadow-md">
                    Simpan Perubahan Kewilayahan Desa
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
