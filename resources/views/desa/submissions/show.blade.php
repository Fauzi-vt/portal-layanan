@extends('layouts.app')

@section('title', 'Verifikasi Berkas #' . $submission->nomor_tiket . ' — Desa ' . ($submission->desa?->nama_desa ?? ''))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

    {{-- Header & Breadcrumb --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="space-y-1">
            <div class="flex items-center gap-2 text-xs text-slate-500 font-medium">
                <a href="{{ route('desa.dashboard') }}" class="hover:text-amber-700">Dashboard Desa</a>
                <span>/</span>
                <a href="{{ route('desa.submissions.index') }}" class="hover:text-amber-700">Verifikasi</a>
                <span>/</span>
                <span class="font-mono text-slate-800 font-semibold">{{ $submission->nomor_tiket }}</span>
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight flex items-center gap-3">
                <span>Verifikasi Tingkat Desa</span>
            </h1>
        </div>

        <div class="flex items-center gap-3">
            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-extrabold border shadow-sm {{ $submission->status->badgeColor() }}">
                {{ $submission->status->label() }}
            </span>
        </div>
    </div>

    {{-- Banner Status Verifikasi Desa jika sudah diproses --}}
    @if ($submission->verified_desa_at)
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 flex items-start gap-3">
            <span class="text-xl">✅</span>
            <div class="text-xs space-y-0.5">
                <p class="font-bold text-emerald-900">
                    Berkas telah diverifikasi oleh {{ $submission->verifiedByDesa?->name ?? 'Kasi Pelayanan Desa' }}
                </p>
                <p class="text-emerald-700">
                    Diverifikasi pada: {{ $submission->verified_desa_at->isoFormat('D MMMM Y, HH:mm') }} WIB.
                    @if ($submission->catatan_desa)
                        <span class="block mt-1 italic text-slate-600">"{{ $submission->catatan_desa }}"</span>
                    @endif
                </p>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- ═══════════════════════════════════════════════════════════════════════
             LEFT COLUMN (2 COLS): IDENTITAS PEMOHON & INSPEKSI DOKUMEN
        ═══════════════════════════════════════════════════════════════════════ --}}
        <div class="lg:col-span-2 space-y-8">

            {{-- 1. IDENTITAS WARGA & LAYANAN --}}
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 portal-shadow space-y-6">
                <h2 class="text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100 pb-3">
                    Profil Pemohon & Permohonan
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div class="p-3.5 bg-slate-50 rounded-2xl space-y-1">
                        <span class="text-slate-400 font-medium block text-[11px]">Nama Lengkap Pemohon:</span>
                        <p class="text-sm font-bold text-slate-900">{{ $submission->user->name }}</p>
                    </div>

                    <div class="p-3.5 bg-slate-50 rounded-2xl space-y-1">
                        <span class="text-slate-400 font-medium block text-[11px]">Nomor Induk Kependudukan (NIK):</span>
                        <p class="text-sm font-mono font-bold text-slate-900">{{ $submission->user->nik ?? 'Belum Diisi' }}</p>
                    </div>

                    <div class="p-3.5 bg-slate-50 rounded-2xl space-y-1">
                        <span class="text-slate-400 font-medium block text-[11px]">Nomor Kontak / WhatsApp:</span>
                        <p class="text-sm font-bold text-slate-900">{{ $submission->user->phone ?? '-' }}</p>
                    </div>

                    <div class="p-3.5 bg-slate-50 rounded-2xl space-y-1">
                        <span class="text-slate-400 font-medium block text-[11px]">Wilayah Domisili:</span>
                        <p class="text-sm font-bold text-slate-900">
                            Desa {{ $submission->user->desa?->nama_desa ?? '-' }}, Kec. {{ $submission->kecamatan->nama_kecamatan }}
                        </p>
                    </div>
                </div>

                {{-- Khusus Formulir Digital Kartu Keluarga & Lainnya --}}
                @if ($submission->form_data && isset($submission->form_data['f101']))
                    <div class="pt-2">
                        <x-f101-detail :f101="$submission->form_data['f101']" :submission="$submission" />
                    </div>
                @endif
                @if ($submission->form_data && isset($submission->form_data['kk_add']))
                    <div class="pt-2">
                        <x-kk-add-detail :kkAdd="$submission->form_data['kk_add']" :submission="$submission" />
                    </div>
                @endif
                @if ($submission->form_data && isset($submission->form_data['kk_del']))
                    <div class="pt-2">
                        <x-kk-del-detail :kkDel="$submission->form_data['kk_del']" :submission="$submission" />
                    </div>
                @endif
                @if ($submission->form_data && !isset($submission->form_data['f101']) && !isset($submission->form_data['kk_add']) && !isset($submission->form_data['kk_del']) && !isset($submission->form_data['pindah_satu_desa']) && !isset($submission->form_data['pindah_antar_desa']) && !isset($submission->form_data['pindah_antar_kecamatan']))
                    <div class="p-4 bg-amber-50/60 border border-amber-200 rounded-2xl text-xs space-y-1">
                        <span class="font-bold text-amber-900 block text-[11px]">Data Formulir Tambahan:</span>
                        <p class="text-amber-800">{{ json_encode($submission->form_data, JSON_UNESCAPED_UNICODE) }}</p>
                    </div>
                @endif
            </div>

            {{-- 2. DOKUMEN PERSYARATAN YANG DIUNGGAH --}}
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 portal-shadow space-y-6">
                <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                    <h2 class="text-xs font-bold text-slate-400 uppercase tracking-wider">
                        Inspeksi Dokumen Persyaratan
                    </h2>
                    <span class="text-xs text-slate-500 font-medium">{{ $submission->documents->count() }} Dokumen Diunggah</span>
                </div>

                <div class="space-y-4">
                    @forelse ($submission->documents as $doc)
                        <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50/50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div class="space-y-1">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm">📄</span>
                                    <span class="font-bold text-slate-900 text-sm">
                                        {{ $doc->requirement?->nama_persyaratan ?? 'Dokumen Pendukung' }}
                                    </span>
                                </div>
                                <p class="text-xs text-slate-500">
                                    Berkas: <span class="font-mono text-slate-700">{{ $doc->file_name ?? 'Berkas Terunggah' }}</span>
                                    • Ukuran: {{ number_format($doc->file_size / 1024, 1) }} KB
                                </p>
                            </div>

                            <div class="flex items-center gap-2">
                                <a href="{{ route('documents.show', $doc) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-bold text-slate-800 bg-white border border-slate-300 hover:bg-slate-100 shadow-sm transition-colors shrink-0">
                                    <span>Lihat Berkas</span>
                                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                </a>
                                <a href="{{ route('documents.download', $doc) }}" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold text-amber-800 bg-amber-50 hover:bg-amber-100 border border-amber-200 transition-colors shrink-0" title="Unduh Berkas">
                                    <svg class="w-3.5 h-3.5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-xs text-slate-400">
                            Tidak ada berkas yang dilampirkan dalam pengajuan ini.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

        {{-- ═══════════════════════════════════════════════════════════════════════
             RIGHT COLUMN (1 COL): PANEL AKSI VERIFIKASI DESA
        ═══════════════════════════════════════════════════════════════════════ --}}
        <div class="space-y-6">

            <div class="bg-white rounded-3xl p-6 border border-slate-200 portal-shadow space-y-6">
                <h3 class="font-bold text-slate-900 text-base flex items-center gap-2 border-b border-slate-100 pb-3">
                    <span>✍️</span>
                    <span>Aksi Verifikasi Kasi Pelayanan</span>
                </h3>

                <form action="{{ route('desa.submissions.verify', $submission) }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">
                            Keputusan Verifikasi Desa:
                        </label>
                        <select name="action" class="w-full px-3 py-2 text-xs sm:text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white font-medium">
                            <option value="approve">✓ Setujui & Teruskan ke Kecamatan</option>
                            <option value="revision">⚠️ Minta Perbaikan / Revisi ke Warga</option>
                            <option value="reject">✕ Tolak Permohonan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">
                            Catatan / Pengantar dari Desa:
                        </label>
                        <textarea name="catatan" rows="4" placeholder="Tuliskan catatan pengantar atau instruksi revisi jika ada..." class="w-full p-3 text-xs sm:text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-amber-500">{{ old('catatan', $submission->catatan_desa) }}</textarea>
                        <p class="text-[11px] text-slate-400 mt-1">
                            Catatan ini akan dapat dibaca oleh Admin Kecamatan dan Pemohon.
                        </p>
                    </div>

                    <button type="submit" class="w-full py-3 px-4 rounded-xl text-xs sm:text-sm font-bold text-slate-900 bg-amber-400 hover:bg-amber-300 shadow-md transition-all transform hover:-translate-y-0.5">
                        Simpan & Proses Keputusan
                    </button>
                </form>
            </div>

            {{-- Ringkasan Permohonan --}}
            <div class="bg-slate-50 rounded-3xl p-6 border border-slate-200 space-y-3 text-xs">
                <h4 class="font-bold text-slate-700 uppercase tracking-wider text-[11px]">Informasi Tiket</h4>
                <div class="divide-y divide-slate-200/60">
                    <div class="py-2 flex justify-between">
                        <span class="text-slate-500">Nomor Tiket:</span>
                        <span class="font-mono font-bold text-slate-800">{{ $submission->nomor_tiket }}</span>
                    </div>
                    <div class="py-2 flex justify-between">
                        <span class="text-slate-500">Layanan:</span>
                        <span class="font-semibold text-slate-800">{{ $submission->service->nama_layanan }}</span>
                    </div>
                    <div class="py-2 flex justify-between">
                        <span class="text-slate-500">Kecamatan Tujuan:</span>
                        <span class="font-semibold text-slate-800">{{ $submission->kecamatan->nama_kecamatan }}</span>
                    </div>
                    <div class="py-2 flex justify-between">
                        <span class="text-slate-500">Tanggal Pengajuan:</span>
                        <span class="text-slate-800">{{ $submission->created_at->isoFormat('D MMMM Y') }}</span>
                    </div>
                </div>
            </div>

        </div>

    </div>

    {{-- Riwayat & Audit Trail Permohonan --}}
    <div class="mt-8">
        <x-submission-timeline :histories="$submission->histories" />
    </div>

</div>
@endsection
