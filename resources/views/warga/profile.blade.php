@extends('layouts.warga')

@section('title', 'Profil Saya — OSS HUB Kominfo')

@section('content')
<div class="space-y-6 sm:space-y-8 max-w-5xl mx-auto" x-data="{
    activeTab: 'info',
    selectedKecamatan: '{{ old('kecamatan_id', $user->kecamatan_id) }}',
    selectedDesa: '{{ old('desa_id', $user->desa_id) }}',
    desas: {{ Js::from($desas) }},
    loadingDesas: false,
    async fetchDesas() {
        if (!this.selectedKecamatan) {
            this.desas = [];
            this.selectedDesa = '';
            return;
        }
        this.loadingDesas = true;
        try {
            const res = await fetch(`{{ url('/warga/desas') }}/${this.selectedKecamatan}`);
            this.desas = await res.json();
        } catch (e) {
            console.error(e);
        } finally {
            this.loadingDesas = false;
        }
    }
}">

    {{-- ═══════════════════════════════════════════════════════════════════════════
         PROFILE BANNER / HEADER
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="relative overflow-hidden rounded-2xl p-6 sm:p-8 text-white shadow-lg" style="background: linear-gradient(135deg, #0a2558 0%, #1a3a70 50%, #1e5799 100%)">
        <div class="absolute -top-8 -right-8 w-48 h-48 rounded-full bg-white/5 pointer-events-none"></div>
        <div class="absolute -bottom-10 -left-4 w-40 h-40 rounded-full bg-white/5 pointer-events-none"></div>

        <div class="relative flex flex-col sm:flex-row sm:items-center justify-between gap-6">
            <div class="flex items-center gap-5">
                {{-- Avatar --}}
                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-gradient-to-br from-teal-400 to-teal-600 text-white flex items-center justify-center font-extrabold text-2xl sm:text-3xl shadow-md ring-4 ring-white/20 flex-shrink-0">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div class="space-y-1">
                    <div class="flex items-center gap-2.5 flex-wrap">
                        <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-white">{{ $user->name }}</h1>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-teal-500/30 text-teal-100 border border-teal-300/30">
                            Warga / Pemohon
                        </span>
                    </div>
                    <p class="text-blue-200 text-xs sm:text-sm font-medium flex items-center gap-1.5">
                        <i data-lucide="mail" class="w-4 h-4 text-blue-300"></i>
                        {{ $user->email }}
                    </p>
                    <p class="text-blue-200 text-xs sm:text-sm font-medium flex items-center gap-1.5">
                        <i data-lucide="map-pin" class="w-4 h-4 text-blue-300"></i>
                        Desa {{ $user->desa?->nama_desa ?? '-' }}, Kec. {{ $user->kecamatan?->nama_kecamatan ?? '-' }}
                    </p>
                </div>
            </div>

            {{-- Shortcut Button --}}
            <a href="{{ route('warga.dashboard') }}"
               class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold bg-white/10 hover:bg-white/20 text-white border border-white/20 transition-all backdrop-blur-xs shrink-0 self-start sm:self-center">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Kembali ke Dashboard
            </a>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         TAB NAVIGATION
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="flex items-center gap-2 border-b border-slate-200 pb-2">
        <button type="button"
                @click="activeTab = 'info'"
                :class="activeTab === 'info' ? 'bg-[#0a2558] text-white font-bold shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100 font-medium'"
                class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm sm:text-base transition-all">
            <i data-lucide="user-pen" class="w-4 h-4"></i>
            <span>Data Pribadi & Domisili</span>
        </button>

        <button type="button"
                @click="activeTab = 'password'"
                :class="activeTab === 'password' ? 'bg-[#0a2558] text-white font-bold shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100 font-medium'"
                class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm sm:text-base transition-all">
            <i data-lucide="key-round" class="w-4 h-4"></i>
            <span>Ubah Kata Sandi</span>
        </button>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         TAB 1: INFORMASI PRIBADI & DOMISILI
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div x-show="activeTab === 'info'" x-cloak class="space-y-6">
        <form method="POST" action="{{ route('warga.profile.update') }}" class="bg-white rounded-2xl border border-slate-200/90 shadow-sm overflow-hidden">
            @csrf
            @method('PUT')

            <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                <div>
                    <h2 class="text-base sm:text-lg font-bold text-slate-900">Informasi Pribadi & Wilayah</h2>
                    <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Perbarui data diri dan domisili untuk keperluan permohonan layanan publik</p>
                </div>
                <span class="text-xs font-semibold px-2.5 py-1 rounded-lg bg-blue-50 text-blue-700 border border-blue-200">
                    Akun Warga
                </span>
            </div>

            <div class="p-6 sm:p-8 space-y-6">

                {{-- NIK (Read Only) --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 sm:gap-4 sm:items-center">
                    <label class="text-xs sm:text-sm font-bold text-slate-700">
                        Nomor Induk Kependudukan (NIK)
                    </label>
                    <div class="sm:col-span-2">
                        <div class="relative">
                            <input type="text"
                                   value="{{ $user->nik }}"
                                   disabled
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-100 text-slate-600 font-mono text-sm sm:text-base font-bold cursor-not-allowed">
                            <span class="absolute right-3.5 top-1/2 -translate-y-1/2 text-xs font-semibold text-slate-400 flex items-center gap-1">
                                <i data-lucide="lock" class="w-3.5 h-3.5"></i>
                                Terkunci
                            </span>
                        </div>
                        <p class="text-xs text-slate-400 mt-1">NIK terdaftar secara permanen dan tidak dapat diubah sendiri demi keamanan identitas.</p>
                    </div>
                </div>

                {{-- Nama Lengkap --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 sm:gap-4 sm:items-center">
                    <label for="name" class="text-xs sm:text-sm font-bold text-slate-700">
                        Nama Lengkap <span class="text-rose-500">*</span>
                    </label>
                    <div class="sm:col-span-2">
                        <input type="text"
                               name="name"
                               id="name"
                               value="{{ old('name', $user->name) }}"
                               required
                               class="w-full px-4 py-2.5 rounded-xl border @error('name') border-rose-300 ring-2 ring-rose-100 @else border-slate-200 @enderror bg-white text-slate-800 text-sm sm:text-base font-medium focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('name')
                            <p class="text-xs text-rose-600 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Email --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 sm:gap-4 sm:items-center">
                    <label for="email" class="text-xs sm:text-sm font-bold text-slate-700">
                        Alamat Email <span class="text-rose-500">*</span>
                    </label>
                    <div class="sm:col-span-2">
                        <input type="email"
                               name="email"
                               id="email"
                               value="{{ old('email', $user->email) }}"
                               required
                               class="w-full px-4 py-2.5 rounded-xl border @error('email') border-rose-300 ring-2 ring-rose-100 @else border-slate-200 @enderror bg-white text-slate-800 text-sm sm:text-base font-medium focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('email')
                            <p class="text-xs text-rose-600 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Nomor Telepon --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 sm:gap-4 sm:items-center">
                    <label for="phone" class="text-xs sm:text-sm font-bold text-slate-700">
                        Nomor HP / WhatsApp
                    </label>
                    <div class="sm:col-span-2">
                        <input type="tel"
                               name="phone"
                               id="phone"
                               placeholder="Contoh: 081234567890"
                               value="{{ old('phone', $user->phone) }}"
                               class="w-full px-4 py-2.5 rounded-xl border @error('phone') border-rose-300 ring-2 ring-rose-100 @else border-slate-200 @enderror bg-white text-slate-800 text-sm sm:text-base font-medium focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('phone')
                            <p class="text-xs text-rose-600 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Kecamatan --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 sm:gap-4 sm:items-center">
                    <label for="kecamatan_id" class="text-xs sm:text-sm font-bold text-slate-700">
                        Kecamatan Domisili
                    </label>
                    <div class="sm:col-span-2">
                        <select name="kecamatan_id"
                                id="kecamatan_id"
                                x-model="selectedKecamatan"
                                @change="fetchDesas()"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-800 text-sm sm:text-base font-medium focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">-- Pilih Kecamatan --</option>
                            @foreach ($kecamatans as $kec)
                                <option value="{{ $kec->id }}">Kecamatan {{ $kec->nama_kecamatan }}</option>
                            @endforeach
                        </select>
                        @error('kecamatan_id')
                            <p class="text-xs text-rose-600 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Desa / Kelurahan --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 sm:gap-4 sm:items-center">
                    <label for="desa_id" class="text-xs sm:text-sm font-bold text-slate-700">
                        Desa / Kelurahan
                    </label>
                    <div class="sm:col-span-2">
                        <div class="relative">
                            <select name="desa_id"
                                    id="desa_id"
                                    x-model="selectedDesa"
                                    :disabled="loadingDesas || !selectedKecamatan"
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-800 text-sm sm:text-base font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:bg-slate-100 disabled:cursor-not-allowed">
                                <option value="">-- Pilih Desa / Kelurahan --</option>
                                <template x-for="d in desas" :key="d.id">
                                    <option :value="d.id" x-text="d.nama_desa" :selected="d.id == selectedDesa"></option>
                                </template>
                            </select>
                            <span x-show="loadingDesas" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-xs text-blue-600 font-semibold flex items-center gap-1">
                                <i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i>
                                Memuat...
                            </span>
                        </div>
                        @error('desa_id')
                            <p class="text-xs text-rose-600 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Alamat Detail --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 sm:gap-4 sm:items-start">
                    <label for="alamat_detail" class="text-xs sm:text-sm font-bold text-slate-700 sm:pt-2">
                        Alamat Lengkap / Jalan
                    </label>
                    <div class="sm:col-span-2">
                        <textarea name="alamat_detail"
                                  id="alamat_detail"
                                  rows="3"
                                  placeholder="Contoh: Jl. Raya Manonjaya No. 12, RT 02 / RW 04"
                                  class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-800 text-sm sm:text-base font-medium focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('alamat_detail', $user->alamat_detail) }}</textarea>
                        @error('alamat_detail')
                            <p class="text-xs text-rose-600 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

            </div>

            {{-- Form Footer Action --}}
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-3">
                <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-[#0a2558] hover:bg-[#0d3070] text-white text-sm sm:text-base font-bold shadow-md hover:shadow-lg transition-all">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         TAB 2: UBAH KATA SANDI
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div x-show="activeTab === 'password'" x-cloak class="space-y-6">
        <form method="POST" action="{{ route('warga.profile.password') }}" class="bg-white rounded-2xl border border-slate-200/90 shadow-sm overflow-hidden">
            @csrf
            @method('PUT')

            <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50">
                <h2 class="text-base sm:text-lg font-bold text-slate-900">Ubah Kata Sandi Akun</h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Pastikan menggunakan kata sandi yang kuat dan aman untuk melindungi akun Anda</p>
            </div>

            <div class="p-6 sm:p-8 space-y-6">

                {{-- Kata Sandi Saat Ini --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 sm:gap-4 sm:items-center">
                    <label for="current_password" class="text-xs sm:text-sm font-bold text-slate-700">
                        Kata Sandi Saat Ini <span class="text-rose-500">*</span>
                    </label>
                    <div class="sm:col-span-2">
                        <input type="password"
                               name="current_password"
                               id="current_password"
                               required
                               placeholder="Masukkan kata sandi lama Anda"
                               class="w-full px-4 py-2.5 rounded-xl border @error('current_password') border-rose-300 ring-2 ring-rose-100 @else border-slate-200 @enderror bg-white text-slate-800 text-sm sm:text-base font-medium focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('current_password')
                            <p class="text-xs text-rose-600 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Kata Sandi Baru --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 sm:gap-4 sm:items-center">
                    <label for="password" class="text-xs sm:text-sm font-bold text-slate-700">
                        Kata Sandi Baru <span class="text-rose-500">*</span>
                    </label>
                    <div class="sm:col-span-2">
                        <input type="password"
                               name="password"
                               id="password"
                               required
                               placeholder="Minimal 8 karakter"
                               class="w-full px-4 py-2.5 rounded-xl border @error('password') border-rose-300 ring-2 ring-rose-100 @else border-slate-200 @enderror bg-white text-slate-800 text-sm sm:text-base font-medium focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('password')
                            <p class="text-xs text-rose-600 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Konfirmasi Kata Sandi Baru --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 sm:gap-4 sm:items-center">
                    <label for="password_confirmation" class="text-xs sm:text-sm font-bold text-slate-700">
                        Ulangi Kata Sandi Baru <span class="text-rose-500">*</span>
                    </label>
                    <div class="sm:col-span-2">
                        <input type="password"
                               name="password_confirmation"
                               id="password_confirmation"
                               required
                               placeholder="Ketik ulang kata sandi baru"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-800 text-sm sm:text-base font-medium focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

            </div>

            {{-- Form Footer Action --}}
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-3">
                <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-[#0a2558] hover:bg-[#0d3070] text-white text-sm sm:text-base font-bold shadow-md hover:shadow-lg transition-all">
                    <i data-lucide="key" class="w-4 h-4"></i>
                    <span>Perbarui Kata Sandi</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
