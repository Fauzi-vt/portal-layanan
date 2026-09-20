@php
    // Siapkan daftar kecamatan beserta desa untuk autocomplete otomatis
    $kecamatanMap = ($kecamatans ?? collect())->mapWithKeys(function($k) {
        return [
            strtoupper($k->nama_kecamatan) => $k->desas ? $k->desas->pluck('nama_desa')->map(fn($d) => strtoupper($d))->values() : []
        ];
    });
@endphp

<div x-data="kkAddComponent({
    userName: @js($user->name),
    userNik: @js($user->nik ?? ''),
    userPhone: @js($user->phone ?? ''),
    userEmail: @js($user->email ?? ''),
    userAlamat: @js($user->alamat_detail ?? ''),
    kecamatanName: @js($user->kecamatan?->nama_kecamatan ?? 'SINGAPARNA'),
    desaName: @js($user->desa?->nama_desa ?? ''),
    kecamatanMap: @js($kecamatanMap),
    oldData: @js(old('form_data.kk_add', isset($submission) ? ($submission->form_data['kk_add'] ?? null) : null))
})" class="bg-white rounded-2xl border border-slate-200 shadow-md overflow-hidden space-y-0 transition-all font-sans">

    {{-- ═══════════════════════════════════════════════════════════════════════
         HEADER FORMULIR DIGITAL PENAMBAHAN KK
    ═══════════════════════════════════════════════════════════════════════ --}}
    <div class="p-6 bg-gradient-to-r from-blue-900 via-indigo-900 to-slate-900 text-white flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-400/20 border border-emerald-400/30 text-emerald-200 text-xs font-bold uppercase tracking-wider mb-2">
                <svg class="w-4 h-4 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
                <span>Formulir Digital Kartu Keluarga</span>
            </div>
            <h2 class="text-xl sm:text-2xl font-black tracking-wide text-white uppercase">
                FORMULIR PENAMBAHAN ANGGOTA KELUARGA
            </h2>
            <p class="text-xs text-blue-100/80 mt-1 max-w-2xl leading-relaxed">
                Pengisian formulir digital terpadu untuk penambahan anggota keluarga baru (kelahiran anak, kepindahan masuk) ke dalam Kartu Keluarga eksisting.
            </p>
        </div>

        <div class="flex items-center gap-3 bg-white/10 backdrop-blur-md px-4 py-3 rounded-2xl border border-white/15">
            <div class="text-right">
                <span class="block text-[11px] text-blue-200 font-medium">Anggota Ditambahkan</span>
                <span class="text-sm font-black text-white" x-text="anggota.length + ' Orang'"></span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-500 text-white flex items-center justify-center font-black text-base shadow-sm">
                <span x-text="anggota.length"></span>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════
         BAGIAN 1: DATA KK EKSISTING & WILAYAH ALAMAT RUMAH
    ═══════════════════════════════════════════════════════════════════════ --}}
    <div class="p-6 bg-slate-50/80 border-b border-slate-200 space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
            <h3 class="text-xs font-black uppercase tracking-wider text-slate-800 flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-600"></span>
                <span>Data Kartu Keluarga & Kepala Keluarga</span>
            </h3>
            <span class="text-[11px] text-emerald-700 font-bold bg-emerald-50 border border-emerald-200 px-2.5 py-1 rounded-lg flex items-center gap-1.5 self-start sm:self-auto">
                <span>⚡</span>
                <span>Otomatisasi Wilayah Aktif (Dapat diedit bebas oleh pemohon)</span>
            </span>
        </div>

        {{-- Grid Tabular untuk Data KK & Alamat --}}
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-4 text-xs">

            {{-- Baris 0: No KK Eksisting & Dasar Alasan Penambahan --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pb-4 border-b border-slate-100">
                <div>
                    <label class="block font-bold text-slate-800 mb-1">
                        Nomor Kartu Keluarga (KK) Eksisting <span class="text-rose-600">*</span>
                    </label>
                    <input type="text"
                           name="form_data[kk_add][no_kk]"
                           x-model="meta.no_kk"
                           @input="meta.no_kk = ($event.target.value || '').replace(/\D/g, '').slice(0, 16)"
                           inputmode="numeric"
                           maxlength="16"
                           required
                           placeholder="16 digit Nomor KK (cth: 3206...)"
                           class="w-full text-xs font-mono font-bold rounded-xl border-slate-300 py-2.5 px-3 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600 shadow-2xs">
                    <p class="text-[10px] text-slate-400 mt-1">Nomor Kartu Keluarga yang akan ditambahkan anggotanya.</p>
                </div>

                <div>
                    <label class="block font-bold text-slate-800 mb-1">
                        Dasar / Alasan Penambahan <span class="text-rose-600">*</span>
                    </label>
                    <select name="form_data[kk_add][alasan_penambahan]"
                            x-model="meta.alasan_penambahan"
                            required
                            class="w-full text-xs font-bold rounded-xl border-slate-300 py-2.5 px-3 bg-white focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600 shadow-2xs">
                        <option value="KELAHIRAN">👶 Kelahiran Anak (Baru Lahir)</option>
                        <option value="PINDAH_DATANG">🚚 Kepindahan Masuk Anggota Keluarga</option>
                        <option value="PERNIKAHAN">💍 Penyatuan Keluarga / Pernikahan</option>
                        <option value="ADOPSI">🤝 Pengangkatan Anak / Adopsi</option>
                        <option value="LAINNYA">📝 Alasan Lainnya</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-800 mb-1">
                        No. Akta Lahir / Surat Ket. Lahir
                    </label>
                    <input type="text"
                           name="form_data[kk_add][no_akta_lahir]"
                           x-model="meta.no_akta_lahir"
                           placeholder="Nomor Akta / Surat Keterangan Lahir (Bidan/RS)"
                           class="w-full text-xs font-medium uppercase rounded-xl border-slate-300 py-2.5 px-3 bg-white focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600 shadow-2xs">
                    <p class="text-[10px] text-slate-400 mt-1">Wajib diisi jika alasan penambahan karena kelahiran.</p>
                </div>
            </div>

            {{-- Baris 1: Nama Kepala Keluarga & Alamat Jalan --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-2">
                    <label class="block font-bold text-slate-800 mb-1">
                        Nama Kepala Keluarga <span class="text-rose-600">*</span>
                    </label>
                    <input type="text"
                           name="form_data[kk_add][nama_kepala_keluarga]"
                           x-model="meta.nama_kepala_keluarga"
                           required
                           placeholder="Contoh: AHMAD FAUZI"
                           class="w-full text-xs font-bold uppercase rounded-xl border-slate-300 py-2.5 px-3 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600">
                    <input type="hidden" name="form_data[kk_add][nama_pemohon]" :value="meta.nama_kepala_keluarga">
                </div>

                <div class="md:col-span-2">
                    <label class="block font-bold text-slate-800 mb-1">
                        Alamat Tempat Tinggal (Jalan / Dusun / Kampung) <span class="text-rose-600">*</span>
                    </label>
                    <input type="text"
                           name="form_data[kk_add][alamat]"
                           x-model="meta.alamat"
                           required
                           placeholder="Contoh: Jl. Pahlawan No. 45, Dusun Sukamaju"
                           class="w-full text-xs font-medium uppercase rounded-xl border-slate-300 py-2.5 px-3 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600">
                </div>
            </div>

            {{-- Baris 2: RT/RW, Kode Pos, Kecamatan, Desa --}}
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
                                   name="form_data[kk_add][rt]"
                                   x-model="meta.rt"
                                   @input="meta.rt = ($event.target.value || '').replace(/\D/g, '').slice(0, 3)"
                                   @blur="meta.rt = meta.rt ? meta.rt.padStart(3, '0').slice(-3) : '001'"
                                   inputmode="numeric"
                                   maxlength="3"
                                   placeholder="001"
                                   class="w-full font-mono text-center text-xs font-bold py-1.5 px-1 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 focus:bg-white focus:ring-1 focus:ring-emerald-600 focus:border-emerald-600 focus:outline-none">
                        </div>
                        <span class="text-slate-300 font-bold">/</span>
                        <div class="flex-1 flex items-center gap-1 pr-1.5">
                            <span class="text-[10px] font-bold text-slate-500 shrink-0">RW</span>
                            <input type="text"
                                   name="form_data[kk_add][rw]"
                                   x-model="meta.rw"
                                   @input="meta.rw = ($event.target.value || '').replace(/\D/g, '').slice(0, 3)"
                                   @blur="meta.rw = meta.rw ? meta.rw.padStart(3, '0').slice(-3) : '001'"
                                   inputmode="numeric"
                                   maxlength="3"
                                   placeholder="001"
                                   class="w-full font-mono text-center text-xs font-bold py-1.5 px-1 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 focus:bg-white focus:ring-1 focus:ring-emerald-600 focus:border-emerald-600 focus:outline-none">
                        </div>
                    </div>
                </div>

                {{-- Kolom 2: Kode Pos --}}
                <div>
                    <label class="block font-bold text-slate-800 mb-1">
                        Kode Pos <span class="text-rose-600 font-bold" aria-hidden="true">*</span>
                    </label>
                    <input type="text"
                           name="form_data[kk_add][kode_pos]"
                           x-model="meta.kode_pos"
                           @input="meta.kode_pos = ($event.target.value || '').replace(/\D/g, '').slice(0, 5)"
                           inputmode="numeric"
                           maxlength="5"
                           placeholder="Contoh: 46182"
                           class="w-full font-mono text-center text-xs font-bold rounded-xl border border-slate-300 py-2.5 px-3 bg-white text-slate-900 focus:ring-2 focus:ring-emerald-600/20 focus:border-emerald-600 focus:outline-none shadow-2xs">
                </div>

                {{-- Kolom 3: Kecamatan --}}
                <div>
                    <label class="block font-bold text-slate-800 mb-1 flex items-center justify-between">
                        <span>Kecamatan <span class="text-rose-600">*</span></span>
                        <span class="text-[10px] text-blue-600 font-semibold">Pilih/Ketik</span>
                    </label>
                    <input type="text"
                           name="form_data[kk_add][nama_kecamatan]"
                           x-model="meta.kecamatan"
                           @input="onKecamatanInput()"
                           @change="onKecamatanInput()"
                           list="list-kecamatan-add"
                           placeholder="Ketik Kecamatan, misal: Manonjaya"
                           class="w-full text-xs font-bold uppercase rounded-xl border-slate-300 py-2.5 px-3 bg-white focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600 shadow-2xs">
                    <datalist id="list-kecamatan-add">
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
                           name="form_data[kk_add][nama_desa]"
                           x-model="meta.desa"
                           list="list-desa-add"
                           placeholder="Nama Desa/Kelurahan"
                           class="w-full text-xs font-bold uppercase rounded-xl border-slate-300 py-2.5 px-3 bg-white focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600 shadow-2xs">
                    <datalist id="list-desa-add">
                        <template x-for="d in availableDesas" :key="d">
                            <option :value="d"></option>
                        </template>
                    </datalist>
                </div>
            </div>

            {{-- Baris 3: Kabupaten, Provinsi, Negara --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2 border-t border-slate-100">
                <div>
                    <label class="block text-[10px] font-semibold text-slate-500 mb-0.5">Kabupaten / Kota</label>
                    <input type="text" name="form_data[kk_add][kabupaten]" x-model="meta.kabupaten"
                           class="w-full text-xs font-bold uppercase rounded-xl border-slate-200 py-2 px-3 bg-slate-50 text-slate-700">
                </div>
                <div>
                    <label class="block text-[10px] font-semibold text-slate-500 mb-0.5">Provinsi</label>
                    <input type="text" name="form_data[kk_add][provinsi]" x-model="meta.provinsi"
                           class="w-full text-xs font-bold uppercase rounded-xl border-slate-200 py-2 px-3 bg-slate-50 text-slate-700">
                </div>
                <div>
                    <label class="block text-[10px] font-semibold text-slate-500 mb-0.5">Negara</label>
                    <input type="text" name="form_data[kk_add][negara]" x-model="meta.negara"
                           class="w-full text-xs font-bold uppercase rounded-xl border-slate-200 py-2 px-3 bg-slate-50 text-slate-700">
                </div>
            </div>

        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════
         BAGIAN 2: TABEL DAFTAR ANGGOTA KELUARGA YANG DITAMBAHKAN
    ═══════════════════════════════════════════════════════════════════════ --}}
    <div class="p-6 space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h3 class="text-xs font-black uppercase tracking-wider text-slate-800 flex items-center gap-2">
                    <span>👶</span>
                    <span>Tabel Daftar Anggota Keluarga yang Ditambahkan</span>
                </h3>
                <p class="text-[11px] text-slate-500 mt-0.5">
                    Tambahkan setiap anggota baru yang akan dimasukkan ke dalam susunan Kartu Keluarga.
                </p>
            </div>

            <button type="button"
                    @click="addAnggota()"
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow-sm hover:shadow-md transition-all self-start sm:self-auto cursor-pointer">
                <span>+</span>
                <span>Tambah Anggota Baru</span>
            </button>
        </div>

        {{-- Table Container --}}
        <div class="overflow-x-auto rounded-2xl border border-slate-200 shadow-2xs">
            <table class="w-full text-left text-xs border-collapse">
                <thead class="bg-slate-100/90 text-slate-700 font-bold uppercase text-[10px] border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-3.5 text-center w-12">No</th>
                        <th class="py-3 px-4">Nama Lengkap</th>
                        <th class="py-3 px-4">NIK</th>
                        <th class="py-3 px-3 text-center">JK</th>
                        <th class="py-3 px-4">Hubungan (SHDK)</th>
                        <th class="py-3 px-4">Tempat / Tgl Lahir</th>
                        <th class="py-3 px-4">Nama Orang Tua</th>
                        <th class="py-3 px-4 text-center w-24">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    <template x-for="(item, index) in anggota" :key="index">
                        <tr class="hover:bg-emerald-50/30 transition-colors">
                            <td class="py-3.5 px-3.5 text-center font-bold text-slate-600" x-text="index + 1"></td>
                            <td class="py-3.5 px-4 font-bold text-slate-900">
                                <span x-text="item.nama"></span>
                                <span x-show="item.is_bayi" class="ml-1.5 px-2 py-0.5 rounded-full text-[9px] font-bold bg-emerald-100 text-emerald-800">
                                    Bayi Baru Lahir
                                </span>
                            </td>
                            <td class="py-3.5 px-4 font-mono font-semibold" :class="item.is_bayi ? 'text-slate-400 italic' : 'text-slate-800'" x-text="item.nik || 'Belum Ada NIK'"></td>
                            <td class="py-3.5 px-3 text-center">
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-bold"
                                      :class="item.jenis_kelamin === 'LAKI-LAKI' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800'"
                                      x-text="item.jenis_kelamin === 'LAKI-LAKI' ? 'L' : 'P'"></span>
                            </td>
                            <td class="py-3.5 px-4 font-bold text-emerald-800" x-text="item.shdk"></td>
                            <td class="py-3.5 px-4 text-slate-600">
                                <span x-text="item.tempat_lahir"></span>,
                                <span x-text="formatDateId(item.tanggal_lahir)"></span>
                            </td>
                            <td class="py-3.5 px-4 text-[11px] text-slate-600">
                                <p>Ayah: <span class="font-semibold text-slate-800" x-text="item.nama_ayah || '-'"></span></p>
                                <p>Ibu: <span class="font-semibold text-slate-800" x-text="item.nama_ibu || '-'"></span></p>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <button type="button"
                                            @click="editMember(index)"
                                            class="p-1.5 rounded-lg text-blue-600 hover:bg-blue-50 transition-colors"
                                            title="Edit Data">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                        </svg>
                                    </button>
                                    <button type="button"
                                            @click="removeAnggota(index)"
                                            class="p-1.5 rounded-lg text-rose-600 hover:bg-rose-50 transition-colors"
                                            title="Hapus Baris">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>

                    <tr x-show="anggota.length === 0">
                        <td colspan="8" class="py-8 text-center text-slate-400">
                            <p class="font-medium text-xs">Belum ada anggota keluarga baru yang ditambahkan.</p>
                            <p class="text-[11px] mt-1">Klik tombol <strong>+ Tambah Anggota Baru</strong> di atas untuk memasukkan data.</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Hidden Inputs for form submit --}}
        <template x-for="(item, index) in anggota" :key="'hidden-' + index">
            <div>
                <input type="hidden" :name="'form_data[kk_add][anggota][' + index + '][nama]'" :value="item.nama">
                <input type="hidden" :name="'form_data[kk_add][anggota][' + index + '][nik]'" :value="item.nik">
                <input type="hidden" :name="'form_data[kk_add][anggota][' + index + '][is_bayi]'" :value="item.is_bayi ? '1' : '0'">
                <input type="hidden" :name="'form_data[kk_add][anggota][' + index + '][jenis_kelamin]'" :value="item.jenis_kelamin">
                <input type="hidden" :name="'form_data[kk_add][anggota][' + index + '][tempat_lahir]'" :value="item.tempat_lahir">
                <input type="hidden" :name="'form_data[kk_add][anggota][' + index + '][tanggal_lahir]'" :value="item.tanggal_lahir">
                <input type="hidden" :name="'form_data[kk_add][anggota][' + index + '][agama]'" :value="item.agama">
                <input type="hidden" :name="'form_data[kk_add][anggota][' + index + '][pendidikan]'" :value="item.pendidikan">
                <input type="hidden" :name="'form_data[kk_add][anggota][' + index + '][pekerjaan]'" :value="item.pekerjaan">
                <input type="hidden" :name="'form_data[kk_add][anggota][' + index + '][gol_darah]'" :value="item.gol_darah">
                <input type="hidden" :name="'form_data[kk_add][anggota][' + index + '][status_kawin]'" :value="item.status_kawin">
                <input type="hidden" :name="'form_data[kk_add][anggota][' + index + '][tgl_kawin]'" :value="item.tgl_kawin">
                <input type="hidden" :name="'form_data[kk_add][anggota][' + index + '][shdk]'" :value="item.shdk">
                <input type="hidden" :name="'form_data[kk_add][anggota][' + index + '][nama_ayah]'" :value="item.nama_ayah">
                <input type="hidden" :name="'form_data[kk_add][anggota][' + index + '][nama_ibu]'" :value="item.nama_ibu">
            </div>
        </template>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════
         MODAL FORMULIR DATA ANGGOTA KELUARGA BARU
    ═══════════════════════════════════════════════════════════════════════ --}}
    <div x-show="showMemberForm"
         x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto"
         role="dialog"
         aria-modal="true">

        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs" @click="showMemberForm = false"></div>

        <div class="relative bg-white rounded-3xl shadow-2xl border border-slate-100 max-w-2xl w-full p-6 z-10 my-8">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h3 class="text-base font-bold text-slate-900" x-text="editingIndex !== null ? 'Edit Data Anggota Keluarga Baru' : 'Tambah Anggota Keluarga Baru ke KK'"></h3>
                <button type="button" @click="showMemberForm = false" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg">✕</button>
            </div>

            <div class="mt-4 space-y-4 text-xs">
                {{-- Alert / Banner Bayi Baru Lahir --}}
                <div class="p-3 bg-emerald-50 border border-emerald-200 rounded-xl flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="text-lg">👶</span>
                        <div>
                            <p class="font-bold text-emerald-900">Penambahan Bayi Baru Lahir</p>
                            <p class="text-[11px] text-emerald-700">Centang opsi di samping jika anggota yang ditambahkan adalah bayi baru lahir (NIK belum terbit).</p>
                        </div>
                    </div>
                    <label class="flex items-center gap-1.5 cursor-pointer font-bold text-emerald-900">
                        <input type="checkbox"
                               x-model="formMember.is_bayi"
                               @change="if(formMember.is_bayi){ formMember.nik = ''; formMember.pekerjaan = 'BELUM/TIDAK BEKERJA'; formMember.pendidikan = 'TIDAK / BELUM SEKOLAH'; formMember.status_kawin = 'BELUM KAWIN'; formMember.shdk = 'ANAK'; }"
                               class="rounded border-emerald-400 text-emerald-600 focus:ring-emerald-500">
                        <span>Bayi Baru Lahir</span>
                    </label>
                </div>

                {{-- Error Banner --}}
                <div x-show="validationError" x-text="validationError" class="p-3 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl font-semibold"></div>

                {{-- Baris 1: Nama Lengkap & NIK --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-800 mb-1">Nama Lengkap <span class="text-rose-600">*</span></label>
                        <input type="text" x-model="formMember.nama" placeholder="Contoh: MUHAMMAD RIZKY"
                               class="w-full text-xs font-bold uppercase rounded-xl border-slate-300 py-2 px-3 focus:ring-2 focus:ring-emerald-600">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-800 mb-1">
                            NIK (Nomor Induk Kependudukan)
                            <span x-show="!formMember.is_bayi" class="text-rose-600">*</span>
                        </label>
                        <input type="text"
                               x-model="formMember.nik"
                               :disabled="formMember.is_bayi"
                               :placeholder="formMember.is_bayi ? '(Otomatis Belum Memiliki NIK)' : '16 Digit Angka NIK'"
                               maxlength="16"
                               @input="formMember.nik = ($event.target.value || '').replace(/\D/g, '').slice(0, 16)"
                               class="w-full text-xs font-mono font-bold rounded-xl border-slate-300 py-2 px-3 focus:ring-2 focus:ring-emerald-600 disabled:bg-slate-100 disabled:text-slate-400">
                    </div>
                </div>

                {{-- Baris 2: Jenis Kelamin, Hubungan Keluarga (SHDK) --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-800 mb-1">Jenis Kelamin <span class="text-rose-600">*</span></label>
                        <select x-model="formMember.jenis_kelamin" class="w-full text-xs font-semibold rounded-xl border-slate-300 py-2 px-3 focus:ring-2 focus:ring-emerald-600">
                            <option value="LAKI-LAKI">LAKI-LAKI</option>
                            <option value="PEREMPUAN">PEREMPUAN</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-bold text-slate-800 mb-1">Status Hubungan dalam Keluarga (SHDK) <span class="text-rose-600">*</span></label>
                        <select x-model="formMember.shdk" class="w-full text-xs font-bold rounded-xl border-slate-300 py-2 px-3 focus:ring-2 focus:ring-emerald-600">
                            <option value="ANAK">ANAK</option>
                            <option value="ISTRI">ISTRI</option>
                            <option value="SUAMI">SUAMI</option>
                            <option value="CUCU">CUCU</option>
                            <option value="MENANTU">MENANTU</option>
                            <option value="ORANG TUA">ORANG TUA</option>
                            <option value="MERTUA">MERTUA</option>
                            <option value="FAMILI LAIN">FAMILI LAIN</option>
                            <option value="LAINNYA">LAINNYA</option>
                        </select>
                    </div>
                </div>

                {{-- Baris 3: Tempat & Tanggal Lahir --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-800 mb-1">Tempat Lahir <span class="text-rose-600">*</span></label>
                        <input type="text" x-model="formMember.tempat_lahir" placeholder="Contoh: TASIKMALAYA"
                               class="w-full text-xs font-bold uppercase rounded-xl border-slate-300 py-2 px-3 focus:ring-2 focus:ring-emerald-600">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-800 mb-1">Tanggal Lahir <span class="text-rose-600">*</span></label>
                        <input type="date" x-model="formMember.tanggal_lahir"
                               class="w-full text-xs font-semibold rounded-xl border-slate-300 py-2 px-3 focus:ring-2 focus:ring-emerald-600">
                    </div>
                </div>

                {{-- Baris 4: Agama, Pendidikan, Pekerjaan, Gol Darah --}}
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    <div>
                        <label class="block font-bold text-slate-800 mb-1">Agama</label>
                        <select x-model="formMember.agama" class="w-full text-xs rounded-xl border-slate-300 py-2 px-2 focus:ring-2 focus:ring-emerald-600">
                            <option value="ISLAM">ISLAM</option>
                            <option value="KRISTEN">KRISTEN</option>
                            <option value="KATOLIK">KATOLIK</option>
                            <option value="HINDU">HINDU</option>
                            <option value="BUDDHA">BUDDHA</option>
                            <option value="KHONGHUCU">KHONGHUCU</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-bold text-slate-800 mb-1">Pendidikan</label>
                        <select x-model="formMember.pendidikan" class="w-full text-xs rounded-xl border-slate-300 py-2 px-2 focus:ring-2 focus:ring-emerald-600">
                            <option value="TIDAK / BELUM SEKOLAH">BELUM SEKOLAH</option>
                            <option value="TAMAT SD / SEDERAJAT">SD</option>
                            <option value="SLTP / SEDERAJAT">SMP</option>
                            <option value="SLTA / SEDERAJAT">SMA/SMK</option>
                            <option value="DIPLOMA I / II / III">DIPLOMA</option>
                            <option value="STRATA I (S1)">S1</option>
                            <option value="STRATA II (S2)">S2</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-bold text-slate-800 mb-1">Pekerjaan</label>
                        <input type="text" x-model="formMember.pekerjaan" placeholder="Pekerjaan"
                               class="w-full text-xs uppercase rounded-xl border-slate-300 py-2 px-2 focus:ring-2 focus:ring-emerald-600">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-800 mb-1">Gol. Darah</label>
                        <select x-model="formMember.gol_darah" class="w-full text-xs rounded-xl border-slate-300 py-2 px-2 focus:ring-2 focus:ring-emerald-600">
                            <option value="-">-</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="AB">AB</option>
                            <option value="O">O</option>
                        </select>
                    </div>
                </div>

                {{-- Baris 5: Nama Orang Tua (Ayah & Ibu) --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2 border-t border-slate-100">
                    <div>
                        <label class="block font-bold text-slate-800 mb-1">Nama Lengkap Ayah Kandung <span class="text-rose-600">*</span></label>
                        <input type="text" x-model="formMember.nama_ayah" placeholder="Nama Lengkap Ayah"
                               class="w-full text-xs font-bold uppercase rounded-xl border-slate-300 py-2 px-3 focus:ring-2 focus:ring-emerald-600">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-800 mb-1">Nama Lengkap Ibu Kandung <span class="text-rose-600">*</span></label>
                        <input type="text" x-model="formMember.nama_ibu" placeholder="Nama Lengkap Ibu"
                               class="w-full text-xs font-bold uppercase rounded-xl border-slate-300 py-2 px-3 focus:ring-2 focus:ring-emerald-600">
                    </div>
                </div>

                <div class="pt-4 flex items-center justify-end gap-2 border-t border-slate-100">
                    <button type="button" @click="showMemberForm = false" class="px-4 py-2 text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl">Batal</button>
                    <button type="button" @click="applyMember()" class="px-5 py-2 text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-sm">Simpan ke Daftar</button>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    function kkAddComponent(config) {
        return {
            meta: {
                no_kk: config.oldData?.no_kk || '',
                alasan_penambahan: config.oldData?.alasan_penambahan || 'KELAHIRAN',
                no_akta_lahir: config.oldData?.no_akta_lahir || '',
                nama_kepala_keluarga: config.oldData?.nama_kepala_keluarga || config.userName || '',
                alamat: config.oldData?.alamat || config.userAlamat || '',
                rt: config.oldData?.rt || '001',
                rw: config.oldData?.rw || '001',
                kode_pos: config.oldData?.kode_pos || '46182',
                kecamatan: config.oldData?.nama_kecamatan || (config.kecamatanName || 'SINGAPARNA').toUpperCase(),
                desa: config.oldData?.nama_desa || (config.desaName || '').toUpperCase(),
                kabupaten: config.oldData?.nama_kabupaten || 'KABUPATEN TASIKMALAYA',
                provinsi: config.oldData?.nama_provinsi || 'JAWA BARAT',
                negara: config.oldData?.negara || 'INDONESIA',
            },

            kecamatanMap: config.kecamatanMap || {},
            availableDesas: [],

            anggota: config.oldData?.anggota ? config.oldData.anggota : [
                {
                    nama: '',
                    nik: '',
                    is_bayi: true,
                    jenis_kelamin: 'LAKI-LAKI',
                    tempat_lahir: 'TASIKMALAYA',
                    tanggal_lahir: new Date().toISOString().split('T')[0],
                    agama: 'ISLAM',
                    pendidikan: 'TIDAK / BELUM SEKOLAH',
                    pekerjaan: 'BELUM/TIDAK BEKERJA',
                    gol_darah: '-',
                    status_kawin: 'BELUM KAWIN',
                    tgl_kawin: '',
                    shdk: 'ANAK',
                    nama_ayah: config.userName || '',
                    nama_ibu: '',
                }
            ],

            showMemberForm: false,
            editingIndex: null,
            validationError: '',
            formMember: {},

            init() {
                this.updateAvailableDesas();
            },

            onKecamatanInput() {
                this.updateAvailableDesas();
            },

            updateAvailableDesas() {
                const kec = (this.meta.kecamatan || '').toUpperCase().trim();
                this.availableDesas = this.kecamatanMap[kec] || [];
                if (this.availableDesas.length > 0 && !this.availableDesas.includes(this.meta.desa)) {
                    this.meta.desa = this.availableDesas[0];
                }
            },

            formatDateId(dateStr) {
                if (!dateStr) return '-';
                try {
                    const d = new Date(dateStr);
                    if (isNaN(d.getTime())) return dateStr;
                    return d.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
                } catch(e) {
                    return dateStr;
                }
            },

            addAnggota() {
                this.editingIndex = null;
                this.validationError = '';
                this.formMember = {
                    nama: '',
                    nik: '',
                    is_bayi: this.meta.alasan_penambahan === 'KELAHIRAN',
                    jenis_kelamin: 'LAKI-LAKI',
                    tempat_lahir: 'TASIKMALAYA',
                    tanggal_lahir: new Date().toISOString().split('T')[0],
                    agama: 'ISLAM',
                    pendidikan: this.meta.alasan_penambahan === 'KELAHIRAN' ? 'TIDAK / BELUM SEKOLAH' : 'SLTA / SEDERAJAT',
                    pekerjaan: this.meta.alasan_penambahan === 'KELAHIRAN' ? 'BELUM/TIDAK BEKERJA' : 'KARYAWAN SWASTA',
                    gol_darah: '-',
                    status_kawin: 'BELUM KAWIN',
                    tgl_kawin: '',
                    shdk: 'ANAK',
                    nama_ayah: this.meta.nama_kepala_keluarga || '',
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
                    this.validationError = '⚠️ Nama Lengkap wajib diisi.';
                    return;
                }
                if (!this.formMember.is_bayi && (!this.formMember.nik || this.formMember.nik.length !== 16)) {
                    this.validationError = '⚠️ NIK wajib 16 digit angka (atau centang Bayi Baru Lahir jika belum ada NIK).';
                    return;
                }
                if (!this.formMember.tempat_lahir || !this.formMember.tempat_lahir.trim()) {
                    this.validationError = '⚠️ Tempat Lahir wajib diisi.';
                    return;
                }
                if (!this.formMember.tanggal_lahir) {
                    this.validationError = '⚠️ Tanggal Lahir wajib diisi.';
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
                if (confirm('Hapus baris data anggota baru ini?')) {
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
