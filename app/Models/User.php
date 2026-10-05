<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'is_active'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // Relasi dengan Dokter
    public function dokter()
    {
        return $this->hasOne(Dokter::class);
    }

    // Relasi dengan Perawat
    public function perawat()
    {
        return $this->hasOne(Perawat::class);
    }

    // Helper methods untuk cek role
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isDokter()
    {
        return $this->role === 'dokter';
    }

    public function isPerawat()
    {
        return $this->role === 'perawat';
    }

    public function isKasir()
    {
        return $this->role === 'kasir';
    }

    public function isFarmasi()
    {
        return $this->role === 'farmasi';
    }

    public function isLaboratorium()
    {
        return $this->role === 'laboratorium';
    }

    public function isRadiologi()
    {
        return $this->role === 'radiologi';
    }
}
