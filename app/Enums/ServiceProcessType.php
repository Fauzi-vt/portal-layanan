<?php

namespace App\Enums;

enum ServiceProcessType: string
{
    case FullDigital = 'full_digital';
    case Hybrid      = 'hybrid';

    /**
     * Label representasi jenis proses layanan.
     */
    public function label(): string
    {
        return match($this) {
            self::FullDigital => 'Layanan Digital Penuh',
            self::Hybrid      => 'Layanan Hybrid (Fisik & Digital)',
        };
    }

    /**
     * Keterangan alur layanan.
     */
    public function description(): string
    {
        return match($this) {
            self::FullDigital => 'Seluruh proses pengajuan, verifikasi, hingga penerbitan dokumen dilakukan secara online.',
            self::Hybrid      => 'Memerlukan langkah fisik seperti perekaman biometrik di kecamatan atau tanda tangan basah form dari Desa/KUA.',
        };
    }

    /**
     * Warna badge Tailwind.
     */
    public function badgeColor(): string
    {
        return match($this) {
            self::FullDigital => 'bg-teal-100 text-teal-800 border-teal-200',
            self::Hybrid      => 'bg-amber-100 text-amber-800 border-amber-200',
        };
    }
}
