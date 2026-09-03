<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
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
        h1, h2, h3 { letter-spacing: -0.02em; }
        [data-lucide] { display: inline-block; vertical-align: middle; }

        .ambient-glow {
            filter: blur(80px);
            opacity: 0.45;
            pointer-events: none;
        }
    </style>
</head>
<body class="min-h-screen bg-[#f1f5f9] text-slate-800 flex flex-col justify-center items-center p-4 sm:p-6 lg:p-8 relative overflow-x-hidden">

    {{-- ═══════════════════════════════════════════════════════════════════════════
         AMBIENT BACKGROUND LIGHTS & PATTERN
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="fixed -top-32 -left-32 w-96 h-96 rounded-full bg-blue-400 ambient-glow"></div>
    <div class="fixed -bottom-32 -right-32 w-96 h-96 rounded-full bg-teal-400 ambient-glow"></div>
    <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] rounded-full bg-indigo-200/30 ambient-glow"></div>

    <div class="fixed inset-0 bg-[linear-gradient(to_right,#e2e8f0_1px,transparent_1px),linear-gradient(to_bottom,#e2e8f0_1px,transparent_1px)] bg-[size:4rem_4rem] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_50%,#000_70%,transparent_100%)] opacity-40 pointer-events-none"></div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         FLOATING TOP NAVIGATION / CLOSE BUTTON ('✕')
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="fixed top-4 sm:top-6 right-4 sm:right-6 z-50 flex items-center gap-3">
        <a href="{{ url('/') }}"
           class="group flex items-center gap-2.5 px-4 py-2.5 rounded-2xl bg-white/90 hover:bg-white text-slate-700 hover:text-slate-950 border border-slate-200/80 shadow-sm hover:shadow-md transition-all backdrop-blur-md"
           title="Tutup dan kembali ke Halaman Utama">
            <span class="text-xs sm:text-sm font-semibold hidden sm:inline-block">Kembali ke Beranda</span>
            <div class="w-7 h-7 rounded-xl bg-slate-100 group-hover:bg-rose-50 text-slate-500 group-hover:text-rose-600 flex items-center justify-center transition-all group-hover:rotate-90">
                <i data-lucide="x" class="w-4 h-4"></i>
            </div>
        </a>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         MAIN REGISTER CARD CONTAINER
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="relative z-10 w-full max-w-5xl bg-white rounded-3xl shadow-2xl border border-slate-200/80 overflow-hidden my-auto grid grid-cols-1 lg:grid-cols-12">

        {{-- ── LEFT COLUMN: REGISTER FORM ── --}}
        <div class="lg:col-span-7 p-6 sm:p-10 lg:p-12 flex flex-col justify-between">
            <div class="space-y-6">

                {{-- Mobile Brand Logo Header --}}
                <div class="flex items-center justify-between lg:hidden pb-4 border-b border-slate-100">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('images/logo2.png') }}" alt="Dishub Kominfo" class="h-9 w-auto object-contain">
                    </a>
                    <span class="text-xs font-bold px-2.5 py-1 rounded-lg bg-blue-50 text-blue-700 border border-blue-100">
                        Pendaftaran
                    </span>
                </div>

                {{-- Heading --}}
                <div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                        Daftar Akun Baru
                    </h1>
                    <p class="text-sm text-slate-500 mt-1.5 font-medium">
                        Lengkapi formulir di bawah ini untuk membuat akun pemohon layanan publik.
                    </p>
                </div>

                {{-- Alert Error --}}
                @if ($errors->any())
                    <div class="rounded-2xl bg-rose-50 border border-rose-200 p-4 flex items-start gap-3.5 text-rose-900 shadow-xs" role="alert">
                        <div class="w-8 h-8 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center flex-shrink-0 mt-0.5 font-bold">
                            <i data-lucide="alert-circle" class="w-5 h-5"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs font-bold text-rose-900 uppercase tracking-wider">Pendaftaran Gagal</p>
                            <ul class="text-xs sm:text-sm text-rose-700 mt-1 space-y-0.5">
                                @foreach ($errors->all() as $err)
                                    <li>• {{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                {{-- Form --}}
                <form method="POST" action="{{ route('register') }}" class="space-y-4" id="regForm">
                    @csrf

                    {{-- Nama Depan & Nama Belakang --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label for="nama_depan" class="block text-xs sm:text-sm font-bold text-slate-700 uppercase tracking-wider">
                                Nama Depan <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <i data-lucide="user" class="w-4 h-4"></i>
                                </div>
                                <input
                                    type="text"
                                    id="nama_depan"
                                    name="nama_depan"
                                    value="{{ old('nama_depan') }}"
                                    placeholder="Contoh: Ahmad"
                                    required
                                    autofocus
                                    class="w-full pl-10 pr-4 py-2.5 rounded-xl text-sm sm:text-base text-slate-900 bg-slate-50/70 border border-slate-200 focus:bg-white focus:border-[#0a2558] focus:ring-4 focus:ring-blue-500/15 outline-none placeholder:text-slate-400 transition-all font-medium"
                                >
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label for="nama_belakang" class="block text-xs sm:text-sm font-bold text-slate-700 uppercase tracking-wider">
                                Nama Belakang
                            </label>
                            <input
                                type="text"
                                id="nama_belakang"
                                name="nama_belakang"
                                value="{{ old('nama_belakang') }}"
                                placeholder="Contoh: Fauzi"
                                class="w-full px-4 py-2.5 rounded-xl text-sm sm:text-base text-slate-900 bg-slate-50/70 border border-slate-200 focus:bg-white focus:border-[#0a2558] focus:ring-4 focus:ring-blue-500/15 outline-none placeholder:text-slate-400 transition-all font-medium"
                            >
                        </div>
                    </div>

                    {{-- Email Field --}}
                    <div class="space-y-1.5">
                        <label for="email" class="block text-xs sm:text-sm font-bold text-slate-700 uppercase tracking-wider">
                            Alamat Email Aktif <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i data-lucide="mail" class="w-4 h-4"></i>
                            </div>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="nama@email.com"
                                required
                                class="w-full pl-10 pr-4 py-2.5 rounded-xl text-sm sm:text-base text-slate-900 bg-slate-50/70 border border-slate-200 focus:bg-white focus:border-[#0a2558] focus:ring-4 focus:ring-blue-500/15 outline-none placeholder:text-slate-400 transition-all font-medium"
                            >
                        </div>
                    </div>

                    {{-- Password & Confirmation --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label for="password" class="block text-xs sm:text-sm font-bold text-slate-700 uppercase tracking-wider">
                                Kata Sandi <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <i data-lucide="lock" class="w-4 h-4"></i>
                                </div>
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    placeholder="Min. 6 karakter"
                                    required
                                    class="w-full pl-10 pr-10 py-2.5 rounded-xl text-sm sm:text-base text-slate-900 bg-slate-50/70 border border-slate-200 focus:bg-white focus:border-[#0a2558] focus:ring-4 focus:ring-blue-500/15 outline-none placeholder:text-slate-400 transition-all font-medium"
                                >
                                <button type="button" id="toggleRegPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-700 cursor-pointer">
                                    <i data-lucide="eye" id="eyeIconReg" class="w-4 h-4"></i>
                                    <i data-lucide="eye-off" id="eyeOffIconReg" class="w-4 h-4 hidden"></i>
                                </button>
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label for="password_confirmation" class="block text-xs sm:text-sm font-bold text-slate-700 uppercase tracking-wider">
                                Ulangi Sandi <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <i data-lucide="lock" class="w-4 h-4"></i>
                                </div>
                                <input
                                    type="password"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    placeholder="Ketik ulang sandi"
                                    required
                                    class="w-full pl-10 pr-4 py-2.5 rounded-xl text-sm sm:text-base text-slate-900 bg-slate-50/70 border border-slate-200 focus:bg-white focus:border-[#0a2558] focus:ring-4 focus:ring-blue-500/15 outline-none placeholder:text-slate-400 transition-all font-medium"
                                >
                            </div>
                        </div>
                    </div>

                    {{-- Persetujuan Syarat Ketentuan --}}
                    <div class="pt-1">
                        <label class="flex items-start gap-2.5 cursor-pointer select-none">
                            <input type="checkbox" required checked class="w-4 h-4 mt-0.5 rounded border-slate-300 text-[#0a2558] focus:ring-blue-500 cursor-pointer">
                            <span class="text-xs text-slate-600 font-medium leading-relaxed">
                                Saya menyetujui <a href="#" onclick="alert('Syarat & Ketentuan Layanan Publik Kabupaten Tasikmalaya');" class="text-blue-700 font-bold underline">Syarat & Ketentuan</a> serta Kebijakan Privasi Portal Layanan Publik.
                            </span>
                        </label>
                    </div>

                    {{-- Submit Button --}}
                    <div class="pt-2">
                        <button
                            type="submit"
                            id="submitBtn"
                            class="w-full py-3.5 px-6 rounded-xl text-sm sm:text-base font-bold bg-[#0a2558] hover:bg-[#0d3070] text-white shadow-lg shadow-blue-950/20 hover:shadow-xl transition-all flex items-center justify-center gap-2 cursor-pointer group hover:-translate-y-0.5 active:translate-y-0"
                        >
                            <span id="btnText" class="flex items-center gap-2">
                                <span>Buat Akun Sekarang</span>
                                <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                            </span>
                            <span id="btnLoading" class="hidden items-center gap-2">
                                <i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i>
                                <span>Membuat akun...</span>
                            </span>
                        </button>
                    </div>
                </form>

                {{-- Login Footer Link --}}
                <div class="pt-3 border-t border-slate-100 text-center">
                    <p class="text-xs sm:text-sm text-slate-600 font-medium">
                        Sudah memiliki akun?
                        <a href="{{ route('login') }}" class="font-bold text-blue-700 hover:text-blue-900 hover:underline transition-colors ml-1">
                            Masuk ke Akun Anda
                        </a>
                    </p>
                </div>

            </div>

            {{-- Security Footer Note --}}
            <div class="mt-6 pt-3 flex items-center justify-center gap-2 text-xs text-slate-400">
                <i data-lucide="shield-check" class="w-4 h-4 text-emerald-600"></i>
                <span>Data Pribadi Anda Dilindungi oleh Sistem Keamanan Terenkripsi</span>
            </div>
        </div>

        {{-- ── RIGHT COLUMN: BRANDING & HIGHLIGHTS ── --}}
        <div class="lg:col-span-5 relative text-white flex flex-col justify-between p-8 sm:p-12 overflow-hidden"
             style="background: linear-gradient(135deg, #0a2558 0%, #113470 50%, #1a4a8d 100%)">

            <div class="absolute -top-12 -right-12 w-64 h-64 rounded-full bg-white/5 pointer-events-none"></div>
            <div class="absolute -bottom-16 -left-16 w-64 h-64 rounded-full bg-white/5 pointer-events-none"></div>
            <div class="absolute top-1/2 right-4 w-32 h-32 rounded-full bg-teal-400/10 blur-2xl pointer-events-none"></div>

            <div class="relative z-10 space-y-8">
                <div class="bg-white/95 rounded-2xl p-4 sm:p-5 shadow-lg max-w-[280px]">
                    <img src="{{ asset('images/logo.png') }}" alt="Dishub Kominfo - Pelayanan Terpadu Satu Pintu" class="h-10 sm:h-12 w-auto object-contain mx-auto">
                </div>

                <div class="space-y-3">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-teal-500/20 text-teal-200 text-xs font-bold border border-teal-300/30">
                        <span class="w-2 h-2 rounded-full bg-teal-400 animate-pulse"></span>
                        Registrasi Pemohon
                    </div>
                    <h2 class="text-xl sm:text-2xl font-bold text-white tracking-tight leading-snug">
                        Mulai Akses Seluruh Layanan Pemerintah Daerah
                    </h2>
                    <p class="text-sm text-blue-100/90 leading-relaxed font-normal">
                        Daftarkan diri Anda dalam beberapa langkah mudah untuk mulai mengajukan berbagai permohonan surat izin dan administrasi kependudukan.
                    </p>
                </div>

                <div class="space-y-4 pt-2">
                    <div class="flex items-start gap-3.5">
                        <div class="w-8 h-8 rounded-xl bg-white/10 flex items-center justify-center flex-shrink-0 text-teal-300">
                            <i data-lucide="user-check" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-white">Satu Akun untuk Semua Layanan</p>
                            <p class="text-xs text-blue-200/80 mt-0.5">Akses berbagai permohonan tanpa perlu membuat akun berulang.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3.5">
                        <div class="w-8 h-8 rounded-xl bg-white/10 flex items-center justify-center flex-shrink-0 text-teal-300">
                            <i data-lucide="clock" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-white">Layanan 24 Jam Mandiri</p>
                            <p class="text-xs text-blue-200/80 mt-0.5">Unggah berkas permohonan kapan saja tanpa terikat jam kantor.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3.5">
                        <div class="w-8 h-8 rounded-xl bg-white/10 flex items-center justify-center flex-shrink-0 text-teal-300">
                            <i data-lucide="file-badge-2" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-white">Unduh Izin Digital Resmi</p>
                            <p class="text-xs text-blue-200/80 mt-0.5">Surat keputusan dan izin diterbitkan langsung dalam format digital.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative z-10 pt-8 mt-6 border-t border-white/10 flex items-center justify-between text-xs text-blue-200/70">
                <span>&copy; {{ date('Y') }} Dinas Kominfo</span>
                <span>Kabupaten Tasikmalaya</span>
            </div>

        </div>

    </div>

    {{-- Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });

        // Password Toggle
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

        // Submit state
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
