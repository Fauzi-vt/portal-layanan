<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard Warga') — Portal Layanan Publik</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>

    <style>
        * { font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-[#f4f7fb] text-slate-800 flex flex-col" x-data="{ sidebarOpen: false, userDropdown: false }">

    {{-- ═══════════════════════════════════════════════════════════════════════════
         TOP NAVBAR (Komdigi Clean Header)
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <header class="bg-white border-b border-slate-200 sticky top-0 z-40 shadow-xs">
        <div class="px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            
            {{-- Left: Logo KOMDIGI / Diskominfo --}}
            <div class="flex items-center gap-4">
                {{-- Mobile toggle --}}
                <button type="button" @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 rounded-lg text-slate-600 hover:bg-slate-100">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>

                <a href="{{ route('warga.dashboard') }}" class="flex items-center">
                    <img src="{{ asset('images/logo2.png') }}" alt="Dishub Kominfo - Portal Layanan Publik" class="h-8 sm:h-9 w-auto max-h-9 object-contain">
                </a>
            </div>

            {{-- Right: Notification Bell & User Profile --}}
            <div class="flex items-center gap-5">
                {{-- Notification Bell --}}
                <button type="button" class="relative text-slate-500 hover:text-slate-700 p-1.5 rounded-full hover:bg-slate-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    @if (auth()->user()->submissions()->where('status', \App\Enums\SubmissionStatus::RevisionRequired)->count() > 0)
                        <span class="absolute top-1 right-1 w-2 h-2 rounded-full bg-amber-500 animate-ping"></span>
                        <span class="absolute top-1 right-1 w-2 h-2 rounded-full bg-amber-500"></span>
                    @endif
                </button>

                {{-- User Avatar & Name Dropdown --}}
                <div class="relative" @click.outside="userDropdown = false">
                    <button type="button" @click="userDropdown = !userDropdown" class="flex items-center gap-2.5 p-1 rounded-lg hover:bg-slate-50 transition-colors cursor-pointer">
                        {{-- Circular Avatar --}}
                        <div class="w-8 h-8 rounded-full bg-teal-500 text-white flex items-center justify-center font-bold text-xs shadow-xs">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <span class="text-xs font-semibold text-slate-800 hidden sm:inline-block max-w-[150px] truncate">
                            {{ auth()->user()->name }}
                        </span>
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </button>

                    {{-- Dropdown Menu --}}
                    <div x-show="userDropdown" x-transition.origin.top.right class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-slate-100 py-1 text-xs text-slate-700 z-50 divide-y divide-slate-100" style="display: none;">
                        <div class="px-4 py-2.5">
                            <p class="font-bold text-slate-900 truncate">{{ auth()->user()->name }}</p>
                            <p class="text-slate-500 font-mono mt-0.5">{{ auth()->user()->email }}</p>
                            <p class="text-[10px] text-teal-600 font-semibold mt-1">Kec. {{ auth()->user()->kecamatan?->nama_kecamatan ?? '-' }}</p>
                        </div>
                        <div class="py-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-rose-600 hover:bg-rose-50 font-semibold flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
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
         MAIN WRAPPER: SIDEBAR + CONTENT
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="flex-1 flex overflow-hidden">

        {{-- ── Left Sidebar (Exact Figma Match) ─────────── --}}
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
               class="fixed lg:static inset-y-0 left-0 z-30 w-64 bg-white border-r border-slate-200/80 transition-transform duration-200 ease-in-out flex flex-col justify-between py-6 px-4 shrink-0 overflow-y-auto">
            
            <div class="space-y-6">
                
                {{-- Top Sidebar Logo (From Figma) --}}
                <div class="px-2 pb-4 mb-2 border-b border-slate-100">
                    <a href="{{ route('warga.dashboard') }}" class="block">
                        <img src="{{ asset('images/logo.png') }}" alt="Dishub Kominfo" class="h-10 w-auto max-h-11 object-contain">
                    </a>
                </div>

                {{-- Group 1: DASHBOARD --}}
                <div class="space-y-1.5">
                    <p class="text-xs font-extrabold text-[#0a2558] tracking-wider uppercase px-3 mb-2 font-serif">
                        DASHBOARD
                    </p>
                    <a href="{{ route('warga.dashboard') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-semibold transition-colors {{ request()->routeIs('warga.dashboard') ? 'bg-[#f0f2f5] text-slate-900 border-l-4 border-[#0a2558] pl-2 font-bold' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('warga.dashboard') ? 'text-[#0a2558]' : 'text-slate-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span>Dashboard</span>
                    </a>
                </div>

                {{-- Group 2: PERMOHONAN --}}
                <div class="space-y-1.5">
                    <p class="text-xs font-extrabold text-[#0a2558] tracking-wider uppercase px-3 mb-2 font-serif">
                        PERMOHONAN
                    </p>
                    
                    {{-- Tambah Permohonan --}}
                    <a href="{{ route('warga.submissions.create') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('warga.submissions.create') ? 'bg-[#f0f2f5] text-slate-900 border-l-4 border-[#0a2558] pl-2 font-bold' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Tambah Permohonan</span>
                    </a>

                    {{-- Daftar Permohonan Dropdown --}}
                    <div x-data="{ openPermohonan: {{ request()->routeIs('warga.submissions.*') ? 'true' : 'false' }} }" class="space-y-1">
                        <button type="button"
                                @click="openPermohonan = !openPermohonan"
                                class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('warga.submissions.*') ? 'bg-[#f0f2f5] text-slate-900 font-bold' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-900' }}">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 {{ request()->routeIs('warga.submissions.*') ? 'text-[#0a2558]' : 'text-slate-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                <span>Daftar Permohonan</span>
                            </div>
                            <svg class="w-4 h-4 text-slate-400 transition-transform duration-200"
                                 :class="{ 'rotate-180 text-blue-600': openPermohonan }"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        {{-- Submenu: Terkirim, Ditolak, Terbit --}}
                        <div x-show="openPermohonan"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="opacity-0 -translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             class="pl-9 pr-2 py-1 space-y-1">

                            {{-- Terkirim --}}
                            <a href="{{ route('warga.submissions.index', ['status' => 'submitted']) }}"
                               class="flex items-center justify-between px-3 py-1.5 rounded-lg text-xs font-medium transition-colors {{ request()->routeIs('warga.submissions.index') && request('status') === 'submitted' ? 'bg-blue-100/70 text-blue-800 font-bold' : 'text-slate-600 hover:text-blue-700 hover:bg-slate-50' }}">
                                <span>Terkirim</span>
                            </a>

                            {{-- Ditolak --}}
                            <a href="{{ route('warga.submissions.index', ['status' => 'rejected']) }}"
                               class="flex items-center justify-between px-3 py-1.5 rounded-lg text-xs font-medium transition-colors {{ request()->routeIs('warga.submissions.index') && request('status') === 'rejected' ? 'bg-rose-100/70 text-rose-800 font-bold' : 'text-slate-600 hover:text-rose-700 hover:bg-slate-50' }}">
                                <span>Ditolak</span>
                            </a>

                            {{-- Terbit --}}
                            <a href="{{ route('warga.submissions.index', ['status' => 'completed']) }}"
                               class="flex items-center justify-between px-3 py-1.5 rounded-lg text-xs font-medium transition-colors {{ request()->routeIs('warga.submissions.index') && request('status') === 'completed' ? 'bg-emerald-100/70 text-emerald-800 font-bold' : 'text-slate-600 hover:text-emerald-700 hover:bg-slate-50' }}">
                                <span>Terbit</span>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Group 3: LAINNYA --}}
                <div class="space-y-1.5">
                    <p class="text-xs font-extrabold text-[#0a2558] tracking-wider uppercase px-3 mb-2 font-serif">
                        LAINNYA
                    </p>
                    <a href="{{ url('/') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors">
                        <svg class="w-5 h-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Bantuan & FAQ</span>
                    </a>
                </div>

            </div>

            {{-- Sidebar Footer --}}
            <div class="pt-4 border-t border-slate-100 text-[11px] text-slate-400 text-center">
                <span>&copy; {{ date('Y') }} KOMDIGI / Pemkab</span>
            </div>
        </aside>

        {{-- Backdrop for mobile --}}
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-slate-900/40 z-20 lg:hidden" style="display: none;"></div>

        {{-- ── Main Content Area (Light grey background #f4f7fb) ──────────────── --}}
        <main class="flex-1 p-6 sm:p-8 lg:p-10 overflow-y-auto max-w-7xl mx-auto w-full">
            
            {{-- Flash Notifications --}}
            @if (session('success'))
                <div class="mb-6 rounded-xl bg-emerald-50 border border-emerald-200 p-4 flex items-center gap-3 text-xs text-emerald-800 font-semibold shadow-xs">
                    <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if (session('warning'))
                <div class="mb-6 rounded-xl bg-amber-50 border border-amber-200 p-4 flex items-center gap-3 text-xs text-amber-800 font-semibold shadow-xs">
                    <svg class="w-5 h-5 text-amber-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <span>{{ session('warning') }}</span>
                </div>
            @endif

            @yield('content')
        </main>

    </div>

</body>
</html>
