<?php
/**
 * Company: CETAM
 * Project: ST
 * File: FaqManagement.php
 * Created on: 24/11/2025
 * Created by: Codex
 * Approved by: Alfonso Angel García Hernández
 */

namespace App\Livewire\Secretary;

use App\Models\Faq;
use App\Models\FaqCategory;
use App\Services\ActivityLogger;
use Livewire\Component;
use Livewire\WithPagination;

class FaqManagement extends Component
{
    use WithPagination;

    // Category properties
    public $categoryName = '';
    public $categoryDescription = '';
    public $categoryOrder = 0;
    public $editingCategoryId = null;

    // UI State
    public $showCategoryForm = false;
    public $search = '';
    public $statusFilter = '';

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'categoryName' => 'required|string|max:100',
        'categoryDescription' => 'nullable|string',
        'categoryOrder' => 'integer|min:0',
    ];

    protected $messages = [
        'categoryName.required' => 'El nombre de la categoría es obligatorio.',
        'categoryName.max' => 'El nombre no debe exceder 100 caracteres.',
    ];

    protected $listeners = ['refreshCategories' => '$refresh'];

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

    public function toggleCategoryForm()
    {
        $this->showCategoryForm = !$this->showCategoryForm;
        if (!$this->showCategoryForm) {
            $this->resetCategoryForm();
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
                $message = 'Categor?a actualizada exitosamente.';
            } else {
                FaqCategory::create([
                    'name' => $this->categoryName,
                    'description' => $this->categoryDescription,
                    'order' => $this->categoryOrder,
                    'is_active' => true,
                ]);
                $message = 'Categor?a creada exitosamente.';
            }

            $user = auth()->user();
            $action = $this->editingCategoryId ? 'actualizada' : 'creada';
            ActivityLogger::log(
                $this->editingCategoryId ? 'faq.categoria.editar' : 'faq.categoria.crear',
                "Categoría de FAQ '{$this->categoryName}' {$action}",
                $user?->users_id
            );

            $this->resetCategoryForm();
            $this->showCategoryForm = false;

            $this->dispatch('faq-notify', type: 'success', title: '?xito!', message: $message);
        } catch (\Exception $e) {
            $this->dispatch('faq-notify', type: 'error', title: 'Error', message: 'No se pudo guardar la categor?a.');
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
            $user = auth()->user();
            ActivityLogger::log(
                'faq.categoria.eliminar',
                "Categoría de FAQ '{$category->name}' eliminada",
                $user?->users_id
            );

            $this->dispatch('faq-notify', type: 'success', title: '¡Eliminada!', message: 'Categoría eliminada exitosamente.');
        } catch (\Exception $e) {
            $this->dispatch('faq-notify', type: 'error', title: 'Error', message: 'No se pudo eliminar la categoría.');
        }
    }


    private function resetCategoryForm()
    {
        $this->reset(['categoryName', 'categoryDescription', 'categoryOrder', 'editingCategoryId']);
        $this->resetValidation();
    }


    public function render()
    {
        $query = FaqCategory::withCount('faqs');

        // Apply search filter
        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        // Apply status filter
        if ($this->statusFilter === 'active') {
            $query->where('is_active', true);
        } elseif ($this->statusFilter === 'inactive') {
            $query->where('is_active', false);
        }

        $categories = $query->orderBy('order')->paginate(10);

        return view('modules.secretary.faq-management', [
            'categories' => $categories,
        ])->layout('layouts.app');
    }
}

