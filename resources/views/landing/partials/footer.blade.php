    {{-- ═══════════════════════════════════════════════════════════════════════════
         FOOTER SECTION (Meniru Persis Tata Letak, Warna #355bdc, & Card Referensi AICLASSASEAN)
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <footer style="background-color: #355bdc;" class="text-white text-xs sm:text-sm pt-10 sm:pt-14 pb-8 sm:pb-10 w-full overflow-hidden relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- ── 1. Top White Floating Card Banner ── --}}
            <div class="bg-white rounded-xl shadow-lg px-5 py-4 sm:px-8 sm:py-5 flex flex-col lg:flex-row items-center justify-between gap-5 mb-10 sm:mb-12">
                
                {{-- Left: Logo & Co-brand --}}
                <div class="flex items-center gap-3.5 flex-shrink-0">
                    <a href="{{ url('/') }}" class="flex items-center gap-2">
                        <img src="{{ asset('images/logo2.png') }}" alt="Diskominfo Kab. Tasikmalaya" class="h-8 sm:h-9 w-auto object-contain">
                    </a>
                    <div class="h-7 w-px bg-slate-200 hidden sm:block"></div>
                    <div class="hidden sm:flex flex-col text-left">
                        <span class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider leading-tight">Pemerintah Kab. Tasikmalaya</span>
                        <span class="text-xs font-bold text-slate-800 leading-tight">Diskominfo Tasikmalaya</span>
                    </div>
                </div>

                {{-- Center: Newsletter Subscription --}}
                <div class="w-full lg:w-auto flex-1 max-w-lg lg:mx-6"
                     x-data="{ emailInput: '', subscribed: false }">
                    <form @submit.prevent="if(emailInput) { subscribed = true; setTimeout(() => { subscribed = false; emailInput = ''; }, 3500); }" 
                          class="flex items-center gap-2">
                        <div class="relative flex-1">
                            <input type="email" 
                                   x-model="emailInput" 
                                   placeholder="Enter Your Email" 
                                   required
                                   class="w-full bg-white border border-slate-300 text-slate-800 placeholder-slate-400 text-xs sm:text-sm rounded-md px-3.5 py-2.5 outline-none focus:border-[#355bdc] focus:ring-2 focus:ring-[#355bdc]/20 transition-all">
                        </div>
                        <button type="submit" 
                                class="bg-[#355bdc] hover:bg-[#2748be] text-white text-xs sm:text-sm font-bold px-4 sm:px-6 py-2.5 rounded-md whitespace-nowrap transition-all shadow-sm cursor-pointer flex-shrink-0">
                            <span x-show="!subscribed">Get Newsletter</span>
                            <span x-show="subscribed" x-cloak class="flex items-center gap-1">
                                <svg class="w-4 h-4 text-emerald-300 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                </svg>
                                Terdaftar!
                            </span>
                        </button>
                    </form>
                </div>

                {{-- Right: Social Media Icons --}}
                <div class="flex items-center gap-4 text-slate-700 flex-shrink-0">
                    <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" 
                       class="w-7 h-7 flex items-center justify-center text-slate-700 hover:text-[#355bdc] hover:scale-110 transition-all" 
                       aria-label="Facebook">
                        <i class="fa-brands fa-facebook-f text-base"></i>
                    </a>
                    <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" 
                       class="w-7 h-7 flex items-center justify-center text-slate-700 hover:text-[#355bdc] hover:scale-110 transition-all" 
                       aria-label="Instagram">
                        <i class="fa-brands fa-instagram text-lg"></i>
                    </a>
                    <a href="https://linkedin.com" target="_blank" rel="noopener noreferrer" 
                       class="w-7 h-7 flex items-center justify-center text-slate-700 hover:text-[#355bdc] hover:scale-110 transition-all" 
                       aria-label="LinkedIn">
                        <i class="fa-brands fa-linkedin-in text-base"></i>
                    </a>
                    <a href="https://youtube.com" target="_blank" rel="noopener noreferrer" 
                       class="w-7 h-7 flex items-center justify-center text-slate-700 hover:text-[#355bdc] hover:scale-110 transition-all" 
                       aria-label="YouTube">
                        <i class="fa-brands fa-youtube text-lg"></i>
                    </a>
                    <a href="https://x.com" target="_blank" rel="noopener noreferrer" 
                       class="w-7 h-7 flex items-center justify-center text-slate-700 hover:text-[#355bdc] hover:scale-110 transition-all" 
                       aria-label="X (Twitter)">
                        <i class="fa-brands fa-x-twitter text-base"></i>
                    </a>
                    <a href="https://tiktok.com" target="_blank" rel="noopener noreferrer" 
                       class="w-7 h-7 flex items-center justify-center text-slate-700 hover:text-[#355bdc] hover:scale-110 transition-all" 
                       aria-label="TikTok">
                        <i class="fa-brands fa-tiktok text-base"></i>
                    </a>
                </div>
            </div>

            {{-- ── 2. Main Footer Body: Description & Multi-column Links ── --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-8 lg:gap-12 mb-8">
                
                {{-- Col 1: Platform Summary & Contacts (lg:col-span-6) --}}
                <div class="lg:col-span-6 space-y-4">
                    <p class="text-white text-xs sm:text-sm leading-relaxed max-w-xl font-normal opacity-95">
                        Portal Pelayanan Publik Terpadu Kabupaten Tasikmalaya merupakan platform resmi Dinas Komunikasi dan Informatika yang memberikan kemudahan akses layanan administrasi kependudukan, perizinan, dan informasi publik secara transparan, akuntabel, dan terintegrasi untuk seluruh masyarakat di 39 kecamatan.
                    </p>

                    <div class="space-y-2.5 pt-3 text-xs sm:text-sm">
                        <div class="flex items-start gap-3">
                            <i class="fa-solid fa-location-dot text-white text-sm mt-0.5 flex-shrink-0 w-4 text-center"></i>
                            <span class="text-white leading-snug">Jalan Sukapura No. 1, Singaparna, Kabupaten Tasikmalaya, Jawa Barat</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-envelope text-white text-sm flex-shrink-0 w-4 text-center"></i>
                            <a href="mailto:diskominfo@tasikmalayakab.go.id" class="text-white hover:underline leading-snug">
                                diskominfo@tasikmalayakab.go.id
                            </a>
                        </div>
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-phone text-white text-sm flex-shrink-0 w-4 text-center"></i>
                            <span class="text-white leading-snug">+62 265 545123</span>
                        </div>
                    </div>
                </div>

                {{-- Col 2: Quick Links (lg:col-span-3) --}}
                <div class="lg:col-span-3 space-y-3">
                    <h4 class="text-white font-bold text-sm sm:text-base tracking-tight mb-3">Quick Links</h4>
                    <ul class="space-y-2 text-xs sm:text-sm">
                        <li>
                            <a href="{{ url('/') }}" class="text-white/90 hover:text-white hover:underline transition-all">Home</a>
                        </li>
                        <li>
                            <a href="{{ url('/#layanan') }}" class="text-white/90 hover:text-white hover:underline transition-all">Our Courses</a>
                        </li>
                        <li>
                            <a href="{{ url('/#faq') }}" class="text-white/90 hover:text-white hover:underline transition-all">Help</a>
                        </li>
                        <li>
                            <a href="{{ url('/#capaian') }}" class="text-white/90 hover:text-white hover:underline transition-all">Profile</a>
                        </li>
                        <li>
                            <a href="{{ url('/#kewilayahan') }}" class="text-white/90 hover:text-white hover:underline transition-all">About Us</a>
                        </li>
                    </ul>
                </div>

                {{-- Col 3: Beneficiaries & Supported By (lg:col-span-3) --}}
                <div class="lg:col-span-3 flex flex-col justify-between space-y-6">
                    <div>
                        <h4 class="text-white font-bold text-sm sm:text-base tracking-tight mb-3">Beneficiaries</h4>
                        <ul class="space-y-2 text-xs sm:text-sm">
                            <li>
                                <a href="{{ url('/#layanan') }}" class="text-white/90 hover:text-white hover:underline transition-all">Youth</a>
                            </li>
                            <li>
                                <a href="{{ url('/#layanan') }}" class="text-white/90 hover:text-white hover:underline transition-all">Parents</a>
                            </li>
                            <li>
                                <a href="{{ url('/#layanan') }}" class="text-white/90 hover:text-white hover:underline transition-all">Educators</a>
                            </li>
                        </ul>
                    </div>

                    {{-- With support from --}}
                    <div class="pt-2">
                        <p class="text-[11px] text-white/80 font-normal mb-1">With support from</p>
                        <div class="text-white font-bold text-lg tracking-tight leading-tight">
                            Pemerintah Kab. Tasikmalaya
                        </div>
                    </div>
                </div>

            </div>

            {{-- ── 3. Bottom Copyright Bar ── --}}
            <div class="pt-6 border-t border-white/20 text-left">
                <p class="text-xs text-white/90 font-normal">
                    &copy; Copyright {{ date('Y') }} Dinas Komunikasi dan Informatika (Diskominfo) Kabupaten Tasikmalaya. All rights reserved.
                </p>
            </div>

        </div>

        {{-- ── Floating Assistant Card (Sesuai Referensi di Pojok Kanan Bawah) ── --}}
        <div class="fixed bottom-6 right-6 z-40 bg-white rounded-2xl p-3 px-4 shadow-xl border border-slate-100 hidden sm:flex flex-col items-center text-center max-w-[210px] cursor-pointer hover:shadow-2xl hover:-translate-y-1 transition-all group"
             @click="openModalPengaduan = true"
             title="Bantuan & Layanan Pengaduan">
            {{-- Mascot Icon with Star --}}
            <div class="relative mb-1">
                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-[#355bdc] via-[#ca6673] to-[#ff9800] p-0.5 flex items-center justify-center shadow-xs">
                    <div class="w-full h-full bg-white rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-[#355bdc]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <span class="absolute -top-1 -right-1 text-amber-400 text-xs animate-pulse">✦</span>
            </div>
            
            <p class="text-[11px] font-bold text-slate-800 leading-tight">
                Hi! Butuh bantuan layanan?
            </p>
            <p class="text-[10px] text-slate-500 leading-tight mt-0.5">
                Konsultasi & Pengaduan Warga
            </p>
        </div>
    </footer>
