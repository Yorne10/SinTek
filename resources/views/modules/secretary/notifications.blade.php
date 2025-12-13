{{-- 
Company: CETAM
Project: ST
File: notifications.blade.php
Created on: 04/11/2025
Created by: Alfonso Angel Garcia Hernandez
Approved by: Alfonso Angel Garcia Hernandez

Changelog:
- ID: <ID> | Date: dd/mm/yyyy
    Modified by: <Developer name>
    Description: <Brief description of change>
--}}

<div>
    {{-- Encabezado --}}
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item">
                        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.dashboard.index') }}">
                            @icon('home', 'fa-xs')
                        </a>
                    </li>
                    <li class="breadcrumb-item">Secretaría</li>
                    <li class="breadcrumb-item">
                        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.notifications') }}">
                            Notificaciones
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $notificationId ? 'Editar' : 'Enviar' }}
                        notificación</li>
                </ol>
            </nav>
            <h2 class="h4">{{ $notificationId ? 'Editar' : 'Enviar' }} notificación</h2>
            <p class="mb-0">{{ $notificationId ? 'Actualiza los detalles de la' : 'Envía' }}
                notificación{{ $notificationId ? '' : ' a los trabajadores' }}.</p>
        </div>
    </div>

    <div class="row">
        {{-- Form: ocupa dos columnas a la izquierda --}}
        <div class="col-12 col-xl-8">
            <div class="card border-0 shadow mb-4">
                <div class="card-body">
                    <h2 class="h5 mb-4">Información de la notificación</h2>
                    <form wire:submit.prevent="save">
                        <div class="row">
                            {{-- Título --}}
                            <div class="col-md-12 mb-3">
                                <label for="title" class="form-label">Título <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    id="title" wire:model="title" placeholder="Ej: Actualización importante">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Mensaje --}}
                            <div class="col-md-12 mb-3">
                                <label for="message" class="form-label">Mensaje <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control @error('message') is-invalid @enderror" id="message" wire:model="message" rows="4"
                                    placeholder="Escribe el mensaje que verán los trabajadores..."></textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">
                                    {{ strlen($message) }}/1000 caracteres
                                </small>
                            </div>

                            @if (!$notificationId)
                                {{-- Búsqueda de trabajadores --}}
                                @if (!$sendToAll)
                                    <div class="col-md-12 mb-3">
                                        <label for="workerSearch" class="form-label">Buscar trabajador</label>
                                        <input type="text" class="form-control" id="workerSearch"
                                            wire:model.live.debounce.400ms="workerSearch"
                                            placeholder="Buscar por nombre o correo...">
                                    </div>

                                    {{-- Resultados de búsqueda --}}
                                    @if ($filteredWorkers->isNotEmpty())
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label small text-muted">Resultados de búsqueda:</label>
                                            <div class="list-group" style="max-height: 200px; overflow-y: auto;">
                                                @foreach ($filteredWorkers as $worker)
                                                    <button type="button"
                                                        class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                                                        wire:click="addUser({{ $worker->users_id }})">
                                                        <div>
                                                            <div class="fw-bold small">{{ $worker->name }}</div>
                                                            <div class="text-muted small">{{ $worker->email }}</div>
                                                        </div>
                                                        @icon('add', 'text-primary')
                                                    </button>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    {{-- Usuarios seleccionados --}}
                                    @if ($selectedWorkers->isNotEmpty())
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Destinatarios seleccionados:</label>
                                            <div class="d-flex flex-wrap gap-2">
                                                @foreach ($selectedWorkers as $worker)
                                                    <span class="badge bg-secondary d-flex align-items-center gap-2">
                                                        <button type="button" class="btn-close btn-close-white btn-sm"
                                                            wire:click="removeUser({{ $worker->users_id }})"
                                                            aria-label="Remove"></button>
                                                        {{ $worker->name }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    @error('selectedUsers')
                                        <div class="col-md-12 mb-3">
                                            <div class="text-danger small">{{ $message }}</div>
                                        </div>
                                    @enderror
                                @endif

                                {{-- Enviar a todos (al final) --}}
                                <div class="col-md-12 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="sendToAll"
                                            wire:model.live="sendToAll">
                                        <label class="form-check-label" for="sendToAll">
                                            Enviar a todos los trabajadores
                                        </label>
                                    </div>
                                </div>
                            @endif

                            {{-- Botones de envío/actualizar y cancelar/eliminar --}}
                            <div class="col-md-12 mt-3">
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex flex-wrap align-items-center gap-2">
                                        <button type="button" id="saveNotificationBtn" class="btn btn-primary"
                                            wire:loading.attr="disabled">
                                            @icon($notificationId ? 'save' : 'send', 'icon-xs me-1')
                                            {{ $notificationId ? 'Actualizar' : 'Enviar' }} notificación
                                        </button>
                                        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.notifications') }}"
                                            class="btn btn-gray-300">
                                            Cancelar
                                        </a>
                                    </div>
                                    @if ($notificationId)
                                        <div>
                                            <button type="button" id="deleteNotificationBtn" class="btn btn-danger">
                                                @icon('delete', 'icon-xs me-1')
                                                Eliminar notificación
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Tarjeta de información (estilo lista con íconos) --}}
        <div class="col-12 col-xl-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <h2 class="h6 mb-3">Información importante</h2>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0">
                            <div class="d-flex align-items-start">
                                @icon('info', 'fa-xs text-info me-3')
                                <div>
                                    <h3 class="h6">Título conciso</h3>
                                    <p class="text-gray-700 small mb-0">Máximo 200 caracteres para mantener claridad.
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="d-flex align-items-start">
                                @icon('info', 'fa-xs text-info me-3')
                                <div>
                                    <h3 class="h6">Mensaje claro</h3>
                                    <p class="text-gray-700 small mb-0">Hasta 1000 caracteres; evita copiar HTML o
                                        contenido externo.</p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="d-flex align-items-start">
                                @icon('info', 'fa-xs text-info me-3')
                                <div>
                                    <h3 class="h6">Destinatarios</h3>
                                    <p class="text-gray-700 small mb-0">Usa "Enviar a todos" o selecciona trabajadores
                                        específicos.</p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="d-flex align-items-start">
                                @icon('info', 'fa-xs text-info me-3')
                                <div>
                                    <h3 class="h6">Sin destinatarios, sin envío</h3>
                                    <p class="text-gray-700 small mb-0">Debe haber al menos un destinatario o marcar el
                                        envío a todos.</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Scripts para confirmaciones --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-primary me-2',
                cancelButton: 'btn btn-gray'
            },
            buttonsStyling: false
        });

        const isEdit = {{ $notificationId ? 'true' : 'false' }};

        // Confirmación antes de guardar/enviar notificación
        document.getElementById('saveNotificationBtn')?.addEventListener('click', function(e) {
            e.preventDefault();

            swalWithBootstrapButtons.fire({
                title: isEdit ? '¿Actualizar notificación?' : '¿Enviar notificación?',
                text: isEdit ? '¿Deseas actualizar los detalles de esta notificación?' :
                    '¿Estás seguro de enviar esta notificación a los usuarios seleccionados?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: isEdit ? 'Sí, actualizar' : 'Sí, enviar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('save');
                }
            });
        });

        // Confirmación antes de eliminar notificación
        document.getElementById('deleteNotificationBtn')?.addEventListener('click', function(e) {
            e.preventDefault();

            const swalWithDangerButton = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-danger me-2',
                    cancelButton: 'btn btn-gray'
                },
                buttonsStyling: false
            });

            swalWithDangerButton.fire({
                title: '¿Eliminar notificación?',
                text: 'Esta acción no se puede deshacer.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('deleteNotification');
                }
            });
        });

        // Listen for notification-sent event
        Livewire.on('notification-sent', (event) => {
            swalWithBootstrapButtons.fire({
                title: event.title,
                text: event.message,
                icon: event.type,
                confirmButtonText: 'Aceptar',
                showConfirmButton: true
            });
        });
    });
</script>
