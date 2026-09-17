@extends('layouts.app')

@section('title', 'Dashboard Petugas Kecamatan — Kec. ' . ($admin->kecamatan?->nama_kecamatan ?? ''))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

    {{-- ═══════════════════════════════════════════════════════════════════════════
         1. KECAMATAN OFFICIAL IDENTITY BANNER
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="relative overflow-hidden rounded-3xl p-6 sm:p-8 text-white portal-shadow" style="background: linear-gradient(135deg, #0a2558 0%, #1a3a70 50%, #1e5799 100%)">
        {{-- Background decoration --}}
        <div class="absolute -top-8 -right-8 w-48 h-48 rounded-full bg-white/5 pointer-events-none"></div>
        <div class="absolute -bottom-10 -left-4 w-40 h-40 rounded-full bg-white/5 pointer-events-none"></div>
        <div class="absolute top-4 right-24 w-20 h-20 rounded-full bg-white/5 pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-white/10 text-blue-200 border border-white/20 backdrop-blur-xs">
                    <span>🏛️ Ruang Kerja Verifikator Kecamatan</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white">
                    Kecamatan {{ $admin->kecamatan?->nama_kecamatan ?? '-' }}
                </h1>
                <p class="text-xs sm:text-sm text-blue-100 flex flex-wrap items-center gap-x-4 gap-y-1 font-medium">
                    <span>Petugas: <strong class="text-white">{{ $admin->name }}</strong></span>
                    <span>Kode Wilayah: <strong class="font-mono text-blue-200">{{ $admin->kecamatan?->kode_kecamatan ?? '-' }}</strong></span>
                    <span>Jam Operasional: <strong class="text-blue-200">{{ $admin->kecamatan?->jam_operasional ?? '08.00 - 16.00 WIB' }}</strong></span>
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('kecamatan.submissions.index') }}" class="inline-flex items-center gap-2.5 px-6 py-3.5 rounded-xl font-bold text-xs sm:text-sm bg-white text-[#0a2558] hover:bg-blue-50 transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5 shrink-0 focus:ring-4 focus:ring-white/30">
                    <span>Buka Meja Verifikasi Berkas</span>
                    <svg class="w-4 h-4 text-[#0a2558]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
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
                <p class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Total Masuk</p>
                <p class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1">{{ $stats['total'] }}</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center font-bold text-lg">
                📥
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border-2 border-blue-200 portal-shadow flex items-center justify-between bg-blue-50/30">
            <div>
                <p class="text-xs text-[#0a2558] font-bold uppercase tracking-wider">Butuh Verifikasi</p>
                <p class="text-2xl sm:text-3xl font-extrabold text-[#0a2558] mt-1">{{ $stats['needs_action'] }}</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-blue-100 text-[#0a2558] flex items-center justify-center font-bold text-lg">
                ⚡
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 portal-shadow flex items-center justify-between">
            <div>
                <p class="text-xs text-amber-600 font-semibold uppercase tracking-wider">Menunggu Revisi Warga</p>
                <p class="text-2xl sm:text-3xl font-extrabold text-amber-700 mt-1">{{ $stats['revision_required'] }}</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold text-lg">
                📝
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 portal-shadow flex items-center justify-between">
            <div>
                <p class="text-xs text-emerald-600 font-semibold uppercase tracking-wider">Selesai Hari Ini</p>
                <p class="text-2xl sm:text-3xl font-extrabold text-emerald-700 mt-1">{{ $stats['completed_today'] }}</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-lg">
                ✅
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         3. ANTREAN VERIFIKASI MENDESAK (SUBMITTED / IN REVIEW)
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Meja Verifikasi Pending --}}
        <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-200 portal-shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#0a2558]"></span>
                    <h2 class="text-base font-bold text-slate-900">Antrean Berkas Masuk yang Perlu Ditinjau</h2>
                </div>
                <a href="{{ route('kecamatan.submissions.index', ['status' => 'submitted']) }}" class="text-xs font-bold text-[#0a2558] hover:text-blue-700 transition-colors">
                    Lihat Semua &rarr;
                </a>
            </div>

            @if ($pendingSubmissions->isEmpty())
                <div class="p-12 text-center space-y-2">
                    <div class="w-12 h-12 mx-auto rounded-2xl bg-blue-50 text-[#0a2558] flex items-center justify-center text-xl">
                        🎉
                    </div>
                    <p class="text-sm font-bold text-slate-800">Semua Berkas Telah Diverifikasi</p>
                    <p class="text-xs text-slate-500">Tidak ada permohonan baru yang sedang menunggu tindakan.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-500 font-semibold border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-3.5">Nomor Tiket</th>
                                <th class="px-6 py-3.5">Pemohon & Desa</th>
                                <th class="px-6 py-3.5">Layanan</th>
                                <th class="px-6 py-3.5">Waktu Masuk</th>
                                <th class="px-6 py-3.5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($pendingSubmissions as $sub)
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <td class="px-6 py-4 font-mono font-bold text-slate-900">
                                        {{ $sub->nomor_tiket }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="font-bold text-slate-800">{{ $sub->user->name }}</p>
                                        <p class="text-[11px] text-slate-500">Desa {{ $sub->user->desa?->nama_desa ?? '-' }}</p>
                                    </td>
                                    <td class="px-6 py-4 font-medium text-slate-700">
                                        {{ $sub->service->nama_layanan }}
                                    </td>
                                    <td class="px-6 py-4 text-slate-500">
                                        {{ $sub->created_at->diffForHumans() }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('kecamatan.submissions.show', $sub) }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg font-bold text-[#0a2558] bg-blue-50 hover:bg-[#0a2558] hover:text-white border border-blue-200 transition-all shadow-2xs">
                                            <span>Verifikasi</span>
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        {{-- Agenda Biometrik e-KTP Hari Ini --}}
        <div class="bg-white rounded-3xl border border-slate-200 portal-shadow p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div class="flex items-center gap-2">
                    <span class="text-base">📸</span>
                    <h3 class="text-sm font-bold text-slate-900">Jadwal e-KTP Hari Ini</h3>
                </div>
                <span class="text-xs font-bold text-[#0a2558] bg-blue-50 px-2 py-0.5 rounded-full border border-blue-200/60">
                    {{ $todayBiometrics->count() }} Warga
                </span>
            </div>

            @if ($todayBiometrics->isEmpty())
                <div class="py-8 text-center text-xs text-slate-500 space-y-1">
                    <p class="font-semibold text-slate-700">Tidak ada jadwal perekaman e-KTP untuk hari ini.</p>
                    <p class="text-[11px] text-slate-400">Jadwal baru akan muncul saat Anda menetapkan antrean biometrik.</p>
                </div>
            @else
                <div class="space-y-3">
                    @foreach ($todayBiometrics as $bio)
                        <div class="p-3 bg-slate-50 border border-slate-200 rounded-2xl flex items-center justify-between text-xs">
                            <div>
                                <span class="font-bold text-slate-900 block">{{ $bio->user->name }}</span>
                                <span class="text-slate-500 text-[11px] font-mono">NIK: {{ $bio->user->nik ?? '-' }}</span>
                            </div>
                            <div class="text-right">
                                <span class="px-2 py-0.5 rounded font-mono font-bold bg-blue-100 text-[#0a2558] block text-[11px]">
                                    {{ $bio->nomor_antrean ?? 'A-001' }}
                                </span>
                                <span class="text-[10px] text-slate-400">{{ $bio->jadwal_biometrik?->format('H:i') }} WIB</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

</div>
@endsection
