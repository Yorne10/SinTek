<?php

namespace App\Livewire\Worker;

use App\Models\InstitutionalDocument;
use Livewire\Component;

class DocumentsIndex extends Component
{
    public function render()
    {
        $reglamentos = InstitutionalDocument::where('status', 'vigente')
            ->where('category', 'reglamento')
            ->orderBy('created_at', 'desc')
            ->get();

        $manuales = InstitutionalDocument::where('status', 'vigente')
            ->where('category', '<>', 'reglamento')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('modules.worker.documents-index', [
            'reglamentos' => $reglamentos,
            'manuales' => $manuales,
        ])->layout('layouts.app');
    }
}
