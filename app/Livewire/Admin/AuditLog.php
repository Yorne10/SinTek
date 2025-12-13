<?php
/**
 * Company: CETAM
 * Project: ST
 * File: AuditLog.php
 * Created on: 05/11/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 * 
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
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

    /**

     * Updating search.

     *

     * @return void

     */

    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**

     * Updating role filter.

     *

     * @return void

     */

    public function updatingRoleFilter()
    {
        $this->resetPage();
    }

    /**

     * Clear filters.

     *

     * @return void

     */

    public function clearFilters()
    {
        $this->reset(['search', 'roleFilter']);
        $this->resetPage();
    }

    /**

     * Get role label.

     *

     * @param mixed $role

     *

     * @return void

     */

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

    /**

     * Refresh list.

     *

     * @return void

     */

    public function refreshList(): void
    {
        // Método utilizado por wire:poll para refrescar el listado.
    }

    /**

     * Render the component view.

     *

     * @return \Illuminate\View\View

     */

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
