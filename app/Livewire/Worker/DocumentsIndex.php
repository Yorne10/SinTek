<?php
/**
 * Company: CETAM
 * Project: ST
 * File: DocumentsIndex.php (Worker)
 * Created on: 04/12/2025
 * Created by: Alfonso Angel García Hernández
 * Approved by: Alfonso Angel García Hernández
 */

namespace App\Livewire\Worker;

use App\Models\InstitutionalDocument;
use Livewire\Component;

class DocumentsIndex extends Component
{
    public $search = '';
    public $categoryFilter = '';

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

        $documents = $query->orderByDesc('created_at')->get();

        // Separate by category for display
        $reglamentos = $documents->filter(fn($doc) => strtolower($doc->category) === 'reglamento');
        $otrosDocumentos = $documents->filter(fn($doc) => strtolower($doc->category) !== 'reglamento');

        return view('modules.worker.documents-index', [
            'reglamentos' => $reglamentos,
            'manuales' => $otrosDocumentos,
            'documents' => $documents,
        ])->layout('layouts.app');
    }
}
