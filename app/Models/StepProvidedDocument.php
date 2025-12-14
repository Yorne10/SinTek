<?php
/**
 * Company: CETAM
 * Project: ST
 * File: StepProvidedDocument.php
 * Created on: 14/12/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StepProvidedDocument extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'step_provided_documents';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'document_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'step_id',
        'name',
        'file_content',
        'mime_type',
    ];

    /**
     * Get the step that owns the document.
     */
    public function step()
    {
        return $this->belongsTo(Step::class, 'step_id', 'step_id');
    }
}
