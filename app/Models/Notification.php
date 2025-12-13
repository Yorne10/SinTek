<?php
/**
 * Company: CETAM
 * Project: ST
 * File: Notification.php
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

class Notification extends Model
{
    use HasFactory;

    protected $primaryKey = 'notification_id';

    protected $fillable = [
        'user_id',
        'convocation_id',  // Corrected from 'convocations_id'
        'title',           // Corrected from 'tittle'
        'message',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    /**

     * User.

     *

     * @return void

     */

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'users_id');
    }

    /**

     * Convocation.

     *

     * @return void

     */

    public function convocation()
    {
        return $this->belongsTo(Convocation::class, 'convocation_id', 'convocation_id');
    }
}
