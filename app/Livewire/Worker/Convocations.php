<?php

namespace App\Livewire\Worker;

use App\Models\Convocation;
use App\Models\InstitutionalDocument;
use Livewire\Component;

class Convocations extends Component
{
    public function render()
    {
        // Obtener solo convocatorias activas y próximas
        $convocations = Convocation::with('documents')
            ->whereIn('status', ['activa', 'proxima', 'permanente'])
            ->orderByRaw("FIELD(status, 'activa', 'permanente', 'proxima')")
            ->orderBy('start_date', 'desc')
            ->get();

        $regulations = InstitutionalDocument::where('status', 'vigente')
            ->where('category', 'reglamento')
            ->orderBy('created_at', 'desc')
            ->get();

        $manuals = InstitutionalDocument::where('status', 'vigente')
            ->where('category', '<>', 'reglamento')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('modules.worker.convocations', [
            'convocations' => $convocations,
            'regulations' => $regulations,
            'manuals' => $manuals,
        ])->layout('layouts.app');
    }
}
