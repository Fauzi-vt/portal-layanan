            {{-- ── SERVICE BADGE ── --}}
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 bg-white rounded-xl border border-slate-200 shadow-sm p-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-700 border border-blue-100 flex items-center justify-center flex-shrink-0">
                        @if ($service->kode_layanan === 'KIA') <i data-lucide="contact" class="w-5 h-5"></i>
                        @elseif ($service->kode_layanan === 'EKTP') <i data-lucide="camera" class="w-5 h-5"></i>
                        @elseif ($service->kode_layanan === 'KK_BARU') <i data-lucide="users" class="w-5 h-5"></i>
                        @elseif ($service->kode_layanan === 'KK_ADD') <i data-lucide="user-plus" class="w-5 h-5"></i>
                        @elseif ($service->kode_layanan === 'KK_DEL') <i data-lucide="user-minus" class="w-5 h-5"></i>
                        @elseif (str_starts_with($service->kode_layanan, 'PINDAH') || $service->kode_layanan === 'DATANG') <i data-lucide="truck" class="w-5 h-5"></i>
                        @elseif ($service->kode_layanan === 'NIKAH') <i data-lucide="heart" class="w-5 h-5"></i>
                        @else <i data-lucide="file-text" class="w-5 h-5"></i>
                        @endif
                    </div>
                    <div>
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-blue-100 text-blue-800">{{ $service->kode_layanan }}</span>
                            <span class="px-2 py-0.5 rounded text-[10px] font-semibold {{ $service->jenis_proses->badgeColor() }}">
                                {{ $service->jenis_proses === \App\Enums\ServiceProcessType::FullDigital ? 'Digital Penuh' : 'Hybrid' }}
                            </span>
                        </div>
                        <h2 class="text-sm font-bold text-slate-900 mt-0.5">{{ $service->nama_layanan }}</h2>
                    </div>
                </div>
                <a href="{{ route('warga.submissions.create') }}"
                   class="text-xs text-blue-600 hover:text-blue-800 font-semibold underline whitespace-nowrap flex items-center gap-1">
                    <i data-lucide="arrow-left" class="w-3 h-3"></i>
                    Ganti Layanan
                </a>
            </div>

            {{-- ── PROGRESS STEPPER ── --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm px-4 sm:px-6 py-4">
                <div class="flex items-center gap-0">
                    @php
                        if ($isKkBaru) {
                            $stepLabels = ['Data Pemohon', 'Kepala Keluarga', 'Anggota Keluarga', 'Dokumen', 'Review'];
                        } elseif ($hasFormSection) {
                            $stepLabels = ['Wilayah & Pemohon', 'Formulir Digital', 'Berkas Dokumen', 'Tinjau & Ajukan'];
                        } else {
                            $stepLabels = ['Wilayah & Pemohon', 'Berkas Dokumen', 'Tinjau & Ajukan'];
                        }
                    @endphp
                    @foreach ($stepLabels as $i => $label)
                        @php $stepNum = $i + 1; @endphp
                        <div class="flex flex-col items-center {{ $stepNum < count($stepLabels) ? 'flex-1' : '' }}">
                            {{-- Pill + label --}}
                            <div class="flex items-center {{ $stepNum < count($stepLabels) ? 'w-full' : '' }}">
                                <div class="flex flex-col items-center">
                                    <button type="button"
                                            @click="if (activeStep > {{ $stepNum }}) goToStep({{ $stepNum }})"
                                            class="step-pill"
                                            :class="{
                                                'active': activeStep === {{ $stepNum }},
                                                'done': activeStep > {{ $stepNum }},
                                                'inactive': activeStep < {{ $stepNum }},
                                                'cursor-pointer': activeStep > {{ $stepNum }}
                                            }">
                                        <template x-if="activeStep > {{ $stepNum }}">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                        </template>
                                        <template x-if="activeStep <= {{ $stepNum }}">
                                            <span>{{ $stepNum }}</span>
                                        </template>
                                    </button>
                                </div>
                                @if ($stepNum < count($stepLabels))
                                    <div class="step-connector flex-1 mx-1" :class="{'done': activeStep > {{ $stepNum }}}"></div>
                                @endif
                            </div>
                            {{-- Step label (hidden on mobile for space) --}}
                            <span class="text-[10px] font-semibold mt-1.5 hidden sm:block text-center leading-tight"
                                  :class="{
                                    'text-blue-600': activeStep === {{ $stepNum }},
                                    'text-green-600': activeStep > {{ $stepNum }},
                                    'text-slate-400': activeStep < {{ $stepNum }}
                                  }">
                                {{ $label }}
                            </span>
                        </div>
                    @endforeach
                </div>
                {{-- Mobile: current step label --}}
                <p class="text-xs font-bold text-blue-700 mt-3 sm:hidden text-center"
                   x-text="'Langkah ' + activeStep + ' dari ' + totalSteps + ': ' + stepLabel(activeStep)"></p>
            </div>

            {{-- ── VALIDATION ERRORS ── --}}
            @if ($errors->any())
                <div class="bg-rose-50 border border-rose-200 rounded-xl p-4 flex gap-3">
                    <div class="flex-shrink-0 w-5 h-5 rounded-full bg-rose-500 text-white flex items-center justify-center text-xs font-black">!</div>
                    <div>
                        <p class="text-xs font-bold text-rose-800 mb-1">Terdapat kesalahan pada pengisian formulir:</p>
                        <ul class="text-xs text-rose-700 space-y-0.5 list-disc list-inside">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
