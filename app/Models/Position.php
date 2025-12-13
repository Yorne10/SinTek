<?php
/**
 * Company: CETAM
 * Project: ST
 * File: Position.php
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

class Position extends Model
{
    use HasFactory;

    protected $primaryKey = 'positions_id';

    protected $fillable = [
        'budget_key',
        'position_name',
    ];

    /**

     * Workers.

     *

     * @return void

     */

    public function workers()
    {
        return $this->belongsToMany(
            Worker::class,
            'positions_workers',
            'positions_id',  // FK in pivot table
            'workers_id'     // Related key in pivot table
        )->withPivot('assigned_at');
    }
}
