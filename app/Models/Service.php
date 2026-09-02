<?php

namespace App\Models;

use App\Enums\ServiceProcessType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';

    protected $fillable = [
        'kode_layanan',
        'nama_layanan',
        'deskripsi',
        'jenis_proses',
        'template_formulir_path',
        'ikon',
        'is_active',
        'urutan',
    ];

    protected function casts(): array
    {
        return [
            'jenis_proses' => ServiceProcessType::class,
            'is_active'    => 'boolean',
            'urutan'       => 'integer',
        ];
    }

    /**
     * Relasi ke Persyaratan Dokumen yang dibutuhkan oleh layanan ini.
     */
    public function requirements(): HasMany
    {
        return $this->hasMany(ServiceRequirement::class, 'service_id')
            ->orderBy('urutan', 'asc');
    }

    /**
     * Persyaratan wajib saja.
     */
    public function requiredDocuments(): HasMany
    {
        return $this->hasMany(ServiceRequirement::class, 'service_id')
            ->where('is_required', true)
            ->orderBy('urutan', 'asc');
    }

    /**
     * Relasi ke seluruh Pengajuan yang menggunakan layanan ini.
     */
    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class, 'service_id');
    }

    /**
     * Helper: Apakah layanan ini merupakan proses hybrid (butuh langkah fisik).
     */
    public function isHybrid(): bool
    {
        return $this->jenis_proses === ServiceProcessType::Hybrid;
    }

    /**
     * Helper: Apakah layanan ini full digital.
     */
    public function isFullDigital(): bool
    {
        return $this->jenis_proses === ServiceProcessType::FullDigital;
    }
}
