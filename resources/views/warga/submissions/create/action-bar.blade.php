            {{-- ════════════════════════════════════════════════
                 STICKY BOTTOM ACTION BAR (Step 1–(N-1))
            ════════════════════════════════════════════════ --}}
            <div class="action-bar rounded-b-xl" x-show="activeStep < totalSteps">
                <div class="flex items-center justify-between gap-3 max-w-3xl mx-auto">
                    {{-- Save as draft (always available except step 1) --}}
                    <div>
                        <button type="button"
                                x-show="activeStep > 1"
                                :disabled="submitting"
                                @click="$refs.submitNowInput.value = '0'; $refs.mainForm.submit(); submitting = true"
                                class="text-xs font-semibold text-slate-500 hover:text-slate-700 flex items-center gap-1.5 transition-colors cursor-pointer disabled:opacity-50">
                            <i data-lucide="bookmark" class="w-3.5 h-3.5"></i>
                            Simpan Draft
                        </button>
                        <div x-show="activeStep === 1" class="text-xs text-slate-400">
                            <span>Langkah </span><span x-text="activeStep"></span><span> dari </span><span x-text="totalSteps"></span>
                        </div>
                    </div>

                    <div class="flex items-center gap-2.5">
                        {{-- Back button --}}
                        <button type="button"
                                x-show="activeStep > 1"
                                @click="goPrev()"
                                class="px-4 py-2.5 rounded-xl font-semibold text-xs text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 transition-colors flex items-center gap-1.5 cursor-pointer shadow-sm">
                            <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                            Kembali
                        </button>

                        {{-- Next button --}}
                        <button type="button"
                                @click="goNext()"
                                class="px-5 py-2.5 rounded-xl font-bold text-xs text-white bg-blue-600 hover:bg-blue-700 transition-colors flex items-center gap-1.5 shadow-sm cursor-pointer">
                            <span x-text="activeStep === (totalSteps - 1) ? 'Ke Tahap Review' : 'Lanjutkan'"></span>
                            <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                        </button>
                    </div>
                </div>
            </div>
