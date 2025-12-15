<?php
/**
 * Company: CETAM
 * Project: ST
 * File: DefineSteps.php
 * Created on: 04/11/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 *
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 *
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

namespace App\Livewire\Admin;

use App\Models\Process;
use App\Models\Step;
use App\Services\ActivityLogger;
use Livewire\Component;

class DefineSteps extends Component
{
    public $selectedProcessId;
    public $selectedProcess;
    public $steps = [];

    /**

     * Initialize component state.

     *

     * @param mixed $process_id

     *

     * @return void

     */

    public function mount($process_id = null)
    {
        // Always use the process that comes from the route. If there is none, don't force another.
        if ($process_id) {
            $this->selectedProcessId = $process_id;
            $this->loadProcess();
        } else {
            $this->selectedProcess = null;
            $this->steps = [];
        }
    }

    /**

     * Updated selected process id.

     *

     * @return void

     */

    public function updatedSelectedProcessId()
    {
        $this->loadProcess();
    }

    /**

     * Load process.

     *

     * @return void

     */

    public function loadProcess()
    {
        if (!$this->selectedProcessId) {
            $this->selectedProcess = null;
            $this->steps = [];
            return;
        }

        $this->selectedProcess = Process::with([
            'steps' => function ($query) {
                $query->orderByRaw('COALESCE(`order`, 9999) asc')
                    ->orderBy('created_at', 'asc')
                    ->with('requiredDocuments');
            },
            'creator'
        ])->find($this->selectedProcessId);

        if ($this->selectedProcess) {
            $this->steps = $this->selectedProcess->steps;

            // Only one visible initial step: the first marked is kept, the rest shown as non-initial
            $initialFound = false;
            $initialTypeFound = false;
            $this->steps = $this->steps->transform(function ($step) use (&$initialFound, &$initialTypeFound) {
                if ($step->is_initial_step) {
                    if ($initialFound) {
                        $step->is_initial_step = false;
                    } else {
                        $initialFound = true;
                    }
                }

                // Only one "initial" type in the Type column; the rest shown as "normal"
                if ($step->step_type === 'initial') {
                    if ($initialTypeFound) {
                        $step->step_type_display = 'normal';
                    } else {
                        $step->step_type_display = 'initial';
                        $initialTypeFound = true;
                    }
                } else {
                    $step->step_type_display = $step->step_type;
                }
                return $step;
            });
        } else {
            // If not found, clear to avoid showing another process.
            $this->steps = [];
        }
    }

    /**

     * Delete step.

     *

     * @param mixed $stepId

     *

     * @return void

     */

    public function deleteStep($stepId)
    {
        $step = Step::find($stepId);
        if ($step) {
            $stepTitle = $step->title;
            $process = Process::find($step->process_id);
            $processName = $process ? $process->name : 'Proceso';

            $step->delete();

            $user = auth()->user();
            ActivityLogger::log(
                'paso.eliminar',
                "Paso eliminado: '{$stepTitle}' del proceso '{$processName}'",
                $user?->users_id
            );
            $this->loadProcess();
            session()->flash('success', 'Paso eliminado exitosamente');
        }
    }

    /**

     * Render the component view.

     *

     * @return \Illuminate\View\View

     */

    public function render()
    {
        $processes = Process::where('active', 1)
            ->orderBy('name', 'asc')
            ->get();

        return view('modules.admin.define-steps', [
            'processes' => $processes
        ])->layout('layouts.app');
    }

    /**

     * Get step type label.

     *

     * @param mixed $conditionType

     *

     * @return void

     */

    public function getStepTypeLabel($conditionType)
    {
        $types = [
            'initial' => 'Paso inicial',
            'conditional' => 'Condicional',
            'final' => 'Final',
            'normal' => 'Normal',
        ];

        return $types[$conditionType] ?? ucfirst($conditionType);
    }

    /**

     * Get step type badge.

     *

     * @param mixed $conditionType

     *

     * @return void

     */

    public function getStepTypeBadge($conditionType)
    {
        $badges = [
            'initial' => 'primary',
            'conditional' => 'warning',
            'final' => 'success',
        ];

        return $badges[$conditionType] ?? 'info';
    }
}
