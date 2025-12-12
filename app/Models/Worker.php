<?php
/**
 * Empresa: CETAM
 * Proyecto: ST
 * Archivo: Worker.php
 * Fecha de creación: 02/11/25
 * Realizado por: Alfonso Angel García Hernández
 * Validado por: Alfonso Angel García Hernández
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    use HasFactory;

    protected $primaryKey = 'workers_id';

    protected $fillable = [
        'user_id',
        'curp',
        'sex',
        'phone',
        'address',  // Corrected from 'adress'
        'rfc',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'users_id');
    }

    public function positions()
    {
        return $this->belongsToMany(
            Position::class,
            'positions_workers',
            'workers_id',  // FK in pivot table
            'positions_id' // Related key in pivot table
        )->withPivot('assigned_at');
    }

    public function requests()
    {
        return $this->hasMany(Request::class, 'worker_id', 'workers_id');
    }
}
