@php
    $kecamatanMap = ($kecamatans ?? collect())->mapWithKeys(function($k) {
        return [
            strtoupper($k->nama_kecamatan) => $k->desas ? $k->desas->pluck('nama_desa')->map(fn($d) => strtoupper($d))->values() : []
        ];
    });
    $defaultDesa = $user->desa?->nama_desa ?: ($desas->first()?->nama_desa ?? '');
    $oldData = old('form_data.pindah_satu_desa', isset($submission) ? ($submission->form_data['pindah_satu_desa'] ?? null) : null);
@endphp

<div x-data="{
    userName: @js($user->name),
    userNik: @js($user->nik ?? ''),
    userPhone: @js($user->phone ?? ''),
    userEmail: @js($user->email ?? ''),
    userAlamat: @js($user->alamat_detail ?? ''),
    kecamatanName: @js($user->kecamatan?->nama_kecamatan ?? 'MANONJAYA'),
    desaName: @js($defaultDesa),
    noKk: @js($oldData['no_kk'] ?? ''),
    namaKepala: @js($oldData['nama_kepala'] ?? ''),
    dusunAsal: @js($oldData['dusun_asal'] ?? ''),
    rtAsal: @js($oldData['rt_asal'] ?? '001'),
    rwAsal: @js($oldData['rw_asal'] ?? '001'),
    kodePosAsal: @js($oldData['kode_pos_asal'] ?? '46182'),
    teleponAsal: @js($oldData['telepon_asal'] ?? ($user->phone ?? '')),
    
    statusKkTujuan: @js($oldData['status_kk_tujuan'] ?? '1'), // 1. Numpang KK, 2. Membuat KK Baru, 3. Nomor KK Tetap
    noKkTujuan: @js($oldData['no_kk_tujuan'] ?? ''),
    nikKepalaTujuan: @js($oldData['nik_kepala_tujuan'] ?? ''),
    namaKepalaTujuan: @js($oldData['nama_kepala_tujuan'] ?? ''),
    tglKedatangan: @js($oldData['tgl_kedatangan'] ?? ''),
    dusunTujuan: @js($oldData['dusun_tujuan'] ?? ''),
    rtTujuan: @js($oldData['rt_tujuan'] ?? '001'),
    rwTujuan: @js($oldData['rw_tujuan'] ?? '001'),
    
    anggota: @js($oldData['anggota'] ?? [
        [ 'nik' => $user->nik ?? '', 'nama' => $user->name, 'ktpSd' => 'Seumur Hidup', 'shdk' => 'Kepala Keluarga' ]
    ]),

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

    {{-- HEADER FORMULIR F.1-23 --}}
    <div class="p-6 bg-gradient-to-r from-blue-900 via-indigo-900 to-slate-900 text-white flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-400/20 border border-blue-400/30 text-blue-200 text-xs font-bold uppercase tracking-wider mb-2">
                <i data-lucide="file-text" class="w-4 h-4 text-blue-300"></i>
                <span>FORM F.1-23 — DUKCAPIL</span>
            </div>
            <h2 class="text-xl sm:text-2xl font-black tracking-wide text-white uppercase">
                FORMULIR PERMOHONAN PINDAH DATANG WNI
            </h2>
            <p class="text-xs text-blue-100/80 mt-1 max-w-2xl leading-relaxed">
                Pengurusan perpindahan domisili penduduk dalam satu wilayah desa / kelurahan yang sama.
            </p>
        </div>

        <div class="flex items-center gap-3 bg-white/10 backdrop-blur-md px-4 py-3 rounded-2xl border border-white/15">
            <div class="text-right">
                <span class="block text-[11px] text-blue-200 font-medium">Format Resmi</span>
                <span class="text-sm font-black text-white">F.1-23 (Dalam Satu Desa)</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-blue-500 text-white flex items-center justify-center font-black text-base shadow-sm">
                <i data-lucide="home" class="w-5 h-5"></i>
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
            <span class="block text-[10px] font-bold uppercase tracking-wider text-slate-500">Desa / Kelurahan</span>
            <span class="font-bold uppercase"
                  :class="desaName ? 'text-slate-900' : 'text-amber-700 italic'"
                  x-text="desaName ? desaName : 'Belum Ditentukan (Sesuai Profil)'"></span>
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
                    <label for="p1_no_kk" class="block font-semibold text-slate-800 mb-1.5 flex items-center justify-between">
                        <span>1. Nomor Kartu Keluarga <span class="text-rose-600 font-bold" aria-hidden="true">*</span></span>
                        <span class="text-[11px] font-normal text-slate-400">16 digit angka</span>
                    </label>
                    <input type="text"
                           id="p1_no_kk"
                           name="form_data[f_pindah_satu_desa][no_kk]"
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
                    <label for="p1_nama_kepala" class="block font-semibold text-slate-800 mb-1.5">
                        2. Nama Kepala Keluarga <span class="text-rose-600 font-bold" aria-hidden="true">*</span>
                    </label>
                    <input type="text"
                           id="p1_nama_kepala"
                           name="form_data[f_pindah_satu_desa][nama_kepala]"
                           x-model="namaKepala"
                           required
                           aria-required="true"
                           placeholder="Contoh: Ahmad Fauzi"
                           class="w-full text-xs font-bold uppercase rounded-xl border border-slate-300 py-2.5 px-3.5 bg-white text-slate-900 placeholder:normal-case placeholder:font-normal placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 focus:outline-none transition-colors shadow-2xs">
                </div>
            </div>

            {{-- Baris 2: 3. Alamat Asal (Kesatuan Alamat Lengkap Sesuai Ketentuan) --}}
            <div class="p-4 rounded-xl bg-slate-50/70 border border-slate-200/80 space-y-3.5">
                <span class="block text-xs font-bold text-slate-800">
                    3. Alamat Asal Lengkap <span class="text-rose-600 font-bold" aria-hidden="true">*</span>
                </span>

                {{-- Sub-baris 1: Jalan/Dusun (65%) + Wilayah Mikro RT/RW (35%) --}}
                <div class="grid grid-cols-1 md:grid-cols-12 gap-3.5">
                    {{-- Dusun/Jalan --}}
                    <div class="md:col-span-8">
                        <label for="p1_dusun_asal" class="block font-medium text-slate-700 mb-1">
                            Nama Jalan / Dusun / Kampung <span class="text-rose-600 font-bold" aria-hidden="true">*</span>
                        </label>
                        <input type="text"
                               id="p1_dusun_asal"
                               name="form_data[f_pindah_satu_desa][dusun_asal]"
                               x-model="dusunAsal"
                               required
                               aria-required="true"
                               placeholder="Contoh: Dusun Sukahaji, Jl. Kaum No. 12"
                               class="w-full text-xs font-medium rounded-xl border border-slate-300 py-2.5 px-3.5 bg-white text-slate-900 placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 focus:outline-none transition-colors shadow-2xs">
                    </div>

                    {{-- RT & RW dalam inline container terpisah dengan visual border jelas --}}
                    <div class="md:col-span-4">
                        <span class="block font-medium text-slate-700 mb-1">Wilayah Mikro (RT / RW) <span class="text-rose-600 font-bold" aria-hidden="true">*</span></span>
                        <div class="flex items-center gap-2 p-1 bg-white rounded-xl border border-slate-300 shadow-2xs">
                            <div class="flex-1 flex items-center gap-1.5 pl-2">
                                <label for="p1_rt_asal" class="text-[11px] font-bold text-slate-500 shrink-0">RT</label>
                                <input type="text"
                                       id="p1_rt_asal"
                                       name="form_data[f_pindah_satu_desa][rt_asal]"
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
                                <label for="p1_rw_asal" class="text-[11px] font-bold text-slate-500 shrink-0">RW</label>
                                <input type="text"
                                       id="p1_rw_asal"
                                       name="form_data[f_pindah_satu_desa][rw_asal]"
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

                {{-- Sub-baris 2: Wilayah Makro (Kode Pos, Desa, Telepon/HP) --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5 pt-1">
                    <div>
                        <label for="p1_kode_pos_asal" class="block font-medium text-slate-700 mb-1">Kode Pos</label>
                        <input type="text"
                               id="p1_kode_pos_asal"
                               name="form_data[f_pindah_satu_desa][kode_pos_asal]"
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
                               name="form_data[f_pindah_satu_desa][desa_asal]"
                               :value="desaName || 'Kecamatan Manonjaya'"
                               readonly
                               aria-readonly="true"
                               tabindex="-1"
                               class="w-full text-xs font-bold uppercase rounded-xl border border-slate-200 py-2.5 px-3.5 bg-[#F3F4F6] text-slate-700 cursor-not-allowed select-none shadow-2xs">
                    </div>
                    <div>
                        <label for="p1_telepon_asal" class="block font-medium text-slate-700 mb-1">Telepon / WhatsApp</label>
                        <input type="tel"
                               id="p1_telepon_asal"
                               name="form_data[f_pindah_satu_desa][telepon_asal]"
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
                        <label for="p1_nik_pemohon" class="font-semibold text-slate-800">
                            4. NIK Pemohon <span class="text-rose-600 font-bold" aria-hidden="true">*</span>
                        </label>
                        <span class="inline-flex items-center gap-1 text-[10px] font-medium text-blue-700 bg-blue-50 px-2 py-0.5 rounded-full border border-blue-200">
                            <i data-lucide="lock" class="w-3 h-3"></i>
                            Terisi otomatis dari profil akun
                        </span>
                    </div>
                    <input type="text"
                           id="p1_nik_pemohon"
                           name="form_data[f_pindah_satu_desa][nik_pemohon]"
                           :value="userNik"
                           readonly
                           aria-readonly="true"
                           tabindex="-1"
                           class="w-full text-xs font-mono font-bold uppercase rounded-xl border border-slate-200 py-2.5 px-3.5 bg-[#F3F4F6] text-slate-700 cursor-not-allowed select-none shadow-2xs">
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="p1_nama_pemohon" class="font-semibold text-slate-800">
                            5. Nama Lengkap Pemohon <span class="text-rose-600 font-bold" aria-hidden="true">*</span>
                        </label>
                        <span class="inline-flex items-center gap-1 text-[10px] font-medium text-blue-700 bg-blue-50 px-2 py-0.5 rounded-full border border-blue-200">
                            <i data-lucide="lock" class="w-3 h-3"></i>
                            Terisi otomatis dari profil akun
                        </span>
                    </div>
                    <input type="text"
                           id="p1_nama_pemohon"
                           name="form_data[f_pindah_satu_desa][nama_pemohon]"
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
         BAGIAN 2: DATA DAERAH TUJUAN (DALAM DESA) - KRONOLOGIS 1 S/D 6
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="p-6 bg-white border-b border-slate-200 space-y-4">
        <h3 class="text-xs font-black uppercase tracking-wider text-slate-800 flex items-center gap-2">
            <span class="w-2.5 h-2.5 rounded-full bg-emerald-600"></span>
            <span>DATA DAERAH TUJUAN (Dalam Satu Desa / Kelurahan)</span>
        </h3>

        <div class="bg-slate-50/70 p-5 sm:p-6 rounded-2xl border border-slate-200 shadow-xs space-y-5 text-xs">
            {{-- Baris 1: 1. Status No KK, 2. No KK Tujuan, 5. Tanggal Kedatangan --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="p1_status_kk_tujuan" class="block font-semibold text-slate-800 mb-1.5">
                        1. Status Nomor KK Bagi Yang Pindah <span class="text-rose-600 font-bold" aria-hidden="true">*</span>
                    </label>
                    <select id="p1_status_kk_tujuan"
                            name="form_data[f_pindah_satu_desa][status_kk_tujuan]"
                            x-model="statusKkTujuan"
                            class="w-full text-xs font-bold rounded-xl border border-slate-300 py-2.5 px-3.5 bg-white text-slate-900 focus:ring-2 focus:ring-emerald-600/20 focus:border-emerald-600 focus:outline-none transition-colors shadow-2xs">
                        <option value="1">1. Numpang KK</option>
                        <option value="2">2. Membuat KK Baru</option>
                        <option value="3">3. Nomor KK Tetap</option>
                    </select>
                </div>

                <div>
                    <label for="p1_no_kk_tujuan" class="block font-semibold text-slate-800 mb-1.5 flex items-center justify-between">
                        <span>2. Nomor KK Tujuan / Baru</span>
                        <span class="text-[11px] font-normal text-slate-400">16 digit angka</span>
                    </label>
                    <input type="text"
                           id="p1_no_kk_tujuan"
                           name="form_data[f_pindah_satu_desa][no_kk_tujuan]"
                           x-model="noKkTujuan"
                           @input="noKkTujuan = maskDigits($event.target.value, 16)"
                           inputmode="numeric"
                           maxlength="16"
                           placeholder="Contoh: 320601xxxxxxxxxx"
                           class="w-full font-mono text-xs font-medium rounded-xl border border-slate-300 py-2.5 px-3.5 bg-white text-slate-900 placeholder:font-sans placeholder:text-slate-400 focus:ring-2 focus:ring-emerald-600/20 focus:border-emerald-600 focus:outline-none transition-colors shadow-2xs">
                </div>

                <div>
                    <label for="p1_tgl_kedatangan" class="block font-semibold text-slate-800 mb-1.5">
                        5. Tanggal Kedatangan <span class="text-rose-600 font-bold" aria-hidden="true">*</span>
                    </label>
                    <input type="date"
                           id="p1_tgl_kedatangan"
                           name="form_data[f_pindah_satu_desa][tgl_kedatangan]"
                           x-model="tglKedatangan"
                           required
                           aria-required="true"
                           class="w-full text-xs font-bold rounded-xl border border-slate-300 py-2.5 px-3.5 bg-white text-slate-900 focus:ring-2 focus:ring-emerald-600/20 focus:border-emerald-600 focus:outline-none transition-colors shadow-2xs">
                </div>
            </div>

            {{-- Baris 2: 3. NIK Kepala KK Tujuan & 4. Nama Kepala KK Tujuan --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="p1_nik_kepala_tujuan" class="block font-semibold text-slate-800 mb-1.5 flex items-center justify-between">
                        <span>3. NIK Kepala Keluarga Tujuan</span>
                        <span class="text-[11px] font-normal text-slate-400">16 digit angka</span>
                    </label>
                    <input type="text"
                           id="p1_nik_kepala_tujuan"
                           name="form_data[f_pindah_satu_desa][nik_kepala_tujuan]"
                           x-model="nikKepalaTujuan"
                           @input="nikKepalaTujuan = maskDigits($event.target.value, 16)"
                           inputmode="numeric"
                           maxlength="16"
                           placeholder="Contoh: 320601xxxxxxxxxx"
                           class="w-full font-mono text-xs font-medium rounded-xl border border-slate-300 py-2.5 px-3.5 bg-white text-slate-900 placeholder:font-sans placeholder:text-slate-400 focus:ring-2 focus:ring-emerald-600/20 focus:border-emerald-600 focus:outline-none transition-colors shadow-2xs">
                </div>

                <div>
                    <label for="p1_nama_kepala_tujuan" class="block font-semibold text-slate-800 mb-1.5">
                        4. Nama Kepala Keluarga Tujuan
                    </label>
                    <input type="text"
                           id="p1_nama_kepala_tujuan"
                           name="form_data[f_pindah_satu_desa][nama_kepala_tujuan]"
                           x-model="namaKepalaTujuan"
                           placeholder="Contoh: Budi Santoso"
                           class="w-full text-xs font-bold uppercase rounded-xl border border-slate-300 py-2.5 px-3.5 bg-white text-slate-900 placeholder:normal-case placeholder:font-normal placeholder:text-slate-400 focus:ring-2 focus:ring-emerald-600/20 focus:border-emerald-600 focus:outline-none transition-colors shadow-2xs">
                </div>
            </div>

            {{-- Baris 3: 6. Alamat Tujuan Baru (Kesatuan Alamat Lengkap) --}}
            <div class="p-4 rounded-xl bg-white border border-slate-200 space-y-3.5">
                <span class="block text-xs font-bold text-slate-800">
                    6. Alamat Tujuan Baru (Domisili Pindah) <span class="text-rose-600 font-bold" aria-hidden="true">*</span>
                </span>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-3.5">
                    {{-- Dusun/Jalan Tujuan --}}
                    <div class="md:col-span-8">
                        <label for="p1_dusun_tujuan" class="block font-medium text-slate-700 mb-1">
                            Nama Jalan / Dusun / Kampung Tujuan <span class="text-rose-600 font-bold" aria-hidden="true">*</span>
                        </label>
                        <input type="text"
                               id="p1_dusun_tujuan"
                               name="form_data[f_pindah_satu_desa][dusun_tujuan]"
                               x-model="dusunTujuan"
                               required
                               aria-required="true"
                               placeholder="Contoh: Dusun Ciharulang, Gang Melati No. 5"
                               class="w-full text-xs font-medium rounded-xl border border-slate-300 py-2.5 px-3.5 bg-white text-slate-900 placeholder:text-slate-400 focus:ring-2 focus:ring-emerald-600/20 focus:border-emerald-600 focus:outline-none transition-colors shadow-2xs">
                    </div>

                    {{-- RT & RW Tujuan dalam inline container --}}
                    <div class="md:col-span-4">
                        <span class="block font-medium text-slate-700 mb-1">Wilayah Mikro Tujuan (RT / RW) <span class="text-rose-600 font-bold" aria-hidden="true">*</span></span>
                        <div class="flex items-center gap-2 p-1 bg-slate-50 rounded-xl border border-slate-300 shadow-2xs">
                            <div class="flex-1 flex items-center gap-1.5 pl-2">
                                <label for="p1_rt_tujuan" class="text-[11px] font-bold text-slate-500 shrink-0">RT</label>
                                <input type="text"
                                       id="p1_rt_tujuan"
                                       name="form_data[f_pindah_satu_desa][rt_tujuan]"
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
                                <label for="p1_rw_tujuan" class="text-[11px] font-bold text-slate-500 shrink-0">RW</label>
                                <input type="text"
                                       id="p1_rw_tujuan"
                                       name="form_data[f_pindah_satu_desa][rw_tujuan]"
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

                {{-- Desa Tujuan (Tetap satu desa) --}}
                <div class="pt-1">
                    <label class="block font-medium text-slate-700 mb-1">Desa / Kelurahan Tujuan</label>
                    <input type="text"
                           name="form_data[f_pindah_satu_desa][desa_tujuan]"
                           :value="desaName || 'Kecamatan Manonjaya'"
                           readonly
                           aria-readonly="true"
                           tabindex="-1"
                           class="w-full text-xs font-bold uppercase rounded-xl border border-slate-200 py-2.5 px-3.5 bg-[#F3F4F6] text-slate-700 cursor-not-allowed select-none shadow-2xs">
                </div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         BAGIAN 3: 7. KELUARGA YANG PINDAH / DATANG
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="p-6 bg-slate-50/50 space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h3 class="text-xs font-black uppercase tracking-wider text-slate-800 flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-indigo-600"></span>
                    <span>7. KELUARGA YANG DATANG / PINDAH</span>
                </h3>
                <p class="text-[11px] text-slate-500 mt-0.5">Cantumkan semua anggota keluarga yang ikut pindah domisili bersama pemohon.</p>
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
                                           :name="'form_data[f_pindah_satu_desa][anggota][' + index + '][nik]'"
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
                                           :name="'form_data[f_pindah_satu_desa][anggota][' + index + '][nama]'"
                                           x-model="item.nama"
                                           required
                                           aria-required="true"
                                           placeholder="Nama lengkap sesuai KTP"
                                           class="w-full text-xs font-bold uppercase rounded-lg border border-slate-300 py-1.5 px-2.5 bg-white text-slate-900 placeholder:normal-case placeholder:font-normal placeholder:text-slate-400 focus:ring-1 focus:ring-blue-600 focus:border-blue-600 focus:outline-none shadow-2xs">
                                </td>
                                <td class="p-3">
                                    <input type="text"
                                           :name="'form_data[f_pindah_satu_desa][anggota][' + index + '][ktp_sd]'"
                                           x-model="item.ktpSd"
                                           placeholder="Seumur hidup"
                                           class="w-full text-xs font-medium rounded-lg border border-slate-300 py-1.5 px-2.5 bg-white text-slate-900 focus:ring-1 focus:ring-blue-600 focus:border-blue-600 focus:outline-none shadow-2xs">
                                </td>
                                <td class="p-3">
                                    <select :name="'form_data[f_pindah_satu_desa][anggota][' + index + '][shdk]'"
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
