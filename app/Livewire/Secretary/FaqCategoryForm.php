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
    public $categoryOrder = 0;

    protected $rules = [
        'categoryName' => 'required|string|max:100',
        'categoryDescription' => 'nullable|string',
        'categoryOrder' => 'integer|min:0',
    ];

    protected $messages = [
        'categoryName.required' => 'El nombre de la categoría es obligatorio.',
        'categoryName.max' => 'El nombre no debe exceder 100 caracteres.',
    ];

    public function mount($categoryId = null): void
    {
        if ($categoryId) {
            $this->categoryId = $categoryId;
            $category = FaqCategory::findOrFail($categoryId);
            $this->categoryName = $category->name;
            $this->categoryDescription = $category->description;
            $this->categoryOrder = $category->order;
        }
    }

    public function save(): void
    {
        $this->validate();

        try {
            if ($this->categoryId) {
                $category = FaqCategory::findOrFail($this->categoryId);
                $category->update([
                    'name' => $this->categoryName,
                    'description' => $this->categoryDescription,
                    'order' => $this->categoryOrder,
                ]);
                $message = 'Categoría actualizada exitosamente.';
                $action = 'actualizada';
            } else {
                FaqCategory::create([
                    'name' => $this->categoryName,
                    'description' => $this->categoryDescription,
                    'order' => $this->categoryOrder,
                    'is_active' => true,
                ]);
                $message = 'Categoría creada exitosamente.';
                $action = 'creada';
            }

            $user = auth()->user();
            ActivityLogger::log(
                $this->categoryId ? 'faq.categoria.editar' : 'faq.categoria.crear',
                "Categoría de FAQ '{$this->categoryName}' {$action}",
                $user?->users_id
            );

            $this->dispatch('category-saved', type: 'success', title: '¡Éxito!', message: $message);
            $this->redirect(route(config('proj.route_name_prefix', 'proj') . '.faq.categories'));
        } catch (\Exception $e) {
            $this->dispatch('category-error', type: 'error', title: 'Error', message: 'No se pudo guardar la categoría.');
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

            $this->dispatch('category-deleted', type: 'success', title: '¡Eliminada!', message: 'Categoría eliminada exitosamente.');
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
