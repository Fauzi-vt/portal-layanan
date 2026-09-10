@extends('layouts.app')

@section('title', 'Kewilayahan & Desa — Kecamatan ' . $kecamatan->nama_kecamatan)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8"
     x-data="{
         modalDesaOpen: false,
         isEditingDesa: false,
         formDesaAction: '{{ route('kecamatan.wilayah.desa.store') }}',
         desaForm: {
             id: null,
             kode_desa: '',
             nama_desa: '',
             jumlah_rw: '',
             jumlah_rt: ''
         },

         openCreateDesa() {
             this.isEditingDesa = false;
             this.formDesaAction = '{{ route('kecamatan.wilayah.desa.store') }}';
             this.desaForm = {
                 id: null,
                 kode_desa: '',
                 nama_desa: '',
                 jumlah_rw: '',
                 jumlah_rt: ''
             };
             this.modalDesaOpen = true;
         },

         openEditDesa(desa) {
             this.isEditingDesa = true;
             this.formDesaAction = '{{ url('/kecamatan/wilayah/desa') }}/' + desa.id;
             this.desaForm = {
                 id: desa.id,
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
    <div class="bg-gradient-to-r from-emerald-950 via-slate-900 to-teal-950 rounded-3xl p-6 sm:p-8 text-white portal-shadow relative overflow-hidden">
        <div class="absolute right-0 top-0 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                    <span>🏛️ Admin Kecamatan {{ $kecamatan->nama_kecamatan }}</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                    Pengelolaan Data Kantor & Desa Binaan
                </h1>
                <p class="text-xs sm:text-sm text-slate-300 max-w-2xl">
                    Perbarui profil kantor kecamatan, data kontak, jam layanan, serta kelola daftar desa/kelurahan yang terintegrasi langsung dengan landing page portal publik.
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('kecamatan.dashboard') }}" class="px-4 py-2.5 rounded-xl text-xs font-bold text-white bg-white/10 hover:bg-white/20 backdrop-blur-sm transition-colors border border-white/20">
                    &larr; Dashboard Kecamatan
                </a>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         2. STATS CARDS
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        <div class="bg-white rounded-2xl p-5 border border-slate-200 portal-shadow flex items-center justify-between">
            <div>
                <p class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Desa / Kelurahan</p>
                <p class="text-2xl sm:text-3xl font-extrabold text-emerald-700 mt-1">{{ $stats['total_desa'] }}</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-lg">
                🏡
            </div>
        </div>

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
                <p class="text-xs text-sky-600 font-semibold uppercase tracking-wider">Total RT</p>
                <p class="text-2xl sm:text-3xl font-extrabold text-sky-700 mt-1">{{ number_format($stats['total_rt']) }}</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center font-bold text-lg">
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
         3. MAIN CONTENT: DUA KOLOM (PROFIL KANTOR & DAFTAR DESA)
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- KOLOM KIRI: EDIT PROFIL KANTOR KECAMATAN --}}
        <div class="lg:col-span-1 bg-white rounded-2xl border border-slate-200 portal-shadow p-6 space-y-6">
            <div>
                <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <span>🏢</span>
                    <span>Profil Kantor Kecamatan</span>
                </h3>
                <p class="text-xs text-slate-500 mt-1">
                    Data ini ditampilkan pada detail pop-up tabel kecamatan di halaman utama.
                </p>
            </div>

            <form action="{{ route('kecamatan.wilayah.profil.update') }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Kode Kecamatan</label>
                    <input type="text" value="{{ $kecamatan->kode_kecamatan }}" disabled
                           class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 bg-slate-100 font-mono text-slate-500 cursor-not-allowed">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Kecamatan</label>
                    <input type="text" value="{{ $kecamatan->nama_kecamatan }}" disabled
                           class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 bg-slate-100 font-bold text-slate-700 cursor-not-allowed">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Alamat Kantor Kecamatan *</label>
                    <textarea name="alamat_kantor" rows="3" required
                              class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">{{ old('alamat_kantor', $kecamatan->alamat_kantor) }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">No. Telepon Kantor</label>
                    <input type="text" name="telepon" value="{{ old('telepon', $kecamatan->telepon) }}" placeholder="(0265) 54xxxx"
                           class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Email Resmi</label>
                    <input type="email" name="email" value="{{ old('email', $kecamatan->email) }}" placeholder="kecamatan@tasikmalayakab.go.id"
                           class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Jam Operasional Pelayanan</label>
                    <input type="text" name="jam_operasional" value="{{ old('jam_operasional', $kecamatan->jam_operasional) }}" placeholder="Senin - Jumat (08.00 - 15.30 WIB)"
                           class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                </div>

                <div class="grid grid-cols-2 gap-3 pt-2 border-t border-slate-100">
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-700 mb-1">Estimasi RW</label>
                        <input type="number" name="jumlah_rw" value="{{ old('jumlah_rw', $kecamatan->jumlah_rw) }}"
                               class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-700 mb-1">Estimasi RT</label>
                        <input type="number" name="jumlah_rt" value="{{ old('jumlah_rt', $kecamatan->jumlah_rt) }}"
                               class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                    </div>
                </div>

                <div class="pt-3">
                    <button type="submit" class="w-full py-2.5 px-4 rounded-xl text-xs font-bold text-white bg-emerald-700 hover:bg-emerald-800 transition-colors shadow-sm">
                        Simpan Perubahan Kantor
                    </button>
                </div>
            </form>
        </div>

        {{-- KOLOM KANAN: DAFTAR DESA / KELURAHAN BINAAN --}}
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 portal-shadow p-6 space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-4">
                <div>
                    <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                        <span>🏡</span>
                        <span>Daftar Desa / Kelurahan Binaan</span>
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">
                        Total {{ $desas->total() }} desa terdaftar di bawah wilayah kerja Kecamatan {{ $kecamatan->nama_kecamatan }}.
                    </p>
                </div>

                <button type="button"
                        @click="openCreateDesa()"
                        class="px-4 py-2 rounded-xl text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 transition-colors shadow-sm flex items-center gap-2">
                    <span>+ Tambah Desa Baru</span>
                </button>
            </div>

            {{-- Search Bar --}}
            <form method="GET" action="{{ route('kecamatan.wilayah.index') }}" class="flex items-center gap-3">
                <div class="relative flex-1 sm:max-w-md">
                    <input type="text"
                           name="q"
                           value="{{ $search }}"
                           placeholder="Cari nama atau kode desa..."
                           class="w-full pl-9 pr-4 py-2 text-xs sm:text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <button type="submit" class="px-4 py-2 text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">
                    Cari
                </button>
                @if ($search)
                    <a href="{{ route('kecamatan.wilayah.index') }}" class="text-xs text-rose-600 hover:underline">
                        Reset
                    </a>
                @endif
            </form>

            {{-- Table Desa --}}
            <div class="overflow-x-auto rounded-xl border border-slate-200">
                <table class="w-full text-xs sm:text-sm text-left border-collapse">
                    <thead class="bg-slate-50 text-slate-700 font-bold uppercase text-[11px] border-b border-slate-200">
                        <tr>
                            <th class="py-3 px-4">Kode Desa</th>
                            <th class="py-3 px-4">Nama Desa / Kelurahan</th>
                            <th class="py-3 px-4 text-center">Jumlah RW</th>
                            <th class="py-3 px-4 text-center">Jumlah RT</th>
                            <th class="py-3 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse ($desas as $d)
                            <tr class="hover:bg-emerald-50/40 transition-colors">
                                <td class="py-3 px-4 font-mono font-bold text-emerald-800">
                                    {{ $d->kode_desa }}
                                </td>
                                <td class="py-3 px-4 font-bold text-slate-900">
                                    {{ $d->nama_desa }}
                                </td>
                                <td class="py-3 px-4 text-center font-semibold text-amber-800">
                                    {{ $d->jumlah_rw }}
                                </td>
                                <td class="py-3 px-4 text-center font-semibold text-emerald-800">
                                    {{ $d->jumlah_rt }}
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <button type="button"
                                                @click="openEditDesa({{ json_encode($d) }})"
                                                class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-emerald-50 hover:bg-emerald-100 text-emerald-700 transition-colors">
                                            Edit
                                        </button>
                                        <form method="POST"
                                              action="{{ route('kecamatan.wilayah.desa.destroy', $d) }}"
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
                                <td colspan="5" class="py-8 text-center text-slate-400">
                                    Belum ada data desa yang terdaftar untuk kecamatan ini.
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
         4. MODAL DESA (TAMBAH / EDIT)
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div x-show="modalDesaOpen"
         x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto"
         role="dialog"
         aria-modal="true">

        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs" @click="modalDesaOpen = false"></div>

        <div class="relative bg-white rounded-3xl shadow-2xl border border-slate-100 max-w-md w-full p-6 z-10 my-8">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h3 class="text-base font-bold text-slate-900" x-text="isEditingDesa ? 'Edit Data Desa' : 'Tambah Desa Baru'"></h3>
                <button type="button" @click="modalDesaOpen = false" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg">✕</button>
            </div>

            <form :action="formDesaAction" method="POST" class="mt-4 space-y-4">
                @csrf
                <template x-if="isEditingDesa">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Kode Desa *</label>
                    <input type="text" name="kode_desa" x-model="desaForm.kode_desa" required placeholder="Contoh: 3206150001"
                           class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Desa / Kelurahan *</label>
                    <input type="text" name="nama_desa" x-model="desaForm.nama_desa" required placeholder="Contoh: Pasirbatang"
                           class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Jumlah RW</label>
                        <input type="number" name="jumlah_rw" x-model="desaForm.jumlah_rw" placeholder="8"
                               class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Jumlah RT</label>
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
