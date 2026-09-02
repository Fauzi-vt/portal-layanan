@extends('layouts.app')

@section('title', 'Verifikasi Berkas #' . $submission->nomor_tiket . ' — Kec. ' . ($submission->kecamatan->nama_kecamatan ?? ''))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

    {{-- Header & Breadcrumb --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="space-y-1">
            <div class="flex items-center gap-2 text-xs text-slate-500 font-medium">
                <a href="{{ route('kecamatan.dashboard') }}" class="hover:text-emerald-700">Dashboard</a>
                <span>/</span>
                <a href="{{ route('kecamatan.submissions.index') }}" class="hover:text-emerald-700">Meja Verifikasi</a>
                <span>/</span>
                <span class="font-mono text-slate-800 font-semibold">{{ $submission->nomor_tiket }}</span>
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight flex items-center gap-3">
                <span>Verifikasi Berkas Permohonan</span>
            </h1>
        </div>

        <div class="flex items-center gap-3">
            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-extrabold border shadow-sm {{ $submission->status->badgeColor() }}">
                {{ $submission->status->label() }}
            </span>
        </div>
    </div>

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

                {{-- Khusus Form Data Tambahan --}}
                @if ($submission->form_data)
                    <div class="p-4 bg-teal-50/60 border border-teal-200 rounded-2xl text-xs space-y-1">
                        <span class="font-bold text-teal-900 block text-[11px]">Data Formulir Tambahan:</span>
                        <p class="text-teal-800">{{ json_encode($submission->form_data, JSON_UNESCAPED_UNICODE) }}</p>
                    </div>
                @endif
            </div>

            {{-- 2. FORM PENINJAUAN & VALIDASI PER BUTIR DOKUMEN --}}
            <form action="{{ route('kecamatan.submissions.review', $submission) }}" method="POST" class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 portal-shadow space-y-6">
                @csrf
                <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                    <h2 class="text-xs font-bold text-slate-400 uppercase tracking-wider">
                        Inspeksi Dokumen Persyaratan
                    </h2>
                    <span class="text-xs text-slate-500 font-medium">{{ $submission->documents->count() }} Dokumen Diunggah</span>
                </div>

                <div class="space-y-6">
                    @foreach ($submission->service->requirements as $req)
                        @php
                            $doc = $submission->documents->firstWhere('service_requirement_id', $req->id);
                        @endphp
                        <div class="p-5 rounded-2xl border border-slate-200 bg-slate-50/50 space-y-4">
                            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-3">
                                <div class="space-y-1">
                                    <div class="flex items-center gap-2">
                                        <h4 class="text-xs font-bold text-slate-900">{{ $req->nama_persyaratan }}</h4>
                                        @if ($req->is_required)
                                            <span class="px-2 py-0.2 rounded text-[10px] font-bold bg-rose-100 text-rose-700">Wajib</span>
                                        @else
                                            <span class="px-2 py-0.2 rounded text-[10px] font-semibold bg-slate-200 text-slate-600">Opsional</span>
                                        @endif
                                    </div>
                                    <p class="text-[11px] text-slate-500">{{ $req->deskripsi }}</p>
                                </div>

                                {{-- File Viewer Link --}}
                                <div>
                                    @if ($doc && $doc->file_path)
                                        <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold text-teal-800 bg-teal-100 hover:bg-teal-200 transition-colors shadow-sm">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            <span>Lihat / Buka Berkas</span>
                                        </a>
                                    @else
                                        <span class="text-xs font-bold text-rose-500 bg-rose-50 px-2.5 py-1 rounded-lg border border-rose-200">
                                            Belum Diunggah
                                        </span>
                                    @endif
                                </div>
                            </div>

                            @if ($doc)
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2 border-t border-slate-200/60">
                                    {{-- Status Validasi Dokumen --}}
                                    <div>
                                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Status Validitas Berkas:</label>
                                        <select name="document_reviews[{{ $req->id }}][status]" class="w-full text-xs rounded-xl border-slate-200 bg-white py-1.5 focus:border-emerald-500 focus:ring-emerald-500">
                                            <option value="valid" {{ $doc->status_validasi->value === 'valid' ? 'selected' : '' }}>✅ Dokumen Sesuai (Valid)</option>
                                            <option value="invalid" {{ $doc->status_validasi->value === 'invalid' ? 'selected' : '' }}>❌ Tidak Sesuai (Perlu Revisi)</option>
                                            <option value="pending" {{ $doc->status_validasi->value === 'pending' ? 'selected' : '' }}>⏳ Menunggu Validasi</option>
                                        </select>
                                    </div>

                                    {{-- Catatan Spesifik per Dokumen --}}
                                    <div>
                                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Catatan Koreksi (Jika Buram/Salah):</label>
                                        <input type="text"
                                               name="document_reviews[{{ $req->id }}][note]"
                                               value="{{ $doc->catatan_dokumen }}"
                                               placeholder="Contoh: Foto terpotong, upload ulang scan asli"
                                               class="w-full text-xs rounded-xl border-slate-200 bg-white py-1.5 focus:border-emerald-500 focus:ring-emerald-500">
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                {{-- Update Status Permohonan Keseluruhan --}}
                <div class="pt-6 border-t border-slate-100 space-y-4">
                    <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Perbarui Status Keseluruhan Permohonan:</h3>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <label class="p-3.5 rounded-2xl border-2 border-slate-200 has-[:checked]:border-indigo-600 has-[:checked]:bg-indigo-50/50 cursor-pointer flex flex-col justify-between space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-indigo-900">Sedang Diverifikasi</span>
                                <input type="radio" name="status" value="in_review" {{ $submission->status->value === 'in_review' ? 'checked' : '' }} class="text-indigo-600 focus:ring-indigo-500">
                            </div>
                            <p class="text-[10px] text-slate-500">Berkas sedang dalam antrean pemeriksaan lanjutan.</p>
                        </label>

                        <label class="p-3.5 rounded-2xl border-2 border-slate-200 has-[:checked]:border-amber-500 has-[:checked]:bg-amber-50/50 cursor-pointer flex flex-col justify-between space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-amber-900">⚠️ Minta Revisi Berkas</span>
                                <input type="radio" name="status" value="revision_required" {{ $submission->status->value === 'revision_required' ? 'checked' : '' }} class="text-amber-600 focus:ring-amber-500">
                            </div>
                            <p class="text-[10px] text-slate-500">Kirim instruksi perbaikan ke portal warga pemohon.</p>
                        </label>

                        <label class="p-3.5 rounded-2xl border-2 border-slate-200 has-[:checked]:border-teal-600 has-[:checked]:bg-teal-50/50 cursor-pointer flex flex-col justify-between space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-teal-900">Berkas Lengkap / Diproses</span>
                                <input type="radio" name="status" value="processed" {{ $submission->status->value === 'processed' ? 'checked' : '' }} class="text-teal-600 focus:ring-teal-500">
                            </div>
                            <p class="text-[10px] text-slate-500">Semua berkas valid, lanjutkan ke tahap berikutnya.</p>
                        </label>
                    </div>

                    {{-- Pesan Catatan untuk Warga --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Catatan / Instruksi Petugas untuk Warga:</label>
                        <textarea name="catatan_petugas" rows="3" placeholder="Tuliskan catatan khusus atau instruksi perbaikan jika ada dokumen yang perlu diunggah ulang..." class="w-full text-xs rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-emerald-500 p-3">{{ $submission->catatan_petugas }}</textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="px-6 py-3 rounded-xl font-bold text-xs text-white bg-slate-900 hover:bg-black shadow-md transition-all">
                            💾 Simpan Hasil Verifikasi & Perbarui Status
                        </button>
                    </div>
                </div>
            </form>

        </div>

        {{-- ═══════════════════════════════════════════════════════════════════════
             RIGHT COLUMN (1 COL): ACTION PANELS (BIOMETRIK, SELESAI, TOLAK)
        ═══════════════════════════════════════════════════════════════════════ --}}
        <div class="space-y-6">

            {{-- 1. PANEL JADWAL BIOMETRIK E-KTP (KHUSUS LAYANAN EKTP) --}}
            @if ($submission->service->kode_layanan === 'EKTP')
                <div class="bg-gradient-to-br from-sky-900 to-indigo-950 rounded-3xl p-6 text-white portal-shadow space-y-4">
                    <div class="flex items-center gap-2">
                        <span class="text-xl">📸</span>
                        <h3 class="text-sm font-bold">Jadwal Biometrik e-KTP</h3>
                    </div>
                    <p class="text-xs text-sky-200">Tetapkan jadwal pemotretan, sidik jari, dan nomor antrean untuk warga di kantor kecamatan.</p>

                    <form action="{{ route('kecamatan.submissions.schedule-biometric', $submission) }}" method="POST" class="space-y-3 pt-2">
                        @csrf
                        <div>
                            <label class="block text-[11px] font-semibold text-sky-200 mb-1">Waktu Perekaman:</label>
                            <input type="datetime-local"
                                   name="jadwal_biometrik"
                                   required
                                   value="{{ $submission->jadwal_biometrik ? $submission->jadwal_biometrik->format('Y-m-d\TH:i') : '' }}"
                                   class="w-full text-xs text-slate-900 rounded-xl border-0 p-2.5 focus:ring-2 focus:ring-sky-400">
                        </div>

                        <div>
                            <label class="block text-[11px] font-semibold text-sky-200 mb-1">Nomor Antrean (Opsional):</label>
                            <input type="text"
                                   name="nomor_antrean"
                                   value="{{ $submission->nomor_antrean }}"
                                   placeholder="Otomatis: A-001, A-002, dst."
                                   class="w-full text-xs text-slate-900 rounded-xl border-0 p-2.5 focus:ring-2 focus:ring-sky-400 font-mono">
                        </div>

                        <button type="submit" class="w-full py-2.5 rounded-xl font-bold text-xs text-slate-900 bg-sky-400 hover:bg-sky-300 shadow-md transition-colors">
                            📅 Tetapkan Jadwal & Antrean
                        </button>
                    </form>
                </div>
            @endif

            {{-- 2. PANEL SELESAIKAN PERMOHONAN & TERBITKAN E-DOKUMEN --}}
            <div class="bg-emerald-950 rounded-3xl p-6 text-white portal-shadow space-y-4">
                <div class="flex items-center gap-2">
                    <span class="text-xl">✅</span>
                    <h3 class="text-sm font-bold">Penyelesaian Permohonan</h3>
                </div>
                <p class="text-xs text-emerald-200">Jika seluruh berkas sah dan diproses, terbitkan e-dokumen hasil untuk diunduh warga.</p>

                <form action="{{ route('kecamatan.submissions.complete', $submission) }}" method="POST" enctype="multipart/form-data" class="space-y-3 pt-2">
                    @csrf
                    <div>
                        <label class="block text-[11px] font-semibold text-emerald-200 mb-1">Unggah e-Dokumen Hasil (PDF):</label>
                        <input type="file"
                               name="output_file"
                               accept=".pdf,.jpg,.png"
                               class="block w-full text-xs text-emerald-100 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-emerald-800 file:text-emerald-100 hover:file:bg-emerald-700 cursor-pointer">
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-emerald-200 mb-1">Catatan Penyelesaian:</label>
                        <textarea name="completion_notes" rows="2" placeholder="Dokumen telah selesai dan siap diunduh/diambil di kantor..." class="w-full text-xs text-slate-900 rounded-xl border-0 p-2.5"></textarea>
                    </div>

                    <button type="submit" class="w-full py-3 rounded-xl font-bold text-xs text-slate-900 bg-emerald-400 hover:bg-emerald-300 shadow-md transition-colors">
                        🎉 Selesaikan & Terbitkan Dokumen
                    </button>
                </form>
            </div>

            {{-- 3. PANEL TOLAK PERMOHONAN --}}
            <div class="bg-white rounded-3xl p-6 border border-slate-200 portal-shadow space-y-4">
                <h3 class="text-xs font-bold text-rose-600 uppercase tracking-wider">Tolak Permohonan</h3>
                <p class="text-xs text-slate-500">Gunakan ini hanya jika pengajuan melanggar peraturan atau tidak dapat diproses.</p>

                <form action="{{ route('kecamatan.submissions.reject', $submission) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menolak permohonan ini secara permanen?');" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Alasan Penolakan Resmi: <span class="text-rose-500">*</span></label>
                        <textarea name="alasan_penolakan" rows="3" required minlength="10" placeholder="Jelaskan alasan penolakan secara jelas untuk warga pemohon..." class="w-full text-xs rounded-xl border-slate-200 bg-slate-50 p-2.5 focus:border-rose-500 focus:ring-rose-500"></textarea>
                    </div>

                    <button type="submit" class="w-full py-2.5 rounded-xl font-bold text-xs text-white bg-rose-600 hover:bg-rose-700 shadow-sm transition-colors">
                        🚫 Tolak Permohonan
                    </button>
                </form>
            </div>

        </div>

    </div>

</div>
@endsection
