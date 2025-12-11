<?php
/**
 * Company: CETAM
 * Project: ST
 * File: FaqQuestionForm.php
 * Created on: 10/12/2025
 * Created by: Codex
 * Approved by: Alfonso Angel Garcia Hernandez
 */

namespace App\Livewire\Secretary;

use App\Models\Faq;
use App\Models\FaqCategory;
use App\Services\ActivityLogger;
use Livewire\Component;

class FaqQuestionForm extends Component
{
    public $categoryId;
    public $category;
    public $faqId = null;
    public $faqQuestion = '';
    public $faqAnswer = '';
    public $faqOrder = 0;

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

    public function mount($categoryId, $faqId = null): void
    {
        $this->categoryId = $categoryId;
        $this->category = FaqCategory::findOrFail($categoryId);

        if ($faqId) {
            $this->faqId = $faqId;
            $faq = Faq::where('faq_category_id', $categoryId)->findOrFail($faqId);
            $this->faqQuestion = $faq->question;
            $this->faqAnswer = $faq->answer;
            $this->faqOrder = $faq->order;
        }
    }

    public function save(): void
    {
        $this->validate();

        try {
            if ($this->faqId) {
                $faq = Faq::findOrFail($this->faqId);
                $faq->update([
                    'question' => $this->faqQuestion,
                    'answer' => $this->faqAnswer,
                    'order' => $this->faqOrder,
                ]);
                $message = 'Pregunta actualizada exitosamente.';
                $action = 'actualizada';
            } else {
                Faq::create([
                    'faq_category_id' => $this->categoryId,
                    'question' => $this->faqQuestion,
                    'answer' => $this->faqAnswer,
                    'order' => $this->faqOrder,
                    'is_active' => true,
                ]);
                $message = 'Pregunta creada exitosamente.';
                $action = 'creada';
            }

            $user = auth()->user();
            ActivityLogger::log(
                $this->faqId ? 'faq.editar' : 'faq.crear',
                "FAQ '{$this->faqQuestion}' {$action} en categoría '{$this->category->name}'",
                $user?->users_id
            );

            $this->dispatch('faq-saved', type: 'success', title: '¡Éxito!', message: $message);
            $this->redirect(route(config('proj.route_name_prefix', 'proj') . '.faq.questions', $this->categoryId));
        } catch (\Exception $e) {
            $this->dispatch('faq-error', type: 'error', title: 'Error', message: 'No se pudo guardar la pregunta.');
        }
    }

    public function deleteFaq(): void
    {
        if (!$this->faqId) {
            return;
        }

        try {
            $faq = Faq::findOrFail($this->faqId);
            $question = $faq->question;
            $faq->delete();

            $user = auth()->user();
            ActivityLogger::log(
                'faq.eliminar',
                "FAQ '{$question}' eliminada de categoría '{$this->category->name}'",
                $user?->users_id
            );

            $this->dispatch('faq-deleted', type: 'success', title: '¡Eliminada!', message: 'Pregunta eliminada exitosamente.');
            $this->redirect(route(config('proj.route_name_prefix', 'proj') . '.faq.questions', $this->categoryId));
        } catch (\Exception $e) {
            $this->dispatch('faq-error', type: 'error', title: 'Error', message: 'No se pudo eliminar la pregunta.');
        }
    }

    public function render()
    {
        return view('modules.secretary.faq-question-form')->layout('layouts.app');
    }
}
