@extends('layouts.app')

@section('title', 'Kelola Master Kewilayahan (39 Kecamatan & Desa) — Diskominfo Kab. Tasikmalaya')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8"
     x-data="{
         activeTab: '{{ $tab }}',
         modalKecamatanOpen: false,
         isEditingKecamatan: false,
         formKecamatanAction: '{{ route('superadmin.wilayah.kecamatan.store') }}',
         kecamatanForm: {
             id: null,
             kode_kecamatan: '',
             nama_kecamatan: '',
             alamat_kantor: '',
             telepon: '',
             email: '',
             jam_operasional: 'Senin - Jumat (08.00 - 15.30 WIB)',
             jumlah_desa: '',
             jumlah_rw: '',
             jumlah_rt: ''
         },

         modalDesaOpen: false,
         isEditingDesa: false,
         formDesaAction: '{{ route('superadmin.wilayah.desa.store') }}',
         desaForm: {
             id: null,
             kecamatan_id: '{{ $selectedKecamatanId ?? ($allKecamatans->first()->id ?? '') }}',
             kode_desa: '',
             nama_desa: '',
             jumlah_rw: '',
             jumlah_rt: ''
         },

         openCreateKecamatan() {
             this.isEditingKecamatan = false;
             this.formKecamatanAction = '{{ route('superadmin.wilayah.kecamatan.store') }}';
             this.kecamatanForm = {
                 id: null,
                 kode_kecamatan: '',
                 nama_kecamatan: '',
                 alamat_kantor: '',
                 telepon: '',
                 email: '',
                 jam_operasional: 'Senin - Jumat (08.00 - 15.30 WIB)',
                 jumlah_desa: '',
                 jumlah_rw: '',
                 jumlah_rt: ''
             };
             this.modalKecamatanOpen = true;
         },

         openEditKecamatan(kec) {
             this.isEditingKecamatan = true;
             this.formKecamatanAction = '{{ url('/superadmin/wilayah/kecamatan') }}/' + kec.id;
             this.kecamatanForm = {
                 id: kec.id,
                 kode_kecamatan: kec.kode_kecamatan,
                 nama_kecamatan: kec.nama_kecamatan,
                 alamat_kantor: kec.alamat_kantor || '',
                 telepon: kec.telepon || '',
                 email: kec.email || '',
                 jam_operasional: kec.jam_operasional || 'Senin - Jumat (08.00 - 15.30 WIB)',
                 jumlah_desa: kec.jumlah_desa || '',
                 jumlah_rw: kec.jumlah_rw || '',
                 jumlah_rt: kec.jumlah_rt || ''
             };
             this.modalKecamatanOpen = true;
         },

         openCreateDesa(defaultKecId = null) {
             this.isEditingDesa = false;
             this.formDesaAction = '{{ route('superadmin.wilayah.desa.store') }}';
             this.desaForm = {
                 id: null,
                 kecamatan_id: defaultKecId || '{{ $selectedKecamatanId ?? ($allKecamatans->first()->id ?? '') }}',
                 kode_desa: '',
                 nama_desa: '',
                 jumlah_rw: '',
                 jumlah_rt: ''
             };
             this.modalDesaOpen = true;
         },

         openEditDesa(desa) {
             this.isEditingDesa = true;
             this.formDesaAction = '{{ url('/superadmin/wilayah/desa') }}/' + desa.id;
             this.desaForm = {
                 id: desa.id,
                 kecamatan_id: desa.kecamatan_id,
                 kode_desa: desa.kode_desa,
                 nama_desa: desa.nama_desa,
                 jumlah_rw: desa.jumlah_rw || '',
                 jumlah_rt: desa.jumlah_rt || ''
             };
             this.modalDesaOpen = true;
         }
     }">

    {{-- ═══════════════════════════════════════════════════════════════════════════
         1. BANNER HEADER
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="bg-gradient-to-r from-purple-950 via-slate-900 to-indigo-950 rounded-3xl p-6 sm:p-8 text-white portal-shadow relative overflow-hidden">
        <div class="absolute right-0 top-0 w-96 h-96 bg-purple-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-purple-500/20 text-purple-300 border border-purple-500/30">
                    <span>👑 Super Administrator Diskominfo</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                    Master Data Kewilayahan Terintegrasi
                </h1>
                <p class="text-xs sm:text-sm text-slate-300 max-w-2xl">
                    Kelola data 39 Kecamatan, Desa/Kelurahan, estimasi jumlah RW & RT yang sinkron langsung ke tabel publik di landing page dan portal permohonan warga.
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('superadmin.dashboard') }}" class="px-4 py-2.5 rounded-xl text-xs font-bold text-white bg-white/10 hover:bg-white/20 backdrop-blur-sm transition-colors border border-white/20">
                    &larr; Dashboard Super Admin
                </a>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         2. AGGREGATE SUMMARY CARDS
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        <div class="bg-white rounded-2xl p-5 border border-slate-200 portal-shadow flex items-center justify-between">
            <div>
                <p class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Total Kecamatan</p>
                <p class="text-2xl sm:text-3xl font-extrabold text-purple-700 mt-1">{{ $stats['total_kecamatan'] }}</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center font-bold text-lg">
                🏛️
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 portal-shadow flex items-center justify-between">
            <div>
                <p class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Desa Terdata</p>
                <p class="text-2xl sm:text-3xl font-extrabold text-blue-700 mt-1">{{ $stats['total_desa'] }}</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-lg">
                🏡
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 portal-shadow flex items-center justify-between">
            <div>
                <p class="text-xs text-amber-600 font-semibold uppercase tracking-wider">Total Rukun Warga (RW)</p>
                <p class="text-2xl sm:text-3xl font-extrabold text-amber-700 mt-1">{{ number_format($stats['total_rw']) }}</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold text-lg">
                🏘️
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 portal-shadow flex items-center justify-between">
            <div>
                <p class="text-xs text-emerald-600 font-semibold uppercase tracking-wider">Total Rukun Tetangga (RT)</p>
                <p class="text-2xl sm:text-3xl font-extrabold text-emerald-700 mt-1">{{ number_format($stats['total_rt']) }}</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-lg">
                🏠
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         3. TABS NAVIGATION & CONTROLS
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="bg-white rounded-2xl border border-slate-200 portal-shadow p-5 space-y-6">

        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4 border-b border-slate-100 pb-4">
            {{-- Tabs Selector --}}
            <div class="flex items-center gap-2">
                <button type="button"
                        @click="activeTab = 'kecamatan'"
                        class="px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition-all cursor-pointer flex items-center gap-2"
                        :class="activeTab === 'kecamatan' ? 'bg-[#0a2558] text-white shadow-sm' : 'bg-slate-50 text-slate-600 hover:bg-slate-100'">
                    <span>🏛️ Data Kecamatan</span>
                    <span class="px-2 py-0.5 rounded-full text-[10px]" :class="activeTab === 'kecamatan' ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-700'">
                        {{ $stats['total_kecamatan'] }}
                    </span>
                </button>
                <button type="button"
                        @click="activeTab = 'desa'"
                        class="px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition-all cursor-pointer flex items-center gap-2"
                        :class="activeTab === 'desa' ? 'bg-[#0a2558] text-white shadow-sm' : 'bg-slate-50 text-slate-600 hover:bg-slate-100'">
                    <span>🏡 Data Desa / Kelurahan</span>
                    <span class="px-2 py-0.5 rounded-full text-[10px]" :class="activeTab === 'desa' ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-700'">
                        {{ $stats['total_desa'] }}
                    </span>
                </button>
            </div>

            {{-- Action Buttons --}}
            <div>
                <button type="button"
                        x-show="activeTab === 'kecamatan'"
                        @click="openCreateKecamatan()"
                        class="px-4 py-2 rounded-xl text-xs font-bold text-white bg-purple-600 hover:bg-purple-700 transition-colors shadow-sm flex items-center gap-2">
                    <span>+ Tambah Kecamatan Baru</span>
                </button>
                <button type="button"
                        x-show="activeTab === 'desa'"
                        @click="openCreateDesa()"
                        class="px-4 py-2 rounded-xl text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 transition-colors shadow-sm flex items-center gap-2">
                    <span>+ Tambah Desa Baru</span>
                </button>
            </div>
        </div>

        {{-- ── TAB 1: DATA KECAMATAN ────────────────────────────────────────── --}}
        <div x-show="activeTab === 'kecamatan'" class="space-y-4">

            {{-- Search Bar --}}
            <form method="GET" action="{{ route('superadmin.wilayah.index') }}" class="flex items-center gap-3">
                <input type="hidden" name="tab" value="kecamatan">
                <div class="relative flex-1 sm:max-w-md">
                    <input type="text"
                           name="q"
                           value="{{ $tab === 'kecamatan' ? $search : '' }}"
                           placeholder="Cari nama atau kode kecamatan..."
                           class="w-full pl-9 pr-4 py-2 text-xs sm:text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <button type="submit" class="px-4 py-2 text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">
                    Cari
                </button>
                @if ($search && $tab === 'kecamatan')
                    <a href="{{ route('superadmin.wilayah.index', ['tab' => 'kecamatan']) }}" class="text-xs text-rose-600 hover:underline">
                        Reset Filter
                    </a>
                @endif
            </form>

            {{-- Table Kecamatan --}}
            <div class="overflow-x-auto rounded-xl border border-slate-200">
                <table class="w-full text-xs sm:text-sm text-left border-collapse">
                    <thead class="bg-slate-50 text-slate-700 font-bold uppercase text-[11px] border-b border-slate-200">
                        <tr>
                            <th class="py-3.5 px-4">Kode</th>
                            <th class="py-3.5 px-4">Nama Kecamatan</th>
                            <th class="py-3.5 px-4 text-center">Jumlah Desa</th>
                            <th class="py-3.5 px-4 text-center">Total RW</th>
                            <th class="py-3.5 px-4 text-center">Total RT</th>
                            <th class="py-3.5 px-4">Kontak & Operasional</th>
                            <th class="py-3.5 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse ($kecamatans as $kec)
                            <tr class="hover:bg-purple-50/40 transition-colors">
                                <td class="py-3.5 px-4 font-mono font-bold text-purple-800">
                                    {{ $kec->kode_kecamatan }}
                                </td>
                                <td class="py-3.5 px-4">
                                    <p class="font-bold text-slate-900">{{ $kec->nama_kecamatan }}</p>
                                    <p class="text-[11px] text-slate-500 line-clamp-1 mt-0.5">{{ $kec->alamat_kantor ?: '-' }}</p>
                                </td>
                                <td class="py-3.5 px-4 text-center font-bold text-slate-800">
                                    {{ $kec->total_desa }}
                                </td>
                                <td class="py-3.5 px-4 text-center font-semibold text-amber-800">
                                    {{ $kec->total_rw }}
                                </td>
                                <td class="py-3.5 px-4 text-center font-semibold text-emerald-800">
                                    {{ $kec->total_rt }}
                                </td>
                                <td class="py-3.5 px-4 text-[11px] text-slate-600">
                                    <p>📞 {{ $kec->telepon ?: '-' }}</p>
                                    <p class="text-blue-600">✉️ {{ $kec->email ?: '-' }}</p>
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <button type="button"
                                                @click="openEditKecamatan({{ json_encode($kec) }})"
                                                class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-purple-50 hover:bg-purple-100 text-purple-700 transition-colors">
                                            Edit
                                        </button>
                                        <a href="{{ route('superadmin.wilayah.index', ['tab' => 'desa', 'kecamatan_id' => $kec->id]) }}"
                                           class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-blue-50 hover:bg-blue-100 text-blue-700 transition-colors">
                                            Desa
                                        </a>
                                        <form method="POST"
                                              action="{{ route('superadmin.wilayah.kecamatan.destroy', $kec) }}"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus Kecamatan {{ $kec->nama_kecamatan }}?');"
                                              class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-rose-50 hover:bg-rose-100 text-rose-700 transition-colors">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center text-slate-400">
                                    Tidak ada data kecamatan yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="pt-2">
                {{ $kecamatans->links() }}
            </div>
        </div>

        {{-- ── TAB 2: DATA DESA / KELURAHAN ─────────────────────────────────── --}}
        <div x-show="activeTab === 'desa'" class="space-y-4">

            {{-- Filter & Search Form --}}
            <form method="GET" action="{{ route('superadmin.wilayah.index') }}" class="flex flex-wrap items-center gap-3">
                <input type="hidden" name="tab" value="desa">

                {{-- Filter by Kecamatan --}}
                <div class="w-full sm:w-64">
                    <select name="kecamatan_id"
                            onchange="this.form.submit()"
                            class="w-full px-3 py-2 text-xs sm:text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 font-medium text-slate-700">
                        <option value="">-- Semua Kecamatan (39) --</option>
                        @foreach ($allKecamatans as $k)
                            <option value="{{ $k->id }}" {{ ($selectedKecamatanId == $k->id) ? 'selected' : '' }}>
                                {{ $k->nama_kecamatan }} ({{ $k->kode_kecamatan }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Search Desa --}}
                <div class="relative flex-1 sm:max-w-xs">
                    <input type="text"
                           name="q"
                           value="{{ $tab === 'desa' ? $search : '' }}"
                           placeholder="Cari nama atau kode desa..."
                           class="w-full pl-9 pr-4 py-2 text-xs sm:text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>

                <button type="submit" class="px-4 py-2 text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">
                    Filter
                </button>

                @if ($selectedKecamatanId || ($search && $tab === 'desa'))
                    <a href="{{ route('superadmin.wilayah.index', ['tab' => 'desa']) }}" class="text-xs text-rose-600 hover:underline">
                        Reset Filter
                    </a>
                @endif
            </form>

            {{-- Table Desa --}}
            <div class="overflow-x-auto rounded-xl border border-slate-200">
                <table class="w-full text-xs sm:text-sm text-left border-collapse">
                    <thead class="bg-slate-50 text-slate-700 font-bold uppercase text-[11px] border-b border-slate-200">
                        <tr>
                            <th class="py-3.5 px-4">Kecamatan Induk</th>
                            <th class="py-3.5 px-4">Kode Desa</th>
                            <th class="py-3.5 px-4">Nama Desa / Kelurahan</th>
                            <th class="py-3.5 px-4 text-center">Jumlah RW</th>
                            <th class="py-3.5 px-4 text-center">Jumlah RT</th>
                            <th class="py-3.5 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse ($desas as $d)
                            <tr class="hover:bg-emerald-50/40 transition-colors">
                                <td class="py-3.5 px-4 font-semibold text-slate-800">
                                    {{ $d->kecamatan?->nama_kecamatan ?? '-' }}
                                </td>
                                <td class="py-3.5 px-4 font-mono font-bold text-emerald-800">
                                    {{ $d->kode_desa }}
                                </td>
                                <td class="py-3.5 px-4 font-bold text-slate-900">
                                    {{ $d->nama_desa }}
                                </td>
                                <td class="py-3.5 px-4 text-center font-semibold text-amber-800">
                                    {{ $d->jumlah_rw }}
                                </td>
                                <td class="py-3.5 px-4 text-center font-semibold text-emerald-800">
                                    {{ $d->jumlah_rt }}
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <button type="button"
                                                @click="openEditDesa({{ json_encode($d) }})"
                                                class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-emerald-50 hover:bg-emerald-100 text-emerald-700 transition-colors">
                                            Edit
                                        </button>
                                        <form method="POST"
                                              action="{{ route('superadmin.wilayah.desa.destroy', $d) }}"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus Desa {{ $d->nama_desa }}?');"
                                              class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-rose-50 hover:bg-rose-100 text-rose-700 transition-colors">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-slate-400">
                                    Tidak ada data desa yang sesuai dengan kriteria filter.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="pt-2">
                {{ $desas->links() }}
            </div>
        </div>

    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         4. MODAL KECAMATAN (TAMBAH / EDIT)
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div x-show="modalKecamatanOpen"
         x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto"
         role="dialog"
         aria-modal="true">

        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs" @click="modalKecamatanOpen = false"></div>

        <div class="relative bg-white rounded-3xl shadow-2xl border border-slate-100 max-w-lg w-full p-6 z-10 my-8">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h3 class="text-base font-bold text-slate-900" x-text="isEditingKecamatan ? 'Edit Data Kecamatan' : 'Tambah Kecamatan Baru'"></h3>
                <button type="button" @click="modalKecamatanOpen = false" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg">✕</button>
            </div>

            <form :action="formKecamatanAction" method="POST" class="mt-4 space-y-4">
                @csrf
                <template x-if="isEditingKecamatan">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Kode Kecamatan *</label>
                        <input type="text" name="kode_kecamatan" x-model="kecamatanForm.kode_kecamatan" required placeholder="KEC-040"
                               class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Kecamatan *</label>
                        <input type="text" name="nama_kecamatan" x-model="kecamatanForm.nama_kecamatan" required placeholder="Contoh: Singaparna"
                               class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Alamat Kantor Kecamatan</label>
                    <textarea name="alamat_kantor" x-model="kecamatanForm.alamat_kantor" rows="2" placeholder="Jl. Raya Singaparna No. ..."
                              class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500"></textarea>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">No. Telepon Kantor</label>
                        <input type="text" name="telepon" x-model="kecamatanForm.telepon" placeholder="(0265) 541234"
                               class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Email Resmi</label>
                        <input type="email" name="email" x-model="kecamatanForm.email" placeholder="kecamatan@tasikmalayakab.go.id"
                               class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Jam Operasional Pelayanan</label>
                    <input type="text" name="jam_operasional" x-model="kecamatanForm.jam_operasional" placeholder="Senin - Jumat (08.00 - 15.30 WIB)"
                           class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500">
                </div>

                <div class="grid grid-cols-3 gap-3 pt-2 border-t border-slate-100">
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-700 mb-1">Jumlah Desa</label>
                        <input type="number" name="jumlah_desa" x-model="kecamatanForm.jumlah_desa" placeholder="10"
                               class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-700 mb-1">Jumlah RW</label>
                        <input type="number" name="jumlah_rw" x-model="kecamatanForm.jumlah_rw" placeholder="54"
                               class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-700 mb-1">Jumlah RT</label>
                        <input type="number" name="jumlah_rt" x-model="kecamatanForm.jumlah_rt" placeholder="320"
                               class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500">
                    </div>
                </div>

                <div class="pt-4 flex items-center justify-end gap-2 border-t border-slate-100">
                    <button type="button" @click="modalKecamatanOpen = false" class="px-4 py-2 text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl">Batal</button>
                    <button type="submit" class="px-5 py-2 text-xs font-bold text-white bg-purple-600 hover:bg-purple-700 rounded-xl shadow-sm">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         5. MODAL DESA (TAMBAH / EDIT)
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div x-show="modalDesaOpen"
         x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto"
         role="dialog"
         aria-modal="true">

        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs" @click="modalDesaOpen = false"></div>

        <div class="relative bg-white rounded-3xl shadow-2xl border border-slate-100 max-w-md w-full p-6 z-10 my-8">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h3 class="text-base font-bold text-slate-900" x-text="isEditingDesa ? 'Edit Data Desa / Kelurahan' : 'Tambah Desa / Kelurahan Baru'"></h3>
                <button type="button" @click="modalDesaOpen = false" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg">✕</button>
            </div>

            <form :action="formDesaAction" method="POST" class="mt-4 space-y-4">
                @csrf
                <template x-if="isEditingDesa">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Kecamatan Induk *</label>
                    <select name="kecamatan_id" x-model="desaForm.kecamatan_id" required
                            class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                        @foreach ($allKecamatans as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_kecamatan }} ({{ $k->kode_kecamatan }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Kode Desa *</label>
                        <input type="text" name="kode_desa" x-model="desaForm.kode_desa" required placeholder="3206150001"
                               class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Desa *</label>
                        <input type="text" name="nama_desa" x-model="desaForm.nama_desa" required placeholder="Manonjaya"
                               class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Jumlah RW di Desa</label>
                        <input type="number" name="jumlah_rw" x-model="desaForm.jumlah_rw" placeholder="8"
                               class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Jumlah RT di Desa</label>
                        <input type="number" name="jumlah_rt" x-model="desaForm.jumlah_rt" placeholder="42"
                               class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                    </div>
                </div>

                <div class="pt-4 flex items-center justify-end gap-2 border-t border-slate-100">
                    <button type="button" @click="modalDesaOpen = false" class="px-4 py-2 text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl">Batal</button>
                    <button type="submit" class="px-5 py-2 text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-sm">Simpan Desa</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
