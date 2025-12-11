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

    public $search = '';
    public $statusFilter = '';

    protected $paginationTheme = 'bootstrap';

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

