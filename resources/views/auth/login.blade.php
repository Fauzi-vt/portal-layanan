<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Masuk ke Portal Layanan Publik Terpadu">
    <title>Masuk — Portal Layanan Publik</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * { font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }

        .bg-komdigi-blue {
            background-color: #0b256b;
            background: linear-gradient(135deg, #091f58 0%, #0b256b 60%, #0d348a 100%);
        }

        .input-komdigi {
            background-color: #f0f4f9;
            border: 1px solid #dce4ee;
            color: #1e293b;
        }

        .input-komdigi:focus {
            background-color: #ffffff;
            border-color: #0b256b;
            box-shadow: 0 0 0 2px rgba(11, 37, 107, 0.15);
            outline: none;
        }

        .btn-komdigi-active {
            background-color: #0b256b;
            color: #ffffff;
            transition: all 0.2s ease;
        }
        .btn-komdigi-active:hover {
            background-color: #081c52;
        }

        .btn-komdigi-disabled {
            background-color: #a8a8a8;
            color: #ffffff;
        }

        /* Halftone gold dot pattern */
        .gold-dots {
            background-image: radial-gradient(#f59e0b 2px, transparent 2px);
            background-size: 16px 16px;
        }
    </style>
</head>
<body class="min-h-screen bg-white flex flex-col justify-between">

    <div class="min-h-screen grid grid-cols-1 lg:grid-cols-12 w-full">

        {{-- ═══════════════════════════════════════════════════════════════════════
             LEFT COLUMN — LOGIN FORM (Komdigi Blue Background)
        ═══════════════════════════════════════════════════════════════════════ --}}
        <div class="lg:col-span-6 bg-komdigi-blue text-white flex flex-col justify-center px-8 sm:px-14 lg:px-20 py-12 relative shadow-2xl">
            <div class="max-w-md w-full mx-auto space-y-6 relative z-10">

                {{-- Heading --}}
                <div>
                    <h1 class="text-4xl font-extrabold text-white tracking-tight">Masuk</h1>
                    <p class="text-sm text-slate-200 mt-2 font-normal">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="text-amber-400 hover:text-amber-300 font-bold transition-colors underline-offset-4 hover:underline">
                            Daftar
                        </a>
                    </p>
                </div>

                {{-- Alert Error --}}
                @if ($errors->any())
                    <div class="rounded-xl bg-rose-950/80 border border-rose-500/50 p-4 flex items-start gap-3 text-rose-100 shadow-md" role="alert">
                        <svg class="w-5 h-5 text-rose-400 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <div class="flex-1">
                            <p class="text-xs font-bold text-rose-200">Login Gagal</p>
                            <p class="text-xs text-rose-300 mt-0.5">{{ $errors->first() }}</p>
                        </div>
                    </div>
                @endif

                @if (session('success'))
                    <div class="rounded-xl bg-emerald-950/80 border border-emerald-500/50 p-3.5 flex items-center gap-2.5 text-xs text-emerald-200 font-medium shadow-md">
                        <svg class="w-4 h-4 text-emerald-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                {{-- Form --}}
                <form method="POST" action="{{ route('login') }}" class="space-y-4" id="loginForm">
                    @csrf

                    {{-- Email / NIK Field --}}
                    <div>
                        <label for="login" class="block text-sm font-medium text-slate-100 mb-1.5">
                            Email
                        </label>
                        <input
                            type="text"
                            id="login"
                            name="login"
                            value="{{ old('login') }}"
                            placeholder="fujiyansah198@gmail.com"
                            required
                            autofocus
                            class="w-full px-4 py-3 rounded-lg text-sm text-slate-900 bg-white border border-slate-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-400/30 outline-none placeholder:text-slate-400 shadow-xs"
                        >
                    </div>

                    {{-- Password Field with Eye Toggle inside a box --}}
                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-100 mb-1.5">
                            Password
                        </label>
                        <div class="flex rounded-lg overflow-hidden border border-slate-200 focus-within:border-amber-400 focus-within:ring-2 focus-within:ring-amber-400/30 bg-white shadow-xs">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="••••••••••••"
                                required
                                class="w-full px-4 py-3 bg-white text-sm text-slate-900 outline-none placeholder:text-slate-400"
                            >
                            <button type="button" id="togglePassword" class="px-3.5 bg-slate-50 border-l border-slate-200 text-slate-600 hover:text-slate-900 flex items-center justify-center cursor-pointer">
                                <svg id="eyeIcon" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="eyeOffIcon" class="w-4 h-4 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- reCAPTCHA simulated widget --}}
                    <div class="pt-1">
                        <div class="w-64 p-3 bg-white rounded-lg flex items-center justify-between shadow-xs border border-white/20">
                            <label class="flex items-center gap-3 cursor-pointer select-none">
                                <input type="checkbox" name="captcha" id="captchaCheck" class="w-5 h-5 rounded border-slate-300 text-teal-600 focus:ring-teal-500 cursor-pointer">
                                <span class="text-xs text-slate-800 font-medium">Saya bukan robot</span>
                            </label>
                            <div class="flex flex-col items-center">
                                <svg class="w-6 h-6 text-sky-600" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2a10 10 0 1010 10A10 10 0 0012 2zm1 14.5a1.5 1.5 0 111.5-1.5 1.5 1.5 0 01-1.5 1.5zm2.5-6.5a2.5 2.5 0 00-5 0h-2a4.5 4.5 0 019 0c0 1.66-1.34 2.5-2.25 3.12-.53.37-.75.63-.75 1.38h-2c0-1.5.85-2.14 1.58-2.65.6-.42 1.42-.97 1.42-1.85z"/>
                                </svg>
                                <span class="text-[9px] text-slate-400 font-semibold tracking-tighter">reCAPTCHA</span>
                            </div>
                        </div>
                    </div>

                    {{-- Lupa Password Link --}}
                    <div class="flex justify-end pt-1">
                        <a href="#" onclick="alert('Silakan hubungi admin Diskominfo untuk reset kata sandi.');" class="text-xs font-medium text-slate-300 hover:text-white transition-colors">
                            Lupa Password
                        </a>
                    </div>

                    {{-- Submit Button --}}
                    <div class="pt-2">
                        <button
                            type="submit"
                            id="submitBtn"
                            class="w-full py-3 px-6 rounded-lg text-sm font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 cursor-pointer"
                        >
                            <span id="btnText">Masuk</span>
                            <span id="btnLoading" class="hidden items-center gap-2">
                                <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                                <span>Memproses...</span>
                            </span>
                        </button>
                    </div>
                </form>


            </div>
        </div>

        {{-- ═══════════════════════════════════════════════════════════════════════
             RIGHT COLUMN — OFFICIAL LIGHT BRANDING (Logo clearly visible)
        ═══════════════════════════════════════════════════════════════════════ --}}
        <div class="lg:col-span-6 bg-gradient-to-br from-slate-50 via-sky-50/40 to-slate-100 text-slate-800 relative flex flex-col justify-between p-8 sm:p-12 overflow-hidden min-h-[500px] lg:min-h-full border-l border-slate-200/60">

            {{-- 1. SVG Wavy Curves & Geometric Art Decor --}}
            <div class="absolute top-12 left-8 w-24 h-40 gold-dots opacity-40 pointer-events-none"></div>

            {{-- Subtle geometric lines --}}
            <div class="absolute top-1/4 right-12 w-6 h-6 text-slate-300 font-mono text-xl select-none pointer-events-none">✕</div>
            <div class="absolute bottom-1/3 left-12 w-6 h-6 text-slate-300 font-mono text-xl select-none pointer-events-none">✕</div>
            <div class="absolute top-16 right-1/3 w-4 h-4 rounded-full border border-slate-300 pointer-events-none"></div>
            <div class="absolute bottom-10 left-1/4 w-4 h-4 rounded-full border border-slate-300 pointer-events-none"></div>

            {{-- Curved Wave Vectors (SVG) --}}
            <svg class="absolute inset-0 w-full h-full pointer-events-none opacity-40" preserveAspectRatio="none" viewBox="0 0 600 700" fill="none">
                <path d="M500 0 C450 200, 600 400, 480 700 L600 700 L600 0 Z" fill="#0b256b" opacity="0.08"/>
                <path d="M420 0 C380 220, 560 380, 420 700 L600 700 L600 0 Z" fill="#0284c7" opacity="0.05"/>

                {{-- Golden Flowing Line --}}
                <path d="M480 0 C420 180, 580 360, 450 700" stroke="#f59e0b" stroke-width="3" stroke-linecap="round" opacity="0.7"/>

                {{-- Blue Thin Flowing Line --}}
                <path d="M510 0 C460 190, 620 370, 480 700" stroke="#0b256b" stroke-width="2" stroke-linecap="round" opacity="0.3"/>

                {{-- Bottom Flowing Golden Curve --}}
                <path d="M280 700 C360 520, 480 580, 600 500" stroke="#f59e0b" stroke-width="3" stroke-linecap="round" opacity="0.7"/>
                <path d="M250 700 C340 500, 460 560, 600 480" stroke="#0b256b" stroke-width="2" stroke-linecap="round" opacity="0.3"/>
            </svg>

            {{-- 2. Top Right Header Links --}}
            <div class="relative z-10 flex items-center justify-end gap-6 text-sm font-semibold text-slate-700">
                <a href="{{ url('/') }}" class="hover:text-blue-700 transition-colors">Beranda</a>
                <a href="#" onclick="alert('Pusat Bantuan & FAQ Portal Layanan');" class="hover:text-blue-700 transition-colors">FAQ</a>
                <a href="#" onclick="alert('Kontak Diskominfo: (0265) 545123');" class="hover:text-blue-700 transition-colors">Hubungi Kami</a>
            </div>

            {{-- 3. Center Branding: Official Dishub Kominfo Logo --}}
            <div class="relative z-10 my-auto text-center py-8 sm:py-12 px-4 sm:px-6 flex items-center justify-center">
                <div class="w-full max-w-[360px] sm:max-w-[440px] lg:max-w-[500px] xl:max-w-[540px] flex items-center justify-center p-4">
                    <x-application-logo class="w-full h-auto max-h-[160px] sm:max-h-[220px] drop-shadow-sm transition-transform duration-300 hover:scale-[1.02]" />
                </div>
            </div>

            {{-- 4. Bottom Empty Spacer for balance --}}
            <div class="relative z-10 h-6"></div>

        </div>

    </div>

    {{-- Script Interactivity --}}
    <script>
        // Password toggle
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput  = document.getElementById('password');
        const eyeIcon        = document.getElementById('eyeIcon');
        const eyeOffIcon     = document.getElementById('eyeOffIcon');

        togglePassword.addEventListener('click', () => {
            const isPass = passwordInput.type === 'password';
            passwordInput.type = isPass ? 'text' : 'password';
            eyeIcon.classList.toggle('hidden', isPass);
            eyeOffIcon.classList.toggle('hidden', !isPass);
        });

        // Submit form state
        const form      = document.getElementById('loginForm');
        const btnText   = document.getElementById('btnText');
        const btnLoad   = document.getElementById('btnLoading');
        const submitBtn = document.getElementById('submitBtn');

        form.addEventListener('submit', () => {
            btnText.classList.add('hidden');
            btnLoad.classList.remove('hidden');
            btnLoad.classList.add('flex');
            submitBtn.disabled = true;
        });


    </script>
</body>
</html>
