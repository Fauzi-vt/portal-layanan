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
        @include('warga.submissions.create.service-selector')

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
            $docStep = $isKkBaru ? 4 : ($hasFormSection ? 3 : 2);
            $reviewStep = $isKkBaru ? 5 : ($hasFormSection ? 4 : 3);
        @endphp

        {{-- Inisialisasi Script & State Alpine Wizard --}}
        @include('warga.submissions.create.wizard-scripts')

        <div x-data="submissionWizardData()" class="space-y-5">

            {{-- 1. Stepper Header & Service Badge --}}
            @include('warga.submissions.create.stepper-header')

            {{-- 2. Main Form Wrapper --}}
            <form x-ref="mainForm"
                  action="{{ route('warga.submissions.store') }}"
                  method="POST"
                  enctype="multipart/form-data"
                  @submit.prevent>
                @csrf
                <input type="hidden" name="service_id" value="{{ $service->id }}">
                <input type="hidden" name="submit_now" value="1" x-ref="submitNowInput">

                {{-- Tahap Formulir: Wilayah, Pemohon & Formulir Digital --}}
                @include('warga.submissions.create.step-form')

                {{-- Tahap Berkas Dokumen Persyaratan --}}
                @include('warga.submissions.create.step-documents')

                {{-- Tahap Review & Tinjau Permohonan --}}
                @include('warga.submissions.create.step-review')

            </form>

            {{-- 3. Sticky Bottom Action Bar --}}
            @include('warga.submissions.create.action-bar')

        </div>

    @endif

</div>
@endsection
