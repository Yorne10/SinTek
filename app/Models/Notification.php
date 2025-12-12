<?php
/**
 * Empresa: CETAM
 * Proyecto: ST
 * Archivo: Notification.php
 * Fecha de creación: 02/11/25
 * Realizado por: Alfonso Angel García Hernández
 * Validado por: Alfonso Angel García Hernández
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $primaryKey = 'notification_id';

    protected $fillable = [
        'user_id',
        'convocation_id',  // Corrected from 'convocations_id'
        'title',           // Corrected from 'tittle'
        'message',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'users_id');
    }

    public function convocation()
    {
        return $this->belongsTo(Convocation::class, 'convocation_id', 'convocation_id');
    }
}
