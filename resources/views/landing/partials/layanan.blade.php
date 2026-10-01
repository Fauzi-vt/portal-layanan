    @php
        $publicServicesData = [
            [
                'kode' => 'EKTP',
                'category_id' => 'identitas',
                'category' => 'Identitas Kependudukan',
                'title' => 'Perekaman E-KTP Biometrik',
                'time' => '1 Hari Kerja',
                'modules' => '2 Dokumen Syarat',
                'learners' => '84.778 Pemohon',
                'image' => 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?auto=format&fit=crop&w=700&q=80',
                'url' => route('layanan.show', ['serviceCode' => 'EKTP']),
            ],
            [
                'kode' => 'KIA',
                'category_id' => 'identitas',
                'category' => 'Identitas Kependudukan',
                'title' => 'Pembuatan Kartu Identitas Anak (KIA)',
                'time' => '1 Hari Kerja',
                'modules' => '4 Dokumen Syarat',
                'learners' => '52.410 Pemohon',
                'image' => 'https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&w=700&q=80',
                'url' => route('layanan.show', ['serviceCode' => 'KIA']),
            ],
            [
                'kode' => 'KK_BARU',
                'category_id' => 'kk',
                'category' => 'Kartu Keluarga',
                'title' => 'Penerbitan Kartu Keluarga (KK) Baru',
                'time' => '2 Hari Kerja',
                'modules' => '4 Dokumen Syarat',
                'learners' => '71.372 Pemohon',
                'image' => 'https://images.unsplash.com/photo-1511895426328-dc8714191300?auto=format&fit=crop&w=700&q=80',
                'url' => route('layanan.show', ['serviceCode' => 'KK_BARU']),
            ],
            [
                'kode' => 'KK_ADD',
                'category_id' => 'kk',
                'category' => 'Kartu Keluarga',
                'title' => 'Penambahan Anggota Kartu Keluarga',
                'time' => '1 Hari Kerja',
                'modules' => '3 Dokumen Syarat',
                'learners' => '48.290 Pemohon',
                'image' => 'https://images.unsplash.com/photo-1609234656388-0ff363383899?auto=format&fit=crop&w=700&q=80',
                'url' => route('layanan.show', ['serviceCode' => 'KK_ADD']),
            ],
            [
                'kode' => 'PINDAH_SATU_DESA',
                'category_id' => 'pindah',
                'category' => 'Perpindahan Domisili',
                'title' => 'Pindah Datang WNI (Satu Desa / F.1-23)',
                'time' => '1 Hari Kerja',
                'modules' => '3 Dokumen Syarat',
                'learners' => '66.859 Pemohon',
                'image' => 'https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&w=700&q=80',
                'url' => route('layanan.show', ['serviceCode' => 'PINDAH_SATU_DESA']),
            ],
            [
                'kode' => 'PINDAH_ANTAR_KEC',
                'category_id' => 'pindah',
                'category' => 'Perpindahan Domisili',
                'title' => 'Pindah Antar Kecamatan (SKPWNI / F.1-29)',
                'time' => '2 Hari Kerja',
                'modules' => '3 Dokumen Syarat',
                'learners' => '39.120 Pemohon',
                'image' => 'https://images.unsplash.com/photo-1524661135-423995f22d0b?auto=format&fit=crop&w=700&q=80',
                'url' => route('layanan.show', ['serviceCode' => 'PINDAH_ANTAR_KEC']),
            ],
            [
                'kode' => 'NIKAH',
                'category_id' => 'surat',
                'category' => 'Dispensasi & Keterangan',
                'title' => 'Surat Rekomendasi / Dispensasi Nikah',
                'time' => '1 Hari Kerja',
                'modules' => '5 Dokumen Syarat',
                'learners' => '28.640 Pemohon',
                'image' => 'https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=700&q=80',
                'url' => route('layanan.show', ['serviceCode' => 'NIKAH']),
            ],
            [
                'kode' => 'LAINNYA',
                'category_id' => 'surat',
                'category' => 'Dispensasi & Keterangan',
                'title' => 'Surat Keterangan Camat Terpadu',
                'time' => '1 Hari Kerja',
                'modules' => '4 Dokumen Syarat',
                'learners' => '61.930 Pemohon',
                'image' => 'https://images.unsplash.com/photo-1450133064473-71024230f91b?auto=format&fit=crop&w=700&q=80',
                'url' => route('layanan.show', ['serviceCode' => 'LAINNYA']),
            ],
        ];
    @endphp

    <section id="layanan" class="aiclass-section bg-white" x-data="{
        activeCategory: 'all',
        services: {{ json_encode($publicServicesData) }},
        get filteredServices() {
            if (this.activeCategory === 'all') return this.services;
            return this.services.filter(s => s.category_id === this.activeCategory);
        },
        scrollTrack(offset) {
            this.$refs.cardTrack.scrollBy({ left: offset, behavior: 'smooth' });
        }
    }">
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6">
            
            {{-- Header (Meniru Persis Tata Letak & Tipografi Referensi) --}}
            <div class="text-center mb-4">
                <h3 style="color: #355bdc; font-weight: 800; font-size: 1rem; letter-spacing: 0.05em; text-transform: uppercase; margin-bottom: 6px;">
                    LAYANAN KAMI
                </h3>
                <h4 style="font-weight: 700; font-size: 2.5rem; letter-spacing: -0.02em; margin-bottom: 24px; line-height: 1.2;">
                    <span style="color: #e84435;">Layanan</span> <span style="color: #000000;">Terpopuler Kami</span>
                </h4>

                {{-- Filter Pills Bar (Meniru Persis Bentuk, Border, & Gradien Tombol Aktif) --}}
                <div class="aiclass-filter-bar">
                    <button type="button"
                            @click="activeCategory = 'all'; $refs.cardTrack.scrollLeft = 0"
                            :class="activeCategory === 'all' ? 'active' : ''"
                            class="aiclass-filter-btn">
                        Semua Layanan
                    </button>
                    <button type="button"
                            @click="activeCategory = 'identitas'; $refs.cardTrack.scrollLeft = 0"
                            :class="activeCategory === 'identitas' ? 'active' : ''"
                            class="aiclass-filter-btn">
                        Identitas Kependudukan
                    </button>
                    <button type="button"
                            @click="activeCategory = 'kk'; $refs.cardTrack.scrollLeft = 0"
                            :class="activeCategory === 'kk' ? 'active' : ''"
                            class="aiclass-filter-btn">
                        Kartu Keluarga
                    </button>
                    <button type="button"
                            @click="activeCategory = 'pindah'; $refs.cardTrack.scrollLeft = 0"
                            :class="activeCategory === 'pindah' ? 'active' : ''"
                            class="aiclass-filter-btn">
                        Perpindahan Domisili
                    </button>
                    <button type="button"
                            @click="activeCategory = 'surat'; $refs.cardTrack.scrollLeft = 0"
                            :class="activeCategory === 'surat' ? 'active' : ''"
                            class="aiclass-filter-btn">
                        Dispensasi & Keterangan
                    </button>
                </div>
            </div>

            {{-- Horizontal Cards Carousel (Meniru Bentuk Kartu & 3.5 Kartu Horizontal Berjajar) --}}
            <div class="relative overflow-hidden w-full">
                <div x-ref="cardTrack"
                     class="flex gap-6 overflow-x-auto scroll-smooth pb-4 px-2 select-none"
                     style="scrollbar-width: none; -ms-overflow-style: none;">
                    
                    <template x-for="(item, index) in filteredServices" :key="item.kode">
                        <div class="aiclass-card">
                            <div>
                                {{-- Card Image --}}
                                <div class="card-img-wrap">
                                    <img :src="item.image" :alt="item.title" loading="lazy">
                                </div>

                                {{-- Tags Row: Blue Category Badge + Red Time Badge --}}
                                <div class="tags">
                                    <span class="competency" x-text="item.category"></span>
                                    <span class="time">
                                        <span style="display: inline-block; width: 6px; height: 6px; border-radius: 50%; background: #ffffff;"></span>
                                        <span x-text="item.time"></span>
                                    </span>
                                </div>

                                {{-- Service Title --}}
                                <h5 x-text="item.title"></h5>
                            </div>

                            <div>
                                {{-- Metadata Row with Black Borders --}}
                                <div class="meta-row">
                                    <span style="display: flex; align-items: center; gap: 6px;">
                                        <svg class="w-3.5 h-3.5 inline-block text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                        <span x-text="item.modules"></span>
                                    </span>
                                    <span style="display: flex; align-items: center; gap: 6px;">
                                        <svg class="w-3.5 h-3.5 inline-block text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        <span x-text="item.learners"></span>
                                    </span>
                                </div>

                                {{-- Action Button: Aligned Left with Rounded Top Corners Only --}}
                                <a :href="item.url" class="btn-detail">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            {{-- Slider Controls (Arrow Buttons & Progress Line) --}}
            <div class="aiclass-controls">
                <button type="button" @click="scrollTrack(-344)" class="aiclass-nav-arrow" aria-label="Sebelumnya">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <div class="w-32 h-1 bg-slate-200 rounded-full overflow-hidden">
                    <div class="h-full bg-[#ff9d00] rounded-full w-1/3 transition-all duration-300"></div>
                </div>
                <button type="button" @click="scrollTrack(344)" class="aiclass-nav-arrow" aria-label="Selanjutnya">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>

        </div>
    </section>
