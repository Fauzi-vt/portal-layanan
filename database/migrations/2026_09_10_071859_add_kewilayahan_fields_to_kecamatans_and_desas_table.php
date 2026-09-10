


<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('kecamatans', function (Blueprint $table) {
            $table->unsignedInteger('jumlah_desa')->nullable()->after('jam_operasional')->comment('Jumlah desa/kelurahan');
            $table->unsignedInteger('jumlah_rw')->nullable()->after('jumlah_desa')->comment('Jumlah Rukun Warga (RW)');
            $table->unsignedInteger('jumlah_rt')->nullable()->after('jumlah_rw')->comment('Jumlah Rukun Tetangga (RT)');
        });

        Schema::table('desas', function (Blueprint $table) {
            $table->unsignedInteger('jumlah_rw')->nullable()->default(0)->after('nama_desa')->comment('Jumlah RW di desa');
            $table->unsignedInteger('jumlah_rt')->nullable()->default(0)->after('jumlah_rw')->comment('Jumlah RT di desa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kecamatans', function (Blueprint $table) {
            $table->dropColumn(['jumlah_desa', 'jumlah_rw', 'jumlah_rt']);
        });

        Schema::table('desas', function (Blueprint $table) {
            $table->dropColumn(['jumlah_rw', 'jumlah_rt']);
        });
    }
};
