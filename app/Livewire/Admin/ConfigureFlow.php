<?php
/**
 * Company: CETAM
 * Project: ST
 * File: ConfigureFlow.php
 * Created on: 12/12/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 * 
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

namespace App\Livewire\Admin;

use App\Models\Process;
use App\Models\Step;
use App\Services\ActivityLogger;
use Livewire\Component;

class ConfigureFlow extends Component
{
    public $process_id;
    public $process;
    public $steps = [];
    public $initialStepId = null;
    public $displaySteps = [];

    // Flow connections - indexed by step_id
    public $connections = [];

    // Validation results
    public $validationErrors = [];
    public $validationWarnings = [];
    public $isFlowValid = false;

    /**

     * Initialize component state.

     *

     * @param mixed $process_id

     *

     * @return void

     */

    public function mount($process_id)
    {
        $this->process_id = $process_id;
        $this->loadProcess();
    }

    /**

     * Load process.

     *

     * @return void

     */

    public function loadProcess()
    {
        $this->process = Process::with([
            'steps' => function ($query) {
                $query->orderBy('order', 'asc')->orderBy('step_id', 'asc');
            }
        ])->find($this->process_id);

        if (!$this->process) {
            session()->flash('error', 'Proceso no encontrado');
            return redirect()->route(config('proj.route_name_prefix', 'proj') . '.admin.define-steps');
        }

        $this->steps = $this->process->steps;

        // Load current configuration
        foreach ($this->steps as $step) {
            // Permitir que el paso marcado como inicial o con tipo inicial sea tomado como inicial
            if ($step->is_initial_step || $step->step_type === 'initial') {
                $this->initialStepId = $step->step_id;
            }

            $this->connections[$step->step_id] = [
                'next_step_id' => $step->next_step_id,
                'next_yes' => $step->next_yes,
                'next_no' => $step->next_no,
            ];
        }

        $this->validateFlow();
        $this->refreshDisplayState();
    }

    /**

     * Updated initial step id.

     *

     * @return void

     */

    public function updatedInitialStepId()
    {
        $this->validateFlow();
        $this->refreshDisplayState();
    }

    /**

     * Updated connections.

     *

     * @return void

     */

    public function updatedConnections()
    {
        $this->validateFlow();
        $this->refreshDisplayState();
    }

    /**

     * Validate flow.

     *

     * @return void

     */

    public function validateFlow()
    {
        $this->validationErrors = [];
        $this->validationWarnings = [];
        $this->isFlowValid = true;

        // Alcanzables desde inicial
        $reachable = $this->initialStepId ? $this->getReachableSteps() : [];

        // 1. Check initial step
        if (!$this->initialStepId) {
            $this->validationErrors[] = 'No hay paso inicial definido';
            $this->isFlowValid = false;
        } else {
            $initialStep = $this->steps->firstWhere('step_id', $this->initialStepId);
            if ($initialStep && $initialStep->step_type === 'final') {
                $this->validationErrors[] = 'El paso inicial no puede ser de tipo Final';
                $this->isFlowValid = false;
            }
        }

        // 2. Check all non-final steps have next step
        foreach ($this->steps as $step) {
            // Si no es alcanzable desde el inicial, no bloquea la validación (solo se marcará advertencia)
            if ($this->initialStepId && !in_array($step->step_id, $reachable)) {
                continue;
            }

            if ($step->step_type === 'final') {
                continue; // Final steps don't need next step
            }

            $conn = $this->connections[$step->step_id] ?? [];

            // Paso condicional
            $hasConditional = $step->step_type === 'conditional';

            if ($hasConditional) {
                // Conditional steps need both branches
                if (empty($conn['next_yes'])) {
                    $this->validationErrors[] = "El paso '{$step->title}' necesita definir el camino SI";
                    $this->isFlowValid = false;
                }
                if (empty($conn['next_no'])) {
                    $this->validationErrors[] = "El paso '{$step->title}' necesita definir el camino NO";
                    $this->isFlowValid = false;
                }
            } else {
                // Normal steps need next_step_id
                if (empty($conn['next_step_id'])) {
                    $this->validationErrors[] = "El paso '{$step->title}' necesita definir el siguiente paso";
                    $this->isFlowValid = false;
                }
            }
        }

        // 3. Check at least one final step exists
        $hasFinalStep = $this->steps->where('step_type', 'final')->count() > 0;
        if (!$hasFinalStep) {
            $this->validationErrors[] = 'Debe existir al menos un paso de tipo Final';
            $this->isFlowValid = false;
        }

        // 4. Detect orphan steps (not reachable from initial)
        if ($this->initialStepId) {
            foreach ($this->steps as $step) {
                if (!in_array($step->step_id, $reachable)) {
                    $this->validationWarnings[] = "El paso '{$step->title}' no es alcanzable desde el paso inicial";
                }
            }
        }

        // 5. Validar que todos los caminos alcanzables llegan a un final
        if ($this->initialStepId) {
            $reachable = $this->getReachableSteps();
            $memo = [];
            foreach ($reachable as $stepId) {
                if (!$this->leadsToFinal($stepId, $memo)) {
                    $step = $this->steps->firstWhere('step_id', $stepId);
                    $title = $step ? $step->title : "Paso {$stepId}";
                    $this->validationErrors[] = "El camino desde '{$title}' no llega a un paso Final";
                    $this->isFlowValid = false;
                }
            }
        }
    }

    protected function getReachableSteps(): array
    {
        if (!$this->initialStepId) {
            return [];
        }

        $visited = [];
        $queue = [$this->initialStepId];

        while (!empty($queue)) {
            $currentId = array_shift($queue);

            if (in_array($currentId, $visited)) {
                continue;
            }

            $visited[] = $currentId;
            $step = $this->steps->firstWhere('step_id', $currentId);

            if (!$step || $step->step_type === 'final') {
                continue;
            }

            $conn = $this->connections[$currentId] ?? [];

            $hasConditional = $step->step_type === 'conditional';

            if ($hasConditional) {
                if (!empty($conn['next_yes']) && !in_array($conn['next_yes'], $visited)) {
                    $queue[] = $conn['next_yes'];
                }
                if (!empty($conn['next_no']) && !in_array($conn['next_no'], $visited)) {
                    $queue[] = $conn['next_no'];
                }
            } else {
                if (!empty($conn['next_step_id']) && !in_array($conn['next_step_id'], $visited)) {
                    $queue[] = $conn['next_step_id'];
                }
            }
        }

        return $visited;
    }

    protected function calculateOrder(): array
    {
        if (!$this->initialStepId) {
            // Sin inicial, mantener un orden estable basado en la posiciГіn actual
            $orders = [];
            foreach ($this->steps->values() as $i => $step) {
                $orders[$step->step_id] = 1000 + $i;
            }
            return $orders;
        }

        $orders = [$this->initialStepId => 1];
        $stepCount = $this->steps->count();

        // Iterative relaxation to ensure a node shared by varios padres tome el máximo nivel
        for ($i = 0; $i < $stepCount; $i++) {
            $changed = false;
            foreach ($this->steps as $step) {
                if (!isset($orders[$step->step_id])) {
                    continue;
                }
                $currentOrder = $orders[$step->step_id];

                if ($step->step_type === 'final') {
                    continue;
                }

                $conn = $this->connections[$step->step_id] ?? [];
                $hasConditional = $step->step_type === 'conditional';

                if ($hasConditional) {
                    foreach (['next_yes', 'next_no'] as $targetKey) {
                        $targetId = $conn[$targetKey] ?? null;
                        if ($targetId) {
                            $nextOrder = $currentOrder + 1;
                            if (($orders[$targetId] ?? 0) < $nextOrder) {
                                $orders[$targetId] = $nextOrder;
                                $changed = true;
                            }
                        }
                    }
                } else {
                    $targetId = $conn['next_step_id'] ?? null;
                    if ($targetId) {
                        $nextOrder = $currentOrder + 1;
                        if (($orders[$targetId] ?? 0) < $nextOrder) {
                            $orders[$targetId] = $nextOrder;
                            $changed = true;
                        }
                    }
                }
            }
            if (!$changed) {
                break;
            }
        }

        // Pasos no alcanzados o sin orden: colocarlos al final de forma estable
        $maxOrder = $orders ? max($orders) : 0;
        foreach ($this->steps->values() as $idx => $step) {
            if (isset($orders[$step->step_id])) {
                continue;
            }
            $maxOrder++;
            // usar maxOrder + indice para mantener estabilidad relativa
            $orders[$step->step_id] = $maxOrder + ($idx / 1000);
        }

        return $orders;
    }

    /**
     * Recalcula flags de vinculado y el orden de visualización dinámico.
     */
    protected function refreshDisplayState(): void
    {
        $reachable = $this->getReachableSteps();

        // Actualizar flag de vinculado en los pasos en memoria
        $this->steps = $this->steps->map(function ($step) use ($reachable) {
            $step->is_linked = in_array($step->step_id, $reachable);
            return $step;
        });

        // Orden para mostrar pasos: derivado del flujo (mayor de los padres)
        $orders = $this->calculateOrder();

        // Indice base para mantener orden estable cuando hay empates
        $baseIndex = [];
        foreach ($this->steps->values() as $idx => $st) {
            $baseIndex[$st->step_id] = $idx;
        }

        $this->displaySteps = $this->steps->sortBy(function ($step) use ($orders, $baseIndex) {
            // Paso inicial siempre primero
            if ($step->is_initial_step || $step->step_type === 'initial') {
                return [0, $baseIndex[$step->step_id] ?? 0];
            }
            return [
                $orders[$step->step_id] ?? 9999,
                $baseIndex[$step->step_id] ?? 9999,
            ];
        })->values();
    }

    /**
     * Determina si desde un paso alcanzable hay al menos un camino a un paso final.
     */
    protected function leadsToFinal(int $stepId, array &$memo, array $visiting = []): bool
    {
        if (isset($memo[$stepId])) {
            return $memo[$stepId];
        }

        if (in_array($stepId, $visiting)) {
            // ciclo, considerar que no llega a final para evitar loop infinito
            return false;
        }

        $step = $this->steps->firstWhere('step_id', $stepId);
        if (!$step) {
            return false;
        }

        if ($step->step_type === 'final') {
            $memo[$stepId] = true;
            return true;
        }

        $visiting[] = $stepId;
        $conn = $this->connections[$stepId] ?? [];
        $hasConditional = $step->step_type === 'conditional';

        $targets = [];
        if ($hasConditional) {
            if (!empty($conn['next_yes'])) {
                $targets[] = (int) $conn['next_yes'];
            }
            if (!empty($conn['next_no'])) {
                $targets[] = (int) $conn['next_no'];
            }
        } else {
            if (!empty($conn['next_step_id'])) {
                $targets[] = (int) $conn['next_step_id'];
            }
        }

        // Si no hay siguientes y no es final, no llega a final
        if (empty($targets)) {
            $memo[$stepId] = false;
            return false;
        }

        foreach ($targets as $targetId) {
            if ($this->leadsToFinal($targetId, $memo, $visiting)) {
                $memo[$stepId] = true;
                return true;
            }
        }

        $memo[$stepId] = false;
        return false;
    }

    /**

     * Save the data.

     *

     * @return void

     */

    public function save()
    {
        $this->validateFlow();

        $reachable = $this->getReachableSteps();
        $orders = $this->calculateOrder();

        // Save all steps
        foreach ($this->steps as $step) {
            $conn = $this->connections[$step->step_id] ?? [];
            $hasConditional = $step->step_type === 'conditional';

            $stepModel = Step::find($step->step_id);
            if ($stepModel) {
                $stepModel->is_initial_step = ($step->step_id == $this->initialStepId);
                $stepModel->is_linked = in_array($step->step_id, $reachable);
                $stepModel->order = $orders[$step->step_id] ?? null;

                if ($hasConditional) {
                    $stepModel->next_step_id = null;
                    $stepModel->next_yes = $conn['next_yes'] ?? null;
                    $stepModel->next_no = $conn['next_no'] ?? null;
                } else {
                    $stepModel->next_step_id = $conn['next_step_id'] ?? null;
                    $stepModel->next_yes = null;
                    $stepModel->next_no = null;
                }

                $stepModel->save();
            }
        }

        // Update process active status based on flow validity
        if (!$this->isFlowValid) {
            $this->process->active = false;
            $this->process->save();
            session()->flash('warning', 'Configuración guardada, pero el proceso quedó INACTIVO porque el flujo no está completo.');
        } else {
            session()->flash('success', 'Configuración de flujo guardada exitosamente.');
        }

        // Log activity
        $user = auth()->user();
        ActivityLogger::log(
            'flujo.configurar',
            "Flujo configurado para proceso: '{$this->process->name}'",
            $user?->users_id
        );

        // Emitir evento para mostrar alerta de éxito y redirigir a definir pasos
        $this->dispatch(
            'flow-saved',
            type: 'success',
            title: 'Flujo guardado',
            message: 'La configuración del flujo se actualizó correctamente.',
            redirect: route(config('proj.route_name_prefix', 'proj') . '.admin.define-steps', ['process_id' => $this->process_id])
        );

        return null;
    }

    /**

     * Render the component view.

     *

     * @return \Illuminate\View\View

     */

    public function render()
    {
        return view('modules.admin.configure-flow')->layout('layouts.app');
    }
}
