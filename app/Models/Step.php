<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    use HasFactory;

    protected $primaryKey = 'step_id';

    protected $fillable = [
        'process_id',
        'order',
        'tittle',
        'description',
        'instructions',
        'condition_type',
        'responsible',
        'deadline_days',
        'priority',
        'send_notification',
        'requires_documents',
        'next_yes',
        'next_no',
    ];

    protected $casts = [
        'order' => 'integer',
        'deadline_days' => 'integer',
        'send_notification' => 'boolean',
        'requires_documents' => 'boolean',
    ];

    public function process()
    {
        return $this->belongsTo(Process::class, 'process_id', 'process_id');
    }

    public function nextYesStep()
    {
        return $this->belongsTo(Step::class, 'next_yes', 'step_id');
    }

    public function nextNoStep()
    {
        return $this->belongsTo(Step::class, 'next_no', 'step_id');
    }

    public function requestSteps()
    {
        return $this->hasMany(RequestStep::class, 'step_id', 'step_id');
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'step_id', 'step_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'steps_id', 'step_id');
    }
}
