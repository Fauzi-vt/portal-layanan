<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Super Admin Command Center') — Kab. Tasikmalaya</title>

    {{-- Fonts Google --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Tailwind CSS compiled via Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Alpine.js for interactive UI state --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>

    {{-- SweetAlert2 for notifications and dialogs --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>

    @stack('styles')
</head>
<body class="h-full antialiased text-slate-800 bg-slate-100 selection:bg-[#0a2558] selection:text-white"
      x-data="{
          sidebarCollapsed: localStorage.getItem('sa_sidebar_collapsed') === 'true',
          mobileDrawerOpen: false,
          profileDropdownOpen: false,
          toggleSidebar() {
              this.sidebarCollapsed = !this.sidebarCollapsed;
              localStorage.setItem('sa_sidebar_collapsed', this.sidebarCollapsed);
          }
      }">

    <div class="min-h-full flex flex-row">

        {{-- ══════════════════════════════════════════════════════════════════════
             1. BACKDROP FOR MOBILE DRAWER
        ══════════════════════════════════════════════════════════════════════ --}}
        <div x-show="mobileDrawerOpen"
             x-cloak
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="mobileDrawerOpen = false"
             class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 lg:hidden"
             aria-hidden="true">
        </div>

        {{-- ══════════════════════════════════════════════════════════════════════
             2. SIDEBAR (DESKTOP & MOBILE DRAWER)
        ══════════════════════════════════════════════════════════════════════ --}}
        <aside :class="{
                   'translate-x-0': mobileDrawerOpen,
                   '-translate-x-full': !mobileDrawerOpen,
                   'lg:w-64': !sidebarCollapsed,
                   'lg:w-20': sidebarCollapsed
               }"
               class="fixed inset-y-0 left-0 z-50 flex flex-col bg-slate-900 text-slate-300 border-r border-slate-800 transition-all duration-300 ease-in-out lg:translate-x-0 lg:static lg:z-30 shrink-0 w-64 shadow-2xl lg:shadow-none">

            {{-- 2.1 Sidebar Header / Brand --}}
            <div class="px-3 py-3 border-b border-slate-800/80 bg-slate-950/70 transition-all duration-300 shrink-0 flex items-center"
                 :class="sidebarCollapsed ? 'justify-center px-2' : 'justify-between'">
                <a href="{{ route('superadmin.dashboard') }}"
                   class="flex items-center group transition-all duration-300"
                   :class="sidebarCollapsed ? 'w-auto' : 'flex-1 lg:w-full'">
                    {{-- Card Putih Kontras Sesuai Ukuran Card Akses Otoritas --}}
                    <div class="bg-white rounded-xl shadow-xs border border-white/90 flex items-center justify-center transition-all duration-300 group-hover:shadow-md group-hover:scale-[1.01]"
                         :class="sidebarCollapsed ? 'w-11 h-11 p-1 overflow-hidden' : 'w-full px-3 py-2'">
                        <img src="{{ asset('images/logo2.png') }}"
                             alt="Logo Portal Layanan"
                             class="h-8 w-auto max-h-8 max-w-full object-contain transition-all duration-300"
                             :class="sidebarCollapsed ? 'h-6 object-left' : ''">
                    </div>
                </a>

                {{-- Close Button for Mobile Drawer --}}
                <button type="button"
                        @click="mobileDrawerOpen = false"
                        class="lg:hidden p-1.5 ml-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition-colors shrink-0"
                        aria-label="Tutup Menu">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- 2.2 Role Indicator Badge --}}
            <div class="px-3 py-3 border-b border-slate-800/60 bg-slate-900/90"
                 x-show="!sidebarCollapsed"
                 x-transition:enter="transition-opacity duration-200">
                <div class="flex items-center gap-2.5 px-3 py-2 rounded-xl bg-blue-950/50 border border-blue-500/20 text-blue-200">
                    <span class="w-2 h-2 rounded-full bg-blue-400 animate-pulse shrink-0"></span>
                    <div class="overflow-hidden">
                        <p class="text-[10px] uppercase font-bold tracking-wider text-blue-300">Akses Otoritas</p>
                        <p class="text-xs font-semibold text-white truncate">Super Administrator</p>
                    </div>
                </div>
            </div>

            {{-- 2.3 Navigation Menu --}}
            <div class="flex-1 overflow-y-auto px-3 py-4 space-y-6">

                {{-- Group: Operasional Utama --}}
                <div class="space-y-1">
                    <div x-show="!sidebarCollapsed" class="px-3 mb-2 text-[10px] font-bold uppercase tracking-wider text-slate-500">
                        Menu Utama
                    </div>

                    {{-- 1. Monitoring Global --}}
                    <a href="{{ route('superadmin.dashboard') }}"
                       :title="sidebarCollapsed ? 'Monitoring Global' : ''"
                       class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('superadmin.dashboard') ? 'bg-[#0a2558] text-white shadow-lg shadow-blue-950/30 border border-blue-500/20' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                        <svg class="w-5 h-5 shrink-0 transition-transform group-hover:scale-110 {{ request()->routeIs('superadmin.dashboard') ? 'text-white' : 'text-slate-400 group-hover:text-blue-400' }}"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        <span x-show="!sidebarCollapsed" class="truncate">Monitoring Global</span>
                    </a>

                    {{-- 2. Kelola Layanan Publik --}}
                    <a href="{{ route('superadmin.services.index') }}"
                       :title="sidebarCollapsed ? 'Kelola Layanan Publik' : ''"
                       class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('superadmin.services.*') ? 'bg-[#0a2558] text-white shadow-lg shadow-blue-950/30 border border-blue-500/20' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                        <svg class="w-5 h-5 shrink-0 transition-transform group-hover:scale-110 {{ request()->routeIs('superadmin.services.*') ? 'text-white' : 'text-slate-400 group-hover:text-blue-400' }}"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span x-show="!sidebarCollapsed" class="truncate">Kelola Layanan Publik</span>
                    </a>

                    {{-- 3. Master Wilayah --}}
                    <a href="{{ route('superadmin.wilayah.index') }}"
                       :title="sidebarCollapsed ? 'Master Wilayah' : ''"
                       class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('superadmin.wilayah.*') ? 'bg-[#0a2558] text-white shadow-lg shadow-blue-950/30 border border-blue-500/20' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                        <svg class="w-5 h-5 shrink-0 transition-transform group-hover:scale-110 {{ request()->routeIs('superadmin.wilayah.*') ? 'text-white' : 'text-slate-400 group-hover:text-blue-400' }}"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span x-show="!sidebarCollapsed" class="truncate">Master Wilayah</span>
                    </a>
                </div>

                {{-- Group: Akses Eksternal & Bantuan --}}
                <div class="space-y-1 pt-4 border-t border-slate-800/80">
                    <div x-show="!sidebarCollapsed" class="px-3 mb-2 text-[10px] font-bold uppercase tracking-wider text-slate-500">
                        Pintas Sistem
                    </div>

                    {{-- Lihat Portal Publik --}}
                    <a href="{{ url('/') }}"
                       target="_blank"
                       :title="sidebarCollapsed ? 'Kunjungi Portal Publik' : ''"
                       class="group flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-medium text-slate-400 hover:bg-slate-800/50 hover:text-slate-200 transition-colors">
                        <svg class="w-5 h-5 shrink-0 text-slate-500 group-hover:text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                        <span x-show="!sidebarCollapsed" class="truncate">Portal Publik Warga</span>
                    </a>
                </div>
            </div>

            {{-- 2.4 Sidebar Footer / Collapse Toggle (Desktop Only) --}}
            <div class="hidden lg:flex p-3 border-t border-slate-800/80 bg-slate-950/40">
                <button type="button"
                        @click="toggleSidebar()"
                        :title="sidebarCollapsed ? 'Perlebar Menu' : 'Perkecil Menu'"
                        class="w-full flex items-center justify-center gap-2 px-3 py-2 rounded-xl text-xs font-semibold text-slate-400 hover:text-white hover:bg-slate-800 transition-colors">
                    <svg class="w-4 h-4 transition-transform duration-300"
                         :class="{ 'rotate-180': sidebarCollapsed }"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                    </svg>
                    <span x-show="!sidebarCollapsed" class="text-[11px]">Sembunyikan Sidebar</span>
                </button>
            </div>
        </aside>

        {{-- ══════════════════════════════════════════════════════════════════════
             3. MAIN WRAPPER (TOPBAR + CONTENT)
        ══════════════════════════════════════════════════════════════════════ --}}
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

            {{-- 3.1 Executive Topbar --}}
            <header class="h-16 bg-white border-b border-slate-200/80 sticky top-0 z-30 flex items-center justify-between px-4 sm:px-6 lg:px-8 shadow-xs">

                {{-- Left Side: Hamburger & Breadcrumb --}}
                <div class="flex items-center gap-3 sm:gap-4 min-w-0">
                    {{-- Mobile Menu Trigger --}}
                    <button type="button"
                            @click="mobileDrawerOpen = true"
                            class="lg:hidden p-2 rounded-xl text-slate-500 hover:text-slate-800 hover:bg-slate-100 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500"
                            aria-label="Buka Navigasi">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    {{-- Breadcrumbs Navigation --}}
                    <nav class="flex items-center text-xs font-medium text-slate-500 truncate" aria-label="Breadcrumb">
                        <a href="{{ route('superadmin.dashboard') }}" class="hover:text-[#0a2558] flex items-center gap-1.5 transition-colors">
                            <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <span class="hidden sm:inline font-semibold">Super Admin</span>
                        </a>

                        <span class="mx-2 text-slate-300">/</span>

                        <div class="truncate font-semibold text-slate-900">
                            @hasSection('breadcrumb')
                                @yield('breadcrumb')
                            @else
                                @if (request()->routeIs('superadmin.dashboard'))
                                    <span>Monitoring Global</span>
                                @elseif (request()->routeIs('superadmin.services.*'))
                                    <span>Kelola Layanan Publik</span>
                                @elseif (request()->routeIs('superadmin.wilayah.*'))
                                    <span>Master Wilayah</span>
                                @else
                                    <span>Portal Panel</span>
                                @endif
                            @endif
                        </div>
                    </nav>
                </div>

                {{-- Right Side: Identity Badge & User Profile Dropdown --}}
                <div class="flex items-center gap-3 sm:gap-4 shrink-0">

                    {{-- Otoritas Identitas Pemerintah --}}
                    <div class="hidden md:flex items-center gap-2 px-3 py-1.5 rounded-full bg-slate-100 border border-slate-200/80 text-[11px] font-medium text-slate-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#0a2558]"></span>
                        <span>Diskominfo Kab. Tasikmalaya</span>
                    </div>

                    {{-- User Profile Dropdown Menu --}}
                    <div class="relative" @click.outside="profileDropdownOpen = false">
                        <button type="button"
                                @click="profileDropdownOpen = !profileDropdownOpen"
                                class="flex items-center gap-2.5 p-1 sm:p-1.5 sm:pl-3 rounded-full hover:bg-slate-100 border border-slate-200 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500"
                                aria-expanded="false"
                                aria-haspopup="true">
                            <span class="w-8 h-8 rounded-full bg-gradient-to-br from-[#0a2558] to-[#1e5799] text-white font-bold flex items-center justify-center text-xs shadow-xs">
                                {{ strtoupper(substr(auth()->user()->name ?? 'S', 0, 1)) }}
                            </span>
                            <div class="hidden sm:block text-left leading-tight pr-1">
                                <span class="block text-xs font-bold text-slate-800 max-w-[140px] truncate">
                                    {{ auth()->user()->name ?? 'Super Administrator' }}
                                </span>
                                <span class="block text-[10px] text-[#0a2558] font-semibold">Diskominfo</span>
                            </div>
                            <svg class="w-4 h-4 text-slate-400 hidden sm:block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        {{-- Dropdown Card --}}
                        <div x-show="profileDropdownOpen"
                             x-cloak
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-64 bg-white rounded-2xl border border-slate-200 shadow-xl py-2 z-50 divide-y divide-slate-100"
                             role="menu">

                            <div class="px-4 py-3">
                                <p class="text-[11px] text-slate-500 font-medium">Akun Terautentikasi:</p>
                                <p class="text-xs font-bold text-slate-900 truncate mt-0.5">{{ auth()->user()->email ?? '-' }}</p>
                                <div class="mt-2 inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-blue-100 text-[#0a2558] border border-blue-200">
                                    👑 {{ auth()->user()->role_label ?? 'Super Administrator' }}
                                </div>
                            </div>

                            <div class="py-1.5">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                            class="w-full text-left px-4 py-2.5 text-xs font-semibold text-rose-600 hover:bg-rose-50 flex items-center gap-2.5 transition-colors">
                                        <svg class="w-4 h-4 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Keluar dari Sistem
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            {{-- 3.2 Main Content View --}}
            <main class="flex-1 overflow-y-auto bg-slate-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">

                    {{-- Flash Session Alerts --}}
                    @if (session('success'))
                        <div x-data="{ show: true }" x-show="show" x-transition.duration.300ms class="mb-6 rounded-2xl bg-emerald-50 border border-emerald-200 p-4 flex items-start gap-3 shadow-xs" role="alert">
                            <div class="flex-shrink-0 w-8 h-8 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                            </div>
                            <div class="flex-1 pt-0.5">
                                <h4 class="text-xs font-bold text-emerald-900">Operasi Berhasil</h4>
                                <p class="text-xs text-emerald-700 mt-0.5">{{ session('success') }}</p>
                            </div>
                            <button type="button" @click="show = false" class="text-emerald-500 hover:text-emerald-700 p-1 rounded-lg">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>
                    @endif

                    @if (session('warning'))
                        <div x-data="{ show: true }" x-show="show" class="mb-6 rounded-2xl bg-amber-50 border border-amber-200 p-4 flex items-start gap-3 shadow-xs" role="alert">
                            <div class="flex-shrink-0 w-8 h-8 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                            </div>
                            <div class="flex-1 pt-0.5">
                                <h4 class="text-xs font-bold text-amber-900">Perhatian</h4>
                                <p class="text-xs text-amber-800 mt-0.5">{{ session('warning') }}</p>
                            </div>
                            <button type="button" @click="show = false" class="text-amber-600 hover:text-amber-800 p-1 rounded-lg">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>
                    @endif

                    @if (session('error') || (isset($errors) && $errors->any()))
                        <div x-data="{ show: true }" x-show="show" class="mb-6 rounded-2xl bg-rose-50 border border-rose-200 p-4 flex items-start gap-3 shadow-xs" role="alert">
                            <div class="flex-shrink-0 w-8 h-8 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center font-bold">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <div class="flex-1 pt-0.5">
                                <h4 class="text-xs font-bold text-rose-900">Terjadi Kesalahan</h4>
                                @if (session('error'))
                                    <p class="text-xs text-rose-700 mt-0.5">{{ session('error') }}</p>
                                @endif
                                @if (isset($errors) && $errors->any())
                                    <ul class="mt-1.5 list-disc list-inside text-xs text-rose-700 space-y-0.5">
                                        @foreach ($errors->all() as $err)
                                            <li>{{ $err }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                            <button type="button" @click="show = false" class="text-rose-500 hover:text-rose-700 p-1 rounded-lg">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>
                    @endif

                    {{-- Konten Utama Halaman --}}
                    @yield('content')
                </div>
            </main>

            {{-- 3.3 Minimalist Executive Footer --}}
            <footer class="bg-white border-t border-slate-200 py-3.5 px-4 sm:px-6 lg:px-8 text-slate-500 text-[11px] flex flex-col sm:flex-row items-center justify-between gap-2">
                <div class="flex items-center gap-2">
                    <span class="font-semibold text-slate-700">Dinas Komunikasi dan Informatika Kab. Tasikmalaya</span>
                    <span class="text-slate-300">|</span>
                    <span>Portal Layanan Publik Terintegrasi</span>
                </div>
                <div>
                    <span>Standar Pelayanan Prima Digital &copy; {{ date('Y') }}</span>
                </div>
            </footer>

        </div>

    </div>

    {{-- SweetAlert2 Flash Trigger --}}
    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#0a2558',
                customClass: { popup: 'rounded-2xl shadow-xl' }
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                confirmButtonColor: '#e11d48',
                customClass: { popup: 'rounded-2xl shadow-xl' }
            });
        @endif
    </script>

    @stack('scripts')
</body>
</html>
