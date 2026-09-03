<div x-data="f101BiodataComponent({
    userName: @js($user->name),
    userNik: @js($user->nik ?? ''),
    userPhone: @js($user->phone ?? ''),
    userEmail: @js($user->email ?? ''),
    userAlamat: @js($user->alamat_detail ?? ''),
    kecamatanName: @js($user->kecamatan?->nama_kecamatan ?? ''),
    desaName: @js($user->desa?->nama_desa ?? '')
})" class="bg-white rounded-2xl border-2 border-blue-200/80 shadow-md overflow-hidden space-y-0 transition-all">

    {{-- Header Banner F-1.01 --}}
    <div class="bg-gradient-to-r from-[#0a2558] via-[#12397d] to-[#1e5799] text-white p-5 sm:p-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="space-y-1">
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-0.5 rounded-md bg-amber-400 text-slate-900 font-extrabold text-[11px] uppercase tracking-wider shadow-xs">
                        FORMULIR F-1.01
                    </span>
                    <span class="text-xs text-blue-200 font-medium">Standar Ditjen Dukcapil Kemendagri</span>
                </div>
                <h3 class="text-lg sm:text-xl font-bold tracking-tight text-white">
                    Formulir Biodata Keluarga
                </h3>
                <p class="text-xs text-blue-100/90 leading-relaxed max-w-2xl">
                    Silakan isi formulir biodata keluarga secara digital di bawah ini. Data ini digunakan untuk penerbitan Kartu Keluarga (KK) baru dan langsung tersimpan ke sistem.
                </p>
            </div>

            <div class="bg-white/10 backdrop-blur-md rounded-xl p-3 border border-white/20 text-center sm:text-right shrink-0">
                <span class="text-[11px] text-blue-200 block uppercase font-medium">Jumlah Anggota Keluarga</span>
                <span class="text-2xl font-black text-white" x-text="anggota.length + ' Orang'"></span>
            </div>
        </div>

        {{-- Nav Tabs Form --}}
        <div class="flex flex-wrap gap-2 pt-5 border-t border-white/15 mt-5">
            <button type="button"
                    @click="activeTab = 'kepala'"
                    :class="activeTab === 'kepala' ? 'bg-white text-[#0a2558] shadow-sm font-bold' : 'bg-white/10 text-white hover:bg-white/20 font-medium'"
                    class="px-4 py-2 rounded-xl text-xs flex items-center gap-2 transition-all">
                <i data-lucide="user-check" class="w-4 h-4"></i>
                <span>1. Data Kepala Keluarga & Alamat</span>
            </button>

            <button type="button"
                    @click="activeTab = 'wilayah'"
                    :class="activeTab === 'wilayah' ? 'bg-white text-[#0a2558] shadow-sm font-bold' : 'bg-white/10 text-white hover:bg-white/20 font-medium'"
                    class="px-4 py-2 rounded-xl text-xs flex items-center gap-2 transition-all">
                <i data-lucide="map-pin" class="w-4 h-4"></i>
                <span>2. Data Wilayah Domisili</span>
            </button>

            <button type="button"
                    @click="activeTab = 'anggota'"
                    :class="activeTab === 'anggota' ? 'bg-white text-[#0a2558] shadow-sm font-bold' : 'bg-white/10 text-white hover:bg-white/20 font-medium'"
                    class="px-4 py-2 rounded-xl text-xs flex items-center gap-2 transition-all">
                <i data-lucide="users" class="w-4 h-4"></i>
                <span>3. Rincian Anggota Keluarga</span>
                <span class="px-1.5 py-0.2 rounded-full text-[10px] font-bold"
                      :class="activeTab === 'anggota' ? 'bg-blue-100 text-blue-800' : 'bg-white/20 text-white'"
                      x-text="anggota.length"></span>
            </button>
        </div>
    </div>

    {{-- Content Container --}}
    <div class="p-5 sm:p-7 space-y-6">

        {{-- ═══════════════════════════════════════════════════════════════════════
             TAB 1: DATA KEPALA KELUARGA & ALAMAT
        ═══════════════════════════════════════════════════════════════════════ --}}
        <div x-show="activeTab === 'kepala'" class="space-y-5">
            {{-- Pilihan Jenis Pemohon --}}
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80 space-y-2">
                <label class="block text-xs font-bold text-slate-800 uppercase tracking-wide">
                    Pilihan Jenis Formulir Kependudukan:
                </label>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs">
                    <label class="flex items-center gap-2 p-3 rounded-lg border bg-white cursor-pointer hover:border-blue-500 transition-colors"
                           :class="jenisPilihan === 'wni' ? 'border-blue-600 bg-blue-50/50 text-blue-900 font-bold' : 'border-slate-200 text-slate-700'">
                        <input type="radio" name="form_data[f101][jenis_pilihan]" value="wni" x-model="jenisPilihan" class="text-blue-600">
                        <span>Kepala & Anggota Keluarga WNI</span>
                    </label>

                    <label class="flex items-center gap-2 p-3 rounded-lg border bg-white cursor-pointer hover:border-blue-500 transition-colors"
                           :class="jenisPilihan === 'asing' ? 'border-blue-600 bg-blue-50/50 text-blue-900 font-bold' : 'border-slate-200 text-slate-700'">
                        <input type="radio" name="form_data[f101][jenis_pilihan]" value="asing" x-model="jenisPilihan" class="text-blue-600">
                        <span>Keluarga Orang Asing (WNA)</span>
                    </label>

                    <label class="flex items-center gap-2 p-3 rounded-lg border bg-white cursor-pointer hover:border-blue-500 transition-colors"
                           :class="jenisPilihan === 'wni_luar_negeri' ? 'border-blue-600 bg-blue-50/50 text-blue-900 font-bold' : 'border-slate-200 text-slate-700'">
                        <input type="radio" name="form_data[f101][jenis_pilihan]" value="wni_luar_negeri" x-model="jenisPilihan" class="text-blue-600">
                        <span>WNI di Luar Negeri</span>
                    </label>
                </div>
            </div>

            {{-- Kolom Data Kepala Keluarga --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1">
                        1. Nama Kepala Keluarga <span class="text-rose-500">*</span>
                    </label>
                    <input type="text"
                           name="form_data[f101][nama_kepala_keluarga]"
                           x-model="kepalaKeluarga.nama"
                           required
                           placeholder="Nama lengkap kepala keluarga sesuai KTP"
                           class="w-full text-xs font-medium rounded-xl border-slate-300 bg-slate-50 focus:bg-white focus:border-blue-600 focus:ring-1 focus:ring-blue-600 py-2.5 px-3">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">
                        NIK Kepala Keluarga <span class="text-rose-500">*</span>
                    </label>
                    <input type="text"
                           name="form_data[f101][nik_kepala_keluarga]"
                           x-model="kepalaKeluarga.nik"
                           maxlength="16"
                           required
                           placeholder="16 Digit NIK Kepala Keluarga"
                           class="w-full text-xs font-mono font-medium rounded-xl border-slate-300 bg-slate-50 focus:bg-white focus:border-blue-600 focus:ring-1 focus:ring-blue-600 py-2.5 px-3">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">
                        Nomor Telepon / Handphone <span class="text-rose-500">*</span>
                    </label>
                    <input type="text"
                           name="form_data[f101][telepon]"
                           x-model="kepalaKeluarga.telepon"
                           required
                           placeholder="08xxxxxxxxxx"
                           class="w-full text-xs font-medium rounded-xl border-slate-300 bg-slate-50 focus:bg-white focus:border-blue-600 focus:ring-1 focus:ring-blue-600 py-2.5 px-3">
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1">
                        2. Alamat Lengkap Rumah <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="form_data[f101][alamat]"
                              x-model="kepalaKeluarga.alamat"
                              rows="2"
                              required
                              placeholder="Nama jalan, gang, nomor rumah"
                              class="w-full text-xs font-medium rounded-xl border-slate-300 bg-slate-50 focus:bg-white focus:border-blue-600 focus:ring-1 focus:ring-blue-600 p-3"></textarea>
                </div>

                <div class="grid grid-cols-3 gap-3 sm:col-span-2">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">4. RT <span class="text-rose-500">*</span></label>
                        <input type="text"
                               name="form_data[f101][rt]"
                               x-model="kepalaKeluarga.rt"
                               maxlength="3"
                               placeholder="001"
                               class="w-full text-xs font-mono font-medium rounded-xl border-slate-300 bg-slate-50 focus:bg-white focus:border-blue-600 focus:ring-1 focus:ring-blue-600 py-2.5 px-3">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">5. RW <span class="text-rose-500">*</span></label>
                        <input type="text"
                               name="form_data[f101][rw]"
                               x-model="kepalaKeluarga.rw"
                               maxlength="3"
                               placeholder="001"
                               class="w-full text-xs font-mono font-medium rounded-xl border-slate-300 bg-slate-50 focus:bg-white focus:border-blue-600 focus:ring-1 focus:ring-blue-600 py-2.5 px-3">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">3. Kode Pos</label>
                        <input type="text"
                               name="form_data[f101][kode_pos]"
                               x-model="kepalaKeluarga.kode_pos"
                               maxlength="5"
                               placeholder="46182"
                               class="w-full text-xs font-mono font-medium rounded-xl border-slate-300 bg-slate-50 focus:bg-white focus:border-blue-600 focus:ring-1 focus:ring-blue-600 py-2.5 px-3">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Email Kepala Keluarga</label>
                    <input type="email"
                           name="form_data[f101][email]"
                           x-model="kepalaKeluarga.email"
                           placeholder="alamat.email@domain.com"
                           class="w-full text-xs font-medium rounded-xl border-slate-300 bg-slate-50 focus:bg-white focus:border-blue-600 focus:ring-1 focus:ring-blue-600 py-2.5 px-3">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">6. Jumlah Anggota Keluarga</label>
                    <div class="p-2.5 bg-slate-100 rounded-xl text-xs font-bold text-slate-800 flex items-center justify-between border border-slate-200">
                        <span x-text="anggota.length + ' Orang Terdaftar'"></span>
                        <span class="text-[10px] text-slate-500 font-normal">Otomatis terhitung</span>
                    </div>
                    <input type="hidden" name="form_data[f101][jumlah_anggota]" :value="anggota.length">
                </div>
            </div>

            <div class="pt-3 flex justify-end">
                <button type="button"
                        @click="activeTab = 'wilayah'"
                        class="px-5 py-2.5 rounded-xl bg-[#0a2558] text-white text-xs font-bold hover:bg-blue-900 transition-colors flex items-center gap-2">
                    <span>Lanjut ke Data Wilayah</span>
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </button>
            </div>
        </div>

        {{-- ═══════════════════════════════════════════════════════════════════════
             TAB 2: DATA WILAYAH
        ═══════════════════════════════════════════════════════════════════════ --}}
        <div x-show="activeTab === 'wilayah'" class="space-y-5">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">9. Provinsi</label>
                    <input type="text"
                           name="form_data[f101][nama_provinsi]"
                           value="32 - JAWA BARAT"
                           readonly
                           class="w-full text-xs font-semibold rounded-xl border-slate-200 bg-slate-100 text-slate-600 py-2.5 px-3 cursor-not-allowed">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">10. Kabupaten / Kota</label>
                    <input type="text"
                           name="form_data[f101][nama_kabupaten]"
                           value="06 - KAB. TASIKMALAYA"
                           readonly
                           class="w-full text-xs font-semibold rounded-xl border-slate-200 bg-slate-100 text-slate-600 py-2.5 px-3 cursor-not-allowed">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">
                        11. Kecamatan <span class="text-rose-500">*</span>
                    </label>
                    <input type="text"
                           name="form_data[f101][nama_kecamatan]"
                           x-model="wilayah.kecamatan"
                           required
                           placeholder="Nama Kecamatan Domisili"
                           class="w-full text-xs font-medium rounded-xl border-slate-300 bg-slate-50 focus:bg-white focus:border-blue-600 focus:ring-1 focus:ring-blue-600 py-2.5 px-3">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">
                        12. Kelurahan / Desa <span class="text-rose-500">*</span>
                    </label>
                    <input type="text"
                           name="form_data[f101][nama_desa]"
                           x-model="wilayah.desa"
                           required
                           placeholder="Nama Desa / Kelurahan"
                           class="w-full text-xs font-medium rounded-xl border-slate-300 bg-slate-50 focus:bg-white focus:border-blue-600 focus:ring-1 focus:ring-blue-600 py-2.5 px-3">
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1">
                        13. Nama Dusun / Dukuh / Kampung <span class="text-rose-500">*</span>
                    </label>
                    <input type="text"
                           name="form_data[f101][nama_dusun]"
                           x-model="wilayah.dusun"
                           required
                           placeholder="Contoh: Kp. Kaum Wetan / Dusun Sukamaju"
                           class="w-full text-xs font-medium rounded-xl border-slate-300 bg-slate-50 focus:bg-white focus:border-blue-600 focus:ring-1 focus:ring-blue-600 py-2.5 px-3">
                </div>
            </div>

            <div class="pt-3 flex justify-between">
                <button type="button"
                        @click="activeTab = 'kepala'"
                        class="px-5 py-2.5 rounded-xl bg-slate-100 text-slate-700 text-xs font-bold hover:bg-slate-200 transition-colors flex items-center gap-2">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    <span>Kembali</span>
                </button>

                <button type="button"
                        @click="activeTab = 'anggota'"
                        class="px-5 py-2.5 rounded-xl bg-[#0a2558] text-white text-xs font-bold hover:bg-blue-900 transition-colors flex items-center gap-2">
                    <span>Lanjut ke Anggota Keluarga</span>
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </button>
            </div>
        </div>

        {{-- ═══════════════════════════════════════════════════════════════════════
             TAB 3: DATA ANGGOTA KELUARGA (Multi-Row Dinamis)
        ═══════════════════════════════════════════════════════════════════════ --}}
        <div x-show="activeTab === 'anggota'" class="space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-slate-100">
                <div>
                    <h4 class="text-sm font-bold text-slate-800">
                        Daftar Anggota Keluarga (Kolom 1 s.d 41 F-1.01)
                    </h4>
                    <p class="text-xs text-slate-500">
                        Masukkan seluruh anggota keluarga (Kepala Keluarga, Istri, Anak, dll.) yang akan dicantumkan dalam KK ini.
                    </p>
                </div>

                <button type="button"
                        @click="tambahAnggota()"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold transition-all shadow-xs shrink-0 cursor-pointer">
                    <i data-lucide="user-plus" class="w-4 h-4"></i>
                    <span>+ Tambah Anggota Keluarga</span>
                </button>
            </div>

            {{-- Kartu Anggota Per Baris --}}
            <div class="space-y-4">
                <template x-for="(item, index) in anggota" :key="index">
                    <div class="p-5 rounded-2xl border border-slate-200 bg-slate-50/70 hover:bg-white transition-all space-y-4 shadow-2xs">
                        
                        {{-- Header Row per Anggota --}}
                        <div class="flex items-center justify-between pb-3 border-b border-slate-200/80">
                            <div class="flex items-center gap-2.5">
                                <span class="w-7 h-7 rounded-lg bg-[#0a2558] text-white flex items-center justify-center font-bold text-xs"
                                      x-text="index + 1"></span>
                                <div>
                                    <span class="text-xs font-bold text-slate-800" x-text="item.nama || 'Anggota #' + (index + 1)"></span>
                                    <span class="ml-2 px-2 py-0.5 rounded text-[10px] font-bold bg-blue-100 text-blue-800 uppercase"
                                          x-text="item.shdk"></span>
                                </div>
                            </div>

                            <button type="button"
                                    x-show="anggota.length > 1"
                                    @click="hapusAnggota(index)"
                                    class="text-rose-600 hover:text-rose-800 p-1.5 rounded-lg hover:bg-rose-50 text-xs font-semibold flex items-center gap-1 transition-colors">
                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                <span>Hapus</span>
                            </button>
                        </div>

                        {{-- Form Kolom Anggota Keluarga --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3.5 text-xs">
                            {{-- Nama Lengkap --}}
                            <div class="md:col-span-2">
                                <label class="block font-bold text-slate-700 mb-1">
                                    Nama Lengkap <span class="text-rose-500">*</span>
                                </label>
                                <input type="text"
                                       :name="'form_data[f101][anggota][' + index + '][nama]'"
                                       x-model="item.nama"
                                       required
                                       placeholder="Nama lengkap sesuai akta / KTP"
                                       class="w-full text-xs font-medium rounded-xl border-slate-300 bg-white py-2 px-3 focus:ring-1 focus:ring-blue-600 focus:border-blue-600">
                            </div>

                            {{-- NIK --}}
                            <div class="md:col-span-2">
                                <label class="block font-bold text-slate-700 mb-1">
                                    NIK (16 Digit) <span class="text-rose-500">*</span>
                                </label>
                                <input type="text"
                                       :name="'form_data[f101][anggota][' + index + '][nik]'"
                                       x-model="item.nik"
                                       maxlength="16"
                                       required
                                       placeholder="3206xxxxxxxxxxxx"
                                       class="w-full text-xs font-mono font-medium rounded-xl border-slate-300 bg-white py-2 px-3 focus:ring-1 focus:ring-blue-600 focus:border-blue-600">
                            </div>

                            {{-- Jenis Kelamin --}}
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Jenis Kelamin <span class="text-rose-500">*</span></label>
                                <select :name="'form_data[f101][anggota][' + index + '][jenis_kelamin]'"
                                        x-model="item.jenis_kelamin"
                                        class="w-full text-xs font-medium rounded-xl border-slate-300 bg-white py-2 px-3 focus:ring-1 focus:ring-blue-600">
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>

                            {{-- Tempat Lahir --}}
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Tempat Lahir <span class="text-rose-500">*</span></label>
                                <input type="text"
                                       :name="'form_data[f101][anggota][' + index + '][tempat_lahir]'"
                                       x-model="item.tempat_lahir"
                                       required
                                       placeholder="Kota/Kab. Lahir"
                                       class="w-full text-xs font-medium rounded-xl border-slate-300 bg-white py-2 px-3 focus:ring-1 focus:ring-blue-600">
                            </div>

                            {{-- Tanggal Lahir --}}
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Tanggal Lahir <span class="text-rose-500">*</span></label>
                                <input type="date"
                                       :name="'form_data[f101][anggota][' + index + '][tanggal_lahir]'"
                                       x-model="item.tanggal_lahir"
                                       required
                                       class="w-full text-xs font-medium rounded-xl border-slate-300 bg-white py-2 px-3 focus:ring-1 focus:ring-blue-600">
                            </div>

                            {{-- Golongan Darah --}}
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Golongan Darah</label>
                                <select :name="'form_data[f101][anggota][' + index + '][gol_darah]'"
                                        x-model="item.gol_darah"
                                        class="w-full text-xs font-medium rounded-xl border-slate-300 bg-white py-2 px-3 focus:ring-1 focus:ring-blue-600">
                                    <option value="-">Tidak Tahu</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="AB">AB</option>
                                    <option value="O">O</option>
                                    <option value="A+">A+</option>
                                    <option value="A-">A-</option>
                                    <option value="B+">B+</option>
                                    <option value="B-">B-</option>
                                    <option value="AB+">AB+</option>
                                    <option value="AB-">AB-</option>
                                    <option value="O+">O+</option>
                                    <option value="O-">O-</option>
                                </select>
                            </div>

                            {{-- Agama --}}
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Agama <span class="text-rose-500">*</span></label>
                                <select :name="'form_data[f101][anggota][' + index + '][agama]'"
                                        x-model="item.agama"
                                        class="w-full text-xs font-medium rounded-xl border-slate-300 bg-white py-2 px-3 focus:ring-1 focus:ring-blue-600">
                                    <option value="Islam">Islam</option>
                                    <option value="Kristen Protestan">Kristen Protestan</option>
                                    <option value="Katolik">Katolik</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Buddha">Buddha</option>
                                    <option value="Konghucu">Konghucu</option>
                                    <option value="Kepercayaan Lainnya">Kepercayaan Terhadap Tuhan YME</option>
                                </select>
                            </div>

                            {{-- SHDK --}}
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Hubungan Keluarga (SHDK) <span class="text-rose-500">*</span></label>
                                <select :name="'form_data[f101][anggota][' + index + '][shdk]'"
                                        x-model="item.shdk"
                                        class="w-full text-xs font-medium rounded-xl border-slate-300 bg-white py-2 px-3 focus:ring-1 focus:ring-blue-600">
                                    <option value="Kepala Keluarga">Kepala Keluarga</option>
                                    <option value="Suami">Suami</option>
                                    <option value="Istri">Istri</option>
                                    <option value="Anak">Anak</option>
                                    <option value="Menantu">Menantu</option>
                                    <option value="Cucu">Cucu</option>
                                    <option value="Orang Tua">Orang Tua</option>
                                    <option value="Mertua">Mertua</option>
                                    <option value="Famili Lain">Famili Lain</option>
                                    <option value="Pembantu">Pembantu</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>

                            {{-- Status Perkawinan --}}
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Status Perkawinan <span class="text-rose-500">*</span></label>
                                <select :name="'form_data[f101][anggota][' + index + '][status_kawin]'"
                                        x-model="item.status_kawin"
                                        class="w-full text-xs font-medium rounded-xl border-slate-300 bg-white py-2 px-3 focus:ring-1 focus:ring-blue-600">
                                    <option value="Belum Kawin">Belum Kawin</option>
                                    <option value="Kawin Tercatat">Kawin Tercatat</option>
                                    <option value="Kawin Belum Tercatat">Kawin Belum Tercatat</option>
                                    <option value="Cerai Hidup">Cerai Hidup</option>
                                    <option value="Cerai Mati">Cerai Mati</option>
                                </select>
                            </div>

                            {{-- Pendidikan --}}
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Pendidikan Terakhir <span class="text-rose-500">*</span></label>
                                <select :name="'form_data[f101][anggota][' + index + '][pendidikan]'"
                                        x-model="item.pendidikan"
                                        class="w-full text-xs font-medium rounded-xl border-slate-300 bg-white py-2 px-3 focus:ring-1 focus:ring-blue-600">
                                    <option value="Tidak / Belum Sekolah">Tidak / Belum Sekolah</option>
                                    <option value="Belum Tamat SD/Sederajat">Belum Tamat SD/Sederajat</option>
                                    <option value="Tamat SD / Sederajat">Tamat SD / Sederajat</option>
                                    <option value="SLTP / Sederajat">SLTP / Sederajat</option>
                                    <option value="SLTA / Sederajat">SLTA / Sederajat</option>
                                    <option value="Diploma I / II">Diploma I / II</option>
                                    <option value="Akademi / Diploma III / Sarjana Muda">Akademi / D-III / S. Muda</option>
                                    <option value="Diploma IV / Strata I">Diploma IV / Strata I</option>
                                    <option value="Strata II">Strata II</option>
                                    <option value="Strata III">Strata III</option>
                                </select>
                            </div>

                            {{-- Pekerjaan --}}
                            <div class="md:col-span-2">
                                <label class="block font-bold text-slate-700 mb-1">Jenis Pekerjaan <span class="text-rose-500">*</span></label>
                                <select :name="'form_data[f101][anggota][' + index + '][pekerjaan]'"
                                        x-model="item.pekerjaan"
                                        class="w-full text-xs font-medium rounded-xl border-slate-300 bg-white py-2 px-3 focus:ring-1 focus:ring-blue-600">
                                    <option value="Belum / Tidak Bekerja">Belum / Tidak Bekerja</option>
                                    <option value="Mengurus Rumah Tangga">Mengurus Rumah Tangga</option>
                                    <option value="Pelajar / Mahasiswa">Pelajar / Mahasiswa</option>
                                    <option value="Pegawai Negeri Sipil (PNS)">Pegawai Negeri Sipil (PNS)</option>
                                    <option value="TNI / Polri">TNI / Polri</option>
                                    <option value="Karyawan Swasta">Karyawan Swasta</option>
                                    <option value="Karyawan BUMN / BUMD">Karyawan BUMN / BUMD</option>
                                    <option value="Wiraswasta">Wiraswasta</option>
                                    <option value="Petani / Pekebun">Petani / Pekebun</option>
                                    <option value="Buruh Harian Lepas">Buruh Harian Lepas</option>
                                    <option value="Pedagang">Pedagang</option>
                                    <option value="Pensiunan">Pensiunan</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>

                            {{-- No Akta Lahir --}}
                            <div class="md:col-span-2">
                                <label class="block font-bold text-slate-700 mb-1">Nomor Akta Kelahiran (Jika Ada)</label>
                                <input type="text"
                                       :name="'form_data[f101][anggota][' + index + '][no_akta_lahir]'"
                                       x-model="item.no_akta_lahir"
                                       placeholder="Nomor kutipan akta lahir"
                                       class="w-full text-xs font-medium rounded-xl border-slate-300 bg-white py-2 px-3 focus:ring-1 focus:ring-blue-600">
                            </div>

                            {{-- Orang Tua --}}
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Nama Ibu Kandung <span class="text-rose-500">*</span></label>
                                <input type="text"
                                       :name="'form_data[f101][anggota][' + index + '][nama_ibu]'"
                                       x-model="item.nama_ibu"
                                       required
                                       placeholder="Nama ibu kandung"
                                       class="w-full text-xs font-medium rounded-xl border-slate-300 bg-white py-2 px-3 focus:ring-1 focus:ring-blue-600">
                            </div>

                            <div>
                                <label class="block font-bold text-slate-700 mb-1">NIK Ibu Kandung</label>
                                <input type="text"
                                       :name="'form_data[f101][anggota][' + index + '][nik_ibu]'"
                                       x-model="item.nik_ibu"
                                       maxlength="16"
                                       placeholder="16 Digit NIK Ibu"
                                       class="w-full text-xs font-mono font-medium rounded-xl border-slate-300 bg-white py-2 px-3 focus:ring-1 focus:ring-blue-600">
                            </div>

                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Nama Ayah Kandung <span class="text-rose-500">*</span></label>
                                <input type="text"
                                       :name="'form_data[f101][anggota][' + index + '][nama_ayah]'"
                                       x-model="item.nama_ayah"
                                       required
                                       placeholder="Nama ayah kandung"
                                       class="w-full text-xs font-medium rounded-xl border-slate-300 bg-white py-2 px-3 focus:ring-1 focus:ring-blue-600">
                            </div>

                            <div>
                                <label class="block font-bold text-slate-700 mb-1">NIK Ayah Kandung</label>
                                <input type="text"
                                       :name="'form_data[f101][anggota][' + index + '][nik_ayah]'"
                                       x-model="item.nik_ayah"
                                       maxlength="16"
                                       placeholder="16 Digit NIK Ayah"
                                       class="w-full text-xs font-mono font-medium rounded-xl border-slate-300 bg-white py-2 px-3 focus:ring-1 focus:ring-blue-600">
                            </div>

                            {{-- Disabilitas --}}
                            <div class="md:col-span-4">
                                <label class="block font-bold text-slate-700 mb-1">Kelainan Fisik & Mental / Penyandang Cacat</label>
                                <select :name="'form_data[f101][anggota][' + index + '][disabilitas]'"
                                        x-model="item.disabilitas"
                                        class="w-full text-xs font-medium rounded-xl border-slate-300 bg-white py-2 px-3 focus:ring-1 focus:ring-blue-600">
                                    <option value="Tidak Ada">Tidak Ada</option>
                                    <option value="Cacat Fisik">Cacat Fisik</option>
                                    <option value="Cacat Netra / Buta">Cacat Netra / Buta</option>
                                    <option value="Cacat Rungu / Wicara">Cacat Rungu / Wicara</option>
                                    <option value="Cacat Mental / Jiwa">Cacat Mental / Jiwa</option>
                                    <option value="Cacat Fisik dan Mental">Cacat Fisik dan Mental</option>
                                    <option value="Cacat Lainnya">Cacat Lainnya</option>
                                </select>
                            </div>
                        </div>

                    </div>
                </template>
            </div>

            <div class="pt-2 flex justify-between">
                <button type="button"
                        @click="activeTab = 'wilayah'"
                        class="px-5 py-2.5 rounded-xl bg-slate-100 text-slate-700 text-xs font-bold hover:bg-slate-200 transition-colors flex items-center gap-2">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    <span>Kembali ke Wilayah</span>
                </button>

                <div class="text-right">
                    <span class="text-xs text-emerald-700 font-bold flex items-center gap-1.5">
                        <i data-lucide="check-circle" class="w-4 h-4"></i>
                        Formulir F-1.01 Siap Diajukan
                    </span>
                </div>
            </div>
        </div>

    </div>

</div>

<script>
    function f101BiodataComponent(initialData) {
        return {
            activeTab: 'kepala',
            jenisPilihan: 'wni',
            kepalaKeluarga: {
                nama: initialData.userName || '',
                nik: initialData.userNik || '',
                telepon: initialData.userPhone || '',
                email: initialData.userEmail || '',
                alamat: initialData.userAlamat || '',
                rt: '001',
                rw: '001',
                kode_pos: '46182',
            },
            wilayah: {
                kecamatan: initialData.kecamatanName || '',
                desa: initialData.desaName || '',
                dusun: '',
            },
            anggota: [
                {
                    nama: initialData.userName || '',
                    nik: initialData.userNik || '',
                    jenis_kelamin: 'L',
                    tempat_lahir: 'Tasikmalaya',
                    tanggal_lahir: '',
                    gol_darah: '-',
                    agama: 'Islam',
                    status_kawin: 'Kawin Tercatat',
                    shdk: 'Kepala Keluarga',
                    pendidikan: 'SLTA / Sederajat',
                    pekerjaan: 'Wiraswasta',
                    no_akta_lahir: '',
                    nama_ibu: '',
                    nik_ibu: '',
                    nama_ayah: '',
                    nik_ayah: '',
                    disabilitas: 'Tidak Ada'
                }
            ],
            tambahAnggota() {
                this.anggota.push({
                    nama: '',
                    nik: '',
                    jenis_kelamin: 'P',
                    tempat_lahir: '',
                    tanggal_lahir: '',
                    gol_darah: '-',
                    agama: 'Islam',
                    status_kawin: 'Kawin Tercatat',
                    shdk: this.anggota.length === 1 ? 'Istri' : 'Anak',
                    pendidikan: 'SLTA / Sederajat',
                    pekerjaan: 'Mengurus Rumah Tangga',
                    no_akta_lahir: '',
                    nama_ibu: this.kepalaKeluarga.nama || '',
                    nik_ibu: '',
                    nama_ayah: '',
                    nik_ayah: '',
                    disabilitas: 'Tidak Ada'
                });
                setTimeout(() => lucide.createIcons(), 50);
            },
            hapusAnggota(index) {
                if (this.anggota.length > 1) {
                    this.anggota.splice(index, 1);
                }
            }
        };
    }
</script>
