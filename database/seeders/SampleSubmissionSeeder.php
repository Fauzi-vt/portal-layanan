<?php

namespace Database\Seeders;

use App\Enums\SubmissionStatus;
use App\Models\Kecamatan;
use App\Models\Service;
use App\Models\Submission;
use App\Models\SubmissionDocument;
use App\Models\User;
use Illuminate\Database\Seeder;

class SampleSubmissionSeeder extends Seeder
{
    /**
     * Seed sample submissions for each registered citizen so all status menus have data:
     * - Terkirim (Proses) [submitted / in_review / processed]
     * - Ditolak / Revisi [revision_required / rejected]
     * - Terbit (Selesai) [completed]
     */
    public function run(): void
    {
        $manonjaya = Kecamatan::where('kode_kecamatan', 'KEC-017')->first() ?? Kecamatan::first();
        if (!$manonjaya) {
            return;
        }

        $wargaUsers = User::where('role', 'warga')->get();
        if ($wargaUsers->isEmpty()) {
            return;
        }

        $serviceEktp = Service::where('kode_layanan', 'EKTP')->first();
        $serviceKia = Service::where('kode_layanan', 'KIA')->first();
        $serviceKkBaru = Service::where('kode_layanan', 'KK_BARU')->first();
        $serviceDatang = Service::where('kode_layanan', 'DATANG')->first();

        foreach ($wargaUsers as $warga) {
            // 1. Permohonan Terkirim / Proses
            $activeSub = Submission::where('user_id', $warga->id)
                ->whereIn('status', [SubmissionStatus::Submitted, SubmissionStatus::InReview, SubmissionStatus::Processed])
                ->first();

            if (!$activeSub) {
                $targetService = $serviceDatang ?? $serviceEktp ?? Service::first();
                $ticket = 'TKT-' . date('Ymd') . '-' . str_pad($manonjaya->id, 2, '0', STR_PAD_LEFT) . '-' . str_pad($warga->id . '01', 4, '0', STR_PAD_LEFT);

                $sub = Submission::updateOrCreate(
                    ['nomor_tiket' => $ticket],
                    [
                        'user_id'         => $warga->id,
                        'kecamatan_id'    => $manonjaya->id,
                        'service_id'      => $targetService->id,
                        'status'          => SubmissionStatus::Submitted,
                        'catatan_petugas' => 'Berkas telah diterima sistem dan masuk dalam antrean verifikasi petugas.',
                        'form_data'       => null,
                        'created_at'      => now()->subHours(4),
                        'updated_at'      => now()->subHours(4),
                    ]
                );

                $this->attachDummyDocuments($sub, $targetService);
            }

            // 2. Permohonan Perlu Revisi / Ditolak
            $revisionSub = Submission::where('user_id', $warga->id)
                ->whereIn('status', [SubmissionStatus::RevisionRequired, SubmissionStatus::Rejected])
                ->first();

            if (!$revisionSub) {
                $targetService = $serviceKia ?? Service::first();
                $ticket = 'TKT-' . date('Ymd') . '-' . str_pad($manonjaya->id, 2, '0', STR_PAD_LEFT) . '-' . str_pad($warga->id . '02', 4, '0', STR_PAD_LEFT);

                $sub = Submission::updateOrCreate(
                    ['nomor_tiket' => $ticket],
                    [
                        'user_id'         => $warga->id,
                        'kecamatan_id'    => $manonjaya->id,
                        'service_id'      => $targetService->id,
                        'status'          => SubmissionStatus::RevisionRequired,
                        'catatan_petugas' => 'Scan/Foto Kartu Keluarga yang diunggah buram dan terpotong pada bagian tanda tangan kepala dinas. Mohon unggah ulang foto asli dokumen dengan jelas.',
                        'form_data'       => null,
                        'created_at'      => now()->subDays(1),
                        'updated_at'      => now()->subHours(2),
                    ]
                );

                $this->attachDummyDocuments($sub, $targetService);
            }

            // 3. Permohonan Terbit / Selesai
            $completedSub = Submission::where('user_id', $warga->id)
                ->where('status', SubmissionStatus::Completed)
                ->first();

            if (!$completedSub) {
                $targetService = $serviceKkBaru ?? Service::first();
                $ticket = 'TKT-' . date('Ymd', strtotime('-3 days')) . '-' . str_pad($manonjaya->id, 2, '0', STR_PAD_LEFT) . '-' . str_pad($warga->id . '03', 4, '0', STR_PAD_LEFT);

                $sub = Submission::updateOrCreate(
                    ['nomor_tiket' => $ticket],
                    [
                        'user_id'              => $warga->id,
                        'kecamatan_id'         => $manonjaya->id,
                        'service_id'           => $targetService->id,
                        'status'               => SubmissionStatus::Completed,
                        'catatan_petugas'      => 'Permohonan telah diverifikasi dan disetujui. Dokumen resmi telah diterbitkan secara digital.',
                        'output_document_path' => 'outputs/dokumen_terbit_' . $ticket . '.pdf',
                        'form_data'            => [
                            'f101' => [
                                'jenis_pilihan'        => 'wni',
                                'nama_kepala_keluarga' => $warga->name,
                                'nik_kepala_keluarga'  => $warga->nik ?? '3206171505980001',
                                'alamat'               => $warga->alamat_detail ?? 'Kp. Kaum Wetan RT 002 RW 004 No. 15',
                                'rt'                   => '002',
                                'rw'                   => '004',
                                'kode_pos'             => '46182',
                                'telepon'              => $warga->phone ?? '085712345678',
                                'email'                => $warga->email,
                                'nama_provinsi'        => '32 - JAWA BARAT',
                                'nama_kabupaten'       => '06 - KAB. TASIKMALAYA',
                                'nama_kecamatan'       => 'MANONJAYA',
                                'nama_desa'            => 'MANONJAYA',
                                'nama_dusun'           => 'KP. KAUM WETAN',
                                'jumlah_anggota'       => 3,
                                'anggota'              => [
                                    [
                                        'nama'          => $warga->name,
                                        'nik'           => $warga->nik ?? '3206171505980001',
                                        'jenis_kelamin' => 'L',
                                        'tempat_lahir'  => 'Tasikmalaya',
                                        'tanggal_lahir' => '1998-05-15',
                                        'gol_darah'     => 'O',
                                        'agama'         => 'Islam',
                                        'status_kawin'  => 'Kawin Tercatat',
                                        'shdk'          => 'Kepala Keluarga',
                                        'pendidikan'    => 'Diploma IV / Strata I',
                                        'pekerjaan'     => 'Karyawan Swasta',
                                        'no_akta_lahir' => '3206-LT-15051998-0021',
                                        'no_buku_nikah' => '0145/012/VI/2023',
                                        'tgl_nikah'     => '2023-06-10',
                                        'nama_ibu'      => 'SITI AMINAH',
                                        'nik_ibu'       => '3206174502700001',
                                        'nama_ayah'     => 'ABDUL RAHMAN',
                                        'nik_ayah'      => '3206171203680001',
                                        'disabilitas'   => 'Tidak Ada',
                                    ],
                                    [
                                        'nama'          => 'NURUL HIDAYAH',
                                        'nik'           => '3206175408990002',
                                        'jenis_kelamin' => 'P',
                                        'tempat_lahir'  => 'Tasikmalaya',
                                        'tanggal_lahir' => '1999-08-14',
                                        'gol_darah'     => 'A',
                                        'agama'         => 'Islam',
                                        'status_kawin'  => 'Kawin Tercatat',
                                        'shdk'          => 'Istri',
                                        'pendidikan'    => 'SLTA / Sederajat',
                                        'pekerjaan'     => 'Mengurus Rumah Tangga',
                                        'no_akta_lahir' => '3206-LT-14081999-0015',
                                        'no_buku_nikah' => '0145/012/VI/2023',
                                        'tgl_nikah'     => '2023-06-10',
                                        'nama_ibu'      => 'ROHAYATI',
                                        'nik_ibu'       => '3206176504720003',
                                        'nama_ayah'     => 'MAMAN SUPARMAN',
                                        'nik_ayah'      => '3206170809690002',
                                        'disabilitas'   => 'Tidak Ada',
                                    ],
                                    [
                                        'nama'          => 'MUHAMMAD AL FATIH',
                                        'nik'           => '3206171201240001',
                                        'jenis_kelamin' => 'L',
                                        'tempat_lahir'  => 'Tasikmalaya',
                                        'tanggal_lahir' => '2024-01-12',
                                        'gol_darah'     => 'O',
                                        'agama'         => 'Islam',
                                        'status_kawin'  => 'Belum Kawin',
                                        'shdk'          => 'Anak',
                                        'pendidikan'    => 'Tidak / Belum Sekolah',
                                        'pekerjaan'     => 'Belum / Tidak Bekerja',
                                        'no_akta_lahir' => '3206-LT-12012024-0005',
                                        'nama_ibu'      => 'NURUL HIDAYAH',
                                        'nik_ibu'       => '3206175408990002',
                                        'nama_ayah'     => $warga->name,
                                        'nik_ayah'      => $warga->nik ?? '3206171505980001',
                                        'disabilitas'   => 'Tidak Ada',
                                    ]
                                ]
                            ]
                        ],
                        'created_at'           => now()->subDays(3),
                        'updated_at'           => now()->subDays(1),
                    ]
                );

                $this->attachDummyDocuments($sub, $targetService);
            }
        }
    }

    private function attachDummyDocuments(Submission $submission, Service $service): void
    {
        $requirements = $service->requirements()->get();
        foreach ($requirements as $req) {
            SubmissionDocument::updateOrCreate(
                [
                    'submission_id'          => $submission->id,
                    'service_requirement_id' => $req->id,
                ],
                [
                    'file_path'       => 'documents/sample_' . $req->id . '.pdf',
                    'file_name'       => $req->nama_persyaratan . '.pdf',
                    'file_size'       => 1024 * 512, // 512 KB
                    'mime_type'       => 'application/pdf',
                    'status_validasi' => $submission->status === SubmissionStatus::RevisionRequired ? 'invalid' : 'valid',
                    'catatan_dokumen' => $submission->status === SubmissionStatus::RevisionRequired ? 'Dokumen buram, harap perbaiki' : null,
                ]
            );
        }
    }
}
