<nav class="bg-white border-b border-slate-200 sticky top-0 z-40 portal-shadow" x-data="{ userMenuOpen: false, mobileMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            {{-- Brand Logo & Title --}}
            <div class="flex items-center gap-4">
                <a href="{{ auth()->check() ? route('dashboard') : url('/') }}" class="flex items-center group">
                    <img src="{{ asset('images/logo2.png') }}" alt="Dishub Kominfo - Portal Layanan Publik" class="h-9 sm:h-10 md:h-11 w-auto max-h-11 object-contain transition-transform group-hover:scale-[1.01]">
                </a>

                {{-- Role / Workspace Badge --}}
                @auth
                    <div class="hidden md:flex items-center ml-2">
                        @if (auth()->user()->isSuperAdmin())
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 border border-blue-200">
                                👑 Super Admin Diskominfo
                            </span>
                        @elseif (auth()->user()->isAdminKecamatan())
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-[#0a2558] border border-blue-200">
                                🏛️ Admin Kec. {{ auth()->user()->kecamatan?->nama_kecamatan ?? '-' }}
                            </span>
                        @elseif (auth()->user()->isAdminDesa())
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 border border-amber-200">
                                🏡 Kasi Pelayanan Desa {{ auth()->user()->desa?->nama_desa ?? '-' }}
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-sky-100 text-sky-800 border border-sky-200">
                                👤 Warga ({{ auth()->user()->kecamatan?->nama_kecamatan ?? 'Kabupaten' }})
                            </span>
                        @endif
                    </div>
                @endauth
            </div>

            {{-- Desktop Navigation Links --}}
            <div class="hidden md:flex md:items-center md:space-x-1">
                @auth
                    @if (auth()->user()->isWarga())
                        {{-- Warga Links --}}
                        <a href="{{ route('warga.dashboard') }}"
                           class="px-3.5 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('warga.dashboard') ? 'bg-teal-50 text-teal-700 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                            Dashboard
                        </a>
                        <a href="{{ route('warga.submissions.create') }}"
                           class="px-3.5 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('warga.submissions.create') ? 'bg-teal-50 text-teal-700 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                            + Ajukan Permohonan
                        </a>
                        <a href="{{ route('warga.submissions.index') }}"
                           class="px-3.5 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('warga.submissions.index') || request()->routeIs('warga.submissions.show') ? 'bg-teal-50 text-teal-700 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                            Riwayat & Tracking
                        </a>

                    @elseif (auth()->user()->isAdminDesa())
                        {{-- Admin Desa Links --}}
                        <a href="{{ route('desa.dashboard') }}"
                           class="px-3.5 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('desa.dashboard') ? 'bg-amber-50 text-amber-800 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                            Dashboard
                        </a>
                        <a href="{{ route('desa.submissions.index') }}"
                           class="px-3.5 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('desa.submissions.*') ? 'bg-amber-50 text-amber-800 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                            Verifikasi Berkas Desa
                        </a>
                        <a href="{{ route('desa.wilayah.index') }}"
                           class="px-3.5 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('desa.wilayah.*') ? 'bg-amber-50 text-amber-800 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                            Data Wilayah Desa
                        </a>

                    @elseif (auth()->user()->isAdminKecamatan())
                        {{-- Admin Kecamatan Links --}}
                        <a href="{{ route('kecamatan.dashboard') }}"
                           class="px-3.5 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('kecamatan.dashboard') ? 'bg-blue-50 text-[#0a2558] font-bold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                            Dashboard
                        </a>
                        <a href="{{ route('kecamatan.submissions.index') }}"
                           class="px-3.5 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('kecamatan.submissions.*') ? 'bg-blue-50 text-[#0a2558] font-bold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                            Meja Verifikasi Berkas
                        </a>
                        <a href="{{ route('kecamatan.wilayah.index') }}"
                           class="px-3.5 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('kecamatan.wilayah.*') ? 'bg-blue-50 text-[#0a2558] font-bold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                            Kewilayahan & Desa
                        </a>

                    @elseif (auth()->user()->isSuperAdmin())
                        {{-- Super Admin Links --}}
                        <a href="{{ route('superadmin.dashboard') }}"
                           class="px-3.5 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('superadmin.dashboard') ? 'bg-blue-50 text-[#0a2558] font-bold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                            Monitoring Global (39 Kec)
                        </a>
                        <a href="{{ route('superadmin.services.index') }}"
                           class="px-3.5 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('superadmin.services.*') ? 'bg-blue-50 text-[#0a2558] font-bold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                            Kelola Layanan Publik
                        </a>
                        <a href="{{ route('superadmin.wilayah.index') }}"
                           class="px-3.5 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('superadmin.wilayah.*') ? 'bg-blue-50 text-[#0a2558] font-bold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                            Master Wilayah (39 Kec)
                        </a>
                    @endif

                    {{-- User Dropdown Menu --}}
                    <div class="relative ml-3" @click.outside="userMenuOpen = false">
                        <button type="button" @click="userMenuOpen = !userMenuOpen" class="flex items-center gap-2.5 p-1.5 pl-3 rounded-full hover:bg-slate-100 text-sm font-medium text-slate-700 border border-slate-200">
                            <span class="w-7 h-7 rounded-full bg-gradient-to-br from-[#0a2558] to-[#1e5799] text-white font-bold flex items-center justify-center text-xs shadow-xs">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </span>
                            <span class="text-xs font-semibold text-slate-700 hidden lg:inline">{{ auth()->user()->name }}</span>
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>

                        <div x-show="userMenuOpen" x-transition.origin.top.right class="absolute right-0 mt-2 w-56 bg-white rounded-2xl border border-slate-200 shadow-xl py-2 z-50 divide-y divide-slate-100" style="display: none;">
                            <div class="px-4 py-2.5">
                                <p class="text-xs text-slate-500">Masuk sebagai:</p>
                                <p class="text-xs font-bold text-slate-900 truncate">{{ auth()->user()->email }}</p>
                                <p class="text-[10px] font-semibold text-[#0a2558] mt-0.5">{{ auth()->user()->role_label }}</p>
                            </div>
                            <div class="py-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-xs font-medium text-rose-600 hover:bg-rose-50 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                                        Keluar (Logout)
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                @else
                    {{-- Guest Links --}}
                    <a href="{{ url('/') }}" class="px-3.5 py-2 rounded-lg text-sm font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-50">Beranda</a>
                    <a href="{{ route('login') }}" class="ml-2 inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-[#0a2558] to-[#1e5799] hover:from-[#102a5c] hover:to-[#2563eb] shadow-sm transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                        Masuk / Login
                    </a>
                @endauth
            </div>

            {{-- Mobile Menu Button --}}
            <div class="flex md:hidden items-center">
                <button type="button" @click="mobileMenuOpen = !mobileMenuOpen" class="p-2 rounded-lg text-slate-600 hover:text-slate-900 hover:bg-slate-100">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" style="display: none;" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu Dropdown --}}
    <div x-show="mobileMenuOpen" class="md:hidden border-t border-slate-200 bg-white px-4 pt-2 pb-4 space-y-1 shadow-lg" style="display: none;">
        @auth
            <div class="pb-3 pt-2 border-b border-slate-100">
                <p class="font-bold text-slate-900">{{ auth()->user()->name }}</p>
                <p class="text-xs font-semibold text-[#0a2558]">{{ auth()->user()->role_label }}</p>
            </div>

            @if (auth()->user()->isWarga())
                <a href="{{ route('warga.dashboard') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 hover:bg-slate-50">Dashboard</a>
                <a href="{{ route('warga.submissions.create') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 hover:bg-slate-50">+ Ajukan Permohonan</a>
                <a href="{{ route('warga.submissions.index') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 hover:bg-slate-50">Riwayat & Tracking</a>
            @elseif (auth()->user()->isAdminDesa())
                <a href="{{ route('desa.dashboard') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 hover:bg-slate-50">Dashboard</a>
                <a href="{{ route('desa.submissions.index') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 hover:bg-slate-50">Verifikasi Berkas Desa</a>
                <a href="{{ route('desa.wilayah.index') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 hover:bg-slate-50">Data Wilayah Desa</a>
            @elseif (auth()->user()->isAdminKecamatan())
                <a href="{{ route('kecamatan.dashboard') }}" class="block px-3 py-2 rounded-lg text-base font-semibold {{ request()->routeIs('kecamatan.dashboard') ? 'bg-blue-50 text-[#0a2558]' : 'text-slate-700 hover:bg-slate-50' }}">Dashboard</a>
                <a href="{{ route('kecamatan.submissions.index') }}" class="block px-3 py-2 rounded-lg text-base font-semibold {{ request()->routeIs('kecamatan.submissions.*') ? 'bg-blue-50 text-[#0a2558]' : 'text-slate-700 hover:bg-slate-50' }}">Meja Verifikasi Berkas</a>
                <a href="{{ route('kecamatan.wilayah.index') }}" class="block px-3 py-2 rounded-lg text-base font-semibold {{ request()->routeIs('kecamatan.wilayah.*') ? 'bg-blue-50 text-[#0a2558]' : 'text-slate-700 hover:bg-slate-50' }}">Kewilayahan & Desa</a>
            @elseif (auth()->user()->isSuperAdmin())
                <a href="{{ route('superadmin.dashboard') }}" class="block px-3 py-2 rounded-lg text-base font-semibold {{ request()->routeIs('superadmin.dashboard') ? 'bg-blue-50 text-[#0a2558]' : 'text-slate-700 hover:bg-slate-50' }}">Monitoring Global</a>
                <a href="{{ route('superadmin.services.index') }}" class="block px-3 py-2 rounded-lg text-base font-semibold {{ request()->routeIs('superadmin.services.*') ? 'bg-blue-50 text-[#0a2558]' : 'text-slate-700 hover:bg-slate-50' }}">Kelola Layanan Publik</a>
                <a href="{{ route('superadmin.wilayah.index') }}" class="block px-3 py-2 rounded-lg text-base font-semibold {{ request()->routeIs('superadmin.wilayah.*') ? 'bg-blue-50 text-[#0a2558]' : 'text-slate-700 hover:bg-slate-50' }}">Master Wilayah (39 Kec)</a>
            @endif

            <form method="POST" action="{{ route('logout') }}" class="pt-2 border-t border-slate-100">
                @csrf
                <button type="submit" class="w-full text-left px-3 py-2 text-rose-600 font-semibold text-sm">Keluar (Logout)</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="block text-center px-4 py-2.5 rounded-xl font-semibold text-white bg-gradient-to-r from-[#0a2558] to-[#1e5799]">Masuk / Login</a>
        @endauth
    </div>
</nav>
