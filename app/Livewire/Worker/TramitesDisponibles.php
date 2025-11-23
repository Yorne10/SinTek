<?php
/**
 * Empresa: CETAM
 * Proyecto: ST
 * Archivo: TramitesDisponibles.php
 * Fecha de creación: 03/11/25
 * Realizado por: Alfonso Angel García Hernández
 * Validado por: Alfonso Angel García Hernández
 */

namespace App\Livewire\Worker;

use App\Models\Process;
use Livewire\Component;

class TramitesDisponibles extends Component
{
    public $search = '';
    public $categoryFilter = '';

    public function render()
    {
        $query = Process::with('steps')
            ->where('active', 1);

        // Aplicar búsqueda
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        // Aplicar filtro de categoría
        if ($this->categoryFilter) {
            $query->where('category', $this->categoryFilter);
        }

        $procesos = $query->orderBy('priority', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.worker.tramites-disponibles', [
            'procesos' => $procesos
        ])->layout('layouts.app');
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->categoryFilter = '';
    }
}
