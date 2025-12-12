<?php
/**
 * Company: CETAM
 * Project: ST
 * File: AuditLog.php
 * Created on: 05/11/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 */

namespace App\Livewire\Admin;

use App\Models\Log;
use Livewire\Component;
use Livewire\WithPagination;

class AuditLog extends Component
{
    use WithPagination;

    public $search = '';
    public $roleFilter = '';
    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingRoleFilter()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset(['search', 'roleFilter']);
        $this->resetPage();
    }

    public function getRoleLabel($role)
    {
        $roles = [
            'admin' => 'Administrador',
            'secretary' => 'Secretario',
            'worker' => 'Trabajador',
            'system' => 'Sistema',
        ];

        return $roles[$role] ?? 'N/D';
    }

    public function refreshList(): void
    {
        // Método utilizado por wire:poll para refrescar el listado.
    }

    public function render()
    {
        $logs = Log::with('user')
            ->when($this->search, function ($query) {
                $term = '%' . $this->search . '%';
                $query->where('action', 'like', $term)
                    ->orWhere('description', 'like', $term)
                    ->orWhereHas('user', function ($q) use ($term) {
                        $q->where('name', 'like', $term);
                    });
            })
            ->when($this->roleFilter, function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('role', $this->roleFilter);
                });
            })
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('modules.admin.audit-log', [
            'logs' => $logs,
        ])->layout('layouts.app');
    }
}
