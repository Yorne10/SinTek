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
 *   Description: Mostrar notificaciones reales para el trabajador.
--}}
<div wire:poll.10s="refreshList">
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
                    <li class="breadcrumb-item">Trámites</li>
                    <li class="breadcrumb-item active" aria-current="page">Notificaciones</li>
                </ol>
            </nav>
            <h2 class="h4">Mis notificaciones</h2>
            <p class="mb-0">Mensajes y avisos relacionados con tus trámites.</p>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="input-group input-group-sm">
                <span class="input-group-text">
                    <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                    </svg>
                </span>
                <input wire:model.debounce.500ms="search" type="text" class="form-control" placeholder="Buscar notificaciones">
            </div>
        </div>
    </div>

    <div class="card border-0 shadow">
        <div class="card-header border-0 pb-0">
            <h2 class="fs-5 fw-bold mb-0">Bandeja</h2>
            <p class="text-muted small mb-0">Lee los mensajes enviados por la secretaría y el sistema.</p>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="border-0">Título</th>
                            <th class="border-0">Detalle</th>
                            <th class="border-0">Estado</th>
                            <th class="border-0 text-end">Recibido</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($notifications as $notification)
                            <tr wire:key="notification-{{ $notification->notification_id }}">
                                <td class="fw-semibold">
                                    {{ $notification->tittle ?? 'Sin título' }}
                                    <div class="text-gray-600 small text-truncate" style="max-width: 280px;">
                                        {{ $notification->message }}
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-semibold">{{ $notification->request->process->name ?? 'Trámite' }}</div>
                                    <div class="text-muted small">Folio: {{ $notification->request_id ?? 'N/D' }}</div>
                                </td>
                                <td>
                                    @if ($notification->read_at)
                                        <span class="badge bg-secondary">Leída</span>
                                    @else
                                        <button type="button" wire:click="markAsRead({{ $notification->notification_id }})" class="btn btn-sm btn-outline-primary">
                                            Marcar como leída
                                        </button>
                                    @endif
                                </td>
                                <td class="text-end text-muted small">
                                    {{ optional($notification->created_at)->format('d/m/Y H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    No tienes notificaciones aún.
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
