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

use App\Models\Process;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

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

            // Si se intenta activar, validar que el flujo sea válido (inicio → final)
            if (!$process->active) {
                [$isValid, $errorMessage] = $this->validateFlow($process);

                if (!$isValid) {
                    $this->dispatch(
                        'processes-notify',
                        type: 'error',
                        title: 'No se puede activar',
                        message: $errorMessage ?? 'El flujo no es válido. Revisa la configuración del flujo.'
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

    /**
     * Valida que el flujo tenga inicio, finales y que los caminos alcanzables lleguen a un final.
     */
    protected function validateFlow(Process $process): array
    {
        $steps = $process->steps;

        if ($steps->isEmpty()) {
            return [false, 'El proceso no tiene pasos definidos. Define al menos un paso inicial y uno final.'];
        }

        $initial = $steps->firstWhere('is_initial_step', true);
        if (!$initial) {
            return [false, 'No hay un paso inicial definido. Ve a "Configurar flujo" y selecciona el paso inicial.'];
        }

        if ($initial->step_type === 'final') {
            return [false, 'El paso inicial no puede ser de tipo Final.'];
        }

        $hasFinal = $steps->contains(fn ($step) => $step->step_type === 'final');
        if (!$hasFinal) {
            return [false, 'No hay un paso de tipo Final. Crea al menos un paso de cierre.'];
        }

        $reachable = $this->getReachableSteps($initial->step_id, $steps);
        if (empty($reachable)) {
            return [false, 'El flujo no tiene caminos configurados desde el paso inicial.'];
        }

        $reachableFinals = $steps->where('step_type', 'final')->whereIn('step_id', $reachable);
        if ($reachableFinals->isEmpty()) {
            return [false, 'Desde el paso inicial no se llega a ningún paso Final.'];
        }

        $memo = [];
        foreach ($reachable as $stepId) {
            if (!$this->leadsToFinal($stepId, $steps, $memo)) {
                $stepTitle = $steps->firstWhere('step_id', $stepId)->title ?? 'Paso';
                return [false, "El camino desde '{$stepTitle}' no llega a un paso Final."];
            }
        }

        return [true, null];
    }

    /**
     * Obtiene los pasos alcanzables desde el inicial sin bloquear por nodos aislados.
     */
    protected function getReachableSteps(int $initialId, $steps): array
    {
        $map = $steps->keyBy('step_id');
        $visited = [];
        $queue = [$initialId];

        while (!empty($queue)) {
            $current = array_shift($queue);
            if (in_array($current, $visited, true)) {
                continue;
            }

            $visited[] = $current;
            $step = $map->get($current);
            if (!$step || $step->step_type === 'final') {
                continue;
            }

            foreach ($this->getNextTargets($step) as $targetId) {
                if (!in_array($targetId, $visited, true)) {
                    $queue[] = $targetId;
                }
            }
        }

        return $visited;
    }

    /**
     * Determina si desde un paso hay al menos un camino a un final.
     */
    protected function leadsToFinal(int $stepId, $steps, array &$memo, array $visiting = []): bool
    {
        if (isset($memo[$stepId])) {
            return $memo[$stepId];
        }

        if (in_array($stepId, $visiting, true)) {
            return false; // ciclo
        }

        $step = $steps->firstWhere('step_id', $stepId);
        if (!$step) {
            return false;
        }

        if ($step->step_type === 'final') {
            $memo[$stepId] = true;
            return true;
        }

        $targets = $this->getNextTargets($step);
        if (empty($targets)) {
            $memo[$stepId] = false;
            return false;
        }

        $visiting[] = $stepId;
        foreach ($targets as $targetId) {
            if ($this->leadsToFinal($targetId, $steps, $memo, $visiting)) {
                $memo[$stepId] = true;
                return true;
            }
        }

        $memo[$stepId] = false;
        return false;
    }

    /**
     * Obtiene los identificadores de pasos siguientes según el tipo de paso.
     */
    protected function getNextTargets($step): array
    {
        $targets = [];
        $isConditional = in_array($step->step_type, ['conditional', 'approval'], true) && $step->condition_question;

        if ($isConditional) {
            if (!empty($step->next_yes)) {
                $targets[] = (int) $step->next_yes;
            }
            if (!empty($step->next_no)) {
                $targets[] = (int) $step->next_no;
            }
        } else {
            if (!empty($step->next_step_id)) {
                $targets[] = (int) $step->next_step_id;
            }
        }

        return $targets;
    }
}
