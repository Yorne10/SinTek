<?php
/**
 * Empresa: CETAM
 * Proyecto: ST
 * Archivo: User.php
 * Fecha de creación: 02/11/25
 * Realizado por: Alfonso Angel García Hernández
 * Validado por: Alfonso Angel García Hernández
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;
    use \App\Traits\EnsuresUtf8;

    protected $primaryKey = 'users_id';

    /**
     * Accessor for name to ensure UTF-8.
     */
    public function getNameAttribute($value)
    {
        return $this->ensureUtf8($value);
    }

    /**
     * Accessor for email to ensure UTF-8.
     */
    public function getEmailAttribute($value)
    {
        return $this->ensureUtf8($value);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Relationship: User has one Worker profile
     */
    public function worker()
    {
        return $this->hasOne(Worker::class, 'user_id', 'users_id');
    }

    public function createdProcesses()
    {
        return $this->hasMany(Process::class, 'created_by', 'users_id');
    }

    public function requestSteps()
    {
        return $this->hasMany(RequestStep::class, 'user_id', 'users_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id', 'users_id');
    }

    public function logs()
    {
        return $this->hasMany(Log::class, 'user_id', 'users_id');
    }

    /**
     * Helper methods para verificar roles
     */
    public function isWorker(): bool
    {
        return $this->role === 'worker';
    }

    public function isSecretary(): bool
    {
        return $this->role === 'secretary';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    public function hasAnyRole(array $roles): bool
    {
        return in_array($this->role, $roles);
    }
}
