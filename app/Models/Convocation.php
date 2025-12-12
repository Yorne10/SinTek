<?php
/**
 * Empresa: CETAM
 * Proyecto: ST
 * Archivo: Convocation.php
 * Fecha de creación: 02/11/25
 * Realizado por: Alfonso Angel García Hernández
 * Validado por: Alfonso Angel García Hernández
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Convocation extends Model
{
    use HasFactory;

    protected $primaryKey = 'convocation_id';

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'convocation_id', 'convocation_id');
    }

    public function documents()
    {
        return $this->hasMany(ConvocationDocument::class, 'convocation_id', 'convocation_id');
    }
}
