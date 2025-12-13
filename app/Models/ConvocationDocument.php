<?php
/**
 * Company: CETAM
 * Project: ST
 * File: ConvocationDocument.php
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
