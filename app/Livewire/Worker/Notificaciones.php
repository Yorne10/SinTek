<?php

namespace App\Livewire\Worker;

use App\Models\Notification;
use Livewire\Component;
use Livewire\WithPagination;

class Notificaciones extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    protected $paginationTheme = 'bootstrap';

    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function markAsRead(int $notificationId): void
    {
        Notification::where('user_id', auth()->id())
            ->whereNull('read_at')
            ->where('notification_id', $notificationId)
            ->update(['read_at' => now()]);
    }

    public function getNotificationsProperty()
    {
        return Notification::with(['request.process'])
            ->where('user_id', auth()->id())
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('tittle', 'like', '%' . $this->search . '%')
                        ->orWhere('message', 'like', '%' . $this->search . '%');
                });
            })
            ->orderByDesc('created_at')
            ->paginate($this->perPage);
    }

    public function refreshList(): void
    {
        // Método utilizado por wire:poll para refrescar el listado.
    }

    public function render()
    {
        return view('livewire.worker.notificaciones', [
            'notifications' => $this->notifications,
        ])->layout('layouts.app');
    }
}
