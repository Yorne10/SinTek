<?php
/**
 * Company: CETAM
 * Project: ST
 * File: ConvocatoriasDocumentosIndex.php
 * Created on: 01/12/2025
 * Created by: Alfonso Angel García Hernández
 * Approved by: Alfonso Angel García Hernández
 */

namespace App\Livewire\Secretary;

use App\Models\Convocation;
use App\Models\InstitutionalDocument;
use Livewire\Component;
use Livewire\WithPagination;

class ConvocatoriasDocumentosIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $convocatorias = Convocation::orderByDesc('created_at')->paginate(10, ['*'], 'convocatorias');
        $institutionalDocuments = InstitutionalDocument::where('status', 'activo')
            ->orderByDesc('created_at')
            ->paginate(10, ['*'], 'documentos');

        return view('modules.secretary.convocatorias-documentos', [
            'convocatorias' => $convocatorias,
            'institutionalDocuments' => $institutionalDocuments,
        ])->layout('layouts.app');
    }
}
