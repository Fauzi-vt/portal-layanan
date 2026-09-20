@extends('layouts.warga')

@section('title', 'Edit Draft Permohonan — Portal Layanan Publik KOMDIGI')

@section('content')
<div class="space-y-6">

    {{-- ═══════════════════════════════════════════════════════════════════════════
         1. TITLE & BREADCRUMB
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-200 pb-4">
        <h1 class="text-xl font-bold text-slate-900 tracking-tight">
            Edit Draft Permohonan
        </h1>

        <div class="flex items-center gap-1.5 text-xs text-slate-500 font-medium">
            <a href="{{ route('warga.dashboard') }}" class="text-blue-600 hover:underline">Dashboard</a>
            <span>/</span>
            <a href="{{ route('warga.submissions.index') }}" class="text-blue-600 hover:underline">Permohonan</a>
            <span>/</span>
            <a href="{{ route('warga.submissions.show', $submission) }}" class="text-blue-600 hover:underline">{{ $submission->nomor_tiket }}</a>
            <span>/</span>
            <span class="text-slate-800 font-semibold">Edit Draft</span>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════
         4. FORMULIR PENGAJUAN LAYANAN TERPILIH
    ═══════════════════════════════════════════════════════════════════════ --}}
    <form action="{{ route('warga.submissions.update', $submission) }}" method="POST" enctype="multipart/form-data" class="space-y-6" x-data="{ isSubmitting: false }" @submit="isSubmitting = true">
        @csrf
        @method('PUT')
        <input type="hidden" name="service_id" value="{{ $service->id }}">

            {{-- Selected Service Card --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-xs p-5 sm:p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center text-xl font-bold flex-shrink-0 border border-blue-100">
                        @if ($service->kode_layanan === 'KIA') <i data-lucide="contact" class="w-6 h-6"></i>
                        @elseif ($service->kode_layanan === 'EKTP') <i data-lucide="camera" class="w-6 h-6"></i>
                        @elseif ($service->kode_layanan === 'KK_BARU') <i data-lucide="users" class="w-6 h-6"></i>
                        @elseif ($service->kode_layanan === 'KK_ADD') <i data-lucide="user-plus" class="w-6 h-6"></i>
                        @elseif ($service->kode_layanan === 'KK_DEL') <i data-lucide="user-minus" class="w-6 h-6"></i>
                        @elseif ($service->kode_layanan === 'PINDAH') <i data-lucide="truck" class="w-6 h-6"></i>
                        @elseif ($service->kode_layanan === 'DATANG') <i data-lucide="home" class="w-6 h-6"></i>
                        @elseif ($service->kode_layanan === 'NIKAH') <i data-lucide="heart" class="w-6 h-6"></i>
                        @else <i data-lucide="file-text" class="w-6 h-6"></i>
                        @endif
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-blue-100 text-blue-800">
                                {{ $service->kode_layanan }}
                            </span>
                            <span class="px-2 py-0.5 rounded text-[10px] font-semibold {{ $service->jenis_proses->badgeColor() }}">
                                {{ $service->jenis_proses === \App\Enums\ServiceProcessType::FullDigital ? 'Digital Penuh' : 'Hybrid' }}
                            </span>
                        </div>
                        <h2 class="text-base sm:text-lg font-bold text-slate-900 mt-1">{{ $service->nama_layanan }}</h2>
                        <p class="text-xs text-slate-500 mt-0.5">{{ $service->deskripsi }}</p>
                    </div>
                </div>

                <div class="text-xs text-slate-500 bg-slate-100 px-3 py-1.5 rounded-lg font-medium whitespace-nowrap self-start sm:self-center">
                    Jenis Layanan Tetap
                </div>
            </div>

            {{-- Formulir Fisik Notice (If Hybrid) --}}
            @if ($service->isHybrid() && $service->template_formulir_path)
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 text-xs">
                    <div class="flex items-center gap-3">
                        <span class="text-xl">📄</span>
                        <div>
                            <p class="font-bold text-amber-900">Perhatian: Layanan Membutuhkan Formulir Fisik Desa / KUA</p>
                            <p class="text-amber-800 mt-0.5">Unduh template form, minta tanda tangan & stempel kantor desa asal, lalu unggah hasil scan aslinya di bawah.</p>
                        </div>
                    </div>
                    <a href="#" onclick="alert('Template formulir siap diunduh.');" class="px-3.5 py-2 rounded-lg font-bold text-white bg-amber-600 hover:bg-amber-700 whitespace-nowrap shadow-2xs">
                        Unduh Template PDF
                    </a>
                </div>
            @endif

            {{-- Form Section 1: Wilayah & Identitas --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-xs p-6 space-y-4">
                <h3 class="text-sm font-bold text-slate-900 border-b border-slate-100 pb-3">
                    1. Wilayah Verifikasi & Data Pemohon
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="kecamatan_id" class="block text-xs font-semibold text-slate-800 mb-1.5 flex items-center justify-between">
                            <span>Kecamatan Tujuan Verifikasi <span class="text-rose-600 font-bold" aria-hidden="true">*</span></span>
                            <span class="text-[11px] text-slate-400">39 Kecamatan</span>
                        </label>
                        <select name="kecamatan_id"
                                id="kecamatan_id"
                                required
                                aria-required="true"
                                class="w-full text-xs font-semibold rounded-xl border border-slate-300 bg-white text-slate-900 focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 focus:outline-none py-2.5 px-3 shadow-2xs transition-colors">
                            @foreach ($kecamatans as $kec)
                                <option value="{{ $kec->id }}" {{ old('kecamatan_id', $submission->kecamatan_id) == $kec->id ? 'selected' : '' }}>
                                    Kecamatan {{ $kec->nama_kecamatan }} ({{ $kec->kode_kecamatan }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="block text-xs font-semibold text-slate-800">Identitas Pemohon Terdaftar</span>
                            <span class="inline-flex items-center gap-1 text-[10px] font-medium text-blue-700 bg-blue-50 px-2 py-0.5 rounded-full border border-blue-200">
                                <i data-lucide="lock" class="w-3 h-3"></i>
                                Terisi otomatis dari profil akun
                            </span>
                        </div>
                        <div class="p-3 bg-[#F3F4F6] border border-slate-200 rounded-xl text-xs space-y-1 cursor-not-allowed select-none shadow-2xs">
                            <p class="font-bold text-slate-900">{{ $user->name }} <span class="font-mono text-slate-600 font-medium">(NIK: {{ $user->nik ?? '-' }})</span></p>
                            <p class="text-[11px] text-slate-600">Email: {{ $user->email }} | WhatsApp: {{ $user->phone ?? '-' }}</p>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Form Section: Formulir Kartu Keluarga (KK Baru, Penambahan KK, Pengurangan KK) --}}
            @if ($service->kode_layanan === 'KK_BARU')
                <div class="space-y-3">
                    <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                        <span>2. Pengisian Formulir Pembuatan Kartu Keluarga Baru</span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800">Format Resmi Dukcapil</span>
                    </h3>
                    @include('warga.submissions.partials.form-f101')
                </div>
            @elseif ($service->kode_layanan === 'KK_ADD')
                <div class="space-y-3">
                    <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                        <span>2. Pengisian Formulir Penambahan Anggota Keluarga</span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">Format Resmi Dukcapil</span>
                    </h3>
                    @include('warga.submissions.partials.form-kk-add')
                </div>
            @elseif ($service->kode_layanan === 'KK_DEL')
                <div class="space-y-3">
                    <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                        <span>2. Pengisian Formulir Pengurangan Anggota Keluarga</span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800">Format Resmi Dukcapil</span>
                    </h3>
                    @include('warga.submissions.partials.form-kk-del')
                </div>
            @elseif (!str_starts_with($service->kode_layanan, 'PINDAH') && $service->kode_layanan !== 'DATANG' && $service->requirements->contains(fn($r) => str_contains($r->nama_persyaratan, 'F-1.01') || str_contains($r->nama_persyaratan, 'F-1.15')))
                <div class="space-y-3">
                    <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                        <span>2. Pengisian Formulir Kartu Keluarga</span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800">Format Resmi Dukcapil</span>
                    </h3>
                    @include('warga.submissions.partials.form-f101')
                </div>
            @endif

            {{-- Form Section: Formulir Pindah Datang WNI (Satu Desa, Antar Desa, Antar Kecamatan) --}}
            @if ($service->kode_layanan === 'PINDAH_SATU_DESA')
                <div class="space-y-3">
                    @include('warga.submissions.partials.form-pindah-satu-desa')
                </div>
            @elseif ($service->kode_layanan === 'PINDAH_ANTAR_DESA')
                <div class="space-y-3">
                    @include('warga.submissions.partials.form-pindah-antar-desa')
                </div>
            @elseif ($service->kode_layanan === 'PINDAH_ANTAR_KEC' || $service->kode_layanan === 'PINDAH' || $service->kode_layanan === 'DATANG')
                <div class="space-y-3">
                    @include('warga.submissions.partials.form-pindah-antar-kecamatan')
                </div>
            @endif

            {{-- Form Section: Upload Persyaratan --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-xs p-6 space-y-5">
                <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                    <h3 class="text-sm font-bold text-slate-900">
                        {{ (in_array($service->kode_layanan, ['KK_BARU', 'KK_ADD', 'KK_DEL']) || str_starts_with($service->kode_layanan, 'PINDAH') || $service->kode_layanan === 'DATANG' || $service->requirements->contains(fn($r) => str_contains($r->nama_persyaratan, 'F-1.01') || str_contains($r->nama_persyaratan, 'F-1.15'))) ? '3. Dokumen Persyaratan & Berkas Pendukung' : '2. Dokumen Persyaratan' }}
                    </h3>
                    <span class="text-xs text-slate-400">PDF, JPG, PNG (Maks 5 MB)</span>
                </div>

                <div class="space-y-4">
                    @foreach ($service->requirements as $req)
                        @php
                            $isF101Doc = str_contains($req->nama_persyaratan, 'F-1.01') || str_contains($req->nama_persyaratan, 'F-1.15') || str_contains($req->nama_persyaratan, 'Formulir');
                            $existingDoc = $submission->documents->firstWhere('service_requirement_id', $req->id);
                        @endphp
                        <div class="p-4 rounded-xl border {{ $isF101Doc ? 'border-blue-200 bg-blue-50/40' : 'border-slate-200 bg-slate-50/60' }} space-y-2.5">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <h4 class="text-xs font-bold text-slate-800">{{ $req->nama_persyaratan }}</h4>
                                    @if ($isF101Doc)
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                            ✓ Sudah Diisi Online (Scan Fisik Opsional)
                                        </span>
                                    @elseif ($req->is_required)
                                        <span class="px-1.5 py-0.2 rounded text-[10px] font-bold bg-rose-100 text-rose-700">Wajib</span>
                                    @else
                                        <span class="px-1.5 py-0.2 rounded text-[10px] font-semibold bg-slate-200 text-slate-600">Opsional</span>
                                    @endif
                                </div>
                            </div>
                            <p class="text-[11px] text-slate-500 leading-relaxed">{{ $req->deskripsi }}</p>

                            @if ($isF101Doc)
                                <div class="p-3 bg-white border border-blue-200 rounded-xl text-xs text-slate-700 space-y-1">
                                    <div class="flex items-center gap-1.5 text-blue-800 font-bold">
                                        <i data-lucide="sparkles" class="w-3.5 h-3.5 text-amber-500"></i>
                                        <span>Kemudahan Layanan Online:</span>
                                    </div>
                                    <p class="text-[11px] text-slate-600">
                                        Karena Anda telah mengisi <strong>Formulir Digital F-1.15</strong> pada bagian formulir di atas, pengunggahan scan formulir kertas ini bersifat <strong>opsional</strong>. Namun jika Anda sudah memiliki scan bertanda tangan basah dari Desa, Anda tetap dapat melampirkannya di bawah.
                                    </p>
                                </div>
                            @endif

                            @if ($existingDoc)
                                <div class="mt-2 mb-3 p-3 bg-white border border-emerald-200 rounded-lg flex items-center justify-between shadow-2xs">
                                    <div class="flex items-center gap-2 overflow-hidden">
                                        <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-500 flex-shrink-0"></i>
                                        <span class="text-[11px] font-medium text-slate-700 truncate" title="{{ $existingDoc->file_name }}">
                                            Sudah diunggah: <span class="font-bold">{{ $existingDoc->file_name }}</span>
                                        </span>
                                    </div>
                                </div>
                                <p class="text-[10px] font-medium text-slate-400">Pilih file baru jika ingin mengganti dokumen yang sudah ada:</p>
                            @endif

                            <input type="file"
                                   id="doc_{{ $req->id }}"
                                   name="documents[{{ $req->id }}]"
                                   accept=".pdf,.jpg,.jpeg,.png"
                                   class="block w-full text-xs text-slate-700 file:mr-3 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer border border-slate-300 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 shadow-2xs transition-colors">
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('warga.submissions.show', $submission) }}" class="px-5 py-2.5 rounded-lg font-semibold text-xs text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-lg font-semibold text-xs text-white bg-blue-700 hover:bg-blue-800 transition-colors shadow-xs cursor-pointer" :disabled="isSubmitting" :class="{'opacity-75 cursor-wait': isSubmitting}">
                    <span x-show="!isSubmitting">Simpan Perubahan</span>
                    <span x-show="isSubmitting">Menyimpan...</span>
                </button>
            </div>
        </form>

</div>
@endsection
