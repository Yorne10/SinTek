<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InstitutionalDocument extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'institutional_document_id';

    protected $fillable = [
        'title',
        'description',
        'category',
        'file_content',
        'file_name',
        'mime_type',
        'file_size',
        'version',
        'status',
        'effective_date',
        'uploaded_by',
    ];

    protected $hidden = [
        'file_content',
    ];

    protected $casts = [
        'effective_date' => 'date',
        'file_size' => 'integer',
    ];

    /**
     * Relación con el usuario que subió el documento
     */
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by', 'users_id');
    }

    /**
     * Obtener el tamaño del archivo en formato legible
     */
    public function getFileSizeHumanAttribute()
    {
        if (!$this->file_size) {
            return 'N/A';
        }

        $bytes = $this->file_size;
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }

    /**
     * Scopes
     */
    public function scopeVigente($query)
    {
        return $query->where('status', 'vigente');
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}
