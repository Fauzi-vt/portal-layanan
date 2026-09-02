<?php

namespace App\Models;

use App\Enums\SubmissionStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Submission extends Model
{
    use HasFactory;

    protected $table = 'submissions';

    protected $fillable = [
        'nomor_tiket',
        'user_id',
        'kecamatan_id',
        'service_id',
        'status',
        'catatan_petugas',
        'jadwal_biometrik',
        'nomor_antrean',
        'output_document_path',
        'form_data',
    ];

    protected function casts(): array
    {
        return [
            'status'           => SubmissionStatus::class,
            'jadwal_biometrik' => 'datetime',
            'form_data'        => 'array',
        ];
    }

    // ─────────────────────────────────────────────
    // Relasi Eloquent
    // ─────────────────────────────────────────────

    /**
     * Relasi ke Warga yang mengajukan permohonan.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke Kecamatan yang menangani permohonan.
     */
    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }

    /**
     * Relasi ke Jenis Layanan yang diajukan.
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    /**
     * Relasi ke Dokumen Berkas yang diunggah warga untuk pengajuan ini.
     */
    public function documents(): HasMany
    {
        return $this->hasMany(SubmissionDocument::class, 'submission_id');
    }

    // ─────────────────────────────────────────────
    // Query Scopes (Scope Isolasi Multi-Kecamatan)
    // ─────────────────────────────────────────────

    /**
     * Scope untuk menyaring data pengajuan berdasarkan ID Kecamatan tertentu.
     * Digunakan untuk memastikan Admin Kecamatan hanya melihat data kecamatannya.
     */
    public function scopeForKecamatan(Builder $query, int|Kecamatan $kecamatan): Builder
    {
        $kecamatanId = $kecamatan instanceof Kecamatan ? $kecamatan->id : $kecamatan;
        return $query->where('kecamatan_id', $kecamatanId);
    }

    /**
     * Scope untuk menyaring berdasarkan status pengajuan.
     */
    public function scopeWithStatus(Builder $query, SubmissionStatus|string $status): Builder
    {
        $statusValue = $status instanceof SubmissionStatus ? $status->value : $status;
        return $query->where('status', $statusValue);
    }

    // ─────────────────────────────────────────────
    // Business Logic & Helpers
    // ─────────────────────────────────────────────

    /**
     * Generator Nomor Tiket Otomatis:
     * Format: TKT-YYYYMMDD-KECID-XXXX
     * Contoh: TKT-20260827-01-0001
     */
    public static function generateTicketNumber(int $kecamatanId): string
    {
        $today = Carbon::now()->format('Ymd');
        $kecCode = str_pad((string)$kecamatanId, 2, '0', STR_PAD_LEFT);
        $prefix = "TKT-{$today}-{$kecCode}";

        $lastSubmission = self::where('nomor_tiket', 'like', "{$prefix}-%")
            ->latest('id')
            ->first();

        if ($lastSubmission) {
            $lastNumber = (int) substr($lastSubmission->nomor_tiket, -4);
            $nextNumber = str_pad((string)($lastNumber + 1), 4, '0', STR_PAD_LEFT);
        } else {
            $nextNumber = '0001';
        }

        return "{$prefix}-{$nextNumber}";
    }

    /**
     * Cek apakah pengajuan membutuhkan perbaikan dokumen dari warga.
     */
    public function isRevisionRequired(): bool
    {
        return $this->status === SubmissionStatus::RevisionRequired;
    }

    /**
     * Cek apakah pengajuan sudah selesai.
     */
    public function isCompleted(): bool
    {
        return $this->status === SubmissionStatus::Completed;
    }
}
