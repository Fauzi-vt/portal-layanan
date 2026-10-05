        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-5">
            <div>
                <h2 class="text-base font-bold text-slate-900">Permohonan Baru</h2>
                <p class="text-xs text-slate-500 mt-0.5">Pilih jenis layanan yang ingin Anda ajukan.</p>
            </div>
            <div class="relative w-full sm:w-96">
                <input type="text" x-model="searchQuery"
                    placeholder="Telusuri layanan di sini…"
                    class="w-full pl-5 pr-14 py-2.5 rounded-full bg-white border border-slate-200 text-xs sm:text-sm text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600 shadow-sm">
                <button type="button" class="absolute right-1 top-1 bottom-1 w-9 h-9 rounded-full bg-[#0b256b] text-white flex items-center justify-center hover:bg-[#081c52] transition-colors cursor-pointer">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </button>
            </div>
        </div>

        <div class="space-y-3.5">
            @php
                $kkServices   = $services->filter(fn($s) => in_array($s->kode_layanan, ['KK_BARU','KK_ADD','KK_DEL']));
                $moveServices = $services->filter(fn($s) => in_array($s->kode_layanan, ['PINDAH_SATU_DESA','PINDAH_ANTAR_DESA','PINDAH_ANTAR_KEC']));
                $kkRendered   = false;
                $moveRendered = false;
            @endphp

            @foreach ($services as $srv)
                @if (in_array($srv->kode_layanan, ['KK_BARU','KK_ADD','KK_DEL']))
                    @if (!$kkRendered)
                        @php $kkRendered = true; @endphp
                        <div x-data="{ open: false }"
                             x-init="$watch('searchQuery', v => { if(v.trim()) open = true; })"
                             x-show="searchQuery === '' || 'layanan kartu keluarga pembuatan kk baru perbaikan kk penambahan anggota keluarga pengurangan anggota keluarga'.includes(searchQuery.toLowerCase())"
                             class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                            <button type="button" @click="open = !open; $nextTick(() => window.lucide?.createIcons())"
                                    class="w-full p-4 sm:p-5 flex items-center justify-between text-left hover:bg-slate-50 transition-colors group cursor-pointer">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-[#0a2558] border border-blue-100 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform">
                                        <i data-lucide="users" class="w-6 h-6"></i>
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <h3 class="text-sm sm:text-base font-bold text-slate-900 group-hover:text-blue-700">Layanan Kartu Keluarga</h3>
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-blue-100 text-blue-800">3 Sub-Layanan</span>
                                        </div>
                                        <p class="text-xs text-slate-500 mt-0.5">KK Baru, Penambahan Anggota, Pengurangan Anggota</p>
                                    </div>
                                </div>
                                <div class="pl-4 flex-shrink-0 flex items-center gap-2">
                                    <span class="text-xs font-semibold text-slate-400 group-hover:text-blue-600 hidden sm:inline" x-text="open ? 'Tutup' : 'Pilih Jenis'"></span>
                                    <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center transition-all duration-200" :class="{'rotate-180 bg-blue-50 text-blue-700': open}">
                                        <i data-lucide="chevron-down" class="w-5 h-5"></i>
                                    </div>
                                </div>
                            </button>
                            <div x-show="open" x-cloak x-transition class="border-t border-slate-100 bg-slate-50/50 p-3 sm:p-4 space-y-2.5">
                                @foreach ($kkServices as $kkSrv)
                                    <a href="{{ route('warga.submissions.create', ['service' => $kkSrv->kode_layanan]) }}"
                                       x-show="searchQuery === '' || '{{ strtolower($kkSrv->nama_layanan . ' ' . $kkSrv->kode_layanan . ' ' . $kkSrv->deskripsi) }}'.includes(searchQuery.toLowerCase())"
                                       class="bg-white rounded-lg border border-slate-200 hover:border-blue-500 hover:shadow-sm p-3.5 sm:p-4 flex items-center justify-between transition-all group block">
                                        <div class="flex items-center gap-3.5">
                                            <div class="w-9 h-9 rounded-lg bg-blue-50 text-[#0a2558] border border-blue-100 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform">
                                                @if ($kkSrv->kode_layanan === 'KK_BARU') <i data-lucide="users" class="w-4 h-4"></i>
                                                @elseif ($kkSrv->kode_layanan === 'KK_ADD') <i data-lucide="user-plus" class="w-4 h-4"></i>
                                                @elseif ($kkSrv->kode_layanan === 'KK_DEL') <i data-lucide="user-minus" class="w-4 h-4"></i>
                                                @endif
                                            </div>
                                            <div>
                                                <h4 class="text-xs sm:text-sm font-bold text-slate-800 group-hover:text-blue-700">{{ $kkSrv->nama_layanan }}</h4>
                                                <p class="text-[11px] sm:text-xs text-slate-500 mt-0.5 line-clamp-1">{{ $kkSrv->deskripsi }}</p>
                                            </div>
                                        </div>
                                        <i data-lucide="arrow-right" class="w-4 h-4 text-amber-500 group-hover:translate-x-1 transition-transform flex-shrink-0"></i>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @elseif (in_array($srv->kode_layanan, ['PINDAH_SATU_DESA','PINDAH_ANTAR_DESA','PINDAH_ANTAR_KEC','PINDAH','DATANG']))
                    @if (!$moveRendered)
                        @php $moveRendered = true; @endphp
                        <div x-data="{ open: false }"
                             x-init="$watch('searchQuery', v => { if(v.trim()) open = true; })"
                             x-show="searchQuery === '' || 'layanan perpindahan penduduk permohonan pindah datang wni satu desa antar desa kecamatan'.includes(searchQuery.toLowerCase())"
                             class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                            <button type="button" @click="open = !open; $nextTick(() => window.lucide?.createIcons())"
                                    class="w-full p-4 sm:p-5 flex items-center justify-between text-left hover:bg-slate-50 transition-colors group cursor-pointer">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-700 border border-indigo-100 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform">
                                        <i data-lucide="truck" class="w-6 h-6"></i>
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <h3 class="text-sm sm:text-base font-bold text-slate-900 group-hover:text-indigo-700">Layanan Perpindahan Penduduk</h3>
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-indigo-100 text-indigo-800">3 Sub-Layanan</span>
                                        </div>
                                        <p class="text-xs text-slate-500 mt-0.5">Pindah Datang WNI (Satu Desa, Antar Desa, Antar Kecamatan)</p>
                                    </div>
                                </div>
                                <div class="pl-4 flex-shrink-0 flex items-center gap-2">
                                    <span class="text-xs font-semibold text-slate-400 group-hover:text-indigo-600 hidden sm:inline" x-text="open ? 'Tutup' : 'Pilih Jenis'"></span>
                                    <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center transition-all duration-200" :class="{'rotate-180 bg-indigo-50 text-indigo-700': open}">
                                        <i data-lucide="chevron-down" class="w-5 h-5"></i>
                                    </div>
                                </div>
                            </button>
                            <div x-show="open" x-cloak x-transition class="border-t border-slate-100 bg-slate-50/50 p-3 sm:p-4 space-y-2.5">
                                @foreach ($moveServices as $moveSrv)
                                    <a href="{{ route('warga.submissions.create', ['service' => $moveSrv->kode_layanan]) }}"
                                       x-show="searchQuery === '' || '{{ strtolower($moveSrv->nama_layanan . ' ' . $moveSrv->kode_layanan . ' ' . $moveSrv->deskripsi) }}'.includes(searchQuery.toLowerCase())"
                                       class="bg-white rounded-lg border border-slate-200 hover:border-indigo-500 hover:shadow-sm p-3.5 sm:p-4 flex items-center justify-between transition-all group block">
                                        <div class="flex items-center gap-3.5">
                                            <div class="w-9 h-9 rounded-lg bg-indigo-50 text-indigo-700 border border-indigo-100 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform">
                                                @if ($moveSrv->kode_layanan === 'PINDAH_SATU_DESA') <i data-lucide="home" class="w-4 h-4"></i>
                                                @elseif ($moveSrv->kode_layanan === 'PINDAH_ANTAR_DESA') <i data-lucide="building-2" class="w-4 h-4"></i>
                                                @elseif ($moveSrv->kode_layanan === 'PINDAH_ANTAR_KEC') <i data-lucide="map" class="w-4 h-4"></i>
                                                @else <i data-lucide="truck" class="w-4 h-4"></i>
                                                @endif
                                            </div>
                                            <div>
                                                <h4 class="text-xs sm:text-sm font-bold text-slate-800 group-hover:text-indigo-700">{{ $moveSrv->nama_layanan }}</h4>
                                                <p class="text-[11px] sm:text-xs text-slate-500 mt-0.5 line-clamp-1">{{ $moveSrv->deskripsi }}</p>
                                            </div>
                                        </div>
                                        <i data-lucide="arrow-right" class="w-4 h-4 text-amber-500 group-hover:translate-x-1 transition-transform flex-shrink-0"></i>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @else
                    <a href="{{ route('warga.submissions.create', ['service' => $srv->kode_layanan]) }}"
                       x-show="searchQuery === '' || '{{ strtolower($srv->nama_layanan . ' ' . $srv->kode_layanan . ' ' . $srv->deskripsi) }}'.includes(searchQuery.toLowerCase())"
                       class="bg-white rounded-xl border border-slate-200 shadow-sm hover:border-blue-400 hover:shadow-md p-4 sm:p-5 flex items-center justify-between transition-all group block">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center text-[#0a2558] flex-shrink-0 group-hover:scale-105 transition-transform">
                                @if ($srv->kode_layanan === 'KIA') <i data-lucide="contact" class="w-6 h-6"></i>
                                @elseif ($srv->kode_layanan === 'EKTP') <i data-lucide="camera" class="w-6 h-6"></i>
                                @elseif ($srv->kode_layanan === 'NIKAH') <i data-lucide="heart" class="w-6 h-6"></i>
                                @else <i data-lucide="file-text" class="w-6 h-6"></i>
                                @endif
                            </div>
                            <div>
                                <h3 class="text-sm sm:text-base font-semibold text-slate-800 group-hover:text-blue-700">{{ $srv->nama_layanan }}</h3>
                                <p class="text-xs text-slate-500 mt-0.5 line-clamp-1">{{ $srv->deskripsi }}</p>
                            </div>
                        </div>
                        <svg class="w-6 h-6 text-amber-500 group-hover:translate-x-1 transition-transform flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                @endif
            @endforeach
        </div>
