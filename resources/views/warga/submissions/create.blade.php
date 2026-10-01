@extends('layouts.warga')

@section('title', $service ? 'Pengajuan ' . $service->nama_layanan . ' — Portal Layanan Publik' : 'Tambah Permohonan — Portal Layanan Publik')

@section('content')
<style>
    /* Stepper */
    .step-connector { flex: 1; height: 2px; background: #e2e8f0; transition: background 0.4s ease; }
    .step-connector.done { background: #3b82f6; }

    /* Step pill */
    .step-pill {
        display: flex; align-items: center; justify-content: center;
        width: 2rem; height: 2rem; border-radius: 50%;
        font-size: 0.7rem; font-weight: 800;
        transition: all 0.3s ease;
        flex-shrink: 0;
    }
    .step-pill.inactive { background: #f1f5f9; color: #94a3b8; border: 2px solid #e2e8f0; }
    .step-pill.active   { background: #2563eb; color: #fff; border: 2px solid #2563eb; box-shadow: 0 0 0 4px #dbeafe; }
    .step-pill.done     { background: #22c55e; color: #fff; border: 2px solid #22c55e; }

    /* File upload card */
    .doc-upload-card { transition: all 0.2s ease; }
    .doc-upload-card:hover { border-color: #93c5fd; box-shadow: 0 2px 10px rgba(59,130,246,.12); }
    .doc-upload-card.has-file { border-color: #86efac; background: #f0fdf4; }

    /* Review card */
    .review-section { border-left: 3px solid #2563eb; }

    /* Smooth step transitions */
    [x-cloak] { display: none !important; }
    .step-panel { animation: stepIn 0.25s ease forwards; }
    @keyframes stepIn { from { opacity:0; transform: translateY(8px); } to { opacity:1; transform: translateY(0); } }

    /* Sticky bottom action bar */
    .action-bar {
        position: sticky; bottom: 0; z-index: 30;
        background: rgba(255,255,255,0.95);
        backdrop-filter: blur(12px);
        border-top: 1px solid #e2e8f0;
        padding: 0.875rem 1.25rem;
    }
</style>
<div x-data="{ searchQuery: '', selectedServiceId: '{{ $service?->id ?? '' }}' }">

    {{-- ═══════════════════════════════════════════════════════
         HEADER + BREADCRUMB
    ═══════════════════════════════════════════════════════ --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-200 pb-4 mb-6">
        <h1 class="text-xl font-bold text-slate-900 tracking-tight">
            {{ $service ? $service->nama_layanan : 'Tambah Permohonan' }}
        </h1>
        <div class="flex items-center gap-1.5 text-xs text-slate-500 font-medium">
            <a href="{{ route('warga.dashboard') }}" class="text-blue-600 hover:underline">Dashboard</a>
            <span>/</span>
            <a href="{{ route('warga.submissions.index') }}" class="text-blue-600 hover:underline">Permohonan</a>
            <span>/</span>
            <span class="text-slate-800 font-semibold">Tambah Permohonan</span>
        </div>
    </div>

    @if (! $service)

        {{-- ═══════════════════════════════════════════════════════
             HALAMAN PILIH LAYANAN
        ═══════════════════════════════════════════════════════ --}}
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

    @else

        {{-- ═══════════════════════════════════════════════════════
             MULTI-STEP WIZARD FORM
        ═══════════════════════════════════════════════════════ --}}
        @php
            $isKkBaru = ($service->kode_layanan === 'KK_BARU');
            $hasFormSection = in_array($service->kode_layanan, [
                'KK_BARU','KK_ADD','KK_DEL',
                'PINDAH_SATU_DESA','PINDAH_ANTAR_DESA','PINDAH_ANTAR_KEC','PINDAH','DATANG'
            ]) || $service->requirements->contains(fn($r) =>
                str_contains($r->nama_persyaratan, 'F-1.01') || str_contains($r->nama_persyaratan, 'F-1.15')
            );
            $totalSteps = $isKkBaru ? 5 : ($hasFormSection ? 4 : 3);
        @endphp

        <div x-data="{
            activeStep: 1,
            totalSteps: {{ $totalSteps }},
            isKkBaru: {{ $isKkBaru ? 'true' : 'false' }},
            hasFormSection: {{ $hasFormSection ? 'true' : 'false' }},
            submitting: false,
            filePreviews: {},

            goNext() {
                if (this.activeStep < this.totalSteps) {
                    this.activeStep++;
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            },
            goPrev() {
                if (this.activeStep > 1) {
                    this.activeStep--;
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            },
            goToStep(step) {
                if (step >= 1 && step <= this.totalSteps) {
                    this.activeStep = step;
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            },
            submitForm(draftVal) {
                if (this.submitting) return;
                this.submitting = true;
                this.$refs.submitNowInput.value = draftVal;
                this.$refs.mainForm.submit();
            },
            handleFileChange(reqId, event) {
                const file = event.target.files[0];
                if (file) {
                    this.filePreviews[reqId] = {
                        name: file.name,
                        size: (file.size / 1024 / 1024).toFixed(2) + ' MB'
                    };
                } else {
                    delete this.filePreviews[reqId];
                }
            },
            stepLabel(step) {
                if (this.isKkBaru) {
                    const labels = { 1: 'Data Pemohon', 2: 'Kepala Keluarga', 3: 'Anggota Keluarga', 4: 'Dokumen', 5: 'Review' };
                    return labels[step] || '';
                }
                if (!this.hasFormSection) {
                    const labels = { 1: 'Wilayah & Pemohon', 2: 'Berkas Dokumen', 3: 'Tinjau & Ajukan' };
                    return labels[step] || '';
                }
                const labels = { 1: 'Wilayah & Pemohon', 2: 'Formulir Digital', 3: 'Berkas Dokumen', 4: 'Tinjau & Ajukan' };
                return labels[step] || '';
            },
            get lastStep() { return this.totalSteps; }
        }" class="space-y-5">

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

            {{-- ════════════════════════════════════════════════════
                 MAIN FORM
            ════════════════════════════════════════════════════ --}}
            <form x-ref="mainForm"
                  action="{{ route('warga.submissions.store') }}"
                  method="POST"
                  enctype="multipart/form-data"
                  @submit.prevent>
                @csrf
                <input type="hidden" name="service_id" value="{{ $service->id }}">
                <input type="hidden" name="submit_now" value="1" x-ref="submitNowInput">

                {{-- ════════════════════════════════════════════════
                     STEP 1 — WILAYAH & PEMOHON
                ════════════════════════════════════════════════ --}}
                <div x-show="activeStep === 1" x-cloak class="step-panel space-y-4">

                    @if ($isKkBaru)
                        {{-- ── KK_BARU: STEP 1 DATA PEMOHON ── --}}
                        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 sm:p-6 space-y-4">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-100">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-700 border border-blue-100 flex items-center justify-center flex-shrink-0">
                                        <i data-lucide="user-check" class="w-5 h-5"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-base font-bold text-slate-900">Data Pemohon</h3>
                                        <p class="text-xs text-slate-500 mt-0.5">
                                            Data diri Anda sebagai pemohon layanan.
                                        </p>
                                    </div>
                                </div>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 self-start sm:self-auto">
                                    <i data-lucide="lock" class="w-3.5 h-3.5"></i>
                                    <span>Data ini diambil dari profil akun Anda.</span>
                                </span>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-1">
                                <div>
                                    <label class="block text-xs font-bold text-slate-800 mb-1.5">
                                        Nama Lengkap
                                    </label>
                                    <input type="text"
                                           value="{{ $user->name }}"
                                           readonly
                                           class="w-full text-xs font-bold uppercase rounded-xl border border-slate-200 py-2.5 px-3.5 bg-slate-50 text-slate-800 cursor-not-allowed select-none shadow-2xs">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-800 mb-1.5">
                                        NIK
                                    </label>
                                    <input type="text"
                                           value="{{ $user->nik ?? '' }}"
                                           readonly
                                           class="w-full font-mono text-xs font-bold rounded-xl border border-slate-200 py-2.5 px-3.5 bg-slate-50 text-slate-800 cursor-not-allowed select-none shadow-2xs">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-800 mb-1.5">
                                        Nomor HP
                                    </label>
                                    <input type="text"
                                           value="{{ $user->phone ?? '' }}"
                                           readonly
                                           class="w-full text-xs font-semibold rounded-xl border border-slate-200 py-2.5 px-3.5 bg-slate-50 text-slate-800 cursor-not-allowed select-none shadow-2xs">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-800 mb-1.5">
                                        Email
                                    </label>
                                    <input type="email"
                                           value="{{ $user->email ?? '' }}"
                                           readonly
                                           class="w-full text-xs font-semibold rounded-xl border border-slate-200 py-2.5 px-3.5 bg-slate-50 text-slate-800 cursor-not-allowed select-none shadow-2xs">
                                </div>
                            </div>

                            <p class="text-[11px] text-slate-500 pt-1">
                                Data ini diambil dari profil akun Anda. Apabila terdapat perubahan data, silakan perbarui pada pengaturan profil akun warga.
                            </p>
                        </div>

                        {{-- Wilayah Verifikasi Card --}}
                        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 sm:p-6 space-y-4">
                            <div class="flex items-center gap-3 pb-3 border-b border-slate-100">
                                <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center flex-shrink-0">
                                    <i data-lucide="map-pin" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-slate-900">Kecamatan Tujuan Verifikasi</h3>
                                    <p class="text-[11px] text-slate-500">Pilih kantor kecamatan domisili tempat permohonan Kartu Keluarga baru ini diproses.</p>
                                </div>
                            </div>

                            <div>
                                <label for="kecamatan_id" class="block text-xs font-bold text-slate-800 mb-1.5">
                                    Kecamatan Verifikasi <span class="text-rose-600">*</span>
                                </label>
                                <select name="kecamatan_id" id="kecamatan_id" required
                                        class="w-full text-xs font-bold rounded-xl border border-slate-300 bg-white text-slate-900 focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 focus:outline-none py-2.5 px-3.5 shadow-2xs">
                                    @foreach ($kecamatans as $kec)
                                        <option value="{{ $kec->id }}" {{ old('kecamatan_id', $user->kecamatan_id) == $kec->id ? 'selected' : '' }}>
                                            Kecamatan {{ $kec->nama_kecamatan }} ({{ $kec->kode_kecamatan }})
                                        </option>
                                    @endforeach
                                </select>
                                <p class="text-[11px] text-slate-500 mt-1.5">
                                    Pilih kecamatan tempat permohonan ini akan diproses. Biasanya sesuai dengan kecamatan domisili Anda.
                                </p>
                            </div>
                        </div>
                    @else
                        {{-- Info banner (Non-KK_BARU) --}}
                        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 flex gap-3 items-start">
                            <i data-lucide="info" class="w-4 h-4 text-blue-600 flex-shrink-0 mt-0.5"></i>
                            <div class="text-xs text-blue-800 leading-relaxed">
                                <strong>Identitas Pemohon.</strong> Data Pemohon terisi otomatis dari profil akun Anda. Pilih kecamatan tujuan verifikasi, lalu lanjutkan ke langkah berikutnya.
                            </div>
                        </div>

                        {{-- Kecamatan selector --}}
                        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 sm:p-6 space-y-5">
                            <div class="flex items-center gap-2 pb-3 border-b border-slate-100">
                                <div class="w-7 h-7 rounded-lg bg-blue-600 text-white flex items-center justify-center flex-shrink-0">
                                    <i data-lucide="map-pin" class="w-3.5 h-3.5"></i>
                                </div>
                                <h3 class="text-sm font-bold text-slate-900">Wilayah Verifikasi</h3>
                            </div>

                            <div>
                                <label for="kecamatan_id" class="block text-xs font-semibold text-slate-700 mb-1.5">
                                    Kecamatan Tujuan Verifikasi <span class="text-rose-500">*</span>
                                    <span class="ml-1 text-slate-400 font-normal">(39 Kecamatan Kabupaten Tasikmalaya)</span>
                                </label>
                                <select name="kecamatan_id" id="kecamatan_id" required
                                        class="w-full text-xs font-semibold rounded-xl border border-slate-300 bg-white text-slate-900 focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 focus:outline-none py-2.5 px-3 shadow-sm">
                                    @foreach ($kecamatans as $kec)
                                        <option value="{{ $kec->id }}" {{ old('kecamatan_id', $user->kecamatan_id) == $kec->id ? 'selected' : '' }}>
                                            Kecamatan {{ $kec->nama_kecamatan }} ({{ $kec->kode_kecamatan }})
                                        </option>
                                    @endforeach
                                </select>
                                <p class="text-[11px] text-slate-500 mt-1.5">
                                    Pilih kecamatan tempat permohonan ini akan diproses. Biasanya sesuai dengan kecamatan domisili Anda.
                                </p>
                            </div>
                        </div>

                        {{-- Pemohon card --}}
                        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 sm:p-6 space-y-4">
                            <div class="flex items-center gap-2 pb-3 border-b border-slate-100">
                                <div class="w-7 h-7 rounded-lg bg-emerald-600 text-white flex items-center justify-center flex-shrink-0">
                                    <i data-lucide="user-circle" class="w-3.5 h-3.5"></i>
                                </div>
                                <h3 class="text-sm font-bold text-slate-900">Identitas Pemohon</h3>
                                <span class="ml-auto inline-flex items-center gap-1 text-[10px] font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded-full">
                                    <i data-lucide="lock" class="w-3 h-3"></i>
                                    Terisi dari profil akun
                                </span>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="bg-slate-50 rounded-xl p-4 border border-slate-100 space-y-2">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-lg bg-blue-600 text-white flex items-center justify-center font-black text-sm flex-shrink-0">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="text-xs font-black text-slate-900">{{ $user->name }}</p>
                                            <p class="text-[11px] text-slate-500 font-mono">NIK: {{ $user->nik ?? '—' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-slate-50 rounded-xl p-4 border border-slate-100 space-y-1.5">
                                    <div class="flex items-center gap-2 text-xs text-slate-600">
                                        <i data-lucide="mail" class="w-3.5 h-3.5 text-slate-400 flex-shrink-0"></i>
                                        <span class="truncate">{{ $user->email }}</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-xs text-slate-600">
                                        <i data-lucide="phone" class="w-3.5 h-3.5 text-slate-400 flex-shrink-0"></i>
                                        <span>{{ $user->phone ?? '—' }}</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-xs text-slate-600">
                                        <i data-lucide="home" class="w-3.5 h-3.5 text-slate-400 flex-shrink-0"></i>
                                        <span class="truncate">{{ $user->desa?->nama_desa ?? '—' }}, {{ $user->kecamatan?->nama_kecamatan ?? '—' }}</span>
                                    </div>
                                </div>
                            </div>

                            <p class="text-[11px] text-slate-500">
                                Data di atas diambil dari profil akun Anda secara otomatis dan tidak dapat diubah di sini.
                                Jika ada yang tidak sesuai, silakan perbarui melalui halaman <a href="#" class="text-blue-600 underline font-semibold">Profil Akun</a>.
                            </p>
                        </div>
                    @endif

                    {{-- Formulir fisik notice --}}
                    @if ($service->isHybrid() && $service->template_formulir_path)
                        <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                            <div class="flex items-start gap-3">
                                <span class="text-xl mt-0.5">📄</span>
                                <div>
                                    <p class="text-xs font-bold text-amber-900">Layanan Membutuhkan Formulir Fisik</p>
                                    <p class="text-[11px] text-amber-800 mt-0.5">Unduh template, minta tanda tangan & stempel desa, lalu unggah hasil scan di langkah Berkas Dokumen.</p>
                                </div>
                            </div>
                            <a href="#" onclick="alert('Template formulir siap diunduh.');" class="px-3.5 py-2 rounded-lg font-bold text-white text-xs bg-amber-600 hover:bg-amber-700 whitespace-nowrap shadow-sm">
                                Unduh Template PDF
                            </a>
                        </div>
                    @endif

                </div>

                {{-- ════════════════════════════════════════════════
                     FORMULIR DIGITAL (KK_BARU 5-step ATAU Service-specific form)
                ════════════════════════════════════════════════ --}}
                @if ($isKkBaru)
                    @include('warga.submissions.partials.form-f101')
                @elseif ($hasFormSection)
                <div x-show="activeStep === 2" x-cloak class="step-panel space-y-4">

                    <div class="bg-indigo-50 border border-indigo-200 rounded-xl p-4 flex gap-3 items-start">
                        <i data-lucide="clipboard-list" class="w-4 h-4 text-indigo-600 flex-shrink-0 mt-0.5"></i>
                        <div class="text-xs text-indigo-800 leading-relaxed">
                            <strong>Formulir Digital.</strong> Isi data dengan lengkap dan benar. Data yang diisi di sini setara dengan formulir resmi Dukcapil.
                        </div>
                    </div>

                    {{-- Service-specific form includes --}}
                    @if ($service->kode_layanan === 'KK_ADD')
                        @include('warga.submissions.partials.form-kk-add')
                    @elseif ($service->kode_layanan === 'KK_DEL')
                        @include('warga.submissions.partials.form-kk-del')
                    @elseif ($service->kode_layanan === 'PINDAH_SATU_DESA')
                        @include('warga.submissions.partials.form-pindah-satu-desa')
                    @elseif ($service->kode_layanan === 'PINDAH_ANTAR_DESA')
                        @include('warga.submissions.partials.form-pindah-antar-desa')
                    @elseif ($service->kode_layanan === 'PINDAH_ANTAR_KEC' || $service->kode_layanan === 'PINDAH' || $service->kode_layanan === 'DATANG')
                        @include('warga.submissions.partials.form-pindah-antar-kecamatan')
                    @elseif ($service->requirements->contains(fn($r) => str_contains($r->nama_persyaratan, 'F-1.01') || str_contains($r->nama_persyaratan, 'F-1.15')))
                        @include('warga.submissions.partials.form-f101')
                    @endif

                </div>
                @endif

                {{-- ════════════════════════════════════════════════
                     BERKAS DOKUMEN (Step 4 jika KK_BARU, 3 jika form lain, 2 jika tanpa form)
                ════════════════════════════════════════════════ --}}
                @php $docStep = $isKkBaru ? 4 : ($hasFormSection ? 3 : 2); @endphp
                <div x-show="activeStep === {{ $docStep }}" x-cloak class="step-panel space-y-4">

                    @if ($isKkBaru)
                        {{-- KK_BARU Header Card --}}
                        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 sm:p-6 space-y-4">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-100">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-violet-50 text-violet-700 border border-violet-100 flex items-center justify-center flex-shrink-0">
                                        <i data-lucide="paperclip" class="w-5 h-5"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-base font-bold text-slate-900">Dokumen Pendukung</h3>
                                        <p class="text-xs text-slate-500 mt-0.5">
                                            Lengkapi dokumen berikut untuk melanjutkan permohonan.
                                        </p>
                                    </div>
                                </div>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold bg-violet-50 text-violet-700 border border-violet-200 self-start sm:self-auto">
                                    <i data-lucide="file-text" class="w-3.5 h-3.5"></i>
                                    <span>{{ $service->requirements->count() }} Persyaratan Dokumen</span>
                                </span>
                            </div>

                            <p class="text-xs text-slate-600 leading-relaxed">
                                Dokumen dengan tanda <strong class="text-rose-600">Dokumen wajib</strong> wajib dilampirkan sebelum mengirimkan permohonan. Format berkas yang didukung: PDF, JPG, PNG (maksimal 5 MB per berkas).
                            </p>
                        </div>
                    @else
                        <div class="bg-violet-50 border border-violet-200 rounded-xl p-4 flex gap-3 items-start">
                            <i data-lucide="paperclip" class="w-4 h-4 text-violet-600 flex-shrink-0 mt-0.5"></i>
                            <div class="text-xs text-violet-800 leading-relaxed">
                                <strong>Unggah Berkas Persyaratan.</strong> Dokumen yang ditandai <span class="font-bold text-rose-600">Wajib</span> harus diunggah sebelum mengajukan permohonan. Ukuran file maks 5 MB (PDF, JPG, PNG).
                            </div>
                        </div>
                    @endif

                    <div class="space-y-3">
                        @foreach ($service->requirements as $req)
                            @php
                                $isF1Doc = str_contains($req->nama_persyaratan, 'F-1.01')
                                    || str_contains($req->nama_persyaratan, 'F-1.15')
                                    || str_contains($req->nama_persyaratan, 'Formulir');
                            @endphp

                            <div class="doc-upload-card bg-white rounded-2xl border border-slate-200 shadow-sm p-4 sm:p-5 space-y-3 transition-all"
                                 :class="{ 'has-file border-emerald-300 bg-emerald-50/20': filePreviews[{{ $req->id }}] }">
                                <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-3">
                                    <div class="flex items-start gap-3 flex-1">
                                        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5"
                                             :class="filePreviews[{{ $req->id }}] ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' : '{{ $isF1Doc ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : ($req->is_required ? 'bg-rose-50 text-rose-700 border border-rose-200' : 'bg-slate-50 text-slate-500 border border-slate-200') }}'">
                                            <template x-if="filePreviews[{{ $req->id }}]">
                                                <i data-lucide="check" class="w-5 h-5"></i>
                                            </template>
                                            <template x-if="!filePreviews[{{ $req->id }}]">
                                                <i data-lucide="{{ $isF1Doc ? 'file-check' : 'file-up' }}" class="w-5 h-5"></i>
                                            </template>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 flex-wrap">
                                                <h4 class="text-xs sm:text-sm font-bold text-slate-900">{{ $req->nama_persyaratan }}</h4>
                                                @if ($isF1Doc)
                                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700 border border-emerald-200">✓ Diisi Online — Opsional</span>
                                                @elseif ($req->is_required)
                                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-700 border border-rose-200">Dokumen wajib</span>
                                                @else
                                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-slate-100 text-slate-600 border border-slate-200">Dokumen opsional</span>
                                                @endif
                                            </div>
                                            @if ($req->deskripsi)
                                                <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">{{ $req->deskripsi }}</p>
                                            @endif
                                            @if ($isF1Doc && $hasFormSection)
                                                <p class="text-[11px] text-emerald-700 mt-1 font-medium">
                                                    Karena Anda telah mengisi formulir digital, unggah scan fisik bersifat opsional. Anda tetap dapat melampirkannya jika tersedia.
                                                </p>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Status Badge --}}
                                    <div class="flex-shrink-0 self-start sm:self-center">
                                        <template x-if="filePreviews[{{ $req->id }}]">
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-700 border border-emerald-200">
                                                <i data-lucide="check-circle" class="w-3.5 h-3.5"></i>
                                                <span>Sudah diunggah</span>
                                            </span>
                                        </template>
                                        <template x-if="!filePreviews[{{ $req->id }}]">
                                            @if ($isF1Doc && $hasFormSection)
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                    <i data-lucide="check" class="w-3.5 h-3.5"></i>
                                                    <span>Sudah diisi online</span>
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold {{ $req->is_required ? 'bg-rose-50 text-rose-700 border border-rose-200' : 'bg-slate-100 text-slate-600 border border-slate-200' }}">
                                                    <i data-lucide="circle" class="w-3.5 h-3.5"></i>
                                                    <span>Belum diunggah</span>
                                                </span>
                                            @endif
                                        </template>
                                    </div>
                                </div>

                                {{-- File preview info --}}
                                <div x-show="filePreviews[{{ $req->id }}]" x-cloak
                                     class="flex items-center gap-2 bg-emerald-50 border border-emerald-200 rounded-xl px-3.5 py-2">
                                    <i data-lucide="file-check-2" class="w-4 h-4 text-emerald-600 flex-shrink-0"></i>
                                    <span class="text-xs text-emerald-800 font-semibold truncate" x-text="filePreviews[{{ $req->id }}]?.name"></span>
                                    <span class="text-[11px] text-emerald-600 ml-auto flex-shrink-0 font-mono" x-text="filePreviews[{{ $req->id }}]?.size"></span>
                                </div>

                                <label class="flex items-center gap-3 cursor-pointer group pt-1">
                                    <div class="flex-1">
                                        <input type="file"
                                               id="doc_{{ $req->id }}"
                                               name="documents[{{ $req->id }}]"
                                               accept=".pdf,.jpg,.jpeg,.png"
                                               {{ ($req->is_required && !$isF1Doc) ? 'required' : '' }}
                                               @change="handleFileChange({{ $req->id }}, $event)"
                                               class="block w-full text-xs text-slate-700
                                                      file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0
                                                      file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700
                                                      hover:file:bg-blue-100 file:cursor-pointer
                                                      border border-dashed border-slate-300 rounded-xl bg-slate-50/50
                                                      focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-400
                                                      transition-all p-2 group-hover:border-blue-400">
                                    </div>
                                </label>
                            </div>
                        @endforeach
                    </div>

                </div>

                {{-- ════════════════════════════════════════════════
                     STEP 4 (or 3 if no form) — TINJAU & AJUKAN
                {{-- ════════════════════════════════════════════════
                     REVIEW & AJUKAN (Step 5 jika KK_BARU, 4 jika form lain, 3 jika tanpa form)
                ════════════════════════════════════════════════ --}}
                @php $reviewStep = $isKkBaru ? 5 : ($hasFormSection ? 4 : 3); @endphp
                <div x-show="activeStep === {{ $reviewStep }}" x-cloak class="step-panel space-y-4">

                    <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 flex gap-3 items-start">
                        <i data-lucide="eye" class="w-4 h-4 text-amber-600 flex-shrink-0 mt-0.5"></i>
                        <div class="text-xs text-amber-800 leading-relaxed">
                            <strong>{{ $isKkBaru ? 'Review Permohonan.' : 'Tinjau sebelum mengajukan.' }}</strong> Pastikan semua informasi sudah benar sebelum mengirimkan permohonan. Anda dapat mengklik tombol <strong>Ubah</strong> pada masing-masing bagian jika ada data yang perlu diperbaiki.
                        </div>
                    </div>

                    @if ($isKkBaru)
                        {{-- Review KK_BARU: 1. Data Pemohon --}}
                        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                            <div class="bg-gradient-to-r from-blue-700 to-blue-600 px-5 py-3 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <i data-lucide="user" class="w-4 h-4 text-blue-200"></i>
                                    <h3 class="text-xs font-bold text-white uppercase tracking-wider">1. Data Pemohon</h3>
                                </div>
                                <button type="button" @click="goToStep(1)" class="text-xs font-bold text-blue-100 hover:text-white underline cursor-pointer flex items-center gap-1">
                                    <i data-lucide="edit-3" class="w-3 h-3"></i>
                                    Ubah
                                </button>
                            </div>
                            <div class="p-5 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 text-xs">
                                <div class="space-y-0.5">
                                    <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider">Nama Pemohon</p>
                                    <p class="font-bold text-slate-900">{{ $user->name }}</p>
                                </div>
                                <div class="space-y-0.5">
                                    <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider">NIK Pemohon</p>
                                    <p class="font-bold text-slate-900 font-mono">{{ $user->nik ?? '—' }}</p>
                                </div>
                                <div class="space-y-0.5">
                                    <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider">Kontak</p>
                                    <p class="font-bold text-slate-900">{{ $user->email }} / {{ $user->phone ?? '—' }}</p>
                                </div>
                                <div class="space-y-0.5">
                                    <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider">Kecamatan Verifikasi</p>
                                    <p class="font-bold text-slate-900" id="review-kecamatan-display">
                                        @php
                                            $defaultKec = $kecamatans->firstWhere('id', old('kecamatan_id', $user->kecamatan_id));
                                        @endphp
                                        {{ $defaultKec ? 'Kec. ' . $defaultKec->nama_kecamatan : '—' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Review KK_BARU: 2. Data Kepala Keluarga & Alamat --}}
                        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                            <div class="bg-gradient-to-r from-indigo-700 to-indigo-600 px-5 py-3 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <i data-lucide="home" class="w-4 h-4 text-indigo-200"></i>
                                    <h3 class="text-xs font-bold text-white uppercase tracking-wider">2. Kepala Keluarga & Alamat</h3>
                                </div>
                                <button type="button" @click="goToStep(2)" class="text-xs font-bold text-indigo-100 hover:text-white underline cursor-pointer flex items-center gap-1">
                                    <i data-lucide="edit-3" class="w-3 h-3"></i>
                                    Ubah
                                </button>
                            </div>
                            <div class="p-5 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 text-xs">
                                <div class="space-y-0.5">
                                    <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider">Nama Kepala Keluarga</p>
                                    <p class="font-bold text-slate-900 text-sm uppercase" x-text="$store.kkBaru?.meta?.nama_kepala_keluarga || '—'"></p>
                                </div>
                                <div class="space-y-0.5 sm:col-span-2">
                                    <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider">Alamat Tempat Tinggal</p>
                                    <p class="font-semibold text-slate-800" x-text="($store.kkBaru?.meta?.alamat || '—') + ' (RT ' + ($store.kkBaru?.meta?.rt || '001') + ' / RW ' + ($store.kkBaru?.meta?.rw || '001') + ')'"></p>
                                </div>
                                <div class="space-y-0.5">
                                    <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider">Desa / Kelurahan</p>
                                    <p class="font-bold text-slate-900 uppercase" x-text="$store.kkBaru?.meta?.desa || '—'"></p>
                                </div>
                                <div class="space-y-0.5">
                                    <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider">Kecamatan</p>
                                    <p class="font-bold text-slate-900 uppercase" x-text="$store.kkBaru?.meta?.kecamatan || '—'"></p>
                                </div>
                                <div class="space-y-0.5">
                                    <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider">Kode Pos & Wilayah</p>
                                    <p class="font-bold text-slate-900 font-mono" x-text="($store.kkBaru?.meta?.kode_pos || '—') + ', ' + ($store.kkBaru?.meta?.kabupaten || 'KAB. TASIKMALAYA')"></p>
                                </div>
                            </div>
                        </div>

                        {{-- Review KK_BARU: 3. Anggota Keluarga --}}
                        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                            <div class="bg-gradient-to-r from-teal-700 to-teal-600 px-5 py-3 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <i data-lucide="users" class="w-4 h-4 text-teal-200"></i>
                                    <h3 class="text-xs font-bold text-white uppercase tracking-wider">
                                        3. Anggota Keluarga (<span x-text="$store.kkBaru?.anggota?.length || 0"></span> Orang)
                                    </h3>
                                </div>
                                <button type="button" @click="goToStep(3)" class="text-xs font-bold text-teal-100 hover:text-white underline cursor-pointer flex items-center gap-1">
                                    <i data-lucide="edit-3" class="w-3 h-3"></i>
                                    Ubah
                                </button>
                            </div>
                            <div class="p-5 divide-y divide-slate-100 space-y-2.5">
                                <template x-for="(m, idx) in ($store.kkBaru?.anggota || [])" :key="'rev-mem-' + idx">
                                    <div class="pt-2.5 first:pt-0 flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-xs">
                                        <div class="flex items-center gap-3">
                                            <span class="w-6 h-6 rounded-full bg-slate-100 text-slate-700 font-bold text-[10px] flex items-center justify-center" x-text="idx + 1"></span>
                                            <div>
                                                <span class="font-bold text-slate-900 uppercase" x-text="m.nama"></span>
                                                <span class="text-slate-400 font-mono text-[11px] ml-1.5" x-text="'(NIK: ' + ($store.kkBaru?.maskNik(m.nik) || m.nik) + ')'"></span>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2 pl-9 sm:pl-0">
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold"
                                                  :class="$store.kkBaru?.getShdkBadgeClass(m.shdk)"
                                                  x-text="m.shdk"></span>
                                            <span class="text-slate-500 text-[11px]" x-text="m.jenis_kelamin"></span>
                                            <template x-if="m.tanggal_lahir">
                                                <span class="text-slate-400 text-[11px]" x-text="'• ' + ($store.kkBaru?.calculateAge(m.tanggal_lahir) || '')"></span>
                                            </template>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    @else
                        {{-- Review: Layanan (Non-KK_BARU) --}}
                        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                            <div class="bg-gradient-to-r from-slate-800 to-slate-700 px-5 py-3 flex items-center gap-2">
                                <i data-lucide="briefcase" class="w-4 h-4 text-slate-300"></i>
                                <h3 class="text-xs font-bold text-white uppercase tracking-wider">Layanan yang Dipilih</h3>
                            </div>
                            <div class="p-5 flex items-center gap-3">
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
                                    <p class="text-sm font-black text-slate-900">{{ $service->nama_layanan }}</p>
                                    <p class="text-[11px] text-slate-500 mt-0.5">{{ $service->deskripsi }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- Review: Pemohon (Non-KK_BARU) --}}
                        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                            <div class="bg-gradient-to-r from-blue-700 to-blue-600 px-5 py-3 flex items-center gap-2">
                                <i data-lucide="user" class="w-4 h-4 text-blue-200"></i>
                                <h3 class="text-xs font-bold text-white uppercase tracking-wider">Data Pemohon & Wilayah</h3>
                            </div>
                            <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                                <div class="review-section pl-3 space-y-0.5">
                                    <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider">Nama Lengkap</p>
                                    <p class="font-bold text-slate-900">{{ $user->name }}</p>
                                </div>
                                <div class="review-section pl-3 space-y-0.5">
                                    <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider">NIK</p>
                                    <p class="font-bold text-slate-900 font-mono">{{ $user->nik ?? '—' }}</p>
                                </div>
                                <div class="review-section pl-3 space-y-0.5">
                                    <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider">Kecamatan Verifikasi</p>
                                    <p class="font-bold text-slate-900" id="review-kecamatan-display">
                                        @php
                                            $defaultKec = $kecamatans->firstWhere('id', old('kecamatan_id', $user->kecamatan_id));
                                        @endphp
                                        {{ $defaultKec ? 'Kec. ' . $defaultKec->nama_kecamatan : '—' }}
                                    </p>
                                </div>
                                <div class="review-section pl-3 space-y-0.5">
                                    <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider">Email / WhatsApp</p>
                                    <p class="font-bold text-slate-900">{{ $user->email }} / {{ $user->phone ?? '—' }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Review: Dokumen --}}
                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                        <div class="bg-gradient-to-r from-violet-700 to-violet-600 px-5 py-3 flex items-center justify-between gap-2">
                            <div class="flex items-center gap-2">
                                <i data-lucide="files" class="w-4 h-4 text-violet-200"></i>
                                <h3 class="text-xs font-bold text-white uppercase tracking-wider">
                                    {{ $isKkBaru ? '4. Dokumen Pendukung' : 'Berkas Persyaratan' }}
                                </h3>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="text-[10px] text-violet-200 font-semibold">
                                    {{ $service->requirements->count() }} Persyaratan
                                </span>
                                @if ($isKkBaru)
                                    <button type="button" @click="goToStep(4)" class="text-xs font-bold text-violet-100 hover:text-white underline cursor-pointer flex items-center gap-1">
                                        <i data-lucide="edit-3" class="w-3 h-3"></i>
                                        Ubah
                                    </button>
                                @endif
                            </div>
                        </div>
                        <div class="p-5 space-y-2.5">
                            @foreach ($service->requirements as $req)
                                @php
                                    $isF1DocRev = str_contains($req->nama_persyaratan, 'F-1.01')
                                        || str_contains($req->nama_persyaratan, 'F-1.15')
                                        || str_contains($req->nama_persyaratan, 'Formulir');
                                @endphp
                                <div class="flex items-center gap-3 text-xs py-2.5 border-b border-slate-50 last:border-0">
                                    <div x-show="!filePreviews[{{ $req->id }}] && !{{ $isF1DocRev && $hasFormSection ? 'true' : 'false' }}"
                                         class="w-5 h-5 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center flex-shrink-0">
                                        <i data-lucide="minus" class="w-3 h-3"></i>
                                    </div>
                                    <div x-show="filePreviews[{{ $req->id }}]"
                                         class="w-5 h-5 rounded-full bg-green-100 text-green-600 flex items-center justify-center flex-shrink-0">
                                        <i data-lucide="check" class="w-3 h-3"></i>
                                    </div>
                                    @if ($isF1DocRev && $hasFormSection)
                                    <div x-show="!filePreviews[{{ $req->id }}]"
                                         class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0">
                                        <i data-lucide="check-check" class="w-3 h-3"></i>
                                    </div>
                                    @endif
                                    <div class="flex-1 flex items-center justify-between gap-3">
                                        <span class="text-slate-700 font-semibold">{{ $req->nama_persyaratan }}</span>
                                        <span x-show="filePreviews[{{ $req->id }}]"
                                              class="text-green-700 font-bold text-[10px]"
                                              x-text="'✓ ' + (filePreviews[{{ $req->id }}]?.name || '')"></span>
                                        @if ($isF1DocRev && $hasFormSection)
                                            <span x-show="!filePreviews[{{ $req->id }}]"
                                                  class="text-emerald-700 font-bold text-[10px]">✓ Diisi online</span>
                                        @elseif (!$req->is_required)
                                            <span x-show="!filePreviews[{{ $req->id }}]"
                                                  class="text-slate-400 font-semibold text-[10px]">Opsional</span>
                                        @else
                                            <span x-show="!filePreviews[{{ $req->id }}]"
                                                  class="text-rose-600 font-bold text-[10px]">⚠ Belum diunggah</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Final call-to-action --}}
                    <div class="bg-gradient-to-br from-blue-900 to-indigo-900 rounded-2xl p-6 sm:p-8 text-center space-y-4">
                        <div class="w-14 h-14 rounded-2xl bg-white/10 text-white flex items-center justify-center mx-auto">
                            <i data-lucide="send" class="w-7 h-7"></i>
                        </div>
                        <div>
                            <h3 class="text-base font-black text-white">Siap Mengajukan?</h3>
                            <p class="text-xs text-blue-200 mt-1 max-w-md mx-auto">
                                Periksa kembali data di atas. Setelah diajukan, permohonan akan diproses oleh petugas kecamatan atau desa.
                            </p>
                        </div>
                        <div class="flex flex-col sm:flex-row items-center justify-center gap-3 pt-1">
                            <button type="button"
                                    :disabled="submitting"
                                    @click="submitForm('0')"
                                    class="w-full sm:w-auto px-6 py-3 rounded-xl font-bold text-sm text-white bg-white/10 border border-white/20 hover:bg-white/20 transition-all disabled:opacity-50 cursor-pointer flex items-center justify-center gap-2">
                                <i data-lucide="bookmark" class="w-4 h-4"></i>
                                Simpan sebagai Draft
                            </button>
                            <button type="button"
                                    :disabled="submitting"
                                    @click="submitForm('1')"
                                    class="w-full sm:w-auto px-8 py-3 rounded-xl font-black text-sm text-blue-900 bg-white hover:bg-blue-50 transition-all shadow-lg disabled:opacity-50 cursor-pointer flex items-center justify-center gap-2">
                                <span x-show="!submitting">Ajukan Permohonan</span>
                                <span x-show="submitting">Mengirim…</span>
                                <i data-lucide="send" class="w-4 h-4" x-show="!submitting"></i>
                                <svg x-show="submitting" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                </div>

            </form>

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

        </div>
    @endif

</div>

<script>
    // Update kecamatan display on review page when selector changes
    document.addEventListener('DOMContentLoaded', function() {
        const sel = document.getElementById('kecamatan_id');
        const display = document.getElementById('review-kecamatan-display');
        if (sel && display) {
            sel.addEventListener('change', function() {
                const opt = sel.options[sel.selectedIndex];
                if (display) display.textContent = opt ? opt.text : '—';
            });
        }
    });
</script>
@endsection
