<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Tabel Master Kecamatan
 *
 * Menyimpan data 39 kecamatan di Kabupaten Tasikmalaya.
 * Setiap kecamatan memiliki admin kecamatan yang hanya bisa
 * mengakses data di kecamatannya sendiri (scope isolation).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kecamatans', function (Blueprint $table) {
            $table->id();

            // Kode unik kecamatan (misal: KEC-001 s/d KEC-039)
            $table->string('kode_kecamatan', 10)->unique()->comment('Kode unik kecamatan (misal: KEC-001)');

            $table->string('nama_kecamatan', 100)->comment('Nama lengkap kecamatan');
            $table->text('alamat_kantor')->nullable()->comment('Alamat kantor kecamatan');
            $table->string('email', 100)->nullable()->comment('Email resmi kecamatan');
            $table->string('telepon', 20)->nullable()->comment('Nomor telepon kantor');
            $table->string('jam_operasional', 100)->nullable()->comment('Misal: Senin-Jumat, 08.00-16.00 WIB');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kecamatans');
    }
};
