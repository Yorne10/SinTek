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
                $query->orderBy('order', 'asc')
                    ->orderBy('step_id', 'asc')
                    ->with(['requiredDocuments', 'providedDocuments']);
            }
        ])->find($this->process_id);

        if (!$this->process) {
            session()->flash('error', 'Proceso no encontrado');
            return redirect()->route(config('proj.route_name_prefix', 'proj') . '.admin.define-steps');
        }

        $this->steps = $this->process->steps;

        // Load current configuration
        foreach ($this->steps as $step) {
            // Allow the step marked as initial or with initial type to be taken as initial
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

        // Reachable from initial
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
            // If not reachable from initial, it doesn't block validation (only shows warning)
            if ($this->initialStepId && !in_array($step->step_id, $reachable)) {
                continue;
            }

            if ($step->step_type === 'final') {
                continue; // Final steps don't need next step
            }

            $conn = $this->connections[$step->step_id] ?? [];

            // Conditional step
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

        // 5. Validate that all reachable paths lead to a final step
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
            // Without initial, maintain a stable order based on current position
            $orders = [];
            foreach ($this->steps->values() as $i => $step) {
                $orders[$step->step_id] = 1000 + $i;
            }
            return $orders;
        }

        $orders = [$this->initialStepId => 1];
        $stepCount = $this->steps->count();

        // Iterative relaxation to ensure a node shared by multiple parents takes the maximum level
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

        // Unreached or unordered steps: place them at the end in a stable manner
        $maxOrder = $orders ? max($orders) : 0;
        foreach ($this->steps->values() as $idx => $step) {
            if (isset($orders[$step->step_id])) {
                continue;
            }
            $maxOrder++;
            // use maxOrder + index to maintain relative stability
            $orders[$step->step_id] = $maxOrder + ($idx / 1000);
        }

        return $orders;
    }

    /**
     * Recalculates linked flags and dynamic display order.
     */
    protected function refreshDisplayState(): void
    {
        $reachable = $this->getReachableSteps();

        // Update linked flag in steps in memory
        $this->steps = $this->steps->map(function ($step) use ($reachable) {
            $step->is_linked = in_array($step->step_id, $reachable);
            return $step;
        });

        // Order for displaying steps: derived from flow (max of parents)
        $orders = $this->calculateOrder();

        // Base index to maintain stable order when there are ties
        $baseIndex = [];
        foreach ($this->steps->values() as $idx => $st) {
            $baseIndex[$st->step_id] = $idx;
        }

        $this->displaySteps = $this->steps->sortBy(function ($step) use ($orders, $baseIndex) {
            // Initial step always first
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
     * Determines if from a reachable step there is at least one path to a final step.
     */
    protected function leadsToFinal(int $stepId, array &$memo, array $visiting = []): bool
    {
        if (isset($memo[$stepId])) {
            return $memo[$stepId];
        }

        if (in_array($stepId, $visiting)) {
            // cycle detected, consider it doesn't reach final to avoid infinite loop
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

        // If no next steps and not final, it doesn't reach final
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

        // Emit event to show success alert and redirect to define steps
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
