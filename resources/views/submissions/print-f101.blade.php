<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pembuatan Kartu Keluarga Baru — {{ $submission->nomor_tiket }}</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 8mm 10mm 8mm 10mm;
        }

        * {
            box-sizing: border-box;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 8.5pt;
            color: #000;
            line-height: 1.25;
            margin: 0;
            padding: 0;
            background: #fff;
        }

        .page-sheet {
            width: 100%;
            max-width: 280mm;
            margin: 0 auto;
            background: #fff;
            position: relative;
        }

        /* ── Action Bar Layar ── */
        .no-print {
            background: #0f172a;
            color: #fff;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 9999;
            box-shadow: 0 2px 10px rgba(0,0,0,0.25);
            font-family: sans-serif;
            margin-bottom: 12px;
        }
        .no-print button, .no-print a {
            background: #2563eb;
            color: #fff;
            border: none;
            padding: 8px 16px;
            font-size: 13px;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .no-print button.btn-back {
            background: #475569;
        }
        .no-print button:hover {
            opacity: 0.9;
        }

        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background: #fff !important;
            }
            .page-sheet {
                max-width: 100% !important;
                margin: 0 !important;
                box-shadow: none !important;
            }
        }

        .title-header {
            text-align: center;
            font-size: 13pt;
            font-weight: 900;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        .meta-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8.5pt;
            margin-bottom: 8px;
        }
        .meta-table td {
            padding: 1.5px 2px;
            vertical-align: top;
        }

        table.kk-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 7.5pt;
            margin-bottom: 6px;
        }
        table.kk-table th, table.kk-table td {
            border: 1px solid #000;
            padding: 2.5px 3px;
            text-align: left;
            vertical-align: middle;
        }
        table.kk-table th {
            text-align: center;
            font-weight: bold;
            background: #fff;
        }
        table.kk-table tr.sub-header td {
            text-align: center;
            font-size: 7pt;
            font-weight: bold;
            background: #e2e8f0;
            padding: 1px 2px;
        }

        .signatures {
            width: 100%;
            border-collapse: collapse;
            font-size: 8pt;
            margin-top: 10px;
        }
        .signatures td {
            vertical-align: top;
            padding: 2px 4px;
        }
    </style>
