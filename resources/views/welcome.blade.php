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
    <section id="layanan" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="px-3.5 py-1 rounded-full text-xs font-bold bg-blue-100 text-[#0a2558] border border-blue-200">
                Pemerintah Kabupaten Tasikmalaya
            </span>
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight mt-3">
                8 Layanan Utama Masyarakat
            </h2>
            <p class="text-xs sm:text-sm text-slate-600 mt-2 leading-relaxed">
                Layanan administrasi kependudukan digital & verifikasi hybrid yang mencakup seluruh <strong>39 wilayah kecamatan</strong> se-Kabupaten Tasikmalaya.
            </p>
        </div>

        @php
            if (!isset($services) || $services->isEmpty()) {
                $services = collect([
                    (object)[
                        'kode_layanan' => 'KIA',
                        'nama_layanan' => 'Pembuatan Kartu Identitas Anak (KIA)',
                        'deskripsi' => 'Pengajuan penerbitan Kartu Identitas Anak untuk anak usia 0-17 tahun kurang satu hari yang belum menikah.',
                        'jenis_proses' => \App\Enums\ServiceProcessType::FullDigital,
                        'req_count' => 4,
                    ],
                    (object)[
                        'kode_layanan' => 'EKTP',
                        'nama_layanan' => 'Perekaman E-KTP (KTP Elektronik)',
                        'deskripsi' => 'Pendaftaran online dan booking jadwal antrean perekaman data biometrik (sidik jari, iris mata, foto) di kantor kecamatan.',
                        'jenis_proses' => \App\Enums\ServiceProcessType::Hybrid,
                        'req_count' => 2,
                    ],
                    (object)[
                        'kode_layanan' => 'KK_BARU',
                        'nama_layanan' => 'Pembuatan Kartu Keluarga (KK) Baru',
                        'deskripsi' => 'Pengajuan penerbitan Kartu Keluarga baru untuk pasangan yang baru menikah atau pembentukan keluarga baru.',
                        'jenis_proses' => \App\Enums\ServiceProcessType::Hybrid,
                        'req_count' => 4,
                    ],
                    (object)[
                        'kode_layanan' => 'KK_ADD',
                        'nama_layanan' => 'Perbaikan KK - Penambahan Anggota Keluarga',
                        'deskripsi' => 'Pengajuan penambahan anggota keluarga pada KK yang sudah ada (kelahiran anak, kepindahan masuk, dll.).',
                        'jenis_proses' => \App\Enums\ServiceProcessType::FullDigital,
                        'req_count' => 3,
                    ],
                    (object)[
                        'kode_layanan' => 'KK_DEL',
                        'nama_layanan' => 'Perbaikan KK - Pengurangan Anggota Keluarga',
                        'deskripsi' => 'Pengajuan pengurangan anggota keluarga pada Kartu Keluarga karena alasan meninggal dunia atau perceraian.',
                        'jenis_proses' => \App\Enums\ServiceProcessType::FullDigital,
                        'req_count' => 3,
                    ],
                    (object)[
                        'kode_layanan' => 'PINDAH_SATU_DESA',
                        'nama_layanan' => 'Permohonan Pindah Datang WNI (Satu Desa)',
                        'deskripsi' => 'Pengisian formulir permohonan perpindahan alamat domisili dalam wilayah desa/kelurahan yang sama.',
                        'jenis_proses' => \App\Enums\ServiceProcessType::FullDigital,
                        'req_count' => 3,
                    ],
                    (object)[
                        'kode_layanan' => 'PINDAH_ANTAR_DESA',
                        'nama_layanan' => 'Permohonan Pindah Datang WNI (Antar Desa Satu Kecamatan)',
                        'deskripsi' => 'Pengisian formulir permohonan perpindahan alamat domisili antar desa/kelurahan dalam wilayah kecamatan yang sama.',
                        'jenis_proses' => \App\Enums\ServiceProcessType::Hybrid,
                        'req_count' => 4,
                    ],
                    (object)[
                        'kode_layanan' => 'PINDAH_ANTAR_KEC',
                        'nama_layanan' => 'Permohonan Pindah Datang WNI (Antar Kecamatan Satu Kabupaten)',
                        'deskripsi' => 'Pengisian formulir permohonan perpindahan alamat domisili antar kecamatan dalam wilayah Kabupaten Tasikmalaya.',
                        'jenis_proses' => \App\Enums\ServiceProcessType::Hybrid,
                        'req_count' => 4,
                    ],
                    (object)[
                        'kode_layanan' => 'NIKAH',
                        'nama_layanan' => 'Surat Dispensasi / Rekomendasi Nikah',
                        'deskripsi' => 'Pengajuan Surat Rekomendasi/Dispensasi Pernikahan bagi warga yang akan melangsungkan akad di luar kecamatan atau waktu mendesak.',
                        'jenis_proses' => \App\Enums\ServiceProcessType::Hybrid,
                        'req_count' => 5,
                    ],
                ]);
            }
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach ($services as $srv)
                <div class="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-xs hover:shadow-xl hover:border-blue-500 transition-all group flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 text-[#0a2558] flex items-center justify-center text-xl font-bold mb-4 group-hover:scale-105 transition-transform border border-blue-100">
                            @if ($srv->kode_layanan === 'KIA') <i data-lucide="contact" class="w-6 h-6"></i>
                            @elseif ($srv->kode_layanan === 'EKTP') <i data-lucide="camera" class="w-6 h-6"></i>
                            @elseif ($srv->kode_layanan === 'KK_BARU') <i data-lucide="users" class="w-6 h-6"></i>
                            @elseif ($srv->kode_layanan === 'KK_ADD') <i data-lucide="user-plus" class="w-6 h-6"></i>
                            @elseif ($srv->kode_layanan === 'KK_DEL') <i data-lucide="user-minus" class="w-6 h-6"></i>
                            @elseif ($srv->kode_layanan === 'PINDAH_SATU_DESA') <i data-lucide="home" class="w-6 h-6"></i>
                            @elseif ($srv->kode_layanan === 'PINDAH_ANTAR_DESA') <i data-lucide="building-2" class="w-6 h-6"></i>
                            @elseif ($srv->kode_layanan === 'PINDAH_ANTAR_KEC' || $srv->kode_layanan === 'PINDAH') <i data-lucide="map" class="w-6 h-6"></i>
                            @elseif ($srv->kode_layanan === 'DATANG') <i data-lucide="truck" class="w-6 h-6"></i>
                            @elseif ($srv->kode_layanan === 'NIKAH') <i data-lucide="heart" class="w-6 h-6"></i>
                            @else <i data-lucide="file-text" class="w-6 h-6"></i>
                            @endif
                        </div>
                        <span class="inline-block px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase border {{ $srv->jenis_proses->badgeColor() }}">
                            {{ $srv->jenis_proses === \App\Enums\ServiceProcessType::FullDigital ? 'Digital Penuh' : 'Proses Hybrid' }}
                        </span>
                        <h3 class="text-base font-bold text-slate-900 group-hover:text-blue-700 transition-colors mt-2.5">
                            {{ $srv->nama_layanan }}
                        </h3>
                        <p class="text-xs text-slate-500 mt-1.5 line-clamp-2 leading-relaxed">
                            {{ $srv->deskripsi }}
                        </p>
                    </div>

                    <div class="mt-6 pt-3.5 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-xs text-slate-400 font-medium">
                            {{ method_exists($srv, 'requirements') ? $srv->requirements()->count() : ($srv->req_count ?? 0) }} Syarat Berkas
                        </span>
                        <a href="{{ route('login') }}" class="text-xs font-bold text-[#0a2558] group-hover:text-blue-700 flex items-center gap-1 group-hover:translate-x-1 transition-all">
                            <span>Ajukan</span>
                            <i data-lucide="arrow-right" class="w-3 h-3"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         5. FOOTER — DISKOMINFO KABUPATEN TASIKMALAYA
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
