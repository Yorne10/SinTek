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

    public function mount($process_id = null)
    {
        // Si se proporciona un process_id desde la ruta, usarlo
        if ($process_id) {
            $this->selectedProcessId = $process_id;
            $this->loadProcess();
        } else {
            // Seleccionar el primer proceso disponible por defecto
            $firstProcess = Process::where('active', 1)->first();
            if ($firstProcess) {
                $this->selectedProcessId = $firstProcess->process_id;
                $this->loadProcess();
            }
        }
    }

    public function updatedSelectedProcessId()
    {
        $this->loadProcess();
    }

    public function loadProcess()
    {
        if ($this->selectedProcessId) {
            $this->selectedProcess = Process::with([
                'steps' => function ($query) {
                    $query->orderBy('order', 'asc')->with('requiredDocuments');
                }
            ])->find($this->selectedProcessId);

            if ($this->selectedProcess) {
                $this->steps = $this->selectedProcess->steps;
            }
        }
    }

    public function deleteStep($stepId)
    {
        $step = Step::find($stepId);
        if ($step) {
            $step->delete();
            $user = auth()->user();
            ActivityLogger::log(
                'paso.eliminar',
                "Paso '{$step->tittle}' eliminado del proceso ID {$step->process_id}",
                $user?->users_id
            );
            $this->loadProcess();
            session()->flash('success', 'Paso eliminado exitosamente');
        }
    }

    public function render()
    {
        $processes = Process::where('active', 1)
            ->orderBy('name', 'asc')
            ->get();

        return view('modules.admin.define-steps', [
            'processes' => $processes
        ])->layout('layouts.app');
    }

    public function getStepTypeLabel($conditionType)
    {
        $types = [
            'form' => 'Formulario',
            'approval' => 'Aprobación',
            'upload' => 'Carga de archivos',
            'final' => 'Final',
        ];

        return $types[$conditionType] ?? ucfirst($conditionType);
    }

    public function getStepTypeBadge($conditionType)
    {
        $badges = [
            'form' => 'info',
            'approval' => 'warning',
            'upload' => 'secondary',
            'final' => 'success',
        ];

        return $badges[$conditionType] ?? 'primary';
    }
}

