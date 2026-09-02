<?php

namespace App\Models;

use App\Enums\DocumentValidationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class SubmissionDocument extends Model
{
    use HasFactory;

    protected $table = 'submission_documents';

    protected $fillable = [
        'submission_id',
        'service_requirement_id',
        'file_path',
        'file_name',
        'file_size',
        'mime_type',
        'status_validasi',
        'catatan_dokumen',
    ];

    protected function casts(): array
    {
        return [
            'status_validasi' => DocumentValidationStatus::class,
            'file_size'       => 'integer',
        ];
    }

    // ─────────────────────────────────────────────
    // Relasi Eloquent
    // ─────────────────────────────────────────────

    /**
     * Relasi balik ke Pengajuan Layanan induk.
     */
    public function submission(): BelongsTo
    {
        return $this->belongsTo(Submission::class, 'submission_id');
    }

    /**
     * Relasi ke Butir Persyaratan yang dipenuhi oleh berkas ini.
     */
    public function requirement(): BelongsTo
    {
        return $this->belongsTo(ServiceRequirement::class, 'service_requirement_id');
    }

    // ─────────────────────────────────────────────
    // Helpers
    // ─────────────────────────────────────────────

    public function isValid(): bool
    {
        return $this->status_validasi === DocumentValidationStatus::Valid;
    }

    public function isInvalid(): bool
    {
        return $this->status_validasi === DocumentValidationStatus::Invalid;
    }

    public function isPending(): bool
    {
        return $this->status_validasi === DocumentValidationStatus::Pending;
    }

    /**
     * Dapatkan URL berkas untuk ditampilkan/diunduh.
     */
    public function getFileUrlAttribute(): ?string
    {
        return $this->file_path ? Storage::url($this->file_path) : null;
    }
}
