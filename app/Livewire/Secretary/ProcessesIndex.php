<?php

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

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset(['search', 'statusFilter']);
        $this->resetPage();
    }

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

    public function toggleProcessStatus(int $processId): void
    {
        try {
            $process = Process::with('steps')->findOrFail($processId);

            // Si se está intentando activar, validar el flujo
            if (!$process->active) {
                $steps = $process->steps;

                // Verificar que haya al menos un paso
                if ($steps->count() === 0) {
                    $this->dispatch(
                        'processes-notify',
                        type: 'error',
                        title: 'No se puede activar',
                        message: 'El proceso no tiene pasos definidos. Define al menos un paso inicial y uno final.'
                    );
                    return;
                }

                // Verificar paso inicial
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

                // Verificar paso final
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

                // Verificar que todos los pasos estén vinculados
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
