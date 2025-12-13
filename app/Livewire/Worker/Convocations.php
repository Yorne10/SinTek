<?php
/**
 * Company: CETAM
 * Project: ST
 * File: Convocations.php
 * Created on: 22/11/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 *
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

namespace App\Livewire\Worker;

use App\Models\Convocation;
use App\Models\InstitutionalDocument;
use Livewire\Component;
use Livewire\WithPagination;

class Convocations extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    /**

     * Render the component view.

     *

     * @return \Illuminate\View\View

     */

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
