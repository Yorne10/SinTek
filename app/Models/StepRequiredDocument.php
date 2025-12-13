<?php
/**
 * Company: CETAM
 * Project: ST
 * File: StepRequiredDocument.php
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

class StepRequiredDocument extends Model
{
    use HasFactory;

    protected $primaryKey = 'step_required_document_id';

    protected $fillable = [
        'step_id',
        'title',
    ];

    /**

     * Step.

     *

     * @return void

     */

    public function step()
    {
        return $this->belongsTo(Step::class, 'step_id', 'step_id');
    }
}
