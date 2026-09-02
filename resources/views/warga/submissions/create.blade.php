@extends('layouts.warga')

@section('title', 'Tambah Permohonan — Portal Layanan Publik KOMDIGI')

@section('content')
<div class="space-y-6" x-data="{ searchQuery: '', selectedServiceId: '{{ $service?->id ?? '' }}' }">

    {{-- ═══════════════════════════════════════════════════════════════════════════
         1. TITLE & BREADCRUMB (Exact match with KOMDIGI screenshot)
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-200 pb-4">
        <h1 class="text-xl font-bold text-slate-900 tracking-tight">
            Tambah Permohonan
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
        {{-- ═══════════════════════════════════════════════════════════════════════
             2. PERMOHONAN BARU & SEARCH BAR (Exact match with screenshot)
        ═══════════════════════════════════════════════════════════════════════ --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pt-2">
            <h2 class="text-base font-bold text-slate-900">
                Permohonan Baru
            </h2>

            {{-- Pill Search Input with Dark Blue Circle Search Button --}}
            <div class="relative w-full sm:w-96">
                <input
                    type="text"
                    x-model="searchQuery"
                    placeholder="Telusuri layanan di sini"
                    class="w-full pl-5 pr-14 py-2.5 rounded-full bg-white border border-slate-200 text-xs sm:text-sm text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600 shadow-2xs"
                >
                <button type="button" class="absolute right-1 top-1 bottom-1 w-9 h-9 rounded-full bg-[#0b256b] text-white flex items-center justify-center hover:bg-[#081c52] transition-colors cursor-pointer shadow-xs">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- ═══════════════════════════════════════════════════════════════════════
             3. LIST OF SERVICE ROWS (Horizontal Cards with Amber Chevron >)
        ═══════════════════════════════════════════════════════════════════════ --}}
        <div class="space-y-3.5 pt-1">
            @foreach ($services as $srv)
                <a href="{{ route('warga.submissions.create', ['service' => $srv->kode_layanan]) }}"
                   x-show="searchQuery === '' || '{{ strtolower($srv->nama_layanan . ' ' . $srv->kode_layanan . ' ' . $srv->deskripsi) }}'.includes(searchQuery.toLowerCase())"
                   class="bg-white rounded-xl border border-slate-200 shadow-xs hover:border-blue-400 hover:shadow-sm p-4 sm:p-5 flex items-center justify-between transition-all group cursor-pointer block">
                    
                    {{-- Left: Icon + Title --}}
                    <div class="flex items-center gap-4">
                        {{-- Icon Illustration Box --}}
                        <div class="w-12 h-12 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center text-2xl flex-shrink-0 group-hover:scale-105 transition-transform shadow-2xs">
                            @if ($srv->kode_layanan === 'KIA') 🪪
                            @elseif ($srv->kode_layanan === 'EKTP') 📸
                            @elseif ($srv->kode_layanan === 'KK_BARU') 👨‍👩‍👧‍👦
                            @elseif ($srv->kode_layanan === 'KK_ADD') 👶
                            @elseif ($srv->kode_layanan === 'KK_DEL') 📋
                            @elseif ($srv->kode_layanan === 'PINDAH') 🚚
                            @elseif ($srv->kode_layanan === 'NIKAH') 💍
                            @else 📄
                            @endif
                        </div>

                        <div>
                            <h3 class="text-sm sm:text-base font-semibold text-slate-800 group-hover:text-blue-700 transition-colors">
                                {{ $srv->nama_layanan }}
                            </h3>
                            <p class="text-xs text-slate-500 mt-0.5 line-clamp-1">
                                {{ $srv->deskripsi }}
                            </p>
                        </div>
                    </div>

                    {{-- Right: Amber Gold Chevron Arrow (Exact match with screenshot) --}}
                    <div class="pl-4 flex-shrink-0">
                        <svg class="w-6 h-6 text-amber-500 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>

                </a>
            @endforeach
        </div>

    @else

        {{-- ═══════════════════════════════════════════════════════════════════════
             4. FORMULIR PENGAJUAN LAYANAN TERPILIH
        ═══════════════════════════════════════════════════════════════════════ --}}
        <form action="{{ route('warga.submissions.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <input type="hidden" name="service_id" value="{{ $service->id }}">

            {{-- Selected Service Card --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-xs p-5 sm:p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center text-2xl font-bold flex-shrink-0">
                        @if ($service->kode_layanan === 'KIA') 🪪
                        @elseif ($service->kode_layanan === 'EKTP') 📸
                        @elseif ($service->kode_layanan === 'KK_BARU') 👨‍👩‍👧‍👦
                        @elseif ($service->kode_layanan === 'KK_ADD') 👶
                        @elseif ($service->kode_layanan === 'KK_DEL') 📋
                        @elseif ($service->kode_layanan === 'PINDAH') 🚚
                        @elseif ($service->kode_layanan === 'NIKAH') 💍
                        @else 📄
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

                <a href="{{ route('warga.submissions.create') }}" class="text-xs text-blue-600 hover:text-blue-800 font-semibold underline whitespace-nowrap self-start sm:self-center">
                    Ganti Layanan
                </a>
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
                        <label for="kecamatan_id" class="block text-xs font-semibold text-slate-700 mb-1">
                            Kecamatan Tujuan Verifikasi <span class="text-rose-500">*</span>
                        </label>
                        <select name="kecamatan_id" id="kecamatan_id" required class="w-full text-xs font-medium rounded-lg border-slate-300 bg-slate-50 focus:bg-white focus:border-blue-600 focus:ring-1 focus:ring-blue-600 py-2.5">
                            @foreach ($kecamatans as $kec)
                                <option value="{{ $kec->id }}" {{ old('kecamatan_id', $user->kecamatan_id) == $kec->id ? 'selected' : '' }}>
                                    Kecamatan {{ $kec->nama_kecamatan }} ({{ $kec->kode_kecamatan }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Identitas Pemohon Terdaftar</label>
                        <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-lg text-xs space-y-0.5">
                            <p class="font-bold text-slate-800">{{ $user->name }} (NIK: {{ $user->nik ?? '-' }})</p>
                            <p class="text-slate-500">Email: {{ $user->email }} | HP: {{ $user->phone ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Khusus Pengurangan KK --}}
                @if ($service->kode_layanan === 'KK_DEL')
                    <div class="pt-3 border-t border-slate-100">
                        <label class="block text-xs font-semibold text-slate-700 mb-2">Alasan Pengurangan Anggota Keluarga <span class="text-rose-500">*</span></label>
                        <div class="grid grid-cols-2 gap-3 text-xs">
                            <label class="p-3 rounded-lg border border-slate-200 bg-slate-50 flex items-center gap-2 cursor-pointer hover:border-blue-500">
                                <input type="radio" name="form_data[alasan]" value="meninggal" checked class="text-blue-600">
                                <span class="font-medium text-slate-800">Meninggal Dunia</span>
                            </label>
                            <label class="p-3 rounded-lg border border-slate-200 bg-slate-50 flex items-center gap-2 cursor-pointer hover:border-blue-500">
                                <input type="radio" name="form_data[alasan]" value="cerai" class="text-blue-600">
                                <span class="font-medium text-slate-800">Perceraian</span>
                            </label>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Form Section 2: Upload Persyaratan --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-xs p-6 space-y-5">
                <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                    <h3 class="text-sm font-bold text-slate-900">
                        2. Dokumen Persyaratan
                    </h3>
                    <span class="text-xs text-slate-400">PDF, JPG, PNG (Maks 5 MB)</span>
                </div>

                <div class="space-y-4">
                    @foreach ($service->requirements as $req)
                        <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/60 space-y-2">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <h4 class="text-xs font-bold text-slate-800">{{ $req->nama_persyaratan }}</h4>
                                    @if ($req->is_required)
                                        <span class="px-1.5 py-0.2 rounded text-[10px] font-bold bg-rose-100 text-rose-700">Wajib</span>
                                    @else
                                        <span class="px-1.5 py-0.2 rounded text-[10px] font-semibold bg-slate-200 text-slate-600">Opsional</span>
                                    @endif
                                </div>
                            </div>
                            <p class="text-[11px] text-slate-500">{{ $req->deskripsi }}</p>

                            <input type="file"
                                   name="documents[{{ $req->id }}]"
                                   accept=".pdf,.jpg,.jpeg,.png"
                                   class="block w-full text-xs text-slate-600 file:mr-3 file:py-2 file:px-3.5 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer border border-slate-200 rounded-lg bg-white">
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="flex items-center justify-end gap-3 pt-2">
                <button type="submit" name="submit_now" value="0" class="px-5 py-2.5 rounded-lg font-semibold text-xs text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 transition-colors cursor-pointer">
                    Simpan Draft
                </button>
                <button type="submit" name="submit_now" value="1" class="px-6 py-2.5 rounded-lg font-semibold text-xs text-white bg-blue-700 hover:bg-blue-800 transition-colors shadow-xs cursor-pointer">
                    Ajukan Permohonan &rarr;
                </button>
            </div>
        </form>
    @endif

</div>
@endsection
