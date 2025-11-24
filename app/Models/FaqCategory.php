<?php
/**
 * Company: CETAM
 * Project: ST
 * File: FaqCategory.php
 * Created on: 24/11/2025
 * Created by: Codex
 * Approved by: Alfonso Angel García Hernández
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FaqCategory extends Model
{
    use SoftDeletes;

    protected $table = 'faq_categories';
    protected $primaryKey = 'faq_category_id';

    protected $fillable = [
        'name',
        'description',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
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
     * Get only active FAQs for this category
     */
    public function activeFaqs(): HasMany
    {
        return $this->hasMany(Faq::class, 'faq_category_id', 'faq_category_id')
                    ->where('is_active', true)
                    ->orderBy('order');
    }

    /**
     * Scope to get only active categories
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to order by order field
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
