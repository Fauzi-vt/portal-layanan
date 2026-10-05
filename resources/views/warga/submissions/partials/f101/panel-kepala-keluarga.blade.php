    <div x-show="typeof activeStep === 'undefined' || activeStep === 2" x-cloak class="space-y-5">

        {{-- Header Card --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 sm:p-6 space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-700 border border-blue-100 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="home" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Data Kepala Keluarga</h3>
                        <p class="text-xs text-slate-500 mt-0.5">
                            Masukkan data kepala keluarga dan alamat tempat tinggal.
                        </p>
                    </div>
                </div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 self-start sm:self-auto">
                    <i data-lucide="sparkles" class="w-3.5 h-3.5"></i>
                    <span>Otomatisasi Wilayah Aktif</span>
                </span>
            </div>

            {{-- Form Fields Grid --}}
            <div class="space-y-4 pt-1">
                {{-- Baris 1: Nama Kepala Keluarga & Alamat --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="f101_nama_kepala_keluarga" class="block text-xs font-bold text-slate-800 mb-1.5">
                            Nama Kepala Keluarga <span class="text-rose-600">*</span>
                        </label>
                        <input type="text"
                               id="f101_nama_kepala_keluarga"
                               x-model="$store.kkBaru.meta.nama_kepala_keluarga"
                               required
                               placeholder="Nama Lengkap sesuai KTP / Dokumen Resmi"
                               class="w-full text-xs font-bold uppercase rounded-xl border-slate-300 py-2.5 px-3.5 bg-slate-50/60 text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600 shadow-2xs transition-colors">
                        <p class="text-[11px] text-slate-400 mt-1">Nama kepala keluarga yang akan tercantum pada Kartu Keluarga.</p>
                    </div>

                    <div>
                        <label for="f101_alamat" class="block text-xs font-bold text-slate-800 mb-1.5">
                            Alamat <span class="text-rose-600">*</span>
                        </label>
                        <input type="text"
                               id="f101_alamat"
                               x-model="$store.kkBaru.meta.alamat"
                               required
                               placeholder="Contoh: Jl. Pahlawan No. 45, Dusun Sukamaju"
                               class="w-full text-xs font-medium uppercase rounded-xl border-slate-300 py-2.5 px-3.5 bg-slate-50/60 text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600 shadow-2xs transition-colors">
                        <p class="text-[11px] text-slate-400 mt-1">Nama jalan, nomor rumah, atau nama dusun/kampung tempat tinggal.</p>
                    </div>
                </div>

                {{-- Baris 2: RT/RW, Kode Pos, Kecamatan, Desa --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 pt-1">
                    {{-- RT / RW --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-800 mb-1.5">
                            RT / RW <span class="text-rose-600">*</span>
                        </label>
                        <div class="flex items-center gap-1.5 p-1 bg-white rounded-xl border border-slate-300 shadow-2xs">
                            <div class="flex-1 flex items-center gap-1 pl-2">
                                <span class="text-[10px] font-bold text-slate-400">RT</span>
                                <input type="text"
                                       x-model="$store.kkBaru.meta.rt"
                                       @input="$store.kkBaru.meta.rt = ($event.target.value || '').replace(/\D/g, '').slice(0, 3)"
                                       @blur="$store.kkBaru.meta.rt = $store.kkBaru.meta.rt ? $store.kkBaru.meta.rt.padStart(3, '0').slice(-3) : '001'"
                                       inputmode="numeric"
                                       maxlength="3"
                                       placeholder="001"
                                       class="w-full font-mono text-center text-xs font-bold py-1.5 px-1 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 focus:bg-white focus:ring-1 focus:ring-blue-600 focus:border-blue-600 focus:outline-none">
                            </div>
                            <span class="text-slate-300 font-bold">/</span>
                            <div class="flex-1 flex items-center gap-1 pr-2">
                                <span class="text-[10px] font-bold text-slate-400">RW</span>
                                <input type="text"
                                       x-model="$store.kkBaru.meta.rw"
                                       @input="$store.kkBaru.meta.rw = ($event.target.value || '').replace(/\D/g, '').slice(0, 3)"
                                       @blur="$store.kkBaru.meta.rw = $store.kkBaru.meta.rw ? $store.kkBaru.meta.rw.padStart(3, '0').slice(-3) : '001'"
                                       inputmode="numeric"
                                       maxlength="3"
                                       placeholder="001"
                                       class="w-full font-mono text-center text-xs font-bold py-1.5 px-1 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 focus:bg-white focus:ring-1 focus:ring-blue-600 focus:border-blue-600 focus:outline-none">
                            </div>
                        </div>
                    </div>

                    {{-- Kode Pos --}}
                    <div>
                        <label for="f101_kode_pos" class="block text-xs font-bold text-slate-800 mb-1.5">
                            Kode Pos <span class="text-rose-600">*</span>
                        </label>
                        <input type="text"
                               id="f101_kode_pos"
                               x-model="$store.kkBaru.meta.kode_pos"
                               @input="$store.kkBaru.meta.kode_pos = ($event.target.value || '').replace(/\D/g, '').slice(0, 5)"
                               inputmode="numeric"
                               maxlength="5"
                               placeholder="46182"
                               class="w-full font-mono text-center text-xs font-bold rounded-xl border border-slate-300 py-2.5 px-3 bg-white text-slate-900 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 shadow-2xs">
                    </div>

                    {{-- Kecamatan --}}
                    <div>
                        <label for="f101_kecamatan" class="block text-xs font-bold text-slate-800 mb-1.5 flex items-center justify-between">
                            <span>Kecamatan <span class="text-rose-600">*</span></span>
                            <span class="text-[10px] text-blue-600 font-semibold">Pilih/Ketik</span>
                        </label>
                        <input type="text"
                               id="f101_kecamatan"
                               x-model="$store.kkBaru.meta.kecamatan"
                               @input="$store.kkBaru.onKecamatanInput()"
                               @change="$store.kkBaru.onKecamatanInput()"
                               list="list-kecamatan-auto-f101"
                               placeholder="Ketik nama kecamatan"
                               class="w-full text-xs font-bold uppercase rounded-xl border-slate-300 py-2.5 px-3 bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600 shadow-2xs">
                        <datalist id="list-kecamatan-auto-f101">
                            @foreach ($kecamatans ?? [] as $kec)
                                <option value="{{ strtoupper($kec->nama_kecamatan) }}"></option>
                            @endforeach
                        </datalist>
                    </div>

                    {{-- Desa / Kelurahan --}}
                    <div>
                        <label for="f101_desa" class="block text-xs font-bold text-slate-800 mb-1.5 flex items-center justify-between">
                            <span>Desa <span class="text-rose-600">*</span></span>
                            <span class="text-[10px] text-slate-400 font-normal">Pilih/Ketik</span>
                        </label>
                        <input type="text"
                               id="f101_desa"
                               x-model="$store.kkBaru.meta.desa"
                               list="list-desa-auto-f101"
                               placeholder="Nama Desa/Kelurahan"
                               class="w-full text-xs font-bold uppercase rounded-xl border-slate-300 py-2.5 px-3 bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600 shadow-2xs">
                        <datalist id="list-desa-auto-f101">
                            <template x-for="desa in $store.kkBaru.availableDesas" :key="desa">
                                <option :value="desa"></option>
                            </template>
                        </datalist>
                    </div>
                </div>

                {{-- Baris 3: Otomatisasi Wilayah (Kabupaten, Provinsi, Negara) --}}
                <div class="pt-3 border-t border-slate-100">
                    <p class="text-[11px] font-semibold text-slate-500 mb-2">Wilayah Administratif Terisi Otomatis (Dapat Disesuaikan jika Diperlukan):</p>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 mb-1">Kabupaten</label>
                            <input type="text"
                                   x-model="$store.kkBaru.meta.kabupaten"
                                   placeholder="KABUPATEN TASIKMALAYA"
                                   class="w-full text-xs font-bold uppercase rounded-xl border-slate-200 py-2 px-3 bg-slate-50 text-slate-800 focus:bg-white focus:ring-2 focus:ring-blue-600">
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 mb-1">Provinsi</label>
                            <input type="text"
                                   x-model="$store.kkBaru.meta.provinsi"
                                   placeholder="JAWA BARAT"
                                   class="w-full text-xs font-bold uppercase rounded-xl border-slate-200 py-2 px-3 bg-slate-50 text-slate-800 focus:bg-white focus:ring-2 focus:ring-blue-600">
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 mb-1">Negara</label>
                            <input type="text"
                                   x-model="$store.kkBaru.meta.negara"
                                   placeholder="INDONESIA"
                                   class="w-full text-xs font-bold uppercase rounded-xl border-slate-200 py-2 px-3 bg-slate-50 text-slate-800 focus:bg-white focus:ring-2 focus:ring-blue-600">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
