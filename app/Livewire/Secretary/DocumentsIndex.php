<?php
/**
 * Company: CETAM
 * Project: ST
 * File: DocumentsIndex.php
 * Created on: 04/12/2025
 * Created by: Alfonso Angel García Hernández
 * Approved by: Alfonso Angel García Hernández
 * 
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
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

    /**

     * Updating search.

     *

     * @return void

     */

    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**

     * Updating category filter.

     *

     * @return void

     */

    public function updatingCategoryFilter()
    {
        $this->resetPage();
    }

    /**

     * Clear filters.

     *

     * @return void

     */

    public function clearFilters()
    {
        $this->search = '';
        $this->categoryFilter = '';
        $this->resetPage();
    }

    /**

     * Toggle status.

     *

     * @param mixed $documentId

     *

     * @return void

     */

    public function toggleStatus($documentId)
    {
        $document = InstitutionalDocument::find($documentId);
        if ($document) {
            $isActive = $document->status === 'active';
            $document->status = $isActive ? 'inactive' : 'active';
            $document->save();

            $this->dispatch(
                'documents-notify',
                type: !$isActive ? 'success' : 'warning',
                title: !$isActive ? 'Documento activado' : 'Documento desactivado',
                message: !$isActive ? 'El documento ahora es visible para los usuarios.' : 'El documento ya no será visible para los usuarios.'
            );
        }
    }

    /**

     * Render the component view.

     *

     * @return \Illuminate\View\View

     */

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
