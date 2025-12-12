<?php
/**
 * Company: CETAM
 * Project: ST
 * File: PreguntasFrecuentes.php
 * Created on: 24/11/2025
 * Modified by: Codex
 * Approved by: Alfonso Angel García Hernández
 */

namespace App\Livewire;

use App\Models\Faq as FaqModel;
use App\Models\FaqCategory;
use Livewire\Component;

class Faq extends Component
{
    public $search = '';
    public $selectedCategoryId = null;

    public function clearFilters(): void
    {
        $this->search = '';
        $this->selectedCategoryId = null;
    }

    public function render()
    {
        // Get categories with their FAQs
        $categories = FaqCategory::when($this->selectedCategoryId, function ($query) {
                $query->where('faq_category_id', $this->selectedCategoryId);
            })
            ->with([
                'faqs' => function ($query) {
                    $query->ordered();
                }
            ])
            ->ordered()
            ->get();

        // Filter FAQs by search and category
        $faqs = FaqModel::query()
            ->with('category')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $term = '%' . $this->search . '%';
                    $q->where('question', 'like', $term)
                        ->orWhere('answer', 'like', $term);
                });
            })
            ->when($this->selectedCategoryId, function ($query) {
                $query->where('faq_category_id', $this->selectedCategoryId);
            })
            ->ordered()
            ->get()
            ->groupBy('faq_category_id');

        // If no specific category selected, hide categories without FAQs when searching
        if ($this->search || $this->selectedCategoryId) {
            $categories = $categories->filter(function ($category) use ($faqs) {
                return $faqs->has($category->faq_category_id);
            });
        }

        return view('modules.faq', [
            'categories' => $categories,
            'faqs' => $faqs,
        ])->layout('layouts.app');
    }
}

