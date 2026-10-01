@php
    // Siapkan daftar kecamatan beserta desa untuk autocomplete otomatis
    $kecamatanMap = ($kecamatans ?? collect())->mapWithKeys(function($k) {
        return [
            strtoupper($k->nama_kecamatan) => $k->desas ? $k->desas->pluck('nama_desa')->map(fn($d) => strtoupper($d))->values() : []
        ];
    });

    $userKecName = strtoupper($user->kecamatan?->nama_kecamatan ?? 'SINGAPARNA');
    $defaultDesa = strtoupper($user->desa?->nama_desa ?? '');
    $existingF101 = old('form_data.f101', isset($submission) ? ($submission->form_data['f101'] ?? null) : null);
@endphp

<div id="kk-baru-root" class="space-y-6 font-sans">

    {{-- ═══════════════════════════════════════════════════════════════════════
         PANEL 1: DATA KEPALA KELUARGA & ALAMAT TEMPAT TINGGAL
         (Ditampilkan pada Step 2 Create Wizard ATAU selalu tampil pada Edit Draft)
    ═══════════════════════════════════════════════════════════════════════ --}}
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

    {{-- ═══════════════════════════════════════════════════════════════════════
         PANEL 2: ANGGOTA KELUARGA (CARD REPEATER & INPUT MODAL)
         (Ditampilkan pada Step 3 Create Wizard ATAU selalu tampil pada Edit Draft)
    ═══════════════════════════════════════════════════════════════════════ --}}
    <div x-show="typeof activeStep === 'undefined' || activeStep === 3" x-cloak class="space-y-5">

        {{-- Header Card & Actions --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 sm:p-6 space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-700 border border-indigo-100 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="users" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Anggota Keluarga</h3>
                        <p class="text-xs text-slate-500 mt-0.5">
                            Tambahkan anggota keluarga yang akan tercantum dalam KK.
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-3 self-start sm:self-auto">
                    <span class="px-3 py-1.5 rounded-xl bg-slate-100 text-slate-700 font-bold text-xs"
                          x-text="$store.kkBaru.anggota.length + ' Anggota Keluarga'">
                    </span>

                    <button type="button"
                            @click="$store.kkBaru.openAddMember()"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-sm transition-all cursor-pointer">
                        <i data-lucide="user-plus" class="w-4 h-4"></i>
                        <span>+ Tambah Anggota Keluarga</span>
                    </button>
                </div>
            </div>

            {{-- Empty State --}}
            <template x-if="$store.kkBaru.anggota.length === 0">
                <div class="p-8 text-center bg-slate-50 rounded-2xl border border-dashed border-slate-300 space-y-3">
                    <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-600 mx-auto flex items-center justify-center">
                        <i data-lucide="users" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-800">Belum ada anggota keluarga ditambahkan</h4>
                        <p class="text-xs text-slate-500 mt-1 max-w-md mx-auto">
                            Klik tombol di bawah untuk menambahkan kepala keluarga dan anggota keluarga lainnya ke dalam permohonan Kartu Keluarga.
                        </p>
                    </div>
                    <button type="button"
                            @click="$store.kkBaru.openAddMember()"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-sm transition-all cursor-pointer">
                        <i data-lucide="user-plus" class="w-4 h-4"></i>
                        <span>+ Tambah Anggota Keluarga</span>
                    </button>
                </div>
            </template>

            {{-- Member Cards Grid / List --}}
            <div class="space-y-3 pt-1">
                <template x-for="(m, idx) in $store.kkBaru.anggota" :key="'member-card-' + idx">
                    <div class="bg-white hover:bg-slate-50/70 border border-slate-200 rounded-2xl p-4 sm:p-5 transition-all space-y-3 shadow-2xs">
                        {{-- Card Header: Anggota Keluarga 1, 2, dst. + SHDK Badge --}}
                        <div class="flex items-center justify-between border-b border-slate-100 pb-2.5">
                            <div class="flex items-center gap-2">
                                <span class="w-6 h-6 rounded-full bg-blue-50 text-blue-700 font-bold text-xs flex items-center justify-center"
                                      x-text="idx + 1"></span>
                                <span class="text-xs font-bold text-slate-700 uppercase tracking-wider"
                                      x-text="'Anggota Keluarga ' + (idx + 1)"></span>
                            </div>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider"
                                  :class="$store.kkBaru.getShdkBadgeClass(m.shdk)"
                                  x-text="m.shdk">
                            </span>
                        </div>

                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                            <div class="space-y-1.5">
                                <h4 class="text-base font-black text-slate-900 uppercase tracking-wide" x-text="m.nama"></h4>

                                <div class="flex items-center gap-2.5 text-xs text-slate-600 flex-wrap font-sans">
                                    <span class="font-mono text-slate-800 font-bold bg-slate-100 px-2 py-0.5 rounded-md"
                                          x-text="'NIK: ' + $store.kkBaru.maskNik(m.nik)"></span>
                                    <span>•</span>
                                    <span class="font-semibold text-slate-700" x-text="m.jenis_kelamin"></span>
                                    <template x-if="m.tanggal_lahir">
                                        <span>•</span>
                                    </template>
                                    <template x-if="m.tanggal_lahir">
                                        <span class="text-blue-700 font-bold" x-text="$store.kkBaru.calculateAge(m.tanggal_lahir)"></span>
                                    </template>
                                    <span>•</span>
                                    <span class="text-slate-700 font-medium" x-text="m.status_kawin"></span>
                                    <span>•</span>
                                    <span class="text-slate-600" x-text="m.pekerjaan"></span>
                                </div>
                            </div>

                            {{-- Actions --}}
                            <div class="flex items-center gap-2 self-end sm:self-center">
                                <button type="button"
                                        @click="$store.kkBaru.editMember(idx)"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-slate-300 bg-white hover:bg-blue-50 hover:text-blue-700 hover:border-blue-300 text-slate-700 font-bold text-xs transition-colors cursor-pointer shadow-2xs">
                                    <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                                    <span>Edit</span>
                                </button>
                                <button type="button"
                                        @click="$store.kkBaru.removeMember(idx)"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-slate-300 bg-white hover:bg-rose-50 hover:text-rose-700 hover:border-rose-300 text-slate-700 font-bold text-xs transition-colors cursor-pointer shadow-2xs">
                                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                    <span>Hapus</span>
                                </button>
                            </div>
                        </div>

                        {{-- Sub Details Row --}}
                        <div class="pt-2.5 border-t border-slate-100 grid grid-cols-1 sm:grid-cols-3 gap-2 text-[11px] text-slate-500">
                            <div>
                                <span>Kelahiran & Agama:</span>
                                <strong class="text-slate-800 ml-1" x-text="m.tempat_lahir + ' (' + m.agama + ')'"></strong>
                            </div>
                            <div>
                                <span>Orang Tua:</span>
                                <strong class="text-slate-800 ml-1" x-text="'Ayah ' + m.nama_ayah + ' / Ibu ' + m.nama_ibu"></strong>
                            </div>
                            <div>
                                <span>Pendidikan & WN:</span>
                                <strong class="text-slate-800 ml-1" x-text="m.pendidikan + ' (' + m.kewarganegaraan + ')'"></strong>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════
         MODAL DIALOG: INPUT / UBAH ANGGOTA KELUARGA
    ═══════════════════════════════════════════════════════════════════════ --}}
    <div x-show="$store.kkBaru.showMemberModal"
         x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-4 bg-slate-900/60 backdrop-blur-xs overflow-y-auto"
         @keydown.escape.window="$store.kkBaru.showMemberModal = false">

        <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-2xl my-6 overflow-hidden transform transition-all"
             @click.outside="$store.kkBaru.showMemberModal = false">

            {{-- Modal Header --}}
            <div class="bg-slate-900 text-white px-5 sm:px-6 py-4 flex items-center justify-between border-b border-slate-800">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-blue-600 text-white flex items-center justify-center font-bold text-xs">
                        <i data-lucide="user-check" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-white text-sm"
                            x-text="$store.kkBaru.editingIndex !== null ? 'Ubah Data Anggota Keluarga' : 'Tambah Anggota Keluarga'">
                        </h4>
                        <p class="text-[11px] text-slate-300">
                            Lengkapi identitas anggota keluarga sesuai dengan dokumen kependudukan resmi.
                        </p>
                    </div>
                </div>

                <button type="button"
                        @click="$store.kkBaru.showMemberModal = false"
                        class="text-slate-400 hover:text-white p-1 rounded-lg hover:bg-slate-800 transition-colors cursor-pointer"
                        aria-label="Tutup modal">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            {{-- Modal Body --}}
            <div class="p-5 sm:p-6 space-y-5 max-h-[75vh] overflow-y-auto text-xs font-sans">

                {{-- Validation Error Alert --}}
                <div x-show="$store.kkBaru.validationError"
                     x-transition
                     class="p-3 bg-rose-50 border border-rose-300 text-rose-800 rounded-xl text-xs flex items-center gap-2.5">
                    <i data-lucide="alert-circle" class="w-4 h-4 text-rose-600 flex-shrink-0"></i>
                    <span class="font-bold" x-text="$store.kkBaru.validationError"></span>
                </div>

                {{-- IDENTITAS --}}
                <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 space-y-3">
                    <div class="flex items-center gap-2 text-slate-800 font-bold border-b border-slate-200 pb-2">
                        <i data-lucide="id-card" class="w-4 h-4 text-blue-600"></i>
                        <span>Identitas</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="sm:col-span-2">
                            <label class="block font-bold text-slate-800 mb-1">
                                Nama Lengkap <span class="text-rose-600">*</span>
                            </label>
                            <input type="text"
                                   x-model="$store.kkBaru.formMember.nama"
                                   placeholder="Contoh: AHMAD FAUZI (Sesuai KTP / Akta)"
                                   class="w-full text-xs font-bold uppercase rounded-lg border-slate-300 py-2 px-3 bg-white focus:ring-1 focus:ring-blue-600">
                        </div>

                        <div>
                            <label class="block font-bold text-slate-800 mb-1 flex items-center justify-between">
                                <span>NIK (16 Digit Angka) <span class="text-rose-600">*</span></span>
                                <span class="font-mono text-[10px]"
                                      :class="$store.kkBaru.formMember.nik.length === 16 ? 'text-emerald-600 font-bold' : 'text-slate-400'"
                                      x-text="$store.kkBaru.formMember.nik.length + '/16'"></span>
                            </label>
                            <input type="text"
                                   x-model="$store.kkBaru.formMember.nik"
                                   @input="$store.kkBaru.formMember.nik = $store.kkBaru.formMember.nik.replace(/\D/g, '').slice(0, 16)"
                                   inputmode="numeric"
                                   maxlength="16"
                                   placeholder="16 digit angka NIK"
                                   class="w-full font-mono text-xs font-bold text-blue-900 rounded-lg border-slate-300 py-2 px-3 bg-white focus:ring-1 focus:ring-blue-600">
                        </div>

                        <div>
                            <label class="block font-bold text-slate-800 mb-1">
                                Jenis Kelamin <span class="text-rose-600">*</span>
                            </label>
                            <select x-model="$store.kkBaru.formMember.jenis_kelamin"
                                    class="w-full text-xs font-bold rounded-lg border-slate-300 py-2 px-3 bg-white focus:ring-1 focus:ring-blue-600">
                                <option value="LAKI-LAKI">LAKI-LAKI</option>
                                <option value="PEREMPUAN">PEREMPUAN</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- KELAHIRAN --}}
                <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 space-y-3">
                    <div class="flex items-center gap-2 text-slate-800 font-bold border-b border-slate-200 pb-2">
                        <i data-lucide="calendar" class="w-4 h-4 text-emerald-600"></i>
                        <span>Kelahiran</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block font-bold text-slate-800 mb-1">
                                Tempat Lahir <span class="text-rose-600">*</span>
                            </label>
                            <input type="text"
                                   x-model="$store.kkBaru.formMember.tempat_lahir"
                                   placeholder="Kota / Kabupaten Lahir"
                                   class="w-full text-xs font-bold uppercase rounded-lg border-slate-300 py-2 px-3 bg-white focus:ring-1 focus:ring-blue-600">
                        </div>

                        <div>
                            <label class="block font-bold text-slate-800 mb-1 flex items-center justify-between">
                                <span>Tanggal Lahir <span class="text-rose-600">*</span></span>
                                <span class="text-[10px] text-blue-600 font-bold"
                                      x-text="$store.kkBaru.calculateAge($store.kkBaru.formMember.tanggal_lahir)"></span>
                            </label>
                            <input type="date"
                                   x-model="$store.kkBaru.formMember.tanggal_lahir"
                                   class="w-full text-xs font-bold rounded-lg border-slate-300 py-2 px-3 bg-white focus:ring-1 focus:ring-blue-600">
                        </div>

                        <div>
                            <label class="block font-bold text-slate-800 mb-1">
                                Agama <span class="text-rose-600">*</span>
                            </label>
                            <select x-model="$store.kkBaru.formMember.agama"
                                    class="w-full text-xs font-bold rounded-lg border-slate-300 py-2 px-3 bg-white focus:ring-1 focus:ring-blue-600">
                                <option value="ISLAM">ISLAM</option>
                                <option value="KRISTEN PROTESTAN">KRISTEN PROTESTAN</option>
                                <option value="KATOLIK">KATOLIK</option>
                                <option value="HINDU">HINDU</option>
                                <option value="BUDDHA">BUDDHA</option>
                                <option value="KHONGHUCU">KHONGHUCU</option>
                            </select>
                        </div>

                        <div>
                            <label class="block font-bold text-slate-800 mb-1">
                                Golongan Darah <span class="text-rose-600">*</span>
                            </label>
                            <select x-model="$store.kkBaru.formMember.gol_darah"
                                    class="w-full text-xs font-bold rounded-lg border-slate-300 py-2 px-3 bg-white focus:ring-1 focus:ring-blue-600">
                                <option value="-">- (TIDAK TAHU)</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="AB">AB</option>
                                <option value="O">O</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- PENDIDIKAN & PEKERJAAN --}}
                <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 space-y-3">
                    <div class="flex items-center gap-2 text-slate-800 font-bold border-b border-slate-200 pb-2">
                        <i data-lucide="briefcase" class="w-4 h-4 text-amber-600"></i>
                        <span>Pendidikan & Pekerjaan</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block font-bold text-slate-800 mb-1">
                                Pendidikan Terakhir <span class="text-rose-600">*</span>
                            </label>
                            <select x-model="$store.kkBaru.formMember.pendidikan"
                                    class="w-full text-xs font-semibold rounded-lg border-slate-300 py-2 px-3 bg-white focus:ring-1 focus:ring-blue-600">
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

                        <div>
                            <label class="block font-bold text-slate-800 mb-1">
                                Pekerjaan <span class="text-rose-600">*</span>
                            </label>
                            <input type="text"
                                   x-model="$store.kkBaru.formMember.pekerjaan"
                                   placeholder="Contoh: Wiraswasta, Karyawan Swasta"
                                   class="w-full text-xs font-bold uppercase rounded-lg border-slate-300 py-2 px-3 bg-white focus:ring-1 focus:ring-blue-600">

                            {{-- Quick Chips --}}
                            <div class="flex flex-wrap gap-1 mt-1.5">
                                <template x-for="job in ['WIRASWASTA', 'KARYAWAN SWASTA', 'PELAJAR/MAHASISWA', 'MENGURUS RUMAH TANGGA', 'PNS', 'BELUM/TIDAK BEKERJA']" :key="job">
                                    <button type="button"
                                            @click="$store.kkBaru.formMember.pekerjaan = job"
                                            class="px-2 py-0.5 rounded text-[10px] bg-slate-200/80 hover:bg-blue-100 hover:text-blue-800 text-slate-700 transition-colors cursor-pointer"
                                            x-text="job">
                                    </button>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- HUBUNGAN KELUARGA --}}
                <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 space-y-3">
                    <div class="flex items-center gap-2 text-slate-800 font-bold border-b border-slate-200 pb-2">
                        <i data-lucide="heart" class="w-4 h-4 text-purple-600"></i>
                        <span>Hubungan Keluarga</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block font-bold text-slate-800 mb-1">
                                Hubungan dengan Kepala Keluarga <span class="text-rose-600">*</span>
                            </label>
                            <select x-model="$store.kkBaru.formMember.shdk"
                                    class="w-full text-xs font-bold rounded-lg border-slate-300 py-2 px-3 bg-white focus:ring-1 focus:ring-blue-600">
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

                        <div>
                            <label class="block font-bold text-slate-800 mb-1">
                                Status Perkawinan <span class="text-rose-600">*</span>
                            </label>
                            <select x-model="$store.kkBaru.formMember.status_kawin"
                                    class="w-full text-xs font-bold rounded-lg border-slate-300 py-2 px-3 bg-white focus:ring-1 focus:ring-blue-600">
                                <option value="BELUM KAWIN">BELUM KAWIN</option>
                                <option value="KAWIN TERCATAT">KAWIN TERCATAT</option>
                                <option value="KAWIN BELUM TERCATAT">KAWIN BELUM TERCATAT</option>
                                <option value="CERAI HIDUP">CERAI HIDUP</option>
                                <option value="CERAI MATI">CERAI MATI</option>
                            </select>
                        </div>

                        {{-- CONDITIONAL FIELD: Tanggal Perkawinan (Hanya jika Kawin) --}}
                        <div x-show="$store.kkBaru.formMember.status_kawin.includes('KAWIN')"
                             x-transition
                             class="sm:col-span-2 bg-blue-50/70 p-3 rounded-xl border border-blue-200">
                            <label class="block font-bold text-slate-800 mb-1 flex items-center justify-between">
                                <span>Tanggal Perkawinan</span>
                                <span class="text-[10px] text-blue-700 font-semibold">Wajib bila sudah menikah</span>
                            </label>
                            <input type="date"
                                   x-model="$store.kkBaru.formMember.tgl_kawin"
                                   class="w-full text-xs font-bold rounded-lg border-blue-300 py-2 px-3 bg-white focus:ring-1 focus:ring-blue-600">
                        </div>
                    </div>
                </div>

                {{-- ORANG TUA --}}
                <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 space-y-3">
                    <div class="flex items-center gap-2 text-slate-800 font-bold border-b border-slate-200 pb-2">
                        <i data-lucide="users" class="w-4 h-4 text-emerald-600"></i>
                        <span>Orang Tua</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block font-bold text-slate-800 mb-1">
                                Nama Ayah Kandung <span class="text-rose-600">*</span>
                            </label>
                            <input type="text"
                                   x-model="$store.kkBaru.formMember.nama_ayah"
                                   placeholder="Nama Ayah Sesuai Akta Lahir"
                                   class="w-full text-xs font-bold uppercase rounded-lg border-slate-300 py-2 px-3 bg-white focus:ring-1 focus:ring-blue-600">
                        </div>

                        <div>
                            <label class="block font-bold text-slate-800 mb-1">
                                Nama Ibu Kandung <span class="text-rose-600">*</span>
                            </label>
                            <input type="text"
                                   x-model="$store.kkBaru.formMember.nama_ibu"
                                   placeholder="Nama Ibu Sesuai Akta Lahir"
                                   class="w-full text-xs font-bold uppercase rounded-lg border-slate-300 py-2 px-3 bg-white focus:ring-1 focus:ring-blue-600">
                        </div>
                    </div>
                </div>

                {{-- KEWARGANEGARAAN --}}
                <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 space-y-3">
                    <div class="flex items-center gap-2 text-slate-800 font-bold border-b border-slate-200 pb-2">
                        <i data-lucide="globe" class="w-4 h-4 text-blue-600"></i>
                        <span>Kewarganegaraan</span>
                    </div>

                    <div class="space-y-3">
                        <div>
                            <label class="block font-bold text-slate-800 mb-1">
                                Kewarganegaraan <span class="text-rose-600">*</span>
                            </label>
                            <select x-model="$store.kkBaru.formMember.kewarganegaraan"
                                    class="w-full text-xs font-bold rounded-lg border-slate-300 py-2 px-3 bg-white focus:ring-1 focus:ring-blue-600">
                                <option value="WNI">WNI (Warga Negara Indonesia)</option>
                                <option value="WNA">WNA (Warga Negara Asing)</option>
                            </select>
                        </div>

                        {{-- CONDITIONAL FIELDS: Paspor & KITAP (HANYA MUNCUL JIKA WNA) --}}
                        <div x-show="$store.kkBaru.formMember.kewarganegaraan === 'WNA'"
                             x-transition
                             class="bg-amber-50/80 p-3.5 rounded-xl border border-amber-200 grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block font-bold text-amber-900 mb-1">
                                    Nomor Paspor (WNA)
                                </label>
                                <input type="text"
                                       x-model="$store.kkBaru.formMember.no_paspor"
                                       placeholder="Contoh: A1234567"
                                       class="w-full font-mono text-xs uppercase rounded-lg border-amber-300 py-2 px-3 bg-white">
                            </div>

                            <div>
                                <label class="block font-bold text-amber-900 mb-1">
                                    Nomor KITAP / KITAS (WNA)
                                </label>
                                <input type="text"
                                       x-model="$store.kkBaru.formMember.no_kitap"
                                       placeholder="Contoh: 2C21..."
                                       class="w-full font-mono text-xs uppercase rounded-lg border-amber-300 py-2 px-3 bg-white">
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Modal Footer --}}
            <div class="bg-slate-50 px-5 sm:px-6 py-4 border-t border-slate-200 flex items-center justify-end gap-3">
                <button type="button"
                        @click="$store.kkBaru.showMemberModal = false"
                        class="px-4 py-2.5 rounded-xl border border-slate-300 bg-white text-slate-700 text-xs font-bold hover:bg-slate-100 transition-colors cursor-pointer">
                    Batal
                </button>
                <button type="button"
                        @click="$store.kkBaru.saveMember()"
                        class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-sm transition-all cursor-pointer">
                    <i data-lucide="check" class="w-4 h-4"></i>
                    <span x-text="$store.kkBaru.editingIndex !== null ? 'Perbarui Anggota' : 'Simpan Anggota'"></span>
                </button>
            </div>

        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════
         SERIALISASI HIDDEN INPUTS (MENJAMIN 100% KONTRAK BACKEND FORM_DATA.F101)
    ═══════════════════════════════════════════════════════════════════════ --}}
    <div class="hidden" aria-hidden="true">
        <input type="hidden" name="form_data[f101][nama_pemohon]" :value="$store.kkBaru.meta.nama_pemohon || '{{ $user->name }}'">
        <input type="hidden" name="form_data[f101][nik_pemohon]" :value="$store.kkBaru.meta.nik_pemohon || '{{ $user->nik }}'">
        <input type="hidden" name="form_data[f101][nama_kepala_keluarga]" :value="$store.kkBaru.meta.nama_kepala_keluarga">
        <input type="hidden" name="form_data[f101][alamat]" :value="$store.kkBaru.meta.alamat">
        <input type="hidden" name="form_data[f101][rt]" :value="$store.kkBaru.meta.rt">
        <input type="hidden" name="form_data[f101][rw]" :value="$store.kkBaru.meta.rw">
        <input type="hidden" name="form_data[f101][kode_pos]" :value="$store.kkBaru.meta.kode_pos">
        <input type="hidden" name="form_data[f101][nama_kecamatan]" :value="$store.kkBaru.meta.kecamatan">
        <input type="hidden" name="form_data[f101][nama_desa]" :value="$store.kkBaru.meta.desa">
        <input type="hidden" name="form_data[f101][nama_kabupaten]" :value="$store.kkBaru.meta.kabupaten">
        <input type="hidden" name="form_data[f101][nama_provinsi]" :value="$store.kkBaru.meta.provinsi">
        <input type="hidden" name="form_data[f101][negara]" :value="$store.kkBaru.meta.negara">
        <input type="hidden" name="form_data[f101][jumlah_anggota]" :value="$store.kkBaru.anggota.length">

        <template x-for="(item, index) in $store.kkBaru.anggota" :key="'f101-serialized-' + index">
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

