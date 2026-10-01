<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\Desa;
use App\Models\Kecamatan;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicServiceDetailTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\KecamatanDesaSeeder::class);
    }

    protected function makeWargaUser(): User
    {
        $manonjaya = Kecamatan::where('kode_kecamatan', 'KEC-017')->first() ?? Kecamatan::first();
        $desaManonjaya = Desa::where('kecamatan_id', $manonjaya->id)->first() ?? Desa::first();

        return User::factory()->create([
            'role'          => UserRole::Warga,
            'name'          => 'Ahmad Warga Tasik',
            'nik'           => '3206171010900001',
            'email'         => 'warga.' . uniqid() . '@example.com',
            'password'      => bcrypt('password123'),
            'kecamatan_id'  => $manonjaya?->id,
            'desa_id'       => $desaManonjaya?->id,
            'alamat_detail' => 'Kp. Sukamanah No. 10',
        ]);
    }

    /**
     * TEST A: Guest (masyarakat belum login) dapat melihat katalog dan detail layanan publik.
     */
    public function test_guest_can_view_public_service_detail_without_login(): void
    {
        $service = Service::where('kode_layanan', 'KK_BARU')->firstOrFail();

        $response = $this->get('/layanan/KK_BARU');

        $response->assertStatus(200);
        $response->assertSee($service->nama_layanan);
        $response->assertSee('Dokumen Persyaratan Pengajuan');
        $response->assertSee('AJUKAN LAYANAN SEKARANG');
        $response->assertSee('Rp 0 (GRATIS)');
    }

    /**
     * Verifikasi bahwa data persyaratan berkas diambil secara dinamis dari database.
     */
    public function test_public_service_detail_displays_database_requirements(): void
    {
        $service = Service::with('requirements')->where('kode_layanan', 'KK_BARU')->firstOrFail();

        $response = $this->get('/layanan/KK_BARU');

        $response->assertStatus(200);
        foreach ($service->requirements as $req) {
            $response->assertSee($req->nama_persyaratan);
        }
    }

    /**
     * TEST B & C: Guest yang mengakses form pengajuan layanan dicegat oleh auth,
     * dan setelah login berhasil, diarahkan kembali ke formulir layanan yang dipilih (konteks tidak hilang).
     */
    public function test_guest_submitting_service_is_redirected_to_login_and_returns_to_form_after_login(): void
    {
        $warga = $this->makeWargaUser();

        // 1. Guest mencoba mengakses form permohonan Kartu Keluarga Baru
        $response = $this->get('/warga/permohonan/buat?service=KK_BARU');

        // Harus dialihkan ke halaman login
        $response->assertRedirect('/login');

        // 2. Akses halaman login — pastikan banner konteks layanan tampil
        $loginPage = $this->get('/login');
        $loginPage->assertStatus(200);
        $loginPage->assertSee('Layanan yang Dipilih');
        $loginPage->assertSee('KK_BARU');

        // 3. Warga melakukan login
        $loginSubmit = $this->post('/login', [
            'login'    => $warga->email,
            'password' => 'password123',
        ]);

        // Setelah login, user harus DIARAHKAN KE FORM KK_BARU (bukan dashboard umum)
        $loginSubmit->assertRedirect('/warga/permohonan/buat?service=KK_BARU');

        // 4. Follow redirect ke form dan pastikan form KK_BARU terbuka
        $formPage = $this->get('/warga/permohonan/buat?service=KK_BARU');
        $formPage->assertStatus(200);
        $formPage->assertSee('Pembuatan Kartu Keluarga (KK) Baru');
    }

    /**
     * Verifikasi jika login dengan parameter ?service=EKTP, user langsung diarahkan ke form EKTP setelah login.
     */
    public function test_login_with_service_parameter_redirects_to_chosen_service_form(): void
    {
        $warga = $this->makeWargaUser();

        // Guest membuka /login?service=EKTP
        $loginPage = $this->get('/login?service=EKTP');
        $loginPage->assertStatus(200);
        $loginPage->assertSee('EKTP');

        // Login
        $loginSubmit = $this->post('/login', [
            'login'    => $warga->email,
            'password' => 'password123',
        ]);

        $loginSubmit->assertRedirect('/warga/permohonan/buat?service=EKTP');
    }

    /**
     * TEST D: User yang sudah login (Warga) saat mengajukan langsung masuk ke form tanpa diminta login.
     */
    public function test_authenticated_warga_directly_accesses_submission_form(): void
    {
        $warga = $this->makeWargaUser();

        $response = $this->actingAs($warga)->get('/warga/permohonan/buat?service=KK_BARU');

        $response->assertStatus(200);
        $response->assertSee('Pembuatan Kartu Keluarga (KK) Baru');
    }

    /**
     * TEST E: Privacy & Security Check — Guest tidak bisa mengakses berkas/data pribadi warga lain.
     */
    public function test_guest_cannot_access_private_submissions_or_documents(): void
    {
        // 1. Guest tidak boleh bisa melihat daftar riwayat permohonan
        $this->get('/warga/permohonan')->assertRedirect('/login');

        // 2. Guest tidak boleh bisa melihat verifikasi desa
        $this->get('/desa/verifikasi')->assertRedirect('/login');

        // 3. Guest tidak boleh bisa melihat verifikasi kecamatan
        $this->get('/kecamatan/verifikasi')->assertRedirect('/login');

        // 4. Guest tidak boleh bisa mengelola master layanan superadmin
        $this->get('/superadmin/layanan')->assertRedirect('/login');
    }

    /**
     * Verifikasi katalog publik /layanan mengarahkan ke halaman beranda section layanan.
     */
    public function test_public_service_index_redirects_to_home_catalog(): void
    {
        $response = $this->get('/layanan');

        $response->assertRedirect(url('/#layanan'));
    }
}
