<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir F-1.01 Biodata Keluarga — {{ $submission->nomor_tiket }}</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 10mm 12mm 10mm 12mm;
        }

        * {
            box-sizing: border-box;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 8pt;
            color: #000;
            line-height: 1.15;
            margin: 0;
            padding: 0;
            background: #fff;
        }

        .page-sheet {
            width: 100%;
            max-width: 277mm;
            margin: 0 auto;
            background: #fff;
            position: relative;
        }

        .page-break {
            page-break-after: always;
            break-after: page;
        }

        /* ── Action bar (Screen Only) ── */
        .no-print {
            background: #0a2558;
            color: #fff;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 9999;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            font-family: sans-serif;
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
                background: none;
            }
            .page-sheet {
                width: 100%;
                max-width: 100%;
                padding: 0;
                margin: 0;
            }
        }

        /* ── Grid & Table Styles ── */
        .header-box {
            position: absolute;
            top: 0;
            right: 0;
            border: 1.5px solid #000;
            padding: 3px 12px;
            font-weight: bold;
            font-size: 10pt;
        }

        .doc-title {
            text-align: center;
            font-size: 12pt;
            font-weight: bold;
            margin-top: 2px;
            margin-bottom: 4px;
            letter-spacing: 0.5px;
        }

        .notice-bar {
            background: #000;
            color: #fff;
            font-weight: bold;
            font-size: 7.5pt;
            padding: 2.5px 6px;
            margin-bottom: 5px;
        }

        .checkbox-group {
            display: flex;
            gap: 20px;
            font-size: 7.5pt;
            margin-bottom: 5px;
        }
        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .box-check {
            width: 11px;
            height: 11px;
            border: 1px solid #000;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 9px;
            font-weight: bold;
        }

        .section-header {
            font-weight: bold;
            font-size: 8pt;
            margin-top: 4px;
            margin-bottom: 2px;
            border-bottom: 1px solid #000;
            padding-bottom: 1px;
        }

        .section-subnote {
            font-style: italic;
            font-size: 7pt;
            margin-bottom: 2px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 8px;
        }

        .form-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 7.5pt;
        }
        .form-table td {
            padding: 1.5px 2px;
            vertical-align: middle;
        }
        .form-table .label {
            width: 160px;
            white-space: nowrap;
        }
        .form-table .colon {
            width: 8px;
            text-align: center;
        }

        .char-boxes {
            display: inline-flex;
            vertical-align: middle;
        }
        .char-box {
            width: 14px;
            height: 14px;
            border: 1px solid #000;
            margin-right: -1px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 7.5pt;
            font-family: monospace;
            font-weight: bold;
            text-transform: uppercase;
        }

        .fill-line {
            display: inline-block;
            border-bottom: 1px solid #000;
            min-height: 13px;
            padding: 0 4px;
            font-weight: bold;
            font-size: 7.5pt;
        }

        /* ── Data Anggota Table ── */
        .member-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 6.5pt;
            margin-top: 3px;
            table-layout: fixed;
        }
        .member-table th, .member-table td {
            border: 1px solid #000;
            padding: 2px 1.5px;
            text-align: center;
            vertical-align: middle;
            word-wrap: break-word;
            overflow: hidden;
        }
        .member-table th {
            background-color: #f1f1f1;
            font-weight: bold;
            line-height: 1.1;
        }
        .member-table th .col-num {
            font-weight: normal;
            font-size: 5.5pt;
            display: block;
            margin-top: 1px;
        }
        .member-table td.text-left {
            text-align: left;
            padding-left: 3px;
        }
        .member-table tr {
            height: 16px;
        }

        /* ── Footer ── */
        .page-footer {
            margin-top: 4px;
            display: flex;
            justify-content: space-between;
            font-size: 7pt;
            font-weight: bold;
        }

        .signatures-container {
            display: flex;
            justify-content: space-between;
            margin-top: 8px;
            font-size: 7.5pt;
        }
        .signature-col {
            width: 45%;
            text-align: center;
        }
        .signature-space {
            height: 45px;
        }

        .statement-box {
            font-size: 6.5pt;
            margin-top: 6px;
            line-height: 1.2;
        }
        .statement-title {
            font-weight: bold;
        }
    </style>
