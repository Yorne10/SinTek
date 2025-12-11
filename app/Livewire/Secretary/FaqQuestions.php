<?php
/**
 * Company: CETAM
 * Project: ST
 * File: FaqQuestions.php
 * Created on: 09/12/2025
 * Created by: Codex
 * Approved by: Alfonso Angel García Hernández
 */

namespace App\Livewire\Secretary;

use App\Models\Faq;
use App\Models\FaqCategory;
use App\Services\ActivityLogger;
use Livewire\Component;
use Livewire\WithPagination;

class FaqQuestions extends Component
{
    use WithPagination;

    public $categoryId;
    public $category;
    public $search = '';
    public $statusFilter = '';

    protected $paginationTheme = 'bootstrap';

    public function mount($categoryId)
    {
        $this->categoryId = $categoryId;
        $this->category = FaqCategory::findOrFail($categoryId);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->statusFilter = '';
        $this->resetPage();
    }

    public function toggleFaqStatus($faqId)
    {
        try {
            $faq = Faq::findOrFail($faqId);
            $faq->is_active = !$faq->is_active;
            $faq->save();

            $status = $faq->is_active ? 'activada' : 'desactivada';
            $this->dispatch('faq-notify', type: 'success', title: 'Estado actualizado', message: "Pregunta {$status} exitosamente.");
        } catch (\Exception $e) {
            $this->dispatch('faq-notify', type: 'error', title: 'Error', message: 'No se pudo cambiar el estado.');
        }
    }

    public function render()
    {
        $query = Faq::where('faq_category_id', $this->categoryId);

        // Apply search filter
        if ($this->search) {
            $query->where(function($q) {
                $q->where('question', 'like', '%' . $this->search . '%')
                  ->orWhere('answer', 'like', '%' . $this->search . '%');
            });
        }

        // Apply status filter
        if ($this->statusFilter === 'active') {
            $query->where('is_active', true);
        } elseif ($this->statusFilter === 'inactive') {
            $query->where('is_active', false);
        }

        $faqs = $query->orderBy('order')->paginate(15);

        return view('modules.secretary.faq-questions', [
            'faqs' => $faqs,
        ])->layout('layouts.app');
    }
}
