@extends('layouts.app')

@section('title', 'Meja Kerja Verifikasi Berkas — Kec. ' . (auth()->user()->kecamatan?->nama_kecamatan ?? ''))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-100 text-[#0a2558] border border-blue-200">
                    Wilayah: Kec. {{ auth()->user()->kecamatan?->nama_kecamatan ?? '-' }}
                </span>
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight mt-1">Meja Verifikasi Pengajuan Warga</h1>
            <p class="text-xs sm:text-sm text-slate-500">Periksa kelengkapan berkas, berikan instruksi perbaikan revisi, atau terbitkan dokumen hasil layanan.</p>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         FILTER STATUS TABS DENGAN COUNTER REAL-TIME
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="flex items-center gap-2 overflow-x-auto pb-2 scrollbar-thin">
        @php
            $statusTabs = [
                ''                  => ['label' => 'Semua Masuk',        'count' => $counts['total']],
                'submitted'         => ['label' => '⚡ Menunggu Review', 'count' => $counts['submitted']],
                'in_review'         => ['label' => 'Sedang Ditinjau',    'count' => $counts['in_review']],
                'revision_required' => ['label' => 'Menunggu Revisi',    'count' => $counts['revision_required']],
                'processed'         => ['label' => 'Diproses',           'count' => $counts['processed']],
                'completed'         => ['label' => '✅ Selesai',         'count' => $counts['completed']],
            ];
        @endphp

        @foreach ($statusTabs as $key => $tab)
            <a href="{{ route('kecamatan.submissions.index', array_merge(request()->query(), ['status' => $key, 'page' => 1])) }}"
               class="px-4 py-2 rounded-xl text-xs font-bold whitespace-nowrap transition-all flex items-center gap-2 border {{ $status === $key || (!$status && !$key) ? 'bg-[#0a2558] text-white border-[#0a2558] shadow-sm' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-50' }}">
                <span>{{ $tab['label'] }}</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold {{ $status === $key || (!$status && !$key) ? 'bg-[#1a3a70] text-blue-100' : 'bg-slate-100 text-slate-600' }}">
                    {{ $tab['count'] }}
                </span>
            </a>
        @endforeach
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         SEARCH & SERVICE FILTER BAR
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="bg-white rounded-2xl p-4 border border-slate-200 portal-shadow flex flex-col sm:flex-row items-center justify-between gap-4">
        <form method="GET" action="{{ route('kecamatan.submissions.index') }}" class="flex flex-col sm:flex-row items-center gap-3 w-full">
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
                       placeholder="Cari nomor tiket, nama pemohon, atau 16 digit NIK..."
                       class="w-full pl-10 pr-4 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-blue-500 focus:ring-blue-500">
            </div>

            {{-- Service Dropdown Filter --}}
            <div class="w-full sm:w-64">
                <select name="service_id" onchange="this.form.submit()" class="w-full text-xs rounded-xl border-slate-200 bg-slate-50 py-2 focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Semua 8 Jenis Layanan</option>
                    @foreach ($services as $srv)
                        <option value="{{ $srv->id }}" {{ $serviceId == $srv->id ? 'selected' : '' }}>
                            {{ $srv->nama_layanan }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="w-full sm:w-auto px-5 py-2 rounded-xl text-xs font-bold text-white bg-[#0a2558] hover:bg-[#1a3a70] transition-colors">
                Cari
            </button>

            @if ($search || $serviceId)
                <a href="{{ route('kecamatan.submissions.index', $status ? ['status' => $status] : []) }}" class="text-xs text-slate-500 hover:text-slate-800 underline whitespace-nowrap">
                    Reset Filter
                </a>
            @endif
        </form>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         DATA TABLE MEJA VERIFIKASI
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="bg-white rounded-3xl border border-slate-200 portal-shadow overflow-hidden">
        @if ($submissions->isEmpty())
            <div class="p-16 text-center space-y-3">
                <div class="w-14 h-14 mx-auto rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center text-2xl">
                    📂
                </div>
                <h3 class="text-sm font-bold text-slate-800">Tidak Ada Permohonan Ditemukan</h3>
                <p class="text-xs text-slate-500 max-w-sm mx-auto">Tidak ada pengajuan warga yang sesuai dengan kriteria pencarian di wilayah Kecamatan {{ auth()->user()->kecamatan?->nama_kecamatan ?? '' }}.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-500 font-semibold border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-4">Nomor Tiket</th>
                            <th class="px-6 py-4">Nama Pemohon (NIK)</th>
                            <th class="px-6 py-4">Desa Asal</th>
                            <th class="px-6 py-4">Jenis Layanan</th>
                            <th class="px-6 py-4">Waktu Masuk</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($submissions as $sub)
                            <tr class="hover:bg-slate-50/80 transition-colors {{ $sub->status === \App\Enums\SubmissionStatus::Submitted ? 'bg-blue-50/30' : '' }}">
                                <td class="px-6 py-4 font-mono font-bold text-slate-900">
                                    {{ $sub->nomor_tiket }}
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-bold text-slate-900">{{ $sub->user->name }}</p>
                                    <p class="text-[11px] text-slate-500 font-mono">NIK: {{ $sub->user->nik ?? '-' }}</p>
                                </td>
                                <td class="px-6 py-4 text-slate-700">
                                    Desa {{ $sub->user->desa?->nama_desa ?? '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-bold text-slate-800">{{ $sub->service->nama_layanan }}</p>
                                    <span class="inline-block mt-0.5 text-[10px] px-2 py-0.2 rounded font-semibold {{ $sub->service->jenis_proses->badgeColor() }}">
                                        {{ $sub->service->jenis_proses === \App\Enums\ServiceProcessType::FullDigital ? 'Digital' : 'Hybrid' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-slate-500">
                                    {{ $sub->created_at->isoFormat('D MMM Y, HH:mm') }} WIB
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold border {{ $sub->status->badgeColor() }}">
                                        {{ $sub->status->label() }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('kecamatan.submissions.show', $sub) }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl font-bold text-xs text-white bg-[#0a2558] hover:bg-[#1a3a70] shadow-sm transition-all">
                                        <span>Periksa Berkas</span>
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $submissions->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
