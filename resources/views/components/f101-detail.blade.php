@props(['f101', 'submission' => null])

@if ($f101 && is_array($f101))
    <div x-data="{ detailView: 'modern_table' }" class="bg-white rounded-2xl border-2 border-slate-200 shadow-md overflow-hidden space-y-0 font-sans">
        {{-- Header Card --}}
        <div class="bg-gradient-to-r from-blue-900 via-indigo-900 to-slate-900 text-white p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="space-y-1">
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-0.5 rounded-md bg-amber-400 text-slate-950 font-black text-[10px] uppercase tracking-wider">
                        FORMULIR KK BARU
                    </span>
                    <span class="text-xs text-blue-200 font-medium">Permohonan Kartu Keluarga Baru</span>
                </div>
                <h3 class="text-base sm:text-lg font-bold text-white">Data Formulir Pembuatan Kartu Keluarga Baru</h3>
            </div>

            @php
                $printUrl = null;
                if ($submission) {
                    if (auth()->user()?->isAdminDesa()) {
                        $printUrl = route('desa.submissions.print-f101', $submission);
                    } elseif (auth()->user()?->isAdminKecamatan()) {
                        $printUrl = route('kecamatan.submissions.print-f101', $submission);
                    } else {
                        $printUrl = route('warga.submissions.print-f101', $submission);
                    }
                }

                $namaKepalaKeluarga = strtoupper($f101['nama_kepala_keluarga'] ?? $f101['nama_pemohon'] ?? $submission?->user?->name ?? '-');
                $alamat = strtoupper($f101['alamat'] ?? $submission?->user?->alamat_detail ?? '-');
                $rt = str_pad($f101['rt'] ?? '001', 3, '0', STR_PAD_LEFT);
                $rw = str_pad($f101['rw'] ?? '001', 3, '0', STR_PAD_LEFT);
                $kodePos = $f101['kode_pos'] ?? '46182';

                $desa = strtoupper($f101['nama_desa'] ?? $submission?->desa?->nama_desa ?? $submission?->user?->desa?->nama_desa ?? '-');
                $kecamatan = strtoupper($f101['nama_kecamatan'] ?? $submission?->kecamatan?->nama_kecamatan ?? '-');
                $kabupaten = strtoupper($f101['nama_kabupaten'] ?? 'KABUPATEN TASIKMALAYA');
                $provinsi = strtoupper($f101['nama_provinsi'] ?? 'JAWA BARAT');
                $negara = strtoupper($f101['negara'] ?? 'INDONESIA');

                $anggotaList = $f101['anggota'] ?? [];
            @endphp

            @if ($printUrl)
                <a href="{{ $printUrl }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-amber-400 hover:bg-amber-300 text-slate-950 text-xs font-bold transition-all shadow-md">
                    <svg class="w-4 h-4 text-slate-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    <span>Cetak Formulir KK Baru (A4 Landscape) &rarr;</span>
                </a>
            @endif
        </div>

        <div class="p-5 sm:p-6 space-y-6 text-xs">
            {{-- Header Alamat & Wilayah (Grid 4 Kolom) --}}
            <div class="bg-slate-50 p-5 rounded-xl border border-slate-200 space-y-3">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 pb-3 border-b border-slate-200">
                    <div class="md:col-span-2">
                        <span class="block text-slate-500 font-medium">Nama Kepala Keluarga:</span>
                        <span class="font-extrabold text-slate-950 text-sm uppercase">{{ $namaKepalaKeluarga }}</span>
                    </div>
                    <div class="md:col-span-2">
                        <span class="block text-slate-500 font-medium">Alamat Tempat Tinggal:</span>
                        <span class="font-bold text-slate-900 uppercase">{{ $alamat }} (RT {{ $rt }} / RW {{ $rw }})</span>
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-5 gap-3 pt-1">
                    <div>
                        <span class="block text-slate-500 font-medium">Desa / Kelurahan:</span>
                        <span class="font-bold text-slate-900 uppercase">{{ $desa }}</span>
                    </div>
                    <div>
                        <span class="block text-slate-500 font-medium">Kecamatan:</span>
                        <span class="font-bold text-slate-900 uppercase">{{ $kecamatan }}</span>
                    </div>
                    <div>
                        <span class="block text-slate-500 font-medium">Kabupaten/Kota:</span>
                        <span class="font-bold text-slate-900 uppercase">{{ $kabupaten }}</span>
                    </div>
                    <div>
                        <span class="block text-slate-500 font-medium">Provinsi:</span>
                        <span class="font-bold text-slate-900 uppercase">{{ $provinsi }}</span>
                    </div>
                    <div>
                        <span class="block text-slate-500 font-medium">Negara / Pos:</span>
                        <span class="font-bold text-slate-900 uppercase">{{ $negara }} ({{ $kodePos }})</span>
                    </div>
                </div>
            </div>

            {{-- View Switcher Tab --}}
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-200 pb-3">
                <div class="inline-flex p-1 bg-slate-100 rounded-xl border border-slate-200">
                    <button type="button"
                            @click="detailView = 'modern_table'"
                            :class="detailView === 'modern_table' ? 'bg-white text-blue-700 shadow-sm font-bold' : 'text-slate-600 font-medium'"
                            class="flex items-center gap-2 px-4 py-2 rounded-lg text-xs transition-all">
                        <span>📊 Tabel 4-Kolom Modern</span>
                    </button>
                    <button type="button"
                            @click="detailView = 'cards'"
                            :class="detailView === 'cards' ? 'bg-white text-blue-700 shadow-sm font-bold' : 'text-slate-600 font-medium'"
                            class="flex items-center gap-2 px-4 py-2 rounded-lg text-xs transition-all">
                        <span>🗂️ Kartu Anggota ({{ count($anggotaList) }})</span>
                    </button>
                    <button type="button"
                            @click="detailView = 'official_table'"
                            :class="detailView === 'official_table' ? 'bg-white text-blue-700 shadow-sm font-bold' : 'text-slate-600 font-medium'"
                            class="flex items-center gap-2 px-4 py-2 rounded-lg text-xs transition-all">
                        <span>📑 Format Cetak Resmi 10 Baris</span>
                    </button>
                </div>
                <span class="text-xs text-slate-600 font-bold">Total Terdaftar: {{ count($anggotaList) }} Anggota</span>
            </div>

            {{-- VIEW 1: TABEL MODERN 4-KOLOM (USER FRIENDLY) --}}
            <div x-show="detailView === 'modern_table'" class="border border-slate-200 rounded-xl overflow-hidden shadow-2xs">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-slate-100 text-slate-700 border-b border-slate-200 font-bold uppercase text-[11px]">
                                <th class="py-3 px-3 w-12 text-center">No</th>
                                <th class="py-3 px-4 min-w-[200px]">Kolom 1: Identitas Pokok</th>
                                <th class="py-3 px-4 min-w-[200px]">Kolom 2: Kelahiran & Hubungan</th>
                                <th class="py-3 px-4 min-w-[190px]">Kolom 3: Pendidikan & Pekerjaan</th>
                                <th class="py-3 px-4 min-w-[200px]">Kolom 4: Orang Tua & Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 bg-white">
                            @forelse ($anggotaList as $idx => $ang)
                                @php
                                    $shdk = strtoupper($ang['shdk'] ?? '-');
                                    $badgeClass = match($shdk) {
                                        'KEPALA KELUARGA' => 'bg-blue-600 text-white',
                                        'ISTRI', 'SUAMI' => 'bg-purple-600 text-white',
                                        'ANAK' => 'bg-emerald-600 text-white',
                                        default => 'bg-amber-600 text-white'
                                    };
                                @endphp
                                <tr class="hover:bg-blue-50/40 transition-colors">
                                    <td class="py-3 px-3 text-center font-bold text-slate-500">{{ $idx + 1 }}</td>
                                    <td class="py-3 px-4">
                                        <div class="font-extrabold text-slate-900 uppercase text-xs">{{ $ang['nama'] ?? '-' }}</div>
                                        <div class="font-mono text-[11px] font-bold text-blue-700 mt-0.5">{{ $ang['nik'] ?? '-' }}</div>
                                        <div class="flex items-center gap-2 mt-1 text-[11px] text-slate-500">
                                            <span class="px-1.5 py-0.5 rounded bg-slate-100 font-medium">{{ $ang['jenis_kelamin'] ?? '-' }}</span>
                                            <span>Gol: <strong class="text-slate-800">{{ $ang['gol_darah'] ?? '-' }}</strong></span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="font-semibold text-slate-800">
                                            {{ $ang['tempat_lahir'] ?? '-' }}, {{ !empty($ang['tanggal_lahir']) ? date('d-m-Y', strtotime($ang['tanggal_lahir'])) : '-' }}
                                        </div>
                                        <div class="flex items-center gap-1.5 mt-1">
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase {{ $badgeClass }}">{{ $shdk }}</span>
                                            <span class="text-[11px] text-slate-500">({{ $ang['agama'] ?? '-' }})</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="font-bold text-slate-800">{{ $ang['pekerjaan'] ?? '-' }}</div>
                                        <div class="text-[11px] text-slate-600">{{ $ang['pendidikan'] ?? '-' }}</div>
                                        <div class="text-[11px] text-slate-500 mt-1">
                                            Status: <strong class="text-slate-700">{{ $ang['status_kawin'] ?? '-' }}</strong>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="text-[11px] text-slate-700">
                                            Ayah: <strong class="text-slate-900 uppercase">{{ $ang['nama_ayah'] ?? '-' }}</strong>
                                        </div>
                                        <div class="text-[11px] text-slate-700 mt-0.5">
                                            Ibu: <strong class="text-slate-900 uppercase">{{ $ang['nama_ibu'] ?? '-' }}</strong>
                                        </div>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="px-1.5 py-0.5 rounded text-[10px] font-bold bg-blue-100 text-blue-800">{{ $ang['kewarganegaraan'] ?? 'WNI' }}</span>
                                            @if (!empty($ang['no_paspor']))
                                                <span class="font-mono text-[10px] text-slate-500">Paspor: {{ $ang['no_paspor'] }}</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-6 text-center text-slate-400">Belum ada anggota keluarga.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- VIEW 2: KARTU ANGGOTA KELUARGA --}}
            <div x-show="detailView === 'cards'" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse ($anggotaList as $idx => $ang)
                    @php
                        $shdk = strtoupper($ang['shdk'] ?? '-');
                        $badgeClass = match($shdk) {
                            'KEPALA KELUARGA' => 'bg-blue-600 text-white',
                            'ISTRI', 'SUAMI' => 'bg-purple-600 text-white',
                            'ANAK' => 'bg-emerald-600 text-white',
                            default => 'bg-amber-600 text-white'
                        };
                        $isMale = strtoupper($ang['jenis_kelamin'] ?? '') === 'LAKI-LAKI';
                    @endphp
                    <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-xs space-y-3">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center font-bold text-base {{ $isMale ? 'bg-blue-100 text-blue-700' : 'bg-rose-100 text-rose-700' }}">
                                    {{ $isMale ? '👨' : '👩' }}
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-[10px] font-bold font-mono px-2 py-0.5 rounded bg-slate-100 text-slate-600">#{{ $idx + 1 }}</span>
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase {{ $badgeClass }}">{{ $shdk }}</span>
                                    </div>
                                    <h4 class="font-extrabold text-slate-900 text-sm mt-0.5 uppercase">{{ $ang['nama'] ?? '-' }}</h4>
                                    <span class="font-mono text-xs text-blue-800 font-bold">{{ $ang['nik'] ?? '-' }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-2 text-[11px] pt-2 border-t border-slate-100">
                            <div class="bg-slate-50 p-2 rounded-lg">
                                <span class="block text-[10px] text-slate-400 font-medium">Kelahiran</span>
                                <span class="font-bold text-slate-800">{{ $ang['tempat_lahir'] ?? '-' }}, {{ !empty($ang['tanggal_lahir']) ? date('d-m-Y', strtotime($ang['tanggal_lahir'])) : '-' }}</span>
                            </div>
                            <div class="bg-slate-50 p-2 rounded-lg">
                                <span class="block text-[10px] text-slate-400 font-medium">Agama / Gol. Darah</span>
                                <span class="font-bold text-slate-800">{{ $ang['agama'] ?? '-' }} / {{ $ang['gol_darah'] ?? '-' }}</span>
                            </div>
                            <div class="bg-slate-50 p-2 rounded-lg">
                                <span class="block text-[10px] text-slate-400 font-medium">Pendidikan</span>
                                <span class="font-bold text-slate-800">{{ $ang['pendidikan'] ?? '-' }}</span>
                            </div>
                            <div class="bg-slate-50 p-2 rounded-lg">
                                <span class="block text-[10px] text-slate-400 font-medium">Pekerjaan</span>
                                <span class="font-bold text-slate-800">{{ $ang['pekerjaan'] ?? '-' }}</span>
                            </div>
                            <div class="col-span-2 bg-slate-50 p-2 rounded-lg flex items-center justify-between">
                                <div>
                                    <span class="block text-[10px] text-slate-400 font-medium">Orang Tua Kandung</span>
                                    <span class="font-bold text-slate-800">
                                        Ayah: {{ $ang['nama_ayah'] ?? '-' }} | Ibu: {{ $ang['nama_ibu'] ?? '-' }}
                                    </span>
                                </div>
                                <span class="px-2 py-0.5 rounded bg-blue-100 text-blue-800 text-[10px] font-bold">{{ $ang['kewarganegaraan'] ?? 'WNI' }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-2 p-8 text-center text-slate-400">
                        Belum ada anggota keluarga terdaftar.
                    </div>
                @endforelse
            </div>

            {{-- VIEW 3: FORMAT RESMI 10 BARIS --}}
            <div x-show="detailView === 'official_table'" class="space-y-6">
                {{-- TABEL 1 (KOLOM 1 - 9) --}}
                <div class="space-y-1">
                    <h5 class="text-xs font-bold text-slate-700 uppercase tracking-wide">
                        Tabel I: Biodata Diri Anggota Keluarga (Kolom 1 - 9)
                    </h5>
                    <div class="border-2 border-slate-900 rounded-none overflow-x-auto">
                        <table class="w-full text-left border-collapse text-[11px] font-sans">
                            <thead>
                                <tr class="bg-white text-slate-950 font-bold border-b-2 border-slate-900 divide-x-2 divide-slate-900 text-center">
                                    <th class="py-2 px-2 w-10">No</th>
                                    <th class="py-2 px-3 min-w-[160px]">Nama Lengkap</th>
                                    <th class="py-2 px-2 min-w-[130px]">NIK</th>
                                    <th class="py-2 px-2 min-w-[90px]">Jenis Kelamin</th>
                                    <th class="py-2 px-2 min-w-[110px]">Tempat Lahir</th>
                                    <th class="py-2 px-2 min-w-[90px]">Tanggal Lahir</th>
                                    <th class="py-2 px-2 min-w-[80px]">Agama</th>
                                    <th class="py-2 px-2 min-w-[120px]">Pendidikan</th>
                                    <th class="py-2 px-2 min-w-[120px]">Jenis Pekerjaan</th>
                                    <th class="py-2 px-2 min-w-[60px]">Golongan Darah</th>
                                </tr>
                                <tr class="bg-slate-200/90 text-slate-900 font-bold border-b-2 border-slate-900 divide-x-2 divide-slate-900 text-center text-[10px]">
                                    <td class="py-1"></td>
                                    <td class="py-1">(1)</td>
                                    <td class="py-1">(2)</td>
                                    <td class="py-1">(3)</td>
                                    <td class="py-1">(4)</td>
                                    <td class="py-1">(5)</td>
                                    <td class="py-1">(6)</td>
                                    <td class="py-1">(7)</td>
                                    <td class="py-1">(8)</td>
                                    <td class="py-1">(9)</td>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-900">
                                @for ($i = 1; $i <= 10; $i++)
                                    @php
                                        $ang = $anggotaList[$i - 1] ?? null;
                                    @endphp
                                    <tr class="divide-x-2 divide-slate-900 hover:bg-slate-50 transition-colors h-7 text-[11px]">
                                        <td class="py-1 px-2 text-center font-bold text-slate-800">{{ $i }}</td>
                                        <td class="py-1 px-3 uppercase font-semibold text-slate-900">{{ $ang['nama'] ?? '-' }}</td>
                                        <td class="py-1 px-2 font-mono font-bold text-blue-900 text-center">{{ $ang['nik'] ?? '-' }}</td>
                                        <td class="py-1 px-2 text-center uppercase">{{ $ang['jenis_kelamin'] ?? '-' }}</td>
                                        <td class="py-1 px-2 uppercase">{{ $ang['tempat_lahir'] ?? '-' }}</td>
                                        <td class="py-1 px-2 text-center">
                                            @if (!empty($ang['tanggal_lahir']) && $ang['tanggal_lahir'] !== '-')
                                                {{ date('d-m-Y', strtotime($ang['tanggal_lahir'])) }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="py-1 px-2 text-center uppercase">{{ $ang['agama'] ?? '-' }}</td>
                                        <td class="py-1 px-2 uppercase">{{ $ang['pendidikan'] ?? '-' }}</td>
                                        <td class="py-1 px-2 uppercase">{{ $ang['pekerjaan'] ?? '-' }}</td>
                                        <td class="py-1 px-2 text-center font-bold">{{ $ang['gol_darah'] ?? '-' }}</td>
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- TABEL 2 (KOLOM 10 - 17) --}}
                <div class="space-y-1 pt-2">
                    <h5 class="text-xs font-bold text-slate-700 uppercase tracking-wide">
                        Tabel II: Status Perkawinan, Imigrasi & Nama Orang Tua (Kolom 10 - 17)
                    </h5>
                    <div class="border-2 border-slate-900 rounded-none overflow-x-auto">
                        <table class="w-full text-left border-collapse text-[11px] font-sans">
                            <thead>
                                <tr class="bg-white text-slate-950 font-bold border-b-2 border-slate-900 divide-x-2 divide-slate-900 text-center">
                                    <th class="py-2 px-2 w-10" rowspan="2">No</th>
                                    <th class="py-2 px-2 min-w-[120px]" rowspan="2">Status Perkawinan</th>
                                    <th class="py-2 px-2 min-w-[110px]" rowspan="2">Tanggal Perkawinan</th>
                                    <th class="py-2 px-2 min-w-[140px]" rowspan="2">Status Hubungan Dalam Keluarga</th>
                                    <th class="py-2 px-2 min-w-[90px]" rowspan="2">Kewarganegaraan</th>
                                    <th class="py-1 px-2" colspan="2">Dokumen Imigrasi</th>
                                    <th class="py-1 px-2" colspan="2">Nama Orang Tua</th>
                                </tr>
                                <tr class="bg-white text-slate-950 font-bold border-b-2 border-slate-900 divide-x-2 divide-slate-900 text-center text-[10px]">
                                    <th class="py-1.5 px-2 min-w-[100px]">No. Paspor</th>
                                    <th class="py-1.5 px-2 min-w-[100px]">No. KITAP</th>
                                    <th class="py-1.5 px-3 min-w-[150px]">Ayah</th>
                                    <th class="py-1.5 px-3 min-w-[150px]">Ibu</th>
                                </tr>
                                <tr class="bg-slate-200/90 text-slate-900 font-bold border-b-2 border-slate-900 divide-x-2 divide-slate-900 text-center text-[10px]">
                                    <td class="py-1"></td>
                                    <td class="py-1">(10)</td>
                                    <td class="py-1">(11)</td>
                                    <td class="py-1">(12)</td>
                                    <td class="py-1">(13)</td>
                                    <td class="py-1">(14)</td>
                                    <td class="py-1">(15)</td>
                                    <td class="py-1">(16)</td>
                                    <td class="py-1">(17)</td>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-900">
                                @for ($i = 1; $i <= 10; $i++)
                                    @php
                                        $ang = $anggotaList[$i - 1] ?? null;
                                    @endphp
                                    <tr class="divide-x-2 divide-slate-900 hover:bg-slate-50 transition-colors h-7 text-[11px]">
                                        <td class="py-1 px-2 text-center font-bold text-slate-800">{{ $i }}</td>
                                        <td class="py-1 px-2 uppercase">{{ $ang['status_kawin'] ?? '-' }}</td>
                                        <td class="py-1 px-2 text-center">
                                            @if (!empty($ang['tgl_kawin']) && $ang['tgl_kawin'] !== '-')
                                                {{ date('d-m-Y', strtotime($ang['tgl_kawin'])) }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="py-1 px-2 uppercase font-semibold text-blue-900">{{ $ang['shdk'] ?? '-' }}</td>
                                        <td class="py-1 px-2 text-center font-bold">{{ $ang['kewarganegaraan'] ?? '-' }}</td>
                                        <td class="py-1 px-2 font-mono text-center">{{ !empty($ang['no_paspor']) ? $ang['no_paspor'] : '-' }}</td>
                                        <td class="py-1 px-2 font-mono text-center">{{ !empty($ang['no_kitap']) ? $ang['no_kitap'] : '-' }}</td>
                                        <td class="py-1 px-3 uppercase font-medium">{{ $ang['nama_ayah'] ?? '-' }}</td>
                                        <td class="py-1 px-3 uppercase font-medium">{{ $ang['nama_ibu'] ?? '-' }}</td>
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
