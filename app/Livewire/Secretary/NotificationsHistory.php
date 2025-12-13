<?php
/**
 * Company: CETAM
 * Project: ST
 * File: NotificationsHistory.php
 * Created on: 12/12/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 * 
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

namespace App\Livewire\Secretary;

use App\Models\Notification;
use Livewire\Component;
use Livewire\WithPagination;

class NotificationsHistory extends Component
{
    use WithPagination;

    public $searchTitle = '';
    public $searchUser = '';
    public $statusFilter = '';
    public $perPage = 10;

    protected $paginationTheme = 'bootstrap';
    protected $queryString = ['searchTitle', 'searchUser', 'statusFilter'];

    public function updatingSearchTitle(): void
    {
        $this->resetPage();
    }

    public function updatingSearchUser(): void
    {
        $this->resetPage();
    }

    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->searchTitle = '';
        $this->searchUser = '';
        $this->statusFilter = '';
        $this->resetPage();
    }

    public function getNotificationsProperty()
    {
        return Notification::with(['user'])
            ->when($this->searchTitle, function ($query) {
                $query->where('title', 'like', '%' . $this->searchTitle . '%');
            })
            ->when($this->searchUser, function ($query) {
                $query->whereHas('user', function ($userQuery) {
                    $userQuery->where('name', 'like', '%' . $this->searchUser . '%')
                        ->orWhere('email', 'like', '%' . $this->searchUser . '%');
                });
            })
            ->when($this->statusFilter, function ($query) {
                if ($this->statusFilter === 'leida') {
                    $query->whereNotNull('read_at');
                } elseif ($this->statusFilter === 'pendiente') {
                    $query->whereNull('read_at');
                }
            })
            ->orderByDesc('created_at')
            ->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.secretary.notifications-history', [
            'notifications' => $this->notifications,
        ])->layout('layouts.app');
    }
}
