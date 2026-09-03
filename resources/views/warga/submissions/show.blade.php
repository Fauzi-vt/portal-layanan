@extends('layouts.warga')

@section('title', 'Detail Permohonan #' . $submission->nomor_tiket . ' — Portal Layanan Publik KOMDIGI')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

    {{-- Breadcrumb & Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="space-y-1">
            <div class="flex items-center gap-2 text-xs text-slate-500 font-medium">
                <a href="{{ route('warga.dashboard') }}" class="hover:text-teal-700">Dashboard</a>
                <span>/</span>
                <a href="{{ route('warga.submissions.index') }}" class="hover:text-teal-700">Riwayat</a>
                <span>/</span>
                <span class="font-mono text-slate-800 font-semibold">{{ $submission->nomor_tiket }}</span>
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight flex items-center gap-3">
                <span>Tracking Status Permohonan</span>
            </h1>
        </div>

        <div>
            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-extrabold border shadow-sm {{ $submission->status->badgeColor() }}">
                {{ $submission->status->label() }}
            </span>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         1. VISUAL 7-STAGE PROGRESS STEPPER
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 portal-shadow">
        <h2 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-6">Tahapan Proses Layanan</h2>

        @php
            $statusVal = $submission->status->value;
            $steps = [
                ['id' => 'draft',             'label' => 'Draft',             'desc' => 'Disimpan pemohon'],
                ['id' => 'submitted',         'label' => 'Diajukan',          'desc' => 'Mengantre verifikasi'],
                ['id' => 'in_review',         'label' => 'Verifikasi Berkas', 'desc' => 'Ditinjau petugas'],
                ['id' => 'processed',         'label' => 'Diproses',          'desc' => 'Penerbitan dokumen'],
                ['id' => 'completed',         'label' => 'Selesai',           'desc' => 'Dokumen siap'],
            ];

            // Hitung active index
            $currentIndex = 1;
            if ($statusVal === 'draft') $currentIndex = 0;
            elseif ($statusVal === 'submitted') $currentIndex = 1;
            elseif ($statusVal === 'in_review') $currentIndex = 2;
            elseif ($statusVal === 'revision_required') $currentIndex = 2; // stage verifikasi dengan warning
            elseif ($statusVal === 'processed') $currentIndex = 3;
            elseif ($statusVal === 'completed') $currentIndex = 4;
            elseif ($statusVal === 'rejected') $currentIndex = 2;
        @endphp

        <div class="grid grid-cols-2 sm:grid-cols-5 gap-4 relative">
            @foreach ($steps as $idx => $st)
                @php
                    $isPassed = $idx <= $currentIndex && $statusVal !== 'rejected';
                    $isCurrent = $idx === $currentIndex;
                    $isRevision = $isCurrent && $statusVal === 'revision_required';
                    $isRejected = $statusVal === 'rejected' && $idx === $currentIndex;
                @endphp

                <div class="flex flex-col items-center text-center space-y-2 relative">
                    <div class="w-10 h-10 rounded-2xl flex items-center justify-center font-bold text-sm transition-all duration-300
                        {{ $isRevision ? 'bg-amber-500 text-white ring-4 ring-amber-100 shadow-md' : '' }}
                        {{ $isRejected ? 'bg-rose-500 text-white ring-4 ring-rose-100 shadow-md' : '' }}
                        {{ !$isRevision && !$isRejected && $isPassed ? 'bg-teal-600 text-white shadow-md' : '' }}
                        {{ !$isPassed ? 'bg-slate-100 text-slate-400 border border-slate-200' : '' }}
                    ">
                        @if ($isRevision) ⚠️
                        @elseif ($isRejected) ❌
                        @elseif ($idx < $currentIndex) ✓
                        @else {{ $idx + 1 }}
                        @endif
                    </div>
                    <div>
                        <p class="text-xs font-bold {{ $isCurrent ? ($isRevision ? 'text-amber-700' : 'text-teal-800 font-extrabold') : ($isPassed ? 'text-slate-800' : 'text-slate-400') }}">
                            {{ $st['label'] }}
                        </p>
                        <p class="text-[10px] text-slate-400">{{ $st['desc'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         2. ALERT KHUSUS: STATUS PERLU PERBAIKAN / REVISI DOKUMEN
    ═══════════════════════════════════════════════════════════════════════════ --}}
    @if ($submission->isRevisionRequired())
        <div class="bg-amber-50 border-2 border-amber-400 rounded-3xl p-6 sm:p-8 space-y-6 portal-shadow">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-500 text-white flex items-center justify-center text-2xl font-bold flex-shrink-0 shadow-md">
                    📝
                </div>
                <div class="space-y-1 flex-1">
                    <h3 class="text-base font-extrabold text-amber-950">Petugas Kecamatan Meminta Perbaikan Berkas!</h3>
                    <p class="text-xs text-amber-800 leading-relaxed">
                        Mohon baca catatan petugas di bawah ini, lalu unggah berkas pengganti yang sudah diperbaiki melalui form berikut.
                    </p>
                </div>
            </div>

            {{-- Catatan Petugas --}}
            <div class="bg-white/80 border border-amber-200 rounded-2xl p-4 text-xs space-y-1">
                <p class="font-bold text-amber-900 uppercase tracking-wider text-[11px]">💬 Instruksi / Catatan Petugas Verifikator:</p>
                <p class="text-slate-800 font-medium whitespace-pre-line">{{ $submission->catatan_petugas ?? 'Mohon perbaiki berkas yang tidak sesuai.' }}</p>
            </div>

            {{-- Form Upload Ulang Revisi --}}
            <form action="{{ route('warga.submissions.update-revision', $submission) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl p-6 border border-amber-200 space-y-4">
                @csrf
                <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Unggah Berkas Revisi Baru:</h4>

                <div class="space-y-4">
                    @foreach ($submission->service->requirements as $req)
                        @php
                            $doc = $submission->documents->firstWhere('service_requirement_id', $req->id);
                        @endphp
                        <div class="p-4 rounded-xl border {{ $doc && $doc->isInvalid() ? 'border-rose-300 bg-rose-50/40' : 'border-slate-200 bg-slate-50/50' }}">
                            <div class="flex items-center justify-between mb-2">
                                <div>
                                    <span class="text-xs font-bold text-slate-800">{{ $req->nama_persyaratan }}</span>
                                    @if ($doc && $doc->isInvalid())
                                        <span class="ml-2 px-2 py-0.5 rounded text-[10px] font-bold bg-rose-100 text-rose-700">Perlu Diperbaiki</span>
                                        @if ($doc->catatan_dokumen)
                                            <p class="text-[11px] text-rose-600 font-medium mt-0.5">Catatan: {{ $doc->catatan_dokumen }}</p>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <input type="file"
                                   name="documents[{{ $req->id }}]"
                                   accept=".pdf,.jpg,.jpeg,.png"
                                   class="block w-full text-xs text-slate-600 file:mr-4 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-amber-100 file:text-amber-800 hover:file:bg-amber-200 cursor-pointer">
                        </div>
                    @endforeach
                </div>

                <div class="pt-2 flex justify-end">
                    <button type="submit" class="px-6 py-3 rounded-xl font-bold text-xs text-white bg-amber-600 hover:bg-amber-700 shadow-md shadow-amber-600/20 transition-all">
                        🚀 Kirimkan Ulang Revisi Berkas &rarr;
                    </button>
                </div>
            </form>
        </div>
    @endif

    {{-- ═══════════════════════════════════════════════════════════════════════════
         3. INFO KHUSUS: JADWAL & NOMOR ANTREAN BIOMETRIK E-KTP
    ═══════════════════════════════════════════════════════════════════════════ --}}
    @if ($submission->jadwal_biometrik)
        <div class="bg-gradient-to-r from-sky-900 to-indigo-950 rounded-3xl p-6 sm:p-8 text-white portal-shadow relative overflow-hidden">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 relative z-10">
                <div class="space-y-2">
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-sky-400/20 text-sky-300 border border-sky-400/30">
                        📸 Jadwal Perekaman Biometrik e-KTP Ditetapkan
                    </span>
                    <h3 class="text-xl sm:text-2xl font-extrabold text-white">
                        {{ $submission->jadwal_biometrik->isoFormat('dddd, D MMMM Y — HH:mm') }} WIB
                    </h3>
                    <p class="text-xs text-sky-200">
                        Lokasi: Kantor Kecamatan {{ $submission->kecamatan->nama_kecamatan }} ({{ $submission->kecamatan->alamat_kantor ?? 'Tasikmalaya' }})
                    </p>
                </div>

                <div class="bg-white/10 border border-white/20 rounded-2xl p-4 text-center min-w-[140px] backdrop-blur-md">
                    <p class="text-[11px] text-sky-200 uppercase font-semibold">Nomor Antrean</p>
                    <p class="text-3xl font-mono font-extrabold text-white mt-0.5">{{ $submission->nomor_antrean ?? '-' }}</p>
                </div>
            </div>
        </div>
    @endif

    {{-- ═══════════════════════════════════════════════════════════════════════════
         4. INFO KHUSUS: UNDUH E-DOKUMEN HASIL SELESAI
    ═══════════════════════════════════════════════════════════════════════════ --}}
    @if ($submission->isCompleted())
        <div class="bg-emerald-50 border-2 border-emerald-300 rounded-3xl p-6 sm:p-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6 portal-shadow">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-600 text-white flex items-center justify-center text-2xl font-bold flex-shrink-0 shadow-md">
                    ✅
                </div>
                <div class="space-y-1">
                    <h3 class="text-lg font-extrabold text-emerald-950">Permohonan Selesai Diproses</h3>
                    <p class="text-xs text-emerald-800 leading-relaxed">
                        {{ $submission->catatan_petugas ?? 'Dokumen administrasi Anda telah diterbitkan secara resmi oleh pihak Kecamatan.' }}
                    </p>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('warga.submissions.download-output', $submission) }}" class="inline-flex items-center gap-2 px-6 py-3.5 rounded-xl font-bold text-xs sm:text-sm text-white bg-emerald-600 hover:bg-emerald-700 shadow-lg shadow-emerald-600/20 transition-all whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    <span>Unduh e-Dokumen Hasil</span>
                </a>

                @if ($submission->form_data && isset($submission->form_data['f101']))
                    <a href="{{ route('warga.submissions.print-f101', $submission) }}" target="_blank" class="inline-flex items-center gap-2 px-5 py-3.5 rounded-xl font-bold text-xs sm:text-sm text-emerald-950 bg-white hover:bg-emerald-100 border border-emerald-300 shadow-xs transition-all whitespace-nowrap">
                        <i data-lucide="printer" class="w-4 h-4 text-emerald-700"></i>
                        <span>Cetak Formulir F-1.01 Resmi</span>
                    </a>
                @endif
            </div>
        </div>
    @endif

    {{-- ═══════════════════════════════════════════════════════════════════════════
         4.5. FORMULIR BIODATA KELUARGA (F-1.01)
    ═══════════════════════════════════════════════════════════════════════════ --}}
    @if ($submission->form_data && isset($submission->form_data['f101']))
        <x-f101-detail :f101="$submission->form_data['f101']" :submission="$submission" />
    @endif

    {{-- ═══════════════════════════════════════════════════════════════════════════
         5. DETAIL INFORMASI PERMOHONAN & BERKAS
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Detail Tiket --}}
        <div class="bg-white rounded-3xl p-6 border border-slate-200 portal-shadow space-y-4">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Ringkasan Tiket</h3>

            <div class="space-y-3 text-xs">
                <div>
                    <span class="text-slate-400 block">Nomor Tiket:</span>
                    <span class="font-mono font-bold text-slate-900 text-sm">{{ $submission->nomor_tiket }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block">Jenis Layanan:</span>
                    <span class="font-bold text-slate-800">{{ $submission->service->nama_layanan }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block">Kecamatan Verifikator:</span>
                    <span class="font-bold text-slate-800">Kecamatan {{ $submission->kecamatan->nama_kecamatan }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block">Waktu Pengajuan:</span>
                    <span class="text-slate-700">{{ $submission->created_at->isoFormat('D MMMM Y, HH:mm') }} WIB</span>
                </div>
            </div>

            {{-- Action jika masih draft --}}
            @if ($submission->status === \App\Enums\SubmissionStatus::Draft)
                <div class="pt-4 border-t border-slate-100">
                    <form action="{{ route('warga.submissions.submit-draft', $submission) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full py-2.5 rounded-xl font-bold text-xs text-white bg-teal-600 hover:bg-teal-700 shadow-sm transition-colors">
                            🚀 Kirim Draft ke Verifikator &rarr;
                        </button>
                    </form>
                </div>
            @endif
        </div>

        {{-- Daftar Berkas yang Diunggah --}}
        <div class="md:col-span-2 bg-white rounded-3xl p-6 border border-slate-200 portal-shadow space-y-4">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Status Dokumen Persyaratan</h3>

            <div class="space-y-3">
                @foreach ($submission->service->requirements as $req)
                    @php
                        $doc = $submission->documents->firstWhere('service_requirement_id', $req->id);
                    @endphp
                    <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50/50 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs">
                        <div class="space-y-0.5">
                            <p class="font-bold text-slate-900">{{ $req->nama_persyaratan }}</p>
                            @if ($doc)
                                <p class="text-slate-500 text-[11px]">Nama file: {{ $doc->file_name ?? basename($doc->file_path) }}</p>
                                @if ($doc->catatan_dokumen)
                                    <p class="text-rose-600 text-[11px] font-medium">Catatan: {{ $doc->catatan_dokumen }}</p>
                                @endif
                            @else
                                <p class="text-slate-400 text-[11px]">Belum diunggah</p>
                            @endif
                        </div>

                        <div class="flex items-center gap-2">
                            @if ($doc)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $doc->status_validasi->badgeColor() }}">
                                    {{ $doc->status_validasi->label() }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-200 text-slate-600">
                                    Kosong
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</div>
@endsection
