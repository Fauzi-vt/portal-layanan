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
        currentDisplayPage: 1,
        thumbLeft: 0,
        thumbWidth: 25,
        services: {{ json_encode($publicServicesData) }},
        get filteredServices() {
            if (this.activeCategory === 'all') return this.services;
            return this.services.filter(s => s.category_id === this.activeCategory);
        },
        init() {
            this.$nextTick(() => {
                this.updateScroll();
            });
        },
        setActiveCategory(cat) {
            this.activeCategory = cat;
            this.$nextTick(() => {
                const el = this.$refs.cardTrack;
                if (el) {
                    el.scrollLeft = 0;
                    this.updateScroll();
                }
            });
        },
        slide(direction) {
            const el = this.$refs.cardTrack;
            if (!el) return;
            const card = el.querySelector('.aiclass-card');
            const gap = 20;
            const step = card ? (card.offsetWidth + gap) : 320;
            el.scrollBy({ left: direction * step, behavior: 'smooth' });

            let count = 0;
            const timer = setInterval(() => {
                this.updateScroll();
                count++;
                if (count > 14) clearInterval(timer);
            }, 40);
        },
        updateScroll() {
            const el = this.$refs.cardTrack;
            if (!el) return;
            const scrollLeft = el.scrollLeft;
            const maxScroll = el.scrollWidth - el.clientWidth;
            const total = this.filteredServices.length;

            const card = el.querySelector('.aiclass-card');
            const gap = 20;
            const step = card ? (card.offsetWidth + gap) : 320;

            if (total > 0 && step > 0) {
                const visibleCards = Math.max(1, Math.round(el.clientWidth / step));
                const idx = Math.min(Math.max(1, Math.round(scrollLeft / step) + 1), total);
                this.currentDisplayPage = idx;

                const ratioVisible = Math.min(1, Math.max(0.15, visibleCards / total));
                this.thumbWidth = Math.round(ratioVisible * 100);

                if (maxScroll > 0) {
                    const scrollRatio = Math.min(1, Math.max(0, scrollLeft / maxScroll));
                    const maxThumbLeft = 100 - this.thumbWidth;
                    this.thumbLeft = Math.round(scrollRatio * maxThumbLeft * 100) / 100;
                } else {
                    this.thumbLeft = 0;
                    this.thumbWidth = 100;
                }
            }
        },
        handleTrackClick(e) {
            const track = e.currentTarget;
            const rect = track.getBoundingClientRect();
            const clickX = e.clientX - rect.left;
            const ratio = Math.max(0, Math.min(1, clickX / rect.width));
            const el = this.$refs.cardTrack;
            if (el) {
                const maxScroll = el.scrollWidth - el.clientWidth;
                el.scrollTo({ left: ratio * maxScroll, behavior: 'smooth' });
                this.updateScroll();
            }
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
                            @click="setActiveCategory('all')"
                            :class="activeCategory === 'all' ? 'active' : ''"
                            class="aiclass-filter-btn">
                        Semua Layanan
                    </button>
                    <button type="button"
                            @click="setActiveCategory('identitas')"
                            :class="activeCategory === 'identitas' ? 'active' : ''"
                            class="aiclass-filter-btn">
                        Identitas Kependudukan
                    </button>
                    <button type="button"
                            @click="setActiveCategory('kk')"
                            :class="activeCategory === 'kk' ? 'active' : ''"
                            class="aiclass-filter-btn">
                        Kartu Keluarga
                    </button>
                    <button type="button"
                            @click="setActiveCategory('pindah')"
                            :class="activeCategory === 'pindah' ? 'active' : ''"
                            class="aiclass-filter-btn">
                        Perpindahan Domisili
                    </button>
                    <button type="button"
                            @click="setActiveCategory('surat')"
                            :class="activeCategory === 'surat' ? 'active' : ''"
                            class="aiclass-filter-btn">
                        Dispensasi & Keterangan
                    </button>
                </div>
            </div>

            {{-- Horizontal Cards Carousel (Tepat 4 Card di Desktop, Sudut Siku 90 Derajat) --}}
            <div class="relative overflow-hidden w-full">
                <div x-ref="cardTrack"
                     @scroll.passive="updateScroll()"
                     @resize.window.debounce.100ms="updateScroll()"
                     class="aiclass-track select-none">

                    
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
                                        <span style="display: inline-block; width: 5px; height: 5px; border-radius: 50%; background: #ffffff;"></span>
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

                                {{-- Action Button: Aligned Left with Rounded Top Corners Only, Touching Bottom --}}
                                <a :href="item.url" class="btn-detail">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            {{-- Slider Controls: Counter + Scrollbar Track Geser + Navigation Arrows (Persis AICLASSASEAN) --}}
            <div class="aiclass-controls">
                {{-- Counter: Menampilkan Halaman / Total Layanan --}}
                <span class="aiclass-counter" x-text="currentDisplayPage + '/' + filteredServices.length"></span>

                {{-- Horizontal Scrollbar Track & Red Sliding Thumb --}}
                <div class="aiclass-progress-track" @click="handleTrackClick($event)" title="Klik untuk menggeser slide">
                    <div class="aiclass-progress-thumb" :style="`left: ${thumbLeft}%; width: ${thumbWidth}%;`"></div>
                </div>

                {{-- Navigation Arrows (Tombol Lingkaran Geser) --}}
                <div class="aiclass-nav-buttons">
                    <button type="button" @click="slide(-1)" class="aiclass-nav-arrow" aria-label="Sebelumnya">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button type="button" @click="slide(1)" class="aiclass-nav-arrow" aria-label="Selanjutnya">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>



        </div>
    </section>
