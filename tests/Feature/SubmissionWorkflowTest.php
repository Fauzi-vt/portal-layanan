<?php

namespace Tests\Feature;

use App\Enums\DocumentValidationStatus;
use App\Enums\SubmissionStatus;
use App\Enums\UserRole;
use App\Models\Kecamatan;
use App\Models\Service;
use App\Models\Submission;
use App\Models\User;
use App\Services\SubmissionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SubmissionWorkflowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\KecamatanDesaSeeder::class);
        Storage::fake('public');
    }

    public function test_warga_can_create_submission(): void
    {
        $manonjaya = Kecamatan::where('kode_kecamatan', 'KEC-017')->first();
        $service = Service::where('kode_layanan', 'KIA')->first();

        $warga = User::factory()->create([
            'role'         => UserRole::Warga,
            'kecamatan_id' => $manonjaya->id,
            'nik'          => '3206171505980001',
        ]);

        $serviceService = app(SubmissionService::class);
        $dummyPdf = UploadedFile::fake()->create('kk.pdf', 500, 'application/pdf');

        $reqId = $service->requirements->first()->id;

        $submission = $serviceService->createSubmission($warga, [
            'service_id'   => $service->id,
            'kecamatan_id' => $manonjaya->id,
            'submit_now'   => true,
            'documents'    => [
                $reqId => $dummyPdf,
            ],
        ]);

        $this->assertDatabaseHas('submissions', [
            'id'           => $submission->id,
            'user_id'      => $warga->id,
            'kecamatan_id' => $manonjaya->id,
            'service_id'   => $service->id,
            'status'       => SubmissionStatus::Submitted->value,
        ]);

        $this->assertDatabaseHas('submission_documents', [
            'submission_id'          => $submission->id,
            'service_requirement_id' => $reqId,
        ]);
    }

    public function test_admin_kecamatan_scope_isolation(): void
    {
        $manonjaya = Kecamatan::where('kode_kecamatan', 'KEC-017')->first();
        $ciawi = Kecamatan::where('kode_kecamatan', 'KEC-003')->first();
        $service = Service::where('kode_layanan', 'KIA')->first();

        $wargaManonjaya = User::factory()->create([
            'role'         => UserRole::Warga,
            'kecamatan_id' => $manonjaya->id,
        ]);

        $adminManonjaya = User::factory()->create([
            'role'         => UserRole::AdminKecamatan,
            'kecamatan_id' => $manonjaya->id,
        ]);

        $adminCiawi = User::factory()->create([
            'role'         => UserRole::AdminKecamatan,
            'kecamatan_id' => $ciawi->id,
        ]);

        $submission = Submission::create([
            'nomor_tiket'  => 'TKT-TEST-001',
            'user_id'      => $wargaManonjaya->id,
            'kecamatan_id' => $manonjaya->id,
            'service_id'   => $service->id,
            'status'       => SubmissionStatus::Submitted,
        ]);

        // Admin Manonjaya boleh melihat
        $response1 = $this->actingAs($adminManonjaya)->get(route('kecamatan.submissions.show', $submission));
        $response1->assertOk();

        // Admin Ciawi TIDAK BOLEH melihat data Manonjaya (403 Forbidden)
        $response2 = $this->actingAs($adminCiawi)->get(route('kecamatan.submissions.show', $submission));
        $response2->assertForbidden();
    }

    public function test_revision_and_approval_workflow(): void
    {
        $manonjaya = Kecamatan::where('kode_kecamatan', 'KEC-017')->first();
        $service = Service::where('kode_layanan', 'KIA')->first();
        $warga = User::factory()->create(['role' => UserRole::Warga, 'kecamatan_id' => $manonjaya->id]);
        $admin = User::factory()->create(['role' => UserRole::AdminKecamatan, 'kecamatan_id' => $manonjaya->id]);

        $submissionService = app(SubmissionService::class);
        $submission = $submissionService->createSubmission($warga, [
            'service_id'   => $service->id,
            'kecamatan_id' => $manonjaya->id,
            'submit_now'   => true,
        ]);

        // Step 1: Admin minta revisi
        $submissionService->reviewSubmission($submission, $admin, [
            'status'          => SubmissionStatus::RevisionRequired->value,
            'catatan_petugas' => 'Scan KK buram, mohon upload ulang.',
        ]);

        $this->assertEquals(SubmissionStatus::RevisionRequired, $submission->fresh()->status);

        // Step 2: Warga kirim revisi
        $req = $service->requirements->first();
        $newPdf = UploadedFile::fake()->create('kk_jelas.pdf', 300, 'application/pdf');

        $submissionService->submitRevision($submission, [
            $req->id => $newPdf,
        ]);

        $this->assertEquals(SubmissionStatus::Submitted, $submission->fresh()->status);

        // Step 3: Admin menyelesaikan permohonan dengan output e-dokumen
        $outputPdf = UploadedFile::fake()->create('kia_digital.pdf', 800, 'application/pdf');
        $submissionService->completeSubmission($submission, $outputPdf, 'KIA telah diterbitkan.');

        $this->assertEquals(SubmissionStatus::Completed, $submission->fresh()->status);
        $this->assertNotNull($submission->fresh()->output_document_path);
    }
}
