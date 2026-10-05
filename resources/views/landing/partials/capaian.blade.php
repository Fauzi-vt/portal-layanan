    <div id="capaian" class="-mt-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-30 scroll-mt-28">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-stretch">

            {{-- Card 1: Profil & Capaian Diskominfo (Left Card) --}}
            <div class="md:col-span-3 bg-white rounded-3xl p-6 shadow-xl border border-slate-100 flex flex-col justify-between">
                <div>
                    <span class="text-[10px] font-bold text-blue-700 uppercase tracking-widest block mb-1">Standar Layanan</span>
                    <h3 class="text-base font-extrabold text-slate-900 leading-snug">
                        Diskominfo Kab. Tasikmalaya
                    </h3>
                    <p class="text-xs text-slate-500 mt-1">Komitmen Pelayanan Prima, Keamanan Informasi & SPBE Kabupaten.</p>

                    <div class="grid grid-cols-2 gap-3 pt-4">
                        <div class="p-3 bg-slate-50 rounded-2xl text-center border border-slate-100">
                            <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center mx-auto mb-1">
                                <i data-lucide="building-2" class="w-4 h-4"></i>
                            </div>
                            <span class="text-[11px] font-bold text-slate-800 block">39 Kecamatan</span>
                            <span class="text-[9px] text-slate-400">Terintegrasi</span>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-2xl text-center border border-slate-100">
                            <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center mx-auto mb-1">
                                <i data-lucide="shield-check" class="w-4 h-4"></i>
                            </div>
                            <span class="text-[11px] font-bold text-slate-800 block">Keamanan Data</span>
                            <span class="text-[9px] text-slate-400">Terenkripsi</span>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 text-right">
                    <a href="#layanan" class="text-xs font-bold text-[#0a2558] hover:text-blue-700 flex items-center justify-end gap-1">
                        <span>Lihat Layanan</span>
                        <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                    </a>
                </div>
            </div>

            {{-- Card 2: PROMINENT YELLOW PPID CARD (Center Card) --}}
            <div id="ppid-highlight" class="md:col-span-6 bg-yellow-ppid rounded-3xl p-6 sm:p-8 shadow-2xl flex flex-col sm:flex-row items-center justify-between gap-6 relative overflow-hidden scroll-mt-28">
                <div class="space-y-4 max-w-md relative z-10">
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-950/10 text-slate-950 text-[11px] font-bold">
                        <i data-lucide="info" class="w-3.5 h-3.5"></i>
                        <span>PPID Diskominfo Kabupaten Tasikmalaya</span>
                    </div>

                    <h3 class="text-xl sm:text-2xl font-black text-slate-950 leading-tight">
                        <span class="italic font-extrabold">Yuk</span>, minta informasi melalui PPID Diskominfo Kabupaten Tasikmalaya
                    </h3>

                    <ul class="space-y-2 text-xs font-medium text-slate-900">
                        <li class="flex items-start gap-2">
                            <span class="w-4 h-4 rounded-full bg-white text-emerald-700 flex items-center justify-center font-bold text-[10px] flex-shrink-0 mt-0.5 shadow-xs">
                                <i data-lucide="check" class="w-3 h-3 text-emerald-700"></i>
                            </span>
                            <span>Diatur dalam <strong>Undang-Undang No. 14 Tahun 2008</strong> tentang Keterbukaan Informasi Publik.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="w-4 h-4 rounded-full bg-white text-emerald-700 flex items-center justify-center font-bold text-[10px] flex-shrink-0 mt-0.5 shadow-xs">
                                <i data-lucide="check" class="w-3 h-3 text-emerald-700"></i>
                            </span>
                            <span>PPID Diskominfo menyediakan informasi berkala, serta merta, dan setiap saat secara transparan.</span>
                        </li>
                    </ul>

                    <div class="pt-2 flex flex-wrap items-center gap-2.5">
                        <button type="button"
                                @click="openPpidModal()"
                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full font-bold text-xs bg-slate-950 hover:bg-slate-800 text-white shadow-md hover:shadow-lg transition-all active:scale-95 cursor-pointer">
                            <i data-lucide="send" class="w-3.5 h-3.5"></i>
                            <span>Ajukan Permohonan Informasi</span>
                        </button>
                        <a href="#ppid"
                           class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-full font-bold text-xs bg-white/70 hover:bg-white text-slate-950 border border-slate-950/15 backdrop-blur-xs transition-all hover:shadow-sm">
                            <span>Direktori Informasi PPID</span>
                            <i data-lucide="arrow-down" class="w-3.5 h-3.5"></i>
                        </a>
                    </div>
                </div>

                {{-- Officer Photo / Avatar Representation --}}
                <div class="flex-shrink-0 relative z-10 w-36 h-44 rounded-2xl bg-white/40 border border-white/60 flex flex-col items-center justify-center text-center p-3 shadow-sm backdrop-blur-xs">
                    <div class="w-12 h-12 rounded-2xl bg-slate-950 text-amber-400 flex items-center justify-center mb-2 shadow-sm">
                        <i data-lucide="headset" class="w-6 h-6"></i>
                    </div>
                    <span class="text-[11px] font-black text-slate-950">Petugas PPID</span>
                    <span class="text-[10px] text-slate-800 font-medium">Kab. Tasikmalaya</span>
                    <button type="button"
                            @click="openPpidTracking()"
                            class="mt-2 text-[10px] font-bold text-slate-950 bg-white/80 hover:bg-white px-2.5 py-1 rounded-full border border-slate-300 shadow-2xs transition-colors cursor-pointer">
                        Lacak Status â†’
                    </button>
                </div>
            </div>

            {{-- Card 3: SP4N-LAPOR! / Pengaduan (Right Card) --}}
            <div id="pengaduan" class="md:col-span-3 bg-white rounded-3xl p-6 shadow-xl border border-slate-100 flex flex-col justify-between scroll-mt-28">
                <div>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-14 rounded-2xl bg-rose-50 border border-rose-200 flex items-center justify-center text-rose-600 flex-shrink-0">
                            <i data-lucide="megaphone" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-extrabold text-rose-950 leading-snug">
                                Aspirasi & Pengaduan
                            </h3>
                            <p class="text-xs text-slate-500 mt-1">Sampaikan laporan layanan publik ke Diskominfo & SP4N-LAPOR!.</p>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100">
                    <button type="button"
                            @click="openPengaduan()"
                            class="w-full inline-flex items-center justify-center gap-1.5 py-2.5 rounded-xl font-bold text-xs text-white bg-rose-600 hover:bg-rose-700 transition-colors shadow-xs cursor-pointer">
                        <span>Buat Pengaduan</span>
                        <i data-lucide="arrow-up-right" class="w-3.5 h-3.5"></i>
                    </button>
                </div>
            </div>

        </div>
    </div>
