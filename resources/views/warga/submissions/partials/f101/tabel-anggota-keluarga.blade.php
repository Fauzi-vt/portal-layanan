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
