<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Portal Layanan Publik Terintegrasi') — Kab. Tasikmalaya</title>

    {{-- Fonts Google --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Tailwind CSS compiled via Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Alpine.js for lightweight UI interactivity --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>

    @stack('styles')
</head>
<body class="h-full flex flex-col antialiased text-slate-800 bg-slate-50 selection:bg-[#0a2558] selection:text-white" x-data="{ mobileMenuOpen: false }">

    {{-- Top Bar Government Identity --}}
    <div class="bg-gradient-to-r from-[#0a2558] via-[#0f2d6b] to-[#0a2558] text-slate-200 text-xs py-1.5 px-4 sm:px-6 lg:px-8 border-b border-blue-900/40">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="inline-block w-2 h-2 rounded-full bg-sky-400 animate-pulse"></span>
                <span class="font-medium tracking-wide">Portal Resmi Pelayanan Administrasi Masyarakat Terintegrasi — 39 Kecamatan</span>
            </div>
            <div class="hidden sm:flex items-center gap-4 text-[11px] text-slate-400">
                <span>Dinas Kominfo Kab. Tasikmalaya</span>
                <span class="text-slate-600">|</span>
                <span>Standar Pelayanan Prima Digital</span>
            </div>
        </div>
    </div>

    {{-- Main Navbar --}}
    @include('layouts.navigation')

    {{-- Flash Notifications (Success / Error / Info) --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4 w-full">
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-transition.duration.300ms class="mb-4 rounded-xl bg-emerald-50 border border-emerald-200 p-4 flex items-start gap-3 shadow-sm" role="alert">
                <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                </div>
                <div class="flex-1 pt-0.5">
                    <h3 class="text-sm font-semibold text-emerald-900">Operasi Berhasil</h3>
                    <p class="text-sm text-emerald-700 mt-0.5">{{ session('success') }}</p>
                </div>
                <button type="button" @click="show = false" class="text-emerald-500 hover:text-emerald-700 p-1 rounded-lg">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
        @endif

        @if (session('warning'))
            <div x-data="{ show: true }" x-show="show" class="mb-4 rounded-xl bg-amber-50 border border-amber-200 p-4 flex items-start gap-3 shadow-sm" role="alert">
                <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                </div>
                <div class="flex-1 pt-0.5">
                    <h3 class="text-sm font-semibold text-amber-900">Perhatian</h3>
                    <p class="text-sm text-amber-800 mt-0.5">{{ session('warning') }}</p>
                </div>
                <button type="button" @click="show = false" class="text-amber-600 hover:text-amber-800 p-1 rounded-lg">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
        @endif

        @if (session('error') || $errors->any())
            <div x-data="{ show: true }" x-show="show" class="mb-4 rounded-xl bg-rose-50 border border-rose-200 p-4 flex items-start gap-3 shadow-sm" role="alert">
                <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-rose-100 text-rose-600 flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <div class="flex-1 pt-0.5">
                    <h3 class="text-sm font-semibold text-rose-900">Terjadi Kesalahan</h3>
                    @if (session('error'))
                        <p class="text-sm text-rose-700 mt-0.5">{{ session('error') }}</p>
                    @endif
                    @if ($errors->any())
                        <ul class="mt-1 list-disc list-inside text-xs text-rose-700 space-y-0.5">
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
    </div>

    {{-- Main Content Area --}}
    <main class="flex-1 pb-16">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('layouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
