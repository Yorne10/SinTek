<?php
/**
 * Empresa: CETAM
 * Proyecto: ST
 * Archivo: Position.php
 * Fecha de creación: 02/11/25
 * Realizado por: Alfonso Angel García Hernández
 * Validado por: Alfonso Angel García Hernández
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $primaryKey = 'positions_id';

    protected $fillable = [
        'budget_key',
        'position_name',
    ];

    public function workers()
    {
        return $this->belongsToMany(Worker::class, 'positions_workers', 'positions_id', 'worker_id', 'positions_id', 'workers_id');
    }
}
