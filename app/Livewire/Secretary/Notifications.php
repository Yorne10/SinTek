<?php
/**
 * Company: CETAM
 * Project: ST
 * File: Notifications.php
 * Created on: 04/11/2025
 * Created by: Alfonso Angel García Hernández
 * Approved by: Alfonso Angel García Hernández
 *
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

namespace App\Livewire\Secretary;

use App\Events\NotificationCreated;
use App\Models\Notification;
use App\Models\User;
use App\Services\ActivityLogger;
use Livewire\Component;
use Livewire\WithPagination;

class Notifications extends Component
{
    use WithPagination;

    public $workerSearch = '';
    public $sendToAll = false;
    public $selectedUsers = [];
    public $title = '';
    public $message = '';
    public $search = '';
    public $perPage = 8;
    public $notificationId = null;

    protected $paginationTheme = 'bootstrap';

    protected $messages = [
        'selectedUsers.required' => 'Selecciona al menos un usuario o marca enviar a todos.',
        'selectedUsers.array' => 'El formato de usuarios no es válido.',
        'selectedUsers.*.exists' => 'Alguno de los usuarios seleccionados no existe.',
        'title.required' => 'Agrega un título para la notificación.',
        'title.max' => 'El título no debe exceder 200 caracteres.',
        'message.required' => 'Escribe el mensaje que verá el usuario.',
        'message.max' => 'El mensaje es demasiado largo (máx. 1000 caracteres).',
    ];

    protected $queryString = ['search'];

    /**

     * Initialize component state.

     *

     * @param mixed $notificationId

     *

     * @return void

     */

    public function mount($notificationId = null): void
    {
        if ($notificationId) {
            $this->notificationId = $notificationId;
            $notification = Notification::findOrFail($notificationId);
            $this->title = $notification->title;
            $this->message = $notification->message;
        }
    }

    /**

     * Updating search.

     *

     * @return void

     */

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    /**

     * Updating worker search.

     *

     * @return void

     */

    public function updatingWorkerSearch(): void
    {
        // keep pagination consistent on search change
        $this->resetPage();
    }

    /**

     * Updated send to all.

     *

     * @param mixed $value

     *

     * @return void

     */

    public function updatedSendToAll($value): void
    {
        // Si se activa "enviar a todos", limpiar selección individual
        if ($value) {
            $this->selectedUsers = [];
            $this->workerSearch = '';
        }
    }

    /**

     * Add user.

     *

     * @param int $userId

     *

     * @return void

     */

    public function addUser(int $userId): void
    {
        if ($this->sendToAll) {
            return;
        }

        $exists = User::where('users_id', $userId)->where('role', 'worker')->exists();
        if (!$exists) {
            return;
        }

        if (!in_array($userId, $this->selectedUsers, true)) {
            $this->selectedUsers[] = $userId;
        }
    }

    /**

     * Remove user.

     *

     * @param int $userId

     *

     * @return void

     */

    public function removeUser(int $userId): void
    {
        $this->selectedUsers = array_values(array_filter(
            $this->selectedUsers,
            fn($id) => (int) $id !== $userId
        ));
    }

    /**

     * Save the data.

     *

     * @return void

     */

    public function save(): void
    {
        if ($this->notificationId) {
            $this->updateNotification();
        } else {
            $this->sendNotification();
        }
    }

    /**

     * Update notification.

     *

     * @return void

     */

    public function updateNotification(): void
    {
        $this->validate([
            'title' => 'required|string|max:200',
            'message' => 'required|string|max:1000',
        ], $this->messages);

        $notification = Notification::findOrFail($this->notificationId);
        $notification->title = $this->title;
        $notification->message = $this->message;
        $notification->save();

        ActivityLogger::log(
            'notificacion.editar',
            "Notificación '{$this->title}' actualizada",
            auth()->user()?->users_id
        );

        $this->dispatch(
            'notification-updated',
            type: 'success',
            title: '¡Notificación actualizada!',
            message: 'La notificación ha sido actualizada exitosamente.'
        );

        $this->redirect(route(config('proj.route_name_prefix', 'proj') . '.secretary.notifications'));
    }

    /**

     * Send notification.

     *

     * @return void

     */

    public function sendNotification(): void
    {
        $rules = [
            'title' => 'required|string|max:200',
            'message' => 'required|string|max:1000',
        ];

        if (!$this->sendToAll) {
            $rules['selectedUsers'] = 'required|array|min:1';
            $rules['selectedUsers.*'] = 'exists:users,users_id';
        }

        $this->validate($rules, $this->messages);

        $recipients = $this->sendToAll
            ? User::where('role', 'worker')->get()
            : User::whereIn('users_id', $this->selectedUsers)->where('role', 'worker')->get();

        if ($recipients->isEmpty()) {
            $this->addError('selectedUsers', 'Selecciona al menos un trabajador.');
            return;
        }

        foreach ($recipients as $recipient) {
            Notification::create([
                'user_id' => $recipient->users_id,
                'title' => $this->title,
                'message' => $this->message,
            ]);
        }

        $count = $recipients->count();
        $this->reset(['title', 'message', 'selectedUsers', 'sendToAll', 'workerSearch']);
        $this->resetPage();

        $sender = auth()->user();
        $targetLabel = $this->sendToAll ? 'todos los trabajadores' : "{$count} usuario(s)";
        ActivityLogger::log(
            'notificacion.crear',
            "Notificación '{$this->title}' enviada a {$targetLabel}",
            $sender?->users_id
        );

        $this->dispatch(
            'notification-sent',
            type: 'success',
            title: '¡Notificación enviada!',
            message: "La notificación ha sido enviada a {$count} " . ($count === 1 ? 'usuario' : 'usuarios') . " exitosamente."
        );
    }

    /**

     * Delete notification.

     *

     * @return void

     */

    public function deleteNotification(): void
    {
        if (!$this->notificationId) {
            return;
        }

        $notification = Notification::findOrFail($this->notificationId);
        $title = $notification->title;
        $notification->delete();

        ActivityLogger::log(
            'notificacion.eliminar',
            "Notificación '{$title}' eliminada",
            auth()->user()?->users_id
        );

        $this->dispatch(
            'notification-deleted',
            type: 'success',
            title: '¡Notificación eliminada!',
            message: 'La notificación ha sido eliminada exitosamente.'
        );

        $this->redirect(route(config('proj.route_name_prefix', 'proj') . '.secretary.notifications'));
    }

    /**

     * Get filtered workers property.

     *

     * @return void

     */

    public function getFilteredWorkersProperty()
    {
        if (trim($this->workerSearch) === '') {
            return collect();
        }

        return User::where('role', 'worker')
            ->when($this->workerSearch, function ($query) {
                $query->where(function ($q) {
                    $term = '%' . $this->workerSearch . '%';
                    $q->where('name', 'like', $term)
                        ->orWhere('email', 'like', $term);
                });
            })
            ->orderBy('name')
            ->limit(15)
            ->get(['users_id', 'name', 'email']);
    }

    /**

     * Get notifications property.

     *

     * @return void

     */

    public function getNotificationsProperty()
    {
        return Notification::with(['user'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('message', 'like', '%' . $this->search . '%');
                });
            })
            ->orderByDesc('created_at')
            ->paginate($this->perPage);
    }

    /**

     * Get selected workers property.

     *

     * @return void

     */

    public function getSelectedWorkersProperty()
    {
        if (empty($this->selectedUsers)) {
            return collect();
        }

        return User::whereIn('users_id', $this->selectedUsers)
            ->get(['users_id', 'name', 'email'])
            ->keyBy('users_id');
    }

    /**

     * Render the component view.

     *

     * @return \Illuminate\View\View

     */

    public function render()
    {
        return view('modules.secretary.notifications', [
            'filteredWorkers' => $this->filteredWorkers,
            'selectedWorkers' => $this->selectedWorkers,
            'notifications' => $this->notifications,
        ])->layout('layouts.app');
    }
}

