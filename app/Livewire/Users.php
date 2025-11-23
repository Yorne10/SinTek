<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;

    public $search = '';
    public $roleFilter = '';
    public $statusFilter = '';

    protected $paginationTheme = 'bootstrap';

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

    public function render()
    {
        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->when($this->roleFilter, function ($query) {
                $query->where('role', $this->roleFilter);
            })
            ->when($this->statusFilter, function ($query) {
                if ($this->statusFilter === 'active') {
                    $query->where('active', 1);
                } elseif ($this->statusFilter === 'inactive') {
                    $query->where('active', 0);
                }
            })
            ->with('worker')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.users', [
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
}
