<?php
/**
 * Empresa: CETAM
 * Proyecto: ST
 * Archivo: InstitutionalDocument.php
 * Fecha de creación: 02/11/25
 * Realizado por: Alfonso Angel García Hernández
 * Validado por: Alfonso Angel García Hernández
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
