{{--
Company: CETAM
Project: ST
File: notifications-history.blade.php
Created on: 12/12/2025
Created by: Codex
Approved by: Alfonso Angel Garcia Hernandez

Changelog:
- ID: <ID> | Date: dd/mm/yyyy
    Modified by: <Developer name>
    Description: <Brief description of change>
--}}

<div>
    {{-- Page Header --}}
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
                    <li class="breadcrumb-item active" aria-current="page">Notificaciones</li>
                </ol>
            </nav>
            <h2 class="h4">Notificaciones</h2>
            <p class="mb-0">Consulta las notificaciones enviadas a los trabajadores.</p>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.notifications.send') }}"
                class="btn btn-sm btn-gray-800 d-inline-flex align-items-center">
                @icon('send', 'me-2')
                Enviar notificación
            </a>
        </div>
    </div>

    {{-- Filters and Search --}}
    <div class="table-settings mb-4">
        <div class="d-flex flex-wrap gap-3 align-items-center">
            <div class="input-group fmxw-300">
                <span class="input-group-text">@icon('search', 'icon icon-xs')</span>
                <input wire:model.live.debounce.300ms="searchTitle" type="text" class="form-control"
                    placeholder="Buscar por título">
            </div>
            <div class="input-group fmxw-300">
                <span class="input-group-text">@icon('search', 'icon icon-xs')</span>
                <input wire:model.live.debounce.300ms="searchUser" type="text" class="form-control"
                    placeholder="Buscar por usuario">
            </div>
            <div class="d-flex align-items-center text-nowrap">
                <span class="small text-gray-600 me-2">Filtrar por estado:</span>
                <select wire:model.live="statusFilter" class="form-select" style="min-width: 200px;"
                    aria-label="Filtrar por estado">
                    <option value="">Todas</option>
                    <option value="leida">Leída</option>
                    <option value="pendiente">Pendiente</option>
                </select>
            </div>
            <div class="ms-auto">
                <button wire:click="clearFilters" type="button"
                    class="btn btn-sm btn-secondary text-white d-inline-flex align-items-center">
                    @icon('refresh', 'me-2 text-white')
                    Limpiar filtros
                </button>
            </div>
        </div>
    </div>

    {{-- Notifications Table --}}
    <div class="card card-body shadow border-0 table-wrapper table-responsive">
        <table class="table table-centered table-nowrap mb-0 rounded user-table align-items-center"
            style="table-layout: fixed;">
            <colgroup>
                <col style="width: 26%">
                <col style="width: 20%">
                <col style="width: 20%">
                <col style="width: 14%">
                <col style="width: 8%">
                <col style="width: 12%; min-width: 72px;">
            </colgroup>
            <thead class="thead-light">
                <tr>
                    <th class="border-0 rounded-start">Título</th>
                    <th class="border-0">Nombre</th>
                    <th class="border-0">Correo</th>
                    <th class="border-0">Fecha</th>
                    <th class="border-0">Estado</th>
                    <th class="border-0 rounded-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($notifications as $notification)
                    <tr>
                        <td>
                            <span
                                class="fw-bold text-gray-900 text-truncate d-inline-block w-100">{{ $notification->title }}</span>
                        </td>
                        <td>
                            <span
                                class="fw-normal text-truncate d-inline-block w-100">{{ $notification->user->name ?? 'N/A' }}</span>
                        </td>
                        <td>
                            <span
                                class="fw-normal text-truncate d-inline-block w-100">{{ $notification->user->email ?? 'N/A' }}</span>
                        </td>
                        <td>
                            <span class="fw-normal">{{ $notification->created_at->format('d/m/Y') }}</span>
                        </td>
                        <td>
                            @if ($notification->read_at)
                                <span class="fw-bold text-success">Leída</span>
                            @else
                                <span class="fw-bold text-warning">Pendiente</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group position-static">
                                <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    @icon('menu', 'icon icon-xs')
                                </button>
                                <div class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1">
                                    <button class="dropdown-item d-flex align-items-center view-notification-detail"
                                        type="button" data-title="{{ $notification->title }}"
                                        data-message="{{ $notification->message }}"
                                        data-user-name="{{ $notification->user->name ?? 'N/A' }}"
                                        data-user-email="{{ $notification->user->email ?? 'N/A' }}"
                                        data-date="{{ $notification->created_at->format('d/m/Y H:i') }}"
                                        data-status="{{ $notification->read_at ? 'Leída' : 'Pendiente' }}"
                                        data-read-at="{{ $notification->read_at ? $notification->read_at->format('d/m/Y H:i') : 'N/A' }}">
                                        @icon('view', 'dropdown-icon text-gray-400 me-2')
                                        Ver detalles
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <div class="text-gray-500">
                                <div class="mb-3">
                                    @icon('notification', 'fa-2x')
                                </div>
                                <p class="fw-bold">No hay notificaciones</p>
                                <p class="small">Aún no se han enviado notificaciones a los trabajadores.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div
            class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
            @if ($notifications->hasPages())
                <nav aria-label="Page navigation" class="mb-3 mb-lg-0">
                    {{ $notifications->onEachSide(1)->links('components.pagination-users') }}
                </nav>
            @endif
            <div class="fw-normal small mt-0 mt-lg-0 ms-lg-auto">
                Mostrando <b>{{ $notifications->firstItem() ?? 0 }}</b> a
                <b>{{ $notifications->lastItem() ?? 0 }}</b> de <b>{{ $notifications->total() }}</b> notificaciones
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-gray'
            },
            buttonsStyling: false
        });

        // Event listener para ver detalles
        document.addEventListener('click', function(e) {
            if (e.target.closest('.view-notification-detail')) {
                e.preventDefault();
                const button = e.target.closest('.view-notification-detail');

                const title = button.getAttribute('data-title');
                const message = button.getAttribute('data-message');
                const userName = button.getAttribute('data-user-name');
                const userEmail = button.getAttribute('data-user-email');
                const date = button.getAttribute('data-date');
                const status = button.getAttribute('data-status');
                const readAt = button.getAttribute('data-read-at');

                const statusClass = status === 'Leída' ? 'text-success' : 'text-warning';

                const htmlContent = `
                    <div class="text-start">
                        <p class="mb-2"><span class="fw-bold">Título:</span> ${title}</p>
                        <p class="mb-2"><span class="fw-bold">Mensaje:</span></p>
                        <p class="mb-3 text-muted">${message}</p>
                        <hr>
                        <p class="mb-2"><span class="fw-bold">Destinatario:</span> ${userName}</p>
                        <p class="mb-2"><span class="fw-bold">Correo:</span> ${userEmail}</p>
                        <p class="mb-2"><span class="fw-bold">Fecha de envío:</span> ${date}</p>
                        <p class="mb-2"><span class="fw-bold">Estado:</span> <span class="fw-bold ${statusClass}">${status}</span></p>
                        ${readAt !== 'N/A' ? `<p class="mb-0"><span class="fw-bold">Leída el:</span> ${readAt}</p>` : ''}
                    </div>
                `;

                swalWithBootstrapButtons.fire({
                    title: 'Detalles de la notificación',
                    html: htmlContent,
                    icon: 'info',
                    confirmButtonText: 'Cerrar',
                    showConfirmButton: true,
                    width: '600px'
                });
            }
        });
    });
</script>
