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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', [
                'user',
                'admin_kecamatan',
                'admin_kabupaten',
                'super_admin',
            ])->default('user')->after('email');

            // Kolom tambahan untuk admin kecamatan & kabupaten
            $table->string('wilayah')->nullable()->after('role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'wilayah']);
        });
    }
};
