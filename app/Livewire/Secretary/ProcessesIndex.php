<?php
/**
 * Company: CETAM
 * Project: ST
 * File: ProcessesIndex.php
 * Created on: 04/12/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 *
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

namespace App\Livewire\Secretary;

use Livewire\Component;
use App\Models\Process;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;

class ProcessesIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';

    protected $paginationTheme = 'bootstrap';

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

     * Updating status filter.

     *

     * @return void

     */

    public function updatingStatusFilter()
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
        $this->reset(['search', 'statusFilter']);
        $this->resetPage();
    }

    /**

     * Render the component view.

     *

     * @return \Illuminate\View\View

     */

    public function render()
    {
        $processes = Process::query()
            ->when($this->search, function ($query) {
                $search = '%' . $this->search . '%';
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', $search)
                        ->orWhere('description', 'like', $search);
                });
            })
            ->when($this->statusFilter, function ($query) {
                if ($this->statusFilter === 'active') {
                    $query->where('active', 1);
                } elseif ($this->statusFilter === 'inactive') {
                    $query->where('active', 0);
                }
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('modules.secretary.processes-index', [
            'processes' => $processes
        ])->layout('layouts.app');
    }

    /**

     * Toggle process status.

     *

     * @param int $processId

     *

     * @return void

     */

    public function toggleProcessStatus(int $processId): void
    {
        try {
            $process = Process::with('steps')->findOrFail($processId);

            // If  está intentando activar, validar el flujo
            if (!$process->active) {
                $steps = $process->steps;

                // Verify que haya al menos un paso
                if ($steps->count() === 0) {
                    $this->dispatch(
                        'processes-notify',
                        type: 'error',
                        title: 'No se puede activar',
                        message: 'El proceso no tiene pasos definidos. Define al menos un paso inicial y uno final.'
                    );
                    return;
                }

                // Verify paso inicial
                $initialSteps = $steps->where('is_initial_step', true);
                if ($initialSteps->count() === 0) {
                    $this->dispatch(
                        'processes-notify',
                        type: 'error',
                        title: 'No se puede activar',
                        message: 'No hay un paso inicial definido. Ve a "Configurar flujo" y selecciona el paso inicial.'
                    );
                    return;
                }

                // Verify final step
                $finalSteps = $steps->where('step_type', 'final');
                if ($finalSteps->count() === 0) {
                    $this->dispatch(
                        'processes-notify',
                        type: 'error',
                        title: 'No se puede activar',
                        message: 'No hay un paso de tipo "Final". Crea al menos un paso de tipo finalización.'
                    );
                    return;
                }

                // Verify que todos los pasos estén vinculados
                $unlinkedSteps = $steps->where('is_linked', false);
                if ($unlinkedSteps->count() > 0) {
                    $unlinkedNames = $unlinkedSteps->pluck('title')->take(3)->implode(', ');
                    $this->dispatch(
                        'processes-notify',
                        type: 'error',
                        title: 'No se puede activar',
                        message: "Hay pasos sin vincular: {$unlinkedNames}. Ve a \"Configurar flujo\" para conectar todos los pasos."
                    );
                    return;
                }
            }

            $process->active = !$process->active;
            $process->save();

            $this->dispatch(
                'processes-notify',
                type: $process->active ? 'success' : 'warning',
                title: $process->active ? 'Proceso activado' : 'Proceso desactivado',
                message: $process->active ? 'Proceso activado correctamente.' : 'Proceso desactivado correctamente.'
            );
        } catch (\Throwable $th) {
            Log::error('No se pudo cambiar el estado del proceso', [
                'process_id' => $processId,
                'error' => $th->getMessage(),
            ]);

            $this->dispatch(
                'processes-notify',
                type: 'error',
                title: 'No se pudo actualizar',
                message: 'Intenta de nuevo o contacta a soporte si el problema persiste.'
            );
        } finally {
            $this->resetPage();
        }
    }
}
