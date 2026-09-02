@extends('layouts.warga')

@section('title', 'Dashboard — OSS HUB Kominfo')

@section('content')
<div class="space-y-6 sm:space-y-8">

    {{-- ═══════════════════════════════════════════════════════════════════════════
         WELCOME BANNER
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="relative overflow-hidden rounded-2xl p-6 sm:p-8 text-white shadow-lg" style="background: linear-gradient(135deg, #0a2558 0%, #1a3a70 50%, #1e5799 100%)">
        {{-- Background decoration --}}
        <div class="absolute -top-8 -right-8 w-48 h-48 rounded-full bg-white/5 pointer-events-none"></div>
        <div class="absolute -bottom-10 -left-4 w-40 h-40 rounded-full bg-white/5 pointer-events-none"></div>
        <div class="absolute top-4 right-24 w-20 h-20 rounded-full bg-white/5 pointer-events-none"></div>

        <div class="relative flex flex-col sm:flex-row sm:items-center sm:justify-between gap-5">
            <div>
                <p class="text-blue-200 text-xs sm:text-sm font-semibold uppercase tracking-wider mb-1">Selamat Datang di Portal Layanan</p>
                <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-white">{{ auth()->user()->name }}</h1>
                <p class="text-blue-100 text-sm sm:text-base mt-2 font-medium flex items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 bg-white/10 backdrop-blur-xs px-3 py-1 rounded-lg">
                        <i data-lucide="map-pin" class="w-4 h-4 text-blue-200"></i>
                        Kecamatan {{ auth()->user()->kecamatan?->nama_kecamatan ?? '-' }}
                    </span>
                </p>
            </div>
            <a href="{{ route('warga.submissions.create') }}"
               class="inline-flex items-center justify-center gap-2.5 px-6 py-3.5 rounded-xl text-sm sm:text-base font-bold bg-white text-[#0a2558] hover:bg-blue-50 transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5 shrink-0 focus:ring-4 focus:ring-white/30">
                <i data-lucide="file-plus-2" class="w-5 h-5 text-[#0a2558]"></i>
                Tambah Permohonan
            </a>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         1. TOP 3 METRIC CARDS
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">

        {{-- Card 1: Permohonan Baru --}}
        <a href="{{ route('warga.submissions.index', ['status' => 'submitted']) }}"
           class="group relative overflow-hidden bg-white rounded-2xl p-6 border border-slate-200/90 shadow-sm hover:shadow-md transition-all hover:-translate-y-0.5 focus:ring-2 focus:ring-sky-500">
            <div class="absolute inset-0 bg-gradient-to-br from-sky-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="relative flex items-start justify-between gap-4">
                <div class="space-y-1">
                    <p class="text-xs sm:text-sm font-bold text-slate-500 uppercase tracking-wide">Permohonan Baru</p>
                    <p class="text-3xl sm:text-4xl font-extrabold text-slate-900 leading-tight">
                        {{ $stats['active'] ?? 0 }}
                    </p>
                    <p class="text-xs sm:text-sm text-slate-600 font-medium">Sedang dalam proses</p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-sky-500 text-white flex items-center justify-center flex-shrink-0 shadow-md shadow-sky-200 group-hover:scale-105 transition-transform">
                    <i data-lucide="send" class="w-7 h-7"></i>
                </div>
            </div>
            <div class="relative mt-5 pt-3.5 border-t border-slate-100 flex items-center justify-between text-sky-700 text-xs sm:text-sm font-semibold">
                <span>Lihat daftar permohonan</span>
                <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
            </div>
        </a>

        {{-- Card 2: Permohonan Terbit --}}
        <a href="{{ route('warga.submissions.index', ['status' => 'completed']) }}"
           class="group relative overflow-hidden bg-white rounded-2xl p-6 border border-slate-200/90 shadow-sm hover:shadow-md transition-all hover:-translate-y-0.5 focus:ring-2 focus:ring-emerald-500">
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="relative flex items-start justify-between gap-4">
                <div class="space-y-1">
                    <p class="text-xs sm:text-sm font-bold text-slate-500 uppercase tracking-wide">Permohonan Terbit</p>
                    <p class="text-3xl sm:text-4xl font-extrabold text-slate-900 leading-tight">
                        {{ $stats['completed'] ?? 0 }}
                    </p>
                    <p class="text-xs sm:text-sm text-slate-600 font-medium">Izin telah diterbitkan</p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-emerald-500 text-white flex items-center justify-center flex-shrink-0 shadow-md shadow-emerald-200 group-hover:scale-105 transition-transform">
                    <i data-lucide="badge-check" class="w-7 h-7"></i>
                </div>
            </div>
            <div class="relative mt-5 pt-3.5 border-t border-slate-100 flex items-center justify-between text-emerald-700 text-xs sm:text-sm font-semibold">
                <span>Lihat izin yang terbit</span>
                <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
            </div>
        </a>

        {{-- Card 3: Permohonan Ditolak --}}
        <a href="{{ route('warga.submissions.index', ['status' => 'rejected']) }}"
           class="group relative overflow-hidden bg-white rounded-2xl p-6 border border-slate-200/90 shadow-sm hover:shadow-md transition-all hover:-translate-y-0.5 focus:ring-2 focus:ring-rose-500">
            <div class="absolute inset-0 bg-gradient-to-br from-rose-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="relative flex items-start justify-between gap-4">
                <div class="space-y-1">
                    <p class="text-xs sm:text-sm font-bold text-slate-500 uppercase tracking-wide">Permohonan Ditolak</p>
                    <p class="text-3xl sm:text-4xl font-extrabold text-slate-900 leading-tight">
                        {{ $stats['revision_required'] ?? 0 }}
                    </p>
                    <p class="text-xs sm:text-sm text-slate-600 font-medium">Perlu tindak lanjut / revisi</p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-rose-500 text-white flex items-center justify-center flex-shrink-0 shadow-md shadow-rose-200 group-hover:scale-105 transition-transform">
                    <i data-lucide="file-x-2" class="w-7 h-7"></i>
                </div>
            </div>
            <div class="relative mt-5 pt-3.5 border-t border-slate-100 flex items-center justify-between text-rose-700 text-xs sm:text-sm font-semibold">
                <span>Lihat yang perlu revisi</span>
                <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
            </div>
        </a>

    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         2. DETAIL PENGGUNA OSS HUB KOMINFO
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm overflow-hidden">
        {{-- Card Header --}}
        <div class="px-6 py-4 sm:py-5 border-b border-slate-100 flex items-center gap-3 bg-slate-50/50">
            <div class="w-9 h-9 rounded-xl bg-[#0a2558]/10 flex items-center justify-center flex-shrink-0">
                <i data-lucide="user-round" class="w-5 h-5 text-[#0a2558]"></i>
            </div>
            <div>
                <h2 class="text-base sm:text-lg font-bold text-slate-900">Detail Pengguna OSS HUB Kominfo</h2>
                <p class="text-xs sm:text-sm text-slate-500">Informasi identitas akun pemohon layanan</p>
            </div>
        </div>

        {{-- Card Body --}}
        <div class="p-6 sm:p-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-7">

                {{-- Email --}}
                <div class="space-y-1.5">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Email Akun</p>
                    <p class="text-sm sm:text-base font-semibold text-slate-900 break-all">{{ $user->email ?: '-' }}</p>
                </div>

                {{-- Nama User --}}
                <div class="space-y-1.5">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Lengkap Pemohon</p>
                    <p class="text-sm sm:text-base font-semibold text-slate-900">{{ $user->name ?: '-' }}</p>
                </div>

                {{-- NIK / NIB --}}
                <div class="space-y-1.5">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Nomor NIK / NIB</p>
                    <p class="text-sm sm:text-base font-bold text-slate-900 font-mono tracking-wider">{{ $user->nik ?: '-' }}</p>
                </div>

                {{-- Tanggal Daftar --}}
                <div class="space-y-1.5">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Tanggal Terdaftar</p>
                    <p class="text-sm sm:text-base font-semibold text-slate-900">
                        {{ $user->created_at ? $user->created_at->translatedFormat('d F Y') : '-' }}
                    </p>
                </div>

                {{-- Alamat --}}
                <div class="space-y-1.5 sm:col-span-2 lg:col-span-4 pt-2 border-t border-slate-100">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Alamat Lengkap Perusahaan / Pemohon</p>
                    <p class="text-sm sm:text-base font-semibold text-slate-900">
                        {{ $user->desa ? 'Desa ' . $user->desa->nama_desa . ', Kecamatan ' . ($user->kecamatan?->nama_kecamatan ?? '-') : '-' }}
                    </p>
                </div>

            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         3. PERMOHONAN BARU (DATATABLE REPLICA)
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm overflow-hidden" x-data="{
        search: '',
        matches(text) {
            return !this.search || text.toLowerCase().includes(this.search.toLowerCase());
        }
    }">
        {{-- Table Header --}}
        <div class="px-6 py-4 sm:py-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-slate-50/50">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-[#0a2558]/10 flex items-center justify-center flex-shrink-0">
                    <i data-lucide="clipboard-list" class="w-5 h-5 text-[#0a2558]"></i>
                </div>
                <div>
                    <h2 class="text-base sm:text-lg font-bold text-slate-900">Daftar Permohonan Terbaru</h2>
                    <p class="text-xs sm:text-sm text-slate-500">{{ $recentSubmissions->count() }} data permohonan terkini</p>
                </div>
            </div>

            {{-- Controls: Search and Filter --}}
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2 text-slate-600 text-xs sm:text-sm">
                    <span class="font-medium">Tampilkan</span>
                    <select class="px-3 py-2 rounded-xl border border-slate-200 bg-white text-xs sm:text-sm font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
                <div class="relative">
                    <i data-lucide="search" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                    <input
                        type="text"
                        x-model="search"
                        placeholder="Cari nomor tiket, izin..."
                        class="pl-9 pr-3.5 py-2 rounded-xl border border-slate-200 bg-white text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 w-48 sm:w-60 transition-all font-medium"
                    >
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-slate-100/70 border-b border-slate-200 text-slate-700">
                        <th class="py-3.5 px-4 text-xs font-bold uppercase tracking-wider whitespace-nowrap">
                            ID Izin / Tiket
                        </th>
                        <th class="py-3.5 px-4 text-xs font-bold uppercase tracking-wider whitespace-nowrap">
                            Kode Izin
                        </th>
                        <th class="py-3.5 px-4 text-xs font-bold uppercase tracking-wider whitespace-nowrap">
                            Nama Izin Layanan
                        </th>
                        <th class="py-3.5 px-4 text-xs font-bold uppercase tracking-wider whitespace-nowrap hidden md:table-cell">
                            Instansi
                        </th>
                        <th class="py-3.5 px-4 text-xs font-bold uppercase tracking-wider text-center whitespace-nowrap">
                            Status
                        </th>
                        <th class="py-3.5 px-4 text-xs font-bold uppercase tracking-wider whitespace-nowrap hidden lg:table-cell">
                            Pembaruan Terakhir
                        </th>
                        <th class="py-3.5 px-4 text-xs font-bold uppercase tracking-wider text-right whitespace-nowrap">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($recentSubmissions as $sub)
                        <tr x-show="matches('{{ $sub->nomor_tiket }} {{ $sub->service->kode_layanan }} {{ $sub->service->nama_layanan }} {{ $sub->status->label() }} {{ $sub->kecamatan->nama_kecamatan }}')"
                            class="hover:bg-blue-50/40 transition-colors group">
                            <td class="py-4 px-4 font-mono font-bold text-blue-700 text-sm whitespace-nowrap">
                                {{ $sub->nomor_tiket }}
                            </td>
                            <td class="py-4 px-4 font-semibold text-slate-800 whitespace-nowrap">
                                {{ $sub->service->kode_layanan }}
                            </td>
                            <td class="py-4 px-4 text-slate-900 font-medium max-w-[240px]">
                                <span class="line-clamp-2 leading-relaxed">{{ $sub->service->nama_layanan }}</span>
                            </td>
                            <td class="py-4 px-4 text-slate-600 font-medium whitespace-nowrap hidden md:table-cell">
                                Kec. {{ $sub->kecamatan->nama_kecamatan }}
                            </td>
                            <td class="py-4 px-4 text-center whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $sub->status->badgeColor() }}">
                                    {{ $sub->status->label() }}
                                </span>
                            </td>
                            <td class="py-4 px-4 text-slate-500 font-medium whitespace-nowrap hidden lg:table-cell text-xs sm:text-sm">
                                {{ $sub->updated_at->isoFormat('D MMM Y, HH:mm') }}
                            </td>
                            <td class="py-4 px-4 text-right whitespace-nowrap">
                                <a href="{{ route('warga.submissions.show', $sub) }}"
                                   class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl font-bold text-xs sm:text-sm text-blue-700 bg-blue-50 hover:bg-blue-100 border border-blue-200 transition-all group-hover:shadow-sm">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                    <span>Detail</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-16 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center">
                                        <i data-lucide="inbox" class="w-8 h-8 text-slate-400"></i>
                                    </div>
                                    <div>
                                        <p class="text-base font-bold text-slate-700">Belum ada riwayat permohonan</p>
                                        <p class="text-sm text-slate-500 mt-1">Mulai ajukan permohonan izin layanan publik Anda sekarang</p>
                                    </div>
                                    <a href="{{ route('warga.submissions.create') }}"
                                       class="mt-2 inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#0a2558] text-white text-sm font-bold hover:bg-[#0d3070] transition-colors shadow-sm">
                                        <i data-lucide="file-plus-2" class="w-4 h-4"></i>
                                        Tambah Permohonan Baru
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Table Footer Pagination --}}
        <div class="px-6 py-4 border-t border-slate-200 bg-slate-50/80 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-sm text-slate-600">
            <p>
                Menampilkan data <span class="font-bold text-slate-800">{{ $recentSubmissions->count() > 0 ? '1' : '0' }}</span>
                sampai <span class="font-bold text-slate-800">{{ $recentSubmissions->count() }}</span>
                dari total <span class="font-bold text-slate-800">{{ $recentSubmissions->count() }}</span> permohonan
            </p>
            <div class="flex items-center gap-2">
                <button type="button" disabled class="px-4 py-2 rounded-xl border border-slate-200 bg-white text-slate-400 cursor-not-allowed text-xs sm:text-sm font-medium">
                    ← Sebelumnya
                </button>
                <button type="button" disabled class="px-4 py-2 rounded-xl border border-slate-200 bg-white text-slate-400 cursor-not-allowed text-xs sm:text-sm font-medium">
                    Berikutnya →
                </button>
            </div>
        </div>

    </div>

</div>
@endsection
