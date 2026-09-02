<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Tabel Syarat Dokumen Dinamis per Layanan (Service Requirements)
 *
 * Dynamic Checklist — setiap jenis layanan memiliki daftar persyaratan
 * dokumen yang bisa dikonfigurasi oleh Super Admin tanpa perlu coding.
 * Warga akan melihat checklist ini saat mengajukan layanan.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_requirements', function (Blueprint $table) {
            $table->id();

            // Setiap persyaratan milik satu jenis layanan
            // Cascade delete: jika layanan dihapus, persyaratannya ikut terhapus
            $table->foreignId('service_id')
                ->constrained('services')
                ->cascadeOnDelete()
                ->comment('Layanan yang memerlukan persyaratan ini');

            $table->string('nama_persyaratan', 150)->comment('Nama dokumen persyaratan');
            $table->text('deskripsi')->nullable()->comment('Panduan dokumen (format, ukuran, dll.)');

            // Jika true: warga WAJIB upload; jika false: opsional
            $table->boolean('is_required')->default(true)->comment('Wajib diunggah atau opsional');

            // Urutan tampil di checklist pengajuan
            $table->unsignedSmallInteger('urutan')->default(0)->comment('Urutan tampil di checklist');

            // Jenis file yang diterima (JSON array: ['pdf','jpg','png'])
            $table->json('accepted_formats')->nullable()
                ->comment('Format file yang diterima (JSON array: ["pdf","jpg","png"])');

            // Maksimum ukuran file dalam KB (default 5 MB = 5120 KB)
            $table->unsignedInteger('max_size_kb')->default(5120)
                ->comment('Ukuran file maksimum dalam KB');

            $table->timestamps();

            // Index untuk query checklist per layanan
            $table->index(['service_id', 'urutan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_requirements');
    }
};
