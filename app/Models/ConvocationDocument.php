<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConvocationDocument extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'convocation_document_id';

    protected $fillable = [
        'convocation_id',
        'title',
        'file_content',
    ];

    public function convocation()
    {
        return $this->belongsTo(Convocation::class, 'convocation_id', 'convocation_id');
    }
}
