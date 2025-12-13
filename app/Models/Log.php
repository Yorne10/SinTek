<?php
/**
 * Company: CETAM
 * Project: ST
 * File: Log.php
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
