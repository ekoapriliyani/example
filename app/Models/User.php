<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable([
    'name',
    'email',
    'password',
    'role',
])]
#[Hidden([
    'password',
    'remember_token',
])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    // constants role
    public const INSPECTOR = 'inspector';
    public const SUPERVISOR = 'supervisor';
    public const MANAGER = 'manager';
    public const ADMINISTRATOR = 'administrator';

    /**
     * Attribute casting
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check role
     */
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    public function hasAnyRole(array $roles): bool
    {
        return in_array($this->role, $roles);
    }

    public function isInspector(): bool
    {
        return $this->role === self::INSPECTOR;
    }

    public function isSupervisor(): bool
    {
        return $this->role === self::SUPERVISOR;
    }

    public function isManager(): bool
    {
        return $this->role === self::MANAGER;
    }

    public function isAdministrator(): bool
    {
        return $this->role === self::ADMINISTRATOR;
    }

    /**
     * Relations
     */
    public function incomingbahanbakuinspeksi()
    {
        return $this->hasMany(IncomingBahanBakuInspeksi::class);
    }

    public function inspeksisheetgalvalize()
    {
        return $this->hasMany(InspeksiSheetGalvanize::class);
    }

    public function incomingpvchdpeinspeksi()
    {
        return $this->hasMany(IncomingPvcHdpeInspeksi::class);
    }

    public function incomingprojectinspeksi()
    {
        return $this->hasMany(IncomingProjectInspeksi::class);
    }
}