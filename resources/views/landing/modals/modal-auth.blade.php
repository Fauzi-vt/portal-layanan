{{-- ═══════════════════════════════════════════════════════════════════════════
     AUTH MODAL POPUP (LOGIN & REGISTER - EXACT AICLASSASEAN REFERENCE)
═══════════════════════════════════════════════════════════════════════════ --}}
<div x-show="showAuthModal"
     x-cloak
     class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 overflow-y-auto"
     role="dialog"
     aria-modal="true"
     aria-labelledby="authModalTitle"
     @keydown.escape.window="closeAuthModal()">

    {{-- 1. Backdrop Overlay --}}
    <div x-show="showAuthModal"
         x-transition:enter="ease-out duration-250"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="closeAuthModal()"
         class="fixed inset-0 bg-slate-900/50 backdrop-blur-[2px] transition-opacity">
    </div>

    {{-- 2. Floating Modal Card --}}
    <div x-show="showAuthModal"
         x-transition:enter="ease-out duration-250"
         x-transition:enter-start="opacity-0 scale-95 translate-y-2 sm:translate-y-0"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="opacity-0 scale-95 translate-y-2 sm:translate-y-0"
         :class="authTab === 'register' ? 'max-w-[820px]' : 'max-w-[760px]'"
         class="relative w-full bg-white rounded-2xl shadow-2xl p-6 sm:p-9 border border-slate-100 overflow-hidden z-10 my-auto transition-all duration-300">

        {{-- Quick Close Button --}}
        <button type="button"
                @click="closeAuthModal()"
                class="absolute top-4 right-4 sm:top-5 sm:right-5 w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-800 flex items-center justify-center transition-colors cursor-pointer"
                title="Tutup">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        {{-- Hidden accessibility title --}}
        <h2 id="authModalTitle" class="sr-only" x-text="authTab === 'register' ? 'Pendaftaran Akun Baru' : 'Masuk ke Akun'"></h2>

        {{-- 2-Column Grid Layout matching Reference Images --}}
        <div class="grid grid-cols-1 md:grid-cols-12 gap-7 md:gap-9 items-start">

            {{-- ── LEFT COLUMN: TAB NAVIGATION & GOOGLE SIGN-IN ── --}}
            <div class="md:col-span-4 flex flex-col space-y-3.5 pt-1">

                {{-- Tab 1: Login --}}
                <button type="button"
                        @click="switchAuthTab('login')"
                        :style="authTab === 'login' ? 'background: linear-gradient(90deg, #5185ec 0%, #ba588a 100%); color: #ffffff;' : ''"
                        :class="authTab === 'login'
                            ? 'font-bold text-white shadow-xs cursor-default'
                            : 'bg-[#f1f4f8] hover:bg-slate-200 text-slate-700 hover:text-slate-900 font-semibold cursor-pointer'"
                        class="w-full py-2.5 px-4 rounded-lg text-sm text-center transition-all select-none">
                    Login
                </button>

                {{-- Tab 2: Register --}}
                <button type="button"
                        @click="switchAuthTab('register')"
                        :style="authTab === 'register' ? 'background: linear-gradient(90deg, #5185ec 0%, #ba588a 100%); color: #ffffff;' : ''"
                        :class="authTab === 'register'
                            ? 'font-bold text-white shadow-xs cursor-default'
                            : 'bg-[#f1f4f8] hover:bg-slate-200 text-slate-700 hover:text-slate-900 font-semibold cursor-pointer'"
                        class="w-full py-2.5 px-4 rounded-lg text-sm text-center transition-all select-none">
                    Register
                </button>

                {{-- Switch Prompt Text (Dynamic based on active tab) --}}
                <div class="pt-3 text-xs leading-relaxed">
                    {{-- When on Login Tab --}}
                    <template x-if="authTab === 'login'">
                        <div>
                            <p class="text-slate-500 font-normal">Don't have an account?</p>
                            <button type="button"
                                    @click="switchAuthTab('register')"
                                    class="font-bold text-slate-900 hover:text-blue-600 transition-colors inline-block mt-0.5 cursor-pointer text-left">
                                Register Now!
                            </button>
                        </div>
                    </template>

                    {{-- When on Register Tab --}}
                    <template x-if="authTab === 'register'">
                        <div>
                            <p class="text-slate-500 font-normal">Already have an account?</p>
                            <button type="button"
                                    @click="switchAuthTab('login')"
                                    class="font-bold text-slate-900 hover:text-blue-600 transition-colors inline-block mt-0.5 cursor-pointer text-left">
                                Login
                            </button>
                        </div>
                    </template>
                </div>

                {{-- Google Sign-In Button --}}
                <div class="pt-2">
                    <button type="button"
                            @click="handleGoogleSignIn()"
                            class="w-full py-2.5 px-3 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 flex items-center justify-center gap-2.5 shadow-2xs transition-all cursor-pointer group">
                        {{-- Google 'G' 4-color SVG Icon --}}
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

                {{-- Security SSL note --}}
                <div class="pt-2 text-[11px] text-slate-400 flex items-center gap-1.5">
                    <i data-lucide="shield-check" class="w-3.5 h-3.5 text-emerald-600"></i>
                    <span>Portal Layanan Publik Terenkripsi</span>
                </div>

            </div>

            {{-- ── RIGHT COLUMN: FORM DISPLAY ── --}}
            <div class="md:col-span-8 flex flex-col justify-between pt-1">

                {{-- Global Alert Banner (Errors / Flash Success) --}}
                @if ($errors->any())
                    <div class="mb-3.5 p-3 rounded-xl bg-rose-50 border border-rose-200 text-xs text-rose-800 flex items-start gap-2.5 shadow-2xs" role="alert">
                        <i data-lucide="alert-circle" class="w-4 h-4 text-rose-600 flex-shrink-0 mt-0.5"></i>
                        <div>
                            <p class="font-bold text-rose-900">Perhatian</p>
                            <p class="text-rose-700 mt-0.5">{{ $errors->first() }}</p>
                        </div>
                    </div>
                @endif

                @if (session('success'))
                    <div class="mb-3.5 p-3 rounded-xl bg-emerald-50 border border-emerald-200 text-xs text-emerald-800 flex items-center gap-2.5 shadow-2xs">
                        <i data-lucide="check-circle" class="w-4 h-4 text-emerald-600 flex-shrink-0"></i>
                        <p class="font-semibold">{{ session('success') }}</p>
                    </div>
                @endif

                {{-- ── 1. LOGIN FORM (Shown when authTab === 'login') ── --}}
                <div x-show="authTab === 'login'" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">
                    <form method="POST" action="{{ route('login') }}" class="space-y-3.5" id="popupLoginForm">
                        @csrf

                        {{-- Email / NIK Input (Bar style matching Reference Image 1) --}}
                        <div class="space-y-1">
                            <input
                                type="text"
                                id="popup_login"
                                name="login"
                                value="{{ old('login') }}"
                                placeholder="rifafauzi044@gmail.com"
                                required
                                class="w-full px-4 py-2.5 rounded-lg bg-[#edf2f9] text-slate-900 placeholder:text-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-[#3264e6]/30 font-medium transition-all"
                            >
                        </div>

                        {{-- Password Input with Eye Toggle --}}
                        <div class="space-y-1 relative">
                            <input
                                :type="showPasswordLogin ? 'text' : 'password'"
                                id="popup_password"
                                name="password"
                                placeholder="••••••••"
                                required
                                class="w-full px-4 py-2.5 pr-11 rounded-lg bg-[#edf2f9] text-slate-900 placeholder:text-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-[#3264e6]/30 font-medium transition-all"
                            >
                            <button type="button"
                                    @click="showPasswordLogin = !showPasswordLogin"
                                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-500 hover:text-slate-800 transition-colors cursor-pointer"
                                    title="Tampilkan / Sembunyikan Kata Sandi">
                                <svg x-show="!showPasswordLogin" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="showPasswordLogin" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                                </svg>
                            </button>
                        </div>

                        {{-- Remember Me & Forget Password Row --}}
                        <div class="flex items-center justify-between pt-1 text-xs">
                            <label class="flex items-center gap-2 cursor-pointer select-none text-slate-700">
                                <input type="checkbox"
                                       name="remember"
                                       id="popup_remember"
                                       class="w-3.5 h-3.5 rounded border-slate-300 text-[#3264e6] focus:ring-[#3264e6] cursor-pointer">
                                <span class="text-xs text-slate-700 font-medium">Remember me</span>
                            </label>

                            <button type="button"
                                    @click="handleForgotPassword()"
                                    class="text-xs font-bold text-slate-900 hover:text-blue-600 transition-colors cursor-pointer">
                                Forget Password?
                            </button>
                        </div>

                        {{-- Submit Button --}}
                        <div class="pt-2">
                            <button
                                type="submit"
                                class="w-full py-2.5 sm:py-3 px-4 rounded-lg bg-[#3264e6] hover:bg-[#2552c7] text-white font-bold text-sm shadow-md shadow-blue-500/25 hover:shadow-lg transition-all flex items-center justify-center gap-2 cursor-pointer"
                            >
                                <span>Submit</span>
                            </button>
                        </div>
                    </form>
                </div>

                {{-- ── 2. REGISTER FORM (Shown when authTab === 'register') ── --}}
                <div x-show="authTab === 'register'" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">
                    <form method="POST" action="{{ route('register') }}" class="space-y-4" id="popupRegForm">
                        @csrf

                        {{-- 2-Column Minimal Underline Inputs Grid (Matching Reference Image 2) --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">

                            {{-- First Name --}}
                            <div class="space-y-0.5">
                                <label for="popup_nama_depan" class="block text-xs text-slate-500 font-medium">First Name</label>
                                <input
                                    type="text"
                                    id="popup_nama_depan"
                                    name="nama_depan"
                                    value="{{ old('nama_depan') }}"
                                    placeholder="Contoh: Ahmad"
                                    required
                                    class="w-full border-b border-slate-300 focus:border-[#3264e6] py-1 text-sm text-slate-900 placeholder:text-slate-300 bg-transparent outline-none transition-colors font-medium"
                                >
                            </div>

                            {{-- Last Name --}}
                            <div class="space-y-0.5">
                                <label for="popup_nama_belakang" class="block text-xs text-slate-500 font-medium">Last Name</label>
                                <input
                                    type="text"
                                    id="popup_nama_belakang"
                                    name="nama_belakang"
                                    value="{{ old('nama_belakang') }}"
                                    placeholder="Contoh: Fauzi"
                                    class="w-full border-b border-slate-300 focus:border-[#3264e6] py-1 text-sm text-slate-900 placeholder:text-slate-300 bg-transparent outline-none transition-colors font-medium"
                                >
                            </div>

                            {{-- Email Address (Spanning full width) --}}
                            <div class="sm:col-span-2 space-y-0.5">
                                <label for="popup_email" class="block text-xs text-slate-500 font-medium">Email Address</label>
                                <input
                                    type="email"
                                    id="popup_email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    placeholder="nama@email.com"
                                    required
                                    class="w-full border-b border-slate-300 focus:border-[#3264e6] py-1 text-sm text-slate-900 placeholder:text-slate-300 bg-transparent outline-none transition-colors font-medium"
                                >
                            </div>

                            {{-- Password with Eye Toggle --}}
                            <div class="space-y-0.5 relative">
                                <label for="popup_reg_password" class="block text-xs text-slate-500 font-medium">Password</label>
                                <input
                                    :type="showPasswordReg ? 'text' : 'password'"
                                    id="popup_reg_password"
                                    name="password"
                                    placeholder="Min. 6 karakter"
                                    required
                                    class="w-full border-b border-slate-300 focus:border-[#3264e6] py-1 pr-8 text-sm text-slate-900 placeholder:text-slate-300 bg-transparent outline-none transition-colors font-medium"
                                >
                                <button type="button"
                                        @click="showPasswordReg = !showPasswordReg"
                                        class="absolute bottom-1 right-0 flex items-center text-slate-400 hover:text-slate-700 transition-colors cursor-pointer"
                                        title="Tampilkan / Sembunyikan Kata Sandi">
                                    <svg x-show="!showPasswordReg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg x-show="showPasswordReg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                                    </svg>
                                </button>
                            </div>

                            {{-- Confirm Password with Eye Toggle --}}
                            <div class="space-y-0.5 relative">
                                <label for="popup_reg_confirm_password" class="block text-xs text-slate-500 font-medium">Confirm password</label>
                                <input
                                    :type="showPasswordConfirmReg ? 'text' : 'password'"
                                    id="popup_reg_confirm_password"
                                    name="password_confirmation"
                                    placeholder="Ketik ulang password"
                                    required
                                    class="w-full border-b border-slate-300 focus:border-[#3264e6] py-1 pr-8 text-sm text-slate-900 placeholder:text-slate-300 bg-transparent outline-none transition-colors font-medium"
                                >
                                <button type="button"
                                        @click="showPasswordConfirmReg = !showPasswordConfirmReg"
                                        class="absolute bottom-1 right-0 flex items-center text-slate-400 hover:text-slate-700 transition-colors cursor-pointer"
                                        title="Tampilkan / Sembunyikan Konfirmasi Sandi">
                                    <svg x-show="!showPasswordConfirmReg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg x-show="showPasswordConfirmReg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                                    </svg>
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
                                    By clicking checkbox, you agree to our <a href="#" @click.prevent="showTermsModal()" class="text-slate-900 font-bold hover:underline">Terms and Conditions</a> and <a href="#" @click.prevent="showPrivacyModal()" class="text-slate-900 font-bold hover:underline">Privacy Policy</a>
                                </span>
                            </label>
                        </div>

                        {{-- Submit Button --}}
                        <div class="pt-2">
                            <button
                                type="submit"
                                class="w-full py-2.5 sm:py-3 px-4 rounded-lg bg-[#3264e6] hover:bg-[#2552c7] text-white font-bold text-sm shadow-md shadow-blue-500/25 hover:shadow-lg transition-all flex items-center justify-center gap-2 cursor-pointer"
                            >
                                <span>Submit</span>
                            </button>
                        </div>
                    </form>
                </div>

            </div>

        </div>

    </div>

</div>
