<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $primaryKey = 'faq_id';

    protected $fillable = [
        'question',
        'answer',
        'category',
        'status',
    ];

    protected $casts = [
        'status' => 'integer',
    ];
}
