<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pengguna extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, SoftDeletes, Notifiable;

    protected $table = 'pengguna';

    protected $fillable = [
        'nama',
        'email',
        'password',
        'role',
        'email_verified_at',
        'foto_profil',
        'provider_name',
        'provider_id',
        'provider_token',
        'permissions',
        'bio',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'permissions'       => 'array',
        ];
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'superadmin';
    }

    public function hasPermission(string $module): bool
    {
        // Super admin otomatis punya semua izin
        if ($this->isSuperAdmin()) {
            return true;
        }

        // Jika array permissions tidak kosong, cek apakah $module ada di dalamnya
        return is_array($this->permissions) && in_array($module, $this->permissions);
    }

    public function isVerified(): bool
    {
        return !is_null($this->email_verified_at);
    }

    /** Inisial nama untuk avatar */
    public function getInitialsAttribute(): string
    {
        $parts = explode(' ', trim($this->nama));
        $init  = strtoupper(substr($parts[0], 0, 1));
        if (isset($parts[1])) {
            $init .= strtoupper(substr($parts[1], 0, 1));
        }
        return $init;
    }

    public function logAktivitas()
    {
        return $this->hasMany(LogAktivitas::class, 'pengguna_id');
    }

    public function pengguna_tulisan()
    {
        return $this->hasMany(PenggunaTulisan::class, 'pengguna_id');
    }

    /**
     * Relasi ke data langganan pengguna (3NF: via pengguna_id FK).
     */
    public function subscriber()
    {
        return $this->hasOne(Subscriber::class, 'pengguna_id');
    }

    /**
     * Cek apakah pengguna ini memiliki langganan Premium yang aktif.
     */
    public function isPremium(): bool
    {
        return $this->subscriber && $this->subscriber->is_active;
    }
}
