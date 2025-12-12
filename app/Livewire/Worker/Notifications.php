<?php

namespace App\Livewire\Worker;

use App\Models\Notification;
use App\Services\ActivityLogger;
use Livewire\Component;
use Livewire\WithPagination;

class Notifications extends Component
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
        $notification = Notification::where('user_id', auth()->id())
            ->whereNull('read_at')
            ->where('notification_id', $notificationId)
            ->first();

        if ($notification) {
            $notification->update(['read_at' => now()]);

            $user = auth()->user();

            // Log activity - SAME MESSAGE AS API
            ActivityLogger::log(
                'notificacion.marcar_leida',
                "Notificación marcada como leída: '{$notification->title}'",
                $user->users_id
            );

            // Emit event to update notifications component in topbar
            $this->dispatch('notification-read');
        }
    }

    public function getNotificationsProperty()
    {
        return Notification::with(['convocation'])
            ->where('user_id', auth()->id())
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('message', 'like', '%' . $this->search . '%');
                });
            })
            ->orderByDesc('created_at')
            ->paginate($this->perPage);
    }

    public function refreshList(): void
    {
        // Method used by wire:poll to refresh the list.
    }

    public function render()
    {
        return view('modules.worker.notifications', [
            'notifications' => $this->notifications,
        ])->layout('layouts.app');
    }
}
