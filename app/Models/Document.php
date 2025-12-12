<?php
/**
 * Empresa: CETAM
 * Proyecto: ST
 * Archivo: Document.php
 * Fecha de creación: 02/11/25
 * Realizado por: Alfonso Angel García Hernández
 * Validado por: Alfonso Angel García Hernández
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $primaryKey = 'document_id';

    protected $fillable = [
        'request_id',
        'step_id',
        'file_content',
        'name',
        'mime_type',
    ];

    protected $hidden = [
        'file_content',
    ];

    public function request()
    {
        return $this->belongsTo(Request::class, 'request_id', 'request_id');
    }

    public function step()
    {
        return $this->belongsTo(Step::class, 'step_id', 'step_id');
    }
}
