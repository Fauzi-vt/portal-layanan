@props(['kkDel', 'submission' => null])

@if ($kkDel && is_array($kkDel))
    @php
        $namaKepalaKeluarga = strtoupper($kkDel['nama_kepala_keluarga'] ?? $kkDel['nama_pemohon'] ?? $submission?->user?->name ?? '-');
        $noKk = $kkDel['no_kk'] ?? '-';
        $alasan = $kkDel['alasan_pengurangan'] ?? 'MENINGGAL';
        $tglPeristiwa = $kkDel['tanggal_peristiwa'] ?? '-';
        $noDokumen = $kkDel['no_dokumen_bukti'] ?? '-';
        $alamat = strtoupper($kkDel['alamat'] ?? $submission?->user?->alamat_detail ?? '-');
        $rt = str_pad($kkDel['rt'] ?? '001', 3, '0', STR_PAD_LEFT);
        $rw = str_pad($kkDel['rw'] ?? '001', 3, '0', STR_PAD_LEFT);
        $kodePos = $kkDel['kode_pos'] ?? '46182';

        $desa = strtoupper($kkDel['nama_desa'] ?? $submission?->desa?->nama_desa ?? $submission?->user?->desa?->nama_desa ?? '-');
        $kecamatan = strtoupper($kkDel['nama_kecamatan'] ?? $submission?->kecamatan?->nama_kecamatan ?? '-');
        $kabupaten = strtoupper($kkDel['kabupaten'] ?? 'KABUPATEN TASIKMALAYA');
        $provinsi = strtoupper($kkDel['provinsi'] ?? 'JAWA BARAT');

        $anggotaList = $kkDel['anggota'] ?? [];
    @endphp

    <div class="bg-white rounded-2xl border-2 border-rose-200 shadow-md overflow-hidden space-y-0 font-sans">
        {{-- Header Card --}}
        <div class="bg-gradient-to-r from-rose-950 via-slate-900 to-indigo-950 text-white p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="space-y-1">
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-0.5 rounded-md bg-rose-400 text-rose-950 font-black text-[10px] uppercase tracking-wider">
                        PENGURANGAN ANGGOTA KK
                    </span>
                    <span class="text-xs text-rose-200 font-medium">Formulir Digital Kartu Keluarga</span>
                </div>
                <h3 class="text-base sm:text-lg font-bold text-white">Data Formulir Pengurangan Anggota Keluarga</h3>
            </div>

            <div class="px-4 py-2 rounded-xl bg-white/10 border border-white/15 text-xs">
                <span class="text-rose-200 block text-[10px] uppercase font-semibold">Total Anggota Dikeluarkan:</span>
                <span class="font-bold text-white text-sm">{{ count($anggotaList) }} Orang</span>
            </div>
        </div>

        <div class="p-5 sm:p-6 space-y-6 text-xs">
            {{-- Data KK Eksisting & Wilayah --}}
            <div class="bg-slate-50 p-5 rounded-xl border border-slate-200 space-y-3">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 pb-3 border-b border-slate-200">
                    <div>
                        <span class="block text-slate-500 font-medium">Nomor Kartu Keluarga (KK):</span>
                        <span class="font-mono font-extrabold text-rose-900 text-sm">{{ $noKk }}</span>
                    </div>
                    <div>
                        <span class="block text-slate-500 font-medium">Alasan Pengurangan:</span>
                        <span class="font-bold text-slate-900 uppercase">{{ str_replace('_', ' ', $alasan) }}</span>
                    </div>
                    <div>
                        <span class="block text-slate-500 font-medium">Tanggal Peristiwa:</span>
                        <span class="font-bold text-slate-800">{{ $tglPeristiwa !== '-' ? date('d-m-Y', strtotime($tglPeristiwa)) : '-' }}</span>
                    </div>
                    <div>
                        <span class="block text-slate-500 font-medium">No. Dokumen Bukti:</span>
                        <span class="font-medium text-slate-800 font-mono">{{ $noDokumen ?: '-' }}</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 pb-3 border-b border-slate-200">
                    <div class="md:col-span-2">
                        <span class="block text-slate-500 font-medium">Nama Kepala Keluarga (Tercatat / Baru):</span>
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

            {{-- Tabel Anggota yang Dikeluarkan --}}
            <div class="space-y-3">
                <h4 class="text-xs font-black uppercase tracking-wider text-slate-800 flex items-center gap-2">
                    <span>📋</span>
                    <span>Daftar Anggota Keluarga yang Dikeluarkan dari KK</span>
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
                                <th class="py-2.5 px-3">Alasan Pengurangan</th>
                                <th class="py-2.5 px-3">Tanggal Kejadian</th>
                                <th class="py-2.5 px-3">Dokumen Bukti</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 bg-white">
                            @forelse ($anggotaList as $idx => $m)
                                <tr class="hover:bg-rose-50/30">
                                    <td class="py-2.5 px-3 text-center font-bold text-slate-500">{{ $idx + 1 }}</td>
                                    <td class="py-2.5 px-3 font-bold text-slate-900">{{ $m['nama'] ?? '-' }}</td>
                                    <td class="py-2.5 px-3 font-mono font-bold text-slate-800">{{ $m['nik'] ?: '-' }}</td>
                                    <td class="py-2.5 px-2 text-center">
                                        <span class="px-1.5 py-0.5 rounded text-[10px] font-bold {{ ($m['jenis_kelamin'] ?? '') === 'LAKI-LAKI' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                            {{ ($m['jenis_kelamin'] ?? '') === 'LAKI-LAKI' ? 'L' : 'P' }}
                                        </span>
                                    </td>
                                    <td class="py-2.5 px-3 font-semibold text-slate-700">{{ $m['shdk'] ?? '-' }}</td>
                                    <td class="py-2.5 px-3 font-semibold uppercase text-rose-800">{{ str_replace('_', ' ', $m['alasan'] ?? $alasan) }}</td>
                                    <td class="py-2.5 px-3 text-slate-700">
                                        {{ !empty($m['tanggal_kejadian']) ? date('d-m-Y', strtotime($m['tanggal_kejadian'])) : '-' }}
                                    </td>
                                    <td class="py-2.5 px-3 font-mono text-[11px] text-slate-600">{{ $m['no_dokumen'] ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="py-4 text-center text-slate-400">Tidak ada rincian anggota keluarga yang dikeluarkan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endif
