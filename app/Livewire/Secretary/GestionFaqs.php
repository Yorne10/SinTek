<?php
/**
 * Company: CETAM
 * Project: ST
 * File: GestionFaqs.php
 * Created on: 24/11/2025
 * Created by: Codex
 * Approved by: Alfonso Angel García Hernández
 */

namespace App\Livewire\Secretary;

use App\Models\Faq;
use App\Models\FaqCategory;
use Livewire\Component;
use Livewire\WithPagination;

class GestionFaqs extends Component
{
    use WithPagination;

    // Category properties
    public $categoryName = '';
    public $categoryDescription = '';
    public $categoryOrder = 0;
    public $editingCategoryId = null;

    // FAQ properties
    public $selectedCategoryId = null;
    public $faqQuestion = '';
    public $faqAnswer = '';
    public $faqOrder = 0;
    public $editingFaqId = null;

    // UI State
    public $showCategoryForm = false;
    public $showFaqForm = false;
    public $activeTab = 'categories'; // 'categories' or 'faqs'

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'categoryName' => 'required|string|max:100',
        'categoryDescription' => 'nullable|string',
        'categoryOrder' => 'integer|min:0',
        'selectedCategoryId' => 'required|exists:faq_categories,faq_category_id',
        'faqQuestion' => 'required|string|max:255',
        'faqAnswer' => 'required|string',
        'faqOrder' => 'integer|min:0',
    ];

    protected $messages = [
        'categoryName.required' => 'El nombre de la categoría es obligatorio.',
        'categoryName.max' => 'El nombre no debe exceder 100 caracteres.',
        'selectedCategoryId.required' => 'Debes seleccionar una categoría.',
        'selectedCategoryId.exists' => 'La categoría seleccionada no existe.',
        'faqQuestion.required' => 'La pregunta es obligatoria.',
        'faqQuestion.max' => 'La pregunta no debe exceder 255 caracteres.',
        'faqAnswer.required' => 'La respuesta es obligatoria.',
    ];

    public function toggleCategoryForm()
    {
        $this->showCategoryForm = !$this->showCategoryForm;
        if (!$this->showCategoryForm) {
            $this->resetCategoryForm();
        }
    }

    public function toggleFaqForm()
    {
        $this->showFaqForm = !$this->showFaqForm;
        if (!$this->showFaqForm) {
            $this->resetFaqForm();
        }
    }

    public function saveCategory()
    {
        $this->validate([
            'categoryName' => 'required|string|max:100',
            'categoryDescription' => 'nullable|string',
            'categoryOrder' => 'integer|min:0',
        ]);

        try {
            if ($this->editingCategoryId) {
                $category = FaqCategory::findOrFail($this->editingCategoryId);
                $category->update([
                    'name' => $this->categoryName,
                    'description' => $this->categoryDescription,
                    'order' => $this->categoryOrder,
                ]);
                $message = 'Categoría actualizada exitosamente.';
            } else {
                FaqCategory::create([
                    'name' => $this->categoryName,
                    'description' => $this->categoryDescription,
                    'order' => $this->categoryOrder,
                    'is_active' => true,
                ]);
                $message = 'Categoría creada exitosamente.';
            }

            $this->resetCategoryForm();
            $this->showCategoryForm = false;

            $this->dispatch('faq-notify', type: 'success', title: '¡xito!', message: $message);
        } catch (\Exception $e) {
            $this->dispatch('faq-notify', type: 'error', title: 'Error', message: 'No se pudo guardar la categoría.');
        }
    }

    public function editCategory($categoryId)
    {
        $category = FaqCategory::findOrFail($categoryId);
        $this->editingCategoryId = $categoryId;
        $this->categoryName = $category->name;
        $this->categoryDescription = $category->description;
        $this->categoryOrder = $category->order;
        $this->showCategoryForm = true;
    }

    public function toggleCategoryStatus($categoryId)
    {
        try {
            $category = FaqCategory::findOrFail($categoryId);
            $category->is_active = !$category->is_active;
            $category->save();

            $status = $category->is_active ? 'activada' : 'desactivada';
            $this->dispatch('faq-notify', type: 'success', title: 'Estado actualizado', message: "Categoría {$status} exitosamente.");
        } catch (\Exception $e) {
            $this->dispatch('faq-notify', type: 'error', title: 'Error', message: 'No se pudo cambiar el estado.');
        }
    }

    public function deleteCategory($categoryId)
    {
        try {
            $category = FaqCategory::findOrFail($categoryId);

            // Check if category has FAQs
            if ($category->faqs()->count() > 0) {
                $this->dispatch('faq-notify', type: 'warning', title: 'No se puede eliminar', message: 'Esta categoría tiene preguntas frecuentes asociadas.');
                return;
            }

            $category->delete();
            $this->dispatch('faq-notify', type: 'success', title: '¡Eliminada!', message: 'Categoría eliminada exitosamente.');
        } catch (\Exception $e) {
            $this->dispatch('faq-notify', type: 'error', title: 'Error', message: 'No se pudo eliminar la categoría.');
        }
    }

    public function saveFaq()
    {
        $this->validate([
            'selectedCategoryId' => 'required|exists:faq_categories,faq_category_id',
            'faqQuestion' => 'required|string|max:255',
            'faqAnswer' => 'required|string',
            'faqOrder' => 'integer|min:0',
        ]);

        try {
            if ($this->editingFaqId) {
                $faq = Faq::findOrFail($this->editingFaqId);
                $faq->update([
                    'faq_category_id' => $this->selectedCategoryId,
                    'question' => $this->faqQuestion,
                    'answer' => $this->faqAnswer,
                    'order' => $this->faqOrder,
                ]);
                $message = 'FAQ actualizada exitosamente.';
            } else {
                Faq::create([
                    'faq_category_id' => $this->selectedCategoryId,
                    'question' => $this->faqQuestion,
                    'answer' => $this->faqAnswer,
                    'order' => $this->faqOrder,
                    'is_active' => true,
                ]);
                $message = 'FAQ creada exitosamente.';
            }

            $this->resetFaqForm();
            $this->showFaqForm = false;

            $this->dispatch('faq-notify', type: 'success', title: '¡xito!', message: $message);
        } catch (\Exception $e) {
            $this->dispatch('faq-notify', type: 'error', title: 'Error', message: 'No se pudo guardar la FAQ.');
        }
    }

    public function editFaq($faqId)
    {
        $faq = Faq::findOrFail($faqId);
        $this->editingFaqId = $faqId;
        $this->selectedCategoryId = $faq->faq_category_id;
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
            $this->dispatch('faq-notify', type: 'success', title: 'Estado actualizado', message: "FAQ {$status} exitosamente.");
        } catch (\Exception $e) {
            $this->dispatch('faq-notify', type: 'error', title: 'Error', message: 'No se pudo cambiar el estado.');
        }
    }

    public function deleteFaq($faqId)
    {
        try {
            $faq = Faq::findOrFail($faqId);
            $faq->delete();
            $this->dispatch('faq-notify', type: 'success', title: '¡Eliminada!', message: 'FAQ eliminada exitosamente.');
        } catch (\Exception $e) {
            $this->dispatch('faq-notify', type: 'error', title: 'Error', message: 'No se pudo eliminar la FAQ.');
        }
    }

    private function resetCategoryForm()
    {
        $this->reset(['categoryName', 'categoryDescription', 'categoryOrder', 'editingCategoryId']);
        $this->resetValidation();
    }

    private function resetFaqForm()
    {
        $this->reset(['selectedCategoryId', 'faqQuestion', 'faqAnswer', 'faqOrder', 'editingFaqId']);
        $this->resetValidation();
    }

    public function render()
    {
        $categories = FaqCategory::withCount('faqs')
            ->orderBy('order')
            ->paginate(10, ['*'], 'categories_page');

        $faqs = Faq::with('category')
            ->orderBy('order')
            ->paginate(15, ['*'], 'faqs_page');

        $allCategories = FaqCategory::active()->ordered()->get();

        return view('modules.secretary.gestion-faqs', [
            'categories' => $categories,
            'faqs' => $faqs,
            'allCategories' => $allCategories,
        ])->layout('layouts.app');
    }
}

