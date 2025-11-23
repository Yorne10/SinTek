<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConvocationDocument extends Model
{
    use HasFactory;

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
