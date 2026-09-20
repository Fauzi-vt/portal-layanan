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

    public function test_warga_can_save_draft_edit_draft_and_submit_draft(): void
    {
        $manonjaya = Kecamatan::where('kode_kecamatan', 'KEC-017')->first();
        $service = Service::where('kode_layanan', 'KIA')->first();

        $warga = User::factory()->create([
            'role'         => UserRole::Warga,
            'kecamatan_id' => $manonjaya->id,
            'nik'          => '3206171505980002',
        ]);

        // 1. Simpan sebagai draft (tanpa berkas lengkap)
        $responseCreate = $this->actingAs($warga)->post(route('warga.submissions.store'), [
            'service_id'   => $service->id,
            'kecamatan_id' => $manonjaya->id,
            'submit_now'   => 0, // simpan draft
            'form_data'    => ['catatan' => 'Draft awal'],
        ]);

        $responseCreate->assertRedirect();
        $submission = Submission::where('user_id', $warga->id)->latest()->first();
        $this->assertNotNull($submission);
        $this->assertEquals(SubmissionStatus::Draft, $submission->status);

        // 2. Akses halaman edit draft
        $responseEdit = $this->actingAs($warga)->get(route('warga.submissions.edit', $submission));
        $responseEdit->assertOk();
        $responseEdit->assertSee('Edit Draft Permohonan');

        // 3. Coba kirim draft sebelum berkas lengkap -> harus gagal validasi
        $responseSubmitIncomplete = $this->actingAs($warga)->post(route('warga.submissions.submit-draft', $submission));
        $responseSubmitIncomplete->assertSessionHas('error', 'Masih ada dokumen persyaratan wajib yang belum diunggah.');
        $this->assertEquals(SubmissionStatus::Draft, $submission->fresh()->status);

        // 4. Update data & unggah semua berkas persyaratan wajib
        $docsPayload = [];
        foreach ($service->requiredDocuments as $req) {
            $docsPayload[$req->id] = UploadedFile::fake()->create("doc_{$req->id}.pdf", 200, 'application/pdf');
        }

        $responseUpdate = $this->actingAs($warga)->put(route('warga.submissions.update', $submission), [
            'kecamatan_id' => $manonjaya->id,
            'form_data'    => ['catatan' => 'Draft telah diperbarui'],
            'documents'    => $docsPayload,
        ]);

        $responseUpdate->assertRedirect(route('warga.submissions.show', $submission));
        $this->assertEquals('Draft telah diperbarui', $submission->fresh()->form_data['catatan']);
        $this->assertCount($service->requiredDocuments->count(), $submission->fresh()->documents);

        // 5. Kirim draft yang kini sudah lengkap
        $responseSubmit = $this->actingAs($warga)->post(route('warga.submissions.submit-draft', $submission));
        $responseSubmit->assertSessionHas('success');
        $this->assertEquals(SubmissionStatus::Submitted, $submission->fresh()->status);
    }

    public function test_warga_cannot_edit_other_warga_draft(): void
    {
        $manonjaya = Kecamatan::where('kode_kecamatan', 'KEC-017')->first();
        $service = Service::where('kode_layanan', 'KIA')->first();

        $wargaOwner = User::factory()->create(['role' => UserRole::Warga, 'kecamatan_id' => $manonjaya->id]);
        $wargaOther = User::factory()->create(['role' => UserRole::Warga, 'kecamatan_id' => $manonjaya->id]);

        $submission = Submission::create([
            'nomor_tiket'  => 'TKT-DRAFT-999',
            'user_id'      => $wargaOwner->id,
            'kecamatan_id' => $manonjaya->id,
            'service_id'   => $service->id,
            'status'       => SubmissionStatus::Draft,
        ]);

        // Warga lain tidak boleh mengakses edit draft
        $responseEdit = $this->actingAs($wargaOther)->get(route('warga.submissions.edit', $submission));
        $responseEdit->assertForbidden();

        // Warga lain tidak boleh mengirimkan update
        $responseUpdate = $this->actingAs($wargaOther)->put(route('warga.submissions.update', $submission), [
            'kecamatan_id' => $manonjaya->id,
        ]);
        $responseUpdate->assertForbidden();
    }

    public function test_cannot_edit_submission_once_submitted(): void
    {
        $manonjaya = Kecamatan::where('kode_kecamatan', 'KEC-017')->first();
        $service = Service::where('kode_layanan', 'KIA')->first();
        $warga = User::factory()->create(['role' => UserRole::Warga, 'kecamatan_id' => $manonjaya->id]);

        $submission = Submission::create([
            'nomor_tiket'  => 'TKT-SUBMITTED-888',
            'user_id'      => $warga->id,
            'kecamatan_id' => $manonjaya->id,
            'service_id'   => $service->id,
            'status'       => SubmissionStatus::Submitted,
        ]);

        // Policy melarang modifikasi permohonan yang bukan draft (403 Forbidden)
        $responseEdit = $this->actingAs($warga)->get(route('warga.submissions.edit', $submission));
        $responseEdit->assertForbidden();
    }
}
