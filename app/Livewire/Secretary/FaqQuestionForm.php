<?php
/**
 * Company: CETAM
 * Project: ST
 * File: FaqQuestionForm.php
 * Created on: 10/12/2025
 * Created by: Codex
 * Approved by: Alfonso Angel Garcia Hernandez
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
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
    public $faqOrder = 1;
    public $maxOrder = 1;
    public $originalOrder = 1;

    protected function rules(): array
    {
        $max = max(1, $this->maxOrder);
        return [
            'faqQuestion' => 'required|string|max:255',
            'faqAnswer' => 'required|string',
            'faqOrder' => 'required|integer|min:1|max:' . $max,
        ];
    }

    protected $messages = [
        'faqQuestion.required' => 'La pregunta es obligatoria.',
        'faqQuestion.max' => 'La pregunta no debe exceder 255 caracteres.',
        'faqAnswer.required' => 'La respuesta es obligatoria.',
        'faqOrder.required' => 'El orden es obligatorio.',
        'faqOrder.integer' => 'El orden debe ser numérico.',
        'faqOrder.min' => 'El orden debe ser al menos 1.',
        'faqOrder.max' => 'El orden no puede exceder el máximo disponible.',
    ];

    public function mount($categoryId, $faqId = null): void
    {
        $this->categoryId = $categoryId;
        $this->category = FaqCategory::findOrFail($categoryId);
        $this->maxOrder = Faq::where('faq_category_id', $categoryId)->count() + ($faqId ? 0 : 1);

        if ($faqId) {
            $this->faqId = $faqId;
            $faq = Faq::where('faq_category_id', $categoryId)->findOrFail($faqId);
            $this->faqQuestion = $faq->question;
            $this->faqAnswer = $faq->answer;
            $this->faqOrder = max(1, (int) $faq->order);
            $this->originalOrder = $this->faqOrder;
        } else {
            // alta: siguiente orden disponible
            $this->faqOrder = $this->maxOrder;
            $this->originalOrder = $this->maxOrder;
        }
    }

    public function save(): void
    {
        $this->validate();

        try {
            $isEditing = (bool) $this->faqId;

            if ($isEditing) {
                $faq = Faq::findOrFail($this->faqId);
                $faq->question = $this->faqQuestion;
                $faq->answer = $this->faqAnswer;
                $faq->order = $this->faqOrder;
                $faq->save();
                $message = 'Pregunta actualizada exitosamente.';
                $action = 'actualizada';
            } else {
                $faq = Faq::create([
                    'faq_category_id' => $this->categoryId,
                    'question' => $this->faqQuestion,
                    'answer' => $this->faqAnswer,
                    'order' => $this->faqOrder,
                ]);
                $message = 'Pregunta creada exitosamente.';
                $action = 'creada';
            }

            $this->reorderFaqs($faq);
            $this->maxOrder = Faq::where('faq_category_id', $this->categoryId)->count();

            $user = auth()->user();
            ActivityLogger::log(
                $isEditing ? 'faq.editar' : 'faq.crear',
                "FAQ '{$this->faqQuestion}' {$action} en categoría '{$this->category->name}'",
                $user?->users_id
            );

            if ($isEditing) {
                // En edición: redirigir después de mostrar alerta
                $redirect = route(config('proj.route_name_prefix', 'proj') . '.faq.questions', $this->categoryId);
                $this->dispatch('faq-saved', type: 'success', title: 'Éxito', message: $message, redirect: $redirect);
            } else {
                // En creación: limpiar formulario y quedarse
                $this->reset(['faqQuestion', 'faqAnswer']);
                $this->maxOrder = Faq::where('faq_category_id', $this->categoryId)->count() + 1;
                $this->faqOrder = $this->maxOrder;
                $this->dispatch('faq-saved', type: 'success', title: 'Éxito', message: $message, redirect: null);
            }
        } catch (\Exception $e) {
            $this->dispatch('faq-error', type: 'error', title: 'Error', message: 'No se pudo guardar la pregunta.');
        }
    }

    protected function reorderFaqs(Faq $current): void
    {
        $others = Faq::where('faq_category_id', $this->categoryId)
            ->where('faq_id', '!=', $current->faq_id)
            ->orderBy('order')
            ->orderBy('faq_id')
            ->get()
            ->values();

        $desired = max(1, (int) $this->faqOrder);
        $desired = min($desired, $others->count() + 1);

        $ordered = $others->toArray();
        array_splice($ordered, $desired - 1, 0, [$current]);

        $order = 1;
        foreach ($ordered as $row) {
            $faq = $row instanceof Faq ? $row : Faq::find($row['faq_id']);
            if ($faq) {
                $faq->order = $order++;
                $faq->save();
            }
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

            // Renumerar FAQs restantes
            $remainingFaqs = Faq::where('faq_category_id', $this->categoryId)->orderBy('order')->get();
            $order = 1;
            foreach ($remainingFaqs as $f) {
                $f->order = $order++;
                $f->save();
            }

            $user = auth()->user();
            ActivityLogger::log(
                'faq.eliminar',
                "FAQ '{$question}' eliminada de categoría '{$this->category->name}'",
                $user?->users_id
            );

            $redirect = route(config('proj.route_name_prefix', 'proj') . '.faq.questions', $this->categoryId);
            $this->dispatch('faq-saved', type: 'success', title: 'Eliminada', message: 'Pregunta eliminada exitosamente.', redirect: $redirect);
        } catch (\Exception $e) {
            $this->dispatch('faq-error', type: 'error', title: 'Error', message: 'No se pudo eliminar la pregunta.');
        }
    }

    public function render()
    {
        return view('modules.secretary.faq-question-form')->layout('layouts.app');
    }
}
