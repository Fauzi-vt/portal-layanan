@php
    // Siapkan daftar kecamatan beserta desa untuk autocomplete otomatis
    $kecamatanMap = ($kecamatans ?? collect())->mapWithKeys(function($k) {
        return [
            strtoupper($k->nama_kecamatan) => $k->desas ? $k->desas->pluck('nama_desa')->map(fn($d) => strtoupper($d))->values() : []
        ];
    });
@endphp

<div x-data="kkBaruComponent({
    userName: @js($user->name),
    userNik: @js($user->nik ?? ''),
    userPhone: @js($user->phone ?? ''),
    userEmail: @js($user->email ?? ''),
    userAlamat: @js($user->alamat_detail ?? ''),
    kecamatanName: @js($user->kecamatan?->nama_kecamatan ?? 'SINGAPARNA'),
    desaName: @js($user->desa?->nama_desa ?? ''),
    kecamatanMap: @js($kecamatanMap)
})" class="bg-white rounded-2xl border border-slate-200 shadow-md overflow-hidden space-y-0 transition-all font-sans">

    {{-- ═══════════════════════════════════════════════════════════════════════
         HEADER FORMULIR DIGITAL KK BARU
    ═══════════════════════════════════════════════════════════════════════ --}}
    <div class="p-6 bg-gradient-to-r from-blue-900 via-indigo-900 to-slate-900 text-white flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-400/20 border border-blue-400/30 text-blue-200 text-xs font-bold uppercase tracking-wider mb-2">
                <svg class="w-4 h-4 text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span>Formulir Digital Kartu Keluarga</span>
            </div>
            <h2 class="text-xl sm:text-2xl font-black tracking-wide text-white uppercase">
                FORMULIR PEMBUATAN KARTU KELUARGA BARU
            </h2>
            <p class="text-xs text-blue-100/80 mt-1 max-w-2xl leading-relaxed">
                Pengisian formulir digital terpadu dengan otomatisasi alamat wilayah dan tabel data anggota keluarga yang fleksibel.
            </p>
        </div>

        <div class="flex items-center gap-3 bg-white/10 backdrop-blur-md px-4 py-3 rounded-2xl border border-white/15">
            <div class="text-right">
                <span class="block text-[11px] text-blue-200 font-medium">Total Terdaftar</span>
                <span class="text-sm font-black text-white" x-text="anggota.length + ' Anggota Keluarga'"></span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-blue-500 text-white flex items-center justify-center font-black text-base shadow-sm">
                <span x-text="anggota.length"></span>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════
         BAGIAN 1: TABEL ALAMAT RUMAH & WILAYAH (OTOMATISASI KECAMATAN / KAB / PROV / NEGARA)
    ═══════════════════════════════════════════════════════════════════════ --}}
    <div class="p-6 bg-slate-50/80 border-b border-slate-200 space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
            <h3 class="text-xs font-black uppercase tracking-wider text-slate-800 flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                <span>Data Kepala Keluarga & Wilayah Alamat Rumah</span>
            </h3>
            <span class="text-[11px] text-emerald-700 font-bold bg-emerald-50 border border-emerald-200 px-2.5 py-1 rounded-lg flex items-center gap-1.5 self-start sm:self-auto">
                <span>⚡</span>
                <span>Otomatisasi Wilayah Aktif (Dapat diedit bebas oleh pemohon)</span>
            </span>
        </div>

        {{-- Grid Tabular 4 Kolom untuk Alamat & Wilayah --}}
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-4 text-xs">
            {{-- Baris 1: Nama Kepala Keluarga & Alamat Jalan --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-2">
                    <label class="block font-bold text-slate-800 mb-1">
                        Nama Kepala Keluarga <span class="text-rose-600">*</span>
                    </label>
                    <input type="text"
                           name="form_data[f101][nama_kepala_keluarga]"
                           x-model="meta.nama_kepala_keluarga"
                           required
                           placeholder="Contoh: AHMAD FAUZI"
                           class="w-full text-xs font-bold uppercase rounded-xl border-slate-300 py-2.5 px-3 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                    <input type="hidden" name="form_data[f101][nama_pemohon]" :value="meta.nama_kepala_keluarga">
                </div>

                <div class="md:col-span-2">
                    <label class="block font-bold text-slate-800 mb-1">
                        Alamat Tempat Tinggal (Jalan / Dusun / Kampung) <span class="text-rose-600">*</span>
                    </label>
                    <input type="text"
                           name="form_data[f101][alamat]"
                           x-model="meta.alamat"
                           required
                           placeholder="Contoh: Jl. Pahlawan No. 45, Dusun Sukamaju"
                           class="w-full text-xs font-medium uppercase rounded-xl border-slate-300 py-2.5 px-3 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                </div>
            </div>

            {{-- Baris 2: RT/RW, Kode Pos, Kecamatan (Auto-trigger), Desa --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                {{-- Kolom 1: RT / RW --}}
                <div>
                    <label class="block font-bold text-slate-800 mb-1">
                        RT / RW <span class="text-rose-600 font-bold" aria-hidden="true">*</span>
                    </label>
                    <div class="flex items-center gap-1.5 p-1 bg-white rounded-xl border border-slate-300 shadow-2xs">
                        <div class="flex-1 flex items-center gap-1 pl-1.5">
                            <span class="text-[10px] font-bold text-slate-500 shrink-0">RT</span>
                            <input type="text"
                                   name="form_data[f101][rt]"
                                   x-model="meta.rt"
                                   @input="meta.rt = ($event.target.value || '').replace(/\D/g, '').slice(0, 3)"
                                   @blur="meta.rt = meta.rt ? meta.rt.padStart(3, '0').slice(-3) : '001'"
                                   inputmode="numeric"
                                   maxlength="3"
                                   placeholder="001"
                                   class="w-full font-mono text-center text-xs font-bold py-1.5 px-1 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 focus:bg-white focus:ring-1 focus:ring-blue-600 focus:border-blue-600 focus:outline-none">
                        </div>
                        <span class="text-slate-300 font-bold">/</span>
                        <div class="flex-1 flex items-center gap-1 pr-1.5">
                            <span class="text-[10px] font-bold text-slate-500 shrink-0">RW</span>
                            <input type="text"
                                   name="form_data[f101][rw]"
                                   x-model="meta.rw"
                                   @input="meta.rw = ($event.target.value || '').replace(/\D/g, '').slice(0, 3)"
                                   @blur="meta.rw = meta.rw ? meta.rw.padStart(3, '0').slice(-3) : '001'"
                                   inputmode="numeric"
                                   maxlength="3"
                                   placeholder="001"
                                   class="w-full font-mono text-center text-xs font-bold py-1.5 px-1 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 focus:bg-white focus:ring-1 focus:ring-blue-600 focus:border-blue-600 focus:outline-none">
                        </div>
                    </div>
                </div>

                {{-- Kolom 2: Kode Pos --}}
                <div>
                    <label class="block font-bold text-slate-800 mb-1">
                        Kode Pos <span class="text-rose-600 font-bold" aria-hidden="true">*</span>
                    </label>
                    <input type="text"
                           name="form_data[f101][kode_pos]"
                           x-model="meta.kode_pos"
                           @input="meta.kode_pos = ($event.target.value || '').replace(/\D/g, '').slice(0, 5)"
                           inputmode="numeric"
                           maxlength="5"
                           placeholder="Contoh: 46182"
                           class="w-full font-mono text-center text-xs font-bold rounded-xl border border-slate-300 py-2.5 px-3 bg-white text-slate-900 placeholder:font-sans placeholder:font-normal placeholder:text-slate-400 focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 focus:outline-none shadow-2xs">
                </div>

                {{-- Kolom 3: Kecamatan (Otomatis memicu Kabupaten, Provinsi, Negara) --}}
                <div>
                    <label class="block font-bold text-slate-800 mb-1 flex items-center justify-between">
                        <span>Kecamatan <span class="text-rose-600">*</span></span>
                        <span class="text-[10px] text-blue-600 font-semibold">Pilih/Ketik</span>
                    </label>
                    <input type="text"
                           name="form_data[f101][nama_kecamatan]"
                           x-model="meta.kecamatan"
                           @input="onKecamatanInput()"
                           @change="onKecamatanInput()"
                           list="list-kecamatan-auto"
                           placeholder="Ketik Kecamatan, misal: Singaparna"
                           class="w-full text-xs font-bold uppercase rounded-xl border-slate-300 py-2.5 px-3 bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600 shadow-2xs">
                    <datalist id="list-kecamatan-auto">
                        @foreach ($kecamatans ?? [] as $kec)
                            <option value="{{ strtoupper($kec->nama_kecamatan) }}"></option>
                        @endforeach
                    </datalist>
                </div>

                {{-- Kolom 4: Desa / Kelurahan --}}
                <div>
                    <label class="block font-bold text-slate-800 mb-1 flex items-center justify-between">
                        <span>Desa / Kelurahan <span class="text-rose-600">*</span></span>
                        <span class="text-[10px] text-slate-400 font-normal">Pilih/Ketik</span>
                    </label>
                    <input type="text"
                           name="form_data[f101][nama_desa]"
                           x-model="meta.desa"
                           list="list-desa-auto"
                           placeholder="Nama Desa/Kelurahan"
                           class="w-full text-xs font-bold uppercase rounded-xl border-slate-300 py-2.5 px-3 bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600 shadow-2xs">
                    <datalist id="list-desa-auto">
                        <template x-for="desa in availableDesas" :key="desa">
                            <option :value="desa"></option>
                        </template>
                    </datalist>
                </div>
            </div>

            {{-- Baris 3: Otomatisasi Wilayah (Kabupaten, Provinsi, Negara) - TIDAK PATEN & BEBAS DIEDIT USER --}}
            <div class="pt-3 border-t border-slate-100">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    {{-- Kabupaten / Kota --}}
                    <div>
                        <label class="block font-bold text-slate-700 mb-1 flex items-center justify-between">
                            <span>Kabupaten / Kota</span>
                            <span class="text-[10px] text-slate-400 font-normal">Dapat diedit bebas</span>
                        </label>
                        <div class="relative">
                            <input type="text"
                                   name="form_data[f101][nama_kabupaten]"
                                   x-model="meta.kabupaten"
                                   placeholder="Contoh: KABUPATEN TASIKMALAYA"
                                   class="w-full text-xs font-bold uppercase rounded-xl border-slate-300 py-2 px-3 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                            <span class="absolute right-2.5 top-2.5 text-slate-400 text-xs">✏️</span>
                        </div>
                    </div>

                    {{-- Provinsi --}}
                    <div>
                        <label class="block font-bold text-slate-700 mb-1 flex items-center justify-between">
                            <span>Provinsi</span>
                            <span class="text-[10px] text-slate-400 font-normal">Dapat diedit bebas</span>
                        </label>
                        <div class="relative">
                            <input type="text"
                                   name="form_data[f101][nama_provinsi]"
                                   x-model="meta.provinsi"
                                   placeholder="Contoh: JAWA BARAT"
                                   class="w-full text-xs font-bold uppercase rounded-xl border-slate-300 py-2 px-3 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                            <span class="absolute right-2.5 top-2.5 text-slate-400 text-xs">✏️</span>
                        </div>
                    </div>

                    {{-- Negara --}}
                    <div>
                        <label class="block font-bold text-slate-700 mb-1 flex items-center justify-between">
                            <span>Negara</span>
                            <span class="text-[10px] text-slate-400 font-normal">Dapat diedit bebas</span>
                        </label>
                        <div class="relative">
                            <input type="text"
                                   name="form_data[f101][negara]"
                                   x-model="meta.negara"
                                   placeholder="INDONESIA"
                                   class="w-full text-xs font-bold uppercase rounded-xl border-slate-300 py-2 px-3 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                            <span class="absolute right-2.5 top-2.5 text-slate-400 text-xs">✏️</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════
         BAGIAN 2: DAFTAR ANGGOTA KELUARGA (TABEL MODERN & USER FRIENDLY)
    ═══════════════════════════════════════════════════════════════════════ --}}
    <div class="p-6 space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-sm font-black text-slate-900 uppercase tracking-wide flex items-center gap-2">
                    <span>👨‍👩‍👧‍👦</span>
                    <span>Tabel Daftar Anggota Keluarga Pemohon</span>
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">
                    Tambahkan setiap anggota keluarga yang akan tercantum dalam Kartu Keluarga Baru.
                </p>
            </div>

            <button type="button"
                    x-show="!showMemberForm"
                    @click="openAddMember()"
                    class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-md shadow-blue-500/20 transition-all transform hover:-translate-y-0.5 self-start sm:self-auto">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                <span>+ Tambah Anggota Keluarga</span>
            </button>
        </div>

        {{-- FORMULIR TABULAR 4 KOLOM PENGISIAN ANGGOTA (TERORGANISIR & MUDAH) --}}
        <div x-show="showMemberForm"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 -translate-y-3"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="bg-blue-50/70 border-2 border-blue-400 rounded-2xl p-5 sm:p-6 space-y-5 shadow-sm"
             style="display: none;">

            {{-- Form Header --}}
            <div class="flex items-center justify-between border-b border-blue-200 pb-3">
                <div class="flex items-center gap-3">
                    <span class="w-9 h-9 rounded-xl bg-blue-600 text-white font-black flex items-center justify-center text-sm shadow-xs">
                        <span x-text="editingIndex !== null ? (editingIndex + 1) : (anggota.length + 1)"></span>
                    </span>
                    <div>
                        <h4 class="font-extrabold text-slate-900 text-sm"
                            x-text="editingIndex !== null ? '✏️ Ubah Data Anggota Keluarga' : '📝 Input Anggota Keluarga Baru (Formulir 4 Kolom)'">
                        </h4>
                        <p class="text-[11px] text-blue-700">
                            Lengkapi 17 kolom isian di bawah, lalu klik <strong>"Terapkan ke Tabel (Apply)"</strong>.
                        </p>
                    </div>
                </div>

                <button type="button"
                        @click="showMemberForm = false"
                        class="text-xs font-bold text-slate-500 hover:text-slate-800 px-3 py-1.5 rounded-lg hover:bg-slate-200 transition-colors">
                    ✕ Batal
                </button>
            </div>

            {{-- Error Banner --}}
            <div x-show="validationError"
                 x-transition
                 class="p-3 bg-rose-50 border border-rose-300 text-rose-800 rounded-xl text-xs flex items-center gap-2">
                <svg class="w-4 h-4 text-rose-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <span class="font-bold" x-text="validationError"></span>
            </div>

            {{-- FORMULIR TABULAR 4 KOLOM --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 text-xs">

                {{-- KOLOM 1: IDENTITAS POKOK --}}
                <div class="bg-white p-4 rounded-xl border border-slate-200 space-y-3 shadow-2xs">
                    <div class="border-b border-slate-100 pb-2 flex items-center gap-2 text-blue-800 font-bold">
                        <span class="w-5 h-5 rounded-md bg-blue-100 text-blue-700 flex items-center justify-center text-[10px]">1</span>
                        <span>Identitas Pokok</span>
                    </div>

                    {{-- (1) Nama Lengkap --}}
                    <div>
                        <label class="block font-bold text-slate-800 mb-1">
                            (1) Nama Lengkap <span class="text-rose-600">*</span>
                        </label>
                        <input type="text"
                               x-model="formMember.nama"
                               placeholder="Nama Sesuai KTP"
                               class="w-full text-xs font-bold uppercase rounded-lg border-slate-300 py-2 px-2.5 bg-slate-50/50 focus:bg-white focus:ring-1 focus:ring-blue-600">
                    </div>

                    {{-- (2) NIK --}}
                    <div>
                        <label class="block font-bold text-slate-800 mb-1 flex items-center justify-between">
                            <span>(2) NIK (16 Digit) <span class="text-rose-600">*</span></span>
                            <span class="font-mono text-[10px]" :class="formMember.nik.length === 16 ? 'text-emerald-600 font-bold' : 'text-slate-400'" x-text="formMember.nik.length + '/16'"></span>
                        </label>
                        <input type="text"
                               x-model="formMember.nik"
                               @input="formMember.nik = formMember.nik.replace(/[^0-9]/g, '').slice(0,16)"
                               placeholder="16 digit angka"
                               class="w-full font-mono text-xs font-bold text-blue-900 rounded-lg border-slate-300 py-2 px-2.5 bg-slate-50/50 focus:bg-white focus:ring-1 focus:ring-blue-600">
                    </div>

                    {{-- (3) Jenis Kelamin --}}
                    <div>
                        <label class="block font-bold text-slate-800 mb-1">
                            (3) Jenis Kelamin <span class="text-rose-600">*</span>
                        </label>
                        <select x-model="formMember.jenis_kelamin" class="w-full text-xs font-bold rounded-lg border-slate-300 py-2 px-2.5 bg-slate-50/50 focus:bg-white focus:ring-1 focus:ring-blue-600">
                            <option value="LAKI-LAKI">LAKI-LAKI</option>
                            <option value="PEREMPUAN">PEREMPUAN</option>
                        </select>
                    </div>

                    {{-- (9) Golongan Darah --}}
                    <div>
                        <label class="block font-bold text-slate-800 mb-1">
                            (9) Golongan Darah <span class="text-rose-600">*</span>
                        </label>
                        <select x-model="formMember.gol_darah" class="w-full text-xs font-bold rounded-lg border-slate-300 py-2 px-2.5 bg-slate-50/50 focus:bg-white focus:ring-1 focus:ring-blue-600">
                            <option value="-">- (TIDAK TAHU)</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="AB">AB</option>
                            <option value="O">O</option>
                        </select>
                    </div>
                </div>

                {{-- KOLOM 2: KELAHIRAN & AGAMA --}}
                <div class="bg-white p-4 rounded-xl border border-slate-200 space-y-3 shadow-2xs">
                    <div class="border-b border-slate-100 pb-2 flex items-center gap-2 text-emerald-800 font-bold">
                        <span class="w-5 h-5 rounded-md bg-emerald-100 text-emerald-700 flex items-center justify-center text-[10px]">2</span>
                        <span>Kelahiran & Agama</span>
                    </div>

                    {{-- (4) Tempat Lahir --}}
                    <div>
                        <label class="block font-bold text-slate-800 mb-1">
                            (4) Tempat Lahir <span class="text-rose-600">*</span>
                        </label>
                        <input type="text"
                               x-model="formMember.tempat_lahir"
                               placeholder="Kota/Kabupaten Lahir"
                               class="w-full text-xs font-medium uppercase rounded-lg border-slate-300 py-2 px-2.5 bg-slate-50/50 focus:bg-white focus:ring-1 focus:ring-blue-600">
                    </div>

                    {{-- (5) Tanggal Lahir --}}
                    <div>
                        <label class="block font-bold text-slate-800 mb-1 flex items-center justify-between">
                            <span>(5) Tanggal Lahir <span class="text-rose-600">*</span></span>
                            <span class="text-[10px] text-blue-600 font-bold" x-text="calculateAge(formMember.tanggal_lahir)"></span>
                        </label>
                        <input type="date"
                               x-model="formMember.tanggal_lahir"
                               class="w-full text-xs font-bold rounded-lg border-slate-300 py-2 px-2.5 bg-slate-50/50 focus:bg-white focus:ring-1 focus:ring-blue-600">
                    </div>

                    {{-- (6) Agama --}}
                    <div>
                        <label class="block font-bold text-slate-800 mb-1">
                            (6) Agama <span class="text-rose-600">*</span>
                        </label>
                        <select x-model="formMember.agama" class="w-full text-xs font-semibold rounded-lg border-slate-300 py-2 px-2.5 bg-slate-50/50 focus:bg-white focus:ring-1 focus:ring-blue-600">
                            <option value="ISLAM">ISLAM</option>
                            <option value="KRISTEN PROTESTAN">KRISTEN PROTESTAN</option>
                            <option value="KATOLIK">KATOLIK</option>
                            <option value="HINDU">HINDU</option>
                            <option value="BUDDHA">BUDDHA</option>
                            <option value="KHONGHUCU">KHONGHUCU</option>
                        </select>
                    </div>

                    {{-- (7) Pendidikan Terakhir --}}
                    <div>
                        <label class="block font-bold text-slate-800 mb-1">
                            (7) Pendidikan Terakhir <span class="text-rose-600">*</span>
                        </label>
                        <select x-model="formMember.pendidikan" class="w-full text-xs font-semibold rounded-lg border-slate-300 py-2 px-2.5 bg-slate-50/50 focus:bg-white focus:ring-1 focus:ring-blue-600">
                            <option value="TIDAK / BELUM SEKOLAH">TIDAK / BELUM SEKOLAH</option>
                            <option value="BELUM TAMAT SD/SEDERAJAT">BELUM TAMAT SD/SEDERAJAT</option>
                            <option value="TAMAT SD / SEDERAJAT">TAMAT SD / SEDERAJAT</option>
                            <option value="SLTP/SEDERAJAT">SLTP/SEDERAJAT</option>
                            <option value="SLTA / SEDERAJAT">SLTA / SEDERAJAT</option>
                            <option value="DIPLOMA I / II">DIPLOMA I / II</option>
                            <option value="AKADEMI/DIPLOMA III/S.MUDA">AKADEMI/DIPLOMA III/S.MUDA</option>
                            <option value="DIPLOMA IV/ STRATA I">DIPLOMA IV/ STRATA I</option>
                            <option value="STRATA II">STRATA II</option>
                            <option value="STRATA III">STRATA III</option>
                        </select>
                    </div>
                </div>

                {{-- KOLOM 3: PEKERJAAN & HUBUNGAN KELUARGA --}}
                <div class="bg-white p-4 rounded-xl border border-slate-200 space-y-3 shadow-2xs">
                    <div class="border-b border-slate-100 pb-2 flex items-center gap-2 text-amber-800 font-bold">
                        <span class="w-5 h-5 rounded-md bg-amber-100 text-amber-700 flex items-center justify-center text-[10px]">3</span>
                        <span>Pekerjaan & Hubungan</span>
                    </div>

                    {{-- (8) Jenis Pekerjaan --}}
                    <div>
                        <label class="block font-bold text-slate-800 mb-1">
                            (8) Jenis Pekerjaan <span class="text-rose-600">*</span>
                        </label>
                        <input type="text"
                               x-model="formMember.pekerjaan"
                               placeholder="Contoh: Wiraswasta"
                               class="w-full text-xs font-bold uppercase rounded-lg border-slate-300 py-2 px-2.5 bg-slate-50/50 focus:bg-white focus:ring-1 focus:ring-blue-600">
                        <div class="flex flex-wrap gap-1 mt-1.5">
                            <template x-for="job in ['WIRASWASTA', 'KARYAWAN SWASTA', 'PELAJAR', 'IRT', 'PNS']" :key="job">
                                <button type="button"
                                        @click="formMember.pekerjaan = (job === 'IRT' ? 'MENGURUS RUMAH TANGGA' : (job === 'PELAJAR' ? 'PELAJAR/MAHASISWA' : job))"
                                        class="px-1.5 py-0.5 rounded text-[9px] bg-slate-100 hover:bg-blue-100 text-slate-600"
                                        x-text="job">
                                </button>
                            </template>
                        </div>
                    </div>

                    {{-- (12) SHDK --}}
                    <div>
                        <label class="block font-bold text-slate-800 mb-1">
                            (12) Hubungan Keluarga (SHDK) <span class="text-rose-600">*</span>
                        </label>
                        <select x-model="formMember.shdk" class="w-full text-xs font-bold rounded-lg border-slate-300 py-2 px-2.5 bg-slate-50/50 focus:bg-white focus:ring-1 focus:ring-blue-600">
                            <option value="KEPALA KELUARGA">KEPALA KELUARGA</option>
                            <option value="SUAMI">SUAMI</option>
                            <option value="ISTRI">ISTRI</option>
                            <option value="ANAK">ANAK</option>
                            <option value="MENANTU">MENANTU</option>
                            <option value="CUCU">CUCU</option>
                            <option value="ORANG TUA">ORANG TUA</option>
                            <option value="MERTUA">MERTUA</option>
                            <option value="FAMILI LAIN">FAMILI LAIN</option>
                            <option value="LAINNYA">LAINNYA</option>
                        </select>
                    </div>

                    {{-- (10) Status Perkawinan --}}
                    <div>
                        <label class="block font-bold text-slate-800 mb-1">
                            (10) Status Perkawinan <span class="text-rose-600">*</span>
                        </label>
                        <select x-model="formMember.status_kawin" class="w-full text-xs font-bold rounded-lg border-slate-300 py-2 px-2.5 bg-slate-50/50 focus:bg-white focus:ring-1 focus:ring-blue-600">
                            <option value="BELUM KAWIN">BELUM KAWIN</option>
                            <option value="KAWIN TERCATAT">KAWIN TERCATAT</option>
                            <option value="KAWIN BELUM TERCATAT">KAWIN BELUM TERCATAT</option>
                            <option value="CERAI HIDUP">CERAI HIDUP</option>
                            <option value="CERAI MATI">CERAI MATI</option>
                        </select>
                    </div>

                    {{-- (11) Tanggal Perkawinan --}}
                    <div>
                        <label class="block font-bold text-slate-800 mb-1 flex items-center justify-between">
                            <span>(11) Tanggal Perkawinan</span>
                            <span class="text-[10px] text-slate-400 font-normal">Bila kawin</span>
                        </label>
                        <input type="date"
                               x-model="formMember.tgl_kawin"
                               class="w-full text-xs font-medium rounded-lg border-slate-300 py-2 px-2.5 bg-slate-50/50 focus:bg-white focus:ring-1 focus:ring-blue-600">
                    </div>
                </div>

                {{-- KOLOM 4: ORANG TUA & KEWARGANEGARAAN --}}
                <div class="bg-white p-4 rounded-xl border border-slate-200 space-y-3 shadow-2xs">
                    <div class="border-b border-slate-100 pb-2 flex items-center gap-2 text-purple-800 font-bold">
                        <span class="w-5 h-5 rounded-md bg-purple-100 text-purple-700 flex items-center justify-center text-[10px]">4</span>
                        <span>Orang Tua & Imigrasi</span>
                    </div>

                    {{-- (16) Nama Ayah --}}
                    <div>
                        <label class="block font-bold text-slate-800 mb-1">
                            (16) Nama Ayah Kandung <span class="text-rose-600">*</span>
                        </label>
                        <input type="text"
                               x-model="formMember.nama_ayah"
                               placeholder="Nama Ayah Sesuai Akta"
                               class="w-full text-xs font-bold uppercase rounded-lg border-slate-300 py-2 px-2.5 bg-slate-50/50 focus:bg-white focus:ring-1 focus:ring-blue-600">
                    </div>

                    {{-- (17) Nama Ibu --}}
                    <div>
                        <label class="block font-bold text-slate-800 mb-1">
                            (17) Nama Ibu Kandung <span class="text-rose-600">*</span>
                        </label>
                        <input type="text"
                               x-model="formMember.nama_ibu"
                               placeholder="Nama Ibu Sesuai Akta"
                               class="w-full text-xs font-bold uppercase rounded-lg border-slate-300 py-2 px-2.5 bg-slate-50/50 focus:bg-white focus:ring-1 focus:ring-blue-600">
                    </div>

                    {{-- (13) Kewarganegaraan --}}
                    <div>
                        <label class="block font-bold text-slate-800 mb-1">
                            (13) Kewarganegaraan <span class="text-rose-600">*</span>
                        </label>
                        <select x-model="formMember.kewarganegaraan" class="w-full text-xs font-bold rounded-lg border-slate-300 py-2 px-2.5 bg-slate-50/50 focus:bg-white focus:ring-1 focus:ring-blue-600">
                            <option value="WNI">WNI (Indonesia)</option>
                            <option value="WNA">WNA (Asing)</option>
                        </select>
                    </div>

                    {{-- (14 & 15) Paspor & KITAP (Opsional) --}}
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block font-bold text-slate-800 mb-1 text-[11px]">
                                (14) No. Paspor
                            </label>
                            <input type="text"
                                   x-model="formMember.no_paspor"
                                   placeholder="Opsional"
                                   class="w-full font-mono text-[11px] uppercase rounded-lg border-slate-300 py-2 px-2 bg-slate-50/50 focus:bg-white">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-800 mb-1 text-[11px]">
                                (15) No. KITAP
                            </label>
                            <input type="text"
                                   x-model="formMember.no_kitap"
                                   placeholder="Opsional"
                                   class="w-full font-mono text-[11px] uppercase rounded-lg border-slate-300 py-2 px-2 bg-slate-50/50 focus:bg-white">
                        </div>
                    </div>
                </div>

            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center justify-end gap-3 pt-3 border-t border-blue-200">
                <button type="button"
                        @click="showMemberForm = false"
                        class="px-4 py-2.5 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-200 transition-colors">
                    Batal
                </button>
                <button type="button"
                        @click="applyMember()"
                        class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-md shadow-emerald-600/20 transition-all transform hover:-translate-y-0.5">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span x-text="editingIndex !== null ? 'Perbarui Data (Apply)' : 'Terapkan ke Tabel (Apply)'"></span>
                </button>
            </div>
        </div>

        {{-- TABEL MODERN 4-KOLOM DAFTAR ANGGOTA KELUARGA --}}
        <div class="border border-slate-200 rounded-2xl overflow-hidden shadow-xs">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-100 text-slate-700 border-b border-slate-200 font-bold uppercase text-[11px]">
                            <th class="py-3 px-3 w-12 text-center">No</th>
                            <th class="py-3 px-4 min-w-[200px]">Kolom 1: Identitas Pokok</th>
                            <th class="py-3 px-4 min-w-[200px]">Kolom 2: Kelahiran & Hubungan</th>
                            <th class="py-3 px-4 min-w-[190px]">Kolom 3: Pendidikan & Pekerjaan</th>
                            <th class="py-3 px-4 min-w-[200px]">Kolom 4: Orang Tua & Status</th>
                            <th class="py-3 px-3 w-20 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        <template x-for="(item, index) in anggota" :key="'table-row-' + index">
                            <tr class="hover:bg-blue-50/40 transition-colors">
                                {{-- Nomor Urut --}}
                                <td class="py-3 px-3 text-center font-bold text-slate-500" x-text="index + 1"></td>

                                {{-- Kolom 1: Identitas Pokok (Nama, NIK, JK, Gol Darah) --}}
                                <td class="py-3 px-4">
                                    <div class="font-extrabold text-slate-900 uppercase text-xs" x-text="item.nama"></div>
                                    <div class="font-mono text-[11px] font-bold text-blue-700 mt-0.5" x-text="item.nik"></div>
                                    <div class="flex items-center gap-2 mt-1 text-[11px] text-slate-500">
                                        <span class="px-1.5 py-0.5 rounded bg-slate-100 font-medium" x-text="item.jenis_kelamin"></span>
                                        <span>Gol: <strong class="text-slate-800" x-text="item.gol_darah"></strong></span>
                                    </div>
                                </td>

                                {{-- Kolom 2: Kelahiran & Hubungan (TTL, Usia, Agama, SHDK) --}}
                                <td class="py-3 px-4">
                                    <div class="font-semibold text-slate-800" x-text="item.tempat_lahir + ', ' + item.tanggal_lahir"></div>
                                    <div class="text-[11px] text-blue-600 font-medium" x-text="calculateAge(item.tanggal_lahir)"></div>
                                    <div class="flex items-center gap-1.5 mt-1">
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase"
                                              :class="getShdkBadgeClass(item.shdk)"
                                              x-text="item.shdk"></span>
                                        <span class="text-[11px] text-slate-500" x-text="'(' + item.agama + ')'"></span>
                                    </div>
                                </td>

                                {{-- Kolom 3: Pendidikan & Pekerjaan (Pendidikan, Pekerjaan, Status Kawin) --}}
                                <td class="py-3 px-4">
                                    <div class="font-bold text-slate-800" x-text="item.pekerjaan"></div>
                                    <div class="text-[11px] text-slate-600" x-text="item.pendidikan"></div>
                                    <div class="text-[11px] text-slate-500 mt-1">
                                        Status: <strong class="text-slate-700" x-text="item.status_kawin"></strong>
                                    </div>
                                </td>

                                {{-- Kolom 4: Orang Tua & Kewarganegaraan (Ayah, Ibu, WN, Paspor) --}}
                                <td class="py-3 px-4">
                                    <div class="text-[11px] text-slate-700">
                                        Ayah: <strong class="text-slate-900 uppercase" x-text="item.nama_ayah"></strong>
                                    </div>
                                    <div class="text-[11px] text-slate-700 mt-0.5">
                                        Ibu: <strong class="text-slate-900 uppercase" x-text="item.nama_ibu"></strong>
                                    </div>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="px-1.5 py-0.5 rounded text-[10px] font-bold bg-blue-100 text-blue-800" x-text="item.kewarganegaraan"></span>
                                        <template x-if="item.no_paspor">
                                            <span class="font-mono text-[10px] text-slate-500" x-text="'Paspor: ' + item.no_paspor"></span>
                                        </template>
                                    </div>
                                </td>

                                {{-- Aksi --}}
                                <td class="py-3 px-3 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <button type="button"
                                                @click="editMember(index)"
                                                title="Ubah baris data ini"
                                                class="p-1.5 rounded-lg text-blue-600 hover:bg-blue-100 border border-blue-200">
                                            ✏️
                                        </button>
                                        <button type="button"
                                                @click="removeAnggota(index)"
                                                title="Hapus baris ini"
                                                class="p-1.5 rounded-lg text-rose-600 hover:bg-rose-100 border border-rose-200">
                                            🗑️
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </template>

                        {{-- Jika Belum Ada Anggota --}}
                        <template x-if="anggota.length === 0">
                            <tr>
                                <td colspan="6" class="py-8 text-center text-slate-400">
                                    Belum ada anggota keluarga yang dimasukkan. Silakan klik tombol <strong>"+ Tambah Anggota Keluarga"</strong> di atas.
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════
         SERIALISASI INPUT TERSEMBUNYI (SESUAI CONTROLLER LARAVEL)
    ═══════════════════════════════════════════════════════════════════════ --}}
    <input type="hidden" name="form_data[f101][jumlah_anggota]" :value="anggota.length">
    <template x-for="(item, index) in anggota" :key="'serialized-' + index">
        <div>
            <input type="hidden" :name="'form_data[f101][anggota][' + index + '][nama]'" :value="item.nama">
            <input type="hidden" :name="'form_data[f101][anggota][' + index + '][nik]'" :value="item.nik">
            <input type="hidden" :name="'form_data[f101][anggota][' + index + '][jenis_kelamin]'" :value="item.jenis_kelamin">
            <input type="hidden" :name="'form_data[f101][anggota][' + index + '][tempat_lahir]'" :value="item.tempat_lahir">
            <input type="hidden" :name="'form_data[f101][anggota][' + index + '][tanggal_lahir]'" :value="item.tanggal_lahir">
            <input type="hidden" :name="'form_data[f101][anggota][' + index + '][agama]'" :value="item.agama">
            <input type="hidden" :name="'form_data[f101][anggota][' + index + '][pendidikan]'" :value="item.pendidikan">
            <input type="hidden" :name="'form_data[f101][anggota][' + index + '][pekerjaan]'" :value="item.pekerjaan">
            <input type="hidden" :name="'form_data[f101][anggota][' + index + '][gol_darah]'" :value="item.gol_darah">
            <input type="hidden" :name="'form_data[f101][anggota][' + index + '][status_kawin]'" :value="item.status_kawin">
            <input type="hidden" :name="'form_data[f101][anggota][' + index + '][tgl_kawin]'" :value="item.tgl_kawin">
            <input type="hidden" :name="'form_data[f101][anggota][' + index + '][shdk]'" :value="item.shdk">
            <input type="hidden" :name="'form_data[f101][anggota][' + index + '][kewarganegaraan]'" :value="item.kewarganegaraan">
            <input type="hidden" :name="'form_data[f101][anggota][' + index + '][no_paspor]'" :value="item.no_paspor">
            <input type="hidden" :name="'form_data[f101][anggota][' + index + '][no_kitap]'" :value="item.no_kitap">
            <input type="hidden" :name="'form_data[f101][anggota][' + index + '][nama_ayah]'" :value="item.nama_ayah">
            <input type="hidden" :name="'form_data[f101][anggota][' + index + '][nama_ibu]'" :value="item.nama_ibu">
        </div>
    </template>

</div>

<script>
    function kkBaruComponent(initialData) {
        return {
            kecamatanMap: initialData.kecamatanMap || {},
            availableDesas: [],

            meta: {
                nama_kepala_keluarga: initialData.userName || '',
                alamat: initialData.userAlamat || '',
                rt: '001',
                rw: '001',
                kode_pos: '46182',
                kecamatan: initialData.kecamatanName || 'SINGAPARNA',
                desa: initialData.desaName || '',
                kabupaten: 'KABUPATEN TASIKMALAYA',
                provinsi: 'JAWA BARAT',
                negara: 'INDONESIA',
            },

            showMemberForm: false,
            editingIndex: null,
            validationError: '',

            formMember: {
                nama: '',
                nik: '',
                jenis_kelamin: 'LAKI-LAKI',
                tempat_lahir: 'TASIKMALAYA',
                tanggal_lahir: '',
                agama: 'ISLAM',
                pendidikan: 'SLTA / SEDERAJAT',
                pekerjaan: 'KARYAWAN SWASTA',
                gol_darah: '-',
                status_kawin: 'BELUM KAWIN',
                tgl_kawin: '',
                shdk: 'KEPALA KELUARGA',
                kewarganegaraan: 'WNI',
                no_paspor: '',
                no_kitap: '',
                nama_ayah: '',
                nama_ibu: '',
            },

            // Inisialisasi awal dengan data kepala keluarga
            anggota: [
                {
                    nama: initialData.userName || '',
                    nik: initialData.userNik || '',
                    jenis_kelamin: 'LAKI-LAKI',
                    tempat_lahir: 'TASIKMALAYA',
                    tanggal_lahir: '1995-01-01',
                    agama: 'ISLAM',
                    pendidikan: 'SLTA / SEDERAJAT',
                    pekerjaan: 'KARYAWAN SWASTA',
                    gol_darah: 'O',
                    status_kawin: 'KAWIN TERCATAT',
                    tgl_kawin: '',
                    shdk: 'KEPALA KELUARGA',
                    kewarganegaraan: 'WNI',
                    no_paspor: '',
                    no_kitap: '',
                    nama_ayah: '',
                    nama_ibu: '',
                }
            ],

            init() {
                this.onKecamatanInput(false);
            },

            // Otomatisasi Kecamatan -> Kabupaten, Provinsi, Negara & Desa List
            onKecamatanInput(resetDesa = true) {
                const kec = (this.meta.kecamatan || '').toUpperCase().trim();

                // Selalu set otomatisasi default Tasikmalaya - Jawa Barat - Indonesia bila ada isian kecamatan
                if (kec.length > 0) {
                    if (!this.meta.kabupaten || this.meta.kabupaten === 'TASIKMALAYA') {
                        this.meta.kabupaten = 'KABUPATEN TASIKMALAYA';
                    }
                    if (!this.meta.provinsi) {
                        this.meta.provinsi = 'JAWA BARAT';
                    }
                    if (!this.meta.negara) {
                        this.meta.negara = 'INDONESIA';
                    }
                }

                // Cek apakah kecamatan terdaftar dalam data tasikmalaya
                if (this.kecamatanMap[kec]) {
                    this.availableDesas = this.kecamatanMap[kec];
                    if (resetDesa && this.availableDesas.length > 0 && !this.meta.desa) {
                        this.meta.desa = this.availableDesas[0];
                    }
                } else {
                    this.availableDesas = [];
                }
            },

            calculateAge(dateStr) {
                if (!dateStr) return '';
                const birth = new Date(dateStr);
                const diff = Date.now() - birth.getTime();
                const age = new Date(diff).getUTCFullYear() - 1970;
                return age >= 0 ? `Usia: ${age} Tahun` : '';
            },

            getShdkBadgeClass(shdk) {
                switch(shdk) {
                    case 'KEPALA KELUARGA':
                        return 'bg-blue-600 text-white';
                    case 'ISTRI':
                    case 'SUAMI':
                        return 'bg-purple-600 text-white';
                    case 'ANAK':
                        return 'bg-emerald-600 text-white';
                    default:
                        return 'bg-amber-600 text-white';
                }
            },

            openAddMember() {
                this.editingIndex = null;
                this.validationError = '';
                this.formMember = {
                    nama: '',
                    nik: '',
                    jenis_kelamin: 'PEREMPUAN',
                    tempat_lahir: 'TASIKMALAYA',
                    tanggal_lahir: '',
                    agama: 'ISLAM',
                    pendidikan: 'SLTA / SEDERAJAT',
                    pekerjaan: 'MENGURUS RUMAH TANGGA',
                    gol_darah: '-',
                    status_kawin: this.anggota.length === 1 ? 'KAWIN TERCATAT' : 'BELUM KAWIN',
                    tgl_kawin: '',
                    shdk: this.anggota.length === 1 ? 'ISTRI' : 'ANAK',
                    kewarganegaraan: 'WNI',
                    no_paspor: '',
                    no_kitap: '',
                    nama_ayah: '',
                    nama_ibu: '',
                };
                this.showMemberForm = true;
            },

            editMember(index) {
                this.editingIndex = index;
                this.validationError = '';
                this.formMember = { ...this.anggota[index] };
                this.showMemberForm = true;
            },

            applyMember() {
                this.validationError = '';

                if (!this.formMember.nama || !this.formMember.nama.trim()) {
                    this.validationError = '⚠️ (1) Nama Lengkap wajib diisi.';
                    return;
                }
                if (!this.formMember.nik || this.formMember.nik.length !== 16) {
                    this.validationError = '⚠️ (2) NIK wajib 16 digit angka.';
                    return;
                }
                if (!this.formMember.tempat_lahir || !this.formMember.tempat_lahir.trim()) {
                    this.validationError = '⚠️ (4) Tempat Lahir wajib diisi.';
                    return;
                }
                if (!this.formMember.tanggal_lahir) {
                    this.validationError = '⚠️ (5) Tanggal Lahir wajib diisi.';
                    return;
                }
                if (!this.formMember.pekerjaan || !this.formMember.pekerjaan.trim()) {
                    this.validationError = '⚠️ (8) Jenis Pekerjaan wajib diisi.';
                    return;
                }
                if (!this.formMember.nama_ayah || !this.formMember.nama_ayah.trim()) {
                    this.validationError = '⚠️ (16) Nama Ayah Kandung wajib diisi.';
                    return;
                }
                if (!this.formMember.nama_ibu || !this.formMember.nama_ibu.trim()) {
                    this.validationError = '⚠️ (17) Nama Ibu Kandung wajib diisi.';
                    return;
                }

                if (this.editingIndex !== null) {
                    this.anggota[this.editingIndex] = { ...this.formMember };
                } else {
                    this.anggota.push({ ...this.formMember });
                }

                this.showMemberForm = false;
                this.editingIndex = null;
                this.validationError = '';
            },

            removeAnggota(index) {
                if (confirm('Hapus anggota keluarga ini dari daftar?')) {
                    this.anggota.splice(index, 1);
                    if (this.editingIndex === index) {
                        this.showMemberForm = false;
                        this.editingIndex = null;
                    }
                }
            }
        };
    }
</script>
