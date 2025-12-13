<?php
/**
 * Company: CETAM
 * Project: ST
 * File: InstitutionalDocument.php
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

class InstitutionalDocument extends Model
{
    use HasFactory;

    protected $table = 'institucional_documents';
    protected $primaryKey = 'institucional_document_id';

    protected $fillable = [
        'title',
        'description',
        'category',
        'version',
        'status',
        'uploaded_by',
        'file_size',
        'file_content',
        'file_name',
        'mime_type',
        'effective_date',
    ];

    protected $hidden = [
        'file_content',
    ];

    protected $casts = [
        'effective_date' => 'date',
        'file_size' => 'integer',
        'uploaded_by' => 'integer',
    ];

    /**
     * Scope by category
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}
