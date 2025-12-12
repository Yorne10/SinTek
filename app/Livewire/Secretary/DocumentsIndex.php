<?php
/**
 * Company: CETAM
 * Project: ST
 * File: DocumentsIndex.php
 * Created on: 04/12/2025
 * Created by: Alfonso Angel García Hernández
 * Approved by: Alfonso Angel García Hernández
 */

namespace App\Livewire\Secretary;

use App\Models\InstitutionalDocument;
use Livewire\Component;
use Livewire\WithPagination;

class DocumentsIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $categoryFilter = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategoryFilter()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->categoryFilter = '';
        $this->resetPage();
    }

    public function render()
    {
        $query = InstitutionalDocument::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->categoryFilter) {
            $query->where('category', $this->categoryFilter);
        }

        $documents = $query->orderByDesc('created_at')->paginate(10);

        return view('modules.secretary.documents-index', [
            'documents' => $documents,
        ])->layout('layouts.app');
    }
}
