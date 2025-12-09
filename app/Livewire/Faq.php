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

    public function render()
    {
        // Get categories with active FAQs
        $categories = FaqCategory::active()
            ->with([
                'activeFaqs' => function ($query) {
                    $query->orderBy('order');
                }
            ])
            ->ordered()
            ->get();

        // Filter FAQs by search and category
        $faqs = FaqModel::active()
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

        return view('modules.faq', [
            'categories' => $categories,
            'faqs' => $faqs,
        ])->layout('layouts.app');
    }
}

