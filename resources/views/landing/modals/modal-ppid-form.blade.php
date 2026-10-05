    {{-- 1. MODAL: FORMULIR PERMOHONAN INFORMASI PUBLIK (PPID ONLINE) --}}
    <div x-show="showPpidModal"
         x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 overflow-y-auto"
         role="dialog"
         aria-modal="true">
        
        {{-- Backdrop --}}
        <div x-show="showPpidModal"
             x-transition:enter="ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="showPpidModal = false"
             class="fixed inset-0 bg-slate-950/70 backdrop-blur-xs"></div>

        {{-- Modal Content Card --}}
        <div x-show="showPpidModal"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:scale-95"
             class="relative bg-white rounded-3xl shadow-2xl border border-slate-100 max-w-2xl w-full overflow-hidden z-10 my-8">

            {{-- Header --}}
            <div class="px-6 py-5 bg-slate-900 text-white flex items-center justify-between border-b border-slate-800">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white/10 text-white border border-white/20 flex items-center justify-center font-bold shadow-md">
                        <i data-lucide="send" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <span class="text-[10px] uppercase tracking-wider font-bold text-slate-400">PPID Online Diskominfo</span>
                        <h3 class="text-base sm:text-lg font-black text-white leading-tight">Formulir Permohonan Informasi Publik</h3>
                    </div>
                </div>
                <button type="button" @click="showPpidModal = false" class="text-slate-400 hover:text-white p-2 rounded-xl hover:bg-white/10 transition-colors">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            {{-- Body Form --}}
            <form @submit.prevent="submitPpidForm()" class="p-6 space-y-4 text-xs max-h-[75vh] overflow-y-auto">
                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 text-[11px] leading-relaxed flex items-start gap-2">
                    <i data-lucide="info" class="w-4 h-4 text-[#0a2558] flex-shrink-0 mt-0.5"></i>
                    <span>Sesuai <strong>UU No. 14 Tahun 2008</strong>, permohonan informasi publik akan diverifikasi dalam 1-3 hari kerja dan diproses maksimal 10 hari kerja tanpa dipungut biaya (gratis).</span>
                </div>

                {{-- Kategori Pemohon --}}
                <div class="space-y-1.5">
                    <label class="font-bold text-slate-800 block">Kategori Pemohon <span class="text-rose-500">*</span></label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="flex items-center gap-2 p-3 rounded-xl border cursor-pointer transition-all"
                                :class="ppidForm.kategori === 'perorangan' ? 'border-[#0a2558] bg-slate-100 text-[#0a2558] font-bold' : 'border-slate-200 text-slate-700'">
                            <input type="radio" value="perorangan" x-model="ppidForm.kategori" class="text-[#0a2558] focus:ring-0">
                            <span>Perorangan / Warga</span>
                        </label>
                        <label class="flex items-center gap-2 p-3 rounded-xl border cursor-pointer transition-all"
                                :class="ppidForm.kategori === 'lembaga' ? 'border-[#0a2558] bg-slate-100 text-[#0a2558] font-bold' : 'border-slate-200 text-slate-700'">
                            <input type="radio" value="lembaga" x-model="ppidForm.kategori" class="text-[#0a2558] focus:ring-0">
                            <span>Lembaga / Badan Hukum</span>
                        </label>
                    </div>
                </div>

                {{-- NIK & Nama --}}400">PPID Online Diskominfo</span>
                        <h3 class="text-base sm:text-lg font-black text-white leading-tight">Formulir Permohonan Informasi Publik</h3>
                    </div>
                </div>
                <button type="button" @click="showPpidModal = false" class="text-white/70 hover:text-white p-2 rounded-xl hover:bg-white/10 transition-colors">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            {{-- Body Form --}}
            <form @submit.prevent="submitPpidForm()" class="p-6 space-y-4 text-xs max-h-[75vh] overflow-y-auto">
                <div class="p-3.5 rounded-xl bg-blue-50 border border-blue-200/80 text-blue-900 text-[11px] leading-relaxed flex items-start gap-2">
                    <i data-lucide="info" class="w-4 h-4 text-blue-600 flex-shrink-0 mt-0.5"></i>
                    <span>Sesuai <strong>UU No. 14 Tahun 2008</strong>, permohonan informasi publik akan diverifikasi dalam 1-3 hari kerja dan diproses maksimal 10 hari kerja tanpa dipungut biaya (gratis).</span>
                </div>

                {{-- Kategori Pemohon --}}
                <div class="space-y-1.5">
                    <label class="font-bold text-slate-800 block">Kategori Pemohon <span class="text-rose-500">*</span></label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="flex items-center gap-2 p-3 rounded-xl border cursor-pointer transition-all"
                               :class="ppidForm.kategori === 'perorangan' ? 'border-[#0a2558] bg-blue-50/50 text-[#0a2558] font-bold' : 'border-slate-200 text-slate-700'">
                            <input type="radio" value="perorangan" x-model="ppidForm.kategori" class="text-blue-600 focus:ring-0">
                            <span>Perorangan / Warga</span>
                        </label>
                        <label class="flex items-center gap-2 p-3 rounded-xl border cursor-pointer transition-all"
                               :class="ppidForm.kategori === 'lembaga' ? 'border-[#0a2558] bg-blue-50/50 text-[#0a2558] font-bold' : 'border-slate-200 text-slate-700'">
                            <input type="radio" value="lembaga" x-model="ppidForm.kategori" class="text-blue-600 focus:ring-0">
                            <span>Lembaga / Badan Hukum</span>
                        </label>
                    </div>
                </div>

                {{-- NIK & Nama --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="space-y-1">
                        <label class="font-bold text-slate-800 block">NIK (Nomor Induk Kependudukan) <span class="text-rose-500">*</span></label>
                        <input type="text"
                               x-model="ppidForm.nik"
                               required
                               maxlength="16"
                               placeholder="16 digit nomor KTP..."
                               class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-slate-900 font-mono">
                    </div>
                    <div class="space-y-1">
                        <label class="font-bold text-slate-800 block">Nama Lengkap Pemohon <span class="text-rose-500">*</span></label>
                        <input type="text"
                               x-model="ppidForm.nama"
                               required
                               placeholder="Sesuai kartu identitas resmi..."
                               class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-slate-900">
                    </div>
                </div>

                {{-- Kontak (No HP & Email) --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="space-y-1">
                        <label class="font-bold text-slate-800 block">No. WhatsApp / HP Aktif <span class="text-rose-500">*</span></label>
                        <input type="tel"
                               x-model="ppidForm.no_hp"
                               required
                               placeholder="0812xxxxxxxx"
                               class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-slate-900">
                    </div>
                    <div class="space-y-1">
                        <label class="font-bold text-slate-800 block">Alamat Email Aktif <span class="text-rose-500">*</span></label>
                        <input type="email"
                               x-model="ppidForm.email"
                               required
                               placeholder="nama@email.com"
                               class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-slate-900">
                    </div>
                </div>

                {{-- Alamat Domisili --}}
                <div class="space-y-1">
                    <label class="font-bold text-slate-800 block">Alamat Domisili & Kecamatan <span class="text-rose-500">*</span></label>
                    <input type="text"
                           x-model="ppidForm.alamat"
                           required
                           placeholder="Contoh: Kp. Cintaraja RT 02/04, Kec. Singaparna..."
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-slate-900">
                </div>

                {{-- Rincian Informasi yang Dibutuhkan --}}
                <div class="space-y-1">
                    <label class="font-bold text-slate-800 block">Rincian Informasi Publik yang Dimohon <span class="text-rose-500">*</span></label>
                    <textarea x-model="ppidForm.rincian"
                              rows="3"
                              required
                              placeholder="Tuliskan secara jelas judul dokumen, data statistik, atau informasi yang Anda butuhkan..."
                              class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-slate-900 leading-relaxed"></textarea>
                </div>

                {{-- Tujuan Penggunaan Informasi --}}
                <div class="space-y-1">
                    <label class="font-bold text-slate-800 block">Tujuan Penggunaan Informasi <span class="text-rose-500">*</span></label>
                    <textarea x-model="ppidForm.tujuan"
                              rows="2"
                              required
                              placeholder="Contoh: Penelitian skripsi/tesis akademik, pemenuhan persyaratan izin usaha, atau kajian kebijakan publik..."
                              class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-slate-900 leading-relaxed"></textarea>
                </div>

                {{-- Cara Memperoleh Informasi & Salinan --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="space-y-1">
                        <label class="font-bold text-slate-800 block">Bentuk Salinan Informasi</label>
                        <select x-model="ppidForm.cara_memperoleh" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl font-medium text-slate-800">
                            <option value="softcopy">Salinan Elektronik / Softcopy (PDF)</option>
                            <option value="hardcopy">Salinan Cetak / Hardcopy Dokumen</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="font-bold text-slate-800 block">Metode Pengiriman Salinan</label>
                        <select x-model="ppidForm.cara_mendapatkan" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl font-medium text-slate-800">
                            <option value="elektronik">Kirim via Email & Unduh di Portal</option>
                            <option value="ambil_langsung">Mengambil Langsung di Meja PPID</option>
                        </select>
                    </div>
                </div>

                {{-- Unggah KTP / Identitas --}}
                <div class="space-y-1">
                    <label class="font-bold text-slate-800 block">Unggah Foto / Scan KTP (Identitas Resmi) <span class="text-slate-400 font-normal">(Opsional)</span></label>
                    <div class="p-3 border-2 border-dashed border-slate-200 rounded-xl bg-slate-50/50 text-center hover:bg-slate-50 transition-colors">
                        <input type="file"
                               @change="handleKtpUpload($event)"
                               accept="image/*,application/pdf"
                               class="hidden"
                               id="ktpFileInput">
                        <label for="ktpFileInput" class="cursor-pointer block">
                            <i data-lucide="upload-cloud" class="w-6 h-6 text-slate-400 mx-auto mb-1"></i>
                            <span class="text-xs text-blue-600 font-semibold hover:underline block">Klik untuk memilih file identitas</span>
                            <span class="text-[10px] text-slate-400 block mt-0.5">Format JPG, PNG, atau PDF (Maks. 2 MB)</span>
                        </label>
                        <template x-if="ppidForm.ktp_nama">
                            <div class="mt-2 text-[11px] font-bold text-emerald-700 bg-emerald-50 py-1 px-3 rounded-md inline-flex items-center gap-1.5">
                                <i data-lucide="check-circle" class="w-3.5 h-3.5"></i>
                                <span x-text="ppidForm.ktp_nama"></span>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- Persetujuan Pernyataan --}}
                <label class="flex items-start gap-2.5 pt-2 text-slate-600 cursor-pointer">
                    <input type="checkbox" required class="rounded border-slate-300 text-blue-600 focus:ring-0 mt-0.5">
                    <span class="text-[11px] leading-tight">Saya menyatakan bahwa data yang diisikan adalah benar dan saya bersedia mematuhi ketentuan perundang-undangan terkait pemanfaatan informasi publik.</span>
                </label>

                {{-- Footer Actions --}}
                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-2.5">
                    <button type="button"
                            @click="showPpidModal = false"
                            class="px-4 py-2 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-100 font-bold transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                            class="px-6 py-2 rounded-xl bg-[#0a2558] hover:bg-[#0d3070] text-white font-bold shadow-md transition-all flex items-center gap-2">
                        <i data-lucide="send" class="w-3.5 h-3.5 text-amber-400"></i>
                        <span>Kirim Permohonan Informasi</span>
                    </button>
                </div>
            </form>

        </div>

    </div>
