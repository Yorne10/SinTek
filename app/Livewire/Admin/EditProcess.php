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
use App\Services\ActivityLogger;
use Illuminate\Support\Facades\Auth;

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

    /**

     * Initialize component state.

     *

     * @param mixed $process_id

     *

     * @return void

     */

    public function mount($process_id = null)
    {
        // Si se proporciona un process_id desde la ruta, usarlo
        if ($process_id) {
            $this->selectedProcessId = $process_id;
            $this->loadProcess();
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

    /**

     * Update process.

     *

     * @return void

     */

    public function updateProcess()
    {
        $this->validate();

        try {
            $process = Process::with('steps')->find($this->selectedProcessId);

            // Si se está intentando activar, validar el flujo
            if ($this->active && !$process->active) {
                $steps = $process->steps;

                // Verificar que haya al menos un paso
                if ($steps->count() === 0) {
                    $this->dispatch(
                        'process-error',
                        title: 'No se puede activar',
                        message: 'El proceso no tiene pasos definidos. Define al menos un paso inicial y uno final.'
                    );
                    return;
                }

                // Verificar paso inicial
                $initialSteps = $steps->where('is_initial_step', true);
                if ($initialSteps->count() === 0) {
                    $this->dispatch(
                        'process-error',
                        title: 'No se puede activar',
                        message: 'No hay un paso inicial definido. Ve a "Configurar flujo" y selecciona el paso inicial.'
                    );
                    return;
                }

                // Verificar paso final
                $finalSteps = $steps->where('step_type', 'final');
                if ($finalSteps->count() === 0) {
                    $this->dispatch(
                        'process-error',
                        title: 'No se puede activar',
                        message: 'No hay un paso de tipo "Final". Crea al menos un paso de tipo finalización.'
                    );
                    return;
                }

                // Verificar que todos los pasos estén vinculados
                $unlinkedSteps = $steps->where('is_linked', false);
                if ($unlinkedSteps->count() > 0) {
                    $unlinkedNames = $unlinkedSteps->pluck('title')->take(3)->implode(', ');
                    $this->dispatch(
                        'process-error',
                        title: 'No se puede activar',
                        message: "Hay pasos sin vincular: {$unlinkedNames}. Ve a \"Configurar flujo\" para conectar todos los pasos."
                    );
                    return;
                }
            }

            $process->update([
                'name' => $this->name,
                'description' => $this->description,
                'process_code' => $this->process_code,
                'category' => $this->category,
                'department' => $this->department,
                'active' => $this->active ?? false,
            ]);

            // Registrar en bitácora
            $user = Auth::user();
            ActivityLogger::log(
                'proceso.editar',
                "Proceso editado: '{$this->name}'" . ($this->category ? " - Categoría: {$this->category}" : ''),
                $user?->users_id
            );

            $this->dispatch(
                'process-updated',
                title: 'Proceso actualizado',
                message: 'El proceso se actualizó correctamente.',
                redirect: route(config('proj.route_name_prefix', 'proj') . '.secretary.processes')
            );

            // Recargar el proceso
            $this->loadProcess();
        } catch (\Throwable $th) {
            Log::error('Error al actualizar proceso', [
                'process_id' => $this->selectedProcessId,
                'error' => $th->getMessage(),
            ]);

            $this->dispatch(
                'process-error',
                title: 'Error al actualizar',
                message: 'No se pudo actualizar el proceso. Intenta de nuevo.'
            );
        }
    }

    /**

     * Delete process.

     *

     * @return void

     */

    public function deleteProcess()
    {
        try {
            $process = Process::find($this->selectedProcessId);
            if ($process) {
                $processName = $process->name;
                $processCategory = $process->category;

                $process->delete();

                // Registrar en bitácora
                $user = Auth::user();
                ActivityLogger::log(
                    'proceso.eliminar',
                    "Proceso eliminado: '{$processName}'" . ($processCategory ? " - Categoría: {$processCategory}" : ''),
                    $user?->users_id
                );

                $this->dispatch(
                    'process-deleted',
                    title: 'Proceso eliminado',
                    message: 'El proceso se eliminó correctamente.'
                );
            }
        } catch (\Throwable $th) {
            Log::error('Error al eliminar proceso', [
                'process_id' => $this->selectedProcessId,
                'error' => $th->getMessage(),
            ]);

            $this->dispatch(
                'process-error',
                title: 'Error al eliminar',
                message: 'No se pudo eliminar el proceso. Intenta de nuevo.'
            );
        }
    }

    /**

     * Render the component view.

     *

     * @return \Illuminate\View\View

     */

    public function render()
    {
        $processes = Process::orderBy('name', 'asc')->get();

        return view('modules.admin.edit-process', [
            'processes' => $processes
        ])->layout('layouts.app');
    }
}
