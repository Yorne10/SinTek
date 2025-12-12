<?php
/**
 * Company: CETAM
 * Project: ST
 * File: ConfigureFlow.php
 * Created on: 12/12/2025
 * Created by: Claude Code
 * Approved by: Alfonso Angel Garcia Hernandez
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

    // Flow connections - indexed by step_id
    public $connections = [];

    // Validation results
    public $validationErrors = [];
    public $validationWarnings = [];
    public $isFlowValid = false;

    public function mount($process_id)
    {
        $this->process_id = $process_id;
        $this->loadProcess();
    }

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
            if ($step->is_initial_step) {
                $this->initialStepId = $step->step_id;
            }

            $this->connections[$step->step_id] = [
                'next_step_id' => $step->next_step_id,
                'next_yes' => $step->next_yes,
                'next_no' => $step->next_no,
            ];
        }

        $this->validateFlow();
    }

    public function updatedInitialStepId()
    {
        $this->validateFlow();
    }

    public function updatedConnections()
    {
        $this->validateFlow();
    }

    public function validateFlow()
    {
        $this->validationErrors = [];
        $this->validationWarnings = [];
        $this->isFlowValid = true;

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
            if ($step->step_type === 'final') {
                continue; // Final steps don't need next step
            }

            $conn = $this->connections[$step->step_id] ?? [];

            // Check if step has condition_question (conditional)
            $hasConditional = $step->step_type === 'approval' && $step->condition_question;

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
            $reachable = $this->getReachableSteps();
            foreach ($this->steps as $step) {
                if (!in_array($step->step_id, $reachable)) {
                    $this->validationWarnings[] = "El paso '{$step->title}' no es alcanzable desde el paso inicial";
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

            $hasConditional = $step->step_type === 'approval' && $step->condition_question;

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
            return [];
        }

        $orders = [];
        $visited = [];
        $queue = [['id' => $this->initialStepId, 'order' => 1]];

        while (!empty($queue)) {
            $current = array_shift($queue);
            $currentId = $current['id'];
            $currentOrder = $current['order'];

            if (in_array($currentId, $visited)) {
                continue;
            }

            $visited[] = $currentId;
            $orders[$currentId] = $currentOrder;

            $step = $this->steps->firstWhere('step_id', $currentId);

            if (!$step || $step->step_type === 'final') {
                continue;
            }

            $conn = $this->connections[$currentId] ?? [];
            $hasConditional = $step->step_type === 'approval' && $step->condition_question;

            if ($hasConditional) {
                if (!empty($conn['next_yes']) && !in_array($conn['next_yes'], $visited)) {
                    $queue[] = ['id' => $conn['next_yes'], 'order' => $currentOrder + 1];
                }
                if (!empty($conn['next_no']) && !in_array($conn['next_no'], $visited)) {
                    $queue[] = ['id' => $conn['next_no'], 'order' => $currentOrder + 1];
                }
            } else {
                if (!empty($conn['next_step_id']) && !in_array($conn['next_step_id'], $visited)) {
                    $queue[] = ['id' => $conn['next_step_id'], 'order' => $currentOrder + 1];
                }
            }
        }

        return $orders;
    }

    public function save()
    {
        $this->validateFlow();

        $reachable = $this->getReachableSteps();
        $orders = $this->calculateOrder();

        // Save all steps
        foreach ($this->steps as $step) {
            $conn = $this->connections[$step->step_id] ?? [];
            $hasConditional = $step->step_type === 'approval' && $step->condition_question;

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

        return redirect()->route(config('proj.route_name_prefix', 'proj') . '.admin.define-steps', ['process_id' => $this->process_id]);
    }

    public function render()
    {
        return view('modules.admin.configure-flow')->layout('layouts.app');
    }
}
