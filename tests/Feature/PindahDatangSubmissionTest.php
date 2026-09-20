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

class PindahDatangSubmissionTest extends TestCase
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
            'name' => 'Doni Pemohon Pindah',
            'nik' => '3206171505980004',
            'email' => 'doni.' . uniqid() . '@example.com',
            'phone' => '081234567893',
            'kecamatan_id' => $manonjaya->id,
            'desa_id' => $desaManonjaya->id,
            'alamat_detail' => 'Jl. Raya Manonjaya No. 99',
        ]);

        return [$warga, $manonjaya, $desaManonjaya];
    }

    /* ────────────────────────────────────────────────────────────────────────
       1. TESTS FOR PINDAH_SATU_DESA
    ──────────────────────────────────────────────────────────────────────── */

    public function test_pindah_satu_desa_form_renders_with_digital_stepper(): void
    {
        [$warga, $manonjaya, $desaManonjaya] = $this->makeWargaUser();

        $response = $this->actingAs($warga)
            ->get(route('warga.submissions.create', ['service' => 'PINDAH_SATU_DESA']));

        $response->assertOk();
        $response->assertSee('pindahSatuDesaDigitalForm');
        $response->assertSee('Permohonan Pindah Datang WNI (Satu Desa)');
        $response->assertSee('Doni Pemohon Pindah');
        $response->assertSee('3206171505980004');
    }

    public function test_pindah_satu_desa_draft_accepted(): void
    {
        [$warga, $manonjaya, $desaManonjaya] = $this->makeWargaUser();
        $service = Service::where('kode_layanan', 'PINDAH_SATU_DESA')->first();

        $response = $this->actingAs($warga)
            ->post(route('warga.submissions.store'), [
                'service_id' => $service->id,
                'kecamatan_id' => $manonjaya->id,
                'submit_now' => '0',
                'form_data' => [
                    'f_pindah_satu_desa' => [
                        'no_kk' => '3206179988776655',
                        'nama_kepala' => 'Doni Pemohon Pindah',
                        'nama_pemohon' => 'Doni Pemohon Pindah',
                        'alasan_pindah' => 'PEKERJAAN',
                    ],
                ],
            ]);

        $submission = Submission::where('user_id', $warga->id)->first();
        $this->assertNotNull($submission);
        $this->assertEquals(SubmissionStatus::Draft, $submission->status);
        $this->assertArrayHasKey('f_pindah_satu_desa', $submission->form_data);
        $response->assertRedirect(route('warga.submissions.show', $submission));
    }

    public function test_pindah_satu_desa_valid_submission_accepted(): void
    {
        [$warga, $manonjaya, $desaManonjaya] = $this->makeWargaUser();
        $service = Service::where('kode_layanan', 'PINDAH_SATU_DESA')->first();

        $documents = [];
        foreach ($service->requirements as $req) {
            $documents[$req->id] = UploadedFile::fake()->create('doc_' . $req->id . '.pdf', 500, 'application/pdf');
        }

        $payload = [
            'service_id' => $service->id,
            'kecamatan_id' => $manonjaya->id,
            'submit_now' => '1',
            'form_data' => [
                'f_pindah_satu_desa' => [
                    'nama_pemohon' => 'Doni Pemohon Pindah',
                    'nik_pemohon' => '3206171505980004',
                    'telepon' => '081234567893',
                    'email' => $warga->email,
                    'no_kk' => '3206179988776655',
                    'nama_kepala' => 'Doni Pemohon Pindah',
                    'alamat' => 'Jl. Asal No. 1',
                    'rt' => '001',
                    'rw' => '001',
                    'kode_pos' => '46182',
                    'nama_desa' => $desaManonjaya->nama_desa,
                    'nama_kecamatan' => $manonjaya->nama_kecamatan,
                    'alasan_pindah' => 'PEKERJAAN',
                    'status_kk_tujuan' => 'NUMPANG_KK',
                    'alamat_tujuan' => 'Jl. Tujuan Baru No. 10',
                    'rt_tujuan' => '002',
                    'rw_tujuan' => '002',
                    'kode_pos_tujuan' => '46182',
                    'jumlah_anggota' => '1',
                    'anggota' => [
                        [
                            'nama' => 'Doni Pemohon Pindah',
                            'nik' => '3206171505980004',
                            'shdk' => 'Kepala Keluarga',
                        ],
                    ],
                ],
            ],
            'documents' => $documents,
        ];

        $response = $this->actingAs($warga)
            ->post(route('warga.submissions.store'), $payload);

        $response->assertSessionHasNoErrors();
        $submission = Submission::where('user_id', $warga->id)->first();
        $this->assertNotNull($submission);
        $this->assertEquals(SubmissionStatus::Submitted, $submission->status);
        $response->assertRedirect(route('warga.submissions.show', $submission));
    }

    /* ────────────────────────────────────────────────────────────────────────
       2. TESTS FOR PINDAH_ANTAR_DESA
    ──────────────────────────────────────────────────────────────────────── */

    public function test_pindah_antar_desa_form_renders_with_digital_stepper(): void
    {
        [$warga, $manonjaya, $desaManonjaya] = $this->makeWargaUser();

        $response = $this->actingAs($warga)
            ->get(route('warga.submissions.create', ['service' => 'PINDAH_ANTAR_DESA']));

        $response->assertOk();
        $response->assertSee('pindahAntarDesaDigitalForm');
        $response->assertSee('Permohonan Pindah Datang WNI (Antar Desa Satu Kecamatan)');
    }

    public function test_pindah_antar_desa_valid_submission_accepted(): void
    {
        [$warga, $manonjaya, $desaManonjaya] = $this->makeWargaUser();
        $service = Service::where('kode_layanan', 'PINDAH_ANTAR_DESA')->first();
        $desaTujuan = Desa::where('kecamatan_id', $manonjaya->id)->where('id', '!=', $desaManonjaya->id)->first() ?? $desaManonjaya;

        $documents = [];
        foreach ($service->requirements as $req) {
            $documents[$req->id] = UploadedFile::fake()->create('doc_' . $req->id . '.pdf', 500, 'application/pdf');
        }

        $payload = [
            'service_id' => $service->id,
            'kecamatan_id' => $manonjaya->id,
            'submit_now' => '1',
            'form_data' => [
                'f_pindah_antar_desa' => [
                    'nama_pemohon' => 'Doni Pemohon Pindah',
                    'nik_pemohon' => '3206171505980004',
                    'telepon' => '081234567893',
                    'email' => $warga->email,
                    'no_kk' => '3206179988776655',
                    'nama_kepala' => 'Doni Pemohon Pindah',
                    'alamat' => 'Jl. Asal No. 1',
                    'rt' => '001',
                    'rw' => '001',
                    'kode_pos' => '46182',
                    'nama_desa_asal' => $desaManonjaya->nama_desa,
                    'nama_kecamatan' => $manonjaya->nama_kecamatan,
                    'alasan_pindah' => 'PEKERJAAN',
                    'nama_desa_tujuan' => $desaTujuan->nama_desa,
                    'status_kk_tujuan' => 'NUMPANG_KK',
                    'alamat_tujuan' => 'Jl. Desa Sebelah No. 5',
                    'rt_tujuan' => '003',
                    'rw_tujuan' => '003',
                    'kode_pos_tujuan' => '46182',
                    'jumlah_anggota' => '1',
                    'anggota' => [
                        [
                            'nama' => 'Doni Pemohon Pindah',
                            'nik' => '3206171505980004',
                            'shdk' => 'Kepala Keluarga',
                        ],
                    ],
                ],
            ],
            'documents' => $documents,
        ];

        $response = $this->actingAs($warga)
            ->post(route('warga.submissions.store'), $payload);

        $response->assertSessionHasNoErrors();
        $submission = Submission::where('user_id', $warga->id)->first();
        $this->assertNotNull($submission);
        $this->assertEquals(SubmissionStatus::Submitted, $submission->status);
        $response->assertRedirect(route('warga.submissions.show', $submission));
    }

    /* ────────────────────────────────────────────────────────────────────────
       3. TESTS FOR PINDAH_ANTAR_KEC
    ──────────────────────────────────────────────────────────────────────── */

    public function test_pindah_antar_kec_form_renders_with_digital_stepper(): void
    {
        [$warga, $manonjaya, $desaManonjaya] = $this->makeWargaUser();

        $response = $this->actingAs($warga)
            ->get(route('warga.submissions.create', ['service' => 'PINDAH_ANTAR_KEC']));

        $response->assertOk();
        $response->assertSee('pindahAntarKecamatanDigitalForm');
        $response->assertSee('Permohonan Pindah Datang WNI (Antar Kecamatan Satu Kabupaten)');
    }

    public function test_pindah_antar_kec_valid_submission_accepted(): void
    {
        [$warga, $manonjaya, $desaManonjaya] = $this->makeWargaUser();
        $service = Service::where('kode_layanan', 'PINDAH_ANTAR_KEC')->first();
        $kecTujuan = Kecamatan::where('id', '!=', $manonjaya->id)->first();
        $desaTujuan = Desa::where('kecamatan_id', $kecTujuan->id)->first();

        $documents = [];
        foreach ($service->requirements as $req) {
            $documents[$req->id] = UploadedFile::fake()->create('doc_' . $req->id . '.pdf', 500, 'application/pdf');
        }

        $payload = [
            'service_id' => $service->id,
            'kecamatan_id' => $manonjaya->id,
            'submit_now' => '1',
            'form_data' => [
                'f_pindah_antar_kecamatan' => [
                    'nama_pemohon' => 'Doni Pemohon Pindah',
                    'nik_pemohon' => '3206171505980004',
                    'telepon' => '081234567893',
                    'email' => $warga->email,
                    'no_kk' => '3206179988776655',
                    'nama_kepala' => 'Doni Pemohon Pindah',
                    'alamat' => 'Jl. Asal No. 1',
                    'rt' => '001',
                    'rw' => '001',
                    'kode_pos' => '46182',
                    'nama_desa_asal' => $desaManonjaya->nama_desa,
                    'nama_kecamatan_asal' => $manonjaya->nama_kecamatan,
                    'alasan_pindah' => 'PEKERJAAN',
                    'jenis_kepindahan' => 'KEPALAKELUARGA_SELURUH',
                    'nama_kecamatan_tujuan' => $kecTujuan->nama_kecamatan,
                    'nama_desa_tujuan' => $desaTujuan?->nama_desa ?? 'SINGAPARNA',
                    'status_kk_tujuan' => 'NUMPANG_KK',
                    'alamat_tujuan' => 'Jl. Kecamatan Sebelah No. 12',
                    'rt_tujuan' => '005',
                    'rw_tujuan' => '005',
                    'kode_pos_tujuan' => '46182',
                    'jumlah_anggota' => '1',
                    'anggota' => [
                        [
                            'nama' => 'Doni Pemohon Pindah',
                            'nik' => '3206171505980004',
                            'shdk' => 'Kepala Keluarga',
                        ],
                    ],
                ],
            ],
            'documents' => $documents,
        ];

        $response = $this->actingAs($warga)
            ->post(route('warga.submissions.store'), $payload);

        $response->assertSessionHasNoErrors();
        $submission = Submission::where('user_id', $warga->id)->first();
        $this->assertNotNull($submission);
        $this->assertEquals(SubmissionStatus::Submitted, $submission->status);
        $response->assertRedirect(route('warga.submissions.show', $submission));
    }

    public function test_pindah_existing_form_data_preloaded(): void
    {
        [$warga, $manonjaya, $desaManonjaya] = $this->makeWargaUser();
        $service = Service::where('kode_layanan', 'PINDAH_SATU_DESA')->first();

        $submission = Submission::create([
            'nomor_tiket' => 'TKT-PINDAH-001',
            'user_id' => $warga->id,
            'kecamatan_id' => $manonjaya->id,
            'service_id' => $service->id,
            'status' => SubmissionStatus::Draft,
            'form_data' => [
                'f_pindah_satu_desa' => [
                    'nama_pemohon' => 'Doni Preload',
                    'no_kk' => '3206179999999999',
                    'nama_kepala' => 'Doni Preload',
                    'alasan_pindah' => 'PEKERJAAN',
                    'alamat_tujuan' => 'Jl. Preload Tujuan',
                ],
            ],
        ]);

        $response = $this->actingAs($warga)
            ->get(route('warga.submissions.create', ['service' => 'PINDAH_SATU_DESA']));

        $response->assertOk();
        $response->assertSee('pindahSatuDesaDigitalForm');

        // Verify old form data preloading into Alpine JS state configuration
        $responseWithOldInput = $this->actingAs($warga)
            ->withSession([
                '_old_input' => [
                    'form_data' => [
                        'f_pindah_satu_desa' => [
                            'no_kk' => '3206179999999999',
                            'nama_kepala' => 'Doni Preload',
                        ],
                    ],
                ],
            ])
            ->get(route('warga.submissions.create', ['service' => 'PINDAH_SATU_DESA']));

        $responseWithOldInput->assertOk();
        $responseWithOldInput->assertSee('3206179999999999');
    }

    public function test_pindah_ownership_protected(): void
    {
        [$warga, $manonjaya, $desaManonjaya] = $this->makeWargaUser();
        $service = Service::where('kode_layanan', 'PINDAH_SATU_DESA')->first();
        $otherUser = User::factory()->create(['role' => UserRole::Warga]);

        $submission = Submission::create([
            'nomor_tiket' => 'TKT-PINDAH-SECRET',
            'user_id' => $otherUser->id,
            'kecamatan_id' => $manonjaya->id,
            'service_id' => $service->id,
            'status' => SubmissionStatus::Draft,
        ]);

        $response = $this->actingAs($warga)
            ->get(route('warga.submissions.show', $submission));

        $response->assertForbidden();
    }
}
