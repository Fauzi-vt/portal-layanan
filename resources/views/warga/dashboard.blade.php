@extends('layouts.warga')

@section('title', 'Dashboard — OSS HUB Kominfo')

@section('content')
<div class="space-y-6">

    {{-- ═══════════════════════════════════════════════════════════════════════════
         1. TOP 3 METRIC CARDS (Exact Match with Figma Design)
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- Card 1: Permohonan Baru (Sky Blue Icon with White Star) --}}
        <a href="{{ route('warga.submissions.index', ['status' => 'submitted']) }}" class="bg-white rounded-xl p-5 border border-slate-200/80 shadow-xs flex items-center gap-5 hover:shadow-md transition-shadow group">
            <div class="w-16 h-16 rounded-xl bg-[#29b6f6] text-white flex items-center justify-center text-3xl font-bold flex-shrink-0 shadow-xs group-hover:scale-105 transition-transform">
                ★
            </div>
            <div>
                <h3 class="text-base font-bold text-slate-800">Permohonan Baru</h3>
            </div>
        </a>

        {{-- Card 2: Permohonan Terbit (Green Icon with White Checkmark) --}}
        <a href="{{ route('warga.submissions.index', ['status' => 'completed']) }}" class="bg-white rounded-xl p-5 border border-slate-200/80 shadow-xs flex items-center gap-5 hover:shadow-md transition-shadow group">
            <div class="w-16 h-16 rounded-xl bg-[#4caf50] text-white flex items-center justify-center text-3xl font-bold flex-shrink-0 shadow-xs group-hover:scale-105 transition-transform">
                ✓
            </div>
            <div>
                <h3 class="text-base font-bold text-slate-800">Permohonan Terbit</h3>
            </div>
        </a>

        {{-- Card 3: Permohonan Ditolak (Coral Red Icon with White X) --}}
        <a href="{{ route('warga.submissions.index', ['status' => 'rejected']) }}" class="bg-white rounded-xl p-5 border border-slate-200/80 shadow-xs flex items-center gap-5 hover:shadow-md transition-shadow group">
            <div class="w-16 h-16 rounded-xl bg-[#ef5350] text-white flex items-center justify-center text-2xl font-bold flex-shrink-0 shadow-xs group-hover:scale-105 transition-transform">
                <span class="w-8 h-8 rounded-full border-2 border-white flex items-center justify-center text-sm font-bold">✕</span>
            </div>
            <div>
                <h3 class="text-base font-bold text-slate-800">Permohonan Ditolak</h3>
            </div>
        </a>

    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         2. DETAIL PENGGUNA OSS HUB KOMINFO (Exact Figma Match)
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="bg-white rounded-xl border border-slate-200/80 shadow-xs p-6 sm:p-8">
        <h2 class="text-lg font-bold text-slate-900 mb-6">
            Detail pengguna OSS HUB Kominfo
        </h2>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-center">
            
            {{-- Left Column (5 cols) --}}
            <div class="lg:col-span-5 space-y-4 text-xs">
                <div class="grid grid-cols-12 gap-2">
                    <span class="col-span-5 text-slate-600 font-medium">Email</span>
                    <span class="col-span-7 font-bold text-slate-800">{{ $user->email ?: '-' }}</span>
                </div>
                <div class="grid grid-cols-12 gap-2">
                    <span class="col-span-5 text-slate-600 font-medium">Nama user proses</span>
                    <span class="col-span-7 font-bold text-slate-800">{{ $user->name ?: '-' }}</span>
                </div>
                <div class="grid grid-cols-12 gap-2">
                    <span class="col-span-5 text-slate-600 font-medium">Alamat Perusahaan</span>
                    <span class="col-span-7 font-bold text-slate-800">{{ $user->desa ? 'Desa ' . $user->desa->nama_desa . ', Kec. ' . $user->kecamatan?->nama_kecamatan : '-' }}</span>
                </div>
            </div>

            {{-- Middle Column (4 cols) --}}
            <div class="lg:col-span-4 space-y-4 text-xs">
                <div class="grid grid-cols-12 gap-2">
                    <span class="col-span-6 text-slate-600 font-medium">NIB</span>
                    <span class="col-span-6 font-bold text-slate-800 font-mono">{{ $user->nik ?: '-' }}</span>
                </div>
                <div class="grid grid-cols-12 gap-2">
                    <span class="col-span-6 text-slate-600 font-medium">Tanggal Terbit NIB</span>
                    <span class="col-span-6 font-bold text-slate-800">{{ $user->created_at ? $user->created_at->format('Y-m-d') : 'Invalid Date' }}</span>
                </div>
            </div>

            {{-- Right Action Button (3 cols) --}}
            <div class="lg:col-span-3 flex justify-start lg:justify-end">
                <a href="{{ route('warga.submissions.create') }}"
                   class="inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl text-xs sm:text-sm font-bold text-white bg-[#6b82c6] hover:bg-[#5a71b2] transition-colors shadow-md shadow-indigo-500/20 w-full sm:w-auto text-center">
                    <span>+ Tambah Permohonan</span>
                </a>
            </div>

        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         3. PERMOHONAN BARU (DATATABLE REPLICA)
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="bg-white rounded-xl border border-slate-200/80 shadow-xs p-6 sm:p-8 space-y-6" x-data="{
        search: '',
        matches(text) {
            return !this.search || text.toLowerCase().includes(this.search.toLowerCase());
        }
    }">
        
        <h2 class="text-lg font-bold text-slate-900">
            Permohonan Baru
        </h2>

        {{-- Controls: Show Entries & Search --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 text-xs">
            <div class="flex items-center gap-2 text-slate-600">
                <span>Show</span>
                <select class="px-2.5 py-1.5 rounded-lg border border-slate-300 bg-white text-xs text-slate-700 focus:outline-none focus:border-blue-600">
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
                    class="px-3 py-1.5 rounded-md border border-slate-400 bg-white text-xs focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600 w-48 sm:w-60"
                >
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto border-t border-slate-100 pt-2">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="text-slate-800 font-bold border-b border-slate-200">
                        <th class="py-3.5 px-3 uppercase tracking-wider">
                            <div class="flex items-center gap-1.5 cursor-pointer select-none">
                                <span>ID IZIN</span>
                                <span class="text-[9px] text-slate-400 font-mono">&#x25B2;&#x25BC;</span>
                            </div>
                        </th>
                        <th class="py-3.5 px-3 uppercase tracking-wider">
                            <div class="flex items-center gap-1.5 cursor-pointer select-none">
                                <span>JENIS IZIN</span>
                                <span class="text-[9px] text-slate-400 font-mono">&#x25B2;&#x25BC;</span>
                            </div>
                        </th>
                        <th class="py-3.5 px-3 uppercase tracking-wider">
                            <div class="flex items-center gap-1.5 cursor-pointer select-none">
                                <span>NAMA IZIN</span>
                                <span class="text-[9px] text-slate-400 font-mono">&#x25B2;&#x25BC;</span>
                            </div>
                        </th>
                        <th class="py-3.5 px-3 uppercase tracking-wider">
                            <div class="flex items-center gap-1.5 cursor-pointer select-none">
                                <span>INSTANSI</span>
                                <span class="text-[9px] text-slate-400 font-mono">&#x25B2;&#x25BC;</span>
                            </div>
                        </th>
                        <th class="py-3.5 px-3 uppercase tracking-wider text-center">
                            <div class="flex items-center justify-center gap-1.5 cursor-pointer select-none">
                                <span>STATUS</span>
                                <span class="text-[9px] text-slate-400 font-mono">&#x25B2;&#x25BC;</span>
                            </div>
                        </th>
                        <th class="py-3.5 px-3 uppercase tracking-wider">
                            <div class="flex items-center gap-1.5 cursor-pointer select-none">
                                <span>UPDATE TERAKHIR</span>
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
                    @forelse ($recentSubmissions as $sub)
                        <tr x-show="matches('{{ $sub->nomor_tiket }} {{ $sub->service->kode_layanan }} {{ $sub->service->nama_layanan }} {{ $sub->status->label() }} {{ $sub->kecamatan->nama_kecamatan }}')"
                            class="hover:bg-slate-50 transition-colors">
                            <td class="py-3.5 px-3 font-mono font-bold text-blue-700">
                                {{ $sub->nomor_tiket }}
                            </td>
                            <td class="py-3.5 px-3 font-semibold">
                                {{ $sub->service->kode_layanan }}
                            </td>
                            <td class="py-3.5 px-3 text-slate-900">
                                {{ $sub->service->nama_layanan }}
                            </td>
                            <td class="py-3.5 px-3 text-slate-600">
                                Kec. {{ $sub->kecamatan->nama_kecamatan }}
                            </td>
                            <td class="py-3.5 px-3 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $sub->status->badgeColor() }}">
                                    {{ $sub->status->label() }}
                                </span>
                            </td>
                            <td class="py-3.5 px-3 text-slate-500">
                                {{ $sub->updated_at->isoFormat('D/MM/Y HH:mm') }}
                            </td>
                            <td class="py-3.5 px-3 text-right">
                                <a href="{{ route('warga.submissions.show', $sub) }}" class="inline-flex items-center gap-1 px-3 py-1 rounded-md font-bold text-xs text-blue-700 bg-blue-50 hover:bg-blue-100 transition-colors">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400 font-medium">
                                No data available in table
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Table Footer Pagination --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs text-slate-500 pt-4 border-t border-slate-100">
            <div>
                Showing {{ $recentSubmissions->count() > 0 ? '1' : '0' }} to {{ $recentSubmissions->count() }} of {{ $recentSubmissions->count() }} entries
            </div>

            <div class="flex items-center gap-1.5">
                <button type="button" disabled class="px-3.5 py-1.5 rounded-md border border-slate-200 bg-slate-50 text-slate-400 cursor-not-allowed text-xs">
                    Previous
                </button>
                <button type="button" disabled class="px-3.5 py-1.5 rounded-md border border-slate-200 bg-slate-50 text-slate-400 cursor-not-allowed text-xs">
                    Next
                </button>
            </div>
        </div>

    </div>

</div>
@endsection
