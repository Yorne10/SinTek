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
                            <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
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

    @if (session()->has('success'))
        <div class="alert alert-success d-flex align-items-center" role="alert">
            <span class="icon icon-sm text-success me-2 fas fa-check-circle"></span>
            <div>{{ session('success') }}</div>
        </div>
    @endif

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

                        <button type="submit" class="btn btn-primary w-100 animate-up-2">
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
                                    <th class="border-0">Tipo</th>
                                    <th class="border-0 text-end">Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($notifications as $notification)
                                    <tr wire:key="notification-{{ $notification->notification_id }}">
                                        <td class="fw-semibold">
                                            {{ $notification->tittle ?? 'Sin título' }}
                                            <div class="text-gray-600 small mb-0 text-truncate" style="max-width: 320px;">
                                                {{ $notification->message }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="fw-semibold">{{ $notification->user->name ?? 'Usuario' }}</div>
                                            <div class="text-muted small">General</div>
                                        </td>
                                        <td>
                                            <span class="badge bg-info text-white text-capitalize">
                                                {{ $notification->type ?? 'general' }}
                                            </span>
                                        </td>
                                        <td class="text-end text-muted small">
                                            {{ optional($notification->created_at)->format('d/m/Y H:i') }}
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
