{{--
* Company: CETAM
* Project: ST
* File: notifications.blade.php
* Created on: 04/11/2025
* Created by: Alfonso Angel García Hernández
* Approved by: Alfonso Angel García Hernández
*
* Changelog:
* - ID: 001 | Modified on: 08/12/2025 |
*   Modified by: Claude Code |
*   Description: Restaurada vista completa de notificaciones con formulario y tabla
--}}
<div>
    {{-- Page Header --}}
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item">
                        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.dashboard.index') }}">
                            @icon('nav.home', 'fa-xs')
                        </a>
                    </li>
                    <li class="breadcrumb-item">Secretaría</li>
                    <li class="breadcrumb-item active" aria-current="page">Notificaciones</li>
                </ol>
            </nav>
            <h2 class="h4">Notificaciones</h2>
            <p class="mb-0">Envía notificaciones a los trabajadores y consulta el historial.</p>
        </div>
    </div>

    <div class="row">
        {{-- Formulario de envío de notificaciones --}}
        <div class="col-12 col-lg-5 mb-4">
            <div class="card border-0 shadow">
                <div class="card-header border-bottom">
                    <h3 class="h5 mb-0">
                        @icon('action.create', 'me-2')
                        Nueva Notificación
                    </h3>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="sendNotification">
                        {{-- Título --}}
                        <div class="mb-3">
                            <label for="title" class="form-label">Título <span class="text-danger">*</span></label>
                            <input type="text"
                                class="form-control @error('title') is-invalid @enderror"
                                id="title"
                                wire:model="title"
                                placeholder="Ej: Actualización importante">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Mensaje --}}
                        <div class="mb-3">
                            <label for="message" class="form-label">Mensaje <span class="text-danger">*</span></label>
                            <textarea
                                class="form-control @error('message') is-invalid @enderror"
                                id="message"
                                wire:model="message"
                                rows="4"
                                placeholder="Escribe el mensaje que verán los trabajadores..."></textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                {{ strlen($message) }}/1000 caracteres
                            </small>
                        </div>

                        {{-- Enviar a todos --}}
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input"
                                    type="checkbox"
                                    id="sendToAll"
                                    wire:model.live="sendToAll">
                                <label class="form-check-label" for="sendToAll">
                                    Enviar a todos los trabajadores
                                </label>
                            </div>
                        </div>

                        {{-- Búsqueda de trabajadores --}}
                        @if(!$sendToAll)
                            <div class="mb-3">
                                <label for="workerSearch" class="form-label">Buscar trabajador</label>
                                <input type="text"
                                    class="form-control"
                                    id="workerSearch"
                                    wire:model.live.debounce.400ms="workerSearch"
                                    placeholder="Buscar por nombre o correo...">
                            </div>

                            {{-- Resultados de búsqueda --}}
                            @if($filteredWorkers->isNotEmpty())
                                <div class="mb-3">
                                    <label class="form-label small text-muted">Resultados de búsqueda:</label>
                                    <div class="list-group" style="max-height: 200px; overflow-y: auto;">
                                        @foreach($filteredWorkers as $worker)
                                            <button type="button"
                                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                                                wire:click="addUser({{ $worker->users_id }})">
                                                <div>
                                                    <div class="fw-bold small">{{ $worker->name }}</div>
                                                    <div class="text-muted small">{{ $worker->email }}</div>
                                                </div>
                                                <i class="fa-solid fa-plus text-primary"></i>
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- Usuarios seleccionados --}}
                            @if($selectedWorkers->isNotEmpty())
                                <div class="mb-3">
                                    <label class="form-label">Destinatarios seleccionados:</label>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($selectedWorkers as $worker)
                                            <span class="badge bg-primary d-flex align-items-center gap-2">
                                                {{ $worker->name }}
                                                <button type="button"
                                                    class="btn-close btn-close-white btn-sm"
                                                    wire:click="removeUser({{ $worker->users_id }})"
                                                    aria-label="Remove"></button>
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @error('selectedUsers')
                                <div class="alert alert-danger small">{{ $message }}</div>
                            @enderror
                        @endif

                        {{-- Botón de envío --}}
                        <div class="d-grid">
                            <button type="button"
                                id="sendNotificationBtn"
                                class="btn btn-gray-800 d-inline-flex align-items-center justify-content-center"
                                wire:loading.attr="disabled">
                                <span wire:loading.remove>
                                    @icon('action.send', 'me-2')
                                    Enviar Notificación
                                </span>
                                <span wire:loading>
                                    <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                    Enviando...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Historial de notificaciones --}}
        <div class="col-12 col-lg-7 mb-4">
            <div class="card border-0 shadow">
                <div class="card-header border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="h5 mb-0">
                            @icon('notif.bell', 'me-2')
                            Historial de Notificaciones
                        </h3>
                        <div class="input-group" style="max-width: 300px;">
                            <span class="input-group-text">
                                @icon('action.search', 'fa-xs')
                            </span>
                            <input type="text"
                                class="form-control form-control-sm"
                                wire:model.live.debounce.400ms="search"
                                placeholder="Buscar...">
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($notifications->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="border-0">Título</th>
                                        <th class="border-0">Destinatario</th>
                                        <th class="border-0">Fecha</th>
                                        <th class="border-0 text-center">Estado</th>
                                        <th class="border-0">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($notifications as $notification)
                                        <tr>
                                            <td>
                                                <div class="fw-bold">{{ $notification->tittle }}</div>
                                                <div class="small text-muted text-truncate" style="max-width: 200px;">
                                                    {{ $notification->message }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="small">{{ $notification->user->name ?? 'N/A' }}</div>
                                                <div class="small text-muted">{{ $notification->user->email ?? 'N/A' }}</div>
                                            </td>
                                            <td class="small text-muted">
                                                {{ $notification->created_at->format('d/m/Y H:i') }}
                                            </td>
                                            <td class="text-center">
                                                @if($notification->read_at)
                                                    <span class="badge bg-success small">Leída</span>
                                                @else
                                                    <span class="badge bg-warning small">Pendiente</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button type="button"
                                                    class="btn btn-sm btn-link view-notification-btn"
                                                    data-notification-title="{{ $notification->tittle }}"
                                                    data-notification-message="{{ $notification->message }}"
                                                    data-notification-user="{{ $notification->user->name ?? 'N/A' }}"
                                                    data-notification-date="{{ $notification->created_at->format('d/m/Y H:i') }}">
                                                    @icon('action.view', 'fa-sm')
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-3">
                                @icon('notif.bell', 'fa-3x text-gray-400')
                            </div>
                            <h5 class="text-gray-600">No hay notificaciones</h5>
                            <p class="text-gray-500 small mb-0">
                                Aún no se han enviado notificaciones a los trabajadores.
                            </p>
                        </div>
                    @endif
                </div>
                @if($notifications->hasPages())
                    <div class="card-footer border-0 d-flex justify-content-between align-items-center">
                        <div class="small text-muted">
                            Mostrando {{ $notifications->firstItem() ?? 0 }} - {{ $notifications->lastItem() ?? 0 }}
                            de {{ $notifications->total() }} notificaciones
                        </div>
                        <nav aria-label="Page navigation">
                            {{ $notifications->links() }}
                        </nav>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Scripts para confirmaciones y modales --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-primary me-2',
                cancelButton: 'btn btn-gray'
            },
            buttonsStyling: false
        });

        // Confirmación antes de enviar notificación
        document.getElementById('sendNotificationBtn')?.addEventListener('click', function (e) {
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

        // Ver detalles de notificación
        document.addEventListener('click', function (e) {
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
                    confirmButtonText: 'OK',
                    showConfirmButton: true
                });
            });
        }
    });
</script>
