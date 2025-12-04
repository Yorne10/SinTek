<?php

namespace App\Livewire\Worker;

use App\Models\Convocation;
use App\Models\InstitutionalDocument;
use Livewire\Component;

class Convocatorias extends Component
{
    public function render()
    {
        // Obtener solo convocatorias activas y próximas
        $convocatorias = Convocation::with('documents')
            ->whereIn('status', ['activa', 'proxima', 'permanente'])
            ->orderByRaw("FIELD(status, 'activa', 'permanente', 'proxima')")
            ->orderBy('start_date', 'desc')
            ->get();

        $reglamentos = InstitutionalDocument::where('status', 'vigente')
            ->where('category', 'reglamento')
            ->orderBy('created_at', 'desc')
            ->get();

        $manuales = InstitutionalDocument::where('status', 'vigente')
            ->where('category', '<>', 'reglamento')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('modules.worker.convocatorias', [
            'convocatorias' => $convocatorias,
            'reglamentos' => $reglamentos,
            'manuales' => $manuales,
        ])->layout('layouts.app');
    }
}
