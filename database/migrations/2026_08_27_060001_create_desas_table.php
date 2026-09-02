<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Tabel Master Desa/Kelurahan
 *
 * Setiap desa berelasi ke satu kecamatan.
 * Digunakan untuk memvalidasi domisili warga saat pendaftaran akun.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('desas', function (Blueprint $table) {
            $table->id();

            // Foreign key ke kecamatans — cascade delete jika kecamatan dihapus
            $table->foreignId('kecamatan_id')
                ->constrained('kecamatans')
                ->cascadeOnDelete()
                ->comment('ID kecamatan induk');

            // Kode desa mengikuti format KEMENDAGRI (10 digit) atau kode internal
            $table->string('kode_desa', 15)->unique()->comment('Kode desa (misal: 3206150001)');
            $table->string('nama_desa', 100)->comment('Nama desa/kelurahan');

            $table->timestamps();

            // Index untuk mempercepat pencarian desa berdasarkan kecamatan
            $table->index('kecamatan_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('desas');
    }
};
