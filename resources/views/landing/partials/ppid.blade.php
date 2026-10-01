    <section id="ppid" class="py-20 bg-slate-50 border-t border-slate-200/90 relative scroll-mt-24 sm:scroll-mt-28 overflow-hidden">
        
        {{-- Ambient decorative background circles --}}
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-slate-200/50 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-slate-200/50 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

            {{-- 1. HEADER SECTION --}}
            <div class="text-center max-w-3xl mx-auto mb-12">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-slate-100 text-[#0a2558] border border-slate-200 text-xs font-semibold shadow-2xs">
                    <span class="w-2 h-2 rounded-full bg-[#0a2558]"></span>
                    <span>Pejabat Pengelola Informasi & Dokumentasi (PPID)</span>
                </div>
                <h2 class="text-2xl sm:text-4xl font-black text-slate-900 tracking-tight mt-3">
                    Portal Keterbukaan Informasi Publik
                </h2>
                <p class="text-xs sm:text-sm text-slate-600 mt-2.5 leading-relaxed">
                    Sesuai amanat <strong>Undang-Undang No. 14 Tahun 2008</strong>, Pemerintah Kabupaten Tasikmalaya melalui Diskominfo menjamin hak masyarakat untuk memperoleh informasi publik secara transparan, akurat, dan bebas biaya.
                </p>

                {{-- Action Quick Buttons --}}
                <div class="flex flex-wrap items-center justify-center gap-3 mt-6">
                    <button type="button"
                            @click="openPpidModal()"
                            class="px-5 py-2.5 rounded-full text-xs font-bold text-white bg-[#0a2558] hover:bg-[#0d3070] shadow-md hover:shadow-lg transition-all active:scale-95 flex items-center gap-2 cursor-pointer">
                        <i data-lucide="send" class="w-4 h-4 text-white"></i>
                        <span>Ajukan Permohonan Informasi</span>
                    </button>
                    <button type="button"
                            @click="openPpidTracking()"
                            class="px-5 py-2.5 rounded-full text-xs font-bold text-slate-800 bg-white hover:bg-slate-50 border border-slate-300 shadow-2xs transition-all active:scale-95 flex items-center gap-2 cursor-pointer">
                        <i data-lucide="search" class="w-4 h-4 text-slate-600"></i>
                        <span>Lacak Status Permohonan</span>
                    </button>
                    <button type="button"
                            @click="activePpidTab = 'alur'; $nextTick(() => lucide.createIcons())"
                            class="px-5 py-2.5 rounded-full text-xs font-semibold text-slate-700 bg-white hover:bg-slate-50 border border-slate-200 transition-all flex items-center gap-1.5 cursor-pointer">
                        <i data-lucide="git-branch" class="w-4 h-4 text-slate-600"></i>
                        <span>Alur & SOP Pelayanan</span>
                    </button>
                </div>
            </div>

            {{-- 2. 4 HIGHLIGHT STATS CARDS --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
                <div class="p-4 bg-white rounded-2xl border border-slate-200 shadow-xs flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl bg-slate-100 text-[#0a2558] flex items-center justify-center flex-shrink-0">
                        <i data-lucide="folder-check" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <span class="text-lg font-black text-slate-900 block leading-tight">4 Kategori</span>
                        <span class="text-[11px] text-slate-500 font-medium">Informasi Publik Resmi</span>
                    </div>
                </div>

                <div class="p-4 bg-white rounded-2xl border border-slate-200 shadow-xs flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl bg-slate-100 text-[#0a2558] flex items-center justify-center flex-shrink-0">
                        <i data-lucide="clock" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <span class="text-lg font-black text-slate-900 block leading-tight">10 + 7 Hari</span>
                        <span class="text-[11px] text-slate-500 font-medium">Maks. Pelayanan UU KIP</span>
                    </div>
                </div>

                <div class="p-4 bg-white rounded-2xl border border-slate-200 shadow-xs flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl bg-slate-100 text-[#0a2558] flex items-center justify-center flex-shrink-0">
                        <i data-lucide="badge-percent" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <span class="text-lg font-black text-slate-900 block leading-tight">Rp 0 (Gratis)</span>
                        <span class="text-[11px] text-slate-500 font-medium">Bebas Pungutan Biaya</span>
                    </div>
                </div>

                <div class="p-4 bg-white rounded-2xl border border-slate-200 shadow-xs flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl bg-slate-100 text-[#0a2558] flex items-center justify-center flex-shrink-0">
                        <i data-lucide="network" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <span class="text-lg font-black text-slate-900 block leading-tight">39 Kecamatan</span>
                        <span class="text-[11px] text-slate-500 font-medium">PPID Pembantu Terhubung</span>
                    </div>
                </div>
            </div>

            {{-- 3. MAIN PPID CARD CONTAINER WITH TABS --}}
            <div id="ppid-daftar" class="bg-white rounded-3xl border border-slate-200/90 shadow-xl overflow-hidden scroll-mt-28">

                {{-- Tabs Bar --}}
                <div class="px-5 sm:px-8 pt-4 pb-4 sm:pb-0 bg-slate-900 text-white flex flex-wrap items-center justify-between gap-4 border-b border-slate-800">
                    <div class="flex items-center gap-2 overflow-x-auto pb-3 sm:pb-0 scrollbar-none w-full sm:w-auto">
                        <button type="button"
                                @click="activePpidTab = 'dokumen'; $nextTick(() => lucide.createIcons())"
                                class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2 whitespace-nowrap cursor-pointer"
                                :class="activePpidTab === 'dokumen' ? 'bg-white text-[#0a2558] shadow-md' : 'text-slate-300 hover:text-white hover:bg-white/10'">
                            <i data-lucide="files" class="w-4 h-4"></i>
                            <span>Daftar Informasi Publik (DIP)</span>
                            <span class="px-1.5 py-0.5 rounded-full text-[10px] font-extrabold"
                                  :class="activePpidTab === 'dokumen' ? 'bg-[#0a2558] text-white' : 'bg-white/20 text-white'">
                                17
                            </span>
                        </button>

                        <button type="button"
                                @click="activePpidTab = 'alur'; $nextTick(() => lucide.createIcons())"
                                class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2 whitespace-nowrap cursor-pointer"
                                :class="activePpidTab === 'alur' ? 'bg-white text-[#0a2558] shadow-md' : 'text-slate-300 hover:text-white hover:bg-white/10'">
                            <i data-lucide="workflow" class="w-4 h-4"></i>
                            <span>Alur & SOP Permohonan</span>
                        </button>

                        <button type="button"
                                @click="activePpidTab = 'regulasi'; $nextTick(() => lucide.createIcons())"
                                class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2 whitespace-nowrap cursor-pointer"
                                :class="activePpidTab === 'regulasi' ? 'bg-white text-[#0a2558] shadow-md' : 'text-slate-300 hover:text-white hover:bg-white/10'">
                            <i data-lucide="scale" class="w-4 h-4"></i>
                            <span>Dasar Hukum & Regulasi</span>
                        </button>

                        <button type="button"
                                @click="activePpidTab = 'kontak'; $nextTick(() => lucide.createIcons())"
                                class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2 whitespace-nowrap cursor-pointer"
                                :class="activePpidTab === 'kontak' ? 'bg-white text-[#0a2558] shadow-md' : 'text-slate-300 hover:text-white hover:bg-white/10'">
                            <i data-lucide="phone-call" class="w-4 h-4"></i>
                            <span>Meja Layanan PPID</span>
                        </button>
                    </div>

                    <div class="hidden sm:flex items-center gap-2 pb-3 sm:pb-0 text-[11px] text-slate-300">
                        <i data-lucide="shield-check" class="w-4 h-4 text-slate-300"></i>
                        <span>Diskominfo Terverifikasi KIP</span>
                    </div>
                </div>

                {{-- TAB CONTENT 1: DAFTAR INFORMASI PUBLIK (DIP) --}}
                <div x-show="activePpidTab === 'dokumen'" class="p-5 sm:p-8 space-y-6">

                    {{-- Filters & Search Controls --}}
                    <div class="flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-4 pb-6 border-b border-slate-100">
                        
                        {{-- Category Pills --}}
                        <div class="flex flex-wrap items-center gap-2">
                            <button type="button"
                                    @click="ppidCategory = 'all'; $nextTick(() => lucide.createIcons())"
                                    class="px-3.5 py-1.5 rounded-full text-xs font-bold transition-all cursor-pointer"
                                    :class="ppidCategory === 'all' ? 'bg-[#0a2558] text-white border border-[#0a2558] shadow-xs' : 'bg-white hover:bg-slate-50 text-slate-600 border border-slate-200'">
                                Semua Kategori (17)
                            </button>
                            <button type="button"
                                    @click="ppidCategory = 'berkala'; $nextTick(() => lucide.createIcons())"
                                    class="px-3.5 py-1.5 rounded-full text-xs font-bold transition-all cursor-pointer"
                                    :class="ppidCategory === 'berkala' ? 'bg-[#0a2558] text-white border border-[#0a2558] shadow-xs' : 'bg-white hover:bg-slate-50 text-slate-600 border border-slate-200'">
                                Berkala (6)
                            </button>
                            <button type="button"
                                    @click="ppidCategory = 'serta-merta'; $nextTick(() => lucide.createIcons())"
                                    class="px-3.5 py-1.5 rounded-full text-xs font-bold transition-all cursor-pointer"
                                    :class="ppidCategory === 'serta-merta' ? 'bg-[#0a2558] text-white border border-[#0a2558] shadow-xs' : 'bg-white hover:bg-slate-50 text-slate-600 border border-slate-200'">
                                Serta Merta (4)
                            </button>
                            <button type="button"
                                    @click="ppidCategory = 'setiap-saat'; $nextTick(() => lucide.createIcons())"
                                    class="px-3.5 py-1.5 rounded-full text-xs font-bold transition-all cursor-pointer"
                                    :class="ppidCategory === 'setiap-saat' ? 'bg-[#0a2558] text-white border border-[#0a2558] shadow-xs' : 'bg-white hover:bg-slate-50 text-slate-600 border border-slate-200'">
                                Setiap Saat (5)
                            </button>
                            <button type="button"
                                    @click="ppidCategory = 'dikecualikan'; $nextTick(() => lucide.createIcons())"
                                    class="px-3.5 py-1.5 rounded-full text-xs font-bold transition-all cursor-pointer"
                                    :class="ppidCategory === 'dikecualikan' ? 'bg-[#0a2558] text-white border border-[#0a2558] shadow-xs' : 'bg-white hover:bg-slate-50 text-slate-600 border border-slate-200'">
                                Dikecualikan (2)
                            </button>
                        </div>

                        {{-- Search Input --}}
                        <div class="relative w-full lg:w-80">
                            <input type="text"
                                   x-model="ppidSearch"
                                   placeholder="Cari dokumen, kode, topik..."
                                   class="w-full pl-9 pr-8 py-2 text-xs sm:text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-[#0a2558] text-slate-800 placeholder-slate-400">
                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">
                                <i data-lucide="search" class="w-4 h-4"></i>
                            </div>
                            <button type="button"
                                    x-show="ppidSearch"
                                    @click="ppidSearch = ''"
                                    class="absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 p-0.5">
                                <i data-lucide="x" class="w-3.5 h-3.5"></i>
                            </button>
                        </div>

                    </div>

                    {{-- Dynamic Summary Text --}}
                    <div class="flex items-center justify-between text-xs text-slate-500">
                        <div>
                            Menampilkan <strong class="text-slate-900" x-text="filteredPpidDocs.length"></strong> dari <strong class="text-slate-900" x-text="ppidDocs.length"></strong> dokumen informasi publik resmi
                        </div>
                        <span class="text-[11px] text-slate-600 bg-slate-100 px-2.5 py-0.5 rounded-md font-semibold border border-slate-200/80">
                            Terakhir Diperbarui: Maret 2025
                        </span>
                    </div>

                    {{-- Documents Grid --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <template x-for="doc in filteredPpidDocs" :key="doc.id">
                            <div class="p-5 rounded-2xl border border-slate-200/90 bg-white hover:border-slate-300 hover:shadow-md transition-all flex flex-col justify-between group">
                                <div class="space-y-2.5">
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="flex items-center gap-2">
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider" :class="doc.categoryBadge" x-text="doc.categoryLabel"></span>
                                            <span class="text-[10px] font-mono text-slate-400 font-semibold" x-text="doc.id"></span>
                                        </div>
                                        <div class="flex items-center gap-1 text-[11px] font-semibold text-slate-400">
                                            <i data-lucide="download" class="w-3 h-3"></i>
                                            <span x-text="doc.downloads"></span>
                                        </div>
                                    </div>

                                    <h4 class="text-xs sm:text-sm font-bold text-slate-900 group-hover:text-[#0a2558] transition-colors leading-snug line-clamp-2"
                                        x-text="doc.title">
                                    </h4>

                                    <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed"
                                       x-text="doc.summary">
                                    </p>
                                </div>

                                <div class="pt-4 mt-3 border-t border-slate-100 flex items-center justify-between gap-2 text-[11px]">
                                    <div class="flex items-center gap-2 text-slate-500">
                                        <span class="px-1.5 py-0.5 rounded bg-slate-100 font-bold text-slate-700 text-[10px]" x-text="doc.type"></span>
                                        <span x-text="doc.size"></span>
                                        <span>&bull;</span>
                                        <span x-text="doc.date"></span>
                                    </div>

                                    <div class="flex items-center gap-1.5">
                                        <button type="button"
                                                @click="openDocPreview(doc)"
                                                class="px-2.5 py-1.5 rounded-lg text-slate-600 hover:text-slate-900 hover:bg-slate-100 font-semibold transition-colors cursor-pointer"
                                                title="Lihat Ringkasan">
                                            Detail
                                        </button>
                                        <button type="button"
                                                @click="downloadDoc(doc)"
                                                class="px-3 py-1.5 rounded-lg bg-[#0a2558] hover:bg-[#0d3070] text-white font-bold transition-all shadow-2xs flex items-center gap-1 cursor-pointer">
                                            <i data-lucide="download" class="w-3 h-3"></i>
                                            <span>Unduh</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    {{-- Empty State --}}
                    <div x-show="filteredPpidDocs.length === 0" class="py-12 text-center text-slate-400 space-y-2">
                        <i data-lucide="file-question" class="w-10 h-10 mx-auto text-slate-300"></i>
                        <p class="font-bold text-slate-700 text-sm">Dokumen Informasi Tidak Ditemukan</p>
                        <p class="text-xs text-slate-500">Tidak ada dokumen yang cocok dengan kata kunci pencarian atau kategori yang dipilih.</p>
                        <button type="button" @click="ppidCategory = 'all'; ppidSearch = ''" class="mt-2 text-xs font-bold text-[#0a2558] hover:underline">
                            Reset Filter Pencarian
                        </button>
                    </div>

                </div>

                {{-- TAB CONTENT 2: ALUR & PROSEDUR PERMOHONAN (SOP) --}}
                <div x-show="activePpidTab === 'alur'" class="p-5 sm:p-8 space-y-8">
                    <div>
                        <h3 class="text-base sm:text-lg font-black text-slate-900">
                            Standar Operasional Prosedur (SOP) Permohonan Informasi Publik
                        </h3>
                        <p class="text-xs text-slate-500 mt-1">
                            Berdasarkan Peraturan Komisi Informasi (PERKI) No. 1 Tahun 2021 dan UU RI No. 14 Tahun 2008.
                        </p>
                    </div>

                    {{-- 4 Flow Steps --}}
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 relative">
                        {{-- Step 1 --}}
                        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/90 relative flex flex-col justify-between">
                            <div class="space-y-3">
                                <div class="w-8 h-8 rounded-xl bg-[#0a2558] text-white font-extrabold flex items-center justify-center text-sm shadow-xs">
                                    1
                                </div>
                                <h4 class="text-sm font-bold text-slate-900">Pengajuan Permohonan</h4>
                                <p class="text-xs text-slate-500 leading-relaxed">
                                    Pemohon mengisi formulir permohonan informasi secara online melalui portal ini atau datang langsung ke Meja PPID Diskominfo dengan melampirkan fotokopi KTP / Identitas.
                                </p>
                            </div>
                            <span class="text-[10px] font-semibold text-slate-600 bg-slate-100 px-2 py-0.5 rounded border border-slate-200/80 mt-4 block text-center">
                                Online / Langsung
                            </span>
                        </div>

                        {{-- Step 2 --}}
                        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/90 relative flex flex-col justify-between">
                            <div class="space-y-3">
                                <div class="w-8 h-8 rounded-xl bg-[#0a2558] text-white font-extrabold flex items-center justify-center text-sm shadow-xs">
                                    2
                                </div>
                                <h4 class="text-sm font-bold text-slate-900">Verifikasi & Tanda Terima</h4>
                                <p class="text-xs text-slate-500 leading-relaxed">
                                    Petugas PPID memeriksa kelengkapan identitas dan kejelasan permohonan. Petugas menerbitkan Bukti Tanda Terima Permohonan ber-Nomor Registrasi resmi.
                                </p>
                            </div>
                            <span class="text-[10px] font-semibold text-slate-600 bg-slate-100 px-2 py-0.5 rounded border border-slate-200/80 mt-4 block text-center">
                                Waktu: 1 - 3 Hari Kerja
                            </span>
                        </div>

                        {{-- Step 3 --}}
                        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/90 relative flex flex-col justify-between">
                            <div class="space-y-3">
                                <div class="w-8 h-8 rounded-xl bg-[#0a2558] text-white font-extrabold flex items-center justify-center text-sm shadow-xs">
                                    3
                                </div>
                                <h4 class="text-sm font-bold text-slate-900">Penyiapan & Uji Dokumen</h4>
                                <p class="text-xs text-slate-500 leading-relaxed">
                                    PPID mengoordinasikan penyiapan data kepada perangkat daerah terkait. Batas waktu penyiapan maksimal 10 hari kerja (+ perpanjangan 7 hari kerja jika informasi kompleks).
                                </p>
                            </div>
                            <span class="text-[10px] font-semibold text-slate-600 bg-slate-100 px-2 py-0.5 rounded border border-slate-200/80 mt-4 block text-center">
                                Maks. 10 + 7 Hari Kerja
                            </span>
                        </div>

                        {{-- Step 4 --}}
                        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/90 relative flex flex-col justify-between">
                            <div class="space-y-3">
                                <div class="w-8 h-8 rounded-xl bg-[#0a2558] text-white font-extrabold flex items-center justify-center text-sm shadow-xs">
                                    4
                                </div>
                                <h4 class="text-sm font-bold text-slate-900">Penyerahan Dokumen</h4>
                                <p class="text-xs text-slate-500 leading-relaxed">
                                    Pemohon menerima salinan dokumen informasi yang diminta dalam bentuk softcopy via email / download portal atau salinan fisik di loket pelayanan.
                                </p>
                            </div>
                            <span class="text-[10px] font-semibold text-slate-600 bg-slate-100 px-2 py-0.5 rounded border border-slate-200/80 mt-4 block text-center">
                                Selesai & Bebas Biaya
                            </span>
                        </div>
                    </div>

                    {{-- Mekanisme Pengajuan Keberatan --}}
                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 text-xs text-slate-700 space-y-2.5">
                        <div class="flex items-center gap-2 font-bold text-slate-900 text-sm">
                            <i data-lucide="alert-triangle" class="w-4 h-4 text-[#0a2558]"></i>
                            <span>Mekanisme Pengajuan Keberatan Informasi Publik</span>
                        </div>
                        <p class="leading-relaxed">
                            Apabila permohonan informasi tidak ditanggapi, ditolak sebagian/seluruhnya, atau biaya/alasan tidak memuaskan, pemohon berhak mengajukan <strong>Surat Keberatan kepada Atasan PPID (Sekretaris Daerah / Kepala Dinas Kominfo)</strong> dalam jangka waktu paling lambat <strong>30 (tiga puluh) hari kerja</strong> setelah diterimanya surat pemberitahuan tertulis.
                        </p>
                    </div>

                    <div class="flex flex-wrap items-center justify-end gap-3 pt-2">
                        <button type="button"
                                @click="triggerSyntheticDownload('Formulir_Permohonan_Informasi_Publik_Kosong.pdf'); triggerToast('Mengunduh Formulir Permohonan Manual (PDF)...')"
                                class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-700 hover:bg-slate-100 text-xs font-bold transition-all flex items-center gap-2 cursor-pointer">
                            <i data-lucide="download" class="w-3.5 h-3.5"></i>
                            <span>Unduh Formulir Kosong (PDF)</span>
                        </button>
                        <button type="button"
                                @click="openPpidModal()"
                                class="px-5 py-2.5 rounded-xl bg-[#0a2558] hover:bg-[#0d3070] text-white text-xs font-bold shadow-md transition-all flex items-center gap-2 cursor-pointer">
                            <i data-lucide="send" class="w-3.5 h-3.5 text-white"></i>
                            <span>Mulai Isi Permohonan Online</span>
                        </button>
                    </div>
                </div>

                {{-- TAB CONTENT 3: DASAR HUKUM & HAK PEMOHON --}}
                <div x-show="activePpidTab === 'regulasi'" class="p-5 sm:p-8 space-y-6">
                    <div>
                        <h3 class="text-base sm:text-lg font-black text-slate-900">
                            Landasan Hukum & Hak Pemohon Informasi Publik
                        </h3>
                        <p class="text-xs text-slate-500 mt-1">
                            Payung hukum keterbukaan informasi di lingkungan Pemerintah Kabupaten Tasikmalaya.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                            <span class="px-2 py-0.5 rounded bg-slate-200/80 text-slate-700 font-semibold text-[10px] uppercase">Undang-Undang Nasional</span>
                            <h4 class="font-bold text-slate-900 text-sm">UU RI No. 14 Tahun 2008</h4>
                            <p class="text-slate-600 leading-relaxed">
                                Tentang Keterbukaan Informasi Publik yang menjamin hak setiap warga negara untuk mengetahui rencana pembuatan kebijakan publik, program keputusan publik, dan proses pengambilan keputusan publik.
                            </p>
                        </div>

                        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                            <span class="px-2 py-0.5 rounded bg-slate-200/80 text-slate-700 font-semibold text-[10px] uppercase">Standar Layanan</span>
                            <h4 class="font-bold text-slate-900 text-sm">PERKI No. 1 Tahun 2021</h4>
                            <p class="text-slate-600 leading-relaxed">
                                Peraturan Komisi Informasi tentang Standar Layanan Informasi Publik yang memuat tata kelola PPID, format dokumen, jangka waktu layanan, dan prosedur uji konsekuensi informasi dikecualikan.
                            </p>
                        </div>

                        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                            <span class="px-2 py-0.5 rounded bg-slate-200/80 text-slate-700 font-semibold text-[10px] uppercase">Regulasi Daerah</span>
                            <h4 class="font-bold text-slate-900 text-sm">Perbup Tasikmalaya No. 48 Tahun 2021</h4>
                            <p class="text-slate-600 leading-relaxed">
                                Pedoman Teknis Pengelolaan Pelayanan Informasi dan Dokumentasi di Lingkungan Pemerintah Daerah Kabupaten Tasikmalaya yang mengintegrasikan seluruh perangkat daerah dan 39 kecamatan.
                            </p>
                        </div>

                        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                            <span class="px-2 py-0.5 rounded bg-slate-200/80 text-slate-700 font-semibold text-[10px] uppercase">Hak & Kewajiban</span>
                            <h4 class="font-bold text-slate-900 text-sm">Hak Pemohon Informasi</h4>
                            <p class="text-slate-600 leading-relaxed">
                                Setiap pemohon berhak melihat dan mengetahui informasi publik, menghadiri pertemuan publik yang terbuka, dan mendapatkan salinan informasi publik melalui permohonan resmi sesuai ketentuan perundang-undangan.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- TAB CONTENT 4: MEJA LAYANAN & KONTAK PPID --}}
                <div x-show="activePpidTab === 'kontak'" class="p-5 sm:p-8 space-y-6">
                    <div>
                        <h3 class="text-base sm:text-lg font-black text-slate-900">
                            Lokasi Meja Layanan Fisik & Kontak Petugas PPID
                        </h3>
                        <p class="text-xs text-slate-500 mt-1">
                            Kunjungi kantor PPID Diskominfo Kabupaten Tasikmalaya atau hubungi kanal layanan daring.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                            <div class="w-10 h-10 rounded-xl bg-slate-100 text-[#0a2558] flex items-center justify-center font-bold">
                                <i data-lucide="map-pin" class="w-5 h-5"></i>
                            </div>
                            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400">Alamat Meja Pelayanan</h4>
                            <p class="text-xs font-semibold text-slate-800 leading-relaxed">
                                Kantor Dinas Komunikasi dan Informatika (Diskominfo) Kab. Tasikmalaya<br>
                                Jl. Raya Cintaraja, Kec. Singaparna, Kabupaten Tasikmalaya, Jawa Barat 46182
                            </p>
                        </div>

                        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                            <div class="w-10 h-10 rounded-xl bg-slate-100 text-[#0a2558] flex items-center justify-center font-bold">
                                <i data-lucide="clock" class="w-5 h-5"></i>
                            </div>
                            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400">Jam Operasional Layanan</h4>
                            <div class="text-xs space-y-1">
                                <p class="text-slate-800 font-bold">Senin - Kamis: 08.00 - 15.30 WIB</p>
                                <p class="text-slate-800 font-bold">Jumat: 08.00 - 15.00 WIB</p>
                                <p class="text-slate-400 text-[11px]">Sabtu, Minggu & Libur Nasional: Tutup</p>
                            </div>
                        </div>

                        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                            <div class="w-10 h-10 rounded-xl bg-slate-100 text-[#0a2558] flex items-center justify-center font-bold">
                                <i data-lucide="message-square" class="w-5 h-5"></i>
                            </div>
                            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400">Kontak Resmi PPID</h4>
                            <div class="text-xs space-y-1">
                                <p class="text-slate-800">Email: <a href="mailto:ppid@tasikmalayakab.go.id" class="text-blue-600 font-semibold hover:underline">ppid@tasikmalayakab.go.id</a></p>
                                <p class="text-slate-800">Telepon / Fax: <span class="font-semibold">(0265) 545123</span></p>
                                <p class="text-slate-800">WhatsApp Desk: <span class="font-semibold text-emerald-700">0811-2345-6789</span></p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>
