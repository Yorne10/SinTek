<?php
/**
 * Company: CETAM
 * Project: ST
 * File: RequestStep.php
 * Created on: 12/12/2025
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

class RequestStep extends Model
{
    use HasFactory;

    protected $primaryKey = 'request_step_id';

    protected $fillable = [
        'request_id',
        'step_id',
        'user_id',
        'request_step_status',
        'step_date',
    ];

    protected $casts = [
        'step_date' => 'datetime',
    ];

    public function request()
    {
        return $this->belongsTo(Request::class, 'request_id', 'request_id');
    }

    public function step()
    {
        return $this->belongsTo(Step::class, 'step_id', 'step_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'users_id');
    }
}
