<?php
/**
 * Empresa: CETAM
 * Proyecto: ST
 * Archivo: ConvocationDocument.php
 * Fecha de creación: 02/11/25
 * Realizado por: Alfonso Angel García Hernández
 * Validado por: Alfonso Angel García Hernández
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConvocationDocument extends Model
{
    use HasFactory;

    protected $table = 'convocation_docs';
    protected $primaryKey = 'convocation_doc_id';

    // This table only has created_at, no updated_at
    const UPDATED_AT = null;

    protected $fillable = [
        'convocation_id',
        'file_name',
        'mime_type',
        'file_content',
    ];

    protected $hidden = [
        'file_content',
    ];

    public function convocation()
    {
        return $this->belongsTo(Convocation::class, 'convocation_id', 'convocation_id');
    }
}
