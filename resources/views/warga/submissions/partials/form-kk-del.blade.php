@php
    // Siapkan daftar kecamatan beserta desa untuk autocomplete otomatis
    $kecamatanMap = ($kecamatans ?? collect())->mapWithKeys(function($k) {
        return [
            strtoupper($k->nama_kecamatan) => $k->desas ? $k->desas->pluck('nama_desa')->map(fn($d) => strtoupper($d))->values() : []
        ];
    });
@endphp

<div x-data="kkDelComponent({
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
         HEADER FORMULIR DIGITAL PENGURANGAN KK
    ═══════════════════════════════════════════════════════════════════════ --}}
    <div class="p-6 bg-gradient-to-r from-blue-900 via-indigo-900 to-slate-900 text-white flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-rose-400/20 border border-rose-400/30 text-rose-200 text-xs font-bold uppercase tracking-wider mb-2">
                <svg class="w-4 h-4 text-rose-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7a4 4 0 11-8 0 4 4 0 018 0zM9 14a6 6 0 00-6 6v1h12v-1a6 6 0 00-6-6zM21 12h-6"/>
                </svg>
                <span>Formulir Digital Kartu Keluarga</span>
            </div>
            <h2 class="text-xl sm:text-2xl font-black tracking-wide text-white uppercase">
                FORMULIR PENGURANGAN ANGGOTA KELUARGA
            </h2>
            <p class="text-xs text-blue-100/80 mt-1 max-w-2xl leading-relaxed">
                Pengisian formulir digital terpadu untuk pembaruan Kartu Keluarga karena pengurangan anggota (kematian, kepindahan keluar, atau perceraian).
            </p>
        </div>

        <div class="flex items-center gap-3 bg-white/10 backdrop-blur-md px-4 py-3 rounded-2xl border border-white/15">
            <div class="text-right">
                <span class="block text-[11px] text-blue-200 font-medium">Anggota Dikeluarkan</span>
                <span class="text-sm font-black text-white" x-text="anggota.length + ' Orang'"></span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-rose-500 text-white flex items-center justify-center font-black text-base shadow-sm">
                <span x-text="anggota.length"></span>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════
         BAGIAN 1: DATA KK EKSISTING & ALASAN PENGURANGAN
    ═══════════════════════════════════════════════════════════════════════ --}}
    <div class="p-6 bg-slate-50/80 border-b border-slate-200 space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
            <h3 class="text-xs font-black uppercase tracking-wider text-slate-800 flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-rose-600"></span>
                <span>Data Kartu Keluarga & Kepala Keluarga</span>
            </h3>
            <span class="text-[11px] text-emerald-700 font-bold bg-emerald-50 border border-emerald-200 px-2.5 py-1 rounded-lg flex items-center gap-1.5 self-start sm:self-auto">
                <span>⚡</span>
                <span>Otomatisasi Wilayah Aktif (Dapat diedit bebas oleh pemohon)</span>
            </span>
        </div>

        {{-- Grid Tabular untuk Data KK & Alamat --}}
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-4 text-xs">

            {{-- Baris 0: No KK Eksisting & Dasar Alasan Pengurangan --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 pb-4 border-b border-slate-100">
                <div>
                    <label class="block font-bold text-slate-800 mb-1">
                        Nomor Kartu Keluarga (KK) Eksisting <span class="text-rose-600">*</span>
                    </label>
                    <input type="text"
                           name="form_data[kk_del][no_kk]"
                           x-model="meta.no_kk"
                           @input="meta.no_kk = ($event.target.value || '').replace(/\D/g, '').slice(0, 16)"
                           inputmode="numeric"
                           maxlength="16"
                           required
                           placeholder="16 digit Nomor KK (cth: 3206...)"
                           class="w-full text-xs font-mono font-bold rounded-xl border-slate-300 py-2.5 px-3 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-rose-600 focus:border-rose-600 shadow-2xs">
                    <p class="text-[10px] text-slate-400 mt-1">Nomor KK yang anggotanya berkurang.</p>
                </div>

                <div>
                    <label class="block font-bold text-slate-800 mb-1">
                        Alasan Pengurangan Anggota <span class="text-rose-600">*</span>
                    </label>
                    <select name="form_data[kk_del][alasan_pengurangan]"
                            x-model="meta.alasan_pengurangan"
                            required
                            class="w-full text-xs font-bold rounded-xl border-slate-300 py-2.5 px-3 bg-white focus:ring-2 focus:ring-rose-600 focus:border-rose-600 shadow-2xs">
                        <option value="MENINGGAL">🕊️ Meninggal Dunia (Wafat)</option>
                        <option value="PINDAH_KELUAR">🚚 Kepindahan Domisili Keluar</option>
                        <option value="PERCERAIAN">💔 Perceraian / Pemisahan KK</option>
                        <option value="LAINNYA">📝 Alasan Lainnya</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-800 mb-1">
                        Tanggal Peristiwa <span class="text-rose-600">*</span>
                    </label>
                    <input type="date"
                           name="form_data[kk_del][tanggal_peristiwa]"
                           x-model="meta.tanggal_peristiwa"
                           required
                           class="w-full text-xs font-semibold rounded-xl border-slate-300 py-2.5 px-3 bg-white focus:ring-2 focus:ring-rose-600 focus:border-rose-600 shadow-2xs">
                    <p class="text-[10px] text-slate-400 mt-1">Tanggal kematian, tanggal pindah, atau putusan cerai.</p>
                </div>

                <div>
                    <label class="block font-bold text-slate-800 mb-1">
                        No. Akta / Surat Bukti
                    </label>
                    <input type="text"
                           name="form_data[kk_del][no_dokumen_bukti]"
                           x-model="meta.no_dokumen_bukti"
                           placeholder="No. Akta Kematian / SKPWNI / Akta Cerai"
                           class="w-full text-xs font-medium uppercase rounded-xl border-slate-300 py-2.5 px-3 bg-white focus:ring-2 focus:ring-rose-600 focus:border-rose-600 shadow-2xs">
                    <p class="text-[10px] text-slate-400 mt-1">Surat Keterangan Kematian atau SKPWNI.</p>
                </div>
            </div>

            {{-- Baris 1: Nama Kepala Keluarga & Alamat Jalan --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-2">
                    <label class="block font-bold text-slate-800 mb-1">
                        Nama Kepala Keluarga (Tercatat / Baru) <span class="text-rose-600">*</span>
                    </label>
                    <input type="text"
                           name="form_data[kk_del][nama_kepala_keluarga]"
                           x-model="meta.nama_kepala_keluarga"
                           required
                           placeholder="Contoh: AHMAD FAUZI"
                           class="w-full text-xs font-bold uppercase rounded-xl border-slate-300 py-2.5 px-3 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-rose-600 focus:border-rose-600">
                    <p class="text-[10px] text-slate-400 mt-0.5">Jika yang meninggal adalah kepala keluarga, isi dengan nama kepala keluarga pengganti.</p>
                </div>

                <div class="md:col-span-2">
                    <label class="block font-bold text-slate-800 mb-1">
                        Alamat Tempat Tinggal (Jalan / Dusun / Kampung) <span class="text-rose-600">*</span>
                    </label>
                    <input type="text"
                           name="form_data[kk_del][alamat]"
                           x-model="meta.alamat"
                           required
                           placeholder="Contoh: Jl. Pahlawan No. 45, Dusun Sukamaju"
                           class="w-full text-xs font-medium uppercase rounded-xl border-slate-300 py-2.5 px-3 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-rose-600 focus:border-rose-600">
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
                                   name="form_data[kk_del][rt]"
                                   x-model="meta.rt"
                                   @input="meta.rt = ($event.target.value || '').replace(/\D/g, '').slice(0, 3)"
                                   @blur="meta.rt = meta.rt ? meta.rt.padStart(3, '0').slice(-3) : '001'"
                                   inputmode="numeric"
                                   maxlength="3"
                                   placeholder="001"
                                   class="w-full font-mono text-center text-xs font-bold py-1.5 px-1 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 focus:bg-white focus:ring-1 focus:ring-rose-600 focus:border-rose-600 focus:outline-none">
                        </div>
                        <span class="text-slate-300 font-bold">/</span>
                        <div class="flex-1 flex items-center gap-1 pr-1.5">
                            <span class="text-[10px] font-bold text-slate-500 shrink-0">RW</span>
                            <input type="text"
                                   name="form_data[kk_del][rw]"
                                   x-model="meta.rw"
                                   @input="meta.rw = ($event.target.value || '').replace(/\D/g, '').slice(0, 3)"
                                   @blur="meta.rw = meta.rw ? meta.rw.padStart(3, '0').slice(-3) : '001'"
                                   inputmode="numeric"
                                   maxlength="3"
                                   placeholder="001"
                                   class="w-full font-mono text-center text-xs font-bold py-1.5 px-1 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 focus:bg-white focus:ring-1 focus:ring-rose-600 focus:border-rose-600 focus:outline-none">
                        </div>
                    </div>
                </div>

                {{-- Kolom 2: Kode Pos --}}
                <div>
                    <label class="block font-bold text-slate-800 mb-1">
                        Kode Pos <span class="text-rose-600 font-bold" aria-hidden="true">*</span>
                    </label>
                    <input type="text"
                           name="form_data[kk_del][kode_pos]"
                           x-model="meta.kode_pos"
                           @input="meta.kode_pos = ($event.target.value || '').replace(/\D/g, '').slice(0, 5)"
                           inputmode="numeric"
                           maxlength="5"
                           placeholder="Contoh: 46182"
                           class="w-full font-mono text-center text-xs font-bold rounded-xl border border-slate-300 py-2.5 px-3 bg-white text-slate-900 focus:ring-2 focus:ring-rose-600/20 focus:border-rose-600 focus:outline-none shadow-2xs">
                </div>

                {{-- Kolom 3: Kecamatan --}}
                <div>
                    <label class="block font-bold text-slate-800 mb-1 flex items-center justify-between">
                        <span>Kecamatan <span class="text-rose-600">*</span></span>
                        <span class="text-[10px] text-blue-600 font-semibold">Pilih/Ketik</span>
                    </label>
                    <input type="text"
                           name="form_data[kk_del][nama_kecamatan]"
                           x-model="meta.kecamatan"
                           @input="onKecamatanInput()"
                           @change="onKecamatanInput()"
                           list="list-kecamatan-del"
                           placeholder="Ketik Kecamatan, misal: Manonjaya"
                           class="w-full text-xs font-bold uppercase rounded-xl border-slate-300 py-2.5 px-3 bg-white focus:ring-2 focus:ring-rose-600 focus:border-rose-600 shadow-2xs">
                    <datalist id="list-kecamatan-del">
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
                           name="form_data[kk_del][nama_desa]"
                           x-model="meta.desa"
                           list="list-desa-del"
                           placeholder="Nama Desa/Kelurahan"
                           class="w-full text-xs font-bold uppercase rounded-xl border-slate-300 py-2.5 px-3 bg-white focus:ring-2 focus:ring-rose-600 focus:border-rose-600 shadow-2xs">
                    <datalist id="list-desa-del">
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
                    <input type="text" name="form_data[kk_del][kabupaten]" x-model="meta.kabupaten"
                           class="w-full text-xs font-bold uppercase rounded-xl border-slate-200 py-2 px-3 bg-slate-50 text-slate-700">
                </div>
                <div>
                    <label class="block text-[10px] font-semibold text-slate-500 mb-0.5">Provinsi</label>
                    <input type="text" name="form_data[kk_del][provinsi]" x-model="meta.provinsi"
                           class="w-full text-xs font-bold uppercase rounded-xl border-slate-200 py-2 px-3 bg-slate-50 text-slate-700">
                </div>
                <div>
                    <label class="block text-[10px] font-semibold text-slate-500 mb-0.5">Negara</label>
                    <input type="text" name="form_data[kk_del][negara]" x-model="meta.negara"
                           class="w-full text-xs font-bold uppercase rounded-xl border-slate-200 py-2 px-3 bg-slate-50 text-slate-700">
                </div>
            </div>

        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════
         BAGIAN 2: TABEL ANGGOTA KELUARGA YANG DIKELUARKAN DARI KK
    ═══════════════════════════════════════════════════════════════════════ --}}
    <div class="p-6 space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h3 class="text-xs font-black uppercase tracking-wider text-slate-800 flex items-center gap-2">
                    <span>📋</span>
                    <span>Tabel Anggota Keluarga yang Dikeluarkan dari KK</span>
                </h3>
                <p class="text-[11px] text-slate-500 mt-0.5">
                    Masukkan rincian anggota keluarga yang dihapus dari kartu keluarga beserta alasan pengurangannya.
                </p>
            </div>

            <button type="button"
                    @click="addAnggota()"
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-xl shadow-sm hover:shadow-md transition-all self-start sm:self-auto cursor-pointer">
                <span>+</span>
                <span>Tambah Anggota yang Dikeluarkan</span>
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
                        <th class="py-3 px-4">Hubungan Sebelumnya (SHDK)</th>
                        <th class="py-3 px-4">Alasan Pengurangan</th>
                        <th class="py-3 px-4">Tanggal Kejadian</th>
                        <th class="py-3 px-4">Dokumen Bukti</th>
                        <th class="py-3 px-4 text-center w-24">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    <template x-for="(item, index) in anggota" :key="index">
                        <tr class="hover:bg-rose-50/30 transition-colors">
                            <td class="py-3.5 px-3.5 text-center font-bold text-slate-600" x-text="index + 1"></td>
                            <td class="py-3.5 px-4 font-bold text-slate-900" x-text="item.nama"></td>
                            <td class="py-3.5 px-4 font-mono font-bold text-slate-800" x-text="item.nik"></td>
                            <td class="py-3.5 px-3 text-center">
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-bold"
                                      :class="item.jenis_kelamin === 'LAKI-LAKI' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800'"
                                      x-text="item.jenis_kelamin === 'LAKI-LAKI' ? 'L' : 'P'"></span>
                            </td>
                            <td class="py-3.5 px-4 font-semibold text-slate-700" x-text="item.shdk"></td>
                            <td class="py-3.5 px-4">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase"
                                      :class="{
                                          'bg-slate-100 text-slate-800': item.alasan === 'MENINGGAL',
                                          'bg-amber-100 text-amber-800': item.alasan === 'PINDAH_KELUAR',
                                          'bg-rose-100 text-rose-800': item.alasan === 'PERCERAIAN',
                                          'bg-blue-100 text-blue-800': item.alasan === 'LAINNYA'
                                      }"
                                      x-text="formatAlasan(item.alasan)"></span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-600" x-text="formatDateId(item.tanggal_kejadian)"></td>
                            <td class="py-3.5 px-4 text-[11px] text-slate-600 font-mono" x-text="item.no_dokumen || '-'"></td>
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
                        <td colspan="9" class="py-8 text-center text-slate-400">
                            <p class="font-medium text-xs">Belum ada anggota keluarga yang dimasukkan ke daftar pengurangan.</p>
                            <p class="text-[11px] mt-1">Klik tombol <strong>+ Tambah Anggota yang Dikeluarkan</strong> di atas untuk mengisi data.</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Hidden Inputs for form submit --}}
        <template x-for="(item, index) in anggota" :key="'hidden-del-' + index">
            <div>
                <input type="hidden" :name="'form_data[kk_del][anggota][' + index + '][nama]'" :value="item.nama">
                <input type="hidden" :name="'form_data[kk_del][anggota][' + index + '][nik]'" :value="item.nik">
                <input type="hidden" :name="'form_data[kk_del][anggota][' + index + '][jenis_kelamin]'" :value="item.jenis_kelamin">
                <input type="hidden" :name="'form_data[kk_del][anggota][' + index + '][shdk]'" :value="item.shdk">
                <input type="hidden" :name="'form_data[kk_del][anggota][' + index + '][alasan]'" :value="item.alasan">
                <input type="hidden" :name="'form_data[kk_del][anggota][' + index + '][tanggal_kejadian]'" :value="item.tanggal_kejadian">
                <input type="hidden" :name="'form_data[kk_del][anggota][' + index + '][no_dokumen]'" :value="item.no_dokumen">
                <input type="hidden" :name="'form_data[kk_del][anggota][' + index + '][keterangan]'" :value="item.keterangan">
            </div>
        </template>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════
         MODAL FORMULIR DATA ANGGOTA KELUARGA YANG DIKELUARKAN
    ═══════════════════════════════════════════════════════════════════════ --}}
    <div x-show="showMemberForm"
         x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto"
         role="dialog"
         aria-modal="true">

        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs" @click="showMemberForm = false"></div>

        <div class="relative bg-white rounded-3xl shadow-2xl border border-slate-100 max-w-xl w-full p-6 z-10 my-8">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h3 class="text-base font-bold text-slate-900" x-text="editingIndex !== null ? 'Edit Data Anggota yang Dikeluarkan' : 'Tambah Anggota yang Dikeluarkan dari KK'"></h3>
                <button type="button" @click="showMemberForm = false" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg">✕</button>
            </div>

            <div class="mt-4 space-y-4 text-xs">
                {{-- Error Banner --}}
                <div x-show="validationError" x-text="validationError" class="p-3 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl font-semibold"></div>

                {{-- Baris 1: Nama Lengkap & NIK --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-800 mb-1">Nama Anggota Keluarga <span class="text-rose-600">*</span></label>
                        <input type="text" x-model="formMember.nama" placeholder="Contoh: SITI FATIMAH"
                               class="w-full text-xs font-bold uppercase rounded-xl border-slate-300 py-2 px-3 focus:ring-2 focus:ring-rose-600">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-800 mb-1">NIK (16 Digit) <span class="text-rose-600">*</span></label>
                        <input type="text"
                               x-model="formMember.nik"
                               placeholder="16 Digit Angka NIK"
                               maxlength="16"
                               @input="formMember.nik = ($event.target.value || '').replace(/\D/g, '').slice(0, 16)"
                               class="w-full text-xs font-mono font-bold rounded-xl border-slate-300 py-2 px-3 focus:ring-2 focus:ring-rose-600">
                    </div>
                </div>

                {{-- Baris 2: Jenis Kelamin, Hubungan Sebelumnya (SHDK) --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-800 mb-1">Jenis Kelamin <span class="text-rose-600">*</span></label>
                        <select x-model="formMember.jenis_kelamin" class="w-full text-xs font-semibold rounded-xl border-slate-300 py-2 px-3 focus:ring-2 focus:ring-rose-600">
                            <option value="LAKI-LAKI">LAKI-LAKI</option>
                            <option value="PEREMPUAN">PEREMPUAN</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-bold text-slate-800 mb-1">Hubungan Sebelumnya (SHDK) <span class="text-rose-600">*</span></label>
                        <select x-model="formMember.shdk" class="w-full text-xs font-bold rounded-xl border-slate-300 py-2 px-3 focus:ring-2 focus:ring-rose-600">
                            <option value="KEPALA KELUARGA">KEPALA KELUARGA</option>
                            <option value="SUAMI">SUAMI</option>
                            <option value="ISTRI">ISTRI</option>
                            <option value="ANAK">ANAK</option>
                            <option value="ORANG TUA">ORANG TUA</option>
                            <option value="MERTUA">MERTUA</option>
                            <option value="FAMILI LAIN">FAMILI LAIN</option>
                            <option value="LAINNYA">LAINNYA</option>
                        </select>
                    </div>
                </div>

                {{-- Baris 3: Alasan Pengurangan & Tanggal Kejadian --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-800 mb-1">Alasan Pengurangan <span class="text-rose-600">*</span></label>
                        <select x-model="formMember.alasan" class="w-full text-xs font-bold rounded-xl border-slate-300 py-2 px-3 focus:ring-2 focus:ring-rose-600">
                            <option value="MENINGGAL">Meninggal Dunia</option>
                            <option value="PINDAH_KELUAR">Pindah Domisili Keluar</option>
                            <option value="PERCERAIAN">Perceraian</option>
                            <option value="LAINNYA">Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-bold text-slate-800 mb-1">Tanggal Kejadian <span class="text-rose-600">*</span></label>
                        <input type="date" x-model="formMember.tanggal_kejadian"
                               class="w-full text-xs font-semibold rounded-xl border-slate-300 py-2 px-3 focus:ring-2 focus:ring-rose-600">
                    </div>
                </div>

                {{-- Baris 4: Nomor Surat Bukti & Keterangan --}}
                <div>
                    <label class="block font-bold text-slate-800 mb-1">Nomor Dokumen Bukti (Akta Kematian / SKPWNI / Putusan Cerai)</label>
                    <input type="text" x-model="formMember.no_dokumen" placeholder="Contoh: 3206-KM-12092026-0001"
                           class="w-full text-xs font-mono font-semibold uppercase rounded-xl border-slate-300 py-2 px-3 focus:ring-2 focus:ring-rose-600">
                </div>

                <div>
                    <label class="block font-bold text-slate-800 mb-1">Keterangan Tambahan (Opsional)</label>
                    <textarea x-model="formMember.keterangan" rows="2" placeholder="Catatan atau keterangan perihal pengurangan anggota..."
                              class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:ring-2 focus:ring-rose-600"></textarea>
                </div>

                <div class="pt-4 flex items-center justify-end gap-2 border-t border-slate-100">
                    <button type="button" @click="showMemberForm = false" class="px-4 py-2 text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl">Batal</button>
                    <button type="button" @click="applyMember()" class="px-5 py-2 text-xs font-bold text-white bg-rose-600 hover:bg-rose-700 rounded-xl shadow-sm">Simpan ke Daftar</button>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    function kkDelComponent(config) {
        return {
            meta: {
                no_kk: '',
                alasan_pengurangan: 'MENINGGAL',
                tanggal_peristiwa: new Date().toISOString().split('T')[0],
                no_dokumen_bukti: '',
                nama_kepala_keluarga: config.userName || '',
                alamat: config.userAlamat || '',
                rt: '001',
                rw: '001',
                kode_pos: '46182',
                kecamatan: (config.kecamatanName || 'SINGAPARNA').toUpperCase(),
                desa: (config.desaName || '').toUpperCase(),
                kabupaten: 'KABUPATEN TASIKMALAYA',
                provinsi: 'JAWA BARAT',
                negara: 'INDONESIA',
            },

            kecamatanMap: config.kecamatanMap || {},
            availableDesas: [],

            anggota: [
                {
                    nama: '',
                    nik: '',
                    jenis_kelamin: 'LAKI-LAKI',
                    shdk: 'ANAK',
                    alasan: 'MENINGGAL',
                    tanggal_kejadian: new Date().toISOString().split('T')[0],
                    no_dokumen: '',
                    keterangan: '',
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

            formatAlasan(val) {
                if (val === 'MENINGGAL') return 'Meninggal Dunia';
                if (val === 'PINDAH_KELUAR') return 'Pindah Keluar';
                if (val === 'PERCERAIAN') return 'Perceraian';
                return 'Lainnya';
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
                    jenis_kelamin: 'LAKI-LAKI',
                    shdk: 'ANAK',
                    alasan: this.meta.alasan_pengurangan || 'MENINGGAL',
                    tanggal_kejadian: this.meta.tanggal_peristiwa || new Date().toISOString().split('T')[0],
                    no_dokumen: this.meta.no_dokumen_bukti || '',
                    keterangan: '',
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
                    this.validationError = '⚠️ Nama Lengkap anggota wajib diisi.';
                    return;
                }
                if (!this.formMember.nik || this.formMember.nik.length !== 16) {
                    this.validationError = '⚠️ NIK wajib 16 digit angka.';
                    return;
                }
                if (!this.formMember.tanggal_kejadian) {
                    this.validationError = '⚠️ Tanggal Kejadian wajib diisi.';
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
                if (confirm('Hapus baris data anggota yang dikurangkan ini?')) {
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
