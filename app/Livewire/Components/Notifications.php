<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Livewire\Attributes\On;

class Notifications extends Component
{
    public $unreadCount = 0;
    public $notifications;

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        $user = auth()->user();
        $isWorker = $user && $user->role === 'worker';

        if ($isWorker) {
            $this->notifications = $user->notifications()->latest()->limit(5)->get();
            $this->unreadCount = $this->notifications->whereNull('read_at')->count();
        } else {
            $this->notifications = collect();
            $this->unreadCount = 0;
        }
    }

    public function refreshNotifications(): void
    {
        $this->loadNotifications();
    }

    #[On('notification-read')]
    public function handleNotificationRead(): void
    {
        $this->loadNotifications();
    }

    public function render()
    {
        return view('livewire.components.notifications');
    }
}
