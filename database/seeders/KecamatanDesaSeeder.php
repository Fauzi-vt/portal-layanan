<?php

namespace Database\Seeders;

use App\Enums\ServiceProcessType;
use App\Models\Desa;
use App\Models\Kecamatan;
use App\Models\Service;
use App\Models\ServiceRequirement;
use Illuminate\Database\Seeder;

class KecamatanDesaSeeder extends Seeder
{
    /**
     * Jalankan seeder untuk 39 Kecamatan di Kabupaten Tasikmalaya,
     * sampel desa pada Kecamatan Manonjaya, dan 8 Master Layanan Utama beserta persyaratannya.
     */
    public function run(): void
    {
        $this->seedKecamatansAndDesas();
        $this->seedServicesAndRequirements();
    }

    /**
     * Seed 39 Kecamatan di Kabupaten Tasikmalaya beserta sampel Desa di Manonjaya.
     */
    private function seedKecamatansAndDesas(): void
    {
        // Daftar 39 Kecamatan resmi di Kabupaten Tasikmalaya
        $kecamatansData = [
            ['kode' => 'KEC-001', 'nama' => 'Kadipaten', 'telepon' => '0265-420001', 'email' => 'kec.kadipaten@tasikmalayakab.go.id'],
            ['kode' => 'KEC-002', 'nama' => 'Pagerageung', 'telepon' => '0265-420002', 'email' => 'kec.pagerageung@tasikmalayakab.go.id'],
            ['kode' => 'KEC-003', 'nama' => 'Ciawi', 'telepon' => '0265-420003', 'email' => 'kec.ciawi@tasikmalayakab.go.id'],
            ['kode' => 'KEC-004', 'nama' => 'Sukaresik', 'telepon' => '0265-420004', 'email' => 'kec.sukaresik@tasikmalayakab.go.id'],
            ['kode' => 'KEC-005', 'nama' => 'Jamanis', 'telepon' => '0265-420005', 'email' => 'kec.jamanis@tasikmalayakab.go.id'],
            ['kode' => 'KEC-006', 'nama' => 'Sukahening', 'telepon' => '0265-420006', 'email' => 'kec.sukahening@tasikmalayakab.go.id'],
            ['kode' => 'KEC-007', 'nama' => 'Rajapolah', 'telepon' => '0265-420007', 'email' => 'kec.rajapolah@tasikmalayakab.go.id'],
            ['kode' => 'KEC-008', 'nama' => 'Cisayong', 'telepon' => '0265-420008', 'email' => 'kec.cisayong@tasikmalayakab.go.id'],
            ['kode' => 'KEC-009', 'nama' => 'Sariwangi', 'telepon' => '0265-420009', 'email' => 'kec.sariwangi@tasikmalayakab.go.id'],
            ['kode' => 'KEC-010', 'nama' => 'Leuwisari', 'telepon' => '0265-420010', 'email' => 'kec.leuwisari@tasikmalayakab.go.id'],
            ['kode' => 'KEC-011', 'nama' => 'Padakembang', 'telepon' => '0265-420011', 'email' => 'kec.padakembang@tasikmalayakab.go.id'],
            ['kode' => 'KEC-012', 'nama' => 'Sukaratul', 'telepon' => '0265-420012', 'email' => 'kec.sukaratu@tasikmalayakab.go.id'],
            ['kode' => 'KEC-013', 'nama' => 'Singaparna', 'telepon' => '0265-420013', 'email' => 'kec.singaparna@tasikmalayakab.go.id'],
            ['kode' => 'KEC-014', 'nama' => 'Salawu', 'telepon' => '0265-420014', 'email' => 'kec.salawu@tasikmalayakab.go.id'],
            ['kode' => 'KEC-015', 'nama' => 'Mangunreja', 'telepon' => '0265-420015', 'email' => 'kec.mangunreja@tasikmalayakab.go.id'],
            ['kode' => 'KEC-016', 'nama' => 'Sukarame', 'telepon' => '0265-420016', 'email' => 'kec.sukarame@tasikmalayakab.go.id'],
            ['kode' => 'KEC-017', 'nama' => 'Manonjaya', 'telepon' => '0265-380123', 'email' => 'kec.manonjaya@tasikmalayakab.go.id', 'alamat' => 'Jl. Kaum No. 12, Manonjaya, Tasikmalaya', 'jam' => 'Senin - Jumat, 08.00 - 16.00 WIB'],
            ['kode' => 'KEC-018', 'nama' => 'Cineam', 'telepon' => '0265-420018', 'email' => 'kec.cineam@tasikmalayakab.go.id'],
            ['kode' => 'KEC-019', 'nama' => 'Taraju', 'telepon' => '0265-420019', 'email' => 'kec.taraju@tasikmalayakab.go.id'],
            ['kode' => 'KEC-020', 'nama' => 'Puspahiang', 'telepon' => '0265-420020', 'email' => 'kec.puspahiang@tasikmalayakab.go.id'],
            ['kode' => 'KEC-021', 'nama' => 'Tanjungjaya', 'telepon' => '0265-420021', 'email' => 'kec.tanjungjaya@tasikmalayakab.go.id'],
            ['kode' => 'KEC-022', 'nama' => 'Sukaraja', 'telepon' => '0265-420022', 'email' => 'kec.sukaraja@tasikmalayakab.go.id'],
            ['kode' => 'KEC-023', 'nama' => 'Gunungtanjung', 'telepon' => '0265-420023', 'email' => 'kec.gunungtanjung@tasikmalayakab.go.id'],
            ['kode' => 'KEC-024', 'nama' => 'Karangjaya', 'telepon' => '0265-420024', 'email' => 'kec.karangjaya@tasikmalayakab.go.id'],
            ['kode' => 'KEC-025', 'nama' => 'Bojongasih', 'telepon' => '0265-420025', 'email' => 'kec.bojongasih@tasikmalayakab.go.id'],
            ['kode' => 'KEC-026', 'nama' => 'Parungponteng', 'telepon' => '0265-420026', 'email' => 'kec.parungponteng@tasikmalayakab.go.id'],
            ['kode' => 'KEC-027', 'nama' => 'Bantarkalong', 'telepon' => '0265-420027', 'email' => 'kec.bantarkalong@tasikmalayakab.go.id'],
            ['kode' => 'KEC-028', 'nama' => 'Culamega', 'telepon' => '0265-420028', 'email' => 'kec.culamega@tasikmalayakab.go.id'],
            ['kode' => 'KEC-029', 'nama' => 'Bojonggambir', 'telepon' => '0265-420029', 'email' => 'kec.bojonggambir@tasikmalayakab.go.id'],
            ['kode' => 'KEC-030', 'nama' => 'Sodonghilir', 'telepon' => '0265-420030', 'email' => 'kec.sodonghilir@tasikmalayakab.go.id'],
            ['kode' => 'KEC-031', 'nama' => 'Cikatomas', 'telepon' => '0265-420031', 'email' => 'kec.cikatomas@tasikmalayakab.go.id'],
            ['kode' => 'KEC-032', 'nama' => 'Cibalong', 'telepon' => '0265-420032', 'email' => 'kec.cibalong@tasikmalayakab.go.id'],
            ['kode' => 'KEC-033', 'nama' => 'Cipatujah', 'telepon' => '0265-420033', 'email' => 'kec.cipatujah@tasikmalayakab.go.id'],
            ['kode' => 'KEC-034', 'nama' => 'Karangnunggal', 'telepon' => '0265-420034', 'email' => 'kec.karangnunggal@tasikmalayakab.go.id'],
            ['kode' => 'KEC-035', 'nama' => 'Cikalong', 'telepon' => '0265-420035', 'email' => 'kec.cikalong@tasikmalayakab.go.id'],
            ['kode' => 'KEC-036', 'nama' => 'Pancatengah', 'telepon' => '0265-420036', 'email' => 'kec.pancatengah@tasikmalayakab.go.id'],
            ['kode' => 'KEC-037', 'nama' => 'Jatiwaras', 'telepon' => '0265-420037', 'email' => 'kec.jatiwaras@tasikmalayakab.go.id'],
            ['kode' => 'KEC-038', 'nama' => 'Cigalontang', 'telepon' => '0265-420038', 'email' => 'kec.cigalontang@tasikmalayakab.go.id'],
            ['kode' => 'KEC-039', 'nama' => 'Cipatujah Selatan', 'telepon' => '0265-420039', 'email' => 'kec.cipatujahselatan@tasikmalayakab.go.id'],
        ];

        foreach ($kecamatansData as $data) {
            $kecamatan = Kecamatan::updateOrCreate(
                ['kode_kecamatan' => $data['kode']],
                [
                    'nama_kecamatan'  => $data['nama'],
                    'alamat_kantor'   => $data['alamat'] ?? "Jl. Raya {$data['nama']} No. 1, Kab. Tasikmalaya",
                    'email'           => $data['email'],
                    'telepon'         => $data['telepon'],
                    'jam_operasional' => $data['jam'] ?? 'Senin - Jumat, 08.00 - 15.30 WIB',
                ]
            );

            // Seed sampel desa untuk Kecamatan Manonjaya (12 Desa)
            if ($data['kode'] === 'KEC-017') {
                $desasManonjaya = [
                    ['kode' => '3206170001', 'nama' => 'Manonjaya'],
                    ['kode' => '3206170002', 'nama' => 'Kalimanggis'],
                    ['kode' => '3206170003', 'nama' => 'Pasirbatang'],
                    ['kode' => '3206170004', 'nama' => 'Kamulyan'],
                    ['kode' => '3206170005', 'nama' => 'Margaluyu'],
                    ['kode' => '3206170006', 'nama' => 'Cibeber'],
                    ['kode' => '3206170007', 'nama' => 'Sukaratu'],
                    ['kode' => '3206170008', 'nama' => 'Cihaur'],
                    ['kode' => '3206170009', 'nama' => 'Pasirhuni'],
                    ['kode' => '3206170010', 'nama' => 'Gunungtanjung'],
                    ['kode' => '3206170011', 'nama' => 'Bantar'],
                    ['kode' => '3206170012', 'nama' => 'Margahayu'],
                ];

                foreach ($desasManonjaya as $desaData) {
                    Desa::updateOrCreate(
                        ['kode_desa' => $desaData['kode']],
                        [
                            'kecamatan_id' => $kecamatan->id,
                            'nama_desa'    => $desaData['nama'],
                        ]
                    );
                }
            }
        }
    }

