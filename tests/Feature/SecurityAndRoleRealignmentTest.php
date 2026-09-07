<?php

namespace Tests\Feature;

use App\Enums\DocumentValidationStatus;
use App\Enums\ServiceProcessType;
use App\Enums\SubmissionStatus;
use App\Enums\UserRole;
use App\Models\Desa;
use App\Models\Kecamatan;
use App\Models\Service;
use App\Models\ServiceRequirement;
use App\Models\Submission;
use App\Models\SubmissionDocument;
use App\Models\User;
use App\Services\SubmissionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SecurityAndRoleRealignmentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\KecamatanDesaSeeder::class);
        Storage::fake('local');
        Storage::fake('public');
    }

    public function test_admin_desa_login_redirects_to_desa_dashboard(): void
    {
        $manonjaya = Kecamatan::where('kode_kecamatan', 'KEC-017')->first();
        $desa = $manonjaya->desas->first();

        $adminDesa = User::factory()->create([
            'role'         => UserRole::AdminDesa,
            'kecamatan_id' => $manonjaya->id,
            'desa_id'      => $desa->id,
            'email'        => 'kasi.desa@test.id',
            'password'     => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'login'    => 'kasi.desa@test.id',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('desa.dashboard'));
    }

    public function test_document_multi_tenant_authorization(): void
    {
        $kecamatanA = Kecamatan::where('kode_kecamatan', 'KEC-017')->first(); // Manonjaya
        $desaA = $kecamatanA->desas->first();

        $kecamatanB = Kecamatan::where('kode_kecamatan', 'KEC-001')->first(); // Kadipaten
        $desaB = Desa::firstOrCreate(
            ['kode_desa' => '3206010001'],
            ['kecamatan_id' => $kecamatanB->id, 'nama_desa' => 'Kadipaten Satu']
        );

        $service = Service::where('kode_layanan', 'KIA')->first();
        $req = $service->requirements->first();

        // Warga A in Desa A, Kecamatan A
        $wargaA = User::factory()->create([
            'role'         => UserRole::Warga,
            'kecamatan_id' => $kecamatanA->id,
            'desa_id'      => $desaA->id,
            'nik'          => '3206171505980001',
        ]);

        // Warga B in Desa B, Kecamatan B
        $wargaB = User::factory()->create([
            'role'         => UserRole::Warga,
            'kecamatan_id' => $kecamatanB->id,
            'desa_id'      => $desaB->id,
            'nik'          => '3206011505980002',
        ]);

        // Admin Desa A
        $adminDesaA = User::factory()->create([
            'role'         => UserRole::AdminDesa,
            'kecamatan_id' => $kecamatanA->id,
            'desa_id'      => $desaA->id,
        ]);

        // Admin Desa B
        $adminDesaB = User::factory()->create([
            'role'         => UserRole::AdminDesa,
            'kecamatan_id' => $kecamatanB->id,
            'desa_id'      => $desaB->id,
        ]);

        // Admin Kecamatan A
        $adminKecA = User::factory()->create([
            'role'         => UserRole::AdminKecamatan,
            'kecamatan_id' => $kecamatanA->id,
        ]);

        // Admin Kecamatan B
        $adminKecB = User::factory()->create([
            'role'         => UserRole::AdminKecamatan,
            'kecamatan_id' => $kecamatanB->id,
        ]);

        // Super Admin
        $superAdmin = User::factory()->create([
            'role' => UserRole::SuperAdmin,
        ]);

        // Create submission for Warga A with document stored in local disk
        $filePath = 'submissions/test/doc.pdf';
        Storage::disk('local')->put($filePath, 'fake pdf content');

        $submission = Submission::create([
            'user_id'      => $wargaA->id,
            'kecamatan_id' => $kecamatanA->id,
            'desa_id'      => $desaA->id,
            'service_id'   => $service->id,
            'nomor_tiket'  => 'TIKET-TEST-001',
            'status'       => SubmissionStatus::Submitted,
        ]);

        $document = SubmissionDocument::create([
            'submission_id'          => $submission->id,
            'service_requirement_id' => $req->id,
            'file_name'              => 'ktp_ayah.pdf',
            'file_path'              => $filePath,
            'mime_type'              => 'application/pdf',
            'file_size'              => 1024,
            'status_validasi'        => DocumentValidationStatus::Pending,
        ]);

        // 1. Warga A CAN view their own document
        $this->actingAs($wargaA)
            ->get(route('documents.show', $document))
            ->assertStatus(200);

        // 2. Warga B CANNOT view Warga A's document (403)
        $this->actingAs($wargaB)
            ->get(route('documents.show', $document))
            ->assertStatus(403);

        // 3. Admin Desa A CAN view document of Warga A (same desa)
        $this->actingAs($adminDesaA)
            ->get(route('documents.show', $document))
            ->assertStatus(200);

        // 4. Admin Desa B CANNOT view document of Warga A (different desa - 403)
        $this->actingAs($adminDesaB)
            ->get(route('documents.show', $document))
            ->assertStatus(403);

        // 5. Admin Kecamatan A CAN view document (same kecamatan)
        $this->actingAs($adminKecA)
            ->get(route('documents.show', $document))
            ->assertStatus(200);

        // 6. Admin Kecamatan B CANNOT view document (different kecamatan - 403)
        $this->actingAs($adminKecB)
            ->get(route('documents.show', $document))
            ->assertStatus(403);

        // 7. SuperAdmin CAN view any document
        $this->actingAs($superAdmin)
            ->get(route('documents.show', $document))
            ->assertStatus(200);
    }

    public function test_super_admin_service_management_access_and_crud(): void
    {
        $superAdmin = User::factory()->create([
            'role' => UserRole::SuperAdmin,
        ]);

        $warga = User::factory()->create([
            'role' => UserRole::Warga,
        ]);

        // Non-superadmin is blocked
        $this->actingAs($warga)
            ->get(route('superadmin.services.index'))
            ->assertStatus(403);

        // Super admin can view service list
        $this->actingAs($superAdmin)
            ->get(route('superadmin.services.index'))
            ->assertStatus(200)
            ->assertSee('Katalog Layanan Publik');

        $service = Service::where('kode_layanan', 'KIA')->first();

        // Toggle service status
        $originalStatus = $service->is_active;
        $this->actingAs($superAdmin)
            ->patch(route('superadmin.services.toggle', $service))
            ->assertRedirect();

        $this->assertEquals(!$originalStatus, $service->fresh()->is_active);

        // Add dynamic requirement
        $this->actingAs($superAdmin)
            ->post(route('superadmin.services.requirements.store', $service), [
                'nama_persyaratan' => 'Surat Pengantar RT/RW Tambahan',
                'deskripsi'        => 'Surat keterangan dari RT setempat',
                'is_required'      => 1,
                'urutan'           => 10,
                'accepted_formats' => ['pdf', 'jpg'],
                'max_size_kb'      => 2048,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('service_requirements', [
            'service_id'       => $service->id,
            'nama_persyaratan' => 'Surat Pengantar RT/RW Tambahan',
            'is_required'      => true,
        ]);
    }
}
