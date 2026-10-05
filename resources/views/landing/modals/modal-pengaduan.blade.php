    {{-- 5. MODAL: LAYANAN ASPIRASI & PENGADUAN (SP4N-LAPOR!) --}}
    <div x-show="showPengaduanModal"
         x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 overflow-y-auto"
         role="dialog"
         aria-modal="true">
        
        <div x-show="showPengaduanModal"
             x-transition:enter="ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             @click="showPengaduanModal = false"
             class="fixed inset-0 bg-slate-950/70 backdrop-blur-xs"></div>

        <div x-show="showPengaduanModal"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             class="relative bg-white rounded-3xl shadow-2xl border border-slate-100 max-w-lg w-full p-6 sm:p-8 z-10 space-y-5 my-8">

            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center gap-2.5">
                    <div class="w-10 h-10 rounded-xl bg-slate-100 text-[#0a2558] flex items-center justify-center font-bold">
                        <i data-lucide="megaphone" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-black text-slate-900 leading-tight">Layanan Aspirasi & Pengaduan Warga</h3>
                        <p class="text-[11px] text-slate-400">Pemerintah Kabupaten Tasikmalaya & SP4N-LAPOR!</p>
                    </div>
                </div>
                <button type="button" @click="showPengaduanModal = false" class="text-slate-400 hover:text-slate-700 p-1.5 rounded-lg">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <p class="text-xs text-slate-600 leading-relaxed">
                Masyarakat dapat menyampaikan kritik, saran, pengaduan pelayanan kependudukan, serta aspirasi secara langsung melalui kanal resmi terpadu berikut:
            </p>

            <div class="space-y-3">
                {{-- SP4N LAPOR Card --}}
                <a href="https://www.lapor.go.id" target="_blank" rel="noopener noreferrer"
                   class="p-4 rounded-2xl border border-slate-200 bg-white hover:bg-slate-50 transition-all flex items-center justify-between gap-3 block group">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-slate-800 text-white flex items-center justify-center font-bold text-xs shadow-xs">
                            SP4N
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-slate-900 group-hover:text-[#0a2558] transition-colors">Kanal Nasional SP4N-LAPOR!</h4>
                            <p class="text-[11px] text-slate-500">Layanan Aspirasi dan Pengaduan Online Rakyat RI</p>
                        </div>
                    </div>
                    <i data-lucide="external-link" class="w-4 h-4 text-slate-400 group-hover:text-[#0a2558] transition-colors"></i>
                </a>

                {{-- WhatsApp Desk --}}
                <a href="https://wa.me/6281123456789?text=Halo%20Admin%20Diskominfo%20Kabupaten%20Tasikmalaya,%20saya%20ingin%20menyampaikan%20aspirasi/pengaduan" target="_blank" rel="noopener noreferrer"
                   class="p-4 rounded-2xl border border-slate-200 bg-white hover:bg-slate-50 transition-all flex items-center justify-between gap-3 block group">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-bold text-xs shadow-xs">
                            WA
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-slate-900 group-hover:text-[#0a2558] transition-colors">WhatsApp Pengaduan Diskominfo</h4>
                            <p class="text-[11px] text-slate-500">Kirim pesan langsung ke petugas pelayanan publik</p>
                        </div>
                    </div>
                    <i data-lucide="arrow-up-right" class="w-4 h-4 text-slate-400 group-hover:text-[#0a2558] transition-colors"></i>
                </a>

                {{-- Call Center 112 --}}
                <div class="p-4 rounded-2xl border border-slate-200 bg-white flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-[#0a2558] text-white flex items-center justify-center font-bold text-xs shadow-xs">
                            112
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-slate-900">Layanan Darurat Kedaruratan 112</h4>
                            <p class="text-[11px] text-slate-500">Bebas pulsa untuk ambulans, damkar, dan bencana daerah</p>
                        </div>
                    </div>
                    <span class="text-xs font-semibold text-slate-700 bg-slate-100 px-2.5 py-1 rounded-lg border border-slate-200/80">24 Jam</span>
                </div>
            </div>

            <div class="pt-2 flex justify-end">
                <button type="button" @click="showPengaduanModal = false" class="px-5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-colors">
                    Tutup
                </button>
            </div>

        </div>

    </div>
