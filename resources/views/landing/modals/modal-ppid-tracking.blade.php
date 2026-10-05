    {{-- 3. MODAL: LACAK STATUS PERMOHONAN PPID --}}
    <div x-show="showTrackingModal"
         x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 overflow-y-auto"
         role="dialog"
         aria-modal="true">
        
        <div x-show="showTrackingModal"
             x-transition:enter="ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             @click="showTrackingModal = false"
             class="fixed inset-0 bg-slate-950/70 backdrop-blur-xs"></div>

        <div x-show="showTrackingModal"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             class="relative bg-white rounded-3xl shadow-2xl border border-slate-100 max-w-xl w-full p-6 sm:p-8 z-10 space-y-5 my-8">

            {{-- Header --}}
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-slate-100 text-[#0a2558] flex items-center justify-center font-bold">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-black text-slate-900 leading-tight">Lacak Permohonan Informasi PPID</h3>
                        <p class="text-[11px] text-slate-400">Pantau progres penyiapan informasi publik Anda secara berkala</p>
                    </div>
                </div>
                <button type="button" @click="showTrackingModal = false" class="text-slate-400 hover:text-slate-700 p-1.5 rounded-lg">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            {{-- Search Box --}}
            <div class="space-y-2">
                <label class="font-bold text-xs text-slate-700 block">Masukkan Nomor Tiket Registrasi:</label>
                <div class="flex items-center gap-2">
                    <input type="text"
                           x-model="trackingInput"
                           @keyup.enter="checkTracking()"
                           placeholder="Contoh: PPID-TSK-2025-0142..."
                           class="flex-1 px-3.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-[#0a2558] text-slate-900 font-mono uppercase">
                    <button type="button"
                            @click="checkTracking()"
                            class="px-5 py-2.5 rounded-xl bg-[#0a2558] hover:bg-[#0d3070] text-white font-bold text-xs transition-colors flex items-center gap-1.5 cursor-pointer">
                        <i data-lucide="search" class="w-3.5 h-3.5"></i>
                        <span>Cek</span>
                    </button>
                </div>

                {{-- Demo Chips --}}
                <div class="pt-1 flex flex-wrap items-center gap-1.5 text-[11px]">
                    <span class="text-slate-400">Coba nomor demo:</span>
                    <template x-for="item in trackingRecords.slice(0, 3)" :key="item.code">
                        <button type="button"
                                @click="trackingInput = item.code; checkTracking(item.code)"
                                class="px-2 py-0.5 rounded-md bg-slate-100 hover:bg-slate-200 text-slate-700 font-mono text-[10px] font-semibold border border-slate-200 transition-colors"
                                x-text="item.code">
                        </button>
                    </template>
                </div>
            </div>

            {{-- Tracking Result Box --}}
            <template x-if="trackingResult && !trackingResult.notFound">
                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/90 space-y-4 text-xs">
                    
                    {{-- Status Banner --}}
                    <div class="flex items-start justify-between gap-3 pb-3 border-b border-slate-200">
                        <div>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold border" :class="trackingResult.statusBadge" x-text="trackingResult.statusText"></span>
                            <h4 class="font-bold text-slate-900 text-sm mt-1.5" x-text="trackingResult.title"></h4>
                            <p class="text-[11px] text-slate-500 mt-0.5">Pemohon: <strong class="text-slate-700" x-text="trackingResult.applicant"></strong> &bull; <span x-text="trackingResult.date"></span></p>
                        </div>
                    </div>

                    {{-- 4 Step Progress Bar --}}
                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between text-[10px] font-bold text-slate-500">
                            <span>1. Diterima</span>
                            <span>2. Verifikasi</span>
                            <span>3. Penyiapan</span>
                            <span>4. Selesai</span>
                        </div>
                        <div class="w-full h-2 rounded-full bg-slate-200 overflow-hidden">
                            <div class="h-full bg-[#0a2558] transition-all duration-500"
                                 :style="`width: ${trackingResult.step * 25}%`"></div>
                        </div>
                    </div>

                    {{-- Officer Notes --}}
                    <div class="p-3 bg-white rounded-xl border border-slate-200 space-y-1">
                        <span class="text-[10px] uppercase font-bold text-slate-400 block">Catatan Petugas PPID:</span>
                        <p class="text-slate-700 leading-relaxed text-[11px]" x-text="trackingResult.notes"></p>
                    </div>

                    {{-- Download Output (if ready) --}}
                    <template x-if="trackingResult.hasDownload">
                        <div class="pt-2">
                            <button type="button"
                                    @click="triggerSyntheticDownload(trackingResult.downloadTitle); triggerToast('Mengunduh Salinan Dokumen Hasil Permohonan...')"
                                    class="w-full py-2.5 rounded-xl bg-[#0a2558] hover:bg-[#0d3070] text-white font-bold text-xs shadow-md transition-all flex items-center justify-center gap-2">
                                <i data-lucide="file-check" class="w-4 h-4"></i>
                                <span>Unduh Salinan Dokumen Resmi (PDF)</span>
                            </button>
                        </div>
                    </template>

                </div>
            </template>

            {{-- Not Found Result --}}
            <template x-if="trackingResult && trackingResult.notFound">
                <div class="p-5 rounded-2xl bg-rose-50 border border-rose-200 text-center text-xs space-y-1">
                    <i data-lucide="alert-circle" class="w-7 h-7 text-rose-500 mx-auto"></i>
                    <p class="font-bold text-rose-900">Nomor Registrasi Tidak Ditemukan</p>
                    <p class="text-rose-700 text-[11px]">Pastikan format nomor tiket sesuai (Contoh: PPID-TSK-2025-0142). Silakan periksa kembali tanda terima Anda.</p>
                </div>
            </template>

            <div class="pt-2 flex justify-end">
                <button type="button" @click="showTrackingModal = false" class="px-5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-colors">
                    Tutup
                </button>
            </div>

        </div>

    </div>
