<?php

namespace App\Enums;

enum UserRole: string
{
    case Warga          = 'warga';
    case AdminKecamatan = 'admin_kecamatan';
    case SuperAdmin     = 'super_admin';

    /**
     * Label ramah untuk ditampilkan di UI.
     */
    public function label(): string
    {
        return match($this) {
            self::Warga          => 'Warga / Masyarakat',
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
            self::AdminKecamatan => 'bg-emerald-100 text-emerald-800 border-emerald-200',
            self::SuperAdmin     => 'bg-purple-100 text-purple-800 border-purple-200',
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
            self::AdminKecamatan => 2,
            self::SuperAdmin     => 3,
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
