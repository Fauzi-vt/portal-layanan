<!DOCTYPE html>
<html lang="id" class="h-full scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Portal Resmi Diskominfo - Digitalisasi Babarengan Ngawangun Pelayanan Publik Terpadu">
    <title>Diskominfo — Pelayanan Publik Terpadu</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>

    <style>
        * { font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }

        .hero-bg {
            background-image: linear-gradient(180deg, rgba(15, 23, 42, 0.75) 0%, rgba(15, 23, 42, 0.88) 100%), url('https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
        }

        .bg-yellow-ppid {
            background-color: #facc15;
            background: linear-gradient(135deg, #fcd34d 0%, #facc15 60%, #eab308 100%);
        }

        .floating-pill-nav {
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.15), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body class="bg-[#f8fafc] text-slate-800 antialiased selection:bg-teal-500 selection:text-white" x-data="{ mobileNav: false }">

    {{-- ═══════════════════════════════════════════════════════════════════════════
         1. FLOATING PILL NAVBAR (Exact match with diskominfo.jabarprov.go.id)
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="fixed top-4 inset-x-0 z-50 px-4 sm:px-6 max-w-5xl mx-auto">
        <nav class="floating-pill-nav rounded-full px-6 py-3 flex items-center justify-between border border-slate-100/80">
            
            {{-- Logo Dishubkominfo Kab. Tasikmalaya --}}
            <a href="{{ url('/') }}" class="flex items-center gap-2">
                <x-application-logo class="h-9 w-auto" />
            </a>

            {{-- Desktop Menu Links with Dropdown Carets (Exact match) --}}
            <div class="hidden lg:flex items-center space-x-6 text-xs font-semibold text-slate-700">
                
                <div class="relative group cursor-pointer flex items-center gap-1 hover:text-emerald-700 transition-colors">
                    <span>Profil</span>
                    <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-emerald-700" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </div>

                <div class="relative group cursor-pointer flex items-center gap-1 hover:text-emerald-700 transition-colors">
                    <span>Informasi</span>
                    <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-emerald-700" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </div>

                <div class="relative group cursor-pointer flex items-center gap-1 hover:text-emerald-700 transition-colors">
                    <span>Dokumen & Publikasi</span>
                    <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-emerald-700" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </div>

                <div class="relative group cursor-pointer flex items-center gap-1 hover:text-emerald-700 transition-colors">
                    <span>PPID</span>
                    <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-emerald-700" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </div>

                <div class="relative group cursor-pointer flex items-center gap-1 hover:text-emerald-700 transition-colors">
                    <span>Pengaduan</span>
                    <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-emerald-700" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </div>

            </div>

            {{-- Right CTA Button --}}
            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 rounded-full text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 transition-colors shadow-xs">
                        Dashboard Saya
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 rounded-full text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 transition-colors shadow-xs">
                        Masuk Portal
                    </a>
                @endauth

                {{-- Mobile toggle --}}
                <button type="button" @click="mobileNav = !mobileNav" class="lg:hidden p-1.5 rounded-full hover:bg-slate-100 text-slate-700">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>

        </nav>

        {{-- Mobile dropdown menu --}}
        <div x-show="mobileNav" @click.outside="mobileNav = false" class="lg:hidden mt-2 bg-white rounded-2xl p-4 shadow-xl border border-slate-100 text-xs space-y-2" style="display: none;">
            <a href="#layanan" class="block py-2 px-3 rounded-lg hover:bg-slate-50 font-semibold">Layanan Publik</a>
            <a href="#informasi" class="block py-2 px-3 rounded-lg hover:bg-slate-50 font-semibold">PPID & Informasi</a>
            <a href="{{ route('login') }}" class="block py-2 px-3 rounded-lg bg-emerald-600 text-white font-bold text-center">Masuk ke Portal</a>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         2. HERO SECTION WITH HEADLINE (Exact match with screenshot)
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <section class="hero-bg text-white pt-40 pb-36 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        
        {{-- Floating Weather Widget on Right (Exact match with screenshot: 30°C Cerah) --}}
        <div class="absolute right-6 top-36 hidden md:flex flex-col items-end gap-2 z-20">
            <div class="bg-black/40 backdrop-blur-md border border-white/10 rounded-2xl px-4 py-2.5 flex items-center gap-3 text-right">
                <div>
                    <span class="block text-xl font-extrabold text-white">30<sup class="text-xs">°C</sup></span>
                    <span class="block text-[10px] text-slate-300 font-medium">Cerah</span>
                </div>
                <div class="w-8 h-8 rounded-full bg-blue-500 text-white flex items-center justify-center text-xs font-bold">
                    &lt;
                </div>
            </div>

            {{-- Accessibility icon button --}}
            <button type="button" class="w-10 h-10 rounded-full bg-black/50 border border-white/20 text-white flex items-center justify-center text-sm shadow-md hover:bg-black/70 transition-colors">
                ♿
            </button>
        </div>

        {{-- Center Hero Headline --}}
        <div class="max-w-4xl mx-auto text-center space-y-4 relative z-10">
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight leading-tight text-white drop-shadow-md">
                Digitalisasi 'Babarengan'<br>
                Ngawangun Jabar Istimewa
            </h1>
            
            <p class="text-base sm:text-lg text-slate-200 font-normal tracking-wide drop-shadow-sm pt-2">
                Kolaborasi Membangun, Respon Mengabdi & Melayani
            </p>

            <div class="pt-6 flex flex-wrap justify-center gap-3">
                <a href="#layanan" class="px-6 py-3 rounded-full text-xs sm:text-sm font-bold bg-emerald-500 hover:bg-emerald-400 text-slate-950 transition-all shadow-lg">
                    Jelajahi Layanan Publik &rarr;
                </a>
                <a href="{{ route('login') }}" class="px-6 py-3 rounded-full text-xs sm:text-sm font-semibold bg-white/10 hover:bg-white/20 text-white border border-white/20 backdrop-blur-md transition-all">
                    Masuk ke Akun
                </a>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         3. HERO CAROUSEL / 3 FLOATING FEATURE CARDS (Exact match)
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="-mt-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-30">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-stretch">

            {{-- Card 1: Prestasi & Capaian (Left Card) --}}
            <div class="md:col-span-3 bg-white rounded-3xl p-6 shadow-xl border border-slate-100 flex flex-col justify-between">
                <div>
                    <h3 class="text-base font-extrabold text-slate-900 leading-snug">
                        Diskominfo Tahun {{ date('Y') }}
                    </h3>
                    <p class="text-xs text-slate-500 mt-1">Capaian Standar Pelayanan Prima & Sertifikasi Keamanan Sistem.</p>

                    <div class="grid grid-cols-2 gap-3 pt-4">
                        <div class="p-3 bg-slate-50 rounded-2xl text-center border border-slate-100">
                            <span class="text-2xl block mb-1">🏆</span>
                            <span class="text-[10px] font-bold text-slate-700 block">Top 3 Inovasi Pelayanan</span>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-2xl text-center border border-slate-100">
                            <span class="text-2xl block mb-1">🛡️</span>
                            <span class="text-[10px] font-bold text-slate-700 block">ISO 27001 Keamanan</span>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 text-right">
                    <a href="#informasi" class="text-xs font-bold text-emerald-700 hover:text-emerald-900">Lihat Semua &rarr;</a>
                </div>
            </div>

            {{-- Card 2: PROMINENT YELLOW PPID CARD (Center Card - Exact match with screenshot) --}}
            <div class="md:col-span-6 bg-yellow-ppid rounded-3xl p-6 sm:p-8 shadow-2xl flex flex-col sm:flex-row items-center justify-between gap-6 relative overflow-hidden">
                <div class="space-y-4 max-w-md relative z-10">
                    <h3 class="text-xl sm:text-2xl font-black text-slate-950 leading-tight">
                        <span class="italic font-extrabold">Yuk</span>, minta informasi melalui PPID Diskominfo Jabar
                    </h3>

                    <ul class="space-y-2 text-xs font-medium text-slate-900">
                        <li class="flex items-start gap-2">
                            <span class="w-4 h-4 rounded-full bg-white text-emerald-700 flex items-center justify-center font-bold text-[10px] flex-shrink-0 mt-0.5">✓</span>
                            <span>Diatur dalam <strong>Undang-Undang No. 14 Tahun 2008</strong> tentang Keterbukaan Informasi Publik.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="w-4 h-4 rounded-full bg-white text-emerald-700 flex items-center justify-center font-bold text-[10px] flex-shrink-0 mt-0.5">✓</span>
                            <span>Tugas utama PPID Diskominfo menyediakan dan melayani permohonan informasi masyarakat secara cepat.</span>
                        </li>
                    </ul>

                    <div class="pt-2">
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full font-bold text-xs bg-slate-950 hover:bg-slate-800 text-white shadow-md transition-colors">
                            <span>Ajukan Permohonan Informasi</span>
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    </div>
                </div>

                {{-- Officer Photo / Avatar Representation --}}
                <div class="flex-shrink-0 relative z-10 w-36 h-44 rounded-2xl bg-white/30 border border-white/40 flex flex-col items-center justify-center text-center p-3">
                    <span class="text-5xl block mb-2">👩‍💼</span>
                    <span class="text-[10px] font-extrabold text-slate-900">Petugas PPID</span>
                    <span class="text-[9px] text-slate-800">Siap Melayani</span>
                </div>
            </div>

            {{-- Card 3: SP4N-LAPOR! / Pengaduan (Right Card) --}}
            <div class="md:col-span-3 bg-white rounded-3xl p-6 shadow-xl border border-slate-100 flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-16 rounded-xl bg-rose-50 border border-rose-200 flex items-center justify-center text-2xl flex-shrink-0">
                            📱
                        </div>
                        <div>
                            <h3 class="text-sm font-extrabold text-rose-900 leading-snug">
                                Kecewa dengan layanan?
                            </h3>
                            <p class="text-[11px] text-slate-500 mt-1">Sampaikan aspirasi dan pengaduan langsung ke pimpinan.</p>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100">
                    <a href="#" onclick="alert('Layanan Pengaduan SP4N-LAPOR! Terintegrasi');" class="w-full inline-block text-center py-2.5 rounded-xl font-bold text-xs text-white bg-rose-600 hover:bg-rose-700 transition-colors shadow-xs">
                        Buat Pengaduan &rarr;
                    </a>
                </div>
            </div>

        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         4. 8 MASTER LAYANAN PUBLIK TERPADU (KATALOG LAYANAN)
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <section id="layanan" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                Portal Pelayanan Terpadu
            </span>
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight mt-3">
                8 Layanan Utama Masyarakat
            </h2>
            <p class="text-xs sm:text-sm text-slate-600 mt-1">
                Layanan administrasi kependudukan digital & hybrid mencakup seluruh 39 wilayah kecamatan.
            </p>
        </div>

        @php
            $services = $services ?? collect();
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach ($services as $srv)
                <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs hover:shadow-lg hover:border-emerald-500 transition-all group flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-2xl font-bold mb-4 group-hover:scale-105 transition-transform">
                            @if ($srv->kode_layanan === 'KIA') 🪪
                            @elseif ($srv->kode_layanan === 'EKTP') 📸
                            @elseif ($srv->kode_layanan === 'KK_BARU') 👨‍👩‍👧‍👦
                            @elseif ($srv->kode_layanan === 'KK_ADD') 👶
                            @elseif ($srv->kode_layanan === 'KK_DEL') 📋
                            @elseif ($srv->kode_layanan === 'PINDAH') 🚚
                            @elseif ($srv->kode_layanan === 'NIKAH') 💍
                            @else 📄
                            @endif
                        </div>
                        <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $srv->jenis_proses->badgeColor() }}">
                            {{ $srv->jenis_proses === \App\Enums\ServiceProcessType::FullDigital ? 'Digital Penuh' : 'Proses Hybrid' }}
                        </span>
                        <h3 class="text-sm font-bold text-slate-900 group-hover:text-emerald-700 transition-colors mt-2">
                            {{ $srv->nama_layanan }}
                        </h3>
                        <p class="text-xs text-slate-500 mt-1 line-clamp-2 leading-relaxed">
                            {{ $srv->deskripsi }}
                        </p>
                    </div>

                    <div class="mt-6 pt-3 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-[11px] text-slate-400 font-medium">{{ $srv->requirements()->count() }} Syarat Dokumen</span>
                        <a href="{{ route('login') }}" class="text-xs font-bold text-emerald-700 group-hover:translate-x-1 transition-transform">
                            Ajukan &rarr;
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         5. FOOTER
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <footer class="bg-slate-950 text-slate-400 text-xs py-8 sm:py-10 border-t border-slate-800/80 w-full overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-5 sm:gap-8 text-center sm:text-left">
                
                {{-- Logo Footer (Kiri di Desktop, Tengah di Mobile) --}}
                <div class="flex items-center justify-center sm:justify-start shrink-0">
                    <a href="{{ url('/') }}" class="inline-flex items-center bg-white/95 hover:bg-white transition-all px-3.5 py-1.5 rounded-xl shadow-xs border border-white/20">
                        <x-application-logo class="h-8 sm:h-9 w-auto max-h-9" />
                    </a>
                </div>

                {{-- Copyright & Info (Kanan di Desktop, Tengah di Mobile) --}}
                <div class="flex flex-col sm:items-end justify-center gap-1 text-center sm:text-right">
                    <p class="text-xs text-slate-300 font-medium leading-relaxed">
                        &copy; {{ date('Y') }} Dishubkominfo Kab. Tasikmalaya. Seluruh Hak Cipta Dilindungi.
                    </p>
                    <p class="text-[11px] text-slate-500">
                        Portal Pelayanan Publik Terpadu &bull; Dinas Perhubungan, Komunikasi dan Informatika
                    </p>
                </div>

            </div>
        </div>
    </footer>

</body>
</html>
