<?php
/**
 * Empresa: CETAM
 * Proyecto: ST
 * Archivo: Log.php
 * Fecha de creación: 02/11/25
 * Realizado por: Alfonso Angel García Hernández
 * Validado por: Alfonso Angel García Hernández
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;
    use \App\Traits\EnsuresUtf8;

    protected $primaryKey = 'logs_id';

    // This table only has created_at, no updated_at
    const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'action',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'users_id');
    }

    /**
     * Accessor for action attribute to ensure UTF-8 encoding.
     */
    public function getActionAttribute($value)
    {
        return $this->ensureUtf8($value);
    }

    /**
     * Accessor for description attribute to ensure UTF-8 encoding.
     */
    public function getDescriptionAttribute($value)
    {
        return $this->ensureUtf8($value);
    }
}
