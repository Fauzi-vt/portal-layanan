@php
    $kecamatanMap = ($kecamatans ?? collect())->mapWithKeys(function($k) {
        return [
            strtoupper($k->nama_kecamatan) => $k->desas ? $k->desas->pluck('nama_desa')->map(fn($d) => strtoupper($d))->values() : []
        ];
    });
    $defaultDesa = $user->desa?->nama_desa ?: ($desas->first()?->nama_desa ?? '');
    $existingPindahSatuDesa = old('form_data.f_pindah_satu_desa', $submission->form_data['f_pindah_satu_desa'] ?? null);
@endphp

<div x-data="pindahSatuDesaDigitalForm({
    userName: @js($user->name),
    userNik: @js($user->nik ?? ''),
    userPhone: @js($user->phone ?? ''),
    userEmail: @js($user->email ?? ''),
    userAlamat: @js($user->alamat_detail ?? ''),
    kecamatanName: @js($user->kecamatan?->nama_kecamatan ?? 'MANONJAYA'),
    desaName: @js($defaultDesa),
    existingData: @js($existingPindahSatuDesa)
})" class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden font-sans">

    {{-- ═══════════════════════════════════════════════════════════════════════
         STEPPER HEADER & PROGRESS BAR
    ═══════════════════════════════════════════════════════════════════════ --}}
    <div class="bg-slate-900 text-white p-5 sm:p-6 border-b border-slate-800">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-5">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500/20 border border-blue-400/30 text-blue-300 text-xs font-bold uppercase tracking-wider mb-2">
                    <i data-lucide="home" class="w-3.5 h-3.5"></i>
                    <span>Formulir F.1-23 — Dukcapil</span>
                </div>
                <h2 class="text-lg sm:text-xl font-extrabold text-white tracking-tight">
                    Permohonan Pindah Datang WNI (Dalam Satu Desa)
                </h2>
                <p class="text-xs text-slate-400 mt-0.5">
                    Pengurusan surat permohonan perpindahan domisili alamat rumah dalam satu desa/kelurahan yang sama.
                </p>
            </div>

            <div class="flex items-center gap-3 bg-slate-800/80 px-4 py-2.5 rounded-xl border border-slate-700/60 self-start md:self-auto">
                <div class="text-right">
                    <span class="block text-[10px] text-slate-400 uppercase font-semibold">Langkah Saat Ini</span>
                    <span class="text-xs font-bold text-blue-400" x-text="'Langkah ' + currentStep + ' dari ' + totalSteps + ': ' + stepTitles[currentStep]"></span>
                </div>
                <div class="w-8 h-8 rounded-lg bg-blue-600 text-white font-bold text-xs flex items-center justify-center">
                    <span x-text="currentStep"></span>
                </div>
            </div>
        </div>

        {{-- Visual Stepper Tabs --}}
        <div class="grid grid-cols-5 gap-1.5 sm:gap-2">
            <template x-for="step in totalSteps" :key="step">
                <button type="button"
                        @click="goToStep(step)"
                        class="flex flex-col items-center py-2 px-1 rounded-lg transition-all text-center group cursor-pointer"
                        :class="{
                            'bg-blue-600 text-white font-bold shadow-xs': currentStep === step,
                            'bg-slate-800/90 text-blue-400 hover:bg-slate-800': currentStep > step,
                            'bg-slate-800/40 text-slate-500 hover:bg-slate-800/70': currentStep < step
                        }">
                    <div class="flex items-center gap-1 text-[11px] font-semibold">
                        <template x-if="currentStep > step">
                            <i data-lucide="check-circle-2" class="w-3.5 h-3.5 text-blue-400"></i>
                        </template>
                        <span x-text="'0' + step"></span>
                    </div>
                    <span class="text-[10px] hidden sm:block truncate max-w-[90px] mt-0.5" x-text="stepLabels[step]"></span>
                </button>
            </template>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════
         SERIALISASI HIDDEN INPUTS (MENJAGA CONTRACT BACKEND F_PINDAH_SATU_DESA)
    ═══════════════════════════════════════════════════════════════════════ --}}
    <div class="hidden">
        <input type="hidden" name="form_data[f_pindah_satu_desa][no_kk]" x-bind:value="meta.no_kk">
        <input type="hidden" name="form_data[f_pindah_satu_desa][nama_kepala]" x-bind:value="meta.nama_kepala">
        <input type="hidden" name="form_data[f_pindah_satu_desa][nama_pemohon]" x-bind:value="meta.nama_pemohon">
        <input type="hidden" name="form_data[f_pindah_satu_desa][nik_pemohon]" x-bind:value="meta.nik_pemohon">
        <input type="hidden" name="form_data[f_pindah_satu_desa][telepon]" x-bind:value="meta.telepon">
        <input type="hidden" name="form_data[f_pindah_satu_desa][email]" x-bind:value="meta.email">

        <input type="hidden" name="form_data[f_pindah_satu_desa][alasan_pindah]" x-bind:value="meta.alasan_pindah">
        <input type="hidden" name="form_data[f_pindah_satu_desa][alamat]" x-bind:value="meta.alamat">
        <input type="hidden" name="form_data[f_pindah_satu_desa][rt]" x-bind:value="meta.rt">
        <input type="hidden" name="form_data[f_pindah_satu_desa][rw]" x-bind:value="meta.rw">
        <input type="hidden" name="form_data[f_pindah_satu_desa][kode_pos]" x-bind:value="meta.kode_pos">
        <input type="hidden" name="form_data[f_pindah_satu_desa][nama_desa]" x-bind:value="meta.nama_desa">
        <input type="hidden" name="form_data[f_pindah_satu_desa][nama_kecamatan]" x-bind:value="meta.nama_kecamatan">

        <input type="hidden" name="form_data[f_pindah_satu_desa][alamat_tujuan]" x-bind:value="meta.alamat_tujuan">
        <input type="hidden" name="form_data[f_pindah_satu_desa][rt_tujuan]" x-bind:value="meta.rt_tujuan">
        <input type="hidden" name="form_data[f_pindah_satu_desa][rw_tujuan]" x-bind:value="meta.rw_tujuan">
        <input type="hidden" name="form_data[f_pindah_satu_desa][kode_pos_tujuan]" x-bind:value="meta.kode_pos_tujuan">
        <input type="hidden" name="form_data[f_pindah_satu_desa][nama_desa_tujuan]" x-bind:value="meta.nama_desa">
        <input type="hidden" name="form_data[f_pindah_satu_desa][status_kk_tujuan]" x-bind:value="meta.status_kk_tujuan">
        <input type="hidden" name="form_data[f_pindah_satu_desa][jumlah_anggota]" x-bind:value="anggota.length">

        <template x-for="(m, idx) in anggota" :key="idx">
            <div>
                <input type="hidden" :name="'form_data[f_pindah_satu_desa][anggota][' + idx + '][nama]'" :value="m.nama">
                <input type="hidden" :name="'form_data[f_pindah_satu_desa][anggota][' + idx + '][nik]'" :value="m.nik">
                <input type="hidden" :name="'form_data[f_pindah_satu_desa][anggota][' + idx + '][shdk]'" :value="m.shdk">
            </div>
        </template>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════
         STEP CONTENT BODY
    ═══════════════════════════════════════════════════════════════════════ --}}
    <div class="p-5 sm:p-7 space-y-6">

        {{-- STEP 1: DATA PEMOHON --}}
        <div x-show="currentStep === 1" x-cloak class="space-y-5">
            <div class="border-b border-slate-100 pb-3">
                <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                    <span>Step 1: Identitas & Data Pemohon</span>
                </h3>
                <p class="text-xs text-slate-500 mt-1">Data pemohon terisi otomatis dari profil akun terdaftar Warga.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Nama Lengkap Pemohon</label>
                    <input type="text" x-model="meta.nama_pemohon" readonly class="w-full font-bold rounded-xl border border-slate-200 bg-slate-100/80 text-slate-800 py-2.5 px-3 cursor-not-allowed">
                </div>

                <div>
                    <label class="block font-semibold text-slate-700 mb-1">NIK Pemohon</label>
                    <input type="text" x-model="meta.nik_pemohon" readonly class="w-full font-mono font-bold rounded-xl border border-slate-200 bg-slate-100/80 text-slate-800 py-2.5 px-3 cursor-not-allowed">
                </div>

                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Nomor WhatsApp / HP</label>
                    <input type="text" x-model="meta.telepon" readonly class="w-full font-semibold rounded-xl border border-slate-200 bg-slate-100/80 text-slate-800 py-2.5 px-3 cursor-not-allowed">
                </div>

                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Email Terdaftar</label>
                    <input type="text" x-model="meta.email" readonly class="w-full font-semibold rounded-xl border border-slate-200 bg-slate-100/80 text-slate-800 py-2.5 px-3 cursor-not-allowed">
                </div>
            </div>
        </div>

        {{-- STEP 2: DATA KK ASLI & ALAMAT ASAL --}}
        <div x-show="currentStep === 2" x-cloak class="space-y-5">
            <div class="border-b border-slate-100 pb-3">
                <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                    <span>Step 2: Data KK & Alamat Asal Pemohon</span>
                </h3>
                <p class="text-xs text-slate-500 mt-1">Masukkan Nomor KK asal dan lokasi tempat tinggal sebelum pindah.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                <div>
                    <label class="block font-bold text-slate-800 mb-1">
                        Nomor Kartu Keluarga (KK) <span class="text-rose-600">*</span>
                    </label>
                    <input type="text"
                           x-model="meta.no_kk"
                           @input="meta.no_kk = ($event.target.value || '').replace(/\D/g, '').slice(0, 16)"
                           inputmode="numeric"
                           maxlength="16"
                           placeholder="16 digit Nomor KK"
                           class="w-full font-mono font-bold rounded-xl border border-slate-300 py-2.5 px-3 focus:ring-2 focus:ring-blue-600">
                </div>

                <div>
                    <label class="block font-bold text-slate-800 mb-1">
                        Nama Kepala Keluarga (KK Asal) <span class="text-rose-600">*</span>
                    </label>
                    <input type="text"
                           x-model="meta.nama_kepala"
                           placeholder="Nama Kepala Keluarga Asal"
                           class="w-full font-bold uppercase rounded-xl border border-slate-300 py-2.5 px-3 focus:ring-2 focus:ring-blue-600">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 text-xs pt-2 border-t border-slate-100">
                <div class="sm:col-span-2">
                    <label class="block font-bold text-slate-800 mb-1">Alamat Asal (Jalan / Dusun) <span class="text-rose-600">*</span></label>
                    <input type="text" x-model="meta.alamat" placeholder="Jl. Raya / Dusun Asal" class="w-full font-semibold uppercase rounded-xl border border-slate-300 py-2.5 px-3 focus:ring-2 focus:ring-blue-600">
                </div>

                <div>
                    <label class="block font-bold text-slate-800 mb-1">RT / RW Asal <span class="text-rose-600">*</span></label>
                    <div class="flex items-center gap-1.5">
                        <input type="text" x-model="meta.rt" placeholder="RT" maxlength="3" class="w-full text-center font-mono font-bold rounded-xl border border-slate-300 py-2.5 px-2">
                        <span class="text-slate-400 font-bold">/</span>
                        <input type="text" x-model="meta.rw" placeholder="RW" maxlength="3" class="w-full text-center font-mono font-bold rounded-xl border border-slate-300 py-2.5 px-2">
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-800 mb-1">Desa & Kecamatan Asal</label>
                    <input type="text" :value="meta.nama_desa + ' / ' + meta.nama_kecamatan" readonly class="w-full font-bold uppercase rounded-xl border border-slate-200 bg-slate-100 py-2.5 px-3 cursor-not-allowed">
                </div>
            </div>
        </div>

        {{-- STEP 3: ALASAN & ALAMAT TUJUAN (SATU DESA) --}}
        <div x-show="currentStep === 3" x-cloak class="space-y-5">
            <div class="border-b border-slate-100 pb-3">
                <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                    <span>Step 3: Alasan & Alamat Tujuan Baru (Satu Desa)</span>
                </h3>
                <p class="text-xs text-slate-500 mt-1">Tentukan alasan perpindahan dan lokasi rumah tujuan dalam desa yang sama.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                <div>
                    <label class="block font-bold text-slate-800 mb-1">Alasan Pindah <span class="text-rose-600">*</span></label>
                    <select x-model="meta.alasan_pindah" class="w-full font-bold rounded-xl border border-slate-300 py-2.5 px-3 focus:ring-2 focus:ring-blue-600">
                        <option value="PEKERJAAN">💼 Pekerjaan / Dinas</option>
                        <option value="PENDIDIKAN">🎓 Pendidikan / Sekolah</option>
                        <option value="PERNIKAHAN">💍 Pernikahan / Keluarga</option>
                        <option value="PERUMAHAN">🏠 Perumahan / Tempat Tinggal Baru</option>
                        <option value="LAINNYA">📝 Alasan Lainnya</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-800 mb-1">Status KK Tujuan <span class="text-rose-600">*</span></label>
                    <select x-model="meta.status_kk_tujuan" class="w-full font-bold rounded-xl border border-slate-300 py-2.5 px-3 focus:ring-2 focus:ring-blue-600">
                        <option value="NUMPANG_KK">👨‍👩‍👧 Numpang Kartu Keluarga</option>
                        <option value="MEMBUAT_KK_BARU">✨ Membuat Kartu Keluarga Baru</option>
                        <option value="KK_TETAP">📄 Nomor Kartu Keluarga Tetap</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 text-xs pt-2 border-t border-slate-100">
                <div class="sm:col-span-2">
                    <label class="block font-bold text-slate-800 mb-1">Alamat Tujuan Baru (Jalan / Dusun) <span class="text-rose-600">*</span></label>
                    <input type="text" x-model="meta.alamat_tujuan" placeholder="Jl. Raya / Dusun Tujuan Baru" class="w-full font-semibold uppercase rounded-xl border border-slate-300 py-2.5 px-3 focus:ring-2 focus:ring-blue-600">
                </div>

                <div>
                    <label class="block font-bold text-slate-800 mb-1">RT / RW Tujuan <span class="text-rose-600">*</span></label>
                    <div class="flex items-center gap-1.5">
                        <input type="text" x-model="meta.rt_tujuan" placeholder="RT" maxlength="3" class="w-full text-center font-mono font-bold rounded-xl border border-slate-300 py-2.5 px-2">
                        <span class="text-slate-400 font-bold">/</span>
                        <input type="text" x-model="meta.rw_tujuan" placeholder="RW" maxlength="3" class="w-full text-center font-mono font-bold rounded-xl border border-slate-300 py-2.5 px-2">
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-800 mb-1">Kode Pos Tujuan</label>
                    <input type="text" x-model="meta.kode_pos_tujuan" placeholder="46182" maxlength="5" class="w-full text-center font-mono font-bold rounded-xl border border-slate-300 py-2.5 px-3">
                </div>
            </div>
        </div>

        {{-- STEP 4: ANGGOTA KELUARGA PINDAH --}}
        <div x-show="currentStep === 4" x-cloak class="space-y-5">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-3">
                <div>
                    <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                        <span>Step 4: Anggota Keluarga yang Pindah</span>
                    </h3>
                    <p class="text-xs text-slate-500 mt-1">Daftar pemohon & anggota keluarga yang ikut pindah domisili.</p>
                </div>

                <button type="button" @click="addAnggota()" class="px-4 py-2 rounded-xl bg-blue-600 text-white font-bold text-xs hover:bg-blue-700 cursor-pointer">
                    + Tambah Anggota Pindah
                </button>
            </div>

            <div class="space-y-3">
                <template x-for="(m, idx) in anggota" :key="idx">
                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-3.5 text-xs flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 w-full">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase">Nama Anggota</label>
                                <input type="text" x-model="m.nama" placeholder="Nama Lengkap" class="w-full font-bold uppercase rounded-lg border-slate-300 py-1.5 px-2 text-xs">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase">NIK (16 Digit)</label>
                                <input type="text" x-model="m.nik" placeholder="NIK 16 Digit" maxlength="16" class="w-full font-mono font-bold rounded-lg border-slate-300 py-1.5 px-2 text-xs">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase">Hubungan (SHDK)</label>
                                <select x-model="m.shdk" class="w-full font-semibold rounded-lg border-slate-300 py-1.5 px-2 text-xs">
                                    <option value="Kepala Keluarga">Kepala Keluarga</option>
                                    <option value="Suami">Suami</option>
                                    <option value="Istri">Istri</option>
                                    <option value="Anak">Anak</option>
                                    <option value="Orang Tua">Orang Tua</option>
                                    <option value="Mertua">Mertua</option>
                                    <option value="Famili Lain">Famili Lain</option>
                                </select>
                            </div>
                        </div>

                        <button type="button" @click="removeAnggota(idx)" x-show="anggota.length > 1" class="text-rose-600 hover:text-rose-800 font-bold text-xs self-end sm:self-center">
                            Hapus
                        </button>
                    </div>
                </template>
            </div>
        </div>

        {{-- STEP 5: REVIEW --}}
        <div x-show="currentStep === 5" x-cloak class="space-y-5">
            <div class="border-b border-slate-100 pb-3">
                <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                    <span>Step 5: Periksa Ringkasan Pindah Satu Desa</span>
                </h3>
                <p class="text-xs text-slate-500 mt-1">Periksa kembali data perpindahan Anda sebelum mengajukan.</p>
            </div>

            <div class="space-y-4 text-xs">
                <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 space-y-2">
                    <div class="flex items-center justify-between border-b border-slate-200 pb-2">
                        <span class="font-bold text-slate-900">Alamat Asal & Pemohon</span>
                        <button type="button" @click="goToStep(2)" class="text-blue-700 font-bold">Ubah</button>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                        <div><span class="block text-slate-400">Pemohon:</span><span class="font-bold text-slate-800" x-text="meta.nama_pemohon"></span></div>
                        <div><span class="block text-slate-400">No KK:</span><span class="font-mono font-bold text-slate-800" x-text="meta.no_kk"></span></div>
                        <div><span class="block text-slate-400">Kepala KK Asal:</span><span class="font-bold text-slate-800" x-text="meta.nama_kepala"></span></div>
                        <div><span class="block text-slate-400">Alamat Asal:</span><span class="font-semibold text-slate-800" x-text="meta.alamat + ' (RT ' + meta.rt + '/RW ' + meta.rw + ')'"></span></div>
                    </div>
                </div>

                <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 space-y-2">
                    <div class="flex items-center justify-between border-b border-slate-200 pb-2">
                        <span class="font-bold text-slate-900">Alamat Tujuan Baru</span>
                        <button type="button" @click="goToStep(3)" class="text-blue-700 font-bold">Ubah</button>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                        <div><span class="block text-slate-400">Alasan Pindah:</span><span class="font-bold text-slate-800" x-text="meta.alasan_pindah"></span></div>
                        <div><span class="block text-slate-400">Status KK Tujuan:</span><span class="font-bold text-slate-800" x-text="meta.status_kk_tujuan"></span></div>
                        <div><span class="block text-slate-400">Alamat Tujuan:</span><span class="font-semibold text-slate-800" x-text="meta.alamat_tujuan + ' (RT ' + meta.rt_tujuan + '/RW ' + meta.rw_tujuan + ')'"></span></div>
                    </div>
                </div>

                <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 space-y-2">
                    <div class="flex items-center justify-between border-b border-slate-200 pb-2">
                        <span class="font-bold text-slate-900">Anggota Ikut Pindah (<span x-text="anggota.length"></span> Orang)</span>
                        <button type="button" @click="goToStep(4)" class="text-blue-700 font-bold">Ubah</button>
                    </div>
                    <template x-for="(m, idx) in anggota" :key="idx">
                        <div class="flex items-center justify-between text-xs py-1 border-b border-slate-100 last:border-0">
                            <span class="font-bold text-slate-800" x-text="(idx + 1) + '. ' + m.nama + ' (NIK: ' + m.nik + ')'"></span>
                            <span class="font-semibold text-blue-700" x-text="m.shdk"></span>
                        </div>
                    </template>
                </div>
            </div>
        </div>

    </div>

    {{-- FOOTER NAVIGATION --}}
    <div class="p-4 sm:p-5 bg-slate-50 border-t border-slate-200 flex items-center justify-between">
        <button type="button" @click="prevStep()" x-show="currentStep > 1" class="px-4 py-2 rounded-xl border border-slate-300 bg-white text-slate-700 font-bold text-xs hover:bg-slate-100 cursor-pointer">
            &larr; Kembali
        </button>
        <div x-show="currentStep === 1"></div>
        <button type="button" @click="nextStep()" x-show="currentStep < totalSteps" class="px-5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs cursor-pointer shadow-xs">
            Lanjut &rarr;
        </button>
        <div x-show="currentStep === totalSteps" class="text-xs text-blue-800 font-bold bg-blue-50 px-3 py-1.5 rounded-xl border border-blue-200">
            ✓ Permohonan Siap Diajukan
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('pindahSatuDesaDigitalForm', (config) => ({
            currentStep: 1,
            totalSteps: 5,
            stepTitles: {
                1: 'Data Pemohon',
                2: 'Data KK & Alamat Asal',
                3: 'Alamat Tujuan Baru',
                4: 'Anggota Pindah',
                5: 'Review Pengajuan'
            },
            stepLabels: { 1: 'Pemohon', 2: 'Asal', 3: 'Tujuan', 4: 'Anggota', 5: 'Review' },
            meta: {
                nama_pemohon: config.existingData?.nama_pemohon || config.userName || '',
                nik_pemohon: config.existingData?.nik_pemohon || config.userNik || '',
                telepon: config.existingData?.telepon || config.userPhone || '',
                email: config.existingData?.email || config.userEmail || '',
                no_kk: config.existingData?.no_kk || '',
                nama_kepala: config.existingData?.nama_kepala || config.userName || '',
                alamat: config.existingData?.alamat || config.userAlamat || '',
                rt: config.existingData?.rt || '001',
                rw: config.existingData?.rw || '001',
                kode_pos: config.existingData?.kode_pos || '46182',
                nama_desa: config.existingData?.nama_desa || config.desaName || '',
                nama_kecamatan: config.existingData?.nama_kecamatan || config.kecamatanName || 'MANONJAYA',
                alasan_pindah: config.existingData?.alasan_pindah || 'PEKERJAAN',
                status_kk_tujuan: config.existingData?.status_kk_tujuan || 'NUMPANG_KK',
                alamat_tujuan: config.existingData?.alamat_tujuan || '',
                rt_tujuan: config.existingData?.rt_tujuan || '001',
                rw_tujuan: config.existingData?.rw_tujuan || '001',
                kode_pos_tujuan: config.existingData?.kode_pos_tujuan || '46182'
            },
            anggota: config.existingData?.anggota || [
                { nama: config.userName || '', nik: config.userNik || '', shdk: 'Kepala Keluarga' }
            ],
            init() { this.$nextTick(() => window.lucide?.createIcons()); },
            goToStep(step) { if (step >= 1 && step <= this.totalSteps) { this.currentStep = step; this.$nextTick(() => window.lucide?.createIcons()); } },
            nextStep() { if (this.currentStep < this.totalSteps) { this.currentStep++; this.$nextTick(() => window.lucide?.createIcons()); } },
            prevStep() { if (this.currentStep > 1) { this.currentStep--; this.$nextTick(() => window.lucide?.createIcons()); } },
            addAnggota() { this.anggota.push({ nama: '', nik: '', shdk: 'Anggota Keluarga' }); },
            removeAnggota(idx) { if (this.anggota.length > 1) this.anggota.splice(idx, 1); }
        }));
    });
</script>
