<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StepRequiredDocument extends Model
{
    use HasFactory;

    protected $primaryKey = 'step_required_document_id';

    protected $fillable = [
        'step_id',
        'title',
    ];

    public function step()
    {
        return $this->belongsTo(Step::class, 'step_id', 'step_id');
    }
}
