<?php

namespace App\Enums;

enum SubmissionStatus: string
{
    case Draft             = 'draft';
    case SubmittedDesa     = 'submitted_desa';
    case Submitted         = 'submitted';
    case InReview          = 'in_review';
    case RevisionRequired  = 'revision_required';
    case Processed         = 'processed';
    case Completed         = 'completed';
    case Rejected          = 'rejected';

    /**
     * Label representasi status pengajuan.
     */
    public function label(): string
    {
        return match($this) {
            self::Draft            => 'Draft Pengajuan',
            self::SubmittedDesa    => 'Menunggu Verifikasi Desa',
            self::Submitted        => 'Diajukan ke Kecamatan',
            self::InReview         => 'Sedang Diverifikasi Kecamatan',
            self::RevisionRequired => 'Perlu Perbaikan / Revisi',
            self::Processed        => 'Sedang Diproses',
            self::Completed        => 'Selesai',
            self::Rejected         => 'Ditolak',
        };
    }

    /**
     * Badge CSS class (Tailwind CSS) untuk UI yang modern & konsisten.
     */
    public function badgeColor(): string
    {
        return match($this) {
            self::Draft            => 'bg-slate-100 text-slate-700 border-slate-300',
            self::SubmittedDesa    => 'bg-amber-50 text-amber-800 border-amber-300',
            self::Submitted        => 'bg-blue-50 text-blue-700 border-blue-200',
            self::InReview         => 'bg-indigo-50 text-indigo-700 border-indigo-200',
            self::RevisionRequired => 'bg-amber-50 text-amber-800 border-amber-300',
            self::Processed        => 'bg-cyan-50 text-cyan-800 border-cyan-300',
            self::Completed        => 'bg-emerald-50 text-emerald-800 border-emerald-300',
            self::Rejected         => 'bg-rose-50 text-rose-800 border-rose-300',
        };
    }

    /**
     * Cek apakah status masih memungkinkan warga mengubah berkas/data.
     */
    public function isEditableByCitizen(): bool
    {
        return in_array($this, [self::Draft, self::RevisionRequired]);
    }

    /**
     * Cek apakah status sudah final.
     */
    public function isFinal(): bool
    {
        return in_array($this, [self::Completed, self::Rejected]);
    }
}
