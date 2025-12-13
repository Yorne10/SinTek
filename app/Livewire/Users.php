<?php
/**
 * Company: CETAM
 * Project: ST
 * File: Users.php
 * Created on: 04/12/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 *
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;

class Users extends Component
{
    use WithPagination;

    public $search = '';
    public $roleFilter = '';
    public $statusFilter = '';

    protected $paginationTheme = 'bootstrap';

    /**
     * Optimiza el input de b���squeda para que no dispare demasiadas peticiones.
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingRoleFilter()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset(['search', 'roleFilter', 'statusFilter']);
        $this->resetPage();
    }

    public function render()
    {
        $users = User::query()
            ->with(['worker.positions'])
            ->select(['users_id', 'name', 'email', 'role', 'is_active', 'created_at'])
            ->when($this->search, function ($query) {
                $search = '%' . $this->search . '%';
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', $search)
                        ->orWhere('email', 'like', $search);
                });
            })
            ->when($this->roleFilter, function ($query) {
                $query->where('role', $this->roleFilter);
            })
            ->when($this->statusFilter, function ($query) {
                if ($this->statusFilter === 'active') {
                    $query->where('is_active', 1);
                } elseif ($this->statusFilter === 'inactive') {
                    $query->where('is_active', 0);
                }
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('modules.users', [
            'users' => $users
        ])->layout('layouts.app');
    }

    public function getRoleLabel($role)
    {
        $roles = [
            'admin' => 'Administrador',
            'secretary' => 'Secretario',
            'worker' => 'Trabajador'
        ];

        return $roles[$role] ?? $role;
    }

    public function toggleUserStatus(int $userId): void
    {
        try {
            $user = User::findOrFail($userId);
            $user->is_active = !$user->is_active;
            $user->save();

            $this->dispatch(
                'users-notify',
                type: $user->is_active ? 'success' : 'warning',
                title: $user->is_active ? 'Usuario activado' : 'Usuario desactivado',
                message: $user->is_active ? 'Usuario activado correctamente.' : 'Usuario desactivado correctamente.'
            );
        } catch (\Throwable $th) {
            Log::error('No se pudo cambiar el estado del usuario', [
                'user_id' => $userId,
                'error' => $th->getMessage(),
            ]);

            $this->dispatch(
                'users-notify',
                type: 'error',
                title: 'No se pudo actualizar',
                message: 'Intenta de nuevo o contacta a soporte si el problema persiste.'
            );
        } finally {
            $this->resetPage();
        }
    }

}