</head>
<body>

    {{-- Screen Action Bar --}}
    <div class="no-print">
        <div style="display:flex; align-items:center; gap:12px;">
            <button class="btn-back" onclick="window.history.back()">
                &larr; Kembali
            </button>
            <span style="font-size:13px; font-weight:bold;">
                Pratinjau Cetak Formulir KK Baru: {{ $submission->nomor_tiket }}
            </span>
        </div>
        <div style="display:flex; gap:10px;">
            <button onclick="window.print()">
                🖨️ Cetak Formulir KK Baru (A4 Landscape)
            </button>
        </div>
    </div>

    @php
        $namaKepalaKeluarga = strtoupper($f101['nama_kepala_keluarga'] ?? $f101['nama_pemohon'] ?? $submission->user->name);
        $alamat = strtoupper($f101['alamat'] ?? $submission->user->alamat_detail ?? '-');
        $rt = str_pad($f101['rt'] ?? '001', 3, '0', STR_PAD_LEFT);
        $rw = str_pad($f101['rw'] ?? '001', 3, '0', STR_PAD_LEFT);
        $kodePos = $f101['kode_pos'] ?? '46182';

        $desa = strtoupper($f101['nama_desa'] ?? $submission->desa?->nama_desa ?? $submission->user->desa?->nama_desa ?? 'MANONJAYA');
        $kecamatan = strtoupper($f101['nama_kecamatan'] ?? $submission->kecamatan?->nama_kecamatan ?? 'MANONJAYA');
        $kabupaten = 'TASIKMALAYA';
        $provinsi = 'JAWA BARAT';

        $anggotaList = $f101['anggota'] ?? [];
        if (empty($anggotaList)) {
            // fallback minimal kepala keluarga
            $anggotaList = [
                [
                    'nama' => $namaKepalaKeluarga,
                    'nik' => $f101['nik_pemohon'] ?? $submission->user->nik ?? '-',
                    'jenis_kelamin' => 'LAKI-LAKI',
                    'tempat_lahir' => 'TASIKMALAYA',
                    'tanggal_lahir' => '-',
                    'agama' => 'ISLAM',
                    'pendidikan' => 'SLTA / SEDERAJAT',
                    'pekerjaan' => 'WIRASWASTA',
                    'gol_darah' => '-',
                    'status_kawin' => 'KAWIN TERCATAT',
                    'tgl_kawin' => '-',
                    'shdk' => 'KEPALA KELUARGA',
                    'kewarganegaraan' => 'WNI',
                    'no_paspor' => '-',
                    'no_kitap' => '-',
                    'nama_ayah' => '-',
                    'nama_ibu' => '-',
                ]
            ];
        }
    @endphp

    <div class="page-sheet">

        {{-- JUDUL FORMULIR --}}
        <div class="title-header">
            FORMULIR PEMBUATAN KARTU KELUARGA BARU
        </div>

        {{-- METADATA DUA KOLOM (KIRI & KANAN) PERSIS GAMBAR --}}
        <table class="meta-table">
            <tr>
                {{-- Kolom Kiri --}}
                <td style="width: 50%;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="width: 140px;">Nama Kepala Keluarga</td>
                            <td style="width: 8px;">:</td>
                            <td style="font-weight: bold;">{{ $namaKepalaKeluarga }}</td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>:</td>
                            <td>{{ $alamat }}</td>
                        </tr>
                        <tr>
                            <td>RT/RW</td>
                            <td>:</td>
                            <td>{{ $rt }} / {{ $rw }}</td>
                        </tr>
                        <tr>
                            <td>Kode Pos</td>
                            <td>:</td>
                            <td>{{ $kodePos }}</td>
                        </tr>
                    </table>
                </td>

                {{-- Kolom Kanan --}}
                <td style="width: 50%;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="width: 130px;">Desa/Kelurahan</td>
                            <td style="width: 8px;">:</td>
                            <td style="font-weight: bold;">{{ $desa }}</td>
                        </tr>
                        <tr>
                            <td>Kecamatan</td>
                            <td>:</td>
                            <td style="font-weight: bold;">{{ $kecamatan }}</td>
                        </tr>
                        <tr>
                            <td>Kabupaten/Kota</td>
                            <td>:</td>
                            <td style="font-weight: bold;">{{ $kabupaten }}</td>
                        </tr>
                        <tr>
                            <td>Provinsi</td>
                            <td>:</td>
                            <td style="font-weight: bold;">{{ $provinsi }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        {{-- TABEL 1 (KOLOM 1 - 9) --}}
        <table class="kk-table">
            <thead>
                <tr>
                    <th style="width: 25px;">No</th>
                    <th style="width: 160px;">Nama Lengkap</th>
                    <th style="width: 115px;">NIK</th>
                    <th style="width: 75px;">Jenis Kelamin</th>
                    <th style="width: 85px;">Tempat Lahir</th>
                    <th style="width: 75px;">Tanggal Lahir</th>
                    <th style="width: 70px;">Agama</th>
                    <th style="width: 110px;">Pendidikan</th>
                    <th style="width: 110px;">Jenis Pekerjaan</th>
                    <th style="width: 55px;">Golongan Darah</th>
                </tr>
                <tr class="sub-header">
                    <td></td>
                    <td>(1)</td>
                    <td>(2)</td>
                    <td>(3)</td>
                    <td>(4)</td>
                    <td>(5)</td>
                    <td>(6)</td>
                    <td>(7)</td>
                    <td>(8)</td>
                    <td>(9)</td>
                </tr>
            </thead>
            <tbody>
                @for ($i = 1; $i <= 10; $i++)
                    @php
                        $ang = $anggotaList[$i - 1] ?? null;
                    @endphp
                    <tr>
                        <td style="text-align: center; font-weight: bold;">{{ $i }}</td>
                        <td style="font-weight: {{ $ang ? 'bold' : 'normal' }}; text-transform: uppercase;">
                            {{ $ang['nama'] ?? '-' }}
                        </td>
                        <td style="text-align: center; font-family: monospace; font-size: 8pt; font-weight: bold;">
                            {{ $ang['nik'] ?? '-' }}
                        </td>
                        <td style="text-align: center; text-transform: uppercase;">
                            {{ $ang['jenis_kelamin'] ?? '-' }}
                        </td>
                        <td style="text-transform: uppercase;">
                            {{ $ang['tempat_lahir'] ?? '-' }}
                        </td>
                        <td style="text-align: center;">
                            @if (!empty($ang['tanggal_lahir']) && $ang['tanggal_lahir'] !== '-')
                                {{ date('d-m-Y', strtotime($ang['tanggal_lahir'])) }}
                            @else
                                -
                            @endif
                        </td>
                        <td style="text-align: center; text-transform: uppercase;">
                            {{ $ang['agama'] ?? '-' }}
                        </td>
                        <td style="text-transform: uppercase;">
                            {{ $ang['pendidikan'] ?? '-' }}
                        </td>
                        <td style="text-transform: uppercase;">
                            {{ $ang['pekerjaan'] ?? '-' }}
                        </td>
                        <td style="text-align: center; font-weight: bold;">
                            {{ $ang['gol_darah'] ?? '-' }}
                        </td>
                    </tr>
                @endfor
            </tbody>
        </table>

        {{-- TABEL 2 (KOLOM 10 - 17) --}}
        <table class="kk-table" style="margin-top: 4px;">
            <thead>
                <tr>
                    <th rowspan="2" style="width: 25px;">No</th>
                    <th rowspan="2" style="width: 105px;">Status Perkawinan</th>
                    <th rowspan="2" style="width: 80px;">Tanggal Perkawinan</th>
                    <th rowspan="2" style="width: 130px;">Status Hubungan Dalam Keluarga</th>
                    <th rowspan="2" style="width: 75px;">Kewarganegaraan</th>
                    <th colspan="2">Dokumen Imigrasi</th>
                    <th colspan="2">Nama Orang Tua</th>
                </tr>
                <tr>
                    <th style="width: 85px;">No. Paspor</th>
                    <th style="width: 85px;">No. KITAP</th>
                    <th style="width: 130px;">Ayah</th>
                    <th style="width: 130px;">Ibu</th>
                </tr>
                <tr class="sub-header">
                    <td></td>
                    <td>(10)</td>
                    <td>(11)</td>
                    <td>(12)</td>
                    <td>(13)</td>
                    <td>(14)</td>
                    <td>(15)</td>
                    <td>(16)</td>
                    <td>(17)</td>
                </tr>
            </thead>
            <tbody>
                @for ($i = 1; $i <= 10; $i++)
                    @php
                        $ang = $anggotaList[$i - 1] ?? null;
                    @endphp
                    <tr>
                        <td style="text-align: center; font-weight: bold;">{{ $i }}</td>
                        <td style="text-transform: uppercase;">
                            {{ $ang['status_kawin'] ?? '-' }}
                        </td>
                        <td style="text-align: center;">
                            @if (!empty($ang['tgl_kawin']) && $ang['tgl_kawin'] !== '-')
                                {{ date('d-m-Y', strtotime($ang['tgl_kawin'])) }}
                            @else
                                -
                            @endif
                        </td>
                        <td style="text-transform: uppercase; font-weight: {{ $ang ? 'bold' : 'normal' }};">
                            {{ $ang['shdk'] ?? '-' }}
                        </td>
                        <td style="text-align: center; font-weight: bold;">
                            {{ $ang['kewarganegaraan'] ?? '-' }}
                        </td>
                        <td style="text-align: center; font-family: monospace;">
                            {{ !empty($ang['no_paspor']) ? $ang['no_paspor'] : '-' }}
                        </td>
                        <td style="text-align: center; font-family: monospace;">
                            {{ !empty($ang['no_kitap']) ? $ang['no_kitap'] : '-' }}
                        </td>
                        <td style="text-transform: uppercase;">
                            {{ $ang['nama_ayah'] ?? '-' }}
                        </td>
                        <td style="text-transform: uppercase;">
                            {{ $ang['nama_ibu'] ?? '-' }}
                        </td>
                    </tr>
                @endfor
            </tbody>
        </table>

        {{-- TANDA TANGAN --}}
        <table class="signatures">
            <tr>
                <td style="width: 35%; text-align: center;">
                    Mengetahui,<br>
                    <strong>KEPALA DESA / LURAH {{ $desa }}</strong>
                    <br><br><br><br><br>
                    ( .............................................................. )
                </td>
                <td style="width: 30%;"></td>
                <td style="width: 35%; text-align: center;">
                    {{ $desa }}, {{ date('d F Y', strtotime($submission->created_at ?? now())) }}<br>
                    <strong>KEPALA KELUARGA / PEMOHON</strong>
                    <br><br><br><br><br>
                    <strong><u>( {{ $namaKepalaKeluarga }} )</u></strong>
                </td>
            </tr>
        </table>

    </div>

</body>
</html>
