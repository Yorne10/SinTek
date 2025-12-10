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

    // FAQ properties
    public $faqQuestion = '';
    public $faqAnswer = '';
    public $faqOrder = 0;
    public $editingFaqId = null;

    // UI State
    public $showFaqForm = false;
    public $search = '';
    public $statusFilter = '';

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'faqQuestion' => 'required|string|max:255',
        'faqAnswer' => 'required|string',
        'faqOrder' => 'integer|min:0',
    ];

    protected $messages = [
        'faqQuestion.required' => 'La pregunta es obligatoria.',
        'faqQuestion.max' => 'La pregunta no debe exceder 255 caracteres.',
        'faqAnswer.required' => 'La respuesta es obligatoria.',
    ];

    protected $listeners = ['refreshFaqs' => '$refresh'];

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

    public function toggleFaqForm()
    {
        $this->showFaqForm = !$this->showFaqForm;
        if (!$this->showFaqForm) {
            $this->resetFaqForm();
        }
    }

    public function saveFaq()
    {
        $this->validate();

        try {
            if ($this->editingFaqId) {
                $faq = Faq::findOrFail($this->editingFaqId);
                $faq->update([
                    'question' => $this->faqQuestion,
                    'answer' => $this->faqAnswer,
                    'order' => $this->faqOrder,
                ]);
                $message = 'Pregunta actualizada exitosamente.';
            } else {
                Faq::create([
                    'faq_category_id' => $this->categoryId,
                    'question' => $this->faqQuestion,
                    'answer' => $this->faqAnswer,
                    'order' => $this->faqOrder,
                    'is_active' => true,
                ]);
                $message = 'Pregunta creada exitosamente.';
            }

            $user = auth()->user();
            $action = $this->editingFaqId ? 'actualizada' : 'creada';
            ActivityLogger::log(
                $this->editingFaqId ? 'faq.editar' : 'faq.crear',
                "FAQ '{$this->faqQuestion}' {$action} en categoría '{$this->category->name}'",
                $user?->users_id
            );

            $this->resetFaqForm();
            $this->showFaqForm = false;

            $this->dispatch('faq-notify', type: 'success', title: '¡Éxito!', message: $message);
        } catch (\Exception $e) {
            $this->dispatch('faq-notify', type: 'error', title: 'Error', message: 'No se pudo guardar la pregunta.');
        }
    }

    public function editFaq($faqId)
    {
        $faq = Faq::findOrFail($faqId);
        $this->editingFaqId = $faqId;
        $this->faqQuestion = $faq->question;
        $this->faqAnswer = $faq->answer;
        $this->faqOrder = $faq->order;
        $this->showFaqForm = true;
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

    public function deleteFaq($faqId)
    {
        try {
            $faq = Faq::findOrFail($faqId);
            $faq->delete();
            $user = auth()->user();
            ActivityLogger::log(
                'faq.eliminar',
                "FAQ '{$faq->question}' eliminada de categoría '{$this->category->name}'",
                $user?->users_id
            );

            $this->dispatch('faq-notify', type: 'success', title: '¡Eliminada!', message: 'Pregunta eliminada exitosamente.');
        } catch (\Exception $e) {
            $this->dispatch('faq-notify', type: 'error', title: 'Error', message: 'No se pudo eliminar la pregunta.');
        }
    }

    private function resetFaqForm()
    {
        $this->reset(['faqQuestion', 'faqAnswer', 'faqOrder', 'editingFaqId']);
        $this->resetValidation();
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