    /**
     * Seed 8 Master Layanan Utama beserta Dokumen Persyaratan Dinamisnya.
     */
    private function seedServicesAndRequirements(): void
    {
        $services = [
            // 1. Pembuatan KIA (Full Digital)
            [
                'kode_layanan'           => 'KIA',
                'nama_layanan'           => 'Pembuatan Kartu Identitas Anak (KIA)',
                'deskripsi'              => 'Pengajuan penerbitan Kartu Identitas Anak untuk anak usia 0-17 tahun kurang satu hari yang belum menikah.',
                'jenis_proses'           => ServiceProcessType::FullDigital,
                'template_formulir_path' => null,
                'ikon'                   => 'identification',
                'urutan'                 => 1,
                'requirements'           => [
                    ['nama' => 'Kartu Keluarga (KK)', 'deskripsi' => 'Scan/Foto Kartu Keluarga orang tua yang masih berlaku (asli)', 'wajib' => true, 'formats' => ['pdf', 'jpg', 'jpeg', 'png']],
                    ['nama' => 'Akta Kelahiran Anak', 'deskripsi' => 'Scan/Foto Akta Kelahiran anak yang diajukan', 'wajib' => true, 'formats' => ['pdf', 'jpg', 'jpeg', 'png']],
                    ['nama' => 'KTP Elektronik Orang Tua', 'deskripsi' => 'Scan/Foto e-KTP kedua orang tua/wali', 'wajib' => true, 'formats' => ['pdf', 'jpg', 'jpeg', 'png']],
                    ['nama' => 'Pas Foto Anak (Usia > 5 Tahun)', 'deskripsi' => 'Pas foto ukuran 3x4 latar belakang merah/biru (khusus anak usia di atas 5 tahun)', 'wajib' => false, 'formats' => ['jpg', 'jpeg', 'png']],
                ],
            ],

            // 2. Perekaman E-KTP (Hybrid)
            [
                'kode_layanan'           => 'EKTP',
                'nama_layanan'           => 'Perekaman E-KTP (KTP Elektronik)',
                'deskripsi'              => 'Pendaftaran online dan booking jadwal antrean perekaman data biometrik (sidik jari, iris mata, foto) di kantor kecamatan.',
                'jenis_proses'           => ServiceProcessType::Hybrid,
                'template_formulir_path' => null,
                'ikon'                   => 'fingerprint',
                'urutan'                 => 2,
                'requirements'           => [
                    ['nama' => 'Kartu Keluarga (KK)', 'deskripsi' => 'Scan/Foto asli Kartu Keluarga yang mencantumkan nama pemohon', 'wajib' => true, 'formats' => ['pdf', 'jpg', 'jpeg', 'png']],
                    ['nama' => 'Surat Pengantar RT/RW (Jika Diperlukan)', 'deskripsi' => 'Scan surat pengantar dari RT/RW setempat (opsional jika sudah terdaftar di database)', 'wajib' => false, 'formats' => ['pdf', 'jpg', 'png']],
                ],
            ],

            // 3. Pembuatan KK Baru (Hybrid)
            [
                'kode_layanan'           => 'KK_BARU',
                'nama_layanan'           => 'Pembuatan Kartu Keluarga (KK) Baru',
                'deskripsi'              => 'Pengajuan penerbitan Kartu Keluarga baru untuk pasangan yang baru menikah atau pembentukan keluarga baru.',
                'jenis_proses'           => ServiceProcessType::Hybrid,
                'template_formulir_path' => 'templates/f101_permohonan_kk_baru.pdf',
                'ikon'                   => 'users',
                'urutan'                 => 3,
                'requirements'           => [
                    ['nama' => 'Formulir F-1.01 Desa', 'deskripsi' => 'Unduh template, bawa ke Desa untuk ditandatangani dan dicap, lalu unggah kembali scan aslinya', 'wajib' => true, 'formats' => ['pdf', 'jpg', 'jpeg', 'png']],
                    ['nama' => 'Buku Nikah / Kutipan Akta Perkawinan', 'deskripsi' => 'Scan Buku Nikah / Akta Perkawinan resmi dari KUA / Catatan Sipil', 'wajib' => true, 'formats' => ['pdf', 'jpg', 'jpeg', 'png']],
                    ['nama' => 'KK Asli Masing-masing Orang Tua', 'deskripsi' => 'Scan Kartu Keluarga orang tua dari kedua belah pihak', 'wajib' => true, 'formats' => ['pdf', 'jpg', 'jpeg', 'png']],
                    ['nama' => 'KTP Elektronik Pasangan', 'deskripsi' => 'Scan e-KTP suami dan istri', 'wajib' => true, 'formats' => ['pdf', 'jpg', 'jpeg', 'png']],
                ],
            ],

            // 4. Perbaikan KK - Penambahan Anggota (Full Digital)
            [
                'kode_layanan'           => 'KK_ADD',
                'nama_layanan'           => 'Perbaikan KK - Penambahan Anggota Keluarga',
                'deskripsi'              => 'Pengajuan penambahan anggota keluarga pada KK yang sudah ada (kelahiran anak, kepindahan masuk, dll.).',
                'jenis_proses'           => ServiceProcessType::FullDigital,
                'template_formulir_path' => null,
                'ikon'                   => 'user-plus',
                'urutan'                 => 4,
                'requirements'           => [
                    ['nama' => 'Kartu Keluarga (KK) Lama', 'deskripsi' => 'Scan/Foto Kartu Keluarga lama yang akan diperbarui', 'wajib' => true, 'formats' => ['pdf', 'jpg', 'jpeg', 'png']],
                    ['nama' => 'Surat Keterangan Kelahiran / Akta Lahir', 'deskripsi' => 'Scan Surat Kelahiran dari Bidan/RS atau Akta Kelahiran anggota baru', 'wajib' => true, 'formats' => ['pdf', 'jpg', 'jpeg', 'png']],
                    ['nama' => 'Buku Nikah Orang Tua', 'deskripsi' => 'Scan Buku Nikah legalisir atau asli', 'wajib' => true, 'formats' => ['pdf', 'jpg', 'jpeg', 'png']],
                ],
            ],

            // 5. Perbaikan KK - Pengurangan Anggota (Full Digital)
            [
                'kode_layanan'           => 'KK_DEL',
                'nama_layanan'           => 'Perbaikan KK - Pengurangan Anggota Keluarga',
                'deskripsi'              => 'Pengajuan pengurangan anggota keluarga pada Kartu Keluarga karena alasan meninggal dunia atau perceraian.',
                'jenis_proses'           => ServiceProcessType::FullDigital,
                'template_formulir_path' => null,
                'ikon'                   => 'user-minus',
                'urutan'                 => 5,
                'requirements'           => [
                    ['nama' => 'Kartu Keluarga (KK) Lama', 'deskripsi' => 'Scan Kartu Keluarga lama yang masih mencantumkan anggota yang bersangkutan', 'wajib' => true, 'formats' => ['pdf', 'jpg', 'jpeg', 'png']],
                    ['nama' => 'Surat Kematian / Akta Cerai', 'deskripsi' => 'Scan Surat Kematian dari Desa/RS (jika meninggal) ATAU Akta Cerai dari Pengadilan Agama (jika cerai)', 'wajib' => true, 'formats' => ['pdf', 'jpg', 'jpeg', 'png']],
                    ['nama' => 'e-KTP Pemohon', 'deskripsi' => 'Scan e-KTP kepala keluarga / pemohon', 'wajib' => true, 'formats' => ['pdf', 'jpg', 'jpeg', 'png']],
                ],
            ],

            // 6. Surat Pindah Antar Kecamatan (Hybrid)
            [
                'kode_layanan'           => 'PINDAH',
                'nama_layanan'           => 'Surat Pindah Antar Kecamatan (SKPWNI)',
                'deskripsi'              => 'Pengajuan Surat Keterangan Pindah Warga Negara Indonesia (SKPWNI) antar wilayah kecamatan dalam Kabupaten Tasikmalaya.',
                'jenis_proses'           => ServiceProcessType::Hybrid,
                'template_formulir_path' => 'templates/f108_surat_pindah.pdf',
                'ikon'                   => 'truck',
                'urutan'                 => 6,
                'requirements'           => [
                    ['nama' => 'Formulir Permohonan Pindah Desa (F-1.08)', 'deskripsi' => 'Unduh formulir, tandatangani di kantor Desa asal, lalu unggah hasil scan bertanda tangan & stempel basah', 'wajib' => true, 'formats' => ['pdf', 'jpg', 'jpeg', 'png']],
                    ['nama' => 'Kartu Keluarga Asli', 'deskripsi' => 'Scan Kartu Keluarga asal', 'wajib' => true, 'formats' => ['pdf', 'jpg', 'jpeg', 'png']],
                    ['nama' => 'e-KTP Pemohon & Anggota yang Pindah', 'deskripsi' => 'Scan e-KTP seluruh anggota keluarga yang ikut pindah domisili', 'wajib' => true, 'formats' => ['pdf', 'jpg', 'jpeg', 'png']],
                    ['nama' => 'Pas Foto Ukuran 3x4 (2 Lembar)', 'deskripsi' => 'Foto berwarna terbaru dengan latar belakang merah atau biru', 'wajib' => true, 'formats' => ['jpg', 'jpeg', 'png']],
                ],
            ],

            // 7. Surat Dispensasi Nikah (Hybrid)
            [
                'kode_layanan'           => 'NIKAH',
                'nama_layanan'           => 'Surat Dispensasi / Rekomendasi Nikah',
                'deskripsi'              => 'Pengajuan Surat Rekomendasi/Dispensasi Pernikahan bagi warga yang akan melangsungkan akad di luar kecamatan atau waktu mendesak.',
                'jenis_proses'           => ServiceProcessType::Hybrid,
                'template_formulir_path' => 'templates/n1_n4_rekomendasi_nikah.pdf',
                'ikon'                   => 'heart',
                'urutan'                 => 7,
                'requirements'           => [
                    ['nama' => 'Formulir N1 - N4 dari Desa', 'deskripsi' => 'Unduh form N1-N4, lengkapi tanda tangan dan stempel Kepala Desa/Kelurahan setempat', 'wajib' => true, 'formats' => ['pdf', 'jpg', 'jpeg', 'png']],
                    ['nama' => 'Surat Pengantar / Rekomendasi KUA Asal', 'deskripsi' => 'Scan surat pengantar resmi dari Kantor Urusan Agama (KUA) kecamatan domisili', 'wajib' => true, 'formats' => ['pdf', 'jpg', 'jpeg', 'png']],
                    ['nama' => 'e-KTP Calon Pengantin & Orang Tua', 'deskripsi' => 'Scan e-KTP kedua calon pengantin dan orang tua/wali', 'wajib' => true, 'formats' => ['pdf', 'jpg', 'jpeg', 'png']],
                    ['nama' => 'Kartu Keluarga (KK)', 'deskripsi' => 'Scan Kartu Keluarga calon pengantin', 'wajib' => true, 'formats' => ['pdf', 'jpg', 'jpeg', 'png']],
                    ['nama' => 'Pas Foto Berdampingan 4x6 (Latar Biru)', 'deskripsi' => 'Foto berdampingan calon pengantin berlatar belakang biru', 'wajib' => true, 'formats' => ['jpg', 'jpeg', 'png']],
                ],
            ],

            // 8. Surat Keterangan Lainnya (Dynamic Service Engine)
            [
                'kode_layanan'           => 'LAINNYA',
                'nama_layanan'           => 'Surat Keterangan Umum & Administrasi Lainnya',
                'deskripsi'              => 'Pengajuan berbagai surat keterangan umum dari kecamatan (keterangan belum menikah, keterangan beda nama, dll.) secara fleksibel.',
                'jenis_proses'           => ServiceProcessType::FullDigital,
                'template_formulir_path' => null,
                'ikon'                   => 'document-text',
                'urutan'                 => 8,
                'requirements'           => [
                    ['nama' => 'Surat Pengantar dari Desa / Kelurahan', 'deskripsi' => 'Scan surat pengantar resmi dari Kantor Desa mengenai perihal surat yang dibutuhkan', 'wajib' => true, 'formats' => ['pdf', 'jpg', 'jpeg', 'png']],
                    ['nama' => 'Kartu Tanda Penduduk (e-KTP)', 'deskripsi' => 'Scan/Foto e-KTP pemohon yang masih berlaku', 'wajib' => true, 'formats' => ['pdf', 'jpg', 'jpeg', 'png']],
                    ['nama' => 'Kartu Keluarga (KK)', 'deskripsi' => 'Scan Kartu Keluarga pemohon', 'wajib' => true, 'formats' => ['pdf', 'jpg', 'jpeg', 'png']],
                    ['nama' => 'Dokumen Pendukung Tambahan', 'deskripsi' => 'Scan dokumen pendukung sesuai jenis surat (ijazah, sertifikat, dll.)', 'wajib' => false, 'formats' => ['pdf', 'jpg', 'jpeg', 'png']],
                ],
            ],
        ];

        foreach ($services as $serviceData) {
            $requirements = $serviceData['requirements'];
            unset($serviceData['requirements']);

            $service = Service::updateOrCreate(
                ['kode_layanan' => $serviceData['kode_layanan']],
                $serviceData
            );

            foreach ($requirements as $index => $req) {
                ServiceRequirement::updateOrCreate(
                    [
                        'service_id'       => $service->id,
                        'nama_persyaratan' => $req['nama'],
                    ],
                    [
                        'deskripsi'        => $req['deskripsi'],
                        'is_required'      => $req['wajib'],
                        'urutan'           => $index + 1,
                        'accepted_formats' => $req['formats'],
                        'max_size_kb'      => 5120, // 5MB
                    ]
                );
            }
        }
    }
}
