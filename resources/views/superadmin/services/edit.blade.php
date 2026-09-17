@extends('layouts.superadmin')

@section('title', 'Konfigurasi: ' . $service->nama_layanan . ' — Super Admin Diskominfo')

@section('breadcrumb')
    <a href="{{ route('superadmin.services.index') }}" class="hover:text-[#0a2558]">Kelola Layanan Publik</a>
    <span class="mx-1.5 text-slate-300">/</span>
    <span class="text-slate-900 font-semibold">{{ $service->nama_layanan }}</span>
@endsection

@section('content')
<div class="space-y-6" x-data="{ editingReqId: null }">

    {{-- ═══════════════════════════════════════════════════════════════════════════
         1. EXECUTIVE HEADER
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="space-y-1">
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-bold bg-blue-100 text-[#0a2558] border border-blue-200">
                    Konfigurasi Master
                </span>
                <span class="text-slate-400 text-xs">•</span>
                <span class="font-mono text-xs font-bold text-[#0a2558] bg-blue-50 px-2 py-0.5 rounded border border-blue-200">
                    {{ $service->kode_layanan }}
                </span>
            </div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">
                {{ $service->nama_layanan }}
            </h1>
            <p class="text-xs text-slate-500 max-w-2xl leading-relaxed">
                Konfigurasikan metadata alur layanan, jalur birokrasi desa, dan daftar dokumen persyaratan yang wajib dilampirkan warga secara dinamis.
            </p>
        </div>

        <div class="flex items-center gap-2.5 shrink-0">
            <a href="{{ route('superadmin.services.index') }}"
               class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 border border-slate-200 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Kembali ke Katalog</span>
            </a>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         2. TWO-COLUMN SPLIT PANE
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

        {{-- ── KOLOM KIRI: EDIT PARAMETER LAYANAN (1 COL) ─────────────────────── --}}
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs space-y-5">
            <div class="border-b border-slate-100 pb-3">
                <h3 class="font-bold text-slate-900 text-xs uppercase tracking-wider">Parameter Layanan</h3>
                <p class="text-[11px] text-slate-500 mt-0.5">Aturan bisnis dan jalur pemrosesan berkas</p>
            </div>

            <form action="{{ route('superadmin.services.update', $service) }}" method="POST" class="space-y-4 text-xs">
                @csrf
                @method('PUT')

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Nama Layanan: <span class="text-rose-500">*</span></label>
                    <input type="text"
                           name="nama_layanan"
                           value="{{ old('nama_layanan', $service->nama_layanan) }}"
                           required
                           class="w-full text-xs rounded-xl border-slate-200 bg-slate-50 p-2.5 focus:bg-white focus:border-[#0a2558] focus:ring-blue-500 font-semibold text-slate-800">
                    @error('nama_layanan') <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Deskripsi & Panduan Pemohon:</label>
                    <textarea name="deskripsi"
                              rows="3"
                              required
                              class="w-full text-xs rounded-xl border-slate-200 bg-slate-50 p-2.5 focus:bg-white focus:border-[#0a2558] focus:ring-blue-500 text-slate-800">{{ old('deskripsi', $service->deskripsi) }}</textarea>
                    @error('deskripsi') <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Jenis Alur Proses: <span class="text-rose-500">*</span></label>
                    <select name="jenis_proses"
                            required
                            class="w-full text-xs rounded-xl border-slate-200 bg-slate-50 p-2.5 focus:bg-white focus:border-[#0a2558] focus:ring-blue-500 font-medium text-slate-800">
                        <option value="full_digital" {{ old('jenis_proses', $service->jenis_proses->value) === 'full_digital' ? 'selected' : '' }}>
                            Full Digital (Selesai Online & Terbit E-Dokumen)
                        </option>
                        <option value="hybrid" {{ old('jenis_proses', $service->jenis_proses->value) === 'hybrid' ? 'selected' : '' }}>
                            Hybrid (Butuh Perekaman/Fisik di Kantor Kecamatan)
                        </option>
                    </select>
                    @error('jenis_proses') <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Urutan Tampil: <span class="text-rose-500">*</span></label>
                    <input type="number"
                           name="urutan"
                           value="{{ old('urutan', $service->urutan) }}"
                           required
                           min="0"
                           class="w-full text-xs rounded-xl border-slate-200 bg-slate-50 p-2.5 focus:bg-white focus:border-[#0a2558] focus:ring-blue-500 font-mono text-slate-800">
                    @error('urutan') <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="pt-2 space-y-3">
                    <label class="flex items-start gap-3 p-3 rounded-xl border border-slate-200 hover:bg-slate-50 cursor-pointer transition-colors">
                        <input type="checkbox"
                               name="requires_desa_approval"
                               value="1"
                               {{ old('requires_desa_approval', $service->requires_desa_approval) ? 'checked' : '' }}
                               class="mt-0.5 rounded text-[#0a2558] focus:ring-blue-500">
                        <div>
                            <span class="font-bold text-slate-800 block text-xs">Wajib Verifikasi Awal Desa</span>
                            <span class="text-[11px] text-slate-500 leading-tight">Pengajuan harus diperiksa Kasi Pelayanan Desa sebelum diteruskan ke Kecamatan.</span>
                        </div>
                    </label>

                    <label class="flex items-start gap-3 p-3 rounded-xl border border-slate-200 hover:bg-slate-50 cursor-pointer transition-colors">
                        <input type="checkbox"
                               name="is_active"
                               value="1"
                               {{ old('is_active', $service->is_active) ? 'checked' : '' }}
                               class="mt-0.5 rounded text-[#0a2558] focus:ring-blue-500">
                        <div>
                            <span class="font-bold text-slate-800 block text-xs">Layanan Aktif untuk Publik</span>
                            <span class="text-[11px] text-slate-500 leading-tight">Warga dapat melihat dan mengajukan permohonan layanan ini di portal.</span>
                        </div>
                    </label>
                </div>

                <div class="pt-3 border-t border-slate-100 flex justify-end">
                    <button type="submit"
                            class="w-full px-4 py-2.5 rounded-xl font-bold text-xs text-white bg-[#0a2558] hover:bg-[#1a3a70] transition-colors shadow-xs">
                        Simpan Perubahan Layanan
                    </button>
                </div>
            </form>
        </div>

        {{-- ── KOLOM KANAN: MANAJEMEN PERSYARATAN DOKUMEN (2 COLS) ─────────────── --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- 1. DAFTAR PERSYARATAN DOKUMEN --}}
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div>
                        <h3 class="font-bold text-slate-900 text-xs uppercase tracking-wider">Daftar Dokumen Persyaratan</h3>
                        <p class="text-[11px] text-slate-500 mt-0.5">Checklist dokumen yang wajib/opsional dilampirkan oleh pemohon</p>
                    </div>
                    <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-blue-50 text-[#0a2558] border border-blue-200">
                        {{ $service->requirements->count() }} Dokumen
                    </span>
                </div>

                <div class="space-y-3">
                    @forelse ($service->requirements as $req)
                        <div class="p-4 rounded-xl border border-slate-200 hover:border-blue-200 bg-slate-50/60 transition-all space-y-3">

                            {{-- View Mode --}}
                            <div class="flex items-start justify-between gap-4" x-show="editingReqId !== {{ $req->id }}">
                                <div class="space-y-1 min-w-0">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <span class="font-mono text-xs font-bold text-slate-400 bg-white px-2 py-0.5 rounded border border-slate-200">
                                            #{{ $req->urutan }}
                                        </span>
                                        <h4 class="font-bold text-slate-900 text-xs">{{ $req->nama_persyaratan }}</h4>
                                        @if ($req->is_required)
                                            <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-rose-50 text-rose-700 border border-rose-200">
                                                Wajib
                                            </span>
                                        @else
                                            <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-slate-100 text-slate-600 border border-slate-200">
                                                Opsional
                                            </span>
                                        @endif
                                    </div>

                                    @if ($req->deskripsi)
                                        <p class="text-[11px] text-slate-500 mt-0.5">{{ $req->deskripsi }}</p>
                                    @endif

                                    <div class="flex items-center gap-3 text-[11px] text-slate-400 pt-1">
                                        <span>Format: <strong class="text-slate-600 font-mono">{{ implode(', ', $req->accepted_formats ?? ['pdf', 'jpg', 'png']) }}</strong></span>
                                        <span>•</span>
                                        <span>Maks: <strong class="text-slate-600">{{ round($req->max_size_kb / 1024, 1) }} MB</strong> ({{ $req->max_size_kb }} KB)</span>
                                        @if ($req->submission_documents_count > 0)
                                            <span>•</span>
                                            <span class="text-indigo-600 font-semibold">{{ $req->submission_documents_count }} berkas warga terarsip</span>
                                        @endif
                                    </div>
                                </div>

                                {{-- Action Buttons --}}
                                <div class="flex items-center gap-1.5 shrink-0">
                                    <button type="button"
                                            @click="editingReqId = {{ $req->id }}; $nextTick(() => $refs['reqName{{ $req->id }}'].focus())"
                                            class="px-2.5 py-1 rounded-lg text-xs font-semibold text-[#0a2558] hover:bg-blue-100 border border-blue-200 bg-white transition-colors">
                                        Edit
                                    </button>

                                    @if ($req->submission_documents_count === 0)
                                        <form action="{{ route('superadmin.services.requirements.destroy', [$service, $req]) }}"
                                              method="POST"
                                              onsubmit="event.preventDefault(); Swal.fire({ title: 'Hapus Persyaratan?', text: 'Apakah Anda yakin ingin menghapus persyaratan {{ $req->nama_persyaratan }}? Tindakan ini tidak dapat dibatalkan.', icon: 'warning', showCancelButton: true, confirmButtonColor: '#d33', cancelButtonColor: '#3085d6', confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal' }).then((result) => { if (result.isConfirmed) { this.submit(); } })">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="px-2.5 py-1 rounded-lg text-xs font-semibold text-rose-600 hover:bg-rose-50 border border-rose-200 bg-white transition-colors">
                                                Hapus
                                            </button>
                                        </form>
                                    @else
                                        <span title="Persyaratan ini sudah memiliki berkas unggahan warga dan tidak dapat dihapus demi integritas arsip."
                                              class="text-[10px] text-slate-400 bg-slate-100 px-2 py-1 rounded-md border border-slate-200 cursor-help">
                                            Terkunci (Arsip)
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Edit Inline Form Mode --}}
                            <div x-show="editingReqId === {{ $req->id }}" x-cloak class="p-4 rounded-xl bg-white border border-blue-200 space-y-3">
                                <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                                    <span class="text-xs font-bold text-[#0a2558]">Ubah Persyaratan: {{ $req->nama_persyaratan }}</span>
                                    <button type="button" @click="editingReqId = null" class="text-xs text-slate-400 hover:text-slate-600">✕ Batal</button>
                                </div>

                                <form action="{{ route('superadmin.services.requirements.update', [$service, $req]) }}" method="POST" class="space-y-3 text-xs">
                                    @csrf
                                    @method('PUT')

                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                        <div class="sm:col-span-2">
                                            <label class="block font-bold text-slate-700 mb-1">Nama Persyaratan: <span class="text-rose-500">*</span></label>
                                            <input type="text" name="nama_persyaratan" value="{{ $req->nama_persyaratan }}" required x-ref="reqName{{ $req->id }}" class="w-full text-xs rounded-xl border-slate-200 p-2 focus:ring-blue-500">
                                        </div>
                                        <div>
                                            <label class="block font-bold text-slate-700 mb-1">Urutan: <span class="text-rose-500">*</span></label>
                                            <input type="number" name="urutan" value="{{ $req->urutan }}" required min="0" class="w-full text-xs rounded-xl border-slate-200 p-2 focus:ring-blue-500 font-mono">
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block font-bold text-slate-700 mb-1">Panduan / Keterangan Dokumen:</label>
                                        <input type="text" name="deskripsi" value="{{ $req->deskripsi }}" class="w-full text-xs rounded-xl border-slate-200 p-2 focus:ring-blue-500">
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 items-center">
                                        <div>
                                            <label class="block font-bold text-slate-700 mb-1">Maks Ukuran File (KB): <span class="text-rose-500">*</span></label>
                                            <input type="number" name="max_size_kb" value="{{ $req->max_size_kb }}" min="100" max="20480" required class="w-full text-xs rounded-xl border-slate-200 p-2 focus:ring-blue-500 font-mono">
                                        </div>
                                        <div>
                                            <label class="block font-bold text-slate-700 mb-1">Format Diizinkan: <span class="text-rose-500">*</span></label>
                                            <div class="flex items-center gap-3">
                                                @foreach (['pdf', 'jpg', 'jpeg', 'png'] as $fmt)
                                                    <label class="inline-flex items-center gap-1 text-[11px]">
                                                        <input type="checkbox" name="accepted_formats[]" value="{{ $fmt }}" {{ in_array($fmt, $req->accepted_formats ?? []) ? 'checked' : '' }} class="rounded text-[#0a2558] focus:ring-blue-500">
                                                        <span class="font-mono text-slate-700">{{ $fmt }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between pt-2 border-t border-slate-100">
                                        <label class="inline-flex items-center gap-2 cursor-pointer">
                                            <input type="checkbox" name="is_required" value="1" {{ $req->is_required ? 'checked' : '' }} class="rounded text-[#0a2558] focus:ring-blue-500">
                                            <span class="text-xs font-semibold text-slate-700">Wajib Diunggah oleh Pemohon</span>
                                        </label>
                                        <div class="flex gap-2">
                                            <button type="button" @click="editingReqId = null" class="px-3 py-1.5 rounded-lg text-xs font-semibold text-slate-600 hover:bg-slate-100 border border-slate-200">Batal</button>
                                            <button type="submit" class="px-4 py-1.5 rounded-lg text-xs font-bold text-white bg-[#0a2558] hover:bg-[#1a3a70] transition-colors">Simpan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    @empty
                        <p class="text-center py-6 text-slate-400 text-xs italic">
                            Belum ada persyaratan dokumen yang dikonfigurasi untuk layanan ini.
                        </p>
                    @endforelse
                </div>
            </div>

            {{-- 2. FORM TAMBAH PERSYARATAN BARU --}}
            <div class="bg-blue-50/50 rounded-2xl p-6 border border-blue-200 shadow-xs space-y-4">
                <div class="border-b border-blue-200/60 pb-3">
                    <h4 class="font-bold text-[#0a2558] text-xs uppercase tracking-wider">+ Tambah Persyaratan Dokumen Baru</h4>
                    <p class="text-[11px] text-blue-700 mt-0.5">Tambahkan dokumen baru yang harus dilampirkan pemohon</p>
                </div>

                <form action="{{ route('superadmin.services.requirements.store', $service) }}" method="POST" class="space-y-4 text-xs">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div class="sm:col-span-2">
                            <label class="block font-bold text-slate-700 mb-1">Nama Dokumen Persyaratan: <span class="text-rose-500">*</span></label>
                            <input type="text"
                                   name="nama_persyaratan"
                                   placeholder="Contoh: Kartu Keluarga (KK) Asli"
                                   required
                                   class="w-full text-xs rounded-xl border-slate-200 bg-white p-2.5 focus:border-[#0a2558] focus:ring-blue-500 text-slate-800">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Urutan: <span class="text-rose-500">*</span></label>
                            <input type="number"
                                   name="urutan"
                                   value="{{ ($service->requirements->max('urutan') ?? 0) + 1 }}"
                                   required
                                   min="0"
                                   class="w-full text-xs rounded-xl border-slate-200 bg-white p-2.5 focus:border-[#0a2558] focus:ring-blue-500 font-mono text-slate-800">
                        </div>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Panduan / Keterangan untuk Pemohon:</label>
                        <input type="text"
                               name="deskripsi"
                               placeholder="Contoh: Scan/Foto asli berwarna, pastikan seluruh teks terbaca jelas dan tidak terpotong..."
                               class="w-full text-xs rounded-xl border-slate-200 bg-white p-2.5 focus:border-[#0a2558] focus:ring-blue-500 text-slate-800">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-center">
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Maksimal Ukuran File (KB): <span class="text-rose-500">*</span></label>
                            <input type="number"
                                   name="max_size_kb"
                                   value="5120"
                                   min="100"
                                   max="20480"
                                   required
                                   class="w-full text-xs rounded-xl border-slate-200 bg-white p-2.5 focus:border-[#0a2558] focus:ring-blue-500 font-mono text-slate-800">
                            <span class="text-[10px] text-slate-400 mt-0.5 block">5120 KB = 5 Megabytes</span>
                        </div>

                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Format Berkas yang Diterima: <span class="text-rose-500">*</span></label>
                            <div class="flex items-center gap-3 pt-1">
                                <label class="inline-flex items-center gap-1.5 text-xs cursor-pointer">
                                    <input type="checkbox" name="accepted_formats[]" value="pdf" checked class="rounded text-[#0a2558] focus:ring-blue-500">
                                    <span class="font-mono font-semibold text-slate-700">.pdf</span>
                                </label>
                                <label class="inline-flex items-center gap-1.5 text-xs cursor-pointer">
                                    <input type="checkbox" name="accepted_formats[]" value="jpg" checked class="rounded text-[#0a2558] focus:ring-blue-500">
                                    <span class="font-mono font-semibold text-slate-700">.jpg</span>
                                </label>
                                <label class="inline-flex items-center gap-1.5 text-xs cursor-pointer">
                                    <input type="checkbox" name="accepted_formats[]" value="jpeg" checked class="rounded text-[#0a2558] focus:ring-blue-500">
                                    <span class="font-mono font-semibold text-slate-700">.jpeg</span>
                                </label>
                                <label class="inline-flex items-center gap-1.5 text-xs cursor-pointer">
                                    <input type="checkbox" name="accepted_formats[]" value="png" checked class="rounded text-[#0a2558] focus:ring-blue-500">
                                    <span class="font-mono font-semibold text-slate-700">.png</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-2 border-t border-blue-200/50">
                        <label class="inline-flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_required" value="1" checked class="rounded text-[#0a2558] focus:ring-blue-500">
                            <span class="text-xs font-bold text-slate-800">Wajib Diunggah (Mandatory)</span>
                        </label>

                        <button type="submit"
                                class="px-5 py-2.5 rounded-xl font-bold text-xs text-white bg-[#0a2558] hover:bg-[#1a3a70] shadow-xs transition-all">
                            + Tambah Dokumen Persyaratan
                        </button>
                    </div>
                </form>
            </div>

        </div>

    </div>

</div>
@endsection