</div>

<script>
    (function() {
        const configKkBaru = {
            userName: @js($user->name),
            userNik: @js($user->nik ?? ''),
            userPhone: @js($user->phone ?? ''),
            userEmail: @js($user->email ?? ''),
            userAlamat: @js($user->alamat_detail ?? ''),
            kecamatanName: @js($userKecName),
            desaName: @js($defaultDesa),
            kecamatanMap: @js($kecamatanMap),
            existingData: @js($existingF101)
        };

        function registerKkBaruStore() {
            if (!window.Alpine) return;
            if (Alpine.store('kkBaru')) return;

            Alpine.store('kkBaru', {
                kecamatanMap: configKkBaru.kecamatanMap || {},
                availableDesas: [],
                showMemberModal: false,
                editingIndex: null,
                validationError: '',

                meta: {
                    nama_pemohon: configKkBaru.userName || '',
                    nik_pemohon: configKkBaru.userNik || '',
                    telepon: configKkBaru.userPhone || '',
                    email: configKkBaru.userEmail || '',
                    nama_kepala_keluarga: configKkBaru.existingData?.nama_kepala_keluarga || configKkBaru.userName || '',
                    alamat: configKkBaru.existingData?.alamat || configKkBaru.userAlamat || '',
                    rt: configKkBaru.existingData?.rt || '001',
                    rw: configKkBaru.existingData?.rw || '001',
                    kode_pos: configKkBaru.existingData?.kode_pos || '46182',
                    kecamatan: configKkBaru.existingData?.nama_kecamatan || configKkBaru.kecamatanName || 'SINGAPARNA',
                    desa: configKkBaru.existingData?.nama_desa || configKkBaru.desaName || '',
                    kabupaten: configKkBaru.existingData?.nama_kabupaten || 'KABUPATEN TASIKMALAYA',
                    provinsi: configKkBaru.existingData?.nama_provinsi || 'JAWA BARAT',
                    negara: configKkBaru.existingData?.negara || 'INDONESIA',
                },

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

                anggota: configKkBaru.existingData?.anggota ? configKkBaru.existingData.anggota : [
                    {
                        nama: configKkBaru.userName || '',
                        nik: configKkBaru.userNik || '',
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

                onKecamatanInput(resetDesa = true) {
                    const kec = (this.meta.kecamatan || '').toUpperCase().trim();
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
                    if (this.kecamatanMap[kec]) {
                        this.availableDesas = this.kecamatanMap[kec];
                        if (resetDesa && this.availableDesas.length > 0 && !this.meta.desa) {
                            this.meta.desa = this.availableDesas[0];
                        }
                    } else {
                        this.availableDesas = [];
                    }
                },

                openAddMember() {
                    this.editingIndex = null;
                    this.validationError = '';
                    this.formMember = {
                        nama: '',
                        nik: '',
                        jenis_kelamin: this.anggota.length === 0 ? 'LAKI-LAKI' : 'PEREMPUAN',
                        tempat_lahir: 'TASIKMALAYA',
                        tanggal_lahir: '',
                        agama: 'ISLAM',
                        pendidikan: 'SLTA / SEDERAJAT',
                        pekerjaan: this.anggota.length === 1 ? 'MENGURUS RUMAH TANGGA' : 'KARYAWAN SWASTA',
                        gol_darah: '-',
                        status_kawin: this.anggota.length === 1 ? 'KAWIN TERCATAT' : 'BELUM KAWIN',
                        tgl_kawin: '',
                        shdk: this.anggota.length === 0 ? 'KEPALA KELUARGA' : (this.anggota.length === 1 ? 'ISTRI' : 'ANAK'),
                        kewarganegaraan: 'WNI',
                        no_paspor: '',
                        no_kitap: '',
                        nama_ayah: '',
                        nama_ibu: '',
                    };
                    this.showMemberModal = true;
                    this.$nextTick(() => window.lucide?.createIcons());
                },

                editMember(index) {
                    this.editingIndex = index;
                    this.validationError = '';
                    this.formMember = JSON.parse(JSON.stringify(this.anggota[index]));
                    this.showMemberModal = true;
                    this.$nextTick(() => window.lucide?.createIcons());
                },

                saveMember() {
                    this.validationError = '';
                    const m = this.formMember;
                    if (!m.nama || !m.nama.trim()) {
                        this.validationError = 'Nama Lengkap wajib diisi.';
                        return;
                    }
                    if (!m.nik || m.nik.replace(/\D/g, '').length !== 16) {
                        this.validationError = 'NIK wajib 16 digit angka.';
                        return;
                    }
                    if (!m.tempat_lahir || !m.tempat_lahir.trim()) {
                        this.validationError = 'Tempat Lahir wajib diisi.';
                        return;
                    }
                    if (!m.tanggal_lahir) {
                        this.validationError = 'Tanggal Lahir wajib diisi.';
                        return;
                    }
                    if (!m.pekerjaan || !m.pekerjaan.trim()) {
                        this.validationError = 'Jenis Pekerjaan wajib diisi.';
                        return;
                    }
                    if (!m.nama_ayah || !m.nama_ayah.trim()) {
                        this.validationError = 'Nama Ayah Kandung wajib diisi.';
                        return;
                    }
                    if (!m.nama_ibu || !m.nama_ibu.trim()) {
                        this.validationError = 'Nama Ibu Kandung wajib diisi.';
                        return;
                    }

                    // Clean & uppercase
                    m.nama = m.nama.toUpperCase().trim();
                    m.nik = m.nik.replace(/\D/g, '').slice(0, 16);
                    m.tempat_lahir = m.tempat_lahir.toUpperCase().trim();
                    m.pekerjaan = m.pekerjaan.toUpperCase().trim();
                    m.nama_ayah = m.nama_ayah.toUpperCase().trim();
                    m.nama_ibu = m.nama_ibu.toUpperCase().trim();

                    if (this.editingIndex !== null) {
                        this.anggota[this.editingIndex] = { ...m };
                    } else {
                        this.anggota.push({ ...m });
                    }

                    this.showMemberModal = false;
                    this.editingIndex = null;
                    this.validationError = '';
                    this.$nextTick(() => window.lucide?.createIcons());
                },

                removeMember(index) {
                    if (this.anggota.length <= 1) {
                        alert('Kartu Keluarga harus memiliki minimal 1 orang anggota keluarga (Kepala Keluarga).');
                        return;
                    }
                    const memberName = this.anggota[index]?.nama || 'anggota ini';
                    if (confirm(`Apakah Anda yakin ingin menghapus ${memberName} dari daftar anggota keluarga?`)) {
                        this.anggota.splice(index, 1);
                        if (this.editingIndex === index) {
                            this.showMemberModal = false;
                            this.editingIndex = null;
                        }
                        this.$nextTick(() => window.lucide?.createIcons());
                    }
                },

                calculateAge(dateStr) {
                    if (!dateStr) return '';
                    const birth = new Date(dateStr);
                    if (isNaN(birth.getTime())) return '';
                    const diff = Date.now() - birth.getTime();
                    const age = new Date(diff).getUTCFullYear() - 1970;
                    return age >= 0 ? `${age} tahun` : '';
                },

                maskNik(nik) {
                    if (!nik) return '—';
                    const str = String(nik).trim();
                    if (str.length !== 16) return str;
                    return str.substring(0, 6) + '••••••••' + str.substring(14);
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
                }
            });
        }

        document.addEventListener('alpine:init', registerKkBaruStore);
        if (window.Alpine) {
            registerKkBaruStore();
        }
    })();
</script>
