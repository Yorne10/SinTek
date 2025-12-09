<?php
/**
 * Company: CETAM
 * Project: ST
 * File: EditProcess.php
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

use Livewire\Component;
use App\Models\Process;
use Illuminate\Support\Facades\Log;

class EditProcess extends Component
{
    public $selectedProcessId;
    public $selectedProcess;

    // Propiedades públicas para el formulario
    public $name;
    public $description;
    public $category;
    public $department;
    public $active = false;
    public $process_code;

    protected $rules = [
        'name' => 'required|string|max:150',
        'description' => 'nullable|string',
        'category' => 'nullable|string|max:100',
        'department' => 'nullable|string|max:100',
        'active' => 'boolean',
    ];

    public function mount($process_id = null)
    {
        // Si se proporciona un process_id desde la ruta, usarlo
        if ($process_id) {
            $this->selectedProcessId = $process_id;
            $this->loadProcess();
        }
    }

    public function updatedSelectedProcessId()
    {
        $this->loadProcess();
    }

    public function loadProcess()
    {
        if ($this->selectedProcessId) {
            $this->selectedProcess = Process::with('creator')->find($this->selectedProcessId);

            if ($this->selectedProcess) {
                // Cargar los datos en las propiedades públicas
                $this->name = $this->selectedProcess->name;
                $this->description = $this->selectedProcess->description;
                $this->category = $this->selectedProcess->category;
                $this->department = $this->selectedProcess->department;
                $this->active = $this->selectedProcess->active;
                $this->process_code = $this->selectedProcess->process_code;
            }
        }
    }

    public function updateProcess()
    {
        $this->validate();

        try {
            $process = Process::find($this->selectedProcessId);
            $process->update([
                'name' => $this->name,
                'description' => $this->description,
                'category' => $this->category,
                'department' => $this->department,
                'active' => $this->active ?? false,
            ]);

            $this->dispatch('process-updated',
                title: 'Proceso actualizado',
                message: 'El proceso se actualizó correctamente.'
            );

            // Recargar el proceso
            $this->loadProcess();
        } catch (\Throwable $th) {
            Log::error('Error al actualizar proceso', [
                'process_id' => $this->selectedProcessId,
                'error' => $th->getMessage(),
            ]);

            $this->dispatch('process-error',
                title: 'Error al actualizar',
                message: 'No se pudo actualizar el proceso. Intenta de nuevo.'
            );
        }
    }

    public function deleteProcess()
    {
        try {
            $process = Process::find($this->selectedProcessId);
            if ($process) {
                $process->delete();

                $this->dispatch('process-deleted',
                    title: 'Proceso eliminado',
                    message: 'El proceso se eliminó correctamente.'
                );
            }
        } catch (\Throwable $th) {
            Log::error('Error al eliminar proceso', [
                'process_id' => $this->selectedProcessId,
                'error' => $th->getMessage(),
            ]);

            $this->dispatch('process-error',
                title: 'Error al eliminar',
                message: 'No se pudo eliminar el proceso. Intenta de nuevo.'
            );
        }
    }

    public function render()
    {
        $processes = Process::orderBy('name', 'asc')->get();

        return view('modules.admin.edit-process', [
            'processes' => $processes
        ])->layout('layouts.app');
    }
}
