<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tambah flag requires_desa_approval pada tabel services
        Schema::table('services', function (Blueprint $table) {
            $table->boolean('requires_desa_approval')->default(false)->after('jenis_proses')
                ->comment('Apakah pengajuan layanan ini wajib melewati verifikasi administrasi desa');
        });

        // 2. Tambah relasi desa dan kolom verifikasi desa pada submissions
        Schema::table('submissions', function (Blueprint $table) {
            $table->foreignId('desa_id')->nullable()->after('kecamatan_id')
                ->constrained('desas')
                ->nullOnDelete()
                ->comment('Desa asal pemohon / desa yang memverifikasi');

            $table->foreignId('verified_by_desa_id')->nullable()->after('catatan_petugas')
                ->constrained('users')
                ->nullOnDelete()
                ->comment('Kasi Pelayanan Desa yang memverifikasi berkas');

            $table->timestamp('verified_desa_at')->nullable()->after('verified_by_desa_id')
                ->comment('Waktu verifikasi oleh pihak desa');

            $table->text('catatan_desa')->nullable()->after('verified_desa_at')
                ->comment('Catatan atau pengantar dari Kasi Pelayanan Desa');

            $table->index(['desa_id', 'status']);
        });

        // 3. Drop check constraint status & role jika ada di Postgres agar mendukung enum baru 'submitted_desa' & 'admin_desa'
        if (DB::getDriverName() === 'pgsql') {
            DB::statement('ALTER TABLE submissions DROP CONSTRAINT IF EXISTS submissions_status_check');
            DB::statement('ALTER TABLE submissions ALTER COLUMN status TYPE VARCHAR(50)');
            DB::statement('ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check');
            DB::statement('ALTER TABLE users ALTER COLUMN role TYPE VARCHAR(50)');
        }
    }

    public function down(): void
    {
        Schema::table('submissions', function (Blueprint $table) {
            $table->dropIndex(['desa_id', 'status']);
            $table->dropForeign(['desa_id']);
            $table->dropForeign(['verified_by_desa_id']);
            $table->dropColumn([
                'desa_id',
                'verified_by_desa_id',
                'verified_desa_at',
                'catatan_desa',
            ]);
        });

        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('requires_desa_approval');
        });
    }
};
