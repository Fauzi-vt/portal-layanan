    @php
        $kecamatanTableData = $kecamatans->map(function ($kec) {
            $actualDesas = $kec->desas ?? collect();
            $desaCount = $kec->total_desa;
            $rwCount = $kec->total_rw;
            $rtCount = $kec->total_rt;

            return [
                'id' => $kec->id,
                'kode' => $kec->kode_kecamatan ?: ('KEC-' . str_pad($kec->id, 3, '0', STR_PAD_LEFT)),
                'nama' => $kec->nama_kecamatan,
                'desa_count' => $desaCount,
                'rw_count' => $rwCount,
                'rt_count' => $rtCount,
                'alamat' => $kec->alamat_kantor ?: ('Jl. Raya ' . $kec->nama_kecamatan . ' No. 01, Kab. Tasikmalaya, Jawa Barat 46182'),
                'telepon' => $kec->telepon ?: ('(0265) 54' . str_pad($kec->id, 4, '0', STR_PAD_LEFT)),
                'email' => $kec->email ?: ('kecamatan.' . \Illuminate\Support\Str::slug($kec->nama_kecamatan) . '@tasikmalayakab.go.id'),
                'jam' => $kec->jam_operasional ?: 'Senin - Jumat (08.00 - 15.30 WIB)',
                'desas' => $actualDesas->map(fn($d) => [
                    'kode' => $d->kode_desa,
                    'nama' => $d->nama_desa,
                    'rw' => $d->jumlah_rw ?? 0,
                    'rt' => $d->jumlah_rt ?? 0,
                ])->values()->all(),
            ];
        })->values()->all();
    @endphp

    <section id="kewilayahan"
             class="py-20 bg-gradient-to-b from-slate-50 via-white to-slate-50/80 border-t border-slate-200/80 relative overflow-hidden scroll-mt-14"
             x-data="{
                 searchQuery: '',
                 perPage: 10,
                 currentPage: 1,
                 sortCol: 'nama',
                 sortAsc: true,
                 showModal: false,
                 selectedKec: null,
                 rawData: {{ Js::from($kecamatanTableData) }},

                 sortBy(col) {
                     if (this.sortCol === col) {
                         this.sortAsc = !this.sortAsc;
                     } else {
                         this.sortCol = col;
                         this.sortAsc = true;
                     }
                     this.currentPage = 1;
                 },

                 get filteredData() {
                     let q = this.searchQuery.toLowerCase().trim();
                     let data = this.rawData.filter(item => {
                         return !q ||
                             item.nama.toLowerCase().includes(q) ||
                             item.kode.toLowerCase().includes(q) ||
                             item.desa_count.toString().includes(q) ||
                             item.rw_count.toString().includes(q) ||
                             item.rt_count.toString().includes(q);
                     });

                     data.sort((a, b) => {
                         let valA = a[this.sortCol];
                         let valB = b[this.sortCol];
                         if (typeof valA === 'string') {
                             return this.sortAsc
                                 ? valA.localeCompare(valB)
                                 : valB.localeCompare(valA);
                         }
                         return this.sortAsc ? (valA - valB) : (valB - valA);
                     });

                     return data;
                 },

                 get paginatedData() {
                     if (this.perPage >= 999) return this.filteredData;
                     let start = (this.currentPage - 1) * this.perPage;
                     return this.filteredData.slice(start, start + parseInt(this.perPage));
                 },

                 get totalPages() {
                     if (this.perPage >= 999) return 1;
                     return Math.ceil(this.filteredData.length / this.perPage) || 1;
                 },

                 openDetail(item) {
                     this.selectedKec = item;
                     this.showModal = true;
                     this.$nextTick(() => {
                         if (window.lucide) window.lucide.createIcons();
                     });
                 }
             }">

        {{-- Subtle ambient blur decorative accents --}}
        <div class="absolute -top-32 -right-32 w-96 h-96 bg-blue-500/5 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-32 -left-32 w-96 h-96 bg-slate-400/5 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

            {{-- 1. Section Header: Executive Government Style --}}
            <div class="text-center max-w-3xl mx-auto mb-10">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-50 text-[#0a2558] border border-blue-200/80 text-xs font-bold shadow-2xs mb-3">
                    <i data-lucide="map" class="w-3.5 h-3.5 text-[#0a2558]"></i>
                    <span>Pemerintah Kabupaten Tasikmalaya</span>
                    <span class="w-1 h-1 rounded-full bg-blue-300"></span>
                    <span class="text-slate-500 font-medium">Data Administrasi Kewilayahan</span>
                </div>

                <h2 class="text-2xl sm:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                    Tabel Data Kecamatan & Kelurahan
                </h2>
                <p class="text-xs sm:text-sm text-slate-600 mt-2.5 leading-relaxed max-w-2xl mx-auto">
                    Transparansi data persebaran wilayah administratif meliputi <strong>39 Kecamatan</strong>, <strong>351 Desa/Kelurahan</strong>, serta cakupan Rukun Warga (RW) dan Rukun Tetangga (RT) di Kabupaten Tasikmalaya.
                </p>

                {{-- Quick Summary KPI Cards --}}
                <div class="flex flex-wrap items-center justify-center gap-3 pt-6">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white border border-slate-200/80 shadow-2xs text-xs font-semibold text-slate-700">
                        <span class="w-2.5 h-2.5 rounded-full bg-[#0a2558]"></span>
                        <span>Total: <strong class="text-slate-900 font-extrabold">39 Kecamatan</strong></span>
                    </div>
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white border border-slate-200/80 shadow-2xs text-xs font-semibold text-slate-700">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
                        <span>Total: <strong class="text-slate-900 font-extrabold">351 Desa / Kelurahan</strong></span>
                    </div>
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white border border-slate-200/80 shadow-2xs text-xs font-semibold text-slate-700">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                        <span>Status Sistem: <strong class="text-emerald-700 font-extrabold">Terintegrasi Online</strong></span>
                    </div>
                </div>
            </div>

            {{-- 2. White Card Container --}}
            <div class="bg-white rounded-2xl shadow-xl shadow-slate-200/50 border border-slate-200/80 overflow-hidden">

                {{-- Controls Toolbar: Search (Left) & Show Entries + Counter (Right) --}}
                <div class="p-4 sm:p-5 border-b border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3.5">
                    
                    {{-- Search Input with Clear Button --}}
                    <div class="relative w-full sm:w-80">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input id="kecamatanFilter"
                               type="text"
                               x-model="searchQuery"
                               @input="currentPage = 1"
                               placeholder="Cari kecamatan, kode, atau desa..."
                               class="w-full pl-9 pr-9 py-2 text-xs sm:text-sm bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#0a2558]/20 focus:border-[#0a2558] text-slate-800 placeholder-slate-400 shadow-2xs transition-all">
                        <button x-show="searchQuery"
                                @click="searchQuery = ''; currentPage = 1"
                                type="button"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 transition-colors"
                                title="Hapus pencarian">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    {{-- Right Controls: Results Count & Show Dropdown --}}
                    <div class="flex items-center justify-between sm:justify-end gap-3 text-xs">
                        <div class="text-slate-500 font-medium">
                            Ditemukan <strong class="text-[#0a2558] font-bold" x-text="filteredData.length"></strong> wilayah
                        </div>

                        <div class="flex items-center gap-1.5">
                            <label for="showPerPage" class="font-semibold text-slate-600">Tampilkan:</label>
                            <div class="relative">
                                <select id="showPerPage"
                                        x-model="perPage"
                                        @change="currentPage = 1"
                                        class="appearance-none bg-white border border-slate-200 rounded-xl px-3 py-1.5 pr-8 text-xs font-bold text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#0a2558]/20 focus:border-[#0a2558] shadow-2xs cursor-pointer">
                                    <option value="10">10 data</option>
                                    <option value="25">25 data</option>
                                    <option value="50">50 data</option>
                                    <option value="999">Semua</option>
                                </select>
                                <svg class="w-3.5 h-3.5 text-slate-400 absolute right-2.5 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Table Responsive Area --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left border-collapse">
                        {{-- Executive Navy Header --}}
                        <thead>
                            <tr class="bg-[#0a2558] text-white font-bold select-none text-xs tracking-wider uppercase">
                                <th scope="col" class="py-3.5 px-4 sm:px-5 w-14 text-center text-blue-200 font-semibold">
                                    No
                                </th>
                                <th scope="col" @click="sortBy('nama')" class="py-3.5 px-4 sm:px-6 cursor-pointer hover:bg-[#0d3070] transition-colors group">
                                    <div class="flex items-center justify-between gap-2">
                                        <span>Kecamatan & Kode</span>
                                        <span class="inline-flex items-center text-blue-200 group-hover:text-white"
                                              :class="{ 'text-amber-300 font-black': sortCol === 'nama' }">
                                            <svg class="w-3.5 h-3.5 transition-transform" :class="sortCol === 'nama' && !sortAsc ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 11l5-5 5 5M7 13l5 5 5-5" />
                                            </svg>
                                        </span>
                                    </div>
                                </th>
                                <th scope="col" @click="sortBy('desa_count')" class="py-3.5 px-4 sm:px-6 cursor-pointer hover:bg-[#0d3070] transition-colors group text-center sm:text-left">
                                    <div class="flex items-center justify-center sm:justify-between gap-2">
                                        <span>Desa / Kelurahan</span>
                                        <span class="inline-flex items-center text-blue-200 group-hover:text-white"
                                              :class="{ 'text-amber-300 font-black': sortCol === 'desa_count' }">
                                            <svg class="w-3.5 h-3.5 transition-transform" :class="sortCol === 'desa_count' && !sortAsc ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 11l5-5 5 5M7 13l5 5 5-5" />
                                            </svg>
                                        </span>
                                    </div>
                                </th>
                                <th scope="col" @click="sortBy('rw_count')" class="py-3.5 px-4 sm:px-6 cursor-pointer hover:bg-[#0d3070] transition-colors group text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <span>RW</span>
                                        <span class="inline-flex items-center text-blue-200 group-hover:text-white"
                                              :class="{ 'text-amber-300 font-black': sortCol === 'rw_count' }">
                                            <svg class="w-3 h-3 transition-transform" :class="sortCol === 'rw_count' && !sortAsc ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 11l5-5 5 5M7 13l5 5 5-5" />
                                            </svg>
                                        </span>
                                    </div>
                                </th>
                                <th scope="col" @click="sortBy('rt_count')" class="py-3.5 px-4 sm:px-6 cursor-pointer hover:bg-[#0d3070] transition-colors group text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <span>RT</span>
                                        <span class="inline-flex items-center text-blue-200 group-hover:text-white"
                                              :class="{ 'text-amber-300 font-black': sortCol === 'rt_count' }">
                                            <svg class="w-3 h-3 transition-transform" :class="sortCol === 'rt_count' && !sortAsc ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 11l5-5 5 5M7 13l5 5 5-5" />
                                            </svg>
                                        </span>
                                    </div>
                                </th>
                                <th scope="col" class="py-3.5 px-4 sm:px-6 text-center w-28">
                                    Aksi
                                </th>
                            </tr>
                        </thead>

                        {{-- Body Rows --}}
                        <tbody class="divide-y divide-slate-100 bg-white">
                            <template x-for="(item, idx) in paginatedData" :key="item.id">
                                <tr @click="openDetail(item)"
                                    class="odd:bg-white even:bg-slate-50/40 hover:bg-blue-50/50 transition-colors cursor-pointer group text-slate-700">
                                    
                                    {{-- Index Number --}}
                                    <td class="py-3.5 px-4 sm:px-5 text-center text-xs font-semibold text-slate-400 font-mono"
                                        x-text="((currentPage - 1) * (perPage >= 999 ? 0 : perPage)) + idx + 1">
                                    </td>

                                    {{-- Kecamatan & Kode Wilayah --}}
                                    <td class="py-3.5 px-4 sm:px-6">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-blue-50 text-[#0a2558] border border-blue-100 flex items-center justify-center flex-shrink-0 group-hover:bg-[#0a2558] group-hover:text-white transition-all shadow-2xs">
                                                <i data-lucide="map-pin" class="w-4 h-4"></i>
                                            </div>
                                            <div>
                                                <div class="font-bold text-slate-900 group-hover:text-[#0a2558] transition-colors text-sm" x-text="item.nama"></div>
                                                <div class="text-[10px] text-slate-400 font-mono tracking-wider" x-text="item.kode"></div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Desa / Kelurahan Count Badge --}}
                                    <td class="py-3.5 px-4 sm:px-6 text-center sm:text-left">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-blue-50/80 text-[#0a2558] border border-blue-100/90 shadow-2xs">
                                            <i data-lucide="home" class="w-3.5 h-3.5 text-blue-500"></i>
                                            <span x-text="item.desa_count + ' Desa'"></span>
                                        </span>
                                    </td>

                                    {{-- RW Count Badge --}}
                                    <td class="py-3.5 px-4 sm:px-6 text-center">
                                        <span class="inline-flex items-center justify-center min-w-[50px] px-2 py-0.5 rounded-md text-xs font-bold bg-slate-100 text-slate-700 border border-slate-200/60 font-mono"
                                              x-text="item.rw_count">
                                        </span>
                                    </td>

                                    {{-- RT Count Badge --}}
                                    <td class="py-3.5 px-4 sm:px-6 text-center">
                                        <span class="inline-flex items-center justify-center min-w-[50px] px-2 py-0.5 rounded-md text-xs font-bold bg-slate-100 text-slate-700 border border-slate-200/60 font-mono"
                                              x-text="item.rt_count">
                                        </span>
                                    </td>

                                    {{-- Action Button --}}
                                    <td class="py-3.5 px-4 sm:px-6 text-center" @click.stop>
                                        <button type="button"
                                                @click="openDetail(item)"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-slate-100 hover:bg-[#0a2558] text-slate-700 hover:text-white border border-slate-200 hover:border-[#0a2558] transition-all shadow-2xs group/btn cursor-pointer">
                                            <span>Detail</span>
                                            <svg class="w-3 h-3 transition-transform group-hover/btn:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            </template>

                            {{-- Empty State --}}
                            <tr x-show="filteredData.length === 0">
                                <td colspan="6" class="py-12 text-center text-slate-500 bg-slate-50/50">
                                    <div class="w-12 h-12 rounded-2xl bg-white border border-slate-200 text-slate-400 flex items-center justify-center mx-auto mb-2.5 shadow-2xs">
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <p class="font-bold text-sm text-slate-700">Tidak ada kecamatan yang cocok</p>
                                    <p class="text-xs text-slate-400 mt-0.5 max-w-sm mx-auto">
                                        Pencarian dengan kata kunci "<span class="font-bold text-slate-700" x-text="searchQuery"></span>" tidak menemukan hasil.
                                    </p>
                                    <button type="button"
                                            @click="searchQuery = ''; currentPage = 1"
                                            class="mt-3 inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg text-xs font-bold text-[#0a2558] bg-blue-50 hover:bg-blue-100 transition-colors cursor-pointer">
                                        Reset Filter Pencarian
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Pagination & Summary Footer --}}
                <div class="p-4 sm:p-5 border-t border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-600">
                    <div>
                        Menampilkan
                        <span class="font-bold text-slate-900" x-text="filteredData.length === 0 ? 0 : ((currentPage - 1) * perPage + 1)"></span>
                        sampai
                        <span class="font-bold text-slate-900" x-text="Math.min(currentPage * perPage, filteredData.length)"></span>
                        dari
                        <span class="font-bold text-slate-900" x-text="filteredData.length"></span>
                        wilayah kecamatan
                    </div>

                    <div class="flex items-center gap-1" x-show="totalPages > 1">
                        <button type="button"
                                @click="currentPage = Math.max(1, currentPage - 1)"
                                :disabled="currentPage === 1"
                                class="px-3 py-1.5 rounded-lg border border-slate-200 bg-white text-slate-600 hover:bg-slate-100 disabled:opacity-40 disabled:cursor-not-allowed font-semibold transition-all shadow-2xs flex items-center gap-1 cursor-pointer">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                            <span>Sebelumnya</span>
                        </button>

                        <div class="flex items-center gap-1 px-1">
                            <template x-for="p in totalPages" :key="p">
                                <button type="button"
                                        @click="currentPage = p"
                                        x-text="p"
                                        class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg border text-xs font-bold transition-all flex items-center justify-center shadow-2xs cursor-pointer"
                                        :class="currentPage === p ? 'bg-[#0a2558] border-[#0a2558] text-white shadow-xs' : 'bg-white border-slate-200 text-slate-700 hover:bg-slate-100'">
                                </button>
                            </template>
                        </div>

                        <button type="button"
                                @click="currentPage = Math.min(totalPages, currentPage + 1)"
                                :disabled="currentPage === totalPages"
                                class="px-3 py-1.5 rounded-lg border border-slate-200 bg-white text-slate-600 hover:bg-slate-100 disabled:opacity-40 disabled:cursor-not-allowed font-semibold transition-all shadow-2xs flex items-center gap-1 cursor-pointer">
                            <span>Selanjutnya</span>
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>

            </div>

        </div>

        {{-- 3. Detail Modal Window --}}
        <div x-show="showModal"
             x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 overflow-y-auto"
             role="dialog"
             aria-modal="true">

            {{-- Backdrop --}}
            <div x-show="showModal"
                 x-transition:enter="ease-out duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-150"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="showModal = false"
                 class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs">
            </div>

            {{-- Modal Content Card --}}
            <div x-show="showModal"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative bg-white rounded-3xl shadow-2xl border border-slate-100 max-w-2xl w-full overflow-hidden z-10 my-8">

                {{-- Modal Header --}}
                <div class="px-6 py-5 bg-gradient-to-r from-[#0a2558] to-[#164e87] text-white flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-white font-bold">
                            <i data-lucide="map-pin" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <span class="text-[11px] uppercase tracking-wider font-semibold text-blue-200" x-text="'Kode Wilayah: ' + (selectedKec?.kode || '-')"></span>
                            <h3 class="text-xl font-bold" x-text="'Kecamatan ' + (selectedKec?.nama || '')"></h3>
                        </div>
                    </div>
                    <button type="button" @click="showModal = false" class="text-white/70 hover:text-white p-2 rounded-xl hover:bg-white/10 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                {{-- Modal Body --}}
                <div class="p-6 space-y-5 text-sm text-slate-600">

                    {{-- 3 Quick Stats Pill --}}
                    <div class="grid grid-cols-3 gap-3">
                        <div class="bg-blue-50/80 border border-blue-100 rounded-2xl p-3.5 text-center">
                            <span class="block text-2xl font-black text-[#0a2558]" x-text="selectedKec?.desa_count"></span>
                            <span class="text-xs font-semibold text-blue-700">Desa / Kelurahan</span>
                        </div>
                        <div class="bg-amber-50/80 border border-amber-100 rounded-2xl p-3.5 text-center">
                            <span class="block text-2xl font-black text-amber-900" x-text="selectedKec?.rw_count"></span>
                            <span class="text-xs font-semibold text-amber-700">Rukun Warga (RW)</span>
                        </div>
                        <div class="bg-emerald-50/80 border border-emerald-100 rounded-2xl p-3.5 text-center">
                            <span class="block text-2xl font-black text-emerald-900" x-text="selectedKec?.rt_count"></span>
                            <span class="text-xs font-semibold text-emerald-700">Rukun Tetangga (RT)</span>
                        </div>
                    </div>

                    {{-- Info Kantor --}}
                    <div class="bg-slate-50 rounded-2xl p-4 border border-slate-200/80 space-y-2.5">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-800 flex items-center gap-1.5">
                            <i data-lucide="building-2" class="w-4 h-4 text-blue-600"></i>
                            <span>Informasi Kantor Kecamatan</span>
                        </h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                            <div>
                                <span class="text-slate-400 block">Alamat Kantor:</span>
                                <span class="text-slate-800 font-medium" x-text="selectedKec?.alamat"></span>
                            </div>
                            <div>
                                <span class="text-slate-400 block">Jam Operasional:</span>
                                <span class="text-emerald-700 font-medium" x-text="selectedKec?.jam"></span>
                            </div>
                            <div>
                                <span class="text-slate-400 block">Nomor Telepon:</span>
                                <span class="text-slate-800 font-medium" x-text="selectedKec?.telepon"></span>
                            </div>
                            <div>
                                <span class="text-slate-400 block">Email Resmi:</span>
                                <span class="text-blue-600 font-medium" x-text="selectedKec?.email"></span>
                            </div>
                        </div>
                    </div>

                    {{-- Daftar Desa/Kelurahan --}}
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-800">
                                Wilayah Kerja Desa / Kelurahan
                            </h4>
                            <span class="text-xs font-medium text-slate-500" x-text="selectedKec?.desas?.length ? (selectedKec.desas.length + ' Desa Terdata') : (selectedKec?.desa_count + ' Wilayah Desa')"></span>
                        </div>

                        <div class="max-h-48 overflow-y-auto pr-1">
                            <template x-if="selectedKec?.desas && selectedKec.desas.length > 0">
                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                                    <template x-for="desa in selectedKec.desas" :key="desa.kode">
                                        <div class="px-3 py-2 bg-white border border-slate-200 rounded-xl flex items-center gap-2 shadow-2xs">
                                            <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                                            <div class="truncate">
                                                <p class="text-xs font-semibold text-slate-800 truncate" x-text="desa.nama"></p>
                                                <p class="text-[10px] text-slate-400 truncate" x-text="desa.kode"></p>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </template>

                            <template x-if="!selectedKec?.desas || selectedKec.desas.length === 0">
                                <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-600 flex items-center gap-2.5">
                                    <i data-lucide="info" class="w-4 h-4 text-blue-500 flex-shrink-0"></i>
                                    <span>Kecamatan ini mengoordinasikan <strong class="text-slate-800" x-text="selectedKec?.desa_count"></strong> desa/kelurahan aktif yang terhubung dalam sistem pelayanan administrasi terpadu Diskominfo Kab. Tasikmalaya.</span>
                                </div>
                            </template>
                        </div>
                    </div>

                </div>

                {{-- Modal Footer --}}
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-3">
                    <button type="button"
                            @click="showModal = false"
                            class="px-4 py-2 text-xs font-bold text-slate-600 hover:text-slate-800 bg-white hover:bg-slate-100 border border-slate-200 rounded-xl transition-colors">
                        Tutup
                    </button>
                    @auth
                        <a href="{{ route('warga.submissions.index') }}"
                           class="px-5 py-2 text-xs font-bold text-white bg-[#0a2558] hover:bg-[#0d3070] rounded-xl shadow-md transition-all">
                            Ajukan Permohonan di Kecamatan Ini
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="px-5 py-2 text-xs font-bold text-white bg-[#0a2558] hover:bg-[#0d3070] rounded-xl shadow-md transition-all cursor-pointer">
                            Masuk & Ajukan Layanan
                        </a>
                    @endauth
                </div>

            </div>
        </div>
    </section>
