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
            $process = Process::findOrFail($processId);
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
