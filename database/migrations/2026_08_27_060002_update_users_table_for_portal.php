<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Update Tabel Users untuk Sistem Portal Layanan
 *
 * Perubahan dari migrasi sebelumnya:
 * - Menghapus kolom 'role' (enum lama: user/admin_kecamatan/admin_kabupaten/super_admin)
 * - Menghapus kolom 'wilayah' (string mentah)
 * - Menambahkan:
 *   - nik          : Nomor Induk Kependudukan 16 digit (unique)
 *   - phone        : Nomor telepon/HP
 *   - role         : Enum baru (warga | admin_kecamatan | super_admin)
 *   - kecamatan_id : FK → kecamatans (untuk admin kecamatan & warga)
 *   - desa_id      : FK → desas (untuk warga)
 *   - alamat_detail: Alamat lengkap warga
 *
 * CATATAN: Migrasi ini harus dijalankan SETELAH kecamatans & desas dibuat.
 */
return new class extends Migration
{
    public function up(): void
    {
        // ── Step 1: Hapus kolom role & wilayah dari migrasi sebelumnya ────────
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'wilayah']);
        });

        // ── Step 2: Tambahkan kolom-kolom baru ────────────────────────────────
        Schema::table('users', function (Blueprint $table) {
            // NIK: 16 digit, unik, wajib untuk warga; nullable untuk admin sistem
            $table->string('nik', 16)
                ->unique()
                ->nullable()
                ->after('id')
                ->comment('Nomor Induk Kependudukan 16 digit');

            // Nomor telepon / HP
            $table->string('phone', 20)
                ->nullable()
                ->after('email')
                ->comment('Nomor telepon aktif');

            // Role baru: sesuai spesifikasi sistem
            $table->enum('role', ['warga', 'admin_desa', 'admin_kecamatan', 'super_admin'])
                ->default('warga')
                ->after('phone')
                ->comment('Role: warga | admin_desa | admin_kecamatan | super_admin');

            // Foreign Key ke kecamatans:
            //   - Warga      : kecamatan domisili
            //   - Admin Kec  : kecamatan yang dikelola
            //   - Super Admin: null
            $table->foreignId('kecamatan_id')
                ->nullable()
                ->after('role')
                ->constrained('kecamatans')
                ->nullOnDelete()
                ->comment('Kecamatan domisili/wilayah kerja');

            // Foreign Key ke desas (hanya untuk warga)
            $table->foreignId('desa_id')
                ->nullable()
                ->after('kecamatan_id')
                ->constrained('desas')
                ->nullOnDelete()
                ->comment('Desa domisili warga');

            // Alamat detail selain desa/kecamatan
            $table->text('alamat_detail')
                ->nullable()
                ->after('desa_id')
                ->comment('Alamat lengkap: RT/RW, nama jalan, dll');

            // Composite index untuk mempercepat scope query per kecamatan
            $table->index(['kecamatan_id', 'role']);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus foreign key constraints dahulu
            $table->dropForeign(['kecamatan_id']);
            $table->dropForeign(['desa_id']);
            $table->dropIndex(['kecamatan_id', 'role']);
            $table->dropColumn(['nik', 'phone', 'role', 'kecamatan_id', 'desa_id', 'alamat_detail']);
        });

        // Kembalikan kolom lama
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', [
                'user',
                'admin_kecamatan',
                'admin_kabupaten',
                'super_admin',
            ])->default('user');
            $table->string('wilayah')->nullable();
        });
    }
};
