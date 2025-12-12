<?php
/**
 * Company: CETAM
 * Project: ST
 * File: FaqCategory.php
 * Created on: 24/11/2025
 * Created by: Alfonso Angel García Hernández
 * Approved by: Alfonso Angel García Hernández
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FaqCategory extends Model
{
    protected $table = 'faqs_categories';
    protected $primaryKey = 'faq_category_id';

    protected $fillable = [
        'name',
        'description',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    /**
     * Get the FAQs for this category
     */
    public function faqs(): HasMany
    {
        return $this->hasMany(Faq::class, 'faq_category_id', 'faq_category_id');
    }

    /**
     * Scope to order by order field
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
