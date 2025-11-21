<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Convocation extends Model
{
    use HasFactory;

    protected $primaryKey = 'convocation_id';

    protected $fillable = [
        'title',
        'description',
        'file_path',
        'start_date',
        'end_date',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'convocations_id', 'convocation_id');
    }
}
