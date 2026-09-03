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
        <div>
            <h1 class="text-xl font-bold text-slate-900 tracking-tight">
                {{ $pageTitle }}
            </h1>
            <p class="text-xs text-slate-500 mt-0.5">Kelola dan pantau seluruh status berkas permohonan layanan publik Anda.</p>
        </div>
        
        {{-- Breadcrumb --}}
        <div class="flex items-center gap-1.5 text-xs text-slate-500 font-medium">
            <a href="{{ route('warga.dashboard') }}" class="text-blue-600 hover:text-blue-800 hover:underline">Dashboard</a>
            <span>/</span>
            <a href="{{ route('warga.submissions.index') }}" class="text-blue-600 hover:text-blue-800 hover:underline">Permohonan</a>
            <span>/</span>
            <span class="font-bold text-slate-900">{{ $breadcrumbStatus }}</span>
        </div>
    </div>

    {{-- Filter Tabs Bar --}}
    <div class="flex flex-wrap items-center gap-2 border-b border-slate-200 pb-3">
        <a href="{{ route('warga.submissions.index') }}"
           class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-bold transition-all
                  {{ !$statusFilter ? 'bg-[#0a2558] text-white shadow-sm' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200' }}">
            <i data-lucide="layers" class="w-4 h-4"></i>
            <span>Semua</span>
            <span class="px-1.5 py-0.2 text-[10px] font-bold rounded-md {{ !$statusFilter ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-700' }}">
                {{ $counts['all'] ?? 0 }}
            </span>
        </a>

        <a href="{{ route('warga.submissions.index', ['status' => 'submitted']) }}"
           class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-bold transition-all
                  {{ in_array($statusFilter, ['submitted', 'dikirim', 'proses']) ? 'bg-blue-600 text-white shadow-sm' : 'bg-white text-slate-700 hover:bg-blue-50 hover:text-blue-700 border border-slate-200' }}">
            <i data-lucide="send" class="w-4 h-4"></i>
            <span>Terkirim (Proses)</span>
            <span class="px-1.5 py-0.2 text-[10px] font-bold rounded-md {{ in_array($statusFilter, ['submitted', 'dikirim', 'proses']) ? 'bg-white/20 text-white' : 'bg-blue-100 text-blue-800' }}">
                {{ $counts['submitted'] ?? 0 }}
            </span>
        </a>

        <a href="{{ route('warga.submissions.index', ['status' => 'rejected']) }}"
           class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-bold transition-all
                  {{ in_array($statusFilter, ['rejected', 'ditolak', 'revisi']) ? 'bg-rose-600 text-white shadow-sm' : 'bg-white text-slate-700 hover:bg-rose-50 hover:text-rose-700 border border-slate-200' }}">
            <i data-lucide="x-circle" class="w-4 h-4"></i>
            <span>Ditolak / Revisi</span>
            <span class="px-1.5 py-0.2 text-[10px] font-bold rounded-md {{ in_array($statusFilter, ['rejected', 'ditolak', 'revisi']) ? 'bg-white/20 text-white' : 'bg-rose-100 text-rose-800' }}">
                {{ $counts['rejected'] ?? 0 }}
            </span>
        </a>

        <a href="{{ route('warga.submissions.index', ['status' => 'completed']) }}"
           class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-bold transition-all
                  {{ in_array($statusFilter, ['completed', 'terbit', 'selesai']) ? 'bg-emerald-600 text-white shadow-sm' : 'bg-white text-slate-700 hover:bg-emerald-50 hover:text-emerald-700 border border-slate-200' }}">
            <i data-lucide="badge-check" class="w-4 h-4"></i>
            <span>Terbit (Selesai)</span>
            <span class="px-1.5 py-0.2 text-[10px] font-bold rounded-md {{ in_array($statusFilter, ['completed', 'terbit', 'selesai']) ? 'bg-white/20 text-white' : 'bg-emerald-100 text-emerald-800' }}">
                {{ $counts['completed'] ?? 0 }}
            </span>
        </a>

        <div class="sm:ml-auto">
            <a href="{{ route('warga.submissions.create') }}"
               class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-bold bg-[#0a2558] text-white hover:bg-blue-900 transition-all shadow-xs">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>Buat Permohonan</span>
            </a>
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
                            <td colspan="5" class="py-12 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center gap-2.5">
                                    <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center">
                                        <i data-lucide="inbox" class="w-6 h-6"></i>
                                    </div>
                                    <p class="font-semibold text-slate-700 text-sm">Belum ada permohonan pada kategori ini</p>
                                    <p class="text-xs text-slate-400 max-w-sm">Silakan ajukan permohonan baru untuk memulai pengurusan dokumen kependudukan Anda.</p>
                                    <a href="{{ route('warga.submissions.create') }}" class="mt-2 inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-[#0a2558] text-white text-xs font-bold hover:bg-blue-900 transition-colors shadow-xs">
                                        <i data-lucide="plus" class="w-4 h-4"></i>
                                        <span>Buat Permohonan Baru</span>
                                    </a>
                                </div>
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
