@php
    $kecamatanMap = ($kecamatans ?? collect())->mapWithKeys(function($k) {
        return [
            strtoupper($k->nama_kecamatan) => $k->desas ? $k->desas->pluck('nama_desa')->map(fn($d) => strtoupper($d))->values() : []
        ];
    });
    $defaultKec = strtoupper($user->kecamatan?->nama_kecamatan ?? 'SINGAPARNA');
@endphp

<div x-data="{
    userName: @js($user->name),
    userNik: @js($user->nik ?? ''),
    userPhone: @js($user->phone ?? ''),
    userEmail: @js($user->email ?? ''),
    userAlamat: @js($user->alamat_detail ?? ''),
    kecamatanMap: @js($kecamatanMap),
    kecamatanAsalName: @js($user->kecamatan?->nama_kecamatan ?? 'SINGAPARNA'),
    desaAsalName: @js($user->desa?->nama_desa ?? ''),
    noKk: '',
    namaKepala: '',
    dusunAsal: '',
    rtAsal: '001',
    rwAsal: '001',
    kodePosAsal: '46182',
    teleponAsal: @js($user->phone ?? ''),
    
    alasanPindah: '1', // 1. Pekerjaan, 2. Pendidikan, 3. Keamanan, 4. Kesehatan, 5. Perumahan, 6. Keluarga, 7. Lainnya
    alasanLainnya: '',
    kecamatanTujuan: '',
    desaTujuan: '',
    dusunTujuan: '',
    rtTujuan: '001',
    rwTujuan: '001',
    kodePosTujuan: '46182',
    teleponTujuan: '',
    
    jenisKepindahan: '2', // 1. Kep. Keluarga, 2. Kep. Keluarga dan Seluruh Angg. Keluarga, 3. Kep. Keluarga dan Sbg. Angg. Keluarga, 4. Angg. Keluarga
    statusKkTidakPindah: '3', // 1. Numpang KK, 2. Membuat KK Baru, 3. Nomor KK Tetap
    statusKkPindah: '2', // 1. Numpang KK, 2. Membuat KK Baru, 3. Nomor KK Tetap
    
    anggota: [
        { nik: @js($user->nik ?? ''), nama: @js($user->name), ktpSd: 'SEUMUR HIDUP', shdk: 'Kepala Keluarga' }
    ],
    get desasTujuanList() {
        if (!this.kecamatanTujuan) return [];
        return this.kecamatanMap[this.kecamatanTujuan] || [];
    },
    addAnggota() {
        this.anggota.push({ nik: '', nama: '', ktpSd: 'SEUMUR HIDUP', shdk: 'Anggota Keluarga' });
    },
    removeAnggota(index) {
        if (this.anggota.length > 1) {
            this.anggota.splice(index, 1);
        }
    }
}" class="bg-white rounded-2xl border border-slate-200 shadow-md overflow-hidden space-y-0 transition-all font-sans">

    {{-- HEADER FORMULIR F.1-29 --}}
    <div class="p-6 bg-gradient-to-r from-blue-900 via-indigo-900 to-slate-900 text-white flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-400/20 border border-blue-400/30 text-blue-200 text-xs font-bold uppercase tracking-wider mb-2">
                <i data-lucide="file-text" class="w-4 h-4 text-blue-300"></i>
                <span>FORM F.1-29 — DUKCAPIL</span>
            </div>
            <h2 class="text-xl sm:text-2xl font-black tracking-wide text-white uppercase">
                FORMULIR PERMOHONAN PINDAH WNI
            </h2>
            <p class="text-xs text-blue-100/80 mt-1 max-w-2xl leading-relaxed">
                Antar Kecamatan Dalam Satu Kabupaten / Kota
            </p>
        </div>

        <div class="flex items-center gap-3 bg-white/10 backdrop-blur-md px-4 py-3 rounded-2xl border border-white/15">
            <div class="text-right">
                <span class="block text-[11px] text-blue-200 font-medium">Format Resmi</span>
                <span class="text-sm font-black text-white">F.1-29 (Antar Kecamatan)</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-blue-500 text-white flex items-center justify-center font-black text-base shadow-sm">
                <i data-lucide="map" class="w-5 h-5"></i>
            </div>
        </div>
    </div>

    {{-- INFO WILAYAH ADMINISTRATIVE --}}
    <div class="p-4 bg-slate-100 border-b border-slate-200 text-xs text-slate-700 grid grid-cols-2 sm:grid-cols-4 gap-3">
        <div><span class="font-bold text-slate-500">PROVINSI:</span> <span class="font-bold text-slate-900">JAWA BARAT</span></div>
        <div><span class="font-bold text-slate-500">KABUPATEN:</span> <span class="font-bold text-slate-900">TASIKMALAYA</span></div>
        <div><span class="font-bold text-slate-500">KECAMATAN ASAL:</span> <span class="font-bold text-slate-900 uppercase" x-text="kecamatanAsalName"></span></div>
        <div><span class="font-bold text-slate-500">DESA ASAL:</span> <span class="font-bold text-slate-900 uppercase" x-text="desaAsalName"></span></div>
    </div>

    {{-- BAGIAN 1: DATA DAERAH ASAL --}}
    <div class="p-6 bg-slate-50/80 border-b border-slate-200 space-y-4">
        <h3 class="text-xs font-black uppercase tracking-wider text-slate-800 flex items-center gap-2">
            <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
            <span>DATA DAERAH ASAL</span>
        </h3>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-4 text-xs">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block font-bold text-slate-800 mb-1">1. Nomor Kartu Keluarga <span class="text-rose-600">*</span></label>
                    <input type="text" name="form_data[f_pindah_antar_kecamatan][no_kk]" x-model="noKk" required maxlength="16" placeholder="16 Digit Nomor KK" class="w-full text-xs font-bold rounded-xl border-slate-300 py-2.5 px-3 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-600">
                </div>
                <div>
                    <label class="block font-bold text-slate-800 mb-1">2. Nama Kepala Keluarga <span class="text-rose-600">*</span></label>
                    <input type="text" name="form_data[f_pindah_antar_kecamatan][nama_kepala]" x-model="namaKepala" required placeholder="Nama Kepala Keluarga" class="w-full text-xs font-bold uppercase rounded-xl border-slate-300 py-2.5 px-3 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-600">
                </div>
                <div>
                    <label class="block font-bold text-slate-800 mb-1">4. NIK Pemohon <span class="text-rose-600">*</span></label>
                    <input type="text" name="form_data[f_pindah_antar_kecamatan][nik_pemohon]" :value="userNik" readonly class="w-full text-xs font-bold uppercase rounded-xl border-slate-200 py-2.5 px-3 bg-slate-100 text-slate-700">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-2">
                    <label class="block font-bold text-slate-800 mb-1">5. Nama Lengkap Pemohon</label>
                    <input type="text" name="form_data[f_pindah_antar_kecamatan][nama_pemohon]" :value="userName" readonly class="w-full text-xs font-bold uppercase rounded-xl border-slate-200 py-2.5 px-3 bg-slate-100 text-slate-700">
                </div>
                <div>
                    <label class="block font-bold text-slate-800 mb-1">Kode Pos</label>
                    <input type="text" name="form_data[f_pindah_antar_kecamatan][kode_pos_asal]" x-model="kodePosAsal" placeholder="46182" class="w-full text-xs font-medium rounded-xl border-slate-300 py-2.5 px-3 bg-slate-50">
                </div>
                <div>
                    <label class="block font-bold text-slate-800 mb-1">Telepon / HP</label>
                    <input type="text" name="form_data[f_pindah_antar_kecamatan][telepon_asal]" x-model="teleponAsal" placeholder="08xxxxxxxxxx" class="w-full text-xs font-medium rounded-xl border-slate-300 py-2.5 px-3 bg-slate-50">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-2">
                    <label class="block font-bold text-slate-800 mb-1">3. Alamat Asal (Dusun / Dukuh / Kampung) <span class="text-rose-600">*</span></label>
                    <input type="text" name="form_data[f_pindah_antar_kecamatan][dusun_asal]" x-model="dusunAsal" required placeholder="Contoh: Dusun Sukahaji" class="w-full text-xs font-medium uppercase rounded-xl border-slate-300 py-2.5 px-3 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-600">
                </div>
                <div>
                    <label class="block font-bold text-slate-800 mb-1">RT / RW Asal <span class="text-rose-600">*</span></label>
                    <div class="grid grid-cols-2 gap-2">
                        <input type="text" name="form_data[f_pindah_antar_kecamatan][rt_asal]" x-model="rtAsal" placeholder="RT" class="w-full text-xs font-medium rounded-xl border-slate-300 py-2.5 px-3 bg-slate-50">
                        <input type="text" name="form_data[f_pindah_antar_kecamatan][rw_asal]" x-model="rwAsal" placeholder="RW" class="w-full text-xs font-medium rounded-xl border-slate-300 py-2.5 px-3 bg-slate-50">
                    </div>
                </div>
                <div>
                    <label class="block font-bold text-slate-800 mb-1">Desa / Kelurahan Asal</label>
                    <input type="text" name="form_data[f_pindah_antar_kecamatan][desa_asal]" :value="desaAsalName" readonly class="w-full text-xs font-bold uppercase rounded-xl border-slate-200 py-2.5 px-3 bg-slate-100 text-slate-700">
                </div>
            </div>
        </div>
    </div>

    {{-- BAGIAN 2: DATA KEPINDAHAN --}}
    <div class="p-6 bg-white border-b border-slate-200 space-y-4">
        <h3 class="text-xs font-black uppercase tracking-wider text-slate-800 flex items-center gap-2">
            <span class="w-2.5 h-2.5 rounded-full bg-emerald-600"></span>
            <span>DATA KEPINDAHAN (Antar Kecamatan Dalam Kab. Tasikmalaya)</span>
        </h3>

        <div class="bg-slate-50/70 p-5 rounded-2xl border border-slate-200 space-y-4 text-xs">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block font-bold text-slate-800 mb-1">1. Alasan Pindah <span class="text-rose-600">*</span></label>
                    <select name="form_data[f_pindah_antar_kecamatan][alasan_pindah]" x-model="alasanPindah" class="w-full text-xs font-bold rounded-xl border-slate-300 py-2.5 px-3 bg-white focus:ring-2 focus:ring-emerald-600">
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
                    <label class="block font-bold text-slate-800 mb-1">Sebutkan Alasan Lainnya</label>
                    <input type="text" name="form_data[f_pindah_antar_kecamatan][alasan_lainnya]" x-model="alasanLainnya" placeholder="Alasan Kepindahan" class="w-full text-xs font-medium rounded-xl border-slate-300 py-2.5 px-3 bg-white">
                </div>
                <div>
                    <label class="block font-bold text-slate-800 mb-1">b. Kecamatan Tujuan <span class="text-rose-600">*</span></label>
                    <select name="form_data[f_pindah_antar_kecamatan][kecamatan_tujuan]" x-model="kecamatanTujuan" @change="desaTujuan = ''" required class="w-full text-xs font-bold uppercase rounded-xl border-slate-300 py-2.5 px-3 bg-white focus:ring-2 focus:ring-emerald-600">
                        <option value="">-- Pilih Kecamatan Tujuan --</option>
                        <template x-for="(desas, kec) in kecamatanMap" :key="kec">
                            <option :value="kec" x-text="kec" :disabled="kec === kecamatanAsalName.toUpperCase()"></option>
                        </template>
                    </select>
                </div>
                <div>
                    <label class="block font-bold text-slate-800 mb-1">a. Desa / Kelurahan Tujuan <span class="text-rose-600">*</span></label>
                    <select name="form_data[f_pindah_antar_kecamatan][desa_tujuan]" x-model="desaTujuan" required :disabled="!kecamatanTujuan" class="w-full text-xs font-bold uppercase rounded-xl border-slate-300 py-2.5 px-3 bg-white focus:ring-2 focus:ring-emerald-600 disabled:bg-slate-100 disabled:text-slate-400">
                        <option value="">-- Pilih Desa Tujuan --</option>
                        <template x-for="desa in desasTujuanList" :key="desa">
                            <option :value="desa" x-text="desa"></option>
                        </template>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-2">
                    <label class="block font-bold text-slate-800 mb-1">2. Alamat Tujuan Pindah (Dusun / Dukuh / Kampung) <span class="text-rose-600">*</span></label>
                    <input type="text" name="form_data[f_pindah_antar_kecamatan][dusun_tujuan]" x-model="dusunTujuan" required placeholder="Contoh: Dusun Ciharulang" class="w-full text-xs font-medium uppercase rounded-xl border-slate-300 py-2.5 px-3 bg-white focus:ring-2 focus:ring-emerald-600">
                </div>
                <div>
                    <label class="block font-bold text-slate-800 mb-1">RT / RW Tujuan <span class="text-rose-600">*</span></label>
                    <div class="grid grid-cols-2 gap-2">
                        <input type="text" name="form_data[f_pindah_antar_kecamatan][rt_tujuan]" x-model="rtTujuan" placeholder="RT" class="w-full text-xs font-medium rounded-xl border-slate-300 py-2.5 px-3 bg-white">
                        <input type="text" name="form_data[f_pindah_antar_kecamatan][rw_tujuan]" x-model="rwTujuan" placeholder="RW" class="w-full text-xs font-medium rounded-xl border-slate-300 py-2.5 px-3 bg-white">
                    </div>
                </div>
                <div>
                    <label class="block font-bold text-slate-800 mb-1">Kode Pos & Telepon</label>
                    <div class="grid grid-cols-2 gap-2">
                        <input type="text" name="form_data[f_pindah_antar_kecamatan][kode_pos_tujuan]" x-model="kodePosTujuan" placeholder="Kode Pos" class="w-full text-xs font-medium rounded-xl border-slate-300 py-2.5 px-3 bg-white">
                        <input type="text" name="form_data[f_pindah_antar_kecamatan][telepon_tujuan]" x-model="teleponTujuan" placeholder="Telepon" class="w-full text-xs font-medium rounded-xl border-slate-300 py-2.5 px-3 bg-white">
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block font-bold text-slate-800 mb-1">3. Jenis Kepindahan <span class="text-rose-600">*</span></label>
                    <select name="form_data[f_pindah_antar_kecamatan][jenis_kepindahan]" x-model="jenisKepindahan" class="w-full text-xs font-medium rounded-xl border-slate-300 py-2.5 px-3 bg-white">
                        <option value="1">1. Kep. Keluarga</option>
                        <option value="2">2. Kep. Keluarga dan Seluruh Angg. Keluarga</option>
                        <option value="3">3. Kep. Keluarga dan Sbg. Angg. Keluarga</option>
                        <option value="4">4. Angg. Keluarga</option>
                    </select>
                </div>
                <div>
                    <label class="block font-bold text-slate-800 mb-1">4. Status KK Bagi Yang Tidak Pindah <span class="text-rose-600">*</span></label>
                    <select name="form_data[f_pindah_antar_kecamatan][status_kk_tidak_pindah]" x-model="statusKkTidakPindah" class="w-full text-xs font-medium rounded-xl border-slate-300 py-2.5 px-3 bg-white">
                        <option value="1">1. Numpang KK</option>
                        <option value="2">2. Membuat KK Baru</option>
                        <option value="3">3. Nomor KK Tetap</option>
                    </select>
                </div>
                <div>
                    <label class="block font-bold text-slate-800 mb-1">5. Status KK Bagi Yang Pindah <span class="text-rose-600">*</span></label>
                    <select name="form_data[f_pindah_antar_kecamatan][status_kk_pindah]" x-model="statusKkPindah" class="w-full text-xs font-medium rounded-xl border-slate-300 py-2.5 px-3 bg-white">
                        <option value="1">1. Numpang KK</option>
                        <option value="2">2. Membuat KK Baru</option>
                        <option value="3">3. Nomor KK Tetap</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    {{-- BAGIAN 3: 6. KELUARGA YANG PINDAH --}}
    <div class="p-6 bg-slate-50/50 space-y-4">
        <div class="flex items-center justify-between">
            <h3 class="text-xs font-black uppercase tracking-wider text-slate-800 flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-indigo-600"></span>
                <span>6. KELUARGA YANG PINDAH</span>
            </h3>
            <button type="button" @click="addAnggota()" class="px-3 py-1.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs flex items-center gap-1.5 shadow-2xs">
                <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                <span>Tambah Anggota</span>
            </button>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-100/80 text-slate-700 border-b border-slate-200 font-bold uppercase tracking-wider">
                    <tr>
                        <th class="p-3 w-12 text-center">NO</th>
                        <th class="p-3">NIK</th>
                        <th class="p-3">NAMA</th>
                        <th class="p-3">MASA BERLAKU KTP S/D</th>
                        <th class="p-3">SHDK</th>
                        <th class="p-3 w-16 text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <template x-for="(item, index) in anggota" :key="index">
                        <tr class="hover:bg-slate-50/60">
                            <td class="p-3 text-center font-bold text-slate-500" x-text="index + 1"></td>
                            <td class="p-3">
                                <input type="text" :name="'form_data[f_pindah_antar_kecamatan][anggota][' + index + '][nik]'" x-model="item.nik" maxlength="16" placeholder="16 Digit NIK" class="w-full text-xs font-medium rounded-lg border-slate-300 py-1.5 px-2 bg-slate-50">
                            </td>
                            <td class="p-3">
                                <input type="text" :name="'form_data[f_pindah_antar_kecamatan][anggota][' + index + '][nama]'" x-model="item.nama" placeholder="Nama Lengkap" class="w-full text-xs font-bold uppercase rounded-lg border-slate-300 py-1.5 px-2 bg-slate-50">
                            </td>
                            <td class="p-3">
                                <input type="text" :name="'form_data[f_pindah_antar_kecamatan][anggota][' + index + '][ktp_sd]'" x-model="item.ktpSd" placeholder="SEUMUR HIDUP" class="w-full text-xs font-medium rounded-lg border-slate-300 py-1.5 px-2 bg-slate-50">
                            </td>
                            <td class="p-3">
                                <select :name="'form_data[f_pindah_antar_kecamatan][anggota][' + index + '][shdk]'" x-model="item.shdk" class="w-full text-xs font-medium rounded-lg border-slate-300 py-1.5 px-2 bg-slate-50">
                                    <option value="Kepala Keluarga">Kepala Keluarga</option>
                                    <option value="Suami">Suami</option>
                                    <option value="Istri">Istri</option>
                                    <option value="Anak">Anak</option>
                                    <option value="Famili Lain">Famili Lain</option>
                                </select>
                            </td>
                            <td class="p-3 text-center">
                                <button type="button" @click="removeAnggota(index)" x-show="anggota.length > 1" class="p-1.5 rounded-lg text-rose-600 hover:bg-rose-50">
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
