<?php

namespace App\Enums;

enum UserRole: string
{
    case Warga          = 'warga';
    case AdminDesa      = 'admin_desa';
    case AdminKecamatan = 'admin_kecamatan';
    case SuperAdmin     = 'super_admin';

    /**
     * Label ramah untuk ditampilkan di UI.
     */
    public function label(): string
    {
        return match($this) {
            self::Warga          => 'Warga / Masyarakat',
            self::AdminDesa      => 'Kasi Pelayanan (Desa)',
            self::AdminKecamatan => 'Admin Kecamatan',
            self::SuperAdmin     => 'Super Admin (Diskominfo/Kabupaten)',
        };
    }

    /**
     * Warna badge untuk UI Tailwind.
     */
    public function badgeColor(): string
    {
        return match($this) {
            self::Warga          => 'bg-blue-100 text-blue-800 border-blue-200',
            self::AdminDesa      => 'bg-amber-100 text-amber-800 border-amber-200',
            self::AdminKecamatan => 'bg-blue-100 text-[#0a2558] border-blue-200',
            self::SuperAdmin     => 'bg-blue-100 text-blue-800 border-blue-200',
        };
    }

    /**
     * Daftar semua role dalam format [value => label].
     */
    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(
            fn($role) => [$role->value => $role->label()]
        )->toArray();
    }

    /**
     * Urutan level akses (semakin tinggi semakin besar hak akses).
     */
    public function level(): int
    {
        return match($this) {
            self::Warga          => 1,
            self::AdminDesa      => 2,
            self::AdminKecamatan => 3,
            self::SuperAdmin     => 4,
        };
    }

    /**
     * Cek apakah role ini memiliki level minimal tertentu.
     */
    public function atLeast(self $role): bool
    {
        return $this->level() >= $role->level();
    }
}
