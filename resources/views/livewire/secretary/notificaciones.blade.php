{{-- 
 * Company: CETAM
 * Project: ST
 * File: notificaciones.blade.php
 * Created on: 04/11/2025
 * Created by: Alfonso Angel García Hernández
 * Approved by: Alfonso Angel García Hernández
 *
 * Changelog:
 * - ID: <ID> | Modified on: 22/11/2025 |
 *   Modified by: Codex |
 *   Description: Envío de notificaciones manuales con buscador y selección múltiple.
--}}
<div>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item">
                        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.dashboard.index') }}">
                            @icon('nav.home', 'icon icon-xxs')
                        </a>
                    </li>
                    <li class="breadcrumb-item">Secretaría</li>
                    <li class="breadcrumb-item active" aria-current="page">Notificaciones</li>
                </ol>
            </nav>
            <h2 class="h4">Notificaciones a trabajadores</h2>
            <p class="mb-0">Busca trabajadores por nombre o correo, agrégalos y envía un mensaje. También puedes enviarlo a todos.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-lg-5 mb-4">
            <div class="card border-0 shadow h-100">
                <div class="card-header bg-white border-0 pb-0">
                    <h2 class="fs-5 fw-bold mb-0">Enviar notificación</h2>
                    <p class="text-muted small mb-0">Solo título y mensaje; selecciona destinatarios o marca “enviar a todos”.</p>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="sendNotification">
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" role="switch" id="sendToAll" wire:model="sendToAll">
                            <label class="form-check-label" for="sendToAll">Enviar a todos los trabajadores</label>
                            <div class="text-muted small">Si activas esta opción no necesitas seleccionar usuarios.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Buscar trabajadores</label>
                            <input type="text" class="form-control" placeholder="Nombre o correo" wire:model.live.debounce.400ms="workerSearch" wire:keydown.enter.prevent @if($sendToAll) disabled @endif>
                            <small class="text-muted d-block mt-1">Los resultados aparecen al escribir, no necesitas presionar Enter. Usa “Agregar” para añadirlos a la lista.</small>
                        </div>

                        @if (!$sendToAll)
                            <div class="mb-3">
                                <div class="list-group small mb-2">
                                    @if (trim($workerSearch) === '')
                                        <div class="list-group-item text-muted">Escribe para buscar trabajadores.</div>
                                    @else
                                        @forelse ($filteredWorkers as $worker)
                                            <button type="button" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" wire:click="addUser({{ $worker->users_id }})">
                                                <span>
                                                    <strong>{{ $worker->name }}</strong>
                                                    <span class="text-muted d-block">{{ $worker->email }}</span>
                                                </span>
                                                <span class="badge bg-primary">Agregar</span>
                                            </button>
                                        @empty
                                            <div class="list-group-item text-muted">Sin resultados para “{{ $workerSearch }}”.</div>
                                        @endforelse
                                    @endif
                                </div>

                                <label class="form-label fw-semibold">Destinatarios seleccionados</label>
                                <div class="d-flex flex-wrap gap-2">
                                    @forelse ($selectedUsers as $userId)
                                        @php $user = $selectedWorkers->get($userId); @endphp
                                        <span class="badge bg-secondary d-flex align-items-center">
                                            <span class="me-2">{{ $user->name ?? 'Usuario' }}</span>
                                            <button type="button" class="btn-close btn-close-white btn-sm" wire:click="removeUser({{ $userId }})" aria-label="Eliminar"></button>
                                        </span>
                                    @empty
                                        <span class="text-muted small">Aún no seleccionas usuarios.</span>
                                    @endforelse
                                </div>
                                @error('selectedUsers') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                @error('selectedUsers.*') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Título</label>
                            <input wire:model.defer="title" type="text" class="form-control @error('title') is-invalid @enderror" placeholder="Ej. Documento listo para recoger">
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Mensaje</label>
                            <textarea wire:model.defer="message" rows="4" class="form-control @error('message') is-invalid @enderror" placeholder="Explica brevemente al usuario qué debe saber."></textarea>
                            @error('message') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="text-muted d-block mt-1">Ejemplo: “Tu documento ya está listo, puedes pasar por ventanilla”.</small>
                        </div>

                        <button type="button" id="sendNotificationBtn" class="btn btn-primary w-100 animate-up-2">
                            <span class="icon icon-xs text-white me-2 fas fa-paper-plane"></span>
                            Enviar notificación
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-7">
            <div class="card border-0 shadow h-100">
                <div class="card-header d-flex align-items-center border-0 pb-0">
                    <div>
                        <h2 class="fs-5 fw-bold mb-0">Historial de notificaciones</h2>
                        <p class="text-muted small mb-0">Mensajes enviados a trabajadores.</p>
                    </div>
                    <div class="ms-auto" style="min-width: 240px;">
                        <input wire:model.debounce.500ms="search" type="text" class="form-control form-control-sm" placeholder="Buscar por título o mensaje">
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th class="border-0">Título</th>
                                    <th class="border-0">Destino</th>
                                    <th class="border-0">Fecha</th>
                                    <th class="border-0">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($notifications as $notification)
                                    <tr wire:key="notification-{{ $notification->notification_id }}">
                                        <td class="fw-semibold">
                                            {{ $notification->tittle ?? 'Sin título' }}
                                            <div class="text-gray-600 small mb-0 text-truncate" style="max-width: 280px;">
                                                {{ $notification->message }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="fw-semibold">{{ $notification->user->name ?? 'Usuario' }}</div>
                                            <div class="text-muted small">{{ $notification->user->email ?? 'N/A' }}</div>
                                        </td>
                                        <td class="text-muted small">
                                            {{ optional($notification->created_at)->format('d/m/Y H:i') }}
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-secondary view-notification-btn" data-notification-id="{{ $notification->notification_id }}" data-notification-title="{{ $notification->tittle ?? 'Sin título' }}" data-notification-message="{{ $notification->message }}" data-notification-user="{{ $notification->user->name ?? 'Usuario' }}" data-notification-date="{{ optional($notification->created_at)->format('d/m/Y H:i') }}">
                                                <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                                </svg>
                                                Ver detalles
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">
                                            No hay notificaciones para mostrar.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer border-0">
                    {{ $notifications->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-primary me-2',
            cancelButton: 'btn btn-gray'
        },
        buttonsStyling: false
    });

    // Botón enviar notificación con confirmación
    document.getElementById('sendNotificationBtn')?.addEventListener('click', function(e) {
        e.preventDefault();

        swalWithBootstrapButtons.fire({
            title: '¿Enviar notificación?',
            text: '¿Estás seguro de enviar esta notificación a los usuarios seleccionados?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, enviar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                @this.call('sendNotification');
            }
        });
    });

    // Event listener para ver detalles de notificación
    document.addEventListener('click', function(e) {
        if (e.target.closest('.view-notification-btn')) {
            const button = e.target.closest('.view-notification-btn');
            const title = button.getAttribute('data-notification-title');
            const message = button.getAttribute('data-notification-message');
            const user = button.getAttribute('data-notification-user');
            const date = button.getAttribute('data-notification-date');

            swalWithBootstrapButtons.fire({
                title: title,
                html: `
                    <div class="text-start">
                        <p class="mb-3"><strong>Mensaje:</strong></p>
                        <p class="mb-3">${message}</p>
                        <hr>
                        <p class="mb-2"><strong>Destinatario:</strong> ${user}</p>
                        <p class="mb-0 text-muted small"><strong>Fecha:</strong> ${date}</p>
                    </div>
                `,
                icon: 'info',
                confirmButtonText: 'Cerrar',
                width: '600px'
            });
        }
    });

    // Escuchar evento de notificación enviada
    if (window.Livewire) {
        Livewire.on('notification-sent', (event) => {
            const detail = event || {};
            swalWithBootstrapButtons.fire({
                icon: detail.type || 'success',
                title: detail.title || 'Aviso',
                text: detail.message || '',
                confirmButtonText: 'Entendido',
                showConfirmButton: true
            });
        });
    }
});
</script>
