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
             class="pt-12 pb-20 bg-[#8cb7ee] relative overflow-hidden"
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

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- 1. Dark Navy Title Banner Pill (Identik dengan Screenshot) --}}
            <div class="flex justify-center mb-6">
                <div class="bg-[#0e3a6c] text-white font-bold text-lg sm:text-2xl px-8 sm:px-14 py-3 rounded-lg shadow-md border border-white/10 tracking-wide text-center">
                    Tabel Data Kecamatan Kabupaten Tasikmalaya
                </div>
            </div>

            {{-- 2. White Card Container --}}
            <div class="bg-white rounded-2xl shadow-xl border border-slate-200/80 p-5 sm:p-8">

                {{-- Controls Row: Filter (Left) & Show (Right) --}}
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4 mb-6">
                    {{-- Filter Input --}}
                    <div class="flex items-center gap-2">
                        <label for="kecamatanFilter" class="text-sm font-semibold text-slate-700">Filter:</label>
                        <div class="relative w-full sm:w-64">
                            <input id="kecamatanFilter"
                                   type="text"
                                   x-model="searchQuery"
                                   @input="currentPage = 1"
                                   placeholder="Type to filter..."
                                   class="w-full pl-3 pr-9 py-1.5 text-sm bg-white border border-slate-300 rounded focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 text-slate-800 placeholder-slate-400">
                            <div class="absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    {{-- Show Per Page Select --}}
                    <div class="flex items-center justify-end gap-2">
                        <label for="showPerPage" class="text-sm font-semibold text-slate-700">Show:</label>
                        <div class="relative">
                            <select id="showPerPage"
                                    x-model="perPage"
                                    @change="currentPage = 1"
                                    class="appearance-none bg-white border border-slate-300 rounded px-3 py-1.5 pr-8 text-sm font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 cursor-pointer">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="999">Semua</option>
                            </select>
                            <svg class="w-4 h-4 text-slate-500 absolute right-2 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Table Responsive Wrapper --}}
                <div class="overflow-x-auto rounded border border-slate-200">
                    <table class="w-full text-sm text-left border-collapse">
                        {{-- Blue Header Sesuai Screenshot --}}
                        <thead>
                            <tr class="bg-[#0088e8] text-white font-bold select-none text-xs sm:text-sm">
                                <th scope="col" @click="sortBy('nama')" class="py-3 px-4 sm:px-6 cursor-pointer hover:bg-[#007cd3] transition-colors">
                                    <div class="flex items-center gap-1.5">
                                        <span>Kecamatan</span>
                                        <span class="text-sky-200 text-xs" :class="{ 'text-white font-extrabold': sortCol === 'nama' }">â†•</span>
                                    </div>
                                </th>
                                <th scope="col" @click="sortBy('desa_count')" class="py-3 px-4 sm:px-6 cursor-pointer hover:bg-[#007cd3] transition-colors">
                                    <div class="flex items-center gap-1.5">
                                        <span>Kelurahan</span>
                                        <span class="text-sky-200 text-xs" :class="{ 'text-white font-extrabold': sortCol === 'desa_count' }">â†•</span>
                                    </div>
                                </th>
                                <th scope="col" @click="sortBy('rw_count')" class="py-3 px-4 sm:px-6 cursor-pointer hover:bg-[#007cd3] transition-colors">
                                    <div class="flex items-center gap-1.5">
                                        <span>RW</span>
                                        <span class="text-sky-200 text-xs" :class="{ 'text-white font-extrabold': sortCol === 'rw_count' }">â†•</span>
                                    </div>
                                </th>
                                <th scope="col" @click="sortBy('rt_count')" class="py-3 px-4 sm:px-6 cursor-pointer hover:bg-[#007cd3] transition-colors">
                                    <div class="flex items-center gap-1.5">
                                        <span>RT</span>
                                        <span class="text-sky-200 text-xs" :class="{ 'text-white font-extrabold': sortCol === 'rt_count' }">â†•</span>
                                    </div>
                                </th>
                                <th scope="col" class="py-3 px-4 sm:px-6 text-center">
                                    Detail
                                </th>
                            </tr>
                        </thead>

                        {{-- Body Rows --}}
                        <tbody class="divide-y divide-slate-200 bg-white">
                            <template x-for="(item, idx) in paginatedData" :key="item.id">
                                <tr class="hover:bg-sky-50/40 transition-colors text-slate-700">
                                    <td class="py-3.5 px-4 sm:px-6 font-medium text-slate-900">
                                        <span x-text="item.nama"></span>
                                    </td>
                                    <td class="py-3.5 px-4 sm:px-6 text-slate-600" x-text="item.desa_count"></td>
                                    <td class="py-3.5 px-4 sm:px-6 text-slate-600" x-text="item.rw_count"></td>
                                    <td class="py-3.5 px-4 sm:px-6 text-slate-600" x-text="item.rt_count"></td>
                                    <td class="py-3.5 px-4 sm:px-6 text-center">
                                        <button type="button"
                                                @click="openDetail(item)"
                                                class="inline-block bg-[#102a43] hover:bg-[#0a2558] text-white text-xs font-semibold px-4 py-1.5 rounded shadow-2xs transition-all active:scale-95 focus:outline-none focus:ring-2 focus:ring-blue-600/30">
                                            Detail
                                        </button>
                                    </td>
                                </tr>
                            </template>

                            {{-- Empty State --}}
                            <tr x-show="filteredData.length === 0">
                                <td colspan="5" class="py-10 text-center text-slate-400">
                                    <p class="font-medium text-sm">Tidak ada data kecamatan yang sesuai dengan filter pencarian.</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Pagination & Summary Footer --}}
                <div class="mt-5 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs sm:text-sm text-slate-600">
                    <div>
                        Menampilkan
                        <span class="font-bold text-slate-900" x-text="filteredData.length === 0 ? 0 : ((currentPage - 1) * perPage + 1)"></span>
                        sampai
                        <span class="font-bold text-slate-900" x-text="Math.min(currentPage * perPage, filteredData.length)"></span>
                        dari
                        <span class="font-bold text-slate-900" x-text="filteredData.length"></span>
                        data kecamatan
                    </div>

                    <div class="flex items-center gap-1" x-show="totalPages > 1">
                        <button type="button"
                                @click="currentPage = Math.max(1, currentPage - 1)"
                                :disabled="currentPage === 1"
                                class="px-3 py-1.5 rounded border border-slate-200 text-slate-600 hover:bg-slate-100 disabled:opacity-40 disabled:cursor-not-allowed font-medium transition-colors">
                            Sebelumnya
                        </button>

                        <template x-for="p in totalPages" :key="p">
                            <button type="button"
                                    @click="currentPage = p"
                                    x-text="p"
                                    class="px-3 py-1.5 rounded border font-medium transition-colors"
                                    :class="currentPage === p ? 'bg-[#0088e8] border-[#0088e8] text-white font-bold' : 'border-slate-200 text-slate-700 hover:bg-slate-100'">
                            </button>
                        </template>

                        <button type="button"
                                @click="currentPage = Math.min(totalPages, currentPage + 1)"
                                :disabled="currentPage === totalPages"
                                class="px-3 py-1.5 rounded border border-slate-200 text-slate-600 hover:bg-slate-100 disabled:opacity-40 disabled:cursor-not-allowed font-medium transition-colors">
                            Selanjutnya
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
                           class="px-5 py-2 text-xs font-bold text-white bg-[#0a2558] hover:bg-[#0d3070] rounded-xl shadow-md transition-all">
                            Masuk & Ajukan Layanan
                        </a>
                    @endauth
                </div>

            </div>
        </div>
    </section>
