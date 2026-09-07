<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel Audit Trail & Log Histori Perubahan Status Pengajuan Layanan.
     */
    public function up(): void
    {
        Schema::create('submission_histories', function (Blueprint $table) {
            $table->id();

            // Relasi ke pengajuan
            $table->foreignId('submission_id')
                ->constrained('submissions')
                ->cascadeOnDelete()
                ->comment('Pengajuan yang mengalami perubahan status / tindakan');

            // Aktor pengguna yang melakukan aksi (Warga, Admin Desa, Admin Kecamatan, Super Admin)
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete()
                ->comment('Pengguna / Petugas yang melakukan aksi');

            // Jenis aksi yang dilakukan
            $table->string('action', 50)->comment('Jenis aksi: created, submitted, verified_desa, revision_requested, etc.');

            // Status sebelum dan sesudah perubahan
            $table->string('old_status', 50)->nullable()->comment('Status sebelum aksi');
            $table->string('new_status', 50)->comment('Status setelah aksi');

            // Catatan atau keterangan saat aksi dilakukan
            $table->text('catatan')->nullable()->comment('Catatan petugas / alasan perbaikan / instruksi');

            $table->timestamps();

            // Index pencarian riwayat per submission
            $table->index(['submission_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('submission_histories');
    }
};
