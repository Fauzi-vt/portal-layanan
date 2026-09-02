<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Desa;
use App\Models\Kecamatan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserRoleSeeder extends Seeder
{
    /**
     * Seed user contoh untuk setiap role dalam sistem RBAC:
     * 1. Super Admin (Diskominfo / Kabupaten Tasikmalaya)
     * 2. Admin Kecamatan (Kecamatan Manonjaya)
     * 3. Warga / Masyarakat (Kecamatan Manonjaya - Desa Manonjaya)
     */
    public function run(): void
    {
        $manonjaya = Kecamatan::where('kode_kecamatan', 'KEC-017')->first();
        $desaManonjaya = Desa::where('kode_desa', '3206170001')->first();

        $users = [
            // 1. Role: Super Admin (Akses Global Kabupaten)
            [
                'nik'           => null,
                'name'          => 'Super Administrator Diskominfo',
                'email'         => 'superadmin@portal.test',
                'password'      => Hash::make('password'),
                'phone'         => '081234567890',
                'role'          => UserRole::SuperAdmin->value,
                'kecamatan_id'  => null,
                'desa_id'       => null,
                'alamat_detail' => 'Dinas Kominfo Kab. Tasikmalaya',
            ],

            // 2. Role: Admin Kecamatan (Wilayah: Kec. Manonjaya)
            [
                'nik'           => '3206170101850001',
                'name'          => 'Petugas Admin Kec. Manonjaya',
                'email'         => 'admin.manonjaya@portal.test',
                'password'      => Hash::make('password'),
                'phone'         => '081298765432',
                'role'          => UserRole::AdminKecamatan->value,
                'kecamatan_id'  => $manonjaya?->id,
                'desa_id'       => null,
                'alamat_detail' => 'Kantor Kecamatan Manonjaya, Tasikmalaya',
            ],

            // 3. Role: Warga / Masyarakat (Kec. Manonjaya, Desa Manonjaya)
            [
                'nik'           => '3206171505980001',
                'name'          => 'Ahmad Fauzi (Warga)',
                'email'         => 'warga@portal.test',
                'password'      => Hash::make('password'),
                'phone'         => '085712345678',
                'role'          => UserRole::Warga->value,
                'kecamatan_id'  => $manonjaya?->id,
                'desa_id'       => $desaManonjaya?->id,
                'alamat_detail' => 'Kp. Kaum Wetan RT 02 / RW 04 No. 15, Manonjaya',
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }

        $this->command->info('✅ User RBAC contoh berhasil di-seed:');
        $this->command->table(
            ['Nama', 'Email', 'Role', 'NIK', 'Kecamatan'],
            collect($users)->map(fn($u) => [
                $u['name'],
                $u['email'],
                UserRole::from($u['role'])->label(),
                $u['nik'] ?? '-',
                $u['kecamatan_id'] ? 'Kec. Manonjaya' : 'Kabupaten Tasikmalaya',
            ])->toArray()
        );
    }
}
