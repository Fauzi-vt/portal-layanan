@extends('layouts.app')

@section('title', 'Verifikasi Berkas Permohonan — Desa ' . (auth()->user()->desa?->nama_desa ?? ''))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-200">
                    Wilayah: Desa {{ auth()->user()->desa?->nama_desa ?? '-' }}, Kec. {{ auth()->user()->kecamatan?->nama_kecamatan ?? '-' }}
                </span>
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight mt-1">Meja Verifikasi Berkas Desa</h1>
            <p class="text-xs sm:text-sm text-slate-500">Periksa keabsahan administrasi dan dokumen pemohon warga desa sebelum diteruskan ke Kecamatan.</p>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         FILTER STATUS TABS DENGAN COUNTER REAL-TIME
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="flex items-center gap-2 overflow-x-auto pb-2 scrollbar-thin">
        @php
            $statusTabs = [
                ''                  => ['label' => 'Semua Permohonan',       'count' => $counts['total']],
                'submitted_desa'    => ['label' => '⚡ Menunggu Verifikasi', 'count' => $counts['needs_action']],
                'submitted'         => ['label' => '🏛️ Diteruskan ke Kec.', 'count' => $counts['forwarded']],
                'revision_required' => ['label' => 'Menunggu Revisi',       'count' => $counts['revision_required']],
                'completed'         => ['label' => '✅ Selesai',            'count' => $counts['completed']],
            ];
        @endphp

        @foreach ($statusTabs as $key => $tab)
            <a href="{{ route('desa.submissions.index', array_merge(request()->query(), ['status' => $key, 'page' => 1])) }}"
               class="px-4 py-2 rounded-xl text-xs font-bold whitespace-nowrap transition-all flex items-center gap-2 border {{ $status === $key || (!$status && !$key) ? 'bg-amber-900 text-white border-amber-900 shadow-sm' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-50' }}">
                <span>{{ $tab['label'] }}</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold {{ $status === $key || (!$status && !$key) ? 'bg-amber-800 text-amber-100' : 'bg-slate-100 text-slate-600' }}">
                    {{ $tab['count'] }}
                </span>
            </a>
        @endforeach
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         SEARCH & SERVICE FILTER BAR
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="bg-white rounded-2xl p-4 border border-slate-200 portal-shadow flex flex-col sm:flex-row items-center justify-between gap-4">
        <form method="GET" action="{{ route('desa.submissions.index') }}" class="flex flex-col sm:flex-row items-center gap-3 w-full">
            @if ($status)
                <input type="hidden" name="status" value="{{ $status }}">
            @endif

            {{-- Input Search --}}
            <div class="relative flex-1 w-full">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input type="text"
                       name="search"
                       value="{{ $search }}"
                       placeholder="Cari nomor tiket, nama warga, atau NIK..."
                       class="w-full pl-10 pr-4 py-2 text-xs sm:text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-amber-500">
            </div>

            {{-- Filter Layanan --}}
            <select name="service_id" onchange="this.form.submit()" class="w-full sm:w-60 px-3 py-2 text-xs sm:text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white">
                <option value="">Semua Jenis Layanan</option>
                @foreach ($services as $svc)
                    <option value="{{ $svc->id }}" {{ $serviceId == $svc->id ? 'selected' : '' }}>
                        {{ $svc->nama_layanan }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs sm:text-sm font-semibold transition-colors">
                Cari
            </button>

            @if ($search || $serviceId || $status)
                <a href="{{ route('desa.submissions.index') }}" class="w-full sm:w-auto px-3 py-2 text-slate-500 hover:text-slate-800 text-xs font-medium text-center">
                    Reset
                </a>
            @endif
        </form>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         TABEL PERMOHONAN WARGA TINGKAT DESA
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="bg-white rounded-3xl border border-slate-200 portal-shadow overflow-hidden">
        @if ($submissions->isEmpty())
            <div class="p-16 text-center space-y-3">
                <div class="w-16 h-16 mx-auto rounded-full bg-slate-50 text-slate-400 flex items-center justify-center text-3xl">
                    📂
                </div>
                <h3 class="text-base font-bold text-slate-800">Tidak ada permohonan yang sesuai kriteria</h3>
                <p class="text-xs text-slate-500 max-w-md mx-auto">
                    Silakan ubah filter status atau kata kunci pencarian Anda untuk melihat data pengajuan lainnya.
                </p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs sm:text-sm">
                    <thead>
                        <tr class="border-b border-slate-200 bg-slate-50/75 text-slate-600 uppercase text-[11px] tracking-wider font-semibold">
                            <th class="py-3.5 px-4 sm:px-6">Tiket & Layanan</th>
                            <th class="py-3.5 px-4">Warga Pemohon</th>
                            <th class="py-3.5 px-4">Tanggal Diajukan</th>
                            <th class="py-3.5 px-4">Status</th>
                            <th class="py-3.5 px-4 sm:px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($submissions as $sub)
                            <tr class="hover:bg-amber-50/30 transition-colors">
                                <td class="py-4 px-4 sm:px-6">
                                    <div class="space-y-0.5">
                                        <span class="font-mono text-xs font-bold text-slate-900">{{ $sub->nomor_tiket }}</span>
                                        <p class="font-bold text-slate-800 text-xs sm:text-sm">{{ $sub->service->nama_layanan }}</p>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <div>
                                        <p class="font-bold text-slate-900">{{ $sub->user->name }}</p>
                                        <p class="text-xs text-slate-500 font-mono">NIK: {{ $sub->user->nik ?? '-' }}</p>
                                        <p class="text-[11px] text-slate-400">{{ $sub->user->phone ?? '-' }}</p>
                                    </div>
                                </td>
                                <td class="py-4 px-4 whitespace-nowrap text-slate-600 text-xs">
                                    {{ $sub->created_at->isoFormat('D MMM Y, HH:mm') }} WIB
                                </td>
                                <td class="py-4 px-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold border {{ $sub->status->badgeColor() }}">
                                        {{ $sub->status->label() }}
                                    </span>
                                    @if ($sub->verified_desa_at)
                                        <p class="text-[10px] text-emerald-600 font-semibold mt-1">✓ Diverifikasi desa</p>
                                    @endif
                                </td>
                                <td class="py-4 px-4 sm:px-6 text-right whitespace-nowrap">
                                    <a href="{{ route('desa.submissions.show', $sub) }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl text-xs font-bold text-amber-900 bg-amber-100 hover:bg-amber-200 transition-colors">
                                        <span>Periksa Berkas</span>
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($submissions->hasPages())
                <div class="px-6 py-4 border-t border-slate-100">
                    {{ $submissions->links() }}
                </div>
            @endif
        @endif
    </div>

</div>
@endsection
