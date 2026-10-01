    <header class="fixed top-0 inset-x-0 z-50 bg-white/98 backdrop-blur-md border-b border-slate-200/80 shadow-2xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-14 sm:h-[58px] flex items-center justify-between">
            
            {{-- Left Side: Brand Logo + Slogan/Co-brand + "Katalog Layanan" Button --}}
            <div class="flex items-center gap-2.5 sm:gap-3">
                {{-- Logo Diskominfo Kab. Tasikmalaya --}}
                <a href="{{ url('/') }}" class="flex items-center gap-2 flex-shrink-0">
                    <img src="{{ asset('images/logo2.png') }}" alt="Diskominfo Kabupaten Tasikmalaya" class="h-7 sm:h-8 w-auto object-contain">
                </a>

                {{-- Co-brand / Partner separator similar to reference --}}
                <div class="hidden xl:flex items-center gap-1.5 pl-2.5 border-l border-slate-200 text-[10px] leading-tight text-slate-500">
                    <span class="text-slate-400 font-medium">oleh:</span>
                    <span class="font-bold text-slate-700">Diskominfo Kab. Tasikmalaya</span>
                </div>

                {{-- Compact Prominent Button: [ â‰¡ Katalog Layanan ] (like [ â‰¡ Kursus Kami ] in reference) --}}
                <div class="relative ml-1"
                     @mouseenter="dropdownLayanan = true; dropdownPpid = false; $nextTick(() => window.lucide?.createIcons())"
                     @mouseleave="dropdownLayanan = false">
                    
                    <button type="button"
                            @click="dropdownLayanan = !dropdownLayanan; dropdownPpid = false; $nextTick(() => window.lucide?.createIcons())"
                            class="px-2.5 py-1.5 sm:px-3 sm:py-1.5 rounded-lg bg-[#ea546c] hover:bg-[#d9445c] text-white text-xs font-bold flex items-center gap-1.5 shadow-2xs hover:shadow-xs transition-all cursor-pointer focus:outline-none">
                        <svg class="w-3.5 h-3.5 stroke-[2.5]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <span>Katalog Layanan</span>
                        <svg class="w-3 h-3 transition-transform duration-200 opacity-90"
                             :class="dropdownLayanan ? 'rotate-180' : ''"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    {{-- Dropdown Container for Layanan --}}
                    <div x-show="dropdownLayanan"
                         x-cloak
                         @click.outside="dropdownLayanan = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-1.5 scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                         x-transition:leave-end="opacity-0 translate-y-1.5 scale-95"
                         class="absolute left-0 top-full mt-1.5 w-[390px] bg-white rounded-2xl p-3.5 shadow-2xl border border-slate-100 z-50">
                        
                        {{-- Top Header Pill --}}
                        <div class="flex items-center justify-between pb-2.5 px-2 border-b border-slate-100 mb-1.5">
                            <span class="text-[10px] font-black uppercase tracking-wider text-slate-400">
                                4 Kategori Layanan Kependudukan
                            </span>
                            <a href="#layanan" @click="dropdownLayanan = false" class="text-[11px] font-bold text-[#0a2558] hover:underline flex items-center gap-1">
                                <span>Lihat Semua</span>
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>

                        {{-- 4 Categories Grid/List --}}
                        <div class="space-y-1">
                            {{-- Item 1: Identitas --}}
                            <a href="{{ route('layanan.show', ['serviceCode' => 'EKTP']) }}"
                               @click="dropdownLayanan = false"
                               class="group p-2 rounded-xl hover:bg-slate-50 transition-all flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-lg bg-slate-100 text-[#0a2558] flex items-center justify-center flex-shrink-0 group-hover:bg-[#0a2558] group-hover:text-white transition-all shadow-2xs">
                                    <i data-lucide="contact" class="w-4 h-4"></i>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <h4 class="text-xs font-bold text-slate-800 group-hover:text-[#0a2558] transition-colors">
                                        Identitas Kependudukan
                                    </h4>
                                    <p class="text-[10px] text-slate-400 truncate">KTP Elektronik Biometrik & KIA Anak</p>
                                </div>
                                <span class="text-[9px] font-semibold px-1.5 py-0.5 rounded bg-slate-100 text-slate-600 border border-slate-200/60">
                                    2 Layanan
                                </span>
                            </a>

                            {{-- Item 2: Kartu Keluarga --}}
                            <a href="{{ route('layanan.show', ['serviceCode' => 'KK_BARU']) }}"
                               @click="dropdownLayanan = false"
                               class="group p-2 rounded-xl hover:bg-slate-50 transition-all flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-lg bg-slate-100 text-[#0a2558] flex items-center justify-center flex-shrink-0 group-hover:bg-[#0a2558] group-hover:text-white transition-all shadow-2xs">
                                    <i data-lucide="users" class="w-4 h-4"></i>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <h4 class="text-xs font-bold text-slate-800 group-hover:text-[#0a2558] transition-colors">
                                        Kartu Keluarga (KK)
                                    </h4>
                                    <p class="text-[10px] text-slate-400 truncate">KK Baru, Penambahan & Pengurangan Anggota</p>
                                </div>
                                <span class="text-[9px] font-semibold px-1.5 py-0.5 rounded bg-slate-100 text-slate-600 border border-slate-200/60">
                                    3 Layanan
                                </span>
                            </a>

                            {{-- Item 3: Perpindahan Penduduk --}}
                            <a href="{{ route('layanan.show', ['serviceCode' => 'PINDAH_SATU_DESA']) }}"
                               @click="dropdownLayanan = false"
                               class="group p-2 rounded-xl hover:bg-slate-50 transition-all flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-lg bg-slate-100 text-[#0a2558] flex items-center justify-center flex-shrink-0 group-hover:bg-[#0a2558] group-hover:text-white transition-all shadow-2xs">
                                    <i data-lucide="truck" class="w-4 h-4"></i>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <h4 class="text-xs font-bold text-slate-800 group-hover:text-[#0a2558] transition-colors">
                                        Perpindahan Domisili
                                    </h4>
                                    <p class="text-[10px] text-slate-400 truncate">Pindah Satu Desa s.d. Antar Kecamatan (F.1-23/29)</p>
                                </div>
                                <span class="text-[9px] font-semibold px-1.5 py-0.5 rounded bg-slate-100 text-slate-600 border border-slate-200/60">
                                    3 Layanan
                                </span>
                            </a>

                            {{-- Item 4: Dispensasi & Keterangan --}}
                            <a href="{{ route('layanan.show', ['serviceCode' => 'NIKAH']) }}"
                               @click="dropdownLayanan = false"
                               class="group p-2 rounded-xl hover:bg-slate-50 transition-all flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-lg bg-slate-100 text-[#0a2558] flex items-center justify-center flex-shrink-0 group-hover:bg-[#0a2558] group-hover:text-white transition-all shadow-2xs">
                                    <i data-lucide="heart" class="w-4 h-4"></i>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <h4 class="text-xs font-bold text-slate-800 group-hover:text-[#0a2558] transition-colors">
                                        Dispensasi & Keterangan
                                    </h4>
                                    <p class="text-[10px] text-slate-400 truncate">Rekomendasi Nikah & Surat Keterangan Camat</p>
                                </div>
                                <span class="text-[9px] font-semibold px-1.5 py-0.5 rounded bg-slate-100 text-slate-600 border border-slate-200/60">
                                    2 Layanan
                                </span>
                            </a>
                        </div>

                        {{-- Bottom CTA Box --}}
                        <div class="mt-2 pt-2 border-t border-slate-100 bg-slate-50/80 -mx-3.5 -mb-3.5 p-3 rounded-b-2xl flex items-center justify-between text-xs">
                            <span class="text-[10px] text-slate-500 font-medium">Bebas antrean & bebas biaya (Rp 0)</span>
                            <a href="#layanan" @click="dropdownLayanan = false" class="text-[11px] font-bold text-[#0a2558] hover:underline flex items-center gap-1">
                                <span>Katalog Lengkap</span>
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Side: Navigation Links + Flag Indicator + Login Button --}}
            <div class="flex items-center gap-3 sm:gap-5">
                {{-- Desktop Menu Links --}}
                <nav class="hidden lg:flex items-center space-x-5 text-xs font-semibold text-slate-600">
                    {{-- 1. BERANDA (Rumah) --}}
                    <a href="#" class="text-[#2563eb] hover:text-[#1d4ed8] transition-colors py-1">
                        Beranda
                    </a>

                    {{-- 2. DATA KECAMATAN --}}
                    <a href="#kewilayahan" class="hover:text-[#2563eb] transition-colors py-1">
                        Data Kecamatan
                    </a>

                    {{-- 3. PPID & INFORMASI (DROPDOWN) --}}
                    <div class="relative"
                         @mouseenter="dropdownPpid = true; dropdownLayanan = false; $nextTick(() => window.lucide?.createIcons())"
                         @mouseleave="dropdownPpid = false">
                        
                        <button type="button"
                                @click="dropdownPpid = !dropdownPpid; dropdownLayanan = false; $nextTick(() => window.lucide?.createIcons())"
                                class="hover:text-[#2563eb] transition-colors flex items-center gap-1 focus:outline-none py-1 cursor-pointer"
                                :class="dropdownPpid ? 'text-[#2563eb]' : ''">
                            <span>PPID & Informasi</span>
                            <svg class="w-3 h-3 transition-transform duration-200"
                                 :class="dropdownPpid ? 'rotate-180 text-[#2563eb]' : 'text-slate-400'"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        {{-- Dropdown Container for PPID --}}
                        <div x-show="dropdownPpid"
                             x-cloak
                             @click.outside="dropdownPpid = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-1.5 scale-95"
                             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                             x-transition:leave-end="opacity-0 translate-y-1.5 scale-95"
                             class="absolute right-0 top-full mt-1.5 w-[370px] bg-white rounded-2xl p-3.5 shadow-2xl border border-slate-100 z-50">
                            
                            {{-- Top Header Pill --}}
                            <div class="flex items-center justify-between pb-2.5 px-2 border-b border-slate-100 mb-1.5">
                                <span class="text-[10px] font-black uppercase tracking-wider text-slate-400">
                                    Keterbukaan Informasi Publik (UU 14/2008)
                                </span>
                                <a href="#ppid" @click="dropdownPpid = false" class="text-[11px] font-bold text-[#0a2558] hover:underline flex items-center gap-1">
                                    <span>Portal PPID</span>
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>

                            {{-- 4 PPID Actions List --}}
                            <div class="space-y-1">
                                {{-- Item 1: Direktori Dokumen --}}
                                <a href="#ppid-daftar"
                                   @click="dropdownPpid = false; activePpidTab = 'dokumen'; $nextTick(() => window.lucide?.createIcons())"
                                   class="group p-2 rounded-xl hover:bg-slate-50 transition-all flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-lg bg-slate-100 text-[#0a2558] flex items-center justify-center flex-shrink-0 group-hover:bg-[#0a2558] group-hover:text-white transition-all shadow-2xs">
                                        <i data-lucide="files" class="w-4 h-4"></i>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <h4 class="text-xs font-bold text-slate-800 group-hover:text-[#0a2558] transition-colors">
                                            Daftar Informasi Publik (DIP)
                                        </h4>
                                        <p class="text-[10px] text-slate-400 truncate">17 Dokumen Resmi (Berkala, Serta Merta, dll.)</p>
                                    </div>
                                    <span class="text-[9px] font-semibold px-1.5 py-0.5 rounded bg-slate-100 text-slate-600 border border-slate-200/60">
                                        17 Berkas
                                    </span>
                                </a>

                                {{-- Item 2: Ajukan Permohonan Informasi --}}
                                <button type="button"
                                        @click="openPpidModal(); dropdownPpid = false"
                                        class="w-full text-left group p-2 rounded-xl hover:bg-slate-50 transition-all flex items-center gap-2.5 cursor-pointer">
                                    <div class="w-8 h-8 rounded-lg bg-slate-100 text-[#0a2558] flex items-center justify-center flex-shrink-0 group-hover:bg-[#0a2558] group-hover:text-white transition-all shadow-2xs">
                                        <i data-lucide="send" class="w-4 h-4"></i>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <h4 class="text-xs font-bold text-slate-800 group-hover:text-[#0a2558] transition-colors">
                                            Ajukan Permohonan Informasi
                                        </h4>
                                        <p class="text-[10px] text-slate-400 truncate">Formulir Online Pemohon Warga & Lembaga</p>
                                    </div>
                                    <span class="text-[9px] font-semibold px-1.5 py-0.5 rounded bg-slate-100 text-slate-600 border border-slate-200/60">
                                        Online
                                    </span>
                                </button>

                                {{-- Item 3: Lacak Status Permohonan --}}
                                <button type="button"
                                        @click="openPpidTracking(); dropdownPpid = false"
                                        class="w-full text-left group p-2 rounded-xl hover:bg-slate-50 transition-all flex items-center gap-2.5 cursor-pointer">
                                    <div class="w-8 h-8 rounded-lg bg-slate-100 text-[#0a2558] flex items-center justify-center flex-shrink-0 group-hover:bg-[#0a2558] group-hover:text-white transition-all shadow-2xs">
                                        <i data-lucide="search" class="w-4 h-4"></i>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <h4 class="text-xs font-bold text-slate-800 group-hover:text-[#0a2558] transition-colors">
                                            Lacak Status Permohonan
                                        </h4>
                                        <p class="text-[10px] text-slate-400 truncate">Cek progres tiket nomor registrasi PPID</p>
                                    </div>
                                    <span class="text-[9px] font-semibold px-1.5 py-0.5 rounded bg-slate-100 text-slate-600 border border-slate-200/60">
                                        Tracking
                                    </span>
                                </button>

                                {{-- Item 4: SOP & Prosedur --}}
                                <a href="#ppid"
                                   @click="dropdownPpid = false; activePpidTab = 'alur'; $nextTick(() => window.lucide?.createIcons())"
                                   class="group p-2 rounded-xl hover:bg-slate-50 transition-all flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-lg bg-slate-100 text-[#0a2558] flex items-center justify-center flex-shrink-0 group-hover:bg-[#0a2558] group-hover:text-white transition-all shadow-2xs">
                                        <i data-lucide="workflow" class="w-4 h-4"></i>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <h4 class="text-xs font-bold text-slate-800 group-hover:text-[#0a2558] transition-colors">
                                            Alur & Standar Prosedur (SOP)
                                        </h4>
                                        <p class="text-[10px] text-slate-400 truncate">SOP Waktu Layanan & Tata Cara Keberatan</p>
                                    </div>
                                    <span class="text-[9px] font-semibold px-1.5 py-0.5 rounded bg-slate-100 text-slate-600 border border-slate-200/60">
                                        SOP
                                    </span>
                                </a>
                            </div>

                            {{-- Bottom CTA Box --}}
                            <div class="mt-2 pt-2 border-t border-slate-100 bg-slate-50/80 -mx-3.5 -mb-3.5 p-3 rounded-b-2xl flex items-center justify-between text-xs">
                                <span class="text-[10px] text-slate-500 font-medium">Layanan resmi bebas biaya (Rp 0)</span>
                                <a href="#ppid" @click="dropdownPpid = false" class="text-[11px] font-bold text-[#0a2558] hover:underline flex items-center gap-1">
                                    <span>Meja PPID Utama</span>
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- 4. PROFIL & CAPAIAN --}}
                    <a href="#capaian" class="hover:text-[#2563eb] transition-colors py-1">
                        Profil & Capaian
                    </a>

                    {{-- 5. PENGADUAN (Membantu / Bantuan) --}}
                    <button type="button"
                            @click="openPengaduan()"
                            class="hover:text-[#2563eb] transition-colors font-semibold py-1 flex items-center gap-1 focus:outline-none cursor-pointer">
                        <span>Pengaduan</span>
                    </button>
                </nav>

                {{-- Flag Indicator (RI / ID) as in reference screenshot --}}
                <div class="hidden sm:flex items-center gap-1 px-1.5 py-1 rounded bg-slate-50 border border-slate-200/80 select-none shadow-2xs" title="Indonesia">
                    <span class="w-3.5 h-2 rounded-[2px] overflow-hidden flex flex-col border border-slate-300/60 shadow-2xs">
                        <span class="w-full h-1/2 bg-[#d8222a]"></span>
                        <span class="w-full h-1/2 bg-white"></span>
                    </span>
                    <span class="text-[10px] font-bold text-slate-700">ID</span>
                </div>

                {{-- Exact AICLASSASEAN Style Login Button: [.btn-join] --}}
                @auth
                    <a href="{{ route('dashboard') }}" class="nav-link btn-join">
                        Dashboard <span><i class="fa-solid fa-chevron-right"></i></span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="nav-link btn-join">
                        Login <span><i class="fa-solid fa-chevron-right"></i></span>
                    </a>
                @endauth

                {{-- Mobile toggle button --}}
                <button type="button" @click="mobileNav = !mobileNav" class="lg:hidden p-1.5 rounded-lg hover:bg-slate-100 text-slate-700 transition-colors">
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>
            </div>
        </div>

        {{-- Mobile Full-Width Dropdown Drawer --}}
        <div x-show="mobileNav"
             x-cloak
             @click.outside="mobileNav = false"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="lg:hidden bg-white border-b border-slate-200 px-4 py-3 shadow-xl text-xs sm:text-sm space-y-2 font-semibold text-slate-800 max-h-[calc(100vh-4rem)] overflow-y-auto">
            
            {{-- Mobile Layanan Accordion --}}
            <div>
                <button type="button"
                        @click="mobileLayanan = !mobileLayanan"
                        class="w-full py-2 px-3 rounded-lg bg-slate-50 hover:bg-slate-100 text-slate-800 flex items-center justify-between text-xs">
                    <span class="flex items-center gap-1.5 text-[#ea546c] font-bold">
                        <svg class="w-3.5 h-3.5 stroke-[2.5]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <span>Katalog Layanan</span>
                    </span>
                    <svg class="w-3.5 h-3.5 transition-transform duration-200 text-slate-400"
                         :class="mobileLayanan ? 'rotate-180 text-[#ea546c]' : ''"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="mobileLayanan" x-collapse class="pl-3 pr-2 py-1.5 space-y-1 text-xs text-slate-600">
                    <a href="{{ route('layanan.show', ['serviceCode' => 'EKTP']) }}" @click="mobileNav = false" class="block py-1.5 px-2.5 rounded-lg hover:bg-slate-100 text-slate-700 hover:text-[#0a2558]">ðŸªª Identitas (e-KTP & KIA)</a>
                    <a href="{{ route('layanan.show', ['serviceCode' => 'KK_BARU']) }}" @click="mobileNav = false" class="block py-1.5 px-2.5 rounded-lg hover:bg-slate-100 text-slate-700 hover:text-[#0a2558]">ðŸ‘¨â€ðŸ‘©â€ðŸ‘§â€ðŸ‘¦ Kartu Keluarga (KK)</a>
                    <a href="{{ route('layanan.show', ['serviceCode' => 'PINDAH_SATU_DESA']) }}" @click="mobileNav = false" class="block py-1.5 px-2.5 rounded-lg hover:bg-slate-100 text-slate-700 hover:text-[#0a2558]">ðŸšš Perpindahan Domisili</a>
                    <a href="{{ route('layanan.show', ['serviceCode' => 'NIKAH']) }}" @click="mobileNav = false" class="block py-1.5 px-2.5 rounded-lg hover:bg-slate-100 text-slate-700 hover:text-[#0a2558]">ðŸ“œ Dispensasi & Keterangan</a>
                    <a href="#layanan" @click="mobileNav = false" class="block py-1.5 px-2.5 rounded-lg text-[#ea546c] font-bold hover:underline">Lihat Semua 8 Layanan &rarr;</a>
                </div>
            </div>

            {{-- Mobile Beranda --}}
            <a href="#" @click="mobileNav = false" class="block py-1.5 px-3 rounded-lg hover:bg-slate-50 text-[#2563eb]">Beranda</a>

            {{-- Mobile Data Kecamatan --}}
            <a href="#kewilayahan" @click="mobileNav = false" class="block py-1.5 px-3 rounded-lg hover:bg-slate-50 text-slate-800">Data Kecamatan</a>

            {{-- Mobile PPID Accordion --}}
            <div>
                <button type="button"
                        @click="mobilePpid = !mobilePpid"
                        class="w-full py-1.5 px-3 rounded-lg hover:bg-slate-50 text-slate-800 flex items-center justify-between text-xs">
                    <span>PPID & Informasi</span>
                    <svg class="w-3.5 h-3.5 transition-transform duration-200 text-slate-400"
                         :class="mobilePpid ? 'rotate-180 text-[#2563eb]' : ''"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="mobilePpid" x-collapse class="pl-3 pr-2 py-1.5 space-y-1 text-xs text-slate-600">
                    <a href="#ppid-daftar" @click="mobileNav = false; activePpidTab = 'dokumen'" class="block py-1.5 px-2.5 rounded-lg hover:bg-slate-100 text-slate-700 hover:text-[#0a2558]">ðŸ“ Daftar Informasi Publik (DIP)</a>
                    <button type="button" @click="mobileNav = false; openPpidModal()" class="w-full text-left py-1.5 px-2.5 rounded-lg hover:bg-slate-100 text-slate-700 hover:text-[#0a2558] font-semibold">âœï¸ Ajukan Permohonan Informasi</button>
                    <button type="button" @click="mobileNav = false; openPpidTracking()" class="w-full text-left py-1.5 px-2.5 rounded-lg hover:bg-slate-100 text-slate-700 hover:text-[#0a2558] font-semibold">ðŸ” Lacak Status Permohonan</button>
                    <a href="#ppid" @click="mobileNav = false; activePpidTab = 'alur'" class="block py-1.5 px-2.5 rounded-lg hover:bg-slate-100 text-slate-700 hover:text-[#0a2558]">ðŸ“‹ Alur & Prosedur (SOP)</a>
                </div>
            </div>

            {{-- Mobile Profil & Capaian --}}
            <a href="#capaian" @click="mobileNav = false" class="block py-1.5 px-3 rounded-lg hover:bg-slate-50 text-slate-800">Profil & Capaian</a>

            {{-- Mobile Pengaduan --}}
            <button type="button" @click="mobileNav = false; openPengaduan()" class="w-full text-left py-1.5 px-3 rounded-lg hover:bg-slate-50 text-slate-800 font-semibold flex items-center justify-between text-xs">
                <span>Layanan Pengaduan</span>
            </button>

            <div class="pt-2 border-t border-slate-100 flex justify-center">
                <a href="{{ route('login') }}" class="nav-link btn-join w-full justify-center text-center">
                    Login<span><i class="fa-solid fa-chevron-right"></i></span>
                </a>
            </div>
        </div>
    </header>
