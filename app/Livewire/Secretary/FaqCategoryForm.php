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
            'categoryDescription' => 'nullable|string',
            'categoryOrder' => 'required|integer|min:1|max:' . $max,
        ];
    }

    protected $messages = [
        'categoryName.required' => 'El nombre de la categoría es obligatorio.',
        'categoryName.max' => 'El nombre no debe exceder 100 caracteres.',
        'categoryName.unique' => 'Ya existe una categoría con este nombre.',
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
            if ($this->categoryId) {
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
                $this->categoryId = $category->faq_category_id;
                $message = 'Categoría creada exitosamente.';
                $action = 'creada';
            }

            $this->reorderCategories($category);
            $this->maxOrder = FaqCategory::count();

            $user = auth()->user();
            ActivityLogger::log(
                $this->categoryId ? 'faq.categoria.editar' : 'faq.categoria.crear',
                "Categoría de FAQ '{$this->categoryName}' {$action}",
                $user?->users_id
            );

            $this->dispatch('category-saved', type: 'success', title: 'Éxito', message: $message);
            $this->redirect(route(config('proj.route_name_prefix', 'proj') . '.faq.categories'));
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

            if ($category->faqs()->count() > 0) {
                $this->dispatch('category-error', type: 'warning', title: 'No se puede eliminar', message: 'Esta categoría tiene preguntas frecuentes asociadas.');
                return;
            }

            $categoryName = $category->name;
            $category->delete();

            $user = auth()->user();
            ActivityLogger::log(
                'faq.categoria.eliminar',
                "Categoría de FAQ '{$categoryName}' eliminada",
                $user?->users_id
            );

            $this->dispatch('category-deleted', type: 'success', title: 'Eliminada', message: 'Categoría eliminada exitosamente.');
            $this->redirect(route(config('proj.route_name_prefix', 'proj') . '.faq.categories'));
        } catch (\Exception $e) {
            $this->dispatch('category-error', type: 'error', title: 'Error', message: 'No se pudo eliminar la categoría.');
        }
    }

    public function render()
    {
        return view('modules.secretary.faq-category-form')->layout('layouts.app');
    }
}
