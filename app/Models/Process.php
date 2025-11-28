<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Process extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'process_id';

    protected $fillable = [
        'name',
        'description',
        'active',
        'created_by',
        'process_code',
        'category',
        'priority',
        'deadline_days',
        'department',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'users_id');
    }

    public function steps()
    {
        return $this->hasMany(Step::class, 'process_id', 'process_id');
    }

    public function requests()
    {
        return $this->hasMany(Request::class, 'process_id', 'process_id');
    }
}
