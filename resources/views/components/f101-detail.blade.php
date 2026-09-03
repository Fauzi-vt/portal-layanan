@props(['f101', 'submission' => null])

@if ($f101 && is_array($f101))
    <div class="bg-white rounded-2xl border-2 border-blue-200 shadow-sm overflow-hidden space-y-0">
        {{-- Header --}}
        <div class="bg-gradient-to-r from-[#0a2558] to-[#1e5799] text-white p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="space-y-1">
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-0.5 rounded-md bg-amber-400 text-slate-900 font-extrabold text-[10px] uppercase">
                        FORMULIR F-1.01
                    </span>
                    <span class="text-xs text-blue-200">Data Biodata Keluarga Terverifikasi</span>
                </div>
                <h3 class="text-lg font-bold text-white">Formulir Biodata Keluarga Pemohon</h3>
            </div>

            @php
                $printUrl = null;
                if ($submission) {
                    $printUrl = auth()->user()?->isAdminKecamatan()
                        ? route('kecamatan.submissions.print-f101', $submission)
                        : route('warga.submissions.print-f101', $submission);
                }
            @endphp

            @if ($printUrl)
                <a href="{{ $printUrl }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white text-[#0a2558] hover:bg-blue-50 text-xs font-bold transition-all shadow-md">
                    <i data-lucide="printer" class="w-4 h-4 text-[#0a2558]"></i>
                    <span>Cetak Formulir F-1.01 Resmi &rarr;</span>
                </a>
            @else
                <button type="button" onclick="window.print()" class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-white/15 hover:bg-white/25 text-white text-xs font-bold border border-white/20 transition-colors shadow-xs">
                    <i data-lucide="printer" class="w-4 h-4"></i>
                    <span>Cetak F-1.01</span>
                </button>
            @endif
        </div>

        <div class="p-5 sm:p-6 space-y-6 text-xs">
            {{-- Bagian Kepala Keluarga & Wilayah --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-slate-50 p-4 rounded-xl border border-slate-200">
                <div class="space-y-2">
                    <h4 class="font-bold text-slate-800 text-sm border-b border-slate-200 pb-1.5 flex items-center gap-2">
                        <i data-lucide="user-check" class="w-4 h-4 text-blue-700"></i>
                        <span>Data Kepala Keluarga</span>
                    </h4>
                    <div class="grid grid-cols-3 gap-1">
                        <span class="text-slate-500 font-medium">Nama Kepala:</span>
                        <span class="col-span-2 font-bold text-slate-900">{{ $f101['nama_kepala_keluarga'] ?? '-' }}</span>
                    </div>
                    <div class="grid grid-cols-3 gap-1">
                        <span class="text-slate-500 font-medium">NIK:</span>
                        <span class="col-span-2 font-mono font-bold text-blue-700">{{ $f101['nik_kepala_keluarga'] ?? '-' }}</span>
                    </div>
                    <div class="grid grid-cols-3 gap-1">
                        <span class="text-slate-500 font-medium">Alamat:</span>
                        <span class="col-span-2 font-medium text-slate-800">{{ $f101['alamat'] ?? '-' }} (RT {{ $f101['rt'] ?? '00' }} / RW {{ $f101['rw'] ?? '00' }})</span>
                    </div>
                    <div class="grid grid-cols-3 gap-1">
                        <span class="text-slate-500 font-medium">Kode Pos:</span>
                        <span class="col-span-2 font-mono text-slate-800">{{ $f101['kode_pos'] ?? '-' }}</span>
                    </div>
                    <div class="grid grid-cols-3 gap-1">
                        <span class="text-slate-500 font-medium">Kontak/HP:</span>
                        <span class="col-span-2 font-medium text-slate-800">{{ $f101['telepon'] ?? '-' }} ({{ $f101['email'] ?? '-' }})</span>
                    </div>
                </div>

                <div class="space-y-2">
                    <h4 class="font-bold text-slate-800 text-sm border-b border-slate-200 pb-1.5 flex items-center gap-2">
                        <i data-lucide="map-pin" class="w-4 h-4 text-blue-700"></i>
                        <span>Data Wilayah Administrasi</span>
                    </h4>
                    <div class="grid grid-cols-3 gap-1">
                        <span class="text-slate-500 font-medium">Provinsi:</span>
                        <span class="col-span-2 font-semibold text-slate-900">{{ $f101['nama_provinsi'] ?? '32 - JAWA BARAT' }}</span>
                    </div>
                    <div class="grid grid-cols-3 gap-1">
                        <span class="text-slate-500 font-medium">Kabupaten:</span>
                        <span class="col-span-2 font-semibold text-slate-900">{{ $f101['nama_kabupaten'] ?? '06 - KAB. TASIKMALAYA' }}</span>
                    </div>
                    <div class="grid grid-cols-3 gap-1">
                        <span class="text-slate-500 font-medium">Kecamatan:</span>
                        <span class="col-span-2 font-semibold text-slate-900">{{ $f101['nama_kecamatan'] ?? '-' }}</span>
                    </div>
                    <div class="grid grid-cols-3 gap-1">
                        <span class="text-slate-500 font-medium">Desa/Kel:</span>
                        <span class="col-span-2 font-semibold text-slate-900">{{ $f101['nama_desa'] ?? '-' }}</span>
                    </div>
                    <div class="grid grid-cols-3 gap-1">
                        <span class="text-slate-500 font-medium">Dusun/Kp:</span>
                        <span class="col-span-2 font-semibold text-slate-900">{{ $f101['nama_dusun'] ?? '-' }}</span>
                    </div>
                </div>
            </div>

            {{-- Tabel Anggota Keluarga --}}
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <h4 class="font-bold text-slate-800 text-sm flex items-center gap-2">
                        <i data-lucide="users" class="w-4 h-4 text-blue-700"></i>
                        <span>Daftar Anggota Keluarga ({{ count($f101['anggota'] ?? []) }} Jiwa)</span>
                    </h4>
                </div>

                <div class="overflow-x-auto border border-slate-200 rounded-xl">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-slate-100 text-slate-700 font-bold border-b border-slate-200">
                                <th class="py-2.5 px-3">No</th>
                                <th class="py-2.5 px-3">Nama Lengkap</th>
                                <th class="py-2.5 px-3">NIK</th>
                                <th class="py-2.5 px-3">JK</th>
                                <th class="py-2.5 px-3">Tempat, Tgl Lahir</th>
                                <th class="py-2.5 px-3">SHDK</th>
                                <th class="py-2.5 px-3">Agama</th>
                                <th class="py-2.5 px-3">Pekerjaan</th>
                                <th class="py-2.5 px-3">Status Kawin</th>
                                <th class="py-2.5 px-3">Nama Orang Tua</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-800">
                            @foreach ($f101['anggota'] ?? [] as $idx => $ang)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="py-2.5 px-3 font-bold text-slate-500">{{ $loop->iteration }}</td>
                                    <td class="py-2.5 px-3 font-bold text-slate-900">{{ $ang['nama'] ?? '-' }}</td>
                                    <td class="py-2.5 px-3 font-mono font-bold text-blue-700">{{ $ang['nik'] ?? '-' }}</td>
                                    <td class="py-2.5 px-3">{{ ($ang['jenis_kelamin'] ?? '') === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                    <td class="py-2.5 px-3">{{ $ang['tempat_lahir'] ?? '-' }}, {{ $ang['tanggal_lahir'] ?? '-' }}</td>
                                    <td class="py-2.5 px-3 font-semibold text-indigo-700">{{ $ang['shdk'] ?? '-' }}</td>
                                    <td class="py-2.5 px-3">{{ $ang['agama'] ?? '-' }}</td>
                                    <td class="py-2.5 px-3">{{ $ang['pekerjaan'] ?? '-' }}</td>
                                    <td class="py-2.5 px-3">{{ $ang['status_kawin'] ?? '-' }}</td>
                                    <td class="py-2.5 px-3 text-[11px] text-slate-600">
                                        <div>Ibu: {{ $ang['nama_ibu'] ?? '-' }}</div>
                                        <div>Ayah: {{ $ang['nama_ayah'] ?? '-' }}</div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endif
