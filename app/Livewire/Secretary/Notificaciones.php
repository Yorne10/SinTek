<?php
/**
 * Company: CETAM
 * Project: ST
 * File: Notificaciones.php
 * Created on: 04/11/2025
 * Created by: Alfonso Angel García Hernández
 * Approved by: Alfonso Angel García Hernández
 *
 * Changelog:
 * - ID: <ID> | Modified on: 22/11/2025 |
 *   Modified by: Codex |
 *   Description: Envío de notificaciones manuales a uno o varios trabajadores.
 */

namespace App\Livewire\Secretary;

use App\Events\NotificationCreated;
use App\Models\Notification;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Notificaciones extends Component
{
    use WithPagination;

    public $workerSearch = '';
    public $sendToAll = false;
    public $selectedUsers = [];
    public $title = '';
    public $message = '';
    public $search = '';
    public $perPage = 8;

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

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingWorkerSearch(): void
    {
        // keep pagination consistent on search change
        $this->resetPage();
    }

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

    public function removeUser(int $userId): void
    {
        $this->selectedUsers = array_values(array_filter(
            $this->selectedUsers,
            fn ($id) => (int) $id !== $userId
        ));
    }

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
                'request_id' => null,
                'user_id' => $recipient->users_id,
                'tittle' => $this->title,
                'message' => $this->message,
                'type' => 'general',
            ]);
        }

        $count = $recipients->count();
        $this->reset(['title', 'message', 'selectedUsers', 'sendToAll', 'workerSearch']);
        $this->resetPage();

        $this->dispatch(
            'notification-sent',
            type: 'success',
            title: '¡Notificación enviada!',
            message: "La notificación ha sido enviada a {$count} " . ($count === 1 ? 'usuario' : 'usuarios') . " exitosamente."
        );
    }

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

    public function getNotificationsProperty()
    {
        return Notification::with(['user'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('tittle', 'like', '%' . $this->search . '%')
                        ->orWhere('message', 'like', '%' . $this->search . '%');
                });
            })
            ->orderByDesc('created_at')
            ->paginate($this->perPage);
    }

    public function getSelectedWorkersProperty()
    {
        if (empty($this->selectedUsers)) {
            return collect();
        }

        return User::whereIn('users_id', $this->selectedUsers)
            ->get(['users_id', 'name', 'email'])
            ->keyBy('users_id');
    }

    public function render()
    {
        return view('livewire.secretary.notificaciones', [
            'filteredWorkers' => $this->filteredWorkers,
            'selectedWorkers' => $this->selectedWorkers,
            'notifications' => $this->notifications,
        ])->layout('layouts.app');
    }
}
