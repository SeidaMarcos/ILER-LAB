<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role_id', 'active',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relación con el modelo Role.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Relación con el modelo Student.
     */
    public function student()
    {
        return $this->hasOne(Student::class);
    }

    /**
     * Relación con el modelo Professor.
     */
    public function professor()
    {
        return $this->hasOne(Professor::class);
    }

    /**
     * Relación con el modelo Admin.
     */
    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    /**
     * Verificar si el usuario tiene un rol específico.
     *
     * @param string $roleName
     * @return bool
     */
    public function hasRole(string $roleName): bool
    {
        return $this->role && $this->role->name === $roleName;
    }

    /**
     * Verificar si el usuario es un administrador.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    /**
     * Verificar si el usuario es un estudiante.
     *
     * @return bool
     */
    public function isStudent(): bool
    {
        return $this->hasRole('student');
    }

    /**
     * Verificar si el usuario es un profesor.
     *
     * @return bool
     */
    public function isProfessor(): bool
    {
        return $this->hasRole('professor');
    }
}
