@extends('layouts.app')

@section('title', 'Konfigurasi Layanan: ' . $service->nama_layanan . ' — Diskominfo Kab. Tasikmalaya')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8" x-data="{ editingReqId: null }">

    {{-- ═══════════════════════════════════════════════════════════════════════════
         1. HEADER BANNER
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="bg-gradient-to-r from-purple-950 via-slate-900 to-indigo-950 rounded-3xl p-6 sm:p-8 text-white portal-shadow relative overflow-hidden">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-purple-500/20 text-purple-300 border border-purple-500/30">
                    <span>⚙️ Pengaturan Master Layanan</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight flex items-center gap-3">
                    <span>{{ $service->nama_layanan }}</span>
                    <span class="font-mono text-sm px-3 py-1 rounded-xl bg-purple-900/60 border border-purple-400/30 font-bold text-purple-200">
                        {{ $service->kode_layanan }}
                    </span>
                </h1>
                <p class="text-xs sm:text-sm text-slate-300">
                    Konfigurasikan metadata alur layanan dan kelola dokumen persyaratan yang wajib dilampirkan warga.
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('superadmin.services.index') }}" class="px-4 py-2.5 rounded-xl text-xs font-bold text-white bg-white/10 hover:bg-white/20 backdrop-blur-sm transition-colors border border-white/20">
                    &larr; Kembali ke Katalog
                </a>
            </div>
        </div>
    </div>

    {{-- Feedback Notifications --}}
    @if (session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center gap-3">
            <span class="text-lg">✓</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if (session('error'))
        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold flex items-center gap-3">
            <span class="text-lg">⚠️</span>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

        {{-- ═══════════════════════════════════════════════════════════════════════
             KOLOM KIRI: EDIT METADATA LAYANAN (1 COL)
        ═══════════════════════════════════════════════════════════════════════ --}}
        <div class="bg-white rounded-3xl p-6 border border-slate-200 portal-shadow space-y-6">
            <div class="border-b border-slate-100 pb-4">
                <h3 class="font-bold text-slate-900 text-sm">Parameter Layanan</h3>
                <p class="text-xs text-slate-500">Aturan bisnis dan jalur birokrasi layanan ini.</p>
            </div>

            <form action="{{ route('superadmin.services.update', $service) }}" method="POST" class="space-y-4 text-xs">
                @csrf
                @method('PUT')

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Nama Layanan: <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama_layanan" value="{{ old('nama_layanan', $service->nama_layanan) }}" required class="w-full text-xs rounded-xl border-slate-200 bg-slate-50 p-2.5 focus:bg-white focus:border-purple-500 focus:ring-purple-500 font-semibold">
                    @error('nama_layanan') <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Deskripsi & Penjelasan:</label>
                    <textarea name="deskripsi" rows="3" required class="w-full text-xs rounded-xl border-slate-200 bg-slate-50 p-2.5 focus:bg-white focus:border-purple-500 focus:ring-purple-500">{{ old('deskripsi', $service->deskripsi) }}</textarea>
                    @error('deskripsi') <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Jenis Alur Proses: <span class="text-rose-500">*</span></label>
                    <select name="jenis_proses" required class="w-full text-xs rounded-xl border-slate-200 bg-slate-50 p-2.5 focus:bg-white focus:border-purple-500 focus:ring-purple-500 font-medium">
                        <option value="full_digital" {{ old('jenis_proses', $service->jenis_proses->value) === 'full_digital' ? 'selected' : '' }}>Full Digital (Selesai Online)</option>
                        <option value="hybrid" {{ old('jenis_proses', $service->jenis_proses->value) === 'hybrid' ? 'selected' : '' }}>Hybrid (Butuh Perekaman/Fisik di Kecamatan)</option>
                    </select>
                    @error('jenis_proses') <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="pt-2 space-y-3">
                    <label class="flex items-start gap-3 p-3 rounded-xl border border-slate-200 hover:bg-slate-50/50 cursor-pointer">
                        <input type="checkbox" name="requires_desa_approval" value="1" {{ old('requires_desa_approval', $service->requires_desa_approval) ? 'checked' : '' }} class="mt-0.5 rounded text-purple-600 focus:ring-purple-500">
                        <div>
                            <span class="font-bold text-slate-800 block text-xs">Wajib Verifikasi Awal Desa</span>
                            <span class="text-[11px] text-slate-500 leading-tight">Jika dicentang, pengajuan wajib diperiksa Kasi Pelayanan Desa sebelum masuk ke Kecamatan.</span>
                        </div>
                    </label>

                    <label class="flex items-start gap-3 p-3 rounded-xl border border-slate-200 hover:bg-slate-50/50 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $service->is_active) ? 'checked' : '' }} class="mt-0.5 rounded text-purple-600 focus:ring-purple-500">
                        <div>
                            <span class="font-bold text-slate-800 block text-xs">Layanan Aktif untuk Publik</span>
                            <span class="text-[11px] text-slate-500 leading-tight">Warga dapat melihat dan mengajukan permohonan untuk layanan ini.</span>
                        </div>
                    </label>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Urutan Tampilan: <span class="text-rose-500">*</span></label>
                    <input type="number" name="urutan" value="{{ old('urutan', $service->urutan) }}" min="0" required class="w-full text-xs rounded-xl border-slate-200 bg-slate-50 p-2.5 focus:bg-white focus:border-purple-500 focus:ring-purple-500 font-mono">
                    @error('urutan') <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-end">
                    <button type="submit" class="w-full py-3 rounded-xl font-bold text-xs text-white bg-purple-700 hover:bg-purple-800 shadow-md shadow-purple-700/20 transition-all">
                        💾 Simpan Perubahan Layanan
                    </button>
                </div>
            </form>
        </div>

        {{-- ═══════════════════════════════════════════════════════════════════════
             KOLOM KANAN: PERSYARATAN DOKUMEN (2 COLS)
        ═══════════════════════════════════════════════════════════════════════ --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- 1. DAFTAR PERSYARATAN SAAT INI --}}
            <div class="bg-white rounded-3xl p-6 border border-slate-200 portal-shadow space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div>
                        <h3 class="font-bold text-slate-900 text-sm">Persyaratan Dokumen ({{ $service->requirements->count() }})</h3>
                        <p class="text-xs text-slate-500">Dokumen yang wajib atau opsional diunggah oleh warga saat mengajukan.</p>
                    </div>
                </div>

                <div class="space-y-3">
                    @forelse ($service->requirements as $req)
                        <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50/50 hover:bg-white transition-all space-y-3">
                            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-2">
                                <div class="space-y-1">
                                    <div class="flex items-center gap-2">
                                        <span class="font-mono text-slate-400 font-bold text-[11px]">#{{ $req->urutan }}</span>
                                        <h4 class="font-bold text-slate-900 text-xs">{{ $req->nama_persyaratan }}</h4>
                                        @if ($req->is_required)
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-rose-100 text-rose-700 border border-rose-200">
                                                Wajib
                                            </span>
                                        @else
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                                Opsional
                                            </span>
                                        @endif
                                    </div>
                                    @if ($req->deskripsi)
                                        <p class="text-[11px] text-slate-500">{{ $req->deskripsi }}</p>
                                    @endif
                                    <div class="flex items-center gap-3 text-[10px] text-slate-500 font-mono">
                                        <span>Format: {{ implode(', ', $req->accepted_formats ?? ['pdf','jpg']) }}</span>
                                        <span>•</span>
                                        <span>Maks: {{ round($req->max_size_kb / 1024, 1) }} MB ({{ $req->max_size_kb }} KB)</span>
                                        <span>•</span>
                                        <span>Digunakan: <strong>{{ $req->submission_documents_count }}</strong> berkas</span>
                                    </div>
                                </div>

                                <div class="flex items-center gap-2 pt-2 sm:pt-0">
                                    <button type="button"
                                            @click="editingReqId = (editingReqId === {{ $req->id }} ? null : {{ $req->id }})"
                                            class="px-2.5 py-1 rounded-lg text-[11px] font-semibold text-slate-700 bg-white hover:bg-slate-100 border border-slate-200 transition-colors">
                                        ✏️ Edit
                                    </button>

                                    <form action="{{ route('superadmin.services.requirements.destroy', [$service, $req]) }}"
                                          method="POST"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus persyaratan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1 rounded-lg text-[11px] font-semibold text-rose-700 bg-rose-50 hover:bg-rose-100 border border-rose-200 transition-colors">
                                            🗑️ Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>

                            {{-- INLINE EDIT FORM (TOGGLED BY ALPINE) --}}
                            <div x-show="editingReqId === {{ $req->id }}" x-cloak class="pt-4 mt-2 border-t border-slate-200 space-y-3">
                                <h5 class="text-[11px] font-bold uppercase tracking-wider text-purple-700">Edit Persyaratan:</h5>
                                <form action="{{ route('superadmin.services.requirements.update', [$service, $req]) }}" method="POST" class="space-y-3 text-xs">
                                    @csrf
                                    @method('PUT')
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                        <div>
                                            <label class="block font-bold text-slate-700 mb-1">Nama Dokumen:</label>
                                            <input type="text" name="nama_persyaratan" value="{{ $req->nama_persyaratan }}" required class="w-full text-xs rounded-xl border-slate-200 p-2 focus:ring-purple-500">
                                        </div>
                                        <div>
                                            <label class="block font-bold text-slate-700 mb-1">Urutan:</label>
                                            <input type="number" name="urutan" value="{{ $req->urutan }}" required min="0" class="w-full text-xs rounded-xl border-slate-200 p-2 focus:ring-purple-500">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block font-bold text-slate-700 mb-1">Keterangan / Panduan:</label>
                                        <input type="text" name="deskripsi" value="{{ $req->deskripsi }}" class="w-full text-xs rounded-xl border-slate-200 p-2 focus:ring-purple-500">
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 items-center">
                                        <div>
                                            <label class="block font-bold text-slate-700 mb-1">Maks Ukuran File (KB):</label>
                                            <input type="number" name="max_size_kb" value="{{ $req->max_size_kb }}" min="100" max="20480" required class="w-full text-xs rounded-xl border-slate-200 p-2 focus:ring-purple-500">
                                        </div>
                                        <div>
                                            <label class="block font-bold text-slate-700 mb-1">Format Diizinkan:</label>
                                            <div class="flex items-center gap-3">
                                                @foreach (['pdf', 'jpg', 'jpeg', 'png'] as $fmt)
                                                    <label class="inline-flex items-center gap-1 text-[11px]">
                                                        <input type="checkbox" name="accepted_formats[]" value="{{ $fmt }}" {{ in_array($fmt, $req->accepted_formats ?? []) ? 'checked' : '' }} class="rounded text-purple-600 focus:ring-purple-500">
                                                        <span>{{ $fmt }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between pt-2">
                                        <label class="inline-flex items-center gap-2">
                                            <input type="checkbox" name="is_required" value="1" {{ $req->is_required ? 'checked' : '' }} class="rounded text-purple-600 focus:ring-purple-500">
                                            <span class="text-xs font-semibold text-slate-700">Wajib Diunggah</span>
                                        </label>
                                        <div class="flex gap-2">
                                            <button type="button" @click="editingReqId = null" class="px-3 py-1.5 rounded-lg text-xs text-slate-600 hover:bg-slate-200">Batal</button>
                                            <button type="submit" class="px-4 py-1.5 rounded-lg text-xs font-bold text-white bg-purple-700 hover:bg-purple-800">Simpan Perubahan</button>
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
            <div class="bg-purple-50/50 rounded-3xl p-6 border border-purple-200/80 portal-shadow space-y-4">
                <div class="border-b border-purple-200/50 pb-3">
                    <h4 class="font-bold text-purple-950 text-xs uppercase tracking-wider">+ Tambah Persyaratan Dokumen Baru</h4>
                    <p class="text-[11px] text-purple-700">Tambahkan jenis berkas yang harus diunggah pemohon tanpa mengubah kode program.</p>
                </div>

                <form action="{{ route('superadmin.services.requirements.store', $service) }}" method="POST" class="space-y-4 text-xs">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div class="sm:col-span-2">
                            <label class="block font-bold text-slate-700 mb-1">Nama Dokumen Persyaratan: <span class="text-rose-500">*</span></label>
                            <input type="text" name="nama_persyaratan" placeholder="Contoh: Kartu Keluarga (KK) Asli" required class="w-full text-xs rounded-xl border-slate-200 bg-white p-2.5 focus:border-purple-500 focus:ring-purple-500">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Urutan: <span class="text-rose-500">*</span></label>
                            <input type="number" name="urutan" value="{{ ($service->requirements->max('urutan') ?? 0) + 1 }}" required min="0" class="w-full text-xs rounded-xl border-slate-200 bg-white p-2.5 focus:border-purple-500 focus:ring-purple-500 font-mono">
                        </div>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Panduan / Keterangan untuk Pemohon:</label>
                        <input type="text" name="deskripsi" placeholder="Contoh: Scan/Foto asli, pastikan tulisan terbaca jelas dan tidak terpotong..." class="w-full text-xs rounded-xl border-slate-200 bg-white p-2.5 focus:border-purple-500 focus:ring-purple-500">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-center">
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Maksimal Ukuran File (KB): <span class="text-rose-500">*</span></label>
                            <input type="number" name="max_size_kb" value="2048" min="100" max="20480" required class="w-full text-xs rounded-xl border-slate-200 bg-white p-2.5 focus:border-purple-500 focus:ring-purple-500 font-mono">
                            <span class="text-[10px] text-slate-400 mt-0.5 block">2048 KB = 2 Megabytes</span>
                        </div>

                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Format Berkas yang Diterima: <span class="text-rose-500">*</span></label>
                            <div class="flex items-center gap-3 pt-1">
                                <label class="inline-flex items-center gap-1.5 text-xs">
                                    <input type="checkbox" name="accepted_formats[]" value="pdf" checked class="rounded text-purple-600 focus:ring-purple-500">
                                    <span class="font-mono font-semibold text-slate-700">.pdf</span>
                                </label>
                                <label class="inline-flex items-center gap-1.5 text-xs">
                                    <input type="checkbox" name="accepted_formats[]" value="jpg" checked class="rounded text-purple-600 focus:ring-purple-500">
                                    <span class="font-mono font-semibold text-slate-700">.jpg</span>
                                </label>
                                <label class="inline-flex items-center gap-1.5 text-xs">
                                    <input type="checkbox" name="accepted_formats[]" value="jpeg" checked class="rounded text-purple-600 focus:ring-purple-500">
                                    <span class="font-mono font-semibold text-slate-700">.jpeg</span>
                                </label>
                                <label class="inline-flex items-center gap-1.5 text-xs">
                                    <input type="checkbox" name="accepted_formats[]" value="png" checked class="rounded text-purple-600 focus:ring-purple-500">
                                    <span class="font-mono font-semibold text-slate-700">.png</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-2">
                        <label class="inline-flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_required" value="1" checked class="rounded text-purple-600 focus:ring-purple-500">
                            <span class="text-xs font-bold text-slate-800">Wajib Diunggah (Mandatory)</span>
                        </label>

                        <button type="submit" class="px-5 py-2.5 rounded-xl font-bold text-xs text-white bg-purple-700 hover:bg-purple-800 shadow-md shadow-purple-700/20 transition-all">
                            + Tambah Persyaratan
                        </button>
                    </div>
                </form>
            </div>

        </div>

    </div>

</div>
@endsection
