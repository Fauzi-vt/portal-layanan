@extends('layouts.warga')

@php
    // ── Terminologi diselaraskan dengan Dashboard Phase 4.1 ──
    $pageTitle = match($statusFilter) {
        'submitted', 'dikirim', 'proses' => 'Sedang Diproses',
        'rejected',  'ditolak', 'revisi' => 'Perlu Tindakan',
        'completed', 'terbit',  'selesai' => 'Permohonan Selesai',
        default => 'Daftar Permohonan',
    };

    $breadcrumbStatus = match($statusFilter) {
        'submitted', 'dikirim', 'proses' => 'Sedang Diproses',
        'rejected',  'ditolak', 'revisi' => 'Perlu Tindakan',
        'completed', 'terbit',  'selesai' => 'Permohonan Selesai',
        'in_review'  => 'Verifikasi',
        'processed'  => 'Diproses',
        default      => 'Semua',
    };

    // Bangun array string pencarian per baris (null-safe) untuk Alpine search
    $searchStrings = $submissions->map(fn($s) => implode(' ', array_filter([
        $s->nomor_tiket,
        $s->service?->nama_layanan,
        $s->service?->kode_layanan,
        $s->status->label(),
        $s->kecamatan?->nama_kecamatan,
    ])))->values()->all();
@endphp

@section('title', "{$pageTitle} — Portal Layanan Publik")

