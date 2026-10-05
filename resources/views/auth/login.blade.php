<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Masuk ke Portal Layanan Publik Terpadu Kabupaten Tasikmalaya">
    <title>Masuk — Portal Layanan Publik Terintegrasi</title>

    {{-- Google Fonts: Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        body { letter-spacing: -0.01em; }
        [data-lucide] { display: inline-block; vertical-align: middle; }
    </style>
</head>
<body class="min-h-screen bg-slate-900/40 relative flex flex-col justify-between p-4 sm:p-6 select-none overflow-x-hidden">

    {{-- ═══════════════════════════════════════════════════════════════════════════
         UNDERLYING BACKDROP (BLURRED PORTAL LANDING AESTHETIC)
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="fixed inset-0 bg-gradient-to-br from-slate-100 via-slate-50 to-blue-50/40 -z-20"></div>

    {{-- Decorative Background Circles / Accents --}}
    <div class="fixed -top-24 -left-24 w-96 h-96 rounded-full bg-blue-400/20 blur-3xl pointer-events-none -z-10"></div>
    <div class="fixed -bottom-24 -right-24 w-96 h-96 rounded-full bg-rose-400/15 blur-3xl pointer-events-none -z-10"></div>
    <div class="fixed inset-0 bg-slate-900/25 backdrop-blur-[2px] -z-10 pointer-events-none"></div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         TOP BAR: BRAND LOGO & BACK TO HOME
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <header class="w-full max-w-6xl mx-auto flex items-center justify-between py-2 px-2 sm:px-4 z-20">
        <a href="{{ url('/') }}" class="flex items-center gap-3 group">
            <img src="{{ asset('images/logo.png') }}" alt="Dishub Kominfo Kab. Tasikmalaya" class="h-9 sm:h-10 w-auto object-contain bg-white/90 px-2 py-1 rounded-xl shadow-xs">
        </a>

        <a href="{{ url('/') }}"
           class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/90 hover:bg-white text-slate-700 hover:text-slate-950 text-xs font-semibold shadow-xs border border-slate-200/80 transition-all cursor-pointer">
            <span>Kembali ke Beranda</span>
            <svg class="w-3.5 h-3.5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </a>
    </header>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         MAIN LOGIN MODAL CARD
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <main class="my-auto py-6 flex items-center justify-center z-10">
        <div class="relative w-full max-w-[760px] bg-white rounded-2xl shadow-2xl p-6 sm:p-9 border border-slate-100 overflow-hidden">
            
            {{-- Quick Close Button --}}
            <a href="{{ url('/') }}"
               class="absolute top-4 right-4 sm:top-5 sm:right-5 w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-800 flex items-center justify-center transition-colors cursor-pointer"
               title="Tutup dan kembali ke Halaman Utama">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </a>

            {{-- 2-Column Grid Layout matching Reference Image --}}
            <div class="grid grid-cols-1 md:grid-cols-12 gap-7 md:gap-9 items-start select-text">

                {{-- ── LEFT COLUMN: TAB NAVIGATION & GOOGLE SIGN-IN ── --}}
                <div class="md:col-span-5 flex flex-col space-y-3.5 pt-1">
                    
                    {{-- Active Login Tab Button --}}
                    <div class="w-full py-2.5 px-4 rounded-lg text-white font-bold text-sm text-center shadow-xs cursor-default select-none transition-all"
                         style="background: linear-gradient(90deg, #5185ec 0%, #ba588a 100%);">
                        Login
                    </div>

                    {{-- Inactive Register Tab Button --}}
                    <a href="{{ route('register', request()->query()) }}"
                       class="w-full py-2.5 px-4 rounded-lg bg-[#f1f4f8] hover:bg-slate-200 text-slate-700 hover:text-slate-900 font-semibold text-sm text-center transition-colors">
                        Register
                    </a>

                    {{-- Switch Prompt Text --}}
                    <div class="pt-3 text-xs leading-relaxed">
                        <p class="text-slate-500 font-normal">Don't have an account?</p>
                        <a href="{{ route('register', request()->query()) }}" class="font-bold text-slate-900 hover:text-blue-600 transition-colors inline-block mt-0.5">
                            Register Now!
                        </a>
                    </div>

                    {{-- Google Sign-In Button --}}
                    <div class="pt-2">
                        <button type="button"
                                onclick="Swal.fire({ title: 'Google Sign-In', text: 'Fitur Masuk dengan Akun Google sedang disiapkan oleh Diskominfo Kab. Tasikmalaya. Silakan masuk menggunakan Email / NIK dan kata sandi Anda.', icon: 'info', confirmButtonColor: '#3264e6', customClass: { popup: 'rounded-2xl shadow-2xl p-6' } })"
                                class="w-full py-2.5 px-3 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 flex items-center justify-center gap-2.5 shadow-2xs transition-all cursor-pointer group">
                            {{-- Google 'G' Icon --}}
                            <svg class="w-4 h-4 flex-shrink-0" viewBox="0 0 24 24">
                                <path fill="#4285F4" d="M23.745 12.27c0-.7-.06-1.4-.19-2.07H12v4.51h6.6c-.29 1.52-1.14 2.82-2.4 3.68v3.05h3.88c2.27-2.09 3.66-5.17 3.66-9.17z"/>
                                <path fill="#34A853" d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.88-3.05c-1.08.72-2.45 1.16-4.05 1.16-3.12 0-5.77-2.1-6.72-4.93H1.25v3.15C3.26 21.36 7.33 24 12 24z"/>
                                <path fill="#FBBC05" d="M5.28 14.27c-.25-.72-.38-1.49-.38-2.27s.13-1.55.38-2.27V6.58H1.25C.45 8.18 0 9.99 0 12s.45 3.82 1.25 5.42l4.03-3.15z"/>
                                <path fill="#EA4335" d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.33 0 3.26 2.64 1.25 6.58l4.03 3.15c.95-2.83 3.6-4.98 6.72-4.98z"/>
                            </svg>
                            <span class="text-[11px] font-bold tracking-wider uppercase text-slate-700 group-hover:text-slate-900">
                                CONTINUE WITH GOOGLE
                            </span>
                        </button>
                    </div>

                    {{-- Security Badge Note --}}
                    <div class="pt-2 text-[11px] text-slate-400 flex items-center gap-1.5">
                        <i data-lucide="shield-check" class="w-3.5 h-3.5 text-emerald-600"></i>
                        <span>Enkripsi Resmi SSL 256-bit</span>
                    </div>

                </div>

                {{-- ── RIGHT COLUMN: LOGIN FORM FIELDS ── --}}
                <div class="md:col-span-7 flex flex-col justify-between pt-1">

                    {{-- Intended Service Banner --}}
                    @if (isset($intendedService) && $intendedService)
                        <div class="mb-3 px-3.5 py-2 rounded-xl bg-blue-50 border border-blue-200/90 text-xs text-[#0a2558] flex items-center justify-between shadow-2xs">
                            <div class="truncate mr-2">
                                <span class="text-[10px] uppercase font-bold text-blue-700 block">Layanan Terpilih:</span>
                                <strong class="truncate block text-slate-900">{{ $intendedService->nama_layanan }}</strong>
                            </div>
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-md bg-white border border-blue-200 text-blue-800 flex-shrink-0">
                                {{ $intendedService->kode_layanan }}
                            </span>
                        </div>
                    @endif

                    {{-- Error Alert --}}
                    @if ($errors->any())
                        <div class="mb-3.5 p-3 rounded-xl bg-rose-50 border border-rose-200 text-xs text-rose-800 flex items-start gap-2.5 shadow-2xs" role="alert">
                            <i data-lucide="alert-circle" class="w-4 h-4 text-rose-600 flex-shrink-0 mt-0.5"></i>
                            <div>
                                <p class="font-bold text-rose-900">Login Gagal</p>
                                <p class="text-rose-700 mt-0.5">{{ $errors->first() }}</p>
                            </div>
                        </div>
                    @endif

                    {{-- Success Alert --}}
                    @if (session('success'))
                        <div class="mb-3.5 p-3 rounded-xl bg-emerald-50 border border-emerald-200 text-xs text-emerald-800 flex items-center gap-2.5 shadow-2xs">
                            <i data-lucide="check-circle" class="w-4 h-4 text-emerald-600 flex-shrink-0"></i>
                            <p class="font-semibold">{{ session('success') }}</p>
                        </div>
                    @endif

                    {{-- Login Form --}}
                    <form method="POST" action="{{ route('login') }}" class="space-y-3.5" id="loginForm">
                        @csrf

                        {{-- Email / NIK Input --}}
                        <div class="space-y-1">
                            <input
                                type="text"
                                id="login"
                                name="login"
                                value="{{ old('login') }}"
                                placeholder="rifafauzi044@gmail.com"
                                required
                                autofocus
                                class="w-full px-4 py-2.5 rounded-lg bg-[#edf3fa] text-slate-900 placeholder:text-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-[#3264e6]/30 font-medium transition-all"
                            >
                        </div>

                        {{-- Password Input with Eye Toggle --}}
                        <div class="space-y-1 relative">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="••••••••"
                                required
                                class="w-full px-4 py-2.5 pr-11 rounded-lg bg-[#edf3fa] text-slate-900 placeholder:text-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-[#3264e6]/30 font-medium transition-all"
                            >
                            <button type="button"
                                    id="togglePassword"
                                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-500 hover:text-slate-800 transition-colors cursor-pointer"
                                    title="Tampilkan / Sembunyikan Kata Sandi">
                                <i data-lucide="eye" id="eyeIcon" class="w-4 h-4"></i>
                                <i data-lucide="eye-off" id="eyeOffIcon" class="w-4 h-4 hidden"></i>
                            </button>
                        </div>

                        {{-- Remember Me & Forget Password Row --}}
                        <div class="flex items-center justify-between pt-1 text-xs">
                            <label class="flex items-center gap-2 cursor-pointer select-none text-slate-700">
                                <input type="checkbox"
                                       name="remember"
                                       id="remember"
                                       class="w-3.5 h-3.5 rounded border-slate-300 text-[#3264e6] focus:ring-[#3264e6] cursor-pointer">
                                <span class="text-xs text-slate-700 font-medium">Remember me</span>
                            </label>

                            <a href="#"
                               onclick="Swal.fire({ title: 'Lupa Kata Sandi?', text: 'Silakan hubungi administrator Dinas Kominfo Kabupaten Tasikmalaya atau hubungi Call Center 112 untuk verifikasi identitas dan bantuan pemulihan kata sandi akun Anda.', icon: 'info', confirmButtonColor: '#3264e6', customClass: { popup: 'rounded-2xl shadow-2xl p-6' } }); return false;"
                               class="text-xs font-bold text-slate-900 hover:text-blue-600 transition-colors">
                                Forget Password?
                            </a>
                        </div>

                        {{-- Submit Button --}}
                        <div class="pt-2">
                            <button
                                type="submit"
                                id="submitBtn"
                                class="w-full py-2.5 sm:py-3 px-4 rounded-lg bg-[#3264e6] hover:bg-[#2552c7] text-white font-bold text-sm shadow-md shadow-blue-500/25 hover:shadow-lg transition-all flex items-center justify-center gap-2 cursor-pointer"
                            >
                                <span id="btnText">Submit</span>
                                <span id="btnLoading" class="hidden items-center gap-2">
                                    <i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i>
                                    <span>Memverifikasi...</span>
                                </span>
                            </button>
                        </div>
                    </form>

                </div>

            </div>

        </div>
    </main>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         FLOATING ASSISTANT BADGE WIDGET (BOTTOM-RIGHT)
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <footer class="w-full max-w-6xl mx-auto flex items-center justify-between text-xs text-slate-500 py-2 px-4 z-20">
        <div class="text-[11px] text-slate-400">
            &copy; {{ date('Y') }} Dinas Komunikasi dan Informatika Kabupaten Tasikmalaya
        </div>

        <div class="bg-white/95 backdrop-blur-md border border-slate-200/80 rounded-2xl p-2 sm:px-3 sm:py-2 shadow-lg flex items-center gap-2.5 pointer-events-auto">
            <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0">
                <i data-lucide="message-square-heart" class="w-4 h-4 text-blue-600"></i>
            </div>
            <div class="hidden sm:block text-left text-[11px] leading-tight">
                <p class="font-bold text-slate-800">Hi! Butuh bantuan layanan?</p>
                <p class="text-slate-500">Konsultasi & Pengaduan Warga</p>
            </div>
        </div>
    </footer>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         SCRIPTS: LUCIDE & PASSWORD TOGGLE & SUBMIT STATE
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) {
                window.lucide.createIcons();
            }
        });

        // Password Visibility Toggle
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput  = document.getElementById('password');
        const eyeIcon        = document.getElementById('eyeIcon');
        const eyeOffIcon     = document.getElementById('eyeOffIcon');

        if (togglePassword && passwordInput) {
            togglePassword.addEventListener('click', () => {
                const isPass = passwordInput.type === 'password';
                passwordInput.type = isPass ? 'text' : 'password';
                eyeIcon.classList.toggle('hidden', isPass);
                eyeOffIcon.classList.toggle('hidden', !isPass);
            });
        }

        // Submit Button Loading State
        const form      = document.getElementById('loginForm');
        const btnText   = document.getElementById('btnText');
        const btnLoad   = document.getElementById('btnLoading');
        const submitBtn = document.getElementById('submitBtn');

        if (form && submitBtn) {
            form.addEventListener('submit', () => {
                btnText.classList.add('hidden');
                btnLoad.classList.remove('hidden');
                btnLoad.classList.add('flex');
                submitBtn.disabled = true;
            });
        }
    </script>
</body>
</html>
