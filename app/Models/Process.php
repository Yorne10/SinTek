<?php
/**
 * Company: CETAM
 * Project: ST
 * File: Process.php
 * Created on: 02/11/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 *
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
    use HasFactory;

    protected $primaryKey = 'process_id';

    protected $fillable = [
        'name',
        'description',
        'active',
        'created_by',
        'process_code',
        'category',
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
