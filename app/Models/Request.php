<?php
/**
 * Company: CETAM
 * Project: ST
 * File: Request.php
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

class Request extends Model
{
    use HasFactory;

    protected $primaryKey = 'request_id';

    protected $fillable = [
        'worker_id',
        'process_id',
        'status',
        'current_step_id',
        'start_date',
        'submitted_at',
        'completed_at',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'submitted_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    /**

     * Worker.

     *

     * @return void

     */

    public function worker()
    {
        return $this->belongsTo(Worker::class, 'worker_id', 'workers_id');
    }

    /**

     * Process.

     *

     * @return void

     */

    public function process()
    {
        return $this->belongsTo(Process::class, 'process_id', 'process_id');
    }

    /**

     * Current step.

     *

     * @return void

     */

    public function currentStep()
    {
        return $this->belongsTo(Step::class, 'current_step_id', 'step_id');
    }

    /**
     * Request steps.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function requestSteps()
    {
        return $this->hasMany(RequestStep::class, 'request_id', 'request_id');
    }
}
