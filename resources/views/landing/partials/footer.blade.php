    <footer class="bg-slate-950 text-slate-400 text-xs py-10 sm:py-12 border-t border-slate-800 w-full overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8 text-center sm:text-left">
                
                {{-- Col 1: Identity --}}
                <div class="md:col-span-2 space-y-3">
                    <div class="inline-flex items-center bg-white px-4 py-2 rounded-2xl shadow-sm">
                        <img src="{{ asset('images/logo.png') }}" alt="Diskominfo Kabupaten Tasikmalaya" class="h-9 w-auto object-contain">
                    </div>
                    <p class="text-xs text-slate-400 leading-relaxed max-w-md mt-2">
                        Portal Pelayanan Publik Terpadu Pemerintah Kabupaten Tasikmalaya dikelola oleh Dinas Komunikasi dan Informatika (Diskominfo) untuk memberikan kemudahan akses layanan kependudukan dan surat keterangan masyarakat di 39 kecamatan.
                    </p>
                    <p class="text-[11px] text-slate-500 flex items-center justify-center sm:justify-start gap-1.5 pt-1">
                        <i data-lucide="map-pin" class="w-3.5 h-3.5 text-slate-400"></i>
                        <span>Kantor Dishubkominfo Kab. Tasikmalaya, Cintaraja, Kec. Singaparna, Kabupaten Tasikmalaya, Jawa Barat 46182</span>
                    </p>
                </div>

                {{-- Col 2: Wilayah Layanan --}}
                <div class="space-y-2">
                    <h4 class="text-white font-bold text-xs uppercase tracking-wider mb-2">Wilayah Layanan</h4>
                    <ul class="space-y-1.5 text-xs text-slate-400">
                        <li>39 Kecamatan Aktif</li>
                        <li>351 Desa se-Kab. Tasikmalaya</li>
                        <li>Layanan Terpadu Satu Pintu</li>
                        <li>Pelayanan Ramah & Transparan</li>
                    </ul>
                </div>

                {{-- Col 3: Kontak Resmi --}}
                <div class="space-y-2">
                    <h4 class="text-white font-bold text-xs uppercase tracking-wider mb-2">Kontak Resmi</h4>
                    <p class="text-slate-400">Email: <a href="mailto:diskominfo@tasikmalayakab.go.id" class="text-blue-400 hover:underline">diskominfo@tasikmalayakab.go.id</a></p>
                    <p class="text-slate-400">Telepon: <span class="text-slate-200 font-semibold">(0265) 545123</span></p>
                    <p class="text-slate-400">Jam Layanan: <span class="text-emerald-400 font-medium">08.00 - 16.00 WIB</span></p>
                </div>

            </div>

            {{-- Copyright Bar --}}
            <div class="pt-8 border-t border-slate-800/80 flex flex-col sm:flex-row items-center justify-between gap-4 text-center sm:text-left">
                <p class="text-xs text-slate-400">
                    &copy; {{ date('Y') }} Dinas Komunikasi dan Informatika (Diskominfo) Kabupaten Tasikmalaya. Seluruh Hak Cipta Dilindungi.
                </p>
                <div class="flex items-center gap-3 text-slate-500 text-xs">
                    <span>Portal Pelayanan Publik Terpadu</span>
                    <span>&bull;</span>
                    <span>Kabupaten Tasikmalaya</span>
                </div>
            </div>
        </div>
    </footer>
