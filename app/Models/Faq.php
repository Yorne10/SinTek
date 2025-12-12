<?php
/**
 * Company: CETAM
 * Project: ST
 * File: Faq.php
 * Created on: 24/11/2025
 * Created by: Alfonso Angel García Hernández
 * Approved by: Alfonso Angel García Hernández
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Faq extends Model
{
    use HasFactory;

    protected $table = 'faqs';
    protected $primaryKey = 'faq_id';

    protected $fillable = [
        'faq_category_id',
        'question',
        'answer',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    /**
     * Get the category for this FAQ
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(FaqCategory::class, 'faq_category_id', 'faq_category_id');
    }

    /**
     * Scope to order by order field
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
