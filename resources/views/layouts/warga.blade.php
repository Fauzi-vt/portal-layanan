<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard Warga') — Portal Layanan Publik</title>

    {{-- Google Fonts: Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Apply saved font scale preference immediately before render
        (function() {
            const savedScale = localStorage.getItem('userFontScale') || '100';
            document.documentElement.style.fontSize = savedScale + '%';
        })();
    </script>

    <style>
        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        body {
            letter-spacing: -0.01em;
            line-height: 1.5;
        }
        h1, h2, h3 { letter-spacing: -0.02em; }
        [data-lucide] { display: inline-block; vertical-align: middle; }

        /* ── Sidebar Width Transition ── */
        #main-sidebar {
            transition: width 0.28s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* ── Label fade when collapsing ── */
        .sidebar-label {
            transition: opacity 0.2s ease, width 0.25s ease;
            overflow: hidden;
            white-space: nowrap;
        }

        /* ── Tooltip for collapsed sidebar ── */
        .nav-tooltip {
            position: absolute;
            left: calc(100% + 12px);
            top: 50%;
            transform: translateY(-50%);
            padding: 8px 14px;
            background: #0f172a;
            color: #ffffff;
            font-size: 13px;
            font-weight: 600;
            border-radius: 10px;
            white-space: nowrap;
            z-index: 999;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.15s ease, transform 0.15s ease;
            box-shadow: 0 10px 25px -5px rgba(0,0,0,0.3);
            transform: translateY(-50%) translateX(4px);
        }
        .nav-tooltip::before {
            content: '';
            position: absolute;
            right: 100%;
            top: 50%;
            transform: translateY(-50%);
            border: 6px solid transparent;
            border-right-color: #0f172a;
        }
        .has-tooltip:hover .nav-tooltip {
            opacity: 1;
            transform: translateY(-50%) translateX(0);
        }

        /* ── Ripple effect ── */
        .ripple-btn {
            position: relative;
            overflow: hidden;
        }
        .ripple-btn::after {
            content: '';
            position: absolute;
            inset: 0;
            background: currentColor;
            opacity: 0;
            border-radius: inherit;
            transition: opacity 0.3s ease;
        }
        .ripple-btn:active::after {
            opacity: 0.08;
            transition: none;
        }

        /* ── Active nav glow ── */
        .nav-active-item {
            box-shadow: 0 4px 12px rgba(10, 37, 88, 0.25);
        }

        /* ── Smooth icon rotation ── */
        .icon-rotate {
            transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* ── Sidebar section label fade ── */
        .section-label {
            transition: opacity 0.2s ease, max-height 0.25s ease;
            overflow: hidden;
        }

        /* ── Nav hover slide effect ── */
        .nav-link {
            position: relative;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .nav-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%) scaleY(0);
            width: 4px;
            height: 65%;
            background: #0a2558;
            border-radius: 0 4px 4px 0;
            transition: transform 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .nav-link:hover::before {
            transform: translateY(-50%) scaleY(1);
        }
        .nav-link.active-link::before {
            display: none;
        }

        /* ── Top Bar Shimmer Animation ── */
        @keyframes shimmer-progress {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        .progress-shimmer {
            background: linear-gradient(90deg, #0284c7 0%, #0d9488 40%, #38bdf8 70%, #0a2558 100%);
            background-size: 200% 100%;
            animation: shimmer-progress 1.5s infinite linear;
        }

        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="min-h-screen bg-[#f4f7fb] text-slate-800 flex flex-col"
      x-data="{
          sidebarOpen: false,
          sidebarCollapsed: localStorage.getItem('sidebarCollapsed') === 'true',
          userDropdown: false,
          fontScale: localStorage.getItem('userFontScale') || '100',
          setFontScale(scale) {
              this.fontScale = scale;
              localStorage.setItem('userFontScale', scale);
              document.documentElement.style.fontSize = scale + '%';
          },
          toggleCollapse() {
              this.sidebarCollapsed = !this.sidebarCollapsed;
              localStorage.setItem('sidebarCollapsed', this.sidebarCollapsed);
              setTimeout(() => lucide.createIcons(), 50);
          }
      }">

    {{-- ═══════════════════════════════════════════════════════════════════════════
         MODERN PAGE TRANSITION OVERLAY & TOP PROGRESS BAR
    ═══════════════════════════════════════════════════════════════════════════ --}}
    {{-- 1. Top Loading Bar --}}
    <div id="page-progress-bar"
         class="fixed top-0 left-0 right-0 h-1 z-[99999] pointer-events-none opacity-0 transition-opacity duration-200 progress-shimmer">
    </div>

    {{-- 2. Glassmorphism Fullscreen Overlay --}}
    <div id="page-transition-overlay"
         class="fixed inset-0 z-[99998] flex items-center justify-center bg-slate-950/30 backdrop-blur-md opacity-0 pointer-events-none transition-all duration-300">
        <div id="page-transition-card"
             class="relative bg-white/95 backdrop-blur-2xl rounded-3xl p-7 shadow-2xl border border-white/60 flex flex-col items-center gap-4 text-center max-w-[280px] sm:max-w-xs transform scale-95 transition-transform duration-300">
            
            {{-- Dual Ring Glowing Spinner --}}
            <div class="relative w-14 h-14 flex items-center justify-center">
                <div class="absolute inset-0 rounded-full border-4 border-slate-100"></div>
                <div class="absolute inset-0 rounded-full border-4 border-transparent border-t-[#0a2558] border-r-teal-500 animate-spin"></div>
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-[#0a2558] to-[#1e5799] text-white flex items-center justify-center shadow-xs">
                    <i data-lucide="sparkles" class="w-4 h-4 text-teal-300 animate-pulse"></i>
                </div>
            </div>

            <div class="space-y-1">
                <p class="text-base font-bold text-slate-900 tracking-tight" id="transition-loading-text">
                    Memuat Halaman...
                </p>
                <p class="text-xs text-slate-500 font-medium">
                    Portal Layanan Publik Terintegrasi
                </p>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         TOP NAVBAR
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <header class="bg-white border-b border-slate-200 sticky top-0 z-40 shadow-sm">
        <div class="px-4 sm:px-6 h-16 sm:h-20 flex items-center justify-between">

            {{-- Left: Mobile Toggle + Logo --}}
            <div class="flex items-center gap-3 sm:gap-4">
                {{-- Mobile hamburger --}}
                <button type="button"
                        @click="sidebarOpen = !sidebarOpen"
                        class="lg:hidden ripple-btn p-2.5 rounded-xl text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors"
                        title="Buka menu navigasi"
                        aria-label="Buka menu navigasi">
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>

                {{-- Desktop collapse toggle --}}
                <button type="button"
                        @click="toggleCollapse()"
                        class="hidden lg:flex ripple-btn p-2.5 rounded-xl text-slate-500 hover:bg-slate-100 hover:text-slate-900 transition-colors"
                        :title="sidebarCollapsed ? 'Perlebar sidebar' : 'Perkecil sidebar'"
                        aria-label="Toggle lebar menu sidebar">
                    <i data-lucide="panel-left-close" class="w-5 h-5 transition-transform duration-300"
                       :class="{ 'rotate-180': sidebarCollapsed }"></i>
                </button>

                <a href="{{ route('warga.dashboard') }}" class="flex items-center gap-2">
                    <img src="{{ asset('images/logo2.png') }}"
                         alt="Dishub Kominfo - Portal Layanan Publik"
                         class="h-9 sm:h-11 w-auto max-h-11 object-contain">
                </a>
            </div>

            {{-- Right: Accessibility Text Scaler + Bell + User --}}
            <div class="flex items-center gap-2 sm:gap-3">

                {{-- Accessibility: Font Size Switcher (Ramah Semua Generasi / Lansia) --}}
                <div class="flex items-center bg-slate-100 p-1 rounded-xl border border-slate-200" title="Sesuaikan Ukuran Huruf (Aksesibilitas)">
                    <button type="button"
                            @click="setFontScale('90')"
                            :class="fontScale === '90' ? 'bg-white text-[#0a2558] font-bold shadow-xs' : 'text-slate-500 hover:text-slate-900'"
                            class="px-2.5 py-1 rounded-lg text-xs transition-all font-medium"
                            title="Huruf Kecil (90%)">
                        A-
                    </button>
                    <button type="button"
                            @click="setFontScale('100')"
                            :class="fontScale === '100' ? 'bg-white text-[#0a2558] font-bold shadow-xs' : 'text-slate-500 hover:text-slate-900'"
                            class="px-2.5 py-1 rounded-lg text-xs sm:text-sm transition-all font-medium"
                            title="Huruf Normal (100%)">
                        A
                    </button>
                    <button type="button"
                            @click="setFontScale('115')"
                            :class="fontScale === '115' ? 'bg-white text-[#0a2558] font-bold shadow-xs' : 'text-slate-500 hover:text-slate-900'"
                            class="px-2.5 py-1 rounded-lg text-sm sm:text-base transition-all font-bold"
                            title="Huruf Besar (115% - Ramah Lansia/Mata Lelah)">
                        A+
                    </button>
                </div>

                {{-- Notification Bell --}}
                <button type="button"
                        class="ripple-btn relative text-slate-600 hover:text-slate-900 p-2.5 rounded-xl hover:bg-slate-100 transition-colors"
                        title="Notifikasi Permohonan"
                        aria-label="Lihat Notifikasi">
                    <i data-lucide="bell" class="w-5 h-5 sm:w-6 sm:h-6"></i>
                    @if (auth()->user()->submissions()->where('status', \App\Enums\SubmissionStatus::RevisionRequired)->count() > 0)
                        <span class="absolute top-2 right-2 w-2.5 h-2.5 rounded-full bg-amber-500 animate-ping"></span>
                        <span class="absolute top-2 right-2 w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                    @endif
                </button>

                {{-- User Dropdown --}}
                <div class="relative" @click.outside="userDropdown = false">
                    <button type="button"
                            @click="userDropdown = !userDropdown"
                            class="ripple-btn relative z-50 flex items-center gap-2.5 px-3 py-2 rounded-xl transition-colors cursor-pointer"
                            :class="userDropdown ? 'bg-slate-100 ring-2 ring-blue-500/20' : 'hover:bg-slate-100'">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-teal-500 to-teal-700 text-white flex items-center justify-center font-bold text-sm sm:text-base shadow-sm ring-2 ring-white">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="text-left hidden md:block max-w-[150px]">
                            <p class="text-sm font-bold text-slate-800 truncate leading-tight">
                                {{ auth()->user()->name }}
                            </p>
                            <p class="text-xs text-slate-500 truncate font-medium">Pemohon (Warga)</p>
                        </div>
                        <i data-lucide="chevron-down"
                           class="w-4 h-4 text-slate-500 icon-rotate hidden sm:block"
                           :class="{ 'rotate-180 text-slate-900': userDropdown }"></i>
                    </button>

                    {{-- Overlay backdrop for Dropdown --}}
                    <div x-show="userDropdown"
                         x-cloak
                         @click="userDropdown = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         class="fixed inset-0 bg-slate-900/30 backdrop-blur-[2px] z-40">
                    </div>

                    {{-- Dropdown Panel --}}
                    <div x-show="userDropdown"
                         x-cloak
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                         class="absolute right-0 mt-2 w-72 bg-white rounded-2xl shadow-2xl border border-slate-100 overflow-hidden z-50">

                        <div class="px-5 py-4 bg-gradient-to-br from-slate-50 to-slate-100/60 border-b border-slate-100">
                            <div class="flex items-center gap-3.5">
                                <div class="w-11 h-11 rounded-full bg-gradient-to-br from-teal-500 to-teal-700 text-white flex items-center justify-center font-bold text-base shadow-sm flex-shrink-0">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="font-bold text-slate-900 text-sm sm:text-base truncate">{{ auth()->user()->name }}</p>
                                    <p class="text-slate-500 text-xs sm:text-sm truncate mt-0.5 font-medium">{{ auth()->user()->email }}</p>
                                </div>
                            </div>
                            <div class="mt-3 flex items-center gap-2 text-xs sm:text-sm text-teal-800 bg-teal-50 rounded-xl px-3 py-2 font-semibold border border-teal-200/60">
                                <i data-lucide="map-pin" class="w-4 h-4 text-teal-600 flex-shrink-0"></i>
                                <span>Kecamatan {{ auth()->user()->kecamatan?->nama_kecamatan ?? '-' }}</span>
                            </div>
                        </div>

                        <div class="py-2.5 px-2.5 space-y-1">
                            <a href="{{ route('warga.profile.edit') }}"
                               class="ripple-btn flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm sm:text-base {{ request()->routeIs('warga.profile.*') ? 'bg-blue-50 text-blue-900 font-bold' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900 font-medium' }} transition-colors">
                                <i data-lucide="user-pen" class="w-5 h-5 {{ request()->routeIs('warga.profile.*') ? 'text-blue-700' : 'text-slate-400' }}"></i>
                                <span>Profil Saya</span>
                            </a>
                            <a href="{{ route('warga.submissions.index', ['status' => 'submitted']) }}"
                               class="ripple-btn flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm sm:text-base text-slate-700 hover:bg-slate-100 hover:text-slate-900 font-medium transition-colors">
                                <i data-lucide="clipboard-list" class="w-5 h-5 text-slate-400"></i>
                                <span>Daftar Permohonan</span>
                            </a>
                        </div>

                        <div class="py-2.5 px-2.5 border-t border-slate-100">
                            <form id="warga-logout-form" method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="button"
                                        onclick="confirmWargaLogout()"
                                        class="ripple-btn w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm sm:text-base text-rose-600 hover:bg-rose-50 font-bold transition-colors">
                                    <i data-lucide="log-out" class="w-5 h-5 text-rose-500"></i>
                                    <span>Keluar (Logout)</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </header>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         MAIN WRAPPER
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="flex-1 flex overflow-hidden">

        {{-- ── Sidebar ── --}}
        <aside id="main-sidebar"
               :class="{
                   'translate-x-0': sidebarOpen,
                   '-translate-x-full': !sidebarOpen,
                   'lg:translate-x-0': true,
                   'w-64 sm:w-72': !sidebarCollapsed,
                   'w-20': sidebarCollapsed
               }"
               class="fixed lg:static inset-y-0 left-0 z-30 bg-white border-r border-slate-200/90 flex flex-col justify-between shrink-0 overflow-hidden overflow-y-auto">

            <div class="py-6 space-y-2" :class="sidebarCollapsed ? 'px-2' : 'px-4'">

                {{-- ── GROUP: DASHBOARD ── --}}
                <div class="mb-2">
                    <p class="section-label text-xs font-bold text-slate-400 tracking-[0.15em] uppercase px-3 mb-2.5"
                       :class="sidebarCollapsed ? 'opacity-0 max-h-0 mb-0' : 'opacity-100 max-h-8'">
                        DASHBOARD
                    </p>

                    <a href="{{ route('warga.dashboard') }}"
                       class="nav-link ripple-btn has-tooltip relative flex items-center gap-3.5 px-3.5 py-3 rounded-2xl text-sm sm:text-base font-semibold transition-all
                              {{ request()->routeIs('warga.dashboard') ? 'bg-[#0a2558] text-white nav-active-item active-link' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}"
                       :class="sidebarCollapsed ? 'justify-center px-0' : ''">
                        <i data-lucide="layout-dashboard"
                           class="w-5 h-5 sm:w-6 sm:h-6 flex-shrink-0 {{ request()->routeIs('warga.dashboard') ? 'text-white' : 'text-slate-500' }}"></i>
                        <span class="sidebar-label"
                              :class="sidebarCollapsed ? 'opacity-0 w-0' : 'opacity-100'">Dashboard</span>
                        <span class="nav-tooltip">Dashboard Utama</span>
                    </a>
                </div>

                {{-- ── GROUP: PERMOHONAN ── --}}
                <div class="mb-2 space-y-1">
                    <p class="section-label text-xs font-bold text-slate-400 tracking-[0.15em] uppercase px-3 mb-2.5"
                       :class="sidebarCollapsed ? 'opacity-0 max-h-0 mb-0' : 'opacity-100 max-h-8'">
                        PERMOHONAN
                    </p>

                    {{-- Tambah Permohonan --}}
                    <a href="{{ route('warga.submissions.create') }}"
                       class="nav-link ripple-btn has-tooltip relative flex items-center gap-3.5 px-3.5 py-3 rounded-2xl text-sm sm:text-base font-semibold transition-all
                              {{ request()->routeIs('warga.submissions.create') ? 'bg-[#0a2558] text-white nav-active-item active-link' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}"
                       :class="sidebarCollapsed ? 'justify-center px-0' : ''">
                        <i data-lucide="file-plus-2"
                           class="w-5 h-5 sm:w-6 sm:h-6 flex-shrink-0 {{ request()->routeIs('warga.submissions.create') ? 'text-white' : 'text-slate-500' }}"></i>
                        <span class="sidebar-label"
                              :class="sidebarCollapsed ? 'opacity-0 w-0' : 'opacity-100'">Tambah Permohonan</span>
                        <span class="nav-tooltip">Buat Permohonan Baru</span>
                    </a>

                    {{-- Daftar Permohonan Accordion --}}
                    <div x-data="{ openPermohonan: {{ request()->routeIs('warga.submissions.*') && !request()->routeIs('warga.submissions.create') ? 'true' : 'false' }} }">

                        <button type="button"
                                @click="if(!sidebarCollapsed) openPermohonan = !openPermohonan"
                                class="nav-link ripple-btn has-tooltip relative w-full flex items-center justify-between px-3.5 py-3 rounded-2xl text-sm sm:text-base font-semibold transition-all
                                       {{ request()->routeIs('warga.submissions.*') && !request()->routeIs('warga.submissions.create') ? 'bg-slate-100 text-slate-900' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}"
                                :class="sidebarCollapsed ? 'justify-center px-0' : ''">
                            <div class="flex items-center gap-3.5">
                                <i data-lucide="clipboard-list"
                                   class="w-5 h-5 sm:w-6 sm:h-6 flex-shrink-0 {{ request()->routeIs('warga.submissions.*') && !request()->routeIs('warga.submissions.create') ? 'text-[#0a2558]' : 'text-slate-500' }}"></i>
                                <span class="sidebar-label"
                                      :class="sidebarCollapsed ? 'opacity-0 w-0' : 'opacity-100'">Daftar Permohonan</span>
                            </div>
                            <i data-lucide="chevron-down"
                               class="w-4 h-4 text-slate-400 icon-rotate flex-shrink-0"
                               :class="{
                                   'rotate-180 text-[#0a2558]': openPermohonan,
                                   'hidden': sidebarCollapsed
                               }"></i>
                            <span class="nav-tooltip">Lihat Daftar Permohonan</span>
                        </button>

                        {{-- Submenu --}}
                        <div x-show="openPermohonan && !sidebarCollapsed"
                             x-cloak
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 -translate-y-2 max-h-0"
                             x-transition:enter-end="opacity-100 translate-y-0 max-h-48"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 -translate-y-2"
                             class="pl-11 pr-2 py-1.5 space-y-1 overflow-hidden">

                            <a href="{{ route('warga.submissions.index', ['status' => 'submitted']) }}"
                               class="ripple-btn flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-xs sm:text-sm font-semibold transition-all
                                      {{ request()->routeIs('warga.submissions.index') && request('status') === 'submitted' ? 'bg-blue-50 text-blue-800 border border-blue-200' : 'text-slate-600 hover:text-blue-700 hover:bg-blue-50/70' }}">
                                <i data-lucide="send" class="w-4 h-4 flex-shrink-0"></i>
                                <span>Terkirim (Proses)</span>
                            </a>

                            <a href="{{ route('warga.submissions.index', ['status' => 'rejected']) }}"
                               class="ripple-btn flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-xs sm:text-sm font-semibold transition-all
                                      {{ request()->routeIs('warga.submissions.index') && request('status') === 'rejected' ? 'bg-rose-50 text-rose-800 border border-rose-200' : 'text-slate-600 hover:text-rose-700 hover:bg-rose-50/70' }}">
                                <i data-lucide="x-circle" class="w-4 h-4 flex-shrink-0"></i>
                                <span>Ditolak / Revisi</span>
                            </a>

                            <a href="{{ route('warga.submissions.index', ['status' => 'completed']) }}"
                               class="ripple-btn flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-xs sm:text-sm font-semibold transition-all
                                      {{ request()->routeIs('warga.submissions.index') && request('status') === 'completed' ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : 'text-slate-600 hover:text-emerald-700 hover:bg-emerald-50/70' }}">
                                <i data-lucide="badge-check" class="w-4 h-4 flex-shrink-0"></i>
                                <span>Terbit (Selesai)</span>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- ── GROUP: AKUN & PENGATURAN ── --}}
                <div class="mb-2">
                    <p class="section-label text-xs font-bold text-slate-400 tracking-[0.15em] uppercase px-3 mb-2.5"
                       :class="sidebarCollapsed ? 'opacity-0 max-h-0 mb-0' : 'opacity-100 max-h-8'">
                        AKUN SAYA
                    </p>

                    <a href="{{ route('warga.profile.edit') }}"
                       class="nav-link ripple-btn has-tooltip relative flex items-center gap-3.5 px-3.5 py-3 rounded-2xl text-sm sm:text-base font-semibold transition-all
                              {{ request()->routeIs('warga.profile.*') ? 'bg-[#0a2558] text-white nav-active-item active-link' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}"
                       :class="sidebarCollapsed ? 'justify-center px-0' : ''">
                        <i data-lucide="user-pen"
                           class="w-5 h-5 sm:w-6 sm:h-6 flex-shrink-0 {{ request()->routeIs('warga.profile.*') ? 'text-white' : 'text-slate-500' }}"></i>
                        <span class="sidebar-label"
                              :class="sidebarCollapsed ? 'opacity-0 w-0' : 'opacity-100'">Profil Saya</span>
                        <span class="nav-tooltip">Pengaturan Profil Saya</span>
                    </a>
                </div>

                {{-- ── GROUP: LAINNYA ── --}}
                <div class="mb-2">
                    <p class="section-label text-xs font-bold text-slate-400 tracking-[0.15em] uppercase px-3 mb-2.5"
                       :class="sidebarCollapsed ? 'opacity-0 max-h-0 mb-0' : 'opacity-100 max-h-8'">
                        LAINNYA
                    </p>

                    <a href="{{ url('/') }}"
                       class="nav-link ripple-btn has-tooltip relative flex items-center gap-3.5 px-3.5 py-3 rounded-2xl text-sm sm:text-base font-semibold text-slate-700 hover:bg-slate-100 hover:text-slate-900 transition-all"
                       :class="sidebarCollapsed ? 'justify-center px-0' : ''">
                        <i data-lucide="circle-help" class="w-5 h-5 sm:w-6 sm:h-6 text-slate-500 flex-shrink-0"></i>
                        <span class="sidebar-label"
                              :class="sidebarCollapsed ? 'opacity-0 w-0' : 'opacity-100'">Bantuan &amp; FAQ</span>
                        <span class="nav-tooltip">Pusat Bantuan & Panduan</span>
                    </a>
                </div>

            </div>

            {{-- Sidebar Footer --}}
            <div class="border-t border-slate-100 py-4"
                 :class="sidebarCollapsed ? 'px-2 flex justify-center' : 'px-5 flex items-center gap-2.5'">
                <i data-lucide="shield-check" class="w-4 h-4 text-slate-400 flex-shrink-0"></i>
                <span class="sidebar-label text-xs font-medium text-slate-500"
                      :class="sidebarCollapsed ? 'opacity-0 w-0' : 'opacity-100'">&copy; {{ date('Y') }} KOMDIGI / Pemkab</span>
            </div>
        </aside>

        {{-- Backdrop mobile --}}
        <div x-show="sidebarOpen"
             x-cloak
             @click="sidebarOpen = false"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-slate-900/40 z-20 lg:hidden backdrop-blur-xs">
        </div>

        {{-- ── Main Content ── --}}
        <main class="flex-1 p-5 sm:p-8 lg:p-10 overflow-y-auto max-w-7xl mx-auto w-full">

            {{-- Flash: Success --}}
            @if (session('success'))
                <div x-data="{ show: true }"
                     x-show="show"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 -translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-end="opacity-0 -translate-y-2"
                     class="mb-6 rounded-2xl bg-emerald-50 border border-emerald-200 p-4 sm:p-5 flex items-center gap-3.5 text-sm sm:text-base text-emerald-900 font-semibold shadow-xs">
                    <i data-lucide="circle-check-big" class="w-6 h-6 text-emerald-600 flex-shrink-0"></i>
                    <span class="flex-1">{{ session('success') }}</span>
                    <button @click="show = false" class="text-emerald-500 hover:text-emerald-800 p-1.5 rounded-xl hover:bg-emerald-100 transition-colors">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
            @endif

            {{-- Flash: Warning --}}
            @if (session('warning'))
                <div x-data="{ show: true }"
                     x-show="show"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 -translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="mb-6 rounded-2xl bg-amber-50 border border-amber-200 p-4 sm:p-5 flex items-center gap-3.5 text-sm sm:text-base text-amber-900 font-semibold shadow-xs">
                    <i data-lucide="triangle-alert" class="w-6 h-6 text-amber-600 flex-shrink-0"></i>
                    <span class="flex-1">{{ session('warning') }}</span>
                    <button @click="show = false" class="text-amber-500 hover:text-amber-800 p-1.5 rounded-xl hover:bg-amber-100 transition-colors">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
            @endif

            @yield('content')
        </main>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            lucide.createIcons();
        });
        document.addEventListener('alpine:initialized', function () {
            lucide.createIcons();
        });
        document.addEventListener('alpine:init', () => {
            Alpine.effect(() => {
                setTimeout(() => lucide.createIcons(), 50);
            });
        });

        // ── SweetAlert2 Helper & Defaults ──
        const SwalToast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            },
            customClass: {
                popup: 'rounded-2xl shadow-xl font-sans text-sm border border-slate-100'
            }
        });

        // ── Laravel Session Flash SweetAlert Triggers ──
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#0a2558',
                confirmButtonText: 'Selesai',
                customClass: {
                    popup: 'rounded-2xl shadow-2xl p-6 font-sans',
                    confirmButton: 'rounded-xl font-bold px-6 py-2.5 shadow-md'
                }
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan!',
                text: '{{ session('error') }}',
                confirmButtonColor: '#e11d48',
                confirmButtonText: 'Tutup',
                customClass: {
                    popup: 'rounded-2xl shadow-2xl p-6 font-sans',
                    confirmButton: 'rounded-xl font-bold px-6 py-2.5 shadow-md'
                }
            });
        @endif

        @if (session('warning'))
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian!',
                text: '{{ session('warning') }}',
                confirmButtonColor: '#d97706',
                confirmButtonText: 'Mengerti',
                customClass: {
                    popup: 'rounded-2xl shadow-2xl p-6 font-sans',
                    confirmButton: 'rounded-xl font-bold px-6 py-2.5 shadow-md'
                }
            });
        @endif

        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Periksa Kembali Isian Anda',
                html: '<ul class="text-left text-sm space-y-1 mt-2 text-rose-700 bg-rose-50 p-3 rounded-xl border border-rose-200">@foreach ($errors->all() as $error)<li>• {{ $error }}</li>@endforeach</ul>',
                confirmButtonColor: '#0a2558',
                confirmButtonText: 'Perbaiki',
                customClass: {
                    popup: 'rounded-2xl shadow-2xl p-6 font-sans',
                    confirmButton: 'rounded-xl font-bold px-6 py-2.5 shadow-md'
                }
            });
        @endif

        // ── Logout Confirmation Dialog ──
        function confirmWargaLogout() {
            Swal.fire({
                title: 'Konfirmasi Keluar',
                text: 'Apakah Anda yakin ingin keluar dari akun Anda?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Keluar',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-2xl shadow-2xl p-6 font-sans',
                    confirmButton: 'rounded-xl font-bold px-5 py-2.5',
                    cancelButton: 'rounded-xl font-medium px-5 py-2.5'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('warga-logout-form').submit();
                }
            });
        }

        // ── Modern Page Transition Overlay Controller ──
        const PageTransition = {
            overlay: null,
            card: null,
            progressBar: null,
            loadingText: null,

            init() {
                this.overlay = document.getElementById('page-transition-overlay');
                this.card = document.getElementById('page-transition-card');
                this.progressBar = document.getElementById('page-progress-bar');
                this.loadingText = document.getElementById('transition-loading-text');

                // Auto hide on load & on history navigation (back/forward)
                window.addEventListener('pageshow', () => this.hide());
                window.addEventListener('load', () => this.hide());
                this.hide();

                // Intercept navigation links
                document.addEventListener('click', (e) => {
                    const link = e.target.closest('a');
                    if (!link) return;

                    const href = link.getAttribute('href');
                    const target = link.getAttribute('target');

                    if (!href || href.startsWith('#') || href.startsWith('javascript:') || target === '_blank' || link.hasAttribute('download')) {
                        return;
                    }

                    if (href.startsWith('/') || href.startsWith(window.location.origin)) {
                        if (e.ctrlKey || e.metaKey || e.shiftKey || e.altKey) return;

                        // Get menu label for customized loading text
                        const labelElem = link.querySelector('.sidebar-label') || link.querySelector('span');
                        const customLabel = labelElem ? labelElem.textContent.trim() : '';
                        
                        if (customLabel && customLabel.length < 30) {
                            this.show(`Membuka ${customLabel}...`);
                        } else {
                            this.show('Memuat Halaman...');
                        }
                    }
                });

                // Intercept form submissions
                document.addEventListener('submit', (e) => {
                    const form = e.target;
                    if (form.getAttribute('target') === '_blank') return;
                    const submitBtn = form.querySelector('button[type="submit"]');
                    const btnText = submitBtn ? submitBtn.textContent.trim() : 'Menyimpan Data...';
                    this.show(btnText || 'Memproses Data...');
                });
            },

            show(text = 'Memuat Halaman...') {
                if (!this.overlay) return;
                if (this.loadingText && text) this.loadingText.textContent = text;
                this.overlay.classList.remove('pointer-events-none', 'opacity-0');
                this.overlay.classList.add('opacity-100');
                if (this.card) {
                    this.card.classList.remove('scale-95');
                    this.card.classList.add('scale-100');
                }
                if (this.progressBar) this.progressBar.classList.remove('opacity-0');

                // Safety timeout: auto hide after 8s
                setTimeout(() => this.hide(), 8000);
            },

            hide() {
                if (!this.overlay) return;
                this.overlay.classList.add('opacity-0', 'pointer-events-none');
                this.overlay.classList.remove('opacity-100');
                if (this.card) {
                    this.card.classList.add('scale-95');
                    this.card.classList.remove('scale-100');
                }
                if (this.progressBar) this.progressBar.classList.add('opacity-0');
            }
        };

        document.addEventListener('DOMContentLoaded', () => PageTransition.init());
    </script>

</body>
</html>
