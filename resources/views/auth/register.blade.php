<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Pendaftaran Akun Warga — Portal Layanan Publik Terpadu Kabupaten Tasikmalaya">
    <title>Daftar Akun — Portal Layanan Publik Terintegrasi</title>

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

    {{-- Decorative Ambient Elements --}}
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
         MAIN REGISTER MODAL CARD
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <main class="my-auto py-6 flex items-center justify-center z-10">
        <div class="relative w-full max-w-[840px] bg-white rounded-2xl shadow-2xl p-6 sm:p-9 border border-slate-100 overflow-hidden">

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

                {{-- ── LEFT COLUMN: TAB NAVIGATION & GOOGLE REGISTER ── --}}
                <div class="md:col-span-4 flex flex-col space-y-3.5 pt-1">

                    {{-- Inactive Login Tab Button --}}
                    <a href="{{ route('login', request()->query()) }}"
                       class="w-full py-2.5 px-4 rounded-lg bg-[#f1f4f8] hover:bg-slate-200 text-slate-700 hover:text-slate-900 font-semibold text-sm text-center transition-colors">
                        Login
                    </a>

                    {{-- Active Register Tab Button --}}
                    <div class="w-full py-2.5 px-4 rounded-lg text-white font-bold text-sm text-center shadow-xs cursor-default select-none transition-all"
                         style="background: linear-gradient(90deg, #5185ec 0%, #ba588a 100%);">
                        Register
                    </div>

                    {{-- Switch Prompt Text --}}
                    <div class="pt-3 text-xs leading-relaxed">
                        <p class="text-slate-500 font-normal">Already have an account?</p>
                        <a href="{{ route('login', request()->query()) }}" class="font-bold text-slate-900 hover:text-blue-600 transition-colors inline-block mt-0.5">
                            Login
                        </a>
                    </div>

                    {{-- Google Sign-In Button --}}
                    <div class="pt-2">
                        <button type="button"
                                onclick="Swal.fire({ title: 'Google Sign-In', text: 'Fitur Registrasi dengan Akun Google sedang disiapkan oleh Diskominfo Kab. Tasikmalaya. Silakan lengkapi formulir pendaftaran akun pemohon.', icon: 'info', confirmButtonColor: '#3264e6', customClass: { popup: 'rounded-2xl shadow-2xl p-6' } })"
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
                        <span>Perlindungan Data Terenkripsi</span>
                    </div>

                </div>

                {{-- ── RIGHT COLUMN: REGISTER FORM FIELDS ── --}}
                <div class="md:col-span-8 flex flex-col justify-between pt-1">

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
                                <p class="font-bold text-rose-900">Pendaftaran Gagal</p>
                                <ul class="mt-0.5 space-y-0.5 text-rose-700">
                                    @foreach ($errors->all() as $err)
                                        <li>• {{ $err }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    {{-- Register Form --}}
                    <form method="POST" action="{{ route('register') }}" class="space-y-4" id="regForm">
                        @csrf

                        {{-- 2-Column Minimal Underline Inputs Grid --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">

                            {{-- First Name --}}
                            <div class="space-y-0.5">
                                <label for="nama_depan" class="block text-xs text-slate-500 font-medium">First Name</label>
                                <input
                                    type="text"
                                    id="nama_depan"
                                    name="nama_depan"
                                    value="{{ old('nama_depan') }}"
                                    placeholder="Contoh: Ahmad"
                                    required
                                    autofocus
                                    class="w-full border-b border-slate-300 focus:border-[#3264e6] py-1 text-sm text-slate-900 placeholder:text-slate-300 bg-transparent outline-none transition-colors font-medium"
                                >
                            </div>

                            {{-- Last Name --}}
                            <div class="space-y-0.5">
                                <label for="nama_belakang" class="block text-xs text-slate-500 font-medium">Last Name</label>
                                <input
                                    type="text"
                                    id="nama_belakang"
                                    name="nama_belakang"
                                    value="{{ old('nama_belakang') }}"
                                    placeholder="Contoh: Fauzi"
                                    class="w-full border-b border-slate-300 focus:border-[#3264e6] py-1 text-sm text-slate-900 placeholder:text-slate-300 bg-transparent outline-none transition-colors font-medium"
                                >
                            </div>

                            {{-- Email Address (Full Width in grid) --}}
                            <div class="sm:col-span-2 space-y-0.5">
                                <label for="email" class="block text-xs text-slate-500 font-medium">Email Address</label>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    placeholder="nama@email.com"
                                    required
                                    class="w-full border-b border-slate-300 focus:border-[#3264e6] py-1 text-sm text-slate-900 placeholder:text-slate-300 bg-transparent outline-none transition-colors font-medium"
                                >
                            </div>

                            {{-- Password with Eye Toggle --}}
                            <div class="space-y-0.5 relative">
                                <label for="password" class="block text-xs text-slate-500 font-medium">Password</label>
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    placeholder="Min. 6 karakter"
                                    required
                                    class="w-full border-b border-slate-300 focus:border-[#3264e6] py-1 pr-8 text-sm text-slate-900 placeholder:text-slate-300 bg-transparent outline-none transition-colors font-medium"
                                >
                                <button type="button"
                                        id="toggleRegPassword"
                                        class="absolute bottom-1 right-0 flex items-center text-slate-400 hover:text-slate-700 transition-colors cursor-pointer"
                                        title="Tampilkan / Sembunyikan Kata Sandi">
                                    <i data-lucide="eye" id="eyeIconReg" class="w-4 h-4"></i>
                                    <i data-lucide="eye-off" id="eyeOffIconReg" class="w-4 h-4 hidden"></i>
                                </button>
                            </div>

                            {{-- Confirm Password with Eye Toggle --}}
                            <div class="space-y-0.5 relative">
                                <label for="password_confirmation" class="block text-xs text-slate-500 font-medium">Confirm password</label>
                                <input
                                    type="password"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    placeholder="Ketik ulang password"
                                    required
                                    class="w-full border-b border-slate-300 focus:border-[#3264e6] py-1 pr-8 text-sm text-slate-900 placeholder:text-slate-300 bg-transparent outline-none transition-colors font-medium"
                                >
                                <button type="button"
                                        id="toggleRegConfirmPassword"
                                        class="absolute bottom-1 right-0 flex items-center text-slate-400 hover:text-slate-700 transition-colors cursor-pointer"
                                        title="Tampilkan / Sembunyikan Konfirmasi Sandi">
                                    <i data-lucide="eye" id="eyeIconConfirm" class="w-4 h-4"></i>
                                    <i data-lucide="eye-off" id="eyeOffIconConfirm" class="w-4 h-4 hidden"></i>
                                </button>
                            </div>

                        </div>

                        {{-- Checkbox Terms & Conditions --}}
                        <div class="pt-2">
                            <label class="flex items-start gap-2 cursor-pointer select-none">
                                <input type="checkbox"
                                       required
                                       checked
                                       class="w-3.5 h-3.5 mt-0.5 rounded border-slate-300 text-[#3264e6] focus:ring-[#3264e6] cursor-pointer">
                                <span class="text-xs text-slate-600 font-normal leading-relaxed">
                                    By clicking checkbox, you agree to our <a href="#" onclick="Swal.fire({ title: 'Terms and Conditions', text: 'Ketentuan dan Persyaratan Penggunaan Layanan Publik Terpadu Pemerintah Kabupaten Tasikmalaya.', icon: 'info', confirmButtonColor: '#3264e6' }); return false;" class="text-slate-900 font-bold hover:underline">Terms and Conditions</a> and <a href="#" onclick="Swal.fire({ title: 'Privacy Policy', text: 'Kebijakan Privasi Portal Layanan Publik Pemerintah Kabupaten Tasikmalaya.', icon: 'info', confirmButtonColor: '#3264e6' }); return false;" class="text-slate-900 font-bold hover:underline">Privacy Policy</a>
                                </span>
                            </label>
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
                                    <span>Membuat akun...</span>
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
         SCRIPTS: LUCIDE & PASSWORD TOGGLES & SUBMIT STATE
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) {
                window.lucide.createIcons();
            }
        });

        // Password Visibility Toggle
        const toggleRegPassword = document.getElementById('toggleRegPassword');
        const passwordInput     = document.getElementById('password');
        const eyeIconReg        = document.getElementById('eyeIconReg');
        const eyeOffIconReg     = document.getElementById('eyeOffIconReg');

        if (toggleRegPassword && passwordInput) {
            toggleRegPassword.addEventListener('click', () => {
                const isPass = passwordInput.type === 'password';
                passwordInput.type = isPass ? 'text' : 'password';
                eyeIconReg.classList.toggle('hidden', isPass);
                eyeOffIconReg.classList.toggle('hidden', !isPass);
            });
        }

        // Confirm Password Visibility Toggle
        const toggleRegConfirmPassword = document.getElementById('toggleRegConfirmPassword');
        const confirmPasswordInput     = document.getElementById('password_confirmation');
        const eyeIconConfirm           = document.getElementById('eyeIconConfirm');
        const eyeOffIconConfirm        = document.getElementById('eyeOffIconConfirm');

        if (toggleRegConfirmPassword && confirmPasswordInput) {
            toggleRegConfirmPassword.addEventListener('click', () => {
                const isPass = confirmPasswordInput.type === 'password';
                confirmPasswordInput.type = isPass ? 'text' : 'password';
                eyeIconConfirm.classList.toggle('hidden', isPass);
                eyeOffIconConfirm.classList.toggle('hidden', !isPass);
            });
        }

        // Submit Button Loading State
        const form      = document.getElementById('regForm');
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
