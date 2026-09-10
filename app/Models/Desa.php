<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Desa extends Model
{
    use HasFactory;

    protected $table = 'desas';

    protected $fillable = [
        'kecamatan_id',
        'kode_desa',
        'nama_desa',
        'jumlah_rw',
        'jumlah_rt',
    ];

    /**
     * Relasi balik ke Kecamatan induk.
     */
    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }

    /**
     * Relasi ke Warga yang berdomisili di desa ini.
     */
    public function warga(): HasMany
    {
        return $this->hasMany(User::class, 'desa_id');
    }
}
