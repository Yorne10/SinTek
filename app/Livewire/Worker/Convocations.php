<?php

namespace App\Livewire\Worker;

use App\Models\Convocation;
use App\Models\InstitutionalDocument;
use Livewire\Component;
use Livewire\WithPagination;

class Convocations extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        // Obtener solo convocatorias activas y próximas
        $convocations = Convocation::with('documents')
            ->whereIn('status', ['activa', 'proxima', 'permanente'])
            ->orderByRaw("FIELD(status, 'activa', 'permanente', 'proxima')")
            ->orderBy('start_date', 'desc')
            ->paginate(10);

        $regulations = InstitutionalDocument::where('status', 'vigente')
            ->where('category', 'reglamento')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $manuals = InstitutionalDocument::where('status', 'vigente')
            ->where('category', '<>', 'reglamento')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('modules.worker.convocations', [
            'convocations' => $convocations,
            'regulations' => $regulations,
            'manuals' => $manuals,
        ])->layout('layouts.app');
    }
}
