<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kecamatan extends Model
{
    use HasFactory;

    protected $table = 'kecamatans';

    protected $fillable = [
        'kode_kecamatan',
        'nama_kecamatan',
        'alamat_kantor',
        'email',
        'telepon',
        'jam_operasional',
    ];

    /**
     * Relasi ke Desa/Kelurahan dalam wilayah kecamatan ini.
     */
    public function desas(): HasMany
    {
        return $this->hasMany(Desa::class, 'kecamatan_id');
    }

    /**
     * Relasi ke seluruh User (Warga & Admin Kecamatan) di kecamatan ini.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'kecamatan_id');
    }

    /**
     * Relasi ke Admin Kecamatan yang bertugas di kecamatan ini.
     */
    public function admins(): HasMany
    {
        return $this->hasMany(User::class, 'kecamatan_id')
            ->where('role', \App\Enums\UserRole::AdminKecamatan);
    }

    /**
     * Relasi ke Pengajuan Layanan (Submissions) yang masuk ke kecamatan ini.
     */
    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class, 'kecamatan_id');
    }
}
