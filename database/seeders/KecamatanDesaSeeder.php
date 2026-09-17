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
     * Seed 39 Kecamatan di Kabupaten Tasikmalaya beserta seluruh 351 Desa/Kelurahan resmi.
     */
    private function seedKecamatansAndDesas(): void
    {
        $jsonPath = database_path('data/wilayah_tasikmalaya.json');
        if (file_exists($jsonPath)) {
            $wilayahData = json_decode(file_get_contents($jsonPath), true);
            foreach ($wilayahData as $kData) {
                $kecamatan = Kecamatan::updateOrCreate(
                    ['kode_kecamatan' => $kData['kode_kecamatan']],
                    [
                        'nama_kecamatan'  => $kData['nama_kecamatan'],
                        'alamat_kantor'   => $kData['alamat_kantor'] ?? "Jl. Raya {$kData['nama_kecamatan']} No. 1, Kab. Tasikmalaya",
                        'email'           => $kData['email'],
                        'telepon'         => $kData['telepon'],
                        'jam_operasional' => $kData['jam_operasional'] ?? 'Senin - Jumat, 08.00 - 15.30 WIB',
                    ]
                );

                foreach ($kData['desas'] as $dData) {
                    Desa::updateOrCreate(
                        ['kode_desa' => $dData['kode_desa']],
                        [
                            'kecamatan_id' => $kecamatan->id,
                            'nama_desa'    => $dData['nama_desa'],
                            'jumlah_rw'    => $dData['jumlah_rw'] ?? 6,
                            'jumlah_rt'    => $dData['jumlah_rt'] ?? 30,
                        ]
                    );
                }

                $kecamatan->jumlah_desa = $kecamatan->desas()->count();
                $kecamatan->jumlah_rw = $kecamatan->desas()->sum('jumlah_rw');
                $kecamatan->jumlah_rt = $kecamatan->desas()->sum('jumlah_rt');
                $kecamatan->save();
            }
            return;
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

            // 6. Permohonan Pindah Datang WNI (Satu Desa)
            [
                'kode_layanan'           => 'PINDAH_SATU_DESA',
                'nama_layanan'           => 'Permohonan Pindah Datang WNI (Satu Desa)',
                'deskripsi'              => 'Pengajuan permohonan pindah datang WNI dalam satu wilayah desa/kelurahan yang sama.',
                'jenis_proses'           => ServiceProcessType::Hybrid,
                'template_formulir_path' => 'templates/f108_surat_pindah.pdf',
                'ikon'                   => 'truck',
                'urutan'                 => 6,
                'requirements'           => [
                    ['nama' => 'Kartu Keluarga (KK) Asli Pemohon', 'deskripsi' => 'Scan/Foto Kartu Keluarga asal yang mencantumkan nama pemohon', 'wajib' => true, 'formats' => ['pdf', 'jpg', 'jpeg', 'png']],
                    ['nama' => 'e-KTP Pemohon & Anggota Pindah', 'deskripsi' => 'Scan e-KTP pemohon dan seluruh anggota keluarga yang ikut pindah alamat', 'wajib' => true, 'formats' => ['pdf', 'jpg', 'jpeg', 'png']],
                    ['nama' => 'Surat Pengantar RT/RW / Kepala Dusun', 'deskripsi' => 'Scan surat pengantar mengenai perpindahan RT/RW atau dusun', 'wajib' => true, 'formats' => ['pdf', 'jpg', 'jpeg', 'png']],
                ],
            ],

            // 7. Permohonan Pindah Datang WNI (Antar Desa Satu Kecamatan)
            [
                'kode_layanan'           => 'PINDAH_ANTAR_DESA',
                'nama_layanan'           => 'Permohonan Pindah Datang WNI (Antar Desa Satu Kecamatan)',
                'deskripsi'              => 'Pengajuan permohonan pindah datang WNI antar desa/kelurahan dalam satu wilayah kecamatan yang sama.',
                'jenis_proses'           => ServiceProcessType::Hybrid,
                'template_formulir_path' => 'templates/f108_surat_pindah.pdf',
                'ikon'                   => 'truck',
                'urutan'                 => 7,
                'requirements'           => [
                    ['nama' => 'Kartu Keluarga (KK) Asli Pemohon', 'deskripsi' => 'Scan Kartu Keluarga asal pemohon', 'wajib' => true, 'formats' => ['pdf', 'jpg', 'jpeg', 'png']],
                    ['nama' => 'Surat Keterangan Pindah Desa Asal', 'deskripsi' => 'Scan Surat Pengantar Pindah dari Kepala Desa / Lurah asal', 'wajib' => true, 'formats' => ['pdf', 'jpg', 'jpeg', 'png']],
                    ['nama' => 'e-KTP Pemohon & Anggota yang Pindah', 'deskripsi' => 'Scan e-KTP anggota keluarga yang ikut pindah domisili', 'wajib' => true, 'formats' => ['pdf', 'jpg', 'jpeg', 'png']],
                ],
            ],

            // 8. Permohonan Pindah Datang WNI (Antar Kecamatan Satu Kabupaten)
            [
                'kode_layanan'           => 'PINDAH_ANTAR_KEC',
                'nama_layanan'           => 'Permohonan Pindah Datang WNI (Antar Kecamatan Satu Kabupaten)',
                'deskripsi'              => 'Pengajuan permohonan pindah datang WNI antar wilayah kecamatan dalam Kabupaten Tasikmalaya.',
                'jenis_proses'           => ServiceProcessType::Hybrid,
                'template_formulir_path' => 'templates/f108_surat_pindah.pdf',
                'ikon'                   => 'truck',
                'urutan'                 => 8,
                'requirements'           => [
                    ['nama' => 'Surat Keterangan Pindah (SKPWNI) dari Kecamatan Asal', 'deskripsi' => 'Scan/foto resmi Surat Keterangan Pindah WNI (SKPWNI) dari kecamatan asal', 'wajib' => true, 'formats' => ['pdf', 'jpg', 'jpeg', 'png']],
                    ['nama' => 'Kartu Keluarga (KK) Asli Pemohon', 'deskripsi' => 'Scan Kartu Keluarga asal', 'wajib' => true, 'formats' => ['pdf', 'jpg', 'jpeg', 'png']],
                    ['nama' => 'e-KTP Pemohon & Anggota yang Pindah', 'deskripsi' => 'Scan e-KTP pemohon dan seluruh anggota keluarga', 'wajib' => true, 'formats' => ['pdf', 'jpg', 'jpeg', 'png']],
                ],
            ],

            // 8. Surat Dispensasi Nikah (Hybrid)
            [
                'kode_layanan'           => 'NIKAH',
                'nama_layanan'           => 'Surat Dispensasi / Rekomendasi Nikah',
                'deskripsi'              => 'Pengajuan Surat Rekomendasi/Dispensasi Pernikahan bagi warga yang akan melangsungkan akad di luar kecamatan atau waktu mendesak.',
                'jenis_proses'           => ServiceProcessType::Hybrid,
                'template_formulir_path' => 'templates/n1_n4_rekomendasi_nikah.pdf',
                'ikon'                   => 'heart',
                'urutan'                 => 8,
                'requirements'           => [
                    ['nama' => 'Formulir N1 - N4 dari Desa', 'deskripsi' => 'Unduh form N1-N4, lengkapi tanda tangan dan stempel Kepala Desa/Kelurahan setempat', 'wajib' => true, 'formats' => ['pdf', 'jpg', 'jpeg', 'png']],
                    ['nama' => 'Surat Pengantar / Rekomendasi KUA Asal', 'deskripsi' => 'Scan surat pengantar resmi dari Kantor Urusan Agama (KUA) kecamatan domisili', 'wajib' => true, 'formats' => ['pdf', 'jpg', 'jpeg', 'png']],
                    ['nama' => 'e-KTP Calon Pengantin & Orang Tua', 'deskripsi' => 'Scan e-KTP kedua calon pengantin dan orang tua/wali', 'wajib' => true, 'formats' => ['pdf', 'jpg', 'jpeg', 'png']],
                    ['nama' => 'Kartu Keluarga (KK)', 'deskripsi' => 'Scan Kartu Keluarga calon pengantin', 'wajib' => true, 'formats' => ['pdf', 'jpg', 'jpeg', 'png']],
                    ['nama' => 'Pas Foto Berdampingan 4x6 (Latar Biru)', 'deskripsi' => 'Foto berdampingan calon pengantin berlatar belakang biru', 'wajib' => true, 'formats' => ['jpg', 'jpeg', 'png']],
                ],
            ],

            // 9. Surat Keterangan Lainnya (Dynamic Service Engine)
            [
                'kode_layanan'           => 'LAINNYA',
                'nama_layanan'           => 'Surat Keterangan Umum & Administrasi Lainnya',
                'deskripsi'              => 'Pengajuan berbagai surat keterangan umum dari kecamatan (keterangan belum menikah, keterangan beda nama, dll.) secara fleksibel.',
                'jenis_proses'           => ServiceProcessType::FullDigital,
                'template_formulir_path' => null,
                'ikon'                   => 'document-text',
                'urutan'                 => 9,
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
