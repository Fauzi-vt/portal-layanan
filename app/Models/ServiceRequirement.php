<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceRequirement extends Model
{
    use HasFactory;

    protected $table = 'service_requirements';

    protected $fillable = [
        'service_id',
        'nama_persyaratan',
        'deskripsi',
        'is_required',
        'urutan',
        'accepted_formats',
        'max_size_kb',
    ];

    protected function casts(): array
    {
        return [
            'is_required'      => 'boolean',
            'urutan'           => 'integer',
            'accepted_formats' => 'array',
            'max_size_kb'      => 'integer',
        ];
    }

    /**
     * Relasi balik ke Jenis Layanan induk.
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    /**
     * Relasi ke file-file submission yang mengunggah dokumen persyaratan ini.
     */
    public function submissionDocuments(): HasMany
    {
        return $this->hasMany(SubmissionDocument::class, 'service_requirement_id');
    }
}
