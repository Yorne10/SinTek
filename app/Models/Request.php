<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $primaryKey = 'request_id';

    protected $fillable = [
        'worker_id',
        'process_id',
        'status',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function worker()
    {
        return $this->belongsTo(Worker::class, 'worker_id', 'workers_id');
    }

    public function process()
    {
        return $this->belongsTo(Process::class, 'process_id', 'process_id');
    }

    public function requestSteps()
    {
        return $this->hasMany(RequestStep::class, 'request_id', 'request_id');
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'request_id', 'request_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'request_id', 'request_id');
    }
}
