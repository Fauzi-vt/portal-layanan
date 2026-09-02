@extends('layouts.warga')

@php
    $pageTitle = match($statusFilter) {
        'submitted' => 'Permohonan Dikirim',
        'rejected'  => 'Permohonan Ditolak',
        'completed' => 'Permohonan Terbit',
        default     => 'Daftar Permohonan',
    };

    $breadcrumbStatus = match($statusFilter) {
        'submitted' => 'Terkirim',
        'rejected'  => 'Ditolak',
        'completed' => 'Terbit',
        'in_review' => 'Verifikasi',
        'processed' => 'Diproses',
        default     => 'Semua',
    };
@endphp

@section('title', "{$pageTitle} — Portal Layanan Publik KOMDIGI")

@section('content')
<div class="space-y-6" x-data="{
    search: '',
    perPage: 10,
    matches(text) {
        return !this.search || text.toLowerCase().includes(this.search.toLowerCase());
    }
}">

    {{-- Top Heading & Breadcrumb Bar --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
        <h1 class="text-xl font-bold text-slate-900 tracking-tight">
            {{ $pageTitle }}
        </h1>
        
        {{-- Breadcrumb --}}
        <div class="flex items-center gap-1.5 text-xs text-slate-500 font-medium">
            <a href="{{ route('warga.dashboard') }}" class="text-blue-600 hover:text-blue-800 hover:underline">Dashboard</a>
            <span>/</span>
            <a href="{{ route('warga.submissions.index') }}" class="text-blue-600 hover:text-blue-800 hover:underline">Permohonan</a>
            <span>/</span>
            <span class="font-bold text-slate-900">{{ $breadcrumbStatus }}</span>
        </div>
    </div>

    {{-- Data Table Card --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-xs p-6 space-y-5">
        
        {{-- Top Table Controls: Show Entries & Search --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 text-xs">
            <div class="flex items-center gap-2 text-slate-600">
                <span>Show</span>
                <select class="px-2.5 py-1.5 rounded-lg border border-slate-300 bg-white text-xs text-slate-700 focus:border-blue-600 focus:outline-none">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
                <span>entries</span>
            </div>

            <div class="flex items-center gap-2 text-slate-600">
                <span class="font-medium">Search:</span>
                <input
                    type="text"
                    x-model="search"
                    placeholder=""
                    class="px-3 py-1.5 rounded-lg border border-slate-300 bg-white text-xs text-slate-800 focus:border-blue-600 focus:ring-1 focus:ring-blue-600 focus:outline-none w-48 sm:w-64"
                >
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto border-t border-slate-100 pt-2">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="text-slate-700 font-bold border-b border-slate-200">
                        <th class="py-3.5 px-3 uppercase tracking-wider">
                            <div class="flex items-center gap-1.5 cursor-pointer select-none">
                                <span>NO PERMOHONAN</span>
                                <span class="text-[9px] text-slate-400 font-mono">&#x25B2;&#x25BC;</span>
                            </div>
                        </th>
                        <th class="py-3.5 px-3 uppercase tracking-wider">
                            <div class="flex items-center gap-1.5 cursor-pointer select-none">
                                <span>LAYANAN</span>
                                <span class="text-[9px] text-slate-400 font-mono">&#x25B2;&#x25BC;</span>
                            </div>
                        </th>
                        <th class="py-3.5 px-3 uppercase tracking-wider">
                            <div class="flex items-center gap-1.5 cursor-pointer select-none">
                                <span>PROSES SAAT INI</span>
                                <span class="text-[9px] text-slate-400 font-mono">&#x25B2;&#x25BC;</span>
                            </div>
                        </th>
                        <th class="py-3.5 px-3 uppercase tracking-wider">
                            <div class="flex items-center gap-1.5 cursor-pointer select-none">
                                <span>PELAKSANA</span>
                                <span class="text-[9px] text-slate-400 font-mono">&#x25B2;&#x25BC;</span>
                            </div>
                        </th>
                        <th class="py-3.5 px-3 uppercase tracking-wider text-right">
                            <div class="flex items-center justify-end gap-1.5 cursor-pointer select-none">
                                <span>AKSI</span>
                                <span class="text-[9px] text-slate-400 font-mono">&#x25B2;&#x25BC;</span>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse ($submissions as $sub)
                        <tr x-show="matches('{{ $sub->nomor_tiket }} {{ $sub->service->nama_layanan }} {{ $sub->status->label() }} {{ $sub->kecamatan->nama_kecamatan }}')"
                            class="hover:bg-slate-50 transition-colors {{ $sub->status === \App\Enums\SubmissionStatus::RevisionRequired ? 'bg-amber-50/40' : '' }}">
                            <td class="py-3.5 px-3 font-mono font-bold text-blue-700">
                                {{ $sub->nomor_tiket }}
                            </td>
                            <td class="py-3.5 px-3 font-semibold text-slate-900">
                                {{ $sub->service->nama_layanan }}
                            </td>
                            <td class="py-3.5 px-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $sub->status->badgeColor() }}">
                                    {{ $sub->status->label() }}
                                </span>
                            </td>
                            <td class="py-3.5 px-3 text-slate-600">
                                Kec. {{ $sub->kecamatan->nama_kecamatan }}
                            </td>
                            <td class="py-3.5 px-3 text-right">
                                <a href="{{ route('warga.submissions.show', $sub) }}" class="inline-flex items-center gap-1 px-3 py-1 rounded-md font-bold text-xs text-blue-700 bg-blue-50 hover:bg-blue-100 transition-colors">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-slate-400 font-medium">
                                No data available in table
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Bottom Pagination & Entry Summary Bar --}}
        <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4 text-xs text-slate-500">
            <div>
                Showing {{ $submissions->firstItem() ?? 0 }} to {{ $submissions->lastItem() ?? 0 }} of {{ $submissions->total() }} entries
            </div>
            <div>
                {{ $submissions->links() }}
            </div>
        </div>

    </div>

</div>
@endsection
