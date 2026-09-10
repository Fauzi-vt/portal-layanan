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
        'jumlah_desa',
        'jumlah_rw',
        'jumlah_rt',
    ];

    /**
     * Hitung total desa aktual atau fallback ke jumlah_desa
     */
    public function getTotalDesaAttribute(): int
    {
        $count = $this->desas()->count();
        return $count > 0 ? $count : ($this->jumlah_desa ?? 0);
    }

    /**
     * Hitung total RW dari sum desa atau fallback ke jumlah_rw
     */
    public function getTotalRwAttribute(): int
    {
        $sum = $this->desas()->sum('jumlah_rw');
        return $sum > 0 ? $sum : ($this->jumlah_rw ?? 0);
    }

    /**
     * Hitung total RT dari sum desa atau fallback ke jumlah_rt
     */
    public function getTotalRtAttribute(): int
    {
        $sum = $this->desas()->sum('jumlah_rt');
        return $sum > 0 ? $sum : ($this->jumlah_rt ?? 0);
    }

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
