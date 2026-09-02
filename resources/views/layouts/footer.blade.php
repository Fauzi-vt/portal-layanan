<footer class="bg-slate-900 text-slate-400 text-sm border-t border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
            {{-- Col 1: Government Identity --}}
            <div class="md:col-span-2 space-y-4">
                <div class="flex items-center">
                    <div class="bg-white/95 px-3.5 py-1.5 rounded-xl shadow-xs inline-flex items-center border border-white/20">
                        <x-application-logo class="h-8 sm:h-9 w-auto max-h-9" />
                    </div>
                </div>
                <p class="text-xs text-slate-400 leading-relaxed max-w-md">
                    Portal Pelayanan Publik Terintegrasi hadir untuk mewujudkan kemudahan akses administrasi kependudukan dan surat keterangan masyarakat secara cepat, transparan, akuntabel, dan bebas pungutan liar di seluruh 39 wilayah kecamatan.
                </p>
                <div class="flex items-center gap-4 text-xs text-slate-500 pt-2">
                    <span>📍 Kompleks Perkantoran Pemkab Tasikmalaya, Jl. Bojongkoneng No. 257, Singaparna</span>
                </div>
            </div>

            {{-- Col 2: Layanan Unggulan --}}
            <div>
                <h4 class="text-white font-bold text-xs uppercase tracking-wider mb-3">Layanan Utama</h4>
                <ul class="space-y-2 text-xs">
                    <li><span class="hover:text-teal-300 transition-colors">Kartu Identitas Anak (KIA)</span></li>
                    <li><span class="hover:text-teal-300 transition-colors">Perekaman e-KTP Biometrik</span></li>
                    <li><span class="hover:text-teal-300 transition-colors">Pembuatan & Perbaikan KK</span></li>
                    <li><span class="hover:text-teal-300 transition-colors">Surat Pindah Antar Kecamatan</span></li>
                    <li><span class="hover:text-teal-300 transition-colors">Surat Dispensasi Nikah</span></li>
                    <li><span class="hover:text-teal-300 transition-colors">Surat Keterangan Administrasi</span></li>
                </ul>
            </div>

            {{-- Col 3: Standar & Kontak --}}
            <div>
                <h4 class="text-white font-bold text-xs uppercase tracking-wider mb-3">Bantuan & Kontak</h4>
                <div class="space-y-2.5 text-xs">
                    <p class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                        <span class="text-slate-300">Jam Layanan:</span>
                        <span>08.00 - 16.00 WIB</span>
                    </p>
                    <p class="text-slate-400">Email: <a href="mailto:diskominfo@tasikmalayakab.go.id" class="text-teal-400 hover:underline">diskominfo@tasikmalayakab.go.id</a></p>
                    <p class="text-slate-400">Call Center: <span class="text-slate-200 font-semibold">(0265) 545123</span></p>
                    <div class="pt-2">
                        <span class="inline-flex items-center px-2.5 py-1 rounded text-[11px] bg-slate-800 text-teal-300 border border-slate-700">
                            🛡️ Standar ISO 27001 Terjamin
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-8 border-t border-slate-800/80 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-center sm:text-left">
            <p>&copy; {{ date('Y') }} Dishubkominfo Kab. Tasikmalaya. Hak Cipta Dilindungi Undang-Undang.</p>
            <div class="flex items-center gap-4 sm:gap-6 text-slate-500 text-center sm:text-right">
                <span>Pelayanan Terpadu Satu Pintu</span>
                <span>•</span>
                <span>39 Kecamatan Aktif</span>
            </div>
        </div>
    </div>
</footer>
