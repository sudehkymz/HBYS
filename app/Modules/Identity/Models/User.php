<?php

namespace App\Modules\Identity\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'is_active',
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
            'is_active'         => 'boolean',
        ];
    }

    /**
     * Rol için Türkçe etiket döner.
     */
    public function getRoleLabelAttribute(): string
    {
        return match ($this->role) {
            'admin'                 => 'Yönetici',
            'physician'             => 'Doktor',
            'nurse'                 => 'Hemşire',
            'receptionist'          => 'Resepsiyon',
            'pharmacist'            => 'Eczacı',
            'lab_technician'        => 'Laboratuvar Teknisyeni',
            'radiology_technician'  => 'Radyoloji Teknisyeni',
            'manager'               => 'Müdür',
            default                 => ucfirst($this->role),
        };
    }

    /**
     * Kullanıcı aktif mi kontrolü.
     */
    public function isActive(): bool
    {
        return $this->is_active;
    }

    /**
     * Kullanıcı admin mi?
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Kullanıcı hekim / doktor mu?
     */
    public function isPhysician(): bool
    {
        return in_array($this->role, ['physician', 'chief_physician']);
    }

    /**
     * Kullanıcı eczacı mı?
     */
    public function isPharmacist(): bool
    {
        return $this->role === 'pharmacist';
    }

    /**
     * Kullanıcı hemşire mi?
     */
    public function isNurse(): bool
    {
        return $this->role === 'nurse';
    }

    /**
     * Kullanıcı sekreter / kayıt danışma mı?
     */
    public function isReceptionist(): bool
    {
        return $this->role === 'receptionist';
    }

    /**
     * Belirtilen rollerden herhangi birine sahip mi?
     */
    public function hasRole(array|string $roles): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        $roles = is_array($roles) ? $roles : func_get_args();
        return in_array($this->role, $roles);
    }
}