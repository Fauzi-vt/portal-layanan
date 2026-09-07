<?php

namespace App\Models;

use App\Enums\SubmissionStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubmissionHistory extends Model
{
    use HasFactory;

    protected $table = 'submission_histories';

    protected $fillable = [
        'submission_id',
        'user_id',
        'action',
        'old_status',
        'new_status',
        'catatan',
    ];

    /**
     * Relasi ke Pengajuan induk.
     */
    public function submission(): BelongsTo
    {
        return $this->belongsTo(Submission::class, 'submission_id');
    }

    /**
     * Relasi ke Pengguna/Petugas yang melakukan aksi.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Label representasi nama status baru untuk UI.
     */
    public function getNewStatusLabelAttribute(): string
    {
        $status = SubmissionStatus::tryFrom($this->new_status);
        return $status ? $status->label() : $this->new_status;
    }

    /**
     * Badge CSS color untuk UI.
     */
    public function getBadgeColorAttribute(): string
    {
        $status = SubmissionStatus::tryFrom($this->new_status);
        return $status ? $status->badgeColor() : 'bg-slate-100 text-slate-700 border-slate-300';
    }
}
