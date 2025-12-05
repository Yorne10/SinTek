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

    public function render()
    {
        $documents = InstitutionalDocument::where('status', '!=', 'archivado') // Assuming we want active/vigente ones, or all except archived. Original code had 'activo' or 'vigente' in different places. Let's check the original index.
            // Original Index used: InstitutionalDocument::where('status', 'activo')
            // But the view used: $institutionalDocuments (which was passed from index).
            // Let's stick to what was in ConvocatoriasDocumentosIndex.php: where('status', 'activo')
            // Wait, ConvocatoriasDocumentos.php (the other one) used where('status', 'vigente').
            // The user wants to split the "Convocatorias y Documentos" page.
            // The file `ConvocatoriasDocumentosIndex.php` had `where('status', 'activo')`.
            // I will use `where('status', 'activo')` to match the file I am replacing.
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('modules.secretary.documents-index', [
            'documents' => $documents,
        ])->layout('layouts.app');
    }
}
