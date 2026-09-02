<?php

namespace App\Enums;

enum DocumentValidationStatus: string
{
    case Pending = 'pending';
    case Valid   = 'valid';
    case Invalid = 'invalid';

    /**
     * Label status verifikasi dokumen.
     */
    public function label(): string
    {
        return match($this) {
            self::Pending => 'Menunggu Validasi',
            self::Valid   => 'Dokumen Sesuai (Valid)',
            self::Invalid => 'Dokumen Tidak Sesuai (Perlu Diperbaiki)',
        };
    }

    /**
     * Badge CSS class (Tailwind CSS).
     */
    public function badgeColor(): string
    {
        return match($this) {
            self::Pending => 'bg-amber-100 text-amber-800 border-amber-200',
            self::Valid   => 'bg-emerald-100 text-emerald-800 border-emerald-200',
            self::Invalid => 'bg-rose-100 text-rose-800 border-rose-200',
        };
    }
}
