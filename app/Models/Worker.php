<?php
/**
 * Company: CETAM
 * Project: ST
 * File: Worker.php
 * Created on: 02/11/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 *
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
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
