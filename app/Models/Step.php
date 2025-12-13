<?php
/**
 * Company: CETAM
 * Project: ST
 * File: Step.php
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

class Step extends Model
{
    use HasFactory;

    protected $primaryKey = 'step_id';

    protected $fillable = [
        'process_id',
        'order',
        'title',              // Corrected from 'tittle'
        'instruction',        // Corrected from 'instructions' (singular)
        'step_type',          // Corrected from 'condition_type'
        'condition_question',
        'responsible_role',   // Corrected from 'responsible'
        'requires_documents',
        'next_step_id',
        'next_yes',
        'next_no',
        'finalization_message',
        'is_initial_step',
        'is_linked',
        'active',
    ];

    protected $casts = [
        'order' => 'integer',
        'requires_documents' => 'boolean',
        'is_initial_step' => 'boolean',
        'is_linked' => 'boolean',
        'active' => 'boolean',
    ];

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

     * Next step.

     *

     * @return void

     */

    public function nextStep()
    {
        return $this->belongsTo(Step::class, 'next_step_id', 'step_id');
    }

    /**

     * Next yes step.

     *

     * @return void

     */

    public function nextYesStep()
    {
        return $this->belongsTo(Step::class, 'next_yes', 'step_id');
    }

    /**

     * Next no step.

     *

     * @return void

     */

    public function nextNoStep()
    {
        return $this->belongsTo(Step::class, 'next_no', 'step_id');
    }

    /**

     * Request steps.

     *

     * @return void

     */

    public function requestSteps()
    {
        return $this->hasMany(RequestStep::class, 'step_id', 'step_id');
    }

    /**

     * Documents.

     *

     * @return void

     */

    public function documents()
    {
        return $this->hasMany(Document::class, 'step_id', 'step_id');
    }

    /**

     * Required documents.

     *

     * @return void

     */

    public function requiredDocuments()
    {
        return $this->hasMany(StepRequiredDocument::class, 'step_id', 'step_id');
    }
}
