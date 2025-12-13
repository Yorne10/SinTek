<?php
/**
 * Company: CETAM
 * Project: ST
 * File: Notifications.php
 * Created on: 12/12/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 *
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

namespace App\Livewire\Components;

use Livewire\Component;
use Livewire\Attributes\On;

class Notifications extends Component
{
    public $unreadCount = 0;
    public $notifications;
    public $notificationRoute = '#';
    public $isWorker = false;

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        $user = auth()->user();
        $this->isWorker = $user && $user->role === 'worker';

        if ($this->isWorker) {
            $this->notifications = $user->notifications()->latest()->limit(5)->get();
            $this->unreadCount = $user->notifications()->whereNull('read_at')->count();
            $this->notificationRoute = route(config('proj.route_name_prefix', 'proj') . '.worker.notifications');
        } else {
            $this->notifications = collect();
            $this->unreadCount = 0;
            $this->notificationRoute = '#';
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
