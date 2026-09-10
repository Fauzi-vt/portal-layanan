@php
    $currentKecName = strtoupper($user->kecamatan?->nama_kecamatan ?? 'MANONJAYA');
    $currentKec = ($kecamatans ?? collect())->first(function($k) use ($currentKecName) {
        return strtoupper($k->nama_kecamatan) === $currentKecName;
    });
    $availableDesas = $currentKec ? $currentKec->desas->pluck('nama_desa')->map(fn($d) => strtoupper($d))->toArray() : [];
    $defaultDesaAsal = $user->desa?->nama_desa ?: ($desas->first()?->nama_desa ?? '');
@endphp

<div x-data="{
    userName: @js($user->name),
    userNik: @js($user->nik ?? ''),
    userPhone: @js($user->phone ?? ''),
    userEmail: @js($user->email ?? ''),
    userAlamat: @js($user->alamat_detail ?? ''),
    kecamatanName: @js($user->kecamatan?->nama_kecamatan ?? 'MANONJAYA'),
    desaAsalName: @js($defaultDesaAsal),
    availableDesas: @js($availableDesas),
    noKk: '',
    namaKepala: '',
    dusunAsal: '',
    rtAsal: '001',
    rwAsal: '001',
    kodePosAsal: '46182',
    teleponAsal: @js($user->phone ?? ''),
    
    alasanPindah: '1', // 1. Pekerjaan, 2. Pendidikan, 3. Keamanan, 4. Kesehatan, 5. Perumahan, 6. Keluarga, 7. Lainnya
    alasanLainnya: '',
    desaTujuan: '',
    dusunTujuan: '',
    rtTujuan: '001',
    rwTujuan: '001',
    kodePosTujuan: '46182',
    teleponTujuan: '',
    tglRencanaPindah: '',
    
    jenisKepindahan: '2', // 1. Kep. Keluarga, 2. Kep. Keluarga dan Seluruh Angg. Keluarga, 3. Kep. Keluarga dan Sbg. Angg. Keluarga, 4. Angg. Keluarga
    statusKkTidakPindah: '3', // 1. Numpang KK, 2. Membuat KK Baru, 3. Nomor KK Tetap
    statusKkPindah: '2', // 1. Numpang KK, 2. Membuat KK Baru, 3. Nomor KK Tetap
    
    anggota: [
        { nik: @js($user->nik ?? ''), nama: @js($user->name), ktpSd: 'Seumur Hidup', shdk: 'Kepala Keluarga' }
    ],

    maskDigits(val, maxLen) {
        let clean = (val || '').toString().replace(/\D/g, '');
        return maxLen ? clean.slice(0, maxLen) : clean;
    },
    padRtRw(val) {
        let clean = (val || '').toString().replace(/\D/g, '');
        if (!clean) return '001';
        return clean.padStart(3, '0').slice(-3);
    },
    maskPhone(val) {
        let clean = (val || '').toString().replace(/[^\d+]/g, '');
        return clean.slice(0, 15);
    },
    addAnggota() {
        this.anggota.push({ nik: '', nama: '', ktpSd: 'Seumur Hidup', shdk: 'Anggota Keluarga' });
        this.$nextTick(() => window.lucide?.createIcons());
    },
    removeAnggota(index) {
        if (this.anggota.length > 1) {
            this.anggota.splice(index, 1);
        }
    }
}" class="bg-white rounded-2xl border border-slate-200 shadow-md overflow-hidden space-y-0 transition-all font-sans">

    {{-- HEADER FORMULIR F.1-25 --}}
    <div class="p-6 bg-gradient-to-r from-blue-900 via-indigo-900 to-slate-900 text-white flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-400/20 border border-blue-400/30 text-blue-200 text-xs font-bold uppercase tracking-wider mb-2">
                <i data-lucide="file-text" class="w-4 h-4 text-blue-300"></i>
                <span>FORM F.1-25 — DUKCAPIL</span>
            </div>
            <h2 class="text-xl sm:text-2xl font-black tracking-wide text-white uppercase">
                FORMULIR PERMOHONAN PINDAH WNI
            </h2>
            <p class="text-xs text-blue-100/80 mt-1 max-w-2xl leading-relaxed">
                Antar Desa / Kelurahan Dalam Satu Wilayah Kecamatan yang Sama.
            </p>
        </div>

        <div class="flex items-center gap-3 bg-white/10 backdrop-blur-md px-4 py-3 rounded-2xl border border-white/15">
            <div class="text-right">
                <span class="block text-[11px] text-blue-200 font-medium">Format Resmi</span>
                <span class="text-sm font-black text-white">F.1-25 (Antar Desa)</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-blue-500 text-white flex items-center justify-center font-black text-base shadow-sm">
                <i data-lucide="building-2" class="w-5 h-5"></i>
            </div>
        </div>
    </div>

    {{-- INFO WILAYAH ADMINISTRATIVE DENGAN STATE DINAMIS & FALLBACK --}}
    <div class="px-6 py-3.5 bg-slate-100/90 border-b border-slate-200 text-xs text-slate-700 grid grid-cols-2 sm:grid-cols-4 gap-3">
        <div class="space-y-0.5">
            <span class="block text-[10px] font-bold uppercase tracking-wider text-slate-500">Provinsi</span>
            <span class="font-bold text-slate-900">JAWA BARAT</span>
        </div>
        <div class="space-y-0.5">
            <span class="block text-[10px] font-bold uppercase tracking-wider text-slate-500">Kabupaten</span>
            <span class="font-bold text-slate-900">TASIKMALAYA</span>
        </div>
        <div class="space-y-0.5">
            <span class="block text-[10px] font-bold uppercase tracking-wider text-slate-500">Kecamatan</span>
            <span class="font-bold text-slate-900 uppercase" x-text="kecamatanName || 'MANONJAYA'"></span>
        </div>
        <div class="space-y-0.5">
            <span class="block text-[10px] font-bold uppercase tracking-wider text-slate-500">Desa Asal</span>
            <span class="font-bold uppercase"
                  :class="desaAsalName ? 'text-slate-900' : 'text-amber-700 italic'"
                  x-text="desaAsalName ? desaAsalName : 'Belum Ditentukan (Sesuai Profil)'"></span>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         BAGIAN 1: DATA DAERAH ASAL (KRONOLOGIS 1 S/D 5)
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="p-6 bg-slate-50/80 border-b border-slate-200 space-y-4">
        <h3 class="text-xs font-black uppercase tracking-wider text-slate-800 flex items-center gap-2">
            <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
            <span>DATA DAERAH ASAL</span>
        </h3>

        <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200 shadow-xs space-y-5 text-xs">
            {{-- Baris 1: 1. No KK & 2. Nama Kepala Keluarga --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="p2_no_kk" class="block font-semibold text-slate-800 mb-1.5 flex items-center justify-between">
                        <span>1. Nomor Kartu Keluarga <span class="text-rose-600 font-bold" aria-hidden="true">*</span></span>
                        <span class="text-[11px] font-normal text-slate-400">16 digit angka</span>
                    </label>
                    <input type="text"
                           id="p2_no_kk"
                           name="form_data[f_pindah_antar_desa][no_kk]"
                           x-model="noKk"
                           @input="noKk = maskDigits($event.target.value, 16)"
                           required
                           inputmode="numeric"
                           maxlength="16"
                           aria-required="true"
                           placeholder="Contoh: 320601xxxxxxxxxx"
                           class="w-full text-xs font-mono font-bold rounded-xl border border-slate-300 py-2.5 px-3.5 bg-white text-slate-900 placeholder:font-sans placeholder:font-normal placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 focus:outline-none transition-colors shadow-2xs">
                </div>

                <div>
                    <label for="p2_nama_kepala" class="block font-semibold text-slate-800 mb-1.5">
                        2. Nama Kepala Keluarga <span class="text-rose-600 font-bold" aria-hidden="true">*</span>
                    </label>
                    <input type="text"
                           id="p2_nama_kepala"
                           name="form_data[f_pindah_antar_desa][nama_kepala]"
                           x-model="namaKepala"
                           required
                           aria-required="true"
                           placeholder="Contoh: Ahmad Fauzi"
                           class="w-full text-xs font-bold uppercase rounded-xl border border-slate-300 py-2.5 px-3.5 bg-white text-slate-900 placeholder:normal-case placeholder:font-normal placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 focus:outline-none transition-colors shadow-2xs">
                </div>
            </div>

            {{-- Baris 2: 3. Alamat Asal Lengkap --}}
            <div class="p-4 rounded-xl bg-slate-50/70 border border-slate-200/80 space-y-3.5">
                <span class="block text-xs font-bold text-slate-800">
                    3. Alamat Asal Lengkap <span class="text-rose-600 font-bold" aria-hidden="true">*</span>
                </span>

                {{-- Sub-baris 1: Jalan/Dusun (65%) + Wilayah Mikro RT/RW (35%) --}}
                <div class="grid grid-cols-1 md:grid-cols-12 gap-3.5">
                    <div class="md:col-span-8">
                        <label for="p2_dusun_asal" class="block font-medium text-slate-700 mb-1">
                            Nama Jalan / Dusun / Kampung <span class="text-rose-600 font-bold" aria-hidden="true">*</span>
                        </label>
                        <input type="text"
                               id="p2_dusun_asal"
                               name="form_data[f_pindah_antar_desa][dusun_asal]"
                               x-model="dusunAsal"
                               required
                               aria-required="true"
                               placeholder="Contoh: Dusun Sukahaji, Jl. Kaum No. 12"
                               class="w-full text-xs font-medium rounded-xl border border-slate-300 py-2.5 px-3.5 bg-white text-slate-900 placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 focus:outline-none transition-colors shadow-2xs">
                    </div>

                    {{-- RT & RW mikro --}}
                    <div class="md:col-span-4">
                        <span class="block font-medium text-slate-700 mb-1">Wilayah Mikro (RT / RW) <span class="text-rose-600 font-bold" aria-hidden="true">*</span></span>
                        <div class="flex items-center gap-2 p-1 bg-white rounded-xl border border-slate-300 shadow-2xs">
                            <div class="flex-1 flex items-center gap-1.5 pl-2">
                                <label for="p2_rt_asal" class="text-[11px] font-bold text-slate-500 shrink-0">RT</label>
                                <input type="text"
                                       id="p2_rt_asal"
                                       name="form_data[f_pindah_antar_desa][rt_asal]"
                                       x-model="rtAsal"
                                       @input="rtAsal = maskDigits($event.target.value, 3)"
                                       @blur="rtAsal = padRtRw(rtAsal)"
                                       required
                                       inputmode="numeric"
                                       maxlength="3"
                                       placeholder="001"
                                       class="w-full font-mono text-center text-xs font-bold py-1.5 px-1 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 focus:bg-white focus:ring-1 focus:ring-blue-600 focus:border-blue-600 focus:outline-none">
                            </div>
                            <span class="text-slate-300 font-bold">/</span>
                            <div class="flex-1 flex items-center gap-1.5 pr-2">
                                <label for="p2_rw_asal" class="text-[11px] font-bold text-slate-500 shrink-0">RW</label>
                                <input type="text"
                                       id="p2_rw_asal"
                                       name="form_data[f_pindah_antar_desa][rw_asal]"
                                       x-model="rwAsal"
                                       @input="rwAsal = maskDigits($event.target.value, 3)"
                                       @blur="rwAsal = padRtRw(rwAsal)"
                                       required
                                       inputmode="numeric"
                                       maxlength="3"
                                       placeholder="001"
                                       class="w-full font-mono text-center text-xs font-bold py-1.5 px-1 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 focus:bg-white focus:ring-1 focus:ring-blue-600 focus:border-blue-600 focus:outline-none">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Sub-baris 2: Wilayah Makro --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5 pt-1">
                    <div>
                        <label for="p2_kode_pos_asal" class="block font-medium text-slate-700 mb-1">Kode Pos</label>
                        <input type="text"
                               id="p2_kode_pos_asal"
                               name="form_data[f_pindah_antar_desa][kode_pos_asal]"
                               x-model="kodePosAsal"
                               @input="kodePosAsal = maskDigits($event.target.value, 5)"
                               inputmode="numeric"
                               maxlength="5"
                               placeholder="Contoh: 46182"
                               class="w-full font-mono text-xs font-medium rounded-xl border border-slate-300 py-2.5 px-3.5 bg-white text-slate-900 placeholder:font-sans placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 focus:outline-none transition-colors shadow-2xs">
                    </div>
                    <div>
                        <label class="block font-medium text-slate-700 mb-1">Desa / Kelurahan Asal</label>
                        <input type="text"
                               name="form_data[f_pindah_antar_desa][desa_asal]"
                               :value="desaAsalName || 'Kecamatan Manonjaya'"
                               readonly
                               aria-readonly="true"
                               tabindex="-1"
                               class="w-full text-xs font-bold uppercase rounded-xl border border-slate-200 py-2.5 px-3.5 bg-[#F3F4F6] text-slate-700 cursor-not-allowed select-none shadow-2xs">
                    </div>
                    <div>
                        <label for="p2_telepon_asal" class="block font-medium text-slate-700 mb-1">Telepon / WhatsApp</label>
                        <input type="tel"
                               id="p2_telepon_asal"
                               name="form_data[f_pindah_antar_desa][telepon_asal]"
                               x-model="teleponAsal"
                               @input="teleponAsal = maskPhone($event.target.value)"
                               placeholder="Contoh: 08123456789"
                               class="w-full text-xs font-mono font-medium rounded-xl border border-slate-300 py-2.5 px-3.5 bg-white text-slate-900 placeholder:font-sans placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 focus:outline-none transition-colors shadow-2xs">
                    </div>
                </div>
            </div>

            {{-- Baris 3: 4. NIK Pemohon & 5. Nama Lengkap Pemohon (Readonly Profil dengan Badge) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-1">
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="p2_nik_pemohon" class="font-semibold text-slate-800">
                            4. NIK Pemohon <span class="text-rose-600 font-bold" aria-hidden="true">*</span>
                        </label>
                        <span class="inline-flex items-center gap-1 text-[10px] font-medium text-blue-700 bg-blue-50 px-2 py-0.5 rounded-full border border-blue-200">
                            <i data-lucide="lock" class="w-3 h-3"></i>
                            Terisi otomatis dari profil akun
                        </span>
                    </div>
                    <input type="text"
                           id="p2_nik_pemohon"
                           name="form_data[f_pindah_antar_desa][nik_pemohon]"
                           :value="userNik"
                           readonly
                           aria-readonly="true"
                           tabindex="-1"
                           class="w-full text-xs font-mono font-bold uppercase rounded-xl border border-slate-200 py-2.5 px-3.5 bg-[#F3F4F6] text-slate-700 cursor-not-allowed select-none shadow-2xs">
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="p2_nama_pemohon" class="font-semibold text-slate-800">
                            5. Nama Lengkap Pemohon <span class="text-rose-600 font-bold" aria-hidden="true">*</span>
                        </label>
                        <span class="inline-flex items-center gap-1 text-[10px] font-medium text-blue-700 bg-blue-50 px-2 py-0.5 rounded-full border border-blue-200">
                            <i data-lucide="lock" class="w-3 h-3"></i>
                            Terisi otomatis dari profil akun
                        </span>
                    </div>
                    <input type="text"
                           id="p2_nama_pemohon"
                           name="form_data[f_pindah_antar_desa][nama_pemohon]"
                           :value="userName"
                           readonly
                           aria-readonly="true"
                           tabindex="-1"
                           class="w-full text-xs font-bold uppercase rounded-xl border border-slate-200 py-2.5 px-3.5 bg-[#F3F4F6] text-slate-700 cursor-not-allowed select-none shadow-2xs">
                </div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         BAGIAN 2: DATA KEPINDAHAN (ANTAR DESA DALAM KECAMATAN) - KRONOLOGIS
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="p-6 bg-white border-b border-slate-200 space-y-4">
        <h3 class="text-xs font-black uppercase tracking-wider text-slate-800 flex items-center gap-2">
            <span class="w-2.5 h-2.5 rounded-full bg-emerald-600"></span>
            <span>DATA KEPINDAHAN (Antar Desa Dalam Kecamatan <span class="uppercase" x-text="kecamatanName"></span>)</span>
        </h3>

        <div class="bg-slate-50/70 p-5 sm:p-6 rounded-2xl border border-slate-200 shadow-xs space-y-5 text-xs">
            {{-- Baris 1: 1. Alasan Pindah & Tanggal Rencana Pindah --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div :class="alasanPindah === '7' ? 'md:col-span-1' : 'md:col-span-2'">
                    <label for="p2_alasan_pindah" class="block font-semibold text-slate-800 mb-1.5">
                        1. Alasan Pindah <span class="text-rose-600 font-bold" aria-hidden="true">*</span>
                    </label>
                    <select id="p2_alasan_pindah"
                            name="form_data[f_pindah_antar_desa][alasan_pindah]"
                            x-model="alasanPindah"
                            class="w-full text-xs font-bold rounded-xl border border-slate-300 py-2.5 px-3.5 bg-white text-slate-900 focus:ring-2 focus:ring-emerald-600/20 focus:border-emerald-600 focus:outline-none transition-colors shadow-2xs">
                        <option value="1">1. Pekerjaan</option>
                        <option value="2">2. Pendidikan</option>
                        <option value="3">3. Keamanan</option>
                        <option value="4">4. Kesehatan</option>
                        <option value="5">5. Perumahan</option>
                        <option value="6">6. Keluarga</option>
                        <option value="7">7. Lainnya</option>
                    </select>
                </div>

                <div x-show="alasanPindah === '7'">
                    <label for="p2_alasan_lainnya" class="block font-semibold text-slate-800 mb-1.5">Sebutkan Alasan Lainnya <span class="text-rose-600 font-bold">*</span></label>
                    <input type="text"
                           id="p2_alasan_lainnya"
                           name="form_data[f_pindah_antar_desa][alasan_lainnya]"
                           x-model="alasanLainnya"
                           placeholder="Contoh: Mengikuti dinas kerja"
                           class="w-full text-xs font-medium rounded-xl border border-slate-300 py-2.5 px-3.5 bg-white text-slate-900 focus:ring-2 focus:ring-emerald-600/20 focus:border-emerald-600 focus:outline-none transition-colors shadow-2xs">
                </div>

                <div>
                    <label for="p2_tgl_rencana" class="block font-semibold text-slate-800 mb-1.5">
                        Tanggal Rencana Kepindahan <span class="text-rose-600 font-bold" aria-hidden="true">*</span>
                    </label>
                    <input type="date"
                           id="p2_tgl_rencana"
                           name="form_data[f_pindah_antar_desa][tgl_rencana_pindah]"
                           x-model="tglRencanaPindah"
                           required
                           aria-required="true"
                           class="w-full text-xs font-bold rounded-xl border border-slate-300 py-2.5 px-3.5 bg-white text-slate-900 focus:ring-2 focus:ring-emerald-600/20 focus:border-emerald-600 focus:outline-none transition-colors shadow-2xs">
                </div>
            </div>

            {{-- Baris 2: 2. Alamat Tujuan Pindah (Kesatuan Alamat Lengkap) --}}
            <div class="p-4 rounded-xl bg-white border border-slate-200 space-y-3.5">
                <span class="block text-xs font-bold text-slate-800">
                    2. Alamat Tujuan Baru (Desa Tujuan & Domisili Baru) <span class="text-rose-600 font-bold" aria-hidden="true">*</span>
                </span>

                {{-- Desa Tujuan Dropdown --}}
                <div>
                    <label for="p2_desa_tujuan" class="block font-medium text-slate-700 mb-1">
                        Desa / Kelurahan Tujuan <span class="text-rose-600 font-bold" aria-hidden="true">*</span>
                    </label>
                    <select id="p2_desa_tujuan"
                            name="form_data[f_pindah_antar_desa][desa_tujuan]"
                            x-model="desaTujuan"
                            required
                            aria-required="true"
                            class="w-full text-xs font-bold uppercase rounded-xl border border-slate-300 py-2.5 px-3.5 bg-white text-slate-900 focus:ring-2 focus:ring-emerald-600/20 focus:border-emerald-600 focus:outline-none transition-colors shadow-2xs">
                        <option value="">-- Pilih Desa / Kelurahan Tujuan --</option>
                        <template x-for="desa in availableDesas" :key="desa">
                            <option :value="desa" x-text="desa" :disabled="desa === (desaAsalName || '').toUpperCase()"></option>
                        </template>
                    </select>
                </div>

                {{-- Jalan/Dusun (65%) & RT/RW (35%) --}}
                <div class="grid grid-cols-1 md:grid-cols-12 gap-3.5">
                    <div class="md:col-span-8">
                        <label for="p2_dusun_tujuan" class="block font-medium text-slate-700 mb-1">
                            Nama Jalan / Dusun / Kampung Tujuan <span class="text-rose-600 font-bold" aria-hidden="true">*</span>
                        </label>
                        <input type="text"
                               id="p2_dusun_tujuan"
                               name="form_data[f_pindah_antar_desa][dusun_tujuan]"
                               x-model="dusunTujuan"
                               required
                               aria-required="true"
                               placeholder="Contoh: Dusun Ciharulang No. 24"
                               class="w-full text-xs font-medium rounded-xl border border-slate-300 py-2.5 px-3.5 bg-white text-slate-900 placeholder:text-slate-400 focus:ring-2 focus:ring-emerald-600/20 focus:border-emerald-600 focus:outline-none transition-colors shadow-2xs">
                    </div>

                    <div class="md:col-span-4">
                        <span class="block font-medium text-slate-700 mb-1">Wilayah Mikro Tujuan (RT / RW) <span class="text-rose-600 font-bold" aria-hidden="true">*</span></span>
                        <div class="flex items-center gap-2 p-1 bg-slate-50 rounded-xl border border-slate-300 shadow-2xs">
                            <div class="flex-1 flex items-center gap-1.5 pl-2">
                                <label for="p2_rt_tujuan" class="text-[11px] font-bold text-slate-500 shrink-0">RT</label>
                                <input type="text"
                                       id="p2_rt_tujuan"
                                       name="form_data[f_pindah_antar_desa][rt_tujuan]"
                                       x-model="rtTujuan"
                                       @input="rtTujuan = maskDigits($event.target.value, 3)"
                                       @blur="rtTujuan = padRtRw(rtTujuan)"
                                       required
                                       inputmode="numeric"
                                       maxlength="3"
                                       placeholder="001"
                                       class="w-full font-mono text-center text-xs font-bold py-1.5 px-1 bg-white border border-slate-200 rounded-lg text-slate-800 focus:ring-1 focus:ring-emerald-600 focus:border-emerald-600 focus:outline-none">
                            </div>
                            <span class="text-slate-300 font-bold">/</span>
                            <div class="flex-1 flex items-center gap-1.5 pr-2">
                                <label for="p2_rw_tujuan" class="text-[11px] font-bold text-slate-500 shrink-0">RW</label>
                                <input type="text"
                                       id="p2_rw_tujuan"
                                       name="form_data[f_pindah_antar_desa][rw_tujuan]"
                                       x-model="rwTujuan"
                                       @input="rwTujuan = maskDigits($event.target.value, 3)"
                                       @blur="rwTujuan = padRtRw(rwTujuan)"
                                       required
                                       inputmode="numeric"
                                       maxlength="3"
                                       placeholder="001"
                                       class="w-full font-mono text-center text-xs font-bold py-1.5 px-1 bg-white border border-slate-200 rounded-lg text-slate-800 focus:ring-1 focus:ring-emerald-600 focus:border-emerald-600 focus:outline-none">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kode Pos & Telepon Tujuan --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 pt-1">
                    <div>
                        <label for="p2_kode_pos_tujuan" class="block font-medium text-slate-700 mb-1">Kode Pos Tujuan</label>
                        <input type="text"
                               id="p2_kode_pos_tujuan"
                               name="form_data[f_pindah_antar_desa][kode_pos_tujuan]"
                               x-model="kodePosTujuan"
                               @input="kodePosTujuan = maskDigits($event.target.value, 5)"
                               inputmode="numeric"
                               maxlength="5"
                               placeholder="Contoh: 46182"
                               class="w-full font-mono text-xs font-medium rounded-xl border border-slate-300 py-2.5 px-3.5 bg-white text-slate-900 placeholder:font-sans placeholder:text-slate-400 focus:ring-2 focus:ring-emerald-600/20 focus:border-emerald-600 focus:outline-none transition-colors shadow-2xs">
                    </div>
                    <div>
                        <label for="p2_telepon_tujuan" class="block font-medium text-slate-700 mb-1">Telepon / HP Penerima di Tujuan</label>
                        <input type="tel"
                               id="p2_telepon_tujuan"
                               name="form_data[f_pindah_antar_desa][telepon_tujuan]"
                               x-model="teleponTujuan"
                               @input="teleponTujuan = maskPhone($event.target.value)"
                               placeholder="Contoh: 08123456789"
                               class="w-full text-xs font-mono font-medium rounded-xl border border-slate-300 py-2.5 px-3.5 bg-white text-slate-900 placeholder:font-sans placeholder:text-slate-400 focus:ring-2 focus:ring-emerald-600/20 focus:border-emerald-600 focus:outline-none transition-colors shadow-2xs">
                    </div>
                </div>
            </div>

            {{-- Baris 3: Status Kepindahan (3, 4, 5) --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-1">
                <div>
                    <label for="p2_jenis_kepindahan" class="block font-semibold text-slate-800 mb-1.5">
                        3. Jenis Kepindahan <span class="text-rose-600 font-bold" aria-hidden="true">*</span>
                    </label>
                    <select id="p2_jenis_kepindahan"
                            name="form_data[f_pindah_antar_desa][jenis_kepindahan]"
                            x-model="jenisKepindahan"
                            class="w-full text-xs font-medium rounded-xl border border-slate-300 py-2.5 px-3.5 bg-white text-slate-900 focus:ring-2 focus:ring-emerald-600/20 focus:border-emerald-600 focus:outline-none transition-colors shadow-2xs">
                        <option value="1">1. Kepala Keluarga</option>
                        <option value="2">2. Kepala Keluarga & Seluruh Anggota</option>
                        <option value="3">3. Kepala Keluarga & Sebagian Anggota</option>
                        <option value="4">4. Anggota Keluarga Saja</option>
                    </select>
                </div>

                <div>
                    <label for="p2_status_tidak_pindah" class="block font-semibold text-slate-800 mb-1.5">
                        4. Status KK Bagi Yang Tidak Pindah <span class="text-rose-600 font-bold" aria-hidden="true">*</span>
                    </label>
                    <select id="p2_status_tidak_pindah"
                            name="form_data[f_pindah_antar_desa][status_kk_tidak_pindah]"
                            x-model="statusKkTidakPindah"
                            class="w-full text-xs font-medium rounded-xl border border-slate-300 py-2.5 px-3.5 bg-white text-slate-900 focus:ring-2 focus:ring-emerald-600/20 focus:border-emerald-600 focus:outline-none transition-colors shadow-2xs">
                        <option value="1">1. Numpang KK</option>
                        <option value="2">2. Membuat KK Baru</option>
                        <option value="3">3. Nomor KK Tetap</option>
                    </select>
                </div>

                <div>
                    <label for="p2_status_pindah" class="block font-semibold text-slate-800 mb-1.5">
                        5. Status KK Bagi Yang Pindah <span class="text-rose-600 font-bold" aria-hidden="true">*</span>
                    </label>
                    <select id="p2_status_pindah"
                            name="form_data[f_pindah_antar_desa][status_kk_pindah]"
                            x-model="statusKkPindah"
                            class="w-full text-xs font-medium rounded-xl border border-slate-300 py-2.5 px-3.5 bg-white text-slate-900 focus:ring-2 focus:ring-emerald-600/20 focus:border-emerald-600 focus:outline-none transition-colors shadow-2xs">
                        <option value="1">1. Numpang KK</option>
                        <option value="2">2. Membuat KK Baru</option>
                        <option value="3">3. Nomor KK Tetap</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         BAGIAN 3: 6. KELUARGA YANG PINDAH
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="p-6 bg-slate-50/50 space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h3 class="text-xs font-black uppercase tracking-wider text-slate-800 flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-indigo-600"></span>
                    <span>6. KELUARGA YANG PINDAH</span>
                </h3>
                <p class="text-[11px] text-slate-500 mt-0.5">Daftar seluruh anggota keluarga yang ikut pindah domisili.</p>
            </div>
            <button type="button"
                    @click="addAnggota()"
                    class="px-3.5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 focus:ring-2 focus:ring-blue-600/30 text-white font-bold text-xs flex items-center gap-1.5 shadow-2xs self-start sm:self-auto cursor-pointer transition-all">
                <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                <span>Tambah Anggota</span>
            </button>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs min-w-[640px]">
                    <thead class="bg-slate-100/90 text-slate-700 border-b border-slate-200 font-bold uppercase tracking-wider">
                        <tr>
                            <th scope="col" class="p-3 w-12 text-center">No</th>
                            <th scope="col" class="p-3 w-48">NIK (16 Digit)</th>
                            <th scope="col" class="p-3">Nama Lengkap</th>
                            <th scope="col" class="p-3 w-40">Masa KTP s/d</th>
                            <th scope="col" class="p-3 w-40">SHDK</th>
                            <th scope="col" class="p-3 w-16 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <template x-for="(item, index) in anggota" :key="index">
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="p-3 text-center font-bold text-slate-500" x-text="index + 1"></td>
                                <td class="p-3">
                                    <input type="text"
                                           :name="'form_data[f_pindah_antar_desa][anggota][' + index + '][nik]'"
                                           x-model="item.nik"
                                           @input="item.nik = maskDigits($event.target.value, 16)"
                                           inputmode="numeric"
                                           maxlength="16"
                                           required
                                           aria-required="true"
                                           placeholder="16 digit NIK"
                                           class="w-full text-xs font-mono font-medium rounded-lg border border-slate-300 py-1.5 px-2.5 bg-white text-slate-900 focus:ring-1 focus:ring-blue-600 focus:border-blue-600 focus:outline-none shadow-2xs">
                                </td>
                                <td class="p-3">
                                    <input type="text"
                                           :name="'form_data[f_pindah_antar_desa][anggota][' + index + '][nama]'"
                                           x-model="item.nama"
                                           required
                                           aria-required="true"
                                           placeholder="Nama lengkap sesuai KTP"
                                           class="w-full text-xs font-bold uppercase rounded-lg border border-slate-300 py-1.5 px-2.5 bg-white text-slate-900 placeholder:normal-case placeholder:font-normal placeholder:text-slate-400 focus:ring-1 focus:ring-blue-600 focus:border-blue-600 focus:outline-none shadow-2xs">
                                </td>
                                <td class="p-3">
                                    <input type="text"
                                           :name="'form_data[f_pindah_antar_desa][anggota][' + index + '][ktp_sd]'"
                                           x-model="item.ktpSd"
                                           placeholder="Seumur hidup"
                                           class="w-full text-xs font-medium rounded-lg border border-slate-300 py-1.5 px-2.5 bg-white text-slate-900 focus:ring-1 focus:ring-blue-600 focus:border-blue-600 focus:outline-none shadow-2xs">
                                </td>
                                <td class="p-3">
                                    <select :name="'form_data[f_pindah_antar_desa][anggota][' + index + '][shdk]'"
                                            x-model="item.shdk"
                                            class="w-full text-xs font-medium rounded-lg border border-slate-300 py-1.5 px-2 bg-white text-slate-900 focus:ring-1 focus:ring-blue-600 focus:border-blue-600 focus:outline-none shadow-2xs">
                                        <option value="Kepala Keluarga">Kepala Keluarga</option>
                                        <option value="Suami">Suami</option>
                                        <option value="Istri">Istri</option>
                                        <option value="Anak">Anak</option>
                                        <option value="Menantu">Menantu</option>
                                        <option value="Cucu">Cucu</option>
                                        <option value="Orang Tua">Orang Tua</option>
                                        <option value="Mertua">Mertua</option>
                                        <option value="Famili Lain">Famili Lain</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </td>
                                <td class="p-3 text-center">
                                    <button type="button"
                                            @click="removeAnggota(index)"
                                            x-show="anggota.length > 1"
                                            title="Hapus baris"
                                            class="p-1.5 rounded-lg text-rose-600 hover:bg-rose-50 focus:ring-2 focus:ring-rose-500/20 cursor-pointer transition-colors">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
