    {{-- 4. MODAL: RINGKASAN / DETAIL DOKUMEN INFORMASI PUBLIK --}}
    <div x-show="showDocPreviewModal"
         x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 overflow-y-auto"
         role="dialog"
         aria-modal="true">
        
        <div x-show="showDocPreviewModal"
             x-transition:enter="ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             @click="showDocPreviewModal = false"
             class="fixed inset-0 bg-slate-950/70 backdrop-blur-xs"></div>

        <div x-show="showDocPreviewModal"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             class="relative bg-white rounded-3xl shadow-2xl border border-slate-100 max-w-xl w-full p-6 sm:p-8 z-10 space-y-5 my-8">

            <div class="flex items-start justify-between gap-3 pb-3 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-0.5 rounded text-[10px] font-black uppercase tracking-wider"
                          :class="selectedDoc?.categoryBadge"
                          x-text="selectedDoc?.categoryLabel"></span>
                    <span class="text-xs font-mono text-slate-400 font-semibold" x-text="selectedDoc?.id"></span>
                </div>
                <button type="button" @click="showDocPreviewModal = false" class="text-slate-400 hover:text-slate-700 p-1.5 rounded-lg">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <div class="space-y-3">
                <h3 class="text-base font-bold text-slate-900 leading-snug" x-text="selectedDoc?.title"></h3>
                <p class="text-xs text-slate-600 leading-relaxed bg-slate-50 p-3.5 rounded-2xl border border-slate-200" x-text="selectedDoc?.summary"></p>
            </div>

            <div class="grid grid-cols-2 gap-3 text-xs bg-slate-50/80 p-4 rounded-2xl border border-slate-200/80">
                <div>
                    <span class="text-slate-400 block text-[10px] uppercase font-bold">Pejabat Penanggung Jawab:</span>
                    <span class="font-bold text-slate-800" x-text="selectedDoc?.pj"></span>
                </div>
                <div>
                    <span class="text-slate-400 block text-[10px] uppercase font-bold">Masa Retensi / Simpan:</span>
                    <span class="font-bold text-slate-800" x-text="selectedDoc?.masaSimpan"></span>
                </div>
                <div class="col-span-2 pt-2 border-t border-slate-200/60">
                    <span class="text-slate-400 block text-[10px] uppercase font-bold">Dasar Hukum Keterbukaan:</span>
                    <span class="text-slate-700 font-medium" x-text="selectedDoc?.dasarHukum"></span>
                </div>
            </div>

            <div class="flex items-center justify-between gap-3 pt-2">
                <span class="text-xs text-slate-400">
                    Format: <strong class="text-slate-700" x-text="selectedDoc?.type"></strong> &bull; <span x-text="selectedDoc?.size"></span>
                </span>
                <div class="flex items-center gap-2">
                    <button type="button" @click="showDocPreviewModal = false" class="px-4 py-2 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-bold transition-colors">
                        Tutup
                    </button>
                    <button type="button"
                            @click="downloadDoc(selectedDoc); showDocPreviewModal = false"
                            class="px-5 py-2 rounded-xl bg-[#0a2558] hover:bg-[#0d3070] text-white text-xs font-bold shadow-md transition-all flex items-center gap-1.5 cursor-pointer">
                        <i data-lucide="download" class="w-3.5 h-3.5"></i>
                        <span>Unduh Dokumen</span>
                    </button>
                </div>
            </div>

        </div>
