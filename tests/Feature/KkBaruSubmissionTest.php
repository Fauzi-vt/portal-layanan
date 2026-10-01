<?php

namespace Tests\Feature;

use App\Enums\SubmissionStatus;
use App\Enums\UserRole;
use App\Models\Desa;
use App\Models\Kecamatan;
use App\Models\Service;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class KkBaruSubmissionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\KecamatanDesaSeeder::class);
        Storage::fake('public');
    }

    protected function makeWargaUser(): array
    {
        $manonjaya = Kecamatan::where('kode_kecamatan', 'KEC-017')->first();
        $desaManonjaya = Desa::where('kecamatan_id', $manonjaya->id)->first();

        $warga = User::factory()->create([
            'role' => UserRole::Warga,
            'name' => 'Fauzi Pemohon KK',
            'nik' => '3206172005950001',
            'email' => 'fauzi.' . uniqid() . '@example.com',
            'phone' => '081234567890',
            'kecamatan_id' => $manonjaya->id,
            'desa_id' => $desaManonjaya->id,
            'alamat_detail' => 'Jl. Pahlawan Manonjaya No. 12',
        ]);

        return [$warga, $manonjaya, $desaManonjaya];
    }

    public function test_kk_baru_form_renders_with_digital_stepper(): void
    {
        [$warga, $manonjaya, $desaManonjaya] = $this->makeWargaUser();

        $response = $this->actingAs($warga)
            ->get(route('warga.submissions.create', ['service' => 'KK_BARU']));

        $response->assertOk();
        $response->assertSee('Data Pemohon');
        $response->assertSee('Data diri Anda sebagai pemohon layanan.');
        $response->assertSee('Data ini diambil dari profil akun Anda.');
        $response->assertSee('Data Kepala Keluarga');
        $response->assertSee('Masukkan data kepala keluarga dan alamat tempat tinggal.');
        $response->assertSee('Anggota Keluarga');
        $response->assertSee('Tambahkan anggota keluarga yang akan tercantum dalam KK.');
        $response->assertSee('+ Tambah Anggota Keluarga');
        $response->assertSee('Dokumen Pendukung');
        $response->assertSee('Lengkapi dokumen berikut untuk melanjutkan permohonan.');
        $response->assertSee('Review Permohonan');
        $response->assertSee('Fauzi Pemohon KK');
        $response->assertSee('3206172005950001');

        // Pastikan pola fisik kaku sudah dihilangkan dari UI warga
        $response->assertDontSee('(1) Nama Lengkap');
        $response->assertDontSee('(17) Nama Ibu');
        $response->assertDontSee('(12) Hubungan Keluarga (SHDK)');
        $response->assertDontSee('Terapkan ke Tabel (Apply)');
        $response->assertDontSee('Terapkan ke Tabel');
    }

    public function test_kk_baru_draft_accepted(): void
    {
        [$warga, $manonjaya, $desaManonjaya] = $this->makeWargaUser();
        $service = Service::where('kode_layanan', 'KK_BARU')->first();

        $payload = [
            'service_id' => $service->id,
            'kecamatan_id' => $manonjaya->id,
            'submit_now' => '0',
            'form_data' => [
                'f101' => [
                    'nama_pemohon' => 'Fauzi Pemohon KK',
                    'nik_pemohon' => '3206172005950001',
                    'nama_kepala_keluarga' => 'Fauzi Pemohon KK',
                    'alamat' => 'Jl. Pahlawan Manonjaya No. 12',
                    'rt' => '002',
                    'rw' => '003',
                    'kode_pos' => '46182',
                    'nama_desa' => $desaManonjaya->nama_desa,
                    'nama_kecamatan' => $manonjaya->nama_kecamatan,
                    'nama_kabupaten' => 'KABUPATEN TASIKMALAYA',
                    'nama_provinsi' => 'JAWA BARAT',
                    'negara' => 'INDONESIA',
                    'jumlah_anggota' => '1',
                    'anggota' => [
                        [
                            'nama' => 'Fauzi Pemohon KK',
                            'nik' => '3206172005950001',
                            'jenis_kelamin' => 'LAKI-LAKI',
                            'tempat_lahir' => 'TASIKMALAYA',
                            'tanggal_lahir' => '1995-05-20',
                            'agama' => 'ISLAM',
                            'pendidikan' => 'SLTA / SEDERAJAT',
                            'pekerjaan' => 'WIRASWASTA',
                            'gol_darah' => 'O',
                            'status_kawin' => 'KAWIN TERCATAT',
                            'tgl_kawin' => '2020-08-17',
                            'shdk' => 'KEPALA KELUARGA',
                            'kewarganegaraan' => 'WNI',
                            'no_paspor' => '',
                            'no_kitap' => '',
                            'nama_ayah' => 'SULAEMAN',
                            'nama_ibu' => 'AMINAH',
                        ]
                    ]
                ]
            ]
        ];

        $response = $this->actingAs($warga)
            ->post(route('warga.submissions.store'), $payload);

        $submission = Submission::where('user_id', $warga->id)->first();
        $this->assertNotNull($submission);
        $this->assertEquals(SubmissionStatus::Draft, $submission->status);
        $this->assertArrayHasKey('f101', $submission->form_data);
        $this->assertEquals('Fauzi Pemohon KK', $submission->form_data['f101']['nama_kepala_keluarga']);
        $this->assertCount(1, $submission->form_data['f101']['anggota']);
        $response->assertRedirect(route('warga.submissions.show', $submission));
    }

    public function test_kk_baru_valid_submission_accepted(): void
    {
        [$warga, $manonjaya, $desaManonjaya] = $this->makeWargaUser();
        $service = Service::where('kode_layanan', 'KK_BARU')->first();

        $documents = [];
        foreach ($service->requirements as $req) {
            $documents[$req->id] = UploadedFile::fake()->create('berkas_' . $req->id . '.pdf', 500, 'application/pdf');
        }

        $payload = [
            'service_id' => $service->id,
            'kecamatan_id' => $manonjaya->id,
            'submit_now' => '1',
            'form_data' => [
                'f101' => [
                    'nama_pemohon' => 'Fauzi Pemohon KK',
                    'nik_pemohon' => '3206172005950001',
                    'nama_kepala_keluarga' => 'Fauzi Pemohon KK',
                    'alamat' => 'Jl. Pahlawan Manonjaya No. 12',
                    'rt' => '002',
                    'rw' => '003',
                    'kode_pos' => '46182',
                    'nama_desa' => $desaManonjaya->nama_desa,
                    'nama_kecamatan' => $manonjaya->nama_kecamatan,
                    'nama_kabupaten' => 'KABUPATEN TASIKMALAYA',
                    'nama_provinsi' => 'JAWA BARAT',
                    'negara' => 'INDONESIA',
                    'jumlah_anggota' => '2',
                    'anggota' => [
                        [
                            'nama' => 'Fauzi Pemohon KK',
                            'nik' => '3206172005950001',
                            'jenis_kelamin' => 'LAKI-LAKI',
                            'tempat_lahir' => 'TASIKMALAYA',
                            'tanggal_lahir' => '1995-05-20',
                            'agama' => 'ISLAM',
                            'pendidikan' => 'SLTA / SEDERAJAT',
                            'pekerjaan' => 'WIRASWASTA',
                            'gol_darah' => 'O',
                            'status_kawin' => 'KAWIN TERCATAT',
                            'tgl_kawin' => '2020-08-17',
                            'shdk' => 'KEPALA KELUARGA',
                            'kewarganegaraan' => 'WNI',
                            'no_paspor' => '',
                            'no_kitap' => '',
                            'nama_ayah' => 'SULAEMAN',
                            'nama_ibu' => 'AMINAH',
                        ],
                        [
                            'nama' => 'SITI MARYAM',
                            'nik' => '3206176508970002',
                            'jenis_kelamin' => 'PEREMPUAN',
                            'tempat_lahir' => 'TASIKMALAYA',
                            'tanggal_lahir' => '1997-08-25',
                            'agama' => 'ISLAM',
                            'pendidikan' => 'DIPLOMA IV/ STRATA I',
                            'pekerjaan' => 'GURU',
                            'gol_darah' => 'A',
                            'status_kawin' => 'KAWIN TERCATAT',
                            'tgl_kawin' => '2020-08-17',
                            'shdk' => 'ISTRI',
                            'kewarganegaraan' => 'WNI',
                            'no_paspor' => '',
                            'no_kitap' => '',
                            'nama_ayah' => 'RUKMANA',
                            'nama_ibu' => 'FATIMAH',
                        ]
                    ]
                ]
            ],
            'documents' => $documents,
        ];

        $response = $this->actingAs($warga)
            ->post(route('warga.submissions.store'), $payload);

        $response->assertSessionHasNoErrors();
        $submission = Submission::where('user_id', $warga->id)->first();
        $this->assertNotNull($submission);
        $this->assertEquals(SubmissionStatus::Submitted, $submission->status);
        $this->assertEquals('2', $submission->form_data['f101']['jumlah_anggota']);
        $this->assertCount(2, $submission->form_data['f101']['anggota']);
        $response->assertRedirect(route('warga.submissions.show', $submission));
    }

    public function test_kk_baru_edit_draft_renders_cleanly(): void
    {
        [$warga, $manonjaya, $desaManonjaya] = $this->makeWargaUser();
        $service = Service::where('kode_layanan', 'KK_BARU')->first();

        $submission = Submission::create([
            'user_id' => $warga->id,
            'service_id' => $service->id,
            'kecamatan_id' => $manonjaya->id,
            'desa_id' => $desaManonjaya->id,
            'nomor_tiket' => 'TIKET-DRAFT-001',
            'status' => SubmissionStatus::Draft,
            'form_data' => [
                'f101' => [
                    'nama_kepala_keluarga' => 'H. AHMAD RIFAI',
                    'alamat' => 'Kp. Sukamulya No. 8',
                    'rt' => '003',
                    'rw' => '004',
                    'kode_pos' => '46182',
                    'nama_desa' => $desaManonjaya->nama_desa,
                    'nama_kecamatan' => $manonjaya->nama_kecamatan,
                    'jumlah_anggota' => '1',
                    'anggota' => [
                        [
                            'nama' => 'H. AHMAD RIFAI',
                            'nik' => '3206170101800001',
                            'jenis_kelamin' => 'LAKI-LAKI',
                            'tempat_lahir' => 'TASIKMALAYA',
                            'tanggal_lahir' => '1980-01-01',
                            'agama' => 'ISLAM',
                            'pendidikan' => 'SLTA / SEDERAJAT',
                            'pekerjaan' => 'PNS',
                            'gol_darah' => 'B',
                            'status_kawin' => 'KAWIN TERCATAT',
                            'tgl_kawin' => '2005-01-01',
                            'shdk' => 'KEPALA KELUARGA',
                            'kewarganegaraan' => 'WNI',
                            'no_paspor' => '',
                            'no_kitap' => '',
                            'nama_ayah' => 'HASAN',
                            'nama_ibu' => 'HALIMAH',
                        ]
                    ]
                ]
            ]
        ]);

        $response = $this->actingAs($warga)
            ->get(route('warga.submissions.edit', $submission));

        $response->assertOk();
        $response->assertSee('Data Kepala Keluarga');
        $response->assertSee('Anggota Keluarga');
        $response->assertSee('H. AHMAD RIFAI');
    }

    public function test_kk_baru_print_f101_renders_correctly(): void
    {
        [$warga, $manonjaya, $desaManonjaya] = $this->makeWargaUser();
        $service = Service::where('kode_layanan', 'KK_BARU')->first();

        $submission = Submission::create([
            'user_id' => $warga->id,
            'service_id' => $service->id,
            'kecamatan_id' => $manonjaya->id,
            'desa_id' => $desaManonjaya->id,
            'status' => SubmissionStatus::Submitted,
            'nomor_tiket' => 'TIKET-KK-TEST-001',
            'form_data' => [
                'f101' => [
                    'nama_kepala_keluarga' => 'H. AHMAD RIFAI',
                    'alamat' => 'Kp. Sukamulya No. 8',
                    'rt' => '003',
                    'rw' => '004',
                    'kode_pos' => '46182',
                    'nama_desa' => $desaManonjaya->nama_desa,
                    'nama_kecamatan' => $manonjaya->nama_kecamatan,
                    'jumlah_anggota' => '1',
                    'anggota' => [
                        [
                            'nama' => 'H. AHMAD RIFAI',
                            'nik' => '3206170101800001',
                            'jenis_kelamin' => 'LAKI-LAKI',
                            'tempat_lahir' => 'TASIKMALAYA',
                            'tanggal_lahir' => '1980-01-01',
                            'agama' => 'ISLAM',
                            'pendidikan' => 'SLTA / SEDERAJAT',
                            'pekerjaan' => 'PNS',
                            'gol_darah' => 'B',
                            'status_kawin' => 'KAWIN TERCATAT',
                            'tgl_kawin' => '2005-01-01',
                            'shdk' => 'KEPALA KELUARGA',
                            'kewarganegaraan' => 'WNI',
                            'no_paspor' => '',
                            'no_kitap' => '',
                            'nama_ayah' => 'HASAN',
                            'nama_ibu' => 'HALIMAH',
                        ]
                    ]
                ]
            ]
        ]);

        $response = $this->actingAs($warga)
            ->get(route('warga.submissions.print-f101', $submission));

        $response->assertOk();
        $response->assertSee('FORMULIR PEMBUATAN KARTU KELUARGA BARU');
        $response->assertSee('H. AHMAD RIFAI');
        $response->assertSee('KP. SUKAMULYA NO. 8');
        $response->assertSee('3206170101800001');
    }
}
