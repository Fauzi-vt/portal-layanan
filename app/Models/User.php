<?php

namespace App\Models;

use App\Enums\UserRole;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'nik',
        'name',
        'email',
        'password',
        'phone',
        'role',
        'kecamatan_id',
        'desa_id',
        'alamat_detail',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'role'              => UserRole::class,
        ];
    }

    // ─────────────────────────────────────────────
    // Relasi Eloquent
    // ─────────────────────────────────────────────

    /**
     * Relasi ke Kecamatan (domisili warga / wilayah kerja admin kecamatan).
     */
    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }

    /**
     * Relasi ke Desa domisili (khusus role warga).
     */
    public function desa(): BelongsTo
    {
        return $this->belongsTo(Desa::class, 'desa_id');
    }

    /**
     * Relasi ke seluruh Pengajuan Layanan yang dibuat oleh user ini.
     */
    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class, 'user_id');
    }

    // ─────────────────────────────────────────────
    // Role Helpers & Checks
    // ─────────────────────────────────────────────

    public function isWarga(): bool
    {
        return $this->role === UserRole::Warga;
    }

    public function isAdminKecamatan(): bool
    {
        return $this->role === UserRole::AdminKecamatan;
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === UserRole::SuperAdmin;
    }

    /**
     * Cek apakah user memiliki salah satu role tertentu.
     *
     * @param  UserRole|string|array<UserRole|string>  $roles
     */
    public function hasRole(UserRole|string|array $roles): bool
    {
        $roles = is_array($roles) ? $roles : [$roles];

        foreach ($roles as $role) {
            $enumRole = $role instanceof UserRole ? $role : UserRole::tryFrom($role);
            if ($this->role === $enumRole) {
                return true;
            }
        }

        return false;
    }

    /**
     * Cek apakah level akses user minimal sama dengan role yang diberikan.
     */
    public function hasMinRole(UserRole $minimumRole): bool
    {
        return $this->role->atLeast($minimumRole);
    }

    /**
     * Label nama role untuk UI.
     */
    public function getRoleLabelAttribute(): string
    {
        return $this->role?->label() ?? '-';
    }
}
