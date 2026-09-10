<!DOCTYPE html>
<html lang="id" class="h-full scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Portal Resmi Dinas Komunikasi dan Informatika (Diskominfo) Kabupaten Tasikmalaya - Pelayanan Administrasi Publik Terpadu 39 Kecamatan">
    <title>Diskominfo Kabupaten Tasikmalaya — Portal Layanan Publik Terpadu</title>

    {{-- Google Fonts: Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>

    <style>
        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        body { letter-spacing: -0.01em; }
        h1, h2, h3 { letter-spacing: -0.02em; }
        [data-lucide] { display: inline-block; vertical-align: middle; }

        .bg-yellow-ppid {
            background: linear-gradient(135deg, #fcd34d 0%, #facc15 60%, #eab308 100%);
        }

        .floating-pill-nav {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.12), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-[#f8fafc] text-slate-800 antialiased selection:bg-[#0a2558] selection:text-white"
      x-data="{
          mobileNav: false,
          currentSlide: 0,
          timer: null,
          slides: [
              {
                  badge: 'Dinas Komunikasi dan Informatika Kabupaten Tasikmalaya',
                  title: 'Transformasi Digital Layanan Publik Terpadu',
                  desc: 'Pelayanan Administrasi Kependudukan, Perizinan, dan Keterbukaan Informasi Terintegrasi untuk Seluruh 39 Kecamatan se-Kabupaten Tasikmalaya.',
                  image: 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=1920&q=80',
                  ctaText: 'Jelajahi 8 Layanan Utama',
                  ctaLink: '#layanan',
                  btnSec: 'Masuk Akun Warga',
                  btnSecLink: '{{ route('login') }}'
              },
              {
                  badge: 'Pelayanan Terpadu Satu Pintu',
                  title: 'Pengurusan Izin & Berkas Cepat Tanpa Antre',
                  desc: 'Ajukan Kartu Identitas Anak (KIA), e-KTP Biometrik, Surat Pindah, dan dokumen kependudukan secara digital langsung dari genggaman Anda.',
                  image: 'https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=1920&q=80',
                  ctaText: 'Mulai Buat Permohonan',
                  ctaLink: '{{ route('login') }}',
                  btnSec: 'Lihat Syarat Berkas',
                  btnSecLink: '#layanan'
              },
              {
                  badge: 'Keterbukaan Informasi Publik (PPID)',
                  title: 'Transparan, Akuntabel, dan Mudah Diakses',
                  desc: 'Akses informasi publik resmi sesuai UU No. 14 Tahun 2008 dan sampaikan aspirasi masyarakat langsung melalui portal resmi Diskominfo.',
                  image: 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1920&q=80',
                  ctaText: 'Layanan PPID Kabupaten',
                  ctaLink: '#ppid',
                  btnSec: 'Layanan Pengaduan',
                  btnSecLink: '#pengaduan'
              },
              {
                  badge: 'Pemerintah Kabupaten Tasikmalaya',
                  title: 'Kolaborasi Menuju Pelayanan Prima 39 Kecamatan',
                  desc: 'Menghubungkan seluruh 39 Kecamatan dan 351 Desa dalam ekosistem digital yang terintegrasi, transparan, dan terenkripsi aman.',
                  image: 'https://images.unsplash.com/photo-1577495508048-b635879837f1?auto=format&fit=crop&w=1920&q=80',
                  ctaText: 'Masuk ke Portal',
                  ctaLink: '{{ route('login') }}',
                  btnSec: 'Daftar Akun Baru',
                  btnSecLink: '{{ route('register') }}'
              }
          ],
          nextSlide() {
              this.currentSlide = (this.currentSlide + 1) % this.slides.length;
          },
          prevSlide() {
              this.currentSlide = (this.currentSlide - 1 + this.slides.length) % this.slides.length;
          },
          goToSlide(index) {
              this.currentSlide = index;
          },
          startAutoPlay() {
              this.timer = setInterval(() => {
                  this.nextSlide();
              }, 5000);
          },
          stopAutoPlay() {
              clearInterval(this.timer);
          }
      }"
      x-init="startAutoPlay()">

    {{-- ═══════════════════════════════════════════════════════════════════════════
         1. FLOATING PILL NAVBAR
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="fixed top-4 inset-x-0 z-50 px-4 sm:px-6 max-w-6xl mx-auto">
        <nav class="floating-pill-nav rounded-full px-5 sm:px-7 py-3 flex items-center justify-between border border-slate-100/90">
            
            {{-- Logo Diskominfo Kab. Tasikmalaya --}}
            <a href="{{ url('/') }}" class="flex items-center gap-2.5">
                <img src="{{ asset('images/logo2.png') }}" alt="Diskominfo Kabupaten Tasikmalaya" class="h-9 sm:h-10 w-auto object-contain">
            </a>

            {{-- Desktop Menu Links --}}
            <div class="hidden lg:flex items-center space-x-7 text-xs sm:text-sm font-semibold text-slate-700">
                <a href="#layanan" class="hover:text-[#0a2558] transition-colors">Layanan Publik</a>
                <a href="#kewilayahan" class="hover:text-[#0a2558] transition-colors">Data Kecamatan</a>
                <a href="#ppid" class="hover:text-[#0a2558] transition-colors">PPID & Informasi</a>
                <a href="#capaian" class="hover:text-[#0a2558] transition-colors">Profil & Capaian</a>
                <a href="#pengaduan" class="hover:text-[#0a2558] transition-colors">Pengaduan</a>
            </div>

            {{-- Right CTA Button --}}
            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="px-5 py-2.5 rounded-full text-xs sm:text-sm font-bold text-white bg-[#0a2558] hover:bg-[#0d3070] transition-all shadow-md hover:shadow-lg flex items-center gap-2">
                        <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                        <span>Dashboard Saya</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-5 py-2.5 rounded-full text-xs sm:text-sm font-bold text-white bg-[#0a2558] hover:bg-[#0d3070] transition-all shadow-md hover:shadow-lg flex items-center gap-2">
                        <i data-lucide="log-in" class="w-4 h-4"></i>
                        <span>Masuk Portal</span>
                    </a>
                @endauth

                {{-- Mobile toggle --}}
                <button type="button" @click="mobileNav = !mobileNav" class="lg:hidden p-2 rounded-full hover:bg-slate-100 text-slate-700 transition-colors">
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>
            </div>

        </nav>

        {{-- Mobile dropdown menu --}}
        <div x-show="mobileNav"
             x-cloak
             @click.outside="mobileNav = false"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="lg:hidden mt-2 bg-white rounded-3xl p-5 shadow-2xl border border-slate-100 text-sm space-y-3 font-semibold">
            <a href="#layanan" @click="mobileNav = false" class="block py-2.5 px-4 rounded-xl hover:bg-slate-50 text-slate-800">Layanan Publik</a>
            <a href="#kewilayahan" @click="mobileNav = false" class="block py-2.5 px-4 rounded-xl hover:bg-slate-50 text-slate-800">Data Kecamatan</a>
            <a href="#ppid" @click="mobileNav = false" class="block py-2.5 px-4 rounded-xl hover:bg-slate-50 text-slate-800">PPID & Informasi</a>
            <a href="#capaian" @click="mobileNav = false" class="block py-2.5 px-4 rounded-xl hover:bg-slate-50 text-slate-800">Profil & Capaian</a>
            <a href="#pengaduan" @click="mobileNav = false" class="block py-2.5 px-4 rounded-xl hover:bg-slate-50 text-slate-800">Layanan Pengaduan</a>
            <div class="pt-2 border-t border-slate-100">
                <a href="{{ route('login') }}" class="block py-3 px-4 rounded-xl bg-[#0a2558] text-white font-bold text-center shadow-md">Masuk ke Akun Portal</a>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         2. HERO SECTION WITH INTERACTIVE SLIDER / CAROUSEL
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <section class="relative text-white pt-36 sm:pt-44 pb-40 px-4 sm:px-6 lg:px-8 overflow-hidden min-h-[640px] sm:min-h-[700px] flex items-center justify-center"
             @mouseenter="stopAutoPlay()"
             @mouseleave="startAutoPlay()">

        {{-- Background Slider Images with Gradient Overlays --}}
        <template x-for="(slide, index) in slides" :key="index">
            <div x-show="currentSlide === index"
                 x-transition:enter="transition ease-out duration-700"
                 x-transition:enter-start="opacity-0 scale-105"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-500"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="absolute inset-0 bg-cover bg-center transition-all"
                 :style="`background-image: linear-gradient(180deg, rgba(10, 37, 88, 0.88) 0%, rgba(15, 23, 42, 0.94) 100%), url('${slide.image}')`">
            </div>
        </template>

        {{-- Ambient Light Deco --}}
        <div class="absolute top-1/4 left-1/2 -translate-x-1/2 w-96 h-96 bg-blue-500/15 rounded-full blur-3xl pointer-events-none"></div>


        {{-- Slide Content --}}
        <div class="max-w-4xl mx-auto text-center space-y-5 relative z-10 py-6">
            <template x-for="(slide, index) in slides" :key="index">
                <div x-show="currentSlide === index"
                     x-transition:enter="transition ease-out duration-500 delay-100"
                     x-transition:enter-start="opacity-0 translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-4"
                     class="space-y-5">
                    
                    {{-- Badge --}}
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-500/20 text-blue-200 text-xs sm:text-sm font-semibold border border-blue-400/30 backdrop-blur-md">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span x-text="slide.badge"></span>
                    </div>

                    {{-- Title --}}
                    <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight leading-tight text-white drop-shadow-md max-w-3xl mx-auto"
                        x-text="slide.title">
                    </h1>
                    
                    {{-- Description --}}
                    <p class="text-sm sm:text-lg text-blue-100 font-normal tracking-wide max-w-2xl mx-auto leading-relaxed pt-1"
                       x-text="slide.desc">
                    </p>

                    {{-- CTA Buttons --}}
                    <div class="pt-6 flex flex-wrap justify-center gap-4">
                        <a :href="slide.ctaLink"
                           class="px-7 py-3.5 rounded-full text-xs sm:text-sm font-bold bg-amber-400 hover:bg-amber-300 text-slate-950 transition-all shadow-xl hover:shadow-2xl hover:-translate-y-0.5 flex items-center gap-2">
                            <span x-text="slide.ctaText"></span>
                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </a>
                        <a :href="slide.btnSecLink"
                           class="px-7 py-3.5 rounded-full text-xs sm:text-sm font-semibold bg-white/10 hover:bg-white/20 text-white border border-white/20 backdrop-blur-md transition-all flex items-center gap-2">
                            <span x-text="slide.btnSec"></span>
                        </a>
                    </div>

                </div>
            </template>
        </div>

        {{-- ── SLIDER NAVIGATION CONTROLS ── --}}
        {{-- Prev Button --}}
        <button type="button"
                @click="prevSlide()"
                class="absolute left-3 sm:left-6 top-1/2 -translate-y-1/2 z-20 w-11 h-11 sm:w-12 sm:h-12 rounded-full bg-white/10 hover:bg-white/25 text-white border border-white/20 backdrop-blur-md flex items-center justify-center transition-all hover:scale-110 shadow-lg"
                title="Slide Sebelumnya"
                aria-label="Slide Sebelumnya">
            <i data-lucide="chevron-left" class="w-6 h-6"></i>
        </button>

        {{-- Next Button --}}
        <button type="button"
                @click="nextSlide()"
                class="absolute right-3 sm:right-6 top-1/2 -translate-y-1/2 z-20 w-11 h-11 sm:w-12 sm:h-12 rounded-full bg-white/10 hover:bg-white/25 text-white border border-white/20 backdrop-blur-md flex items-center justify-center transition-all hover:scale-110 shadow-lg"
                title="Slide Selanjutnya"
                aria-label="Slide Selanjutnya">
            <i data-lucide="chevron-right" class="w-6 h-6"></i>
        </button>

        {{-- Dot Indicators --}}
        <div class="absolute bottom-24 inset-x-0 z-20 flex items-center justify-center gap-2.5">
            <template x-for="(slide, index) in slides" :key="index">
                <button type="button"
                        @click="goToSlide(index)"
                        class="h-2.5 rounded-full transition-all duration-300 cursor-pointer"
                        :class="currentSlide === index ? 'w-8 bg-amber-400 shadow-md' : 'w-2.5 bg-white/40 hover:bg-white/70'"
                        :title="`Buka Slide ${index + 1}`"
                        :aria-label="`Slide ${index + 1}`">
                </button>
            </template>
        </div>

    </section>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         3. HERO 3 FLOATING FEATURE CARDS
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div id="capaian" class="-mt-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-30">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-stretch">

            {{-- Card 1: Profil & Capaian Diskominfo (Left Card) --}}
            <div class="md:col-span-3 bg-white rounded-3xl p-6 shadow-xl border border-slate-100 flex flex-col justify-between">
                <div>
                    <span class="text-[10px] font-bold text-blue-700 uppercase tracking-widest block mb-1">Standar Layanan</span>
                    <h3 class="text-base font-extrabold text-slate-900 leading-snug">
                        Diskominfo Kab. Tasikmalaya
                    </h3>
                    <p class="text-xs text-slate-500 mt-1">Komitmen Pelayanan Prima, Keamanan Informasi & SPBE Kabupaten.</p>

                    <div class="grid grid-cols-2 gap-3 pt-4">
                        <div class="p-3 bg-slate-50 rounded-2xl text-center border border-slate-100">
                            <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center mx-auto mb-1">
                                <i data-lucide="building-2" class="w-4 h-4"></i>
                            </div>
                            <span class="text-[11px] font-bold text-slate-800 block">39 Kecamatan</span>
                            <span class="text-[9px] text-slate-400">Terintegrasi</span>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-2xl text-center border border-slate-100">
                            <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center mx-auto mb-1">
                                <i data-lucide="shield-check" class="w-4 h-4"></i>
                            </div>
                            <span class="text-[11px] font-bold text-slate-800 block">Keamanan Data</span>
                            <span class="text-[9px] text-slate-400">Terenkripsi</span>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 text-right">
                    <a href="#layanan" class="text-xs font-bold text-[#0a2558] hover:text-blue-700 flex items-center justify-end gap-1">
                        <span>Lihat Layanan</span>
                        <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                    </a>
                </div>
            </div>

            {{-- Card 2: PROMINENT YELLOW PPID CARD (Center Card) --}}
            <div id="ppid" class="md:col-span-6 bg-yellow-ppid rounded-3xl p-6 sm:p-8 shadow-2xl flex flex-col sm:flex-row items-center justify-between gap-6 relative overflow-hidden">
                <div class="space-y-4 max-w-md relative z-10">
                    <h3 class="text-xl sm:text-2xl font-black text-slate-950 leading-tight">
                        <span class="italic font-extrabold">Yuk</span>, minta informasi melalui PPID Diskominfo Kabupaten Tasikmalaya
                    </h3>

                    <ul class="space-y-2.5 text-xs font-medium text-slate-900">
                        <li class="flex items-start gap-2">
                            <span class="w-4 h-4 rounded-full bg-white text-emerald-700 flex items-center justify-center font-bold text-[10px] flex-shrink-0 mt-0.5 shadow-xs">
                                <i data-lucide="check" class="w-3 h-3 text-emerald-700"></i>
                            </span>
                            <span>Diatur dalam <strong>Undang-Undang No. 14 Tahun 2008</strong> tentang Keterbukaan Informasi Publik.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="w-4 h-4 rounded-full bg-white text-emerald-700 flex items-center justify-center font-bold text-[10px] flex-shrink-0 mt-0.5 shadow-xs">
                                <i data-lucide="check" class="w-3 h-3 text-emerald-700"></i>
                            </span>
                            <span>PPID Diskominfo Kab. Tasikmalaya menyediakan dan melayani permohonan informasi publik secara cepat dan transparan.</span>
                        </li>
                    </ul>

                    <div class="pt-2">
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full font-bold text-xs bg-slate-950 hover:bg-slate-800 text-white shadow-md transition-colors">
                            <span>Ajukan Permohonan Informasi</span>
                            <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                        </a>
                    </div>
                </div>

                {{-- Officer Photo / Avatar Representation --}}
                <div class="flex-shrink-0 relative z-10 w-36 h-44 rounded-2xl bg-white/30 border border-white/50 flex flex-col items-center justify-center text-center p-3 shadow-sm backdrop-blur-xs">
                    <div class="w-12 h-12 rounded-2xl bg-white/40 text-slate-950 flex items-center justify-center mb-2 shadow-xs">
                        <i data-lucide="headset" class="w-7 h-7"></i>
                    </div>
                    <span class="text-[11px] font-extrabold text-slate-950">Petugas PPID</span>
                    <span class="text-[10px] text-slate-800 font-medium">Kab. Tasikmalaya</span>
                </div>
            </div>

            {{-- Card 3: SP4N-LAPOR! / Pengaduan (Right Card) --}}
            <div id="pengaduan" class="md:col-span-3 bg-white rounded-3xl p-6 shadow-xl border border-slate-100 flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-14 rounded-2xl bg-rose-50 border border-rose-200 flex items-center justify-center text-rose-600 flex-shrink-0">
                            <i data-lucide="megaphone" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-extrabold text-rose-950 leading-snug">
                                Aspirasi & Pengaduan
                            </h3>
                            <p class="text-xs text-slate-500 mt-1">Sampaikan laporan layanan publik ke Diskominfo & SP4N-LAPOR!.</p>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100">
                    <a href="#" onclick="alert('Layanan Pengaduan SP4N-LAPOR! Terintegrasi Pemerintah Kabupaten Tasikmalaya.');" class="w-full inline-flex items-center justify-center gap-1.5 py-2.5 rounded-xl font-bold text-xs text-white bg-rose-600 hover:bg-rose-700 transition-colors shadow-xs">
                        <span>Buat Pengaduan</span>
                        <i data-lucide="arrow-up-right" class="w-3.5 h-3.5"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         4. 8 MASTER LAYANAN PUBLIK TERPADU
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <section id="layanan" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20" x-data="{ activeCategory: 'all' }">
        <div class="text-center max-w-3xl mx-auto mb-12">
            <span class="px-3.5 py-1 rounded-full text-xs font-bold bg-blue-100 text-[#0a2558] border border-blue-200">
                Pemerintah Kabupaten Tasikmalaya
            </span>
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight mt-3">
                Kategori Layanan Utama Kependudukan
            </h2>
            <p class="text-xs sm:text-sm text-slate-600 mt-2 leading-relaxed">
                Penyederhanaan 8+ layanan administrasi kependudukan ke dalam <strong>4 kategori terpadu</strong> yang melayani seluruh 39 wilayah kecamatan se-Kabupaten Tasikmalaya.
            </p>

            {{-- Category Filter Tabs --}}
            <div class="flex flex-wrap items-center justify-center gap-2 mt-7">
                <button type="button"
                        @click="activeCategory = 'all'; $nextTick(() => window.lucide?.createIcons())"
                        class="px-4 py-2 rounded-full text-xs font-bold transition-all cursor-pointer shadow-2xs"
                        :class="activeCategory === 'all' ? 'bg-[#0a2558] text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50'">
                    Semua Kategori (4)
                </button>
                <button type="button"
                        @click="activeCategory = 'identitas'; $nextTick(() => window.lucide?.createIcons())"
                        class="px-4 py-2 rounded-full text-xs font-bold transition-all cursor-pointer shadow-2xs"
                        :class="activeCategory === 'identitas' ? 'bg-[#0a2558] text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50'">
                    🪪 Identitas (KTP & KIA)
                </button>
                <button type="button"
                        @click="activeCategory = 'kk'; $nextTick(() => window.lucide?.createIcons())"
                        class="px-4 py-2 rounded-full text-xs font-bold transition-all cursor-pointer shadow-2xs"
                        :class="activeCategory === 'kk' ? 'bg-[#0a2558] text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50'">
                    👨‍👩‍👧‍👦 Kartu Keluarga (KK)
                </button>
                <button type="button"
                        @click="activeCategory = 'pindah'; $nextTick(() => window.lucide?.createIcons())"
                        class="px-4 py-2 rounded-full text-xs font-bold transition-all cursor-pointer shadow-2xs"
                        :class="activeCategory === 'pindah' ? 'bg-[#0a2558] text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50'">
                    🚚 Perpindahan Penduduk
                </button>
                <button type="button"
                        @click="activeCategory = 'surat'; $nextTick(() => window.lucide?.createIcons())"
                        class="px-4 py-2 rounded-full text-xs font-bold transition-all cursor-pointer shadow-2xs"
                        :class="activeCategory === 'surat' ? 'bg-[#0a2558] text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50'">
                    📜 Dispensasi & Keterangan
                </button>
            </div>
        </div>

        @php
            $categories = [
                [
                    'id' => 'identitas',
                    'nama' => 'Identitas Kependudukan',
                    'subjudul' => 'KTP Elektronik & Kartu Identitas Anak',
                    'deskripsi' => 'Pengurusan dokumen identitas diri resmi bagi seluruh warga dewasa dan pencatatan kartu identitas anak.',
                    'badge' => '2 Layanan Utama',
                    'badge_color' => 'bg-blue-100 text-blue-800 border-blue-200',
                    'icon_bg' => 'bg-blue-600 text-white shadow-blue-500/20',
                    'header_bg' => 'from-blue-50/70 via-white to-white',
                    'accent_border' => 'hover:border-blue-500',
                    'icon' => 'contact',
                    'items' => [
                        [
                            'kode' => 'EKTP',
                            'nama' => 'Perekaman E-KTP (KTP Elektronik)',
                            'deskripsi' => 'Pendaftaran online & booking antrean rekam biometrik di kecamatan.',
                            'jenis' => 'Hybrid',
                            'badge_jenis' => 'bg-amber-50 text-amber-700 border-amber-200',
                            'berkas' => 2,
                            'icon' => 'camera',
                        ],
                        [
                            'kode' => 'KIA',
                            'nama' => 'Pembuatan Kartu Identitas Anak (KIA)',
                            'deskripsi' => 'Penerbitan kartu identitas resmi bagi anak usia 0 hingga 17 tahun kurang satu hari.',
                            'jenis' => 'Digital Penuh',
                            'badge_jenis' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                            'berkas' => 4,
                            'icon' => 'contact',
                        ],
                    ]
                ],
                [
                    'id' => 'kk',
                    'nama' => 'Layanan Kartu Keluarga (KK)',
                    'subjudul' => 'Penerbitan Baru & Pemutakhiran Data',
                    'deskripsi' => 'Pengurusan Kartu Keluarga lengkap untuk pasangan baru menikah, penambahan anggota, dan pengurangan.',
                    'badge' => '3 Sub-Layanan',
                    'badge_color' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                    'icon_bg' => 'bg-emerald-600 text-white shadow-emerald-500/20',
                    'header_bg' => 'from-emerald-50/70 via-white to-white',
                    'accent_border' => 'hover:border-emerald-500',
                    'icon' => 'users',
                    'items' => [
                        [
                            'kode' => 'KK_BARU',
                            'nama' => 'Pembuatan Kartu Keluarga (KK) Baru',
                            'deskripsi' => 'Penerbitan KK bagi pasangan baru menikah / pembentukan keluarga mandiri (F-1.01).',
                            'jenis' => 'Hybrid',
                            'badge_jenis' => 'bg-amber-50 text-amber-700 border-amber-200',
                            'berkas' => 4,
                            'icon' => 'users',
                        ],
                        [
                            'kode' => 'KK_ADD',
                            'nama' => 'Penambahan Anggota Keluarga',
                            'deskripsi' => 'Pembaruan data KK karena kelahiran anak atau kepindahan anggota masuk.',
                            'jenis' => 'Digital Penuh',
                            'badge_jenis' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                            'berkas' => 3,
                            'icon' => 'user-plus',
                        ],
                        [
                            'kode' => 'KK_DEL',
                            'nama' => 'Pengurangan Anggota Keluarga',
                            'deskripsi' => 'Pembaruan susunan KK karena anggota meninggal dunia atau perceraian resmi.',
                            'jenis' => 'Digital Penuh',
                            'badge_jenis' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                            'berkas' => 3,
                            'icon' => 'user-minus',
                        ],
                    ]
                ],
                [
                    'id' => 'pindah',
                    'nama' => 'Layanan Perpindahan Penduduk',
                    'subjudul' => 'Surat Permohonan Pindah Datang WNI',
                    'deskripsi' => 'Pelayanan perpindahan domisili terpadu satu desa, antar desa satu kecamatan, hingga antar kecamatan.',
                    'badge' => '3 Sub-Layanan',
                    'badge_color' => 'bg-amber-100 text-amber-800 border-amber-200',
                    'icon_bg' => 'bg-amber-500 text-white shadow-amber-500/20',
                    'header_bg' => 'from-amber-50/70 via-white to-white',
                    'accent_border' => 'hover:border-amber-500',
                    'icon' => 'truck',
                    'items' => [
                        [
                            'kode' => 'PINDAH_SATU_DESA',
                            'nama' => 'Pindah Datang WNI (Satu Desa)',
                            'deskripsi' => 'Perpindahan alamat domisili dalam wilayah satu desa/kelurahan yang sama (F.1-23).',
                            'jenis' => 'Digital Penuh',
                            'badge_jenis' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                            'berkas' => 3,
                            'icon' => 'home',
                        ],
                        [
                            'kode' => 'PINDAH_ANTAR_DESA',
                            'nama' => 'Pindah Datang WNI (Antar Desa Satu Kecamatan)',
                            'deskripsi' => 'Perpindahan domisili antar desa/kelurahan dalam wilayah satu kecamatan (F.1-25).',
                            'jenis' => 'Hybrid',
                            'badge_jenis' => 'bg-amber-50 text-amber-700 border-amber-200',
                            'berkas' => 3,
                            'icon' => 'building-2',
                        ],
                        [
                            'kode' => 'PINDAH_ANTAR_KEC',
                            'nama' => 'Pindah Datang WNI (Antar Kecamatan)',
                            'deskripsi' => 'Pengurusan SKPWNI antar wilayah kecamatan dalam Kabupaten Tasikmalaya (F.1-29).',
                            'jenis' => 'Hybrid',
                            'badge_jenis' => 'bg-amber-50 text-amber-700 border-amber-200',
                            'berkas' => 3,
                            'icon' => 'map',
                        ],
                    ]
                ],
                [
                    'id' => 'surat',
                    'nama' => 'Dispensasi & Surat Keterangan',
                    'subjudul' => 'Rekomendasi Pernikahan & Administrasi',
                    'deskripsi' => 'Pengajuan surat dispensasi nikah KUA dan berbagai surat keterangan kependudukan umum kecamatan.',
                    'badge' => '2 Layanan Utama',
                    'badge_color' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
                    'icon_bg' => 'bg-indigo-600 text-white shadow-indigo-500/20',
                    'header_bg' => 'from-indigo-50/70 via-white to-white',
                    'accent_border' => 'hover:border-indigo-500',
                    'icon' => 'heart',
                    'items' => [
                        [
                            'kode' => 'NIKAH',
                            'nama' => 'Surat Dispensasi / Rekomendasi Nikah',
                            'deskripsi' => 'Rekomendasi resmi bagi warga yang melangsungkan akad di luar kecamatan / mendesak.',
                            'jenis' => 'Hybrid',
                            'badge_jenis' => 'bg-amber-50 text-amber-700 border-amber-200',
                            'berkas' => 5,
                            'icon' => 'heart',
                        ],
                        [
                            'kode' => 'LAINNYA',
                            'nama' => 'Surat Keterangan Umum Kecamatan',
                            'deskripsi' => 'Penerbitan surat keterangan umum kecamatan (beda nama, belum nikah, dll.) secara online.',
                            'jenis' => 'Digital Penuh',
                            'badge_jenis' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                            'berkas' => 4,
                            'icon' => 'file-text',
                        ],
                    ]
                ],
            ];
        @endphp

        {{-- 4 CATEGORIZED CARDS GRID --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-7">
            @foreach ($categories as $cat)
                <div x-show="activeCategory === 'all' || activeCategory === '{{ $cat['id'] }}'"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     class="bg-white rounded-3xl border border-slate-200 shadow-xs {{ $cat['accent_border'] }} hover:shadow-lg transition-all flex flex-col justify-between overflow-hidden">
                    
                    {{-- Card Header --}}
                    <div class="p-6 sm:p-7 bg-gradient-to-b {{ $cat['header_bg'] }} border-b border-slate-100">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex items-center gap-3.5">
                                <div class="w-12 h-12 rounded-2xl {{ $cat['icon_bg'] }} flex items-center justify-center text-xl font-bold flex-shrink-0 shadow-md">
                                    <i data-lucide="{{ $cat['icon'] }}" class="w-6 h-6"></i>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <h3 class="text-base sm:text-lg font-black text-slate-900">
                                            {{ $cat['nama'] }}
                                        </h3>
                                    </div>
                                    <p class="text-xs font-semibold text-slate-500 mt-0.5">
                                        {{ $cat['subjudul'] }}
                                    </p>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase border shrink-0 {{ $cat['badge_color'] }}">
                                {{ $cat['badge'] }}
                            </span>
                        </div>
                        <p class="text-xs text-slate-600 mt-3 leading-relaxed">
                            {{ $cat['deskripsi'] }}
                        </p>
                    </div>

                    {{-- Sub-services List inside Category --}}
                    <div class="p-5 sm:p-6 space-y-3 flex-1 bg-white">
                        <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">
                            Daftar Layanan Tersedia:
                        </p>

                        @foreach ($cat['items'] as $item)
                            @php
                                $targetUrl = auth()->check()
                                    ? route('warga.submissions.create', ['service' => $item['kode']])
                                    : route('login');
                            @endphp
                            <a href="{{ $targetUrl }}"
                               class="group p-3.5 rounded-2xl border border-slate-100 bg-slate-50/60 hover:bg-blue-50/40 hover:border-blue-300 transition-all flex items-center justify-between gap-3 block">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="w-9 h-9 rounded-xl bg-white border border-slate-200 text-[#0a2558] flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform shadow-2xs">
                                        <i data-lucide="{{ $item['icon'] }}" class="w-4 h-4"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <h4 class="text-xs font-bold text-slate-800 group-hover:text-blue-700 transition-colors">
                                                {{ $item['nama'] }}
                                            </h4>
                                            <span class="px-1.5 py-0.5 rounded text-[9px] font-bold uppercase border {{ $item['badge_jenis'] }}">
                                                {{ $item['jenis'] }}
                                            </span>
                                        </div>
                                        <p class="text-[11px] text-slate-500 mt-0.5 line-clamp-1">
                                            {{ $item['deskripsi'] }}
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-2 pl-2 flex-shrink-0">
                                    <span class="text-[10px] font-semibold text-slate-400 hidden sm:inline">
                                        {{ $item['berkas'] }} Berkas
                                    </span>
                                    <div class="w-7 h-7 rounded-lg bg-white border border-slate-200 group-hover:bg-blue-600 group-hover:border-blue-600 group-hover:text-white text-slate-400 flex items-center justify-center transition-all shadow-2xs">
                                        <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform"></i>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    {{-- Category Footer CTA --}}
                    <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-[11px] font-medium text-slate-500">
                            Proses Cepat & Terverifikasi
                        </span>
                        @php
                            $defaultServiceCode = $cat['items'][0]['kode'];
                            $catAjukanUrl = auth()->check()
                                ? route('warga.submissions.create', ['service' => $defaultServiceCode])
                                : route('login');
                        @endphp
                        <a href="{{ $catAjukanUrl }}"
                           class="inline-flex items-center gap-1.5 text-xs font-bold text-[#0a2558] hover:text-blue-700 group transition-colors">
                            <span>Mulai Pengajuan</span>
                            <i data-lucide="chevron-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>

                </div>
            @endforeach
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         5. TABEL DATA KEWILAYAHAN KECAMATAN KABUPATEN TASIKMALAYA
         (Model Presisi Sesuai Referensi Laci RW Kewilayahan)
    ═══════════════════════════════════════════════════════════════════════════ --}}
    @php
        $kecamatanTableData = $kecamatans->map(function ($kec) {
            $actualDesas = $kec->desas ?? collect();
            $desaCount = $kec->total_desa;
            $rwCount = $kec->total_rw;
            $rtCount = $kec->total_rt;

            return [
                'id' => $kec->id,
                'kode' => $kec->kode_kecamatan ?: ('KEC-' . str_pad($kec->id, 3, '0', STR_PAD_LEFT)),
                'nama' => $kec->nama_kecamatan,
                'desa_count' => $desaCount,
                'rw_count' => $rwCount,
                'rt_count' => $rtCount,
                'alamat' => $kec->alamat_kantor ?: ('Jl. Raya ' . $kec->nama_kecamatan . ' No. 01, Kab. Tasikmalaya, Jawa Barat 46182'),
                'telepon' => $kec->telepon ?: ('(0265) 54' . str_pad($kec->id, 4, '0', STR_PAD_LEFT)),
                'email' => $kec->email ?: ('kecamatan.' . \Illuminate\Support\Str::slug($kec->nama_kecamatan) . '@tasikmalayakab.go.id'),
                'jam' => $kec->jam_operasional ?: 'Senin - Jumat (08.00 - 15.30 WIB)',
                'desas' => $actualDesas->map(fn($d) => [
                    'kode' => $d->kode_desa,
                    'nama' => $d->nama_desa,
                    'rw' => $d->jumlah_rw ?? 0,
                    'rt' => $d->jumlah_rt ?? 0,
                ])->values()->all(),
            ];
        })->values()->all();
    @endphp

    <section id="kewilayahan"
             class="pt-12 pb-20 bg-[#8cb7ee] relative overflow-hidden"
             x-data="{
                 searchQuery: '',
                 perPage: 10,
                 currentPage: 1,
                 sortCol: 'nama',
                 sortAsc: true,
                 showModal: false,
                 selectedKec: null,
                 rawData: {{ Js::from($kecamatanTableData) }},

                 sortBy(col) {
                     if (this.sortCol === col) {
                         this.sortAsc = !this.sortAsc;
                     } else {
                         this.sortCol = col;
                         this.sortAsc = true;
                     }
                     this.currentPage = 1;
                 },

                 get filteredData() {
                     let q = this.searchQuery.toLowerCase().trim();
                     let data = this.rawData.filter(item => {
                         return !q ||
                             item.nama.toLowerCase().includes(q) ||
                             item.kode.toLowerCase().includes(q) ||
                             item.desa_count.toString().includes(q) ||
                             item.rw_count.toString().includes(q) ||
                             item.rt_count.toString().includes(q);
                     });

                     data.sort((a, b) => {
                         let valA = a[this.sortCol];
                         let valB = b[this.sortCol];
                         if (typeof valA === 'string') {
                             return this.sortAsc
                                 ? valA.localeCompare(valB)
                                 : valB.localeCompare(valA);
                         }
                         return this.sortAsc ? (valA - valB) : (valB - valA);
                     });

                     return data;
                 },

                 get paginatedData() {
                     if (this.perPage >= 999) return this.filteredData;
                     let start = (this.currentPage - 1) * this.perPage;
                     return this.filteredData.slice(start, start + parseInt(this.perPage));
                 },

                 get totalPages() {
                     if (this.perPage >= 999) return 1;
                     return Math.ceil(this.filteredData.length / this.perPage) || 1;
                 },

                 openDetail(item) {
                     this.selectedKec = item;
                     this.showModal = true;
                     this.$nextTick(() => {
                         if (window.lucide) window.lucide.createIcons();
                     });
                 }
             }">

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- 1. Dark Navy Title Banner Pill (Identik dengan Screenshot) --}}
            <div class="flex justify-center mb-6">
                <div class="bg-[#0e3a6c] text-white font-bold text-lg sm:text-2xl px-8 sm:px-14 py-3 rounded-lg shadow-md border border-white/10 tracking-wide text-center">
                    Tabel Data Kecamatan Kabupaten Tasikmalaya
                </div>
            </div>

            {{-- 2. White Card Container --}}
            <div class="bg-white rounded-2xl shadow-xl border border-slate-200/80 p-5 sm:p-8">

                {{-- Controls Row: Filter (Left) & Show (Right) --}}
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4 mb-6">
                    {{-- Filter Input --}}
                    <div class="flex items-center gap-2">
                        <label for="kecamatanFilter" class="text-sm font-semibold text-slate-700">Filter:</label>
                        <div class="relative w-full sm:w-64">
                            <input id="kecamatanFilter"
                                   type="text"
                                   x-model="searchQuery"
                                   @input="currentPage = 1"
                                   placeholder="Type to filter..."
                                   class="w-full pl-3 pr-9 py-1.5 text-sm bg-white border border-slate-300 rounded focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 text-slate-800 placeholder-slate-400">
                            <div class="absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    {{-- Show Per Page Select --}}
                    <div class="flex items-center justify-end gap-2">
                        <label for="showPerPage" class="text-sm font-semibold text-slate-700">Show:</label>
                        <div class="relative">
                            <select id="showPerPage"
                                    x-model="perPage"
                                    @change="currentPage = 1"
                                    class="appearance-none bg-white border border-slate-300 rounded px-3 py-1.5 pr-8 text-sm font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 cursor-pointer">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="999">Semua</option>
                            </select>
                            <svg class="w-4 h-4 text-slate-500 absolute right-2 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Table Responsive Wrapper --}}
                <div class="overflow-x-auto rounded border border-slate-200">
                    <table class="w-full text-sm text-left border-collapse">
                        {{-- Blue Header Sesuai Screenshot --}}
                        <thead>
                            <tr class="bg-[#0088e8] text-white font-bold select-none text-xs sm:text-sm">
                                <th scope="col" @click="sortBy('nama')" class="py-3 px-4 sm:px-6 cursor-pointer hover:bg-[#007cd3] transition-colors">
                                    <div class="flex items-center gap-1.5">
                                        <span>Kecamatan</span>
                                        <span class="text-sky-200 text-xs" :class="{ 'text-white font-extrabold': sortCol === 'nama' }">↕</span>
                                    </div>
                                </th>
                                <th scope="col" @click="sortBy('desa_count')" class="py-3 px-4 sm:px-6 cursor-pointer hover:bg-[#007cd3] transition-colors">
                                    <div class="flex items-center gap-1.5">
                                        <span>Kelurahan</span>
                                        <span class="text-sky-200 text-xs" :class="{ 'text-white font-extrabold': sortCol === 'desa_count' }">↕</span>
                                    </div>
                                </th>
                                <th scope="col" @click="sortBy('rw_count')" class="py-3 px-4 sm:px-6 cursor-pointer hover:bg-[#007cd3] transition-colors">
                                    <div class="flex items-center gap-1.5">
                                        <span>RW</span>
                                        <span class="text-sky-200 text-xs" :class="{ 'text-white font-extrabold': sortCol === 'rw_count' }">↕</span>
                                    </div>
                                </th>
                                <th scope="col" @click="sortBy('rt_count')" class="py-3 px-4 sm:px-6 cursor-pointer hover:bg-[#007cd3] transition-colors">
                                    <div class="flex items-center gap-1.5">
                                        <span>RT</span>
                                        <span class="text-sky-200 text-xs" :class="{ 'text-white font-extrabold': sortCol === 'rt_count' }">↕</span>
                                    </div>
                                </th>
                                <th scope="col" class="py-3 px-4 sm:px-6 text-center">
                                    Detail
                                </th>
                            </tr>
                        </thead>

                        {{-- Body Rows --}}
                        <tbody class="divide-y divide-slate-200 bg-white">
                            <template x-for="(item, idx) in paginatedData" :key="item.id">
                                <tr class="hover:bg-sky-50/40 transition-colors text-slate-700">
                                    <td class="py-3.5 px-4 sm:px-6 font-medium text-slate-900">
                                        <span x-text="item.nama"></span>
                                    </td>
                                    <td class="py-3.5 px-4 sm:px-6 text-slate-600" x-text="item.desa_count"></td>
                                    <td class="py-3.5 px-4 sm:px-6 text-slate-600" x-text="item.rw_count"></td>
                                    <td class="py-3.5 px-4 sm:px-6 text-slate-600" x-text="item.rt_count"></td>
                                    <td class="py-3.5 px-4 sm:px-6 text-center">
                                        <button type="button"
                                                @click="openDetail(item)"
                                                class="inline-block bg-[#102a43] hover:bg-[#0a2558] text-white text-xs font-semibold px-4 py-1.5 rounded shadow-2xs transition-all active:scale-95 focus:outline-none focus:ring-2 focus:ring-blue-600/30">
                                            Detail
                                        </button>
                                    </td>
                                </tr>
                            </template>

                            {{-- Empty State --}}
                            <tr x-show="filteredData.length === 0">
                                <td colspan="5" class="py-10 text-center text-slate-400">
                                    <p class="font-medium text-sm">Tidak ada data kecamatan yang sesuai dengan filter pencarian.</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Pagination & Summary Footer --}}
                <div class="mt-5 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs sm:text-sm text-slate-600">
                    <div>
                        Menampilkan
                        <span class="font-bold text-slate-900" x-text="filteredData.length === 0 ? 0 : ((currentPage - 1) * perPage + 1)"></span>
                        sampai
                        <span class="font-bold text-slate-900" x-text="Math.min(currentPage * perPage, filteredData.length)"></span>
                        dari
                        <span class="font-bold text-slate-900" x-text="filteredData.length"></span>
                        data kecamatan
                    </div>

                    <div class="flex items-center gap-1" x-show="totalPages > 1">
                        <button type="button"
                                @click="currentPage = Math.max(1, currentPage - 1)"
                                :disabled="currentPage === 1"
                                class="px-3 py-1.5 rounded border border-slate-200 text-slate-600 hover:bg-slate-100 disabled:opacity-40 disabled:cursor-not-allowed font-medium transition-colors">
                            Sebelumnya
                        </button>

                        <template x-for="p in totalPages" :key="p">
                            <button type="button"
                                    @click="currentPage = p"
                                    x-text="p"
                                    class="px-3 py-1.5 rounded border font-medium transition-colors"
                                    :class="currentPage === p ? 'bg-[#0088e8] border-[#0088e8] text-white font-bold' : 'border-slate-200 text-slate-700 hover:bg-slate-100'">
                            </button>
                        </template>

                        <button type="button"
                                @click="currentPage = Math.min(totalPages, currentPage + 1)"
                                :disabled="currentPage === totalPages"
                                class="px-3 py-1.5 rounded border border-slate-200 text-slate-600 hover:bg-slate-100 disabled:opacity-40 disabled:cursor-not-allowed font-medium transition-colors">
                            Selanjutnya
                        </button>
                    </div>
                </div>

            </div>

        </div>

        {{-- 3. Detail Modal Window --}}
        <div x-show="showModal"
             x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 overflow-y-auto"
             role="dialog"
             aria-modal="true">

            {{-- Backdrop --}}
            <div x-show="showModal"
                 x-transition:enter="ease-out duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-150"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="showModal = false"
                 class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs">
            </div>

            {{-- Modal Content Card --}}
            <div x-show="showModal"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative bg-white rounded-3xl shadow-2xl border border-slate-100 max-w-2xl w-full overflow-hidden z-10 my-8">

                {{-- Modal Header --}}
                <div class="px-6 py-5 bg-gradient-to-r from-[#0a2558] to-[#164e87] text-white flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-white font-bold">
                            <i data-lucide="map-pin" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <span class="text-[11px] uppercase tracking-wider font-semibold text-blue-200" x-text="'Kode Wilayah: ' + (selectedKec?.kode || '-')"></span>
                            <h3 class="text-xl font-bold" x-text="'Kecamatan ' + (selectedKec?.nama || '')"></h3>
                        </div>
                    </div>
                    <button type="button" @click="showModal = false" class="text-white/70 hover:text-white p-2 rounded-xl hover:bg-white/10 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                {{-- Modal Body --}}
                <div class="p-6 space-y-5 text-sm text-slate-600">

                    {{-- 3 Quick Stats Pill --}}
                    <div class="grid grid-cols-3 gap-3">
                        <div class="bg-blue-50/80 border border-blue-100 rounded-2xl p-3.5 text-center">
                            <span class="block text-2xl font-black text-[#0a2558]" x-text="selectedKec?.desa_count"></span>
                            <span class="text-xs font-semibold text-blue-700">Desa / Kelurahan</span>
                        </div>
                        <div class="bg-amber-50/80 border border-amber-100 rounded-2xl p-3.5 text-center">
                            <span class="block text-2xl font-black text-amber-900" x-text="selectedKec?.rw_count"></span>
                            <span class="text-xs font-semibold text-amber-700">Rukun Warga (RW)</span>
                        </div>
                        <div class="bg-emerald-50/80 border border-emerald-100 rounded-2xl p-3.5 text-center">
                            <span class="block text-2xl font-black text-emerald-900" x-text="selectedKec?.rt_count"></span>
                            <span class="text-xs font-semibold text-emerald-700">Rukun Tetangga (RT)</span>
                        </div>
                    </div>

                    {{-- Info Kantor --}}
                    <div class="bg-slate-50 rounded-2xl p-4 border border-slate-200/80 space-y-2.5">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-800 flex items-center gap-1.5">
                            <i data-lucide="building-2" class="w-4 h-4 text-blue-600"></i>
                            <span>Informasi Kantor Kecamatan</span>
                        </h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                            <div>
                                <span class="text-slate-400 block">Alamat Kantor:</span>
                                <span class="text-slate-800 font-medium" x-text="selectedKec?.alamat"></span>
                            </div>
                            <div>
                                <span class="text-slate-400 block">Jam Operasional:</span>
                                <span class="text-emerald-700 font-medium" x-text="selectedKec?.jam"></span>
                            </div>
                            <div>
                                <span class="text-slate-400 block">Nomor Telepon:</span>
                                <span class="text-slate-800 font-medium" x-text="selectedKec?.telepon"></span>
                            </div>
                            <div>
                                <span class="text-slate-400 block">Email Resmi:</span>
                                <span class="text-blue-600 font-medium" x-text="selectedKec?.email"></span>
                            </div>
                        </div>
                    </div>

                    {{-- Daftar Desa/Kelurahan --}}
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-800">
                                Wilayah Kerja Desa / Kelurahan
                            </h4>
                            <span class="text-xs font-medium text-slate-500" x-text="selectedKec?.desas?.length ? (selectedKec.desas.length + ' Desa Terdata') : (selectedKec?.desa_count + ' Wilayah Desa')"></span>
                        </div>

                        <div class="max-h-48 overflow-y-auto pr-1">
                            <template x-if="selectedKec?.desas && selectedKec.desas.length > 0">
                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                                    <template x-for="desa in selectedKec.desas" :key="desa.kode">
                                        <div class="px-3 py-2 bg-white border border-slate-200 rounded-xl flex items-center gap-2 shadow-2xs">
                                            <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                                            <div class="truncate">
                                                <p class="text-xs font-semibold text-slate-800 truncate" x-text="desa.nama"></p>
                                                <p class="text-[10px] text-slate-400 truncate" x-text="desa.kode"></p>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </template>

                            <template x-if="!selectedKec?.desas || selectedKec.desas.length === 0">
                                <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-600 flex items-center gap-2.5">
                                    <i data-lucide="info" class="w-4 h-4 text-blue-500 flex-shrink-0"></i>
                                    <span>Kecamatan ini mengoordinasikan <strong class="text-slate-800" x-text="selectedKec?.desa_count"></strong> desa/kelurahan aktif yang terhubung dalam sistem pelayanan administrasi terpadu Diskominfo Kab. Tasikmalaya.</span>
                                </div>
                            </template>
                        </div>
                    </div>

                </div>

                {{-- Modal Footer --}}
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-3">
                    <button type="button"
                            @click="showModal = false"
                            class="px-4 py-2 text-xs font-bold text-slate-600 hover:text-slate-800 bg-white hover:bg-slate-100 border border-slate-200 rounded-xl transition-colors">
                        Tutup
                    </button>
                    @auth
                        <a href="{{ route('warga.submissions.index') }}"
                           class="px-5 py-2 text-xs font-bold text-white bg-[#0a2558] hover:bg-[#0d3070] rounded-xl shadow-md transition-all">
                            Ajukan Permohonan di Kecamatan Ini
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="px-5 py-2 text-xs font-bold text-white bg-[#0a2558] hover:bg-[#0d3070] rounded-xl shadow-md transition-all">
                            Masuk & Ajukan Layanan
                        </a>
                    @endauth
                </div>

            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         6. FOOTER — DISKOMINFO KABUPATEN TASIKMALAYA
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <footer class="bg-slate-950 text-slate-400 text-xs py-10 sm:py-12 border-t border-slate-800 w-full overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8 text-center sm:text-left">
                
                {{-- Col 1: Identity --}}
                <div class="md:col-span-2 space-y-3">
                    <div class="inline-flex items-center bg-white px-4 py-2 rounded-2xl shadow-sm">
                        <img src="{{ asset('images/logo.png') }}" alt="Diskominfo Kabupaten Tasikmalaya" class="h-9 w-auto object-contain">
                    </div>
                    <p class="text-xs text-slate-400 leading-relaxed max-w-md mt-2">
                        Portal Pelayanan Publik Terpadu Pemerintah Kabupaten Tasikmalaya dikelola oleh Dinas Komunikasi dan Informatika (Diskominfo) untuk memberikan kemudahan akses layanan kependudukan dan surat keterangan masyarakat di 39 kecamatan.
                    </p>
                    <p class="text-[11px] text-slate-500 flex items-center justify-center sm:justify-start gap-1.5 pt-1">
                        <i data-lucide="map-pin" class="w-3.5 h-3.5 text-slate-400"></i>
                        <span>Kantor Dishubkominfo Kab. Tasikmalaya, Cintaraja, Kec. Singaparna, Kabupaten Tasikmalaya, Jawa Barat 46182</span>
                    </p>
                </div>

                {{-- Col 2: Wilayah Layanan --}}
                <div class="space-y-2">
                    <h4 class="text-white font-bold text-xs uppercase tracking-wider mb-2">Wilayah Layanan</h4>
                    <ul class="space-y-1.5 text-xs text-slate-400">
                        <li>39 Kecamatan Aktif</li>
                        <li>351 Desa se-Kab. Tasikmalaya</li>
                        <li>Layanan Terpadu Satu Pintu</li>
                        <li>Pelayanan Ramah & Transparan</li>
                    </ul>
                </div>

                {{-- Col 3: Kontak Resmi --}}
                <div class="space-y-2">
                    <h4 class="text-white font-bold text-xs uppercase tracking-wider mb-2">Kontak Resmi</h4>
                    <p class="text-slate-400">Email: <a href="mailto:diskominfo@tasikmalayakab.go.id" class="text-blue-400 hover:underline">diskominfo@tasikmalayakab.go.id</a></p>
                    <p class="text-slate-400">Telepon: <span class="text-slate-200 font-semibold">(0265) 545123</span></p>
                    <p class="text-slate-400">Jam Layanan: <span class="text-emerald-400 font-medium">08.00 - 16.00 WIB</span></p>
                </div>

            </div>

            {{-- Copyright Bar --}}
            <div class="pt-8 border-t border-slate-800/80 flex flex-col sm:flex-row items-center justify-between gap-4 text-center sm:text-left">
                <p class="text-xs text-slate-400">
                    &copy; {{ date('Y') }} Dinas Komunikasi dan Informatika (Diskominfo) Kabupaten Tasikmalaya. Seluruh Hak Cipta Dilindungi.
                </p>
                <div class="flex items-center gap-3 text-slate-500 text-xs">
                    <span>Portal Pelayanan Publik Terpadu</span>
                    <span>&bull;</span>
                    <span>Kabupaten Tasikmalaya</span>
                </div>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });
    </script>
</body>
</html>
