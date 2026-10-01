    {{-- 2. MODAL: BUKTI TANDA TERIMA / SUKSES REGISTRASI PERMOHONAN PPID --}}
    <div x-show="showPpidSuccessModal"
         x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 overflow-y-auto"
         role="dialog"
         aria-modal="true">
        
        <div x-show="showPpidSuccessModal"
             x-transition:enter="ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             @click="showPpidSuccessModal = false"
             class="fixed inset-0 bg-slate-950/70 backdrop-blur-xs"></div>

        <div x-show="showPpidSuccessModal"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             class="relative bg-white rounded-3xl shadow-2xl border border-slate-100 max-w-lg w-full p-6 sm:p-8 text-center z-10 space-y-5 my-8">

            <div class="w-16 h-16 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto shadow-md">
                <i data-lucide="check-check" class="w-8 h-8"></i>
            </div>

            <div>
                <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200 font-bold text-[11px] uppercase tracking-wider">
                    Registrasi Berhasil
                </span>
                <h3 class="text-xl font-black text-slate-900 mt-2">
                    Permohonan Informasi Telah Diterima!
                </h3>
                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                    Permohonan Anda telah resmi tercatat dalam sistem PPID Diskominfo Kabupaten Tasikmalaya.
                </p>
            </div>

            {{-- Ticket Box --}}
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2 text-left">
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Nomor Tiket Registrasi:</span>
                    <button type="button"
                            @click="copyToClipboard(generatedTicket)"
                            class="text-[11px] font-bold text-blue-600 hover:underline flex items-center gap-1">
                        <i data-lucide="copy" class="w-3 h-3"></i>
                        <span>Salin No. Tiket</span>
                    </button>
                </div>
                <div class="p-2.5 bg-white rounded-xl border border-slate-200 flex items-center justify-between font-mono font-black text-base text-[#0a2558]">
                    <span x-text="generatedTicket"></span>
                    <i data-lucide="ticket" class="w-5 h-5 text-[#0a2558]"></i>
                </div>
                <div class="grid grid-cols-2 gap-2 pt-2 text-[11px] text-slate-600">
                    <div>
                        <span class="text-slate-400 block">Pemohon:</span>
                        <span class="font-bold text-slate-800" x-text="ppidForm.nama"></span>
                    </div>
                    <div>
                        <span class="text-slate-400 block">Tanggal Registrasi:</span>
                        <span class="font-bold text-slate-800" x-text="ticketDate"></span>
                    </div>
                </div>
            </div>

            {{-- SLA Note --}}
            <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 text-left text-[11px] text-slate-700 space-y-1">
                <span class="font-bold text-slate-900 block">Waktu Penanganan:</span>
                <p>Petugas PPID akan melakukan verifikasi dan penyiapan berkas dalam waktu maksimal <strong>10 hari kerja</strong> sesuai SOP UU No. 14 Tahun 2008.</p>
            </div>

            {{-- Actions --}}
            <div class="space-y-2 pt-2">
                <button type="button"
                        @click="triggerSyntheticDownload('Tanda_Terima_' + generatedTicket + '.pdf'); triggerToast('Mengunduh Bukti Tanda Terima (PDF)...')"
                        class="w-full py-2.5 rounded-xl bg-[#0a2558] hover:bg-[#0d3070] text-white text-xs font-bold shadow-md transition-all flex items-center justify-center gap-2">
                    <i data-lucide="download" class="w-4 h-4 text-white"></i>
                    <span>Unduh Bukti Tanda Terima (PDF)</span>
                </button>
                <div class="flex items-center gap-2">
                    <button type="button"
                            @click="showPpidSuccessModal = false; openPpidTracking(generatedTicket)"
                            class="flex-1 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-bold transition-colors">
                        Lacak Status Tiket Ini
                    </button>
                    <button type="button"
                            @click="showPpidSuccessModal = false"
                            class="flex-1 py-2 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-bold transition-colors">
                        Tutup
                    </button>
                </div>
            </div>

        </div>
