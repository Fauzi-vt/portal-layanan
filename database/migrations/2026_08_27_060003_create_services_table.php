<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Tabel Master Layanan (Services)
 *
 * Menyimpan 8 jenis layanan utama yang tersedia di portal.
 * Kolom 'jenis_proses' menentukan alur: full digital atau hybrid
 * (memerlukan interaksi fisik seperti tanda tangan desa/biometrik).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();

            // Kode layanan pendek, unique — digunakan sebagai identifier di seluruh sistem
            // Contoh: KIA, EKTP, KK_BARU, KK_ADD, KK_DEL, PINDAH, NIKAH, LAINNYA
            $table->string('kode_layanan', 20)->unique()->comment('Kode unik layanan (misal: KIA, EKTP)');

            $table->string('nama_layanan', 150)->comment('Nama lengkap layanan');
            $table->text('deskripsi')->nullable()->comment('Deskripsi dan panduan layanan');

            // full_digital: seluruh proses bisa selesai online
            // hybrid: ada tahap fisik (biometrik e-KTP, form bertanda tangan desa/KUA)
            $table->enum('jenis_proses', ['full_digital', 'hybrid'])
                ->comment('Jenis alur proses: full_digital | hybrid');

            // Path file template formulir fisik yang bisa diunduh warga
            // Diisi untuk layanan KK Baru, Pindah, Dispensasi Nikah, dll.
            $table->string('template_formulir_path')->nullable()
                ->comment('Path file template formulir (PDF) untuk diunduh warga');

            // Ikon untuk tampilan di portal (nama icon heroicons/fontawesome, dll.)
            $table->string('ikon', 50)->nullable()->comment('Nama ikon untuk UI (misal: identification)');

            // Mengaktifkan/menonaktifkan layanan tanpa menghapus datanya
            $table->boolean('is_active')->default(true)->comment('Status aktif layanan');

            // Urutan tampil di portal
            $table->unsignedTinyInteger('urutan')->default(0)->comment('Urutan tampil di halaman layanan');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
