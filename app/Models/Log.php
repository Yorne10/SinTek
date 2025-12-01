<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    use \App\Traits\EnsuresUtf8;

    protected $primaryKey = 'logs_id';

    protected $fillable = [
        'user_id',
        'action',
        'description',
        'date',
    ];

    protected $casts = [
        'date' => 'datetime',
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
