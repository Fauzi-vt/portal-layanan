<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Tabel Pengajuan Layanan Warga (Submissions)
 *
 * Inti dari sistem — setiap baris mewakili satu pengajuan layanan
 * oleh satu warga ke satu kecamatan.
 *
 * Alur Status:
 *   draft → submitted → in_review → [revision_required | processed] → [completed | rejected]
 *
 * Scope Isolasi: Setiap Admin Kecamatan HANYA dapat melihat data
 * submissions di mana kecamatan_id === admin.kecamatan_id.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();

            // Format nomor tiket: TKT-YYYYMMDD-KECID-XXXX
            // Contoh: TKT-20260827-05-0001
            $table->string('nomor_tiket', 30)->unique()->comment('Nomor tiket unik (TKT-YYYYMMDD-KEC-XXXX)');

            // Relasi ke warga yang mengajukan
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete()
                ->comment('Warga yang mengajukan');

            // Kecamatan tujuan pengajuan — digunakan untuk scope admin
            $table->foreignId('kecamatan_id')
                ->constrained('kecamatans')
                ->cascadeOnDelete()
                ->comment('Kecamatan tempat pengajuan diproses');

            // Jenis layanan yang diajukan
            $table->foreignId('service_id')
                ->constrained('services')
                ->cascadeOnDelete()
                ->comment('Jenis layanan yang diajukan');

            // ── Status Pengajuan ──────────────────────────────────────────────
            // draft            : Masih dikerjakan warga, belum dikirim
            // submitted        : Sudah dikirim, menunggu review
            // in_review        : Sedang diverifikasi petugas
            // revision_required: Petugas meminta perbaikan berkas
            // processed        : Berkas lengkap, sedang diproses
            // completed        : Selesai, e-dokumen/info tersedia
            // rejected         : Ditolak dengan alasan
            $table->enum('status', [
                'draft',
                'submitted',
                'in_review',
                'revision_required',
                'processed',
                'completed',
                'rejected',
            ])->default('draft')->comment('Status alur pengajuan');

            // Catatan dari petugas: instruksi revisi atau alasan penolakan
            // Penting untuk mencegah warga bolak-balik tanpa arahan jelas
            $table->text('catatan_petugas')->nullable()
                ->comment('Catatan/instruksi dari petugas (revisi/penolakan)');

            // Khusus layanan e-KTP: jadwal biometrik yang di-booking
            $table->dateTime('jadwal_biometrik')->nullable()
                ->comment('Jadwal rekam biometrik e-KTP (khusus layanan EKTP)');

            // Nomor antrean biometrik (untuk layanan e-KTP)
            $table->string('nomor_antrean', 10)->nullable()
                ->comment('Nomor antrean rekam biometrik');

            // Path e-dokumen hasil (e-KK, e-surat, dll.) setelah selesai diproses
            $table->string('output_document_path')->nullable()
                ->comment('Path file e-dokumen hasil yang bisa diunduh warga');

            // Data formulir tambahan (JSON) — untuk layanan dinamis & field khusus
            $table->json('form_data')->nullable()
                ->comment('Data formulir tambahan (JSON) per jenis layanan');

            $table->timestamps();

            // ── Indexes ───────────────────────────────────────────────────────
            // Index utama untuk query Admin Kecamatan (scope per kecamatan + status)
            $table->index(['kecamatan_id', 'status']);
            // Index untuk tracking warga
            $table->index(['user_id', 'status']);
            // Index untuk laporan per layanan
            $table->index(['service_id', 'kecamatan_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
