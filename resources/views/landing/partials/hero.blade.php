    <section class="relative text-white pt-20 sm:pt-24 pb-32 sm:pb-36 px-4 sm:px-6 lg:px-8 overflow-hidden min-h-[580px] sm:min-h-[640px] flex items-center justify-center"
             @mouseenter="stopAutoPlay()"
             @mouseleave="startAutoPlay()">

        {{-- Background Slider Images with Gradient Overlays --}}
        <template x-for="(slide, index) in slides" :key="index">
            <div x-show="currentSlide === index"
                 x-transition:enter="transition ease-out duration-700"
                 x-transition:enter-start="opacity-0 scale-105"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-500"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="absolute inset-0 bg-cover bg-center transition-all"
                 :style="`background-image: linear-gradient(180deg, rgba(10, 37, 88, 0.88) 0%, rgba(15, 23, 42, 0.94) 100%), url('${slide.image}')`">
            </div>
        </template>

        {{-- Ambient Light Deco --}}
        <div class="absolute top-1/4 left-1/2 -translate-x-1/2 w-96 h-96 bg-blue-500/15 rounded-full blur-3xl pointer-events-none"></div>


        {{-- Slide Content --}}
        <div class="max-w-4xl mx-auto text-center space-y-5 relative z-10 py-6">
            <template x-for="(slide, index) in slides" :key="index">
                <div x-show="currentSlide === index"
                     x-transition:enter="transition ease-out duration-500 delay-100"
                     x-transition:enter-start="opacity-0 translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-4"
                     class="space-y-5">
                    
                    {{-- Badge --}}
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-500/20 text-blue-200 text-xs sm:text-sm font-semibold border border-blue-400/30 backdrop-blur-md">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span x-text="slide.badge"></span>
                    </div>

                    {{-- Title --}}
                    <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight leading-tight text-white drop-shadow-md max-w-3xl mx-auto"
                        x-text="slide.title">
                    </h1>
                    
                    {{-- Description --}}
                    <p class="text-sm sm:text-lg text-blue-100 font-normal tracking-wide max-w-2xl mx-auto leading-relaxed pt-1"
                       x-text="slide.desc">
                    </p>

                    {{-- CTA Buttons --}}
                    <div class="pt-6 flex flex-wrap justify-center gap-4">
                        <a :href="slide.ctaLink"
                           class="px-7 py-3.5 rounded-full text-xs sm:text-sm font-bold bg-amber-400 hover:bg-amber-300 text-slate-950 transition-all shadow-xl hover:shadow-2xl hover:-translate-y-0.5 flex items-center gap-2 cursor-pointer">
                            <span x-text="slide.ctaText"></span>
                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </a>
                        <a :href="slide.btnSecLink"
                           class="px-7 py-3.5 rounded-full text-xs sm:text-sm font-semibold bg-white/10 hover:bg-white/20 text-white border border-white/20 backdrop-blur-md transition-all flex items-center gap-2 cursor-pointer">
                            <span x-text="slide.btnSec"></span>
                        </a>
                    </div>

                </div>
            </template>
        </div>

        {{-- â”€â”€ SLIDER NAVIGATION CONTROLS â”€â”€ --}}
        {{-- Prev Button --}}
        <button type="button"
                @click="prevSlide()"
                class="absolute left-3 sm:left-6 top-1/2 -translate-y-1/2 z-20 w-11 h-11 sm:w-12 sm:h-12 rounded-full bg-white/10 hover:bg-white/25 text-white border border-white/20 backdrop-blur-md flex items-center justify-center transition-all hover:scale-110 shadow-lg"
                title="Slide Sebelumnya"
                aria-label="Slide Sebelumnya">
            <i data-lucide="chevron-left" class="w-6 h-6"></i>
        </button>

        {{-- Next Button --}}
        <button type="button"
                @click="nextSlide()"
                class="absolute right-3 sm:right-6 top-1/2 -translate-y-1/2 z-20 w-11 h-11 sm:w-12 sm:h-12 rounded-full bg-white/10 hover:bg-white/25 text-white border border-white/20 backdrop-blur-md flex items-center justify-center transition-all hover:scale-110 shadow-lg"
                title="Slide Selanjutnya"
                aria-label="Slide Selanjutnya">
            <i data-lucide="chevron-right" class="w-6 h-6"></i>
        </button>

        {{-- Dot Indicators --}}
        <div class="absolute bottom-24 inset-x-0 z-20 flex items-center justify-center gap-2.5">
            <template x-for="(slide, index) in slides" :key="index">
                <button type="button"
                        @click="goToSlide(index)"
                        class="h-2.5 rounded-full transition-all duration-300 cursor-pointer"
                        :class="currentSlide === index ? 'w-8 bg-amber-400 shadow-md' : 'w-2.5 bg-white/40 hover:bg-white/70'"
                        :title="`Buka Slide ${index + 1}`"
                        :aria-label="`Slide ${index + 1}`">
                </button>
            </template>
        </div>

    </section>
