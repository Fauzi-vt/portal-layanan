<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Tabel File Persyaratan yang Diunggah Warga (Submission Documents)
 *
 * Menyimpan berkas/dokumen upload untuk setiap butir persyaratan.
 * Admin Kecamatan dapat memvalidasi dokumen secara individual
 * (status_validasi: pending, valid, invalid) dan memberikan catatan per dokumen jika ditolak/tidak jelas.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('submission_documents', function (Blueprint $table) {
            $table->id();

            // Relasi ke pengajuan utama
            $table->foreignId('submission_id')
                ->constrained('submissions')
                ->cascadeOnDelete()
                ->comment('Pengajuan layanan terkait');

            // Relasi ke butir persyaratan yang dipenuhi
            $table->foreignId('service_requirement_id')
                ->constrained('service_requirements')
                ->cascadeOnDelete()
                ->comment('Persyaratan layanan yang dipenuhi');

            // Path penyimpanan file di storage (misal: documents/2026/08/xxx.pdf)
            $table->string('file_path')->comment('Lokasi penyimpanan file di disk storage');

            // Nama asli file yang diunggah warga
            $table->string('file_name')->nullable()->comment('Nama asli berkas');

            // Ukuran file dalam bytes
            $table->unsignedBigInteger('file_size')->nullable()->comment('Ukuran file dalam bytes');

            // MIME Type (misal: application/pdf, image/jpeg)
            $table->string('mime_type', 100)->nullable()->comment('Tipe MIME berkas');

            // Status validasi verifikator per berkas
            $table->enum('status_validasi', ['pending', 'valid', 'invalid'])
                ->default('pending')
                ->comment('Status verifikasi berkas: pending | valid | invalid');

            // Catatan spesifik per dokumen jika tidak valid (misal: "Foto KTP buram, mohon upload ulang")
            $table->text('catatan_dokumen')->nullable()
                ->comment('Catatan petugas jika berkas tidak sesuai/buram');

            $table->timestamps();

            // Index pencarian dokumen per submission
            $table->index(['submission_id', 'status_validasi']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('submission_documents');
    }
};
