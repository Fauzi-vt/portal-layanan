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