@section('content')
<div class="space-y-6"
     x-data="{
         search: '',
         searchStrings: @js($searchStrings),
         matches(text) {
             return !this.search || text.toLowerCase().includes(this.search.toLowerCase());
         },
         get hasAnyMatch() {
             if (!this.search) return true;
             const q = this.search.toLowerCase();
             return this.searchStrings.some(s => s.toLowerCase().includes(q));
         }
     }">

    {{-- ── Heading & Breadcrumb ── --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
        <div>
            <h1 class="text-xl font-bold text-slate-900 tracking-tight">
                {{ $pageTitle }}
            </h1>
            <p class="text-xs text-slate-500 mt-0.5">Kelola dan pantau seluruh status berkas permohonan layanan publik Anda.</p>
        </div>

        {{-- Breadcrumb --}}
        <nav aria-label="Breadcrumb" class="flex items-center gap-1.5 text-xs text-slate-500 font-medium">
            <a href="{{ route('warga.dashboard') }}" class="text-blue-600 hover:text-blue-800 hover:underline">Dashboard</a>
            <span aria-hidden="true">/</span>
            <a href="{{ route('warga.submissions.index') }}" class="text-blue-600 hover:text-blue-800 hover:underline">Permohonan</a>
            <span aria-hidden="true">/</span>
            <span class="font-bold text-slate-900" aria-current="page">{{ $breadcrumbStatus }}</span>
        </nav>
    </div>

    {{-- ── Filter Tabs — query param dipertahankan, hanya label diubah ── --}}
    <div class="flex flex-wrap items-center gap-2 border-b border-slate-200 pb-3" role="tablist" aria-label="Filter status permohonan">

        {{-- Tab: Semua --}}
        <a href="{{ route('warga.submissions.index') }}"
           role="tab"
           aria-selected="{{ !$statusFilter ? 'true' : 'false' }}"
           class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-bold transition-all
                  {{ !$statusFilter ? 'bg-[#0a2558] text-white shadow-sm' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200' }}">
            <i data-lucide="layers" class="w-4 h-4" aria-hidden="true"></i>
            <span>Semua</span>
            <span class="px-1.5 py-0.5 text-[10px] font-bold rounded-md {{ !$statusFilter ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-700' }}">
                {{ $counts['all'] ?? 0 }}
            </span>
        </a>

        {{-- Tab: Sedang Diproses (submitted + in_review + processed) --}}
        <a href="{{ route('warga.submissions.index', ['status' => 'submitted']) }}"
           role="tab"
           aria-selected="{{ in_array($statusFilter, ['submitted', 'dikirim', 'proses']) ? 'true' : 'false' }}"
           class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-bold transition-all
                  {{ in_array($statusFilter, ['submitted', 'dikirim', 'proses']) ? 'bg-blue-600 text-white shadow-sm' : 'bg-white text-slate-700 hover:bg-blue-50 hover:text-blue-700 border border-slate-200' }}">
            <i data-lucide="loader-circle" class="w-4 h-4" aria-hidden="true"></i>
            <span>Sedang Diproses</span>
            <span class="px-1.5 py-0.5 text-[10px] font-bold rounded-md {{ in_array($statusFilter, ['submitted', 'dikirim', 'proses']) ? 'bg-white/20 text-white' : 'bg-blue-100 text-blue-800' }}">
                {{ $counts['submitted'] ?? 0 }}
            </span>
        </a>

        {{-- Tab: Perlu Tindakan (rejected + revision_required) --}}
        <a href="{{ route('warga.submissions.index', ['status' => 'rejected']) }}"
           role="tab"
           aria-selected="{{ in_array($statusFilter, ['rejected', 'ditolak', 'revisi']) ? 'true' : 'false' }}"
           class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-bold transition-all
                  {{ in_array($statusFilter, ['rejected', 'ditolak', 'revisi']) ? 'bg-amber-600 text-white shadow-sm' : 'bg-white text-slate-700 hover:bg-amber-50 hover:text-amber-700 border border-slate-200' }}">
            <i data-lucide="circle-alert" class="w-4 h-4" aria-hidden="true"></i>
            <span>Perlu Tindakan</span>
            <span class="px-1.5 py-0.5 text-[10px] font-bold rounded-md {{ in_array($statusFilter, ['rejected', 'ditolak', 'revisi']) ? 'bg-white/20 text-white' : 'bg-amber-100 text-amber-800' }}">
                {{ $counts['rejected'] ?? 0 }}
            </span>
        </a>

        {{-- Tab: Permohonan Selesai (completed) --}}
        <a href="{{ route('warga.submissions.index', ['status' => 'completed']) }}"
           role="tab"
           aria-selected="{{ in_array($statusFilter, ['completed', 'terbit', 'selesai']) ? 'true' : 'false' }}"
           class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-bold transition-all
                  {{ in_array($statusFilter, ['completed', 'terbit', 'selesai']) ? 'bg-emerald-600 text-white shadow-sm' : 'bg-white text-slate-700 hover:bg-emerald-50 hover:text-emerald-700 border border-slate-200' }}">
            <i data-lucide="badge-check" class="w-4 h-4" aria-hidden="true"></i>
            <span>Permohonan Selesai</span>
            <span class="px-1.5 py-0.5 text-[10px] font-bold rounded-md {{ in_array($statusFilter, ['completed', 'terbit', 'selesai']) ? 'bg-white/20 text-white' : 'bg-emerald-100 text-emerald-800' }}">
                {{ $counts['completed'] ?? 0 }}
            </span>
        </a>

        {{-- CTA Buat Permohonan --}}
        <div class="sm:ml-auto">
            <a href="{{ route('warga.submissions.create') }}"
               class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-bold bg-[#0a2558] text-white hover:bg-blue-900 transition-all shadow-xs">
                <i data-lucide="plus" class="w-4 h-4" aria-hidden="true"></i>
                <span>Buat Permohonan</span>
            </a>
        </div>
    </div>

    {{-- ── Data Table Card ── --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-xs p-6 space-y-5">

        {{-- ── Controls: Info ringkasan + Search ── --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 text-xs">

            {{-- Info ringkasan — menggunakan data paginator real (bukan fake dropdown) --}}
            <p class="text-slate-500 font-medium">
                @if ($submissions->total() > 0)
                    Menampilkan
                    <span class="font-bold text-slate-800">{{ $submissions->firstItem() ?? 0 }}</span>–<span class="font-bold text-slate-800">{{ $submissions->lastItem() ?? 0 }}</span>
                    dari <span class="font-bold text-slate-800">{{ $submissions->total() }}</span> permohonan
                @else
                    Tidak ada data permohonan pada kategori ini
                @endif
            </p>

            {{-- Search: label aksesibel + input --}}
            <div class="flex items-center gap-2">
                <label for="submission-search" class="text-slate-600 font-medium whitespace-nowrap">
                    Cari:
                </label>
                <input
                    id="submission-search"
                    type="search"
                    x-model="search"
                    placeholder="No. tiket, layanan, status..."
                    aria-label="Cari dari daftar pengajuan yang ditampilkan"
                    class="px-3 py-1.5 rounded-lg border border-slate-300 bg-white text-xs text-slate-800 focus:border-blue-600 focus:ring-1 focus:ring-blue-600 focus:outline-none w-48 sm:w-64 transition-colors"
                >
            </div>
        </div>

        {{-- ── Tabel ── --}}
        <div class="overflow-x-auto border-t border-slate-100 pt-2">
            <table class="w-full text-left text-xs border-collapse" aria-label="Daftar pengajuan layanan publik Anda">
                <caption class="sr-only">
                    Daftar pengajuan layanan publik — {{ $pageTitle }}. Total {{ $submissions->total() }} pengajuan.
                </caption>
                <thead>
                    <tr class="text-slate-700 font-bold border-b border-slate-200">
                        {{-- Sort icon dihapus — sorting tidak didukung backend --}}
                        <th scope="col" class="py-3.5 px-3 uppercase tracking-wider whitespace-nowrap">
                            No. Permohonan
                        </th>
                        <th scope="col" class="py-3.5 px-3 uppercase tracking-wider whitespace-nowrap">
                            Layanan
                        </th>
                        <th scope="col" class="py-3.5 px-3 uppercase tracking-wider whitespace-nowrap">
                            Status
                        </th>
                        <th scope="col" class="py-3.5 px-3 uppercase tracking-wider whitespace-nowrap hidden md:table-cell">
                            Pelaksana
                        </th>
                        <th scope="col" class="py-3.5 px-3 uppercase tracking-wider whitespace-nowrap hidden sm:table-cell">
                            Tanggal
                        </th>
                        <th scope="col" class="py-3.5 px-3 uppercase tracking-wider text-right whitespace-nowrap">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse ($submissions as $sub)
                        @php
                            // Null-safe: bangun string pencarian per baris
                            $rowSearch = implode(' ', array_filter([
                                $sub->nomor_tiket,
                                $sub->service?->nama_layanan,
                                $sub->service?->kode_layanan,
                                $sub->status->label(),
                                $sub->kecamatan?->nama_kecamatan,
                            ]));

                            // Row visual highlight berdasarkan status
                            $rowClass = match(true) {
                                $sub->status === \App\Enums\SubmissionStatus::Rejected         => 'bg-rose-50/30',
                                $sub->status === \App\Enums\SubmissionStatus::RevisionRequired => 'bg-amber-50/40',
                                default => '',
                            };
                        @endphp
                        <tr x-show="matches('{{ e($rowSearch) }}')"
                            class="hover:bg-slate-50 transition-colors {{ $rowClass }}">

                            {{-- No. Tiket --}}
                            <td class="py-3.5 px-3 font-mono font-bold text-blue-700 whitespace-nowrap">
                                {{ $sub->nomor_tiket }}
                            </td>

                            {{-- Nama Layanan — null-safe --}}
                            <td class="py-3.5 px-3 font-semibold text-slate-900 max-w-[180px]">
                                <span class="line-clamp-2 leading-relaxed">
                                    {{ $sub->service?->nama_layanan ?? '(Layanan tidak ditemukan)' }}
                                </span>
                            </td>

                            {{-- Status Badge — dari enum, bukan hardcoded --}}
                            <td class="py-3.5 px-3 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $sub->status->badgeColor() }}">
                                    {{ $sub->status->label() }}
                                </span>
                            </td>

                            {{-- Pelaksana / Kecamatan — null-safe, hidden di mobile --}}
                            <td class="py-3.5 px-3 text-slate-600 whitespace-nowrap hidden md:table-cell">
                                {{ $sub->kecamatan ? 'Kec. ' . $sub->kecamatan->nama_kecamatan : '-' }}
                            </td>

                            {{-- Tanggal Pengajuan — dari created_at, null-safe --}}
                            <td class="py-3.5 px-3 text-slate-500 whitespace-nowrap hidden sm:table-cell">
                                {{ $sub->created_at?->translatedFormat('d M Y') ?? '-' }}
                            </td>

                            {{-- Aksi --}}
                            <td class="py-3.5 px-3 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5 justify-end">
                                    @if ($sub->status === \App\Enums\SubmissionStatus::Draft)
                                        <a href="{{ route('warga.submissions.edit', $sub) }}"
                                           class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md font-bold text-xs text-amber-800 bg-amber-50 hover:bg-amber-100 border border-amber-200 transition-colors focus:ring-2 focus:ring-amber-500"
                                           aria-label="Edit draft permohonan {{ $sub->nomor_tiket }}">
                                            <i data-lucide="edit-3" class="w-3.5 h-3.5" aria-hidden="true"></i>
                                            Edit
                                        </a>
                                    @endif
                                    <a href="{{ route('warga.submissions.show', $sub) }}"
                                       class="inline-flex items-center gap-1 px-3 py-1 rounded-md font-bold text-xs text-blue-700 bg-blue-50 hover:bg-blue-100 transition-colors focus:ring-2 focus:ring-blue-500"
                                       aria-label="Lihat detail permohonan {{ $sub->nomor_tiket }}">
                                        <i data-lucide="eye" class="w-3.5 h-3.5" aria-hidden="true"></i>
                                        Detail
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        {{-- Empty state: tidak ada data dari DB (bukan karena filter search) --}}
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center gap-2.5">
                                    <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center" aria-hidden="true">
                                        <i data-lucide="inbox" class="w-6 h-6"></i>
                                    </div>
                                    <p class="font-semibold text-slate-700 text-sm">Belum ada permohonan pada kategori ini</p>
                                    <p class="text-xs text-slate-400 max-w-sm">Silakan ajukan permohonan baru untuk memulai pengurusan dokumen kependudukan Anda.</p>
                                    <a href="{{ route('warga.submissions.create') }}"
                                       class="mt-2 inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-[#0a2558] text-white text-xs font-bold hover:bg-blue-900 transition-colors shadow-xs">
                                        <i data-lucide="plus" class="w-4 h-4" aria-hidden="true"></i>
                                        <span>Buat Permohonan Baru</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse

                    {{-- Empty state: ada data di DB tapi semua tersembunyi karena search lokal --}}
                    @if ($submissions->count() > 0)
                        <tr x-show="!hasAnyMatch && search !== ''" x-cloak>
                            <td colspan="6" class="py-10 text-center">
                                <div class="flex flex-col items-center gap-2.5">
                                    <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center" aria-hidden="true">
                                        <i data-lucide="search-x" class="w-6 h-6 text-slate-400"></i>
                                    </div>
                                    <p class="font-semibold text-slate-700 text-sm">Tidak ada pengajuan yang cocok</p>
                                    <p class="text-xs text-slate-400">Pencarian Anda tidak menemukan hasil pada halaman ini.</p>
                                    <button type="button"
                                            @click="search = ''"
                                            class="mt-1 inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors">
                                        <i data-lucide="x" class="w-3.5 h-3.5" aria-hidden="true"></i>
                                        Kosongkan pencarian
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        {{-- ── Footer: Info paginator (real) + navigasi halaman ── --}}
        <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4 text-xs text-slate-500">
            <p>
                @if ($submissions->total() > 0)
                    Menampilkan
                    <span class="font-semibold text-slate-700">{{ $submissions->firstItem() ?? 0 }}</span>–<span class="font-semibold text-slate-700">{{ $submissions->lastItem() ?? 0 }}</span>
                    dari total <span class="font-semibold text-slate-700">{{ $submissions->total() }}</span> permohonan
                @else
                    Tidak ada data yang ditampilkan
                @endif
            </p>
            {{-- Pagination Laravel — real, withQueryString() mempertahankan ?status= --}}
            <div>
                {{ $submissions->links() }}
            </div>
        </div>

    </div>

</div>
@endsection
