<?php
/**
 * Company: CETAM
 * Project: ST
 * File: FaqCategoryForm.php
 * Created on: 10/12/2025
 * Created by: Codex
 * Approved by: Alfonso Angel Garcia Hernandez
 */

namespace App\Livewire\Secretary;

use App\Models\FaqCategory;
use App\Services\ActivityLogger;
use Livewire\Component;

class FaqCategoryForm extends Component
{
    public $categoryId = null;
    public $categoryName = '';
    public $categoryDescription = '';
    public $categoryOrder = 1;
    public $maxOrder = 1;
    public $originalOrder = 1;

    protected function rules(): array
    {
        $max = max(1, $this->maxOrder);
        $uniqueRule = 'unique:faqs_categories,name';
        if ($this->categoryId) {
            $uniqueRule .= ',' . $this->categoryId . ',faq_category_id';
        }
        return [
            'categoryName' => 'required|string|max:100|' . $uniqueRule,
            'categoryDescription' => 'required|string',
            'categoryOrder' => 'required|integer|min:1|max:' . $max,
        ];
    }

    protected $messages = [
        'categoryName.required' => 'El nombre de la categoría es obligatorio.',
        'categoryName.max' => 'El nombre no debe exceder 100 caracteres.',
        'categoryName.unique' => 'Ya existe una categoría con este nombre.',
        'categoryDescription.required' => 'La descripción es obligatoria.',
        'categoryOrder.required' => 'El orden es obligatorio.',
        'categoryOrder.integer' => 'El orden debe ser numérico.',
        'categoryOrder.min' => 'El orden debe ser al menos 1.',
        'categoryOrder.max' => 'El orden no puede exceder el máximo disponible.',
    ];

    public function mount($categoryId = null): void
    {
        $this->maxOrder = FaqCategory::count() + ($categoryId ? 0 : 1);

        if ($categoryId) {
            $this->categoryId = $categoryId;
            $category = FaqCategory::findOrFail($categoryId);
            $this->categoryName = $category->name;
            $this->categoryDescription = $category->description;
            $this->categoryOrder = $category->order;
            $this->originalOrder = $category->order;
        } else {
            // En alta, proponer el siguiente orden disponible
            $this->categoryOrder = $this->maxOrder;
            $this->originalOrder = $this->maxOrder;
        }
    }

    public function save(): void
    {
        $this->validate();

        try {
            $isEditing = (bool) $this->categoryId;

            if ($isEditing) {
                $category = FaqCategory::findOrFail($this->categoryId);
                $category->name = $this->categoryName;
                $category->description = $this->categoryDescription;
                $category->order = $this->categoryOrder;
                $category->save();
                $message = 'Categoría actualizada exitosamente.';
                $action = 'actualizada';
            } else {
                $category = FaqCategory::create([
                    'name' => $this->categoryName,
                    'description' => $this->categoryDescription,
                    'order' => $this->categoryOrder,
                ]);
                $message = 'Categoría creada exitosamente.';
                $action = 'creada';
            }

            $this->reorderCategories($category);
            $this->maxOrder = FaqCategory::count();

            $user = auth()->user();
            ActivityLogger::log(
                $isEditing ? 'faq.categoria.editar' : 'faq.categoria.crear',
                "Categoría de FAQ '{$this->categoryName}' {$action}",
                $user?->users_id
            );

            if ($isEditing) {
                // En edición: redirigir después de mostrar alerta
                $redirect = route(config('proj.route_name_prefix', 'proj') . '.faq.categories');
                $this->dispatch('category-saved', type: 'success', title: 'Éxito', message: $message, redirect: $redirect);
            } else {
                // En creación: limpiar formulario y quedarse
                $this->reset(['categoryName', 'categoryDescription']);
                $this->maxOrder = FaqCategory::count() + 1;
                $this->categoryOrder = $this->maxOrder;
                $this->dispatch('category-saved', type: 'success', title: 'Éxito', message: $message, redirect: null);
            }
        } catch (\Exception $e) {
            $this->dispatch('category-error', type: 'error', title: 'Error', message: 'No se pudo guardar la categoría.');
        }
    }

    protected function reorderCategories(FaqCategory $current): void
    {
        $categories = FaqCategory::where('faq_category_id', '!=', $current->faq_category_id)
            ->orderBy('order')
            ->orderBy('faq_category_id')
            ->get()
            ->values();

        $desired = max(1, (int) $this->categoryOrder);
        $desired = min($desired, $categories->count() + 1);

        $ordered = $categories->toArray();
        array_splice($ordered, $desired - 1, 0, [$current]);

        $order = 1;
        foreach ($ordered as $catData) {
            $cat = $catData instanceof FaqCategory ? $catData : FaqCategory::find($catData['faq_category_id']);
            if ($cat) {
                $cat->order = $order++;
                $cat->save();
            }
        }
    }

    public function deleteCategory(): void
    {
        if (!$this->categoryId) {
            return;
        }

        try {
            $category = FaqCategory::findOrFail($this->categoryId);
            $faqsCount = $category->faqs()->count();

            if ($faqsCount > 0) {
                // Mostrar warning de que se eliminarán las FAQs también
                $this->dispatch('category-has-faqs', count: $faqsCount);
            } else {
                // Mostrar solo question de confirmación
                $this->dispatch('category-no-faqs');
            }
        } catch (\Exception $e) {
            $this->dispatch('category-error', type: 'error', title: 'Error', message: 'No se pudo eliminar la categoría.');
        }
    }

    public function confirmDelete(): void
    {
        if (!$this->categoryId) {
            return;
        }

        try {
            $category = FaqCategory::findOrFail($this->categoryId);
            $this->performDelete($category);
        } catch (\Exception $e) {
            $this->dispatch('category-error', type: 'error', title: 'Error', message: 'No se pudo eliminar la categoría.');
        }
    }

    public function confirmDeleteWithFaqs(): void
    {
        if (!$this->categoryId) {
            return;
        }

        try {
            $category = FaqCategory::findOrFail($this->categoryId);

            // Eliminar FAQs asociadas primero
            $category->faqs()->delete();

            // Luego eliminar la categoría
            $this->performDelete($category);
        } catch (\Exception $e) {
            $this->dispatch('category-error', type: 'error', title: 'Error', message: 'No se pudo eliminar la categoría.');
        }
    }

    protected function performDelete(FaqCategory $category): void
    {
        $categoryName = $category->name;
        $category->delete();

        // Renumerar categorías restantes
        $remainingCategories = FaqCategory::orderBy('order')->get();
        $order = 1;
        foreach ($remainingCategories as $cat) {
            $cat->order = $order++;
            $cat->save();
        }

        $user = auth()->user();
        ActivityLogger::log(
            'faq.categoria.eliminar',
            "Categoría de FAQ '{$categoryName}' eliminada",
            $user?->users_id
        );

        $redirect = route(config('proj.route_name_prefix', 'proj') . '.faq.categories');
        $this->dispatch('category-saved', type: 'success', title: 'Eliminada', message: 'Categoría eliminada exitosamente.', redirect: $redirect);
    }

    public function render()
    {
        return view('modules.secretary.faq-category-form')->layout('layouts.app');
    }
}