</head>
<body>

    {{-- Top Action Bar (Screen Only) --}}
    <div class="no-print">
        <div style="display: flex; align-items: center; gap: 12px;">
            <button type="button" class="btn-back" onclick="window.history.back()">
                &larr; Kembali
            </button>
            <span style="font-weight: bold; font-size: 14px;">Pratinjau Cetak Formulir F-1.01 (Biodata Keluarga)</span>
            <span style="font-size: 12px; opacity: 0.8;">Tiket: {{ $submission->nomor_tiket }}</span>
        </div>
        <div style="display: flex; gap: 8px;">
            <button type="button" onclick="window.print()">
                <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/><path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z"/></svg>
                Cetak / Simpan PDF
            </button>
        </div>
    </div>

    @php
        $jenisPilihan = $f101['jenis_pilihan'] ?? 'wni';
        $namaKepala = strtoupper($f101['nama_kepala_keluarga'] ?? $submission->user->name);
        $nikKepala = $f101['nik_kepala_keluarga'] ?? $submission->user->nik ?? '';
        $alamat = strtoupper($f101['alamat'] ?? $submission->user->alamat_detail ?? '-');
        $rt = str_pad($f101['rt'] ?? '1', 3, '0', STR_PAD_LEFT);
        $rw = str_pad($f101['rw'] ?? '1', 3, '0', STR_PAD_LEFT);
        $kodePos = $f101['kode_pos'] ?? '46182';
        $telepon = $f101['telepon'] ?? $submission->user->phone ?? '-';
        $email = $f101['email'] ?? $submission->user->email ?? '-';

        $provinsi = strtoupper($f101['nama_provinsi'] ?? '32 - JAWA BARAT');
        $kabupaten = strtoupper($f101['nama_kabupaten'] ?? '06 - KAB. TASIKMALAYA');
        $kecamatan = strtoupper($f101['nama_kecamatan'] ?? $submission->kecamatan->nama_kecamatan);
        $desa = strtoupper($f101['nama_desa'] ?? $submission->user->desa?->nama_desa ?? '-');
        $dusun = strtoupper($f101['nama_dusun'] ?? '-');

        $anggotaList = $f101['anggota'] ?? [];
        $jumlahAnggota = count($anggotaList) > 0 ? count($anggotaList) : 1;
    @endphp

    {{-- ═══════════════════════════════════════════════════════════════════════════
         HALAMAN 1 (PAGE 1 OF 2)
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="page-sheet page-break">
        <div class="header-box">F-1.01</div>

        <div class="doc-title">FORMULIR BIODATA KELUARGA</div>

        <div class="notice-bar">
            PERHATIAN : Isilah Formulir ini dengan huruf cetak dan jelas serta mengikuti "TATA CARA PENGISIAN FORMULIR"
        </div>

        <div class="checkbox-group">
            <span style="font-weight: bold;">Pilih salah satu:</span>
            <div class="checkbox-item">
                <span class="box-check">{{ $jenisPilihan === 'wni' ? 'X' : '' }}</span>
                <span>Input Data Kepala Keluarga dan Anggota Keluarga WNI</span>
            </div>
            <div class="checkbox-item">
                <span class="box-check">{{ $jenisPilihan === 'asing' ? 'X' : '' }}</span>
                <span>Input Data Kepala Keluarga dan Anggota Keluarga Orang Asing</span>
            </div>
            <div class="checkbox-item">
                <span class="box-check">{{ $jenisPilihan === 'wni_luar_negeri' ? 'X' : '' }}</span>
                <span>Input Data Kepala Keluarga dan Anggota Keluarga WNI di luar Negeri</span>
            </div>
        </div>

        {{-- Grid Data Kepala Keluarga & Data Wilayah --}}
        <div class="form-grid">
            {{-- Kiri: DATA KEPALA KELUARGA --}}
            <div>
                <div class="section-header">DATA KEPALA KELUARGA</div>
                <table class="form-table">
                    <tr>
                        <td class="label">1. Nama Kepala Keluarga / <i>Name of Head</i></td>
                        <td class="colon">:</td>
                        <td><span class="fill-line" style="width: 95%;">{{ $namaKepala }}</span></td>
                    </tr>
                    <tr>
                        <td class="label">2. Alamat / <i>Address</i></td>
                        <td class="colon">:</td>
                        <td><span class="fill-line" style="width: 95%;">{{ $alamat }}</span></td>
                    </tr>
                    <tr>
                        <td class="label">3. Kode Pos / <i>Post Code</i></td>
                        <td class="colon">:</td>
                        <td>
                            <div class="char-boxes">
                                @foreach (str_split(str_pad(substr($kodePos, 0, 5), 5, ' ')) as $c)
                                    <span class="char-box">{{ $c }}</span>
                                @endforeach
                            </div>
                            &nbsp;&nbsp;4. RT :
                            <div class="char-boxes">
                                @foreach (str_split(str_pad(substr($rt, 0, 3), 3, '0', STR_PAD_LEFT)) as $c)
                                    <span class="char-box">{{ $c }}</span>
                                @endforeach
                            </div>
                            &nbsp;&nbsp;5. RW :
                            <div class="char-boxes">
                                @foreach (str_split(str_pad(substr($rw, 0, 3), 3, '0', STR_PAD_LEFT)) as $c)
                                    <span class="char-box">{{ $c }}</span>
                                @endforeach
                            </div>
                            &nbsp;&nbsp;6. Jumlah Anggota :
                            <div class="char-boxes">
                                @foreach (str_split(str_pad($jumlahAnggota, 2, '0', STR_PAD_LEFT)) as $c)
                                    <span class="char-box">{{ $c }}</span>
                                @endforeach
                            </div> Orang
                        </td>
                    </tr>
                    <tr>
                        <td class="label">7. Telepon / Handphone</td>
                        <td class="colon">:</td>
                        <td>
                            <div class="char-boxes">
                                @foreach (str_split(str_pad(substr(preg_replace('/[^0-9]/', '', $telepon), 0, 14), 14, ' ')) as $c)
                                    <span class="char-box">{{ $c !== ' ' ? $c : '' }}</span>
                                @endforeach
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">8. Email</td>
                        <td class="colon">:</td>
                        <td><span class="fill-line" style="width: 95%;">{{ $email }}</span></td>
                    </tr>
                </table>
            </div>

            {{-- Kanan: DATA WILAYAH --}}
            <div>
                <div class="section-subnote" style="text-align: right;">Kode Wilayah diisi oleh Petugas Kependudukan dan Catatan Sipil</div>
                <div class="section-header">DATA WILAYAH</div>
                <table class="form-table">
                    <tr>
                        <td class="label">9. Kode-Nama Provinsi</td>
                        <td class="colon">:</td>
                        <td>
                            <div class="char-boxes">
                                <span class="char-box">3</span><span class="char-box">2</span>
                            </div>
                            &nbsp;<span class="fill-line" style="width: 140px;">JAWA BARAT</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">10. Kode-Nama Kab/Kota</td>
                        <td class="colon">:</td>
                        <td>
                            <div class="char-boxes">
                                <span class="char-box">0</span><span class="char-box">6</span>
                            </div>
                            &nbsp;<span class="fill-line" style="width: 140px;">KAB. TASIKMALAYA</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">11. Kode-Nama Kecamatan</td>
                        <td class="colon">:</td>
                        <td>
                            <div class="char-boxes">
                                <span class="char-box">1</span><span class="char-box">7</span>
                            </div>
                            &nbsp;<span class="fill-line" style="width: 140px;">{{ $kecamatan }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">12. Kode-Nama Kel/Desa</td>
                        <td class="colon">:</td>
                        <td>
                            <div class="char-boxes">
                                <span class="char-box">0</span><span class="char-box">1</span>
                            </div>
                            &nbsp;<span class="fill-line" style="width: 140px;">{{ $desa }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">13. Nama Dusun/Dukuh/Kp.</td>
                        <td class="colon">:</td>
                        <td><span class="fill-line" style="width: 180px;">{{ $dusun }}</span></td>
                    </tr>
                </table>
            </div>
        </div>

        {{-- Section: DATA ANGGOTA KELUARGA --}}
        <div style="margin-top: 6px;">
            <div class="section-header" style="display: flex; justify-content: space-between;">
                <span>DATA ANGGOTA KELUARGA</span>
                <span style="font-weight: normal; font-size: 6.5pt;">(Catatan: WNI mengisi Kolom 2 s.d 6, 10 s.d 31, 38 s.d 41)</span>
            </div>

            {{-- Table 1 (Kolom 1 - 7) --}}
            <table class="member-table">
                <thead>
                    <tr>
                        <th style="width: 25px;">No.<span class="col-num">1</span></th>
                        <th style="width: 200px;">Nama Lengkap<br><i>Full Name</i><span class="col-num">2</span></th>
                        <th style="width: 60px;">Gelar Depan<span class="col-num">3</span></th>
                        <th style="width: 65px;">Gelar Belakang<span class="col-num">4</span></th>
                        <th style="width: 120px;">Nomor Paspor<br><i>Passport Number</i><span class="col-num">5</span></th>
                        <th style="width: 110px;">Tanggal Berakhir Passport<br><i>Date of Expiry</i><span class="col-num">6</span></th>
                        <th>Nama Sponsor<br><i>Sponsor Name</i><span class="col-num">7</span></th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 0; $i < 10; $i++)
                        @php $ang = $anggotaList[$i] ?? null; @endphp
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td class="text-left font-bold" style="font-weight: {{ $ang ? 'bold' : 'normal' }};">
                                {{ $ang ? strtoupper($ang['nama']) : '' }}
                            </td>
                            <td>{{ $ang['gelar_depan'] ?? '' }}</td>
                            <td>{{ $ang['gelar_belakang'] ?? '' }}</td>
                            <td>{{ $ang['paspor'] ?? '' }}</td>
                            <td>{{ $ang['paspor_exp'] ?? '' }}</td>
                            <td>{{ $ang['sponsor'] ?? '' }}</td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>

        <div class="page-footer">
            <span>Portal Pelayanan Terpadu Kabupaten Tasikmalaya &bull; No. Tiket: {{ $submission->nomor_tiket }}</span>
            <span>F-1.01 1 of 2</span>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         HALAMAN 2 (PAGE 2 OF 2)
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="page-sheet">
        <div style="text-align: right; font-weight: bold; font-size: 8pt; margin-bottom: 2px;">
            Lanjutan Formulir Biodata Keluarga F-1.01
        </div>

        {{-- Table 2 (Kolom 8 - 15) --}}
        <table class="member-table">
            <thead>
                <tr>
                    <th style="width: 25px;">No.</th>
                    <th style="width: 90px;">Tipe Sponsor<span class="col-num">8</span></th>
                    <th style="width: 130px;">Alamat Sponsor<span class="col-num">9</span></th>
                    <th style="width: 60px;">Jenis Kelamin<span class="col-num">10</span></th>
                    <th style="width: 110px;">Tempat Lahir<span class="col-num">11</span></th>
                    <th style="width: 100px;">Tgl, Bln, Thn Lahir<span class="col-num">12</span></th>
                    <th style="width: 90px;">Kewarganegaraan<span class="col-num">13</span></th>
                    <th style="width: 100px;">No. SK Penetapan WNI<span class="col-num">14</span></th>
                    <th>Akta Lahir<span class="col-num">15</span></th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < 10; $i++)
                    @php $ang = $anggotaList[$i] ?? null; @endphp
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $ang['tipe_sponsor'] ?? '' }}</td>
                        <td>{{ $ang['alamat_sponsor'] ?? '' }}</td>
                        <td>{{ $ang ? (($ang['jenis_kelamin'] ?? '') === 'L' ? 'LAKI-LAKI' : 'PEREMPUAN') : '' }}</td>
                        <td class="text-left">{{ $ang ? strtoupper($ang['tempat_lahir'] ?? '') : '' }}</td>
                        <td>{{ $ang['tanggal_lahir'] ?? '' }}</td>
                        <td>{{ $ang ? 'WNI' : '' }}</td>
                        <td>{{ $ang['sk_wni'] ?? '' }}</td>
                        <td>{{ $ang ? (!empty($ang['no_akta_lahir']) ? 'ADA' : 'TIDAK ADA') : '' }}</td>
                    </tr>
                @endfor
            </tbody>
        </table>

        {{-- Table 3 (Kolom 16 - 23) --}}
        <table class="member-table" style="margin-top: 3px;">
            <thead>
                <tr>
                    <th style="width: 25px;">No.</th>
                    <th style="width: 130px;">Nomor Akta Kelahiran<span class="col-num">16</span></th>
                    <th style="width: 55px;">Gol. Darah<span class="col-num">17</span></th>
                    <th style="width: 80px;">Agama<span class="col-num">18</span></th>
                    <th style="width: 120px;">Organisasi Kepercayaan<span class="col-num">19</span></th>
                    <th style="width: 85px;">Status Perkawinan<span class="col-num">20</span></th>
                    <th style="width: 60px;">Akta Kawin<span class="col-num">21</span></th>
                    <th style="width: 110px;">Nomor Akta Perkawinan<span class="col-num">22</span></th>
                    <th>Tanggal Perkawinan<span class="col-num">23</span></th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < 10; $i++)
                    @php $ang = $anggotaList[$i] ?? null; @endphp
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td class="text-left">{{ $ang['no_akta_lahir'] ?? '' }}</td>
                        <td>{{ $ang ? ($ang['gol_darah'] ?? '-') : '' }}</td>
                        <td>{{ $ang ? strtoupper($ang['agama'] ?? '') : '' }}</td>
                        <td></td>
                        <td>{{ $ang ? strtoupper($ang['status_kawin'] ?? '') : '' }}</td>
                        <td>{{ $ang ? (!empty($ang['no_buku_nikah']) ? 'ADA' : 'TIDAK') : '' }}</td>
                        <td class="text-left">{{ $ang['no_buku_nikah'] ?? '' }}</td>
                        <td>{{ $ang['tgl_nikah'] ?? '' }}</td>
                    </tr>
                @endfor
            </tbody>
        </table>

        {{-- Table 4 (Kolom 24 - 33) --}}
        <table class="member-table" style="margin-top: 3px;">
            <thead>
                <tr>
                    <th style="width: 25px;">No.</th>
                    <th style="width: 50px;">Akta Cerai<span class="col-num">24</span></th>
                    <th style="width: 100px;">Nomor Akta Cerai<span class="col-num">25</span></th>
                    <th style="width: 75px;">Tgl Cerai<span class="col-num">26</span></th>
                    <th style="width: 100px;">Status Hub. Keluarga<span class="col-num">27</span></th>
                    <th style="width: 80px;">Kelainan Fisik<span class="col-num">28</span></th>
                    <th style="width: 80px;">Penyandang Cacat<span class="col-num">29</span></th>
                    <th style="width: 90px;">Pendidikan Terakhir<span class="col-num">30</span></th>
                    <th style="width: 100px;">Jenis Pekerjaan<span class="col-num">31</span></th>
                    <th style="width: 60px;">No ITAS<span class="col-num">32</span></th>
                    <th>Tempat Terbit<span class="col-num">33</span></th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < 10; $i++)
                    @php $ang = $anggotaList[$i] ?? null; @endphp
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-left font-bold">{{ $ang ? strtoupper($ang['shdk'] ?? '') : '' }}</td>
                        <td>{{ $ang ? ($ang['disabilitas'] !== 'Tidak Ada' ? $ang['disabilitas'] : 'TIDAK ADA') : '' }}</td>
                        <td>{{ $ang ? ($ang['disabilitas'] !== 'Tidak Ada' ? $ang['disabilitas'] : '-') : '' }}</td>
                        <td>{{ $ang ? strtoupper($ang['pendidikan'] ?? '') : '' }}</td>
                        <td class="text-left">{{ $ang ? strtoupper($ang['pekerjaan'] ?? '') : '' }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                @endfor
            </tbody>
        </table>

        {{-- Table 5 (Kolom 34 - 41) --}}
        <table class="member-table" style="margin-top: 3px;">
            <thead>
                <tr>
                    <th style="width: 25px;">No.</th>
                    <th style="width: 80px;">Tgl Terbit ITAS<span class="col-num">34</span></th>
                    <th style="width: 80px;">Tgl Akhir ITAS<span class="col-num">35</span></th>
                    <th style="width: 90px;">Tempat Datang<span class="col-num">36</span></th>
                    <th style="width: 85px;">Tgl Kedatangan<span class="col-num">37</span></th>
                    <th style="width: 110px;">NIK Ibu<span class="col-num">38</span></th>
                    <th style="width: 130px;">Nama Ibu Kandung<span class="col-num">39</span></th>
                    <th style="width: 110px;">NIK Ayah<span class="col-num">40</span></th>
                    <th>Nama Ayah Kandung<span class="col-num">41</span></th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < 10; $i++)
                    @php $ang = $anggotaList[$i] ?? null; @endphp
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="font-mono">{{ $ang['nik_ibu'] ?? '' }}</td>
                        <td class="text-left">{{ $ang ? strtoupper($ang['nama_ibu'] ?? '') : '' }}</td>
                        <td class="font-mono">{{ $ang['nik_ayah'] ?? '' }}</td>
                        <td class="text-left">{{ $ang ? strtoupper($ang['nama_ayah'] ?? '') : '' }}</td>
                    </tr>
                @endfor
            </tbody>
        </table>

        {{-- Pernyataan & Tanda Tangan --}}
        <div class="statement-box">
            <span class="statement-title">PERNYATAAN</span><br>
            Demikian Formulir ini saya/ kami isi dengan sesungguhnya. Apabila keterangan tersebut tidak sesuai dengan keadaan sebenarnya,
            saya bersedia dikenakan sanksi sesuai ketentuan peraturan perundang-undangan yang berlaku.
        </div>

        <div class="signatures-container">
            <div class="signature-col">
                Mengetahui,<br>
                Kepala Dinas Kependudukan dan Pencatatan Sipil /<br>
                Camat {{ $submission->kecamatan->nama_kecamatan }}
                <div class="signature-space"></div>
                ( ............................................................................ )<br>
                NIP. ....................................................................
            </div>

            <div class="signature-col">
                {{ $submission->kecamatan->nama_kecamatan }}, {{ now()->isoFormat('D MMMM Y') }}<br>
                Kepala Keluarga / <i>Head of Family</i>
                <div class="signature-space"></div>
                <b>( {{ $namaKepala }} )</b>
            </div>
        </div>

        <div class="page-footer">
            <span>Portal Pelayanan Terpadu Kabupaten Tasikmalaya &bull; No. Tiket: {{ $submission->nomor_tiket }}</span>
            <span>F-1.01 2 of 2</span>
        </div>
    </div>

</body>
</html>
