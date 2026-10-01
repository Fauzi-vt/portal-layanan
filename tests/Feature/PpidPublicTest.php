<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PpidPublicTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\KecamatanDesaSeeder::class);
    }

    /**
     * Test direct /ppid route redirects to /#ppid.
     */
    public function test_ppid_route_redirects_to_home_ppid_section(): void
    {
        $response = $this->get('/ppid');
        $response->assertRedirect('/#ppid');
    }

    /**
     * Test home page includes comprehensive PPID section, tabs, and interactive features.
     */
    public function test_home_page_renders_ppid_and_information_section(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Portal Keterbukaan Informasi Publik');
        $response->assertSee('Pejabat Pengelola Informasi');
        $response->assertSee('Daftar Informasi Publik (DIP)');
        $response->assertSee('Alur & SOP Permohonan', false);
        $response->assertSee('Dasar Hukum & Regulasi', false);
        $response->assertSee('Meja Layanan PPID');
        $response->assertSee('Laporan Akuntabilitas Kinerja Instansi Pemerintah (LKjIP)');
        $response->assertSee('Formulir Permohonan Informasi Publik');
        $response->assertSee('Lacak Permohonan Informasi PPID');
        $response->assertSee('Layanan Aspirasi & Pengaduan Warga', false);
    }
}
