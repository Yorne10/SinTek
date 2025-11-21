<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $primaryKey = 'notification_id';

    protected $fillable = [
        'request_id',
        'user_id',
        'steps_id',
        'convocations_id',
        'tittle',
        'message',
        'read_at',
        'type',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    public function request()
    {
        return $this->belongsTo(Request::class, 'request_id', 'request_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'users_id');
    }

    public function step()
    {
        return $this->belongsTo(Step::class, 'steps_id', 'step_id');
    }

    public function convocation()
    {
        return $this->belongsTo(Convocation::class, 'convocations_id', 'convocation_id');
    }
}
