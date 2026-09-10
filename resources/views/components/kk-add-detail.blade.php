@props(['kkAdd', 'submission' => null])

@if ($kkAdd && is_array($kkAdd))
    @php
        $namaKepalaKeluarga = strtoupper($kkAdd['nama_kepala_keluarga'] ?? $kkAdd['nama_pemohon'] ?? $submission?->user?->name ?? '-');
        $noKk = $kkAdd['no_kk'] ?? '-';
        $alasan = $kkAdd['alasan_penambahan'] ?? 'KELAHIRAN';
        $noAkta = $kkAdd['no_akta_lahir'] ?? '-';
        $alamat = strtoupper($kkAdd['alamat'] ?? $submission?->user?->alamat_detail ?? '-');
        $rt = str_pad($kkAdd['rt'] ?? '001', 3, '0', STR_PAD_LEFT);
        $rw = str_pad($kkAdd['rw'] ?? '001', 3, '0', STR_PAD_LEFT);
        $kodePos = $kkAdd['kode_pos'] ?? '46182';

        $desa = strtoupper($kkAdd['nama_desa'] ?? $submission?->desa?->nama_desa ?? $submission?->user?->desa?->nama_desa ?? '-');
        $kecamatan = strtoupper($kkAdd['nama_kecamatan'] ?? $submission?->kecamatan?->nama_kecamatan ?? '-');
        $kabupaten = strtoupper($kkAdd['kabupaten'] ?? 'KABUPATEN TASIKMALAYA');
        $provinsi = strtoupper($kkAdd['provinsi'] ?? 'JAWA BARAT');

        $anggotaList = $kkAdd['anggota'] ?? [];
    @endphp

    <div class="bg-white rounded-2xl border-2 border-emerald-200 shadow-md overflow-hidden space-y-0 font-sans">
        {{-- Header Card --}}
        <div class="bg-gradient-to-r from-emerald-950 via-teal-900 to-slate-900 text-white p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="space-y-1">
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-0.5 rounded-md bg-emerald-400 text-emerald-950 font-black text-[10px] uppercase tracking-wider">
                        PENAMBAHAN ANGGOTA KK
                    </span>
                    <span class="text-xs text-emerald-200 font-medium">Formulir Digital Kartu Keluarga</span>
                </div>
                <h3 class="text-base sm:text-lg font-bold text-white">Data Formulir Penambahan Anggota Keluarga</h3>
            </div>

            <div class="px-4 py-2 rounded-xl bg-white/10 border border-white/15 text-xs">
                <span class="text-emerald-200 block text-[10px] uppercase font-semibold">Total Anggota Ditambahkan:</span>
                <span class="font-bold text-white text-sm">{{ count($anggotaList) }} Orang</span>
            </div>
        </div>

        <div class="p-5 sm:p-6 space-y-6 text-xs">
            {{-- Data KK Eksisting & Wilayah --}}
            <div class="bg-slate-50 p-5 rounded-xl border border-slate-200 space-y-3">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 pb-3 border-b border-slate-200">
                    <div>
                        <span class="block text-slate-500 font-medium">Nomor Kartu Keluarga (KK):</span>
                        <span class="font-mono font-extrabold text-emerald-900 text-sm">{{ $noKk }}</span>
                    </div>
                    <div>
                        <span class="block text-slate-500 font-medium">Dasar / Alasan Penambahan:</span>
                        <span class="font-bold text-slate-900 uppercase">{{ str_replace('_', ' ', $alasan) }}</span>
                    </div>
                    <div class="md:col-span-2">
                        <span class="block text-slate-500 font-medium">No. Akta / Ket. Kelahiran:</span>
                        <span class="font-medium text-slate-800">{{ $noAkta ?: '-' }}</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 pb-3 border-b border-slate-200">
                    <div class="md:col-span-2">
                        <span class="block text-slate-500 font-medium">Nama Kepala Keluarga:</span>
                        <span class="font-extrabold text-slate-950 text-sm uppercase">{{ $namaKepalaKeluarga }}</span>
                    </div>
                    <div class="md:col-span-2">
                        <span class="block text-slate-500 font-medium">Alamat Rumah (Jalan / Dusun):</span>
                        <span class="font-bold text-slate-900 uppercase">{{ $alamat }}</span>
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-slate-700">
                    <div>
                        <span class="block text-slate-500 font-medium">RT / RW:</span>
                        <span class="font-mono font-bold">{{ $rt }} / {{ $rw }}</span>
                    </div>
                    <div>
                        <span class="block text-slate-500 font-medium">Kode Pos:</span>
                        <span class="font-mono font-bold">{{ $kodePos }}</span>
                    </div>
                    <div>
                        <span class="block text-slate-500 font-medium">Desa / Kelurahan:</span>
                        <span class="font-bold uppercase">{{ $desa }}</span>
                    </div>
                    <div>
                        <span class="block text-slate-500 font-medium">Kecamatan:</span>
                        <span class="font-bold uppercase">{{ $kecamatan }}</span>
                    </div>
                </div>
            </div>

            {{-- Tabel Anggota yang Ditambahkan --}}
            <div class="space-y-3">
                <h4 class="text-xs font-black uppercase tracking-wider text-slate-800 flex items-center gap-2">
                    <span>👶</span>
                    <span>Daftar Anggota Keluarga Baru yang Dimasukkan ke KK</span>
                </h4>

                <div class="overflow-x-auto rounded-xl border border-slate-200">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead class="bg-slate-100 text-slate-700 font-bold uppercase text-[10px]">
                            <tr>
                                <th class="py-2.5 px-3 text-center w-10">No</th>
                                <th class="py-2.5 px-3">Nama Lengkap</th>
                                <th class="py-2.5 px-3">NIK</th>
                                <th class="py-2.5 px-2 text-center">JK</th>
                                <th class="py-2.5 px-3">Hubungan (SHDK)</th>
                                <th class="py-2.5 px-3">Tempat & Tanggal Lahir</th>
                                <th class="py-2.5 px-3">Nama Orang Tua</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 bg-white">
                            @forelse ($anggotaList as $idx => $m)
                                <tr class="hover:bg-emerald-50/30">
                                    <td class="py-2.5 px-3 text-center font-bold text-slate-500">{{ $idx + 1 }}</td>
                                    <td class="py-2.5 px-3 font-bold text-slate-900">
                                        {{ $m['nama'] ?? '-' }}
                                        @if (!empty($m['is_bayi']) && $m['is_bayi'] == '1')
                                            <span class="ml-1 px-1.5 py-0.2 rounded text-[9px] font-bold bg-emerald-100 text-emerald-800">Bayi Baru Lahir</span>
                                        @endif
                                    </td>
                                    <td class="py-2.5 px-3 font-mono font-semibold text-slate-800">{{ $m['nik'] ?: '-' }}</td>
                                    <td class="py-2.5 px-2 text-center">
                                        <span class="px-1.5 py-0.5 rounded text-[10px] font-bold {{ ($m['jenis_kelamin'] ?? '') === 'LAKI-LAKI' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                            {{ ($m['jenis_kelamin'] ?? '') === 'LAKI-LAKI' ? 'L' : 'P' }}
                                        </span>
                                    </td>
                                    <td class="py-2.5 px-3 font-bold text-emerald-800">{{ $m['shdk'] ?? '-' }}</td>
                                    <td class="py-2.5 px-3 text-slate-700">
                                        {{ $m['tempat_lahir'] ?? '-' }},
                                        {{ !empty($m['tanggal_lahir']) ? date('d-m-Y', strtotime($m['tanggal_lahir'])) : '-' }}
                                    </td>
                                    <td class="py-2.5 px-3 text-[11px] text-slate-600">
                                        <p>Ayah: <span class="font-semibold text-slate-800">{{ $m['nama_ayah'] ?? '-' }}</span></p>
                                        <p>Ibu: <span class="font-semibold text-slate-800">{{ $m['nama_ibu'] ?? '-' }}</span></p>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-4 text-center text-slate-400">Tidak ada rincian anggota keluarga.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endif
