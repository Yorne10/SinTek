<?php
/**
 * Company: CETAM
 * Project: ST
 * File: Convocation.php
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

class Convocation extends Model
{
    use HasFactory;

    protected $primaryKey = 'convocation_id';

    protected $fillable = [
        'title',
        'description',
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
        return $this->hasMany(Notification::class, 'convocation_id', 'convocation_id');
    }

    public function documents()
    {
        return $this->hasMany(ConvocationDocument::class, 'convocation_id', 'convocation_id');
    }
}
