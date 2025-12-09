{{--
* Company: CETAM
* Project: ST
* File: notifications.blade.php
* Created on: 04/12/2025
* Created by: Alfonso Angel Garcia Hernandez
* Approved by: Alfonso Angel Garcia Hernandez
*
* Changelog:
* - ID: 001 | Modified on: 04/12/2025 |
*   Modified by: Claude Code |
*   Description: Refactored notifications table to match users table design with actions menu
--}}

<div wire:poll.10s="refreshList">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item">
                        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.dashboard.index') }}">
                            @icon('nav.home', 'fa-xs')
                        </a>
                    </li>
                    <li class="breadcrumb-item">Trámites</li>
                    <li class="breadcrumb-item active" aria-current="page">Notificaciones</li>
                </ol>
            </nav>
            <h2 class="h4">Mis notificaciones</h2>
            <p class="mb-0">Mensajes y avisos relacionados con tus trámites.</p>
        </div>
    </div>

    <div class="table-settings mb-4">
        <div class="d-flex flex-wrap gap-3 align-items-center">
            <div class="input-group fmxw-300">
                <span class="input-group-text">
                    <svg class="icon icon-xs" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                            clip-rule="evenodd"></path>
                    </svg>
                </span>
                <input wire:model.live.debounce.400ms="search" type="text"
                    class="form-control" placeholder="Buscar notificaciones">
            </div>
        </div>
    </div>

    <div class="card card-body shadow border-0 table-wrapper table-responsive">
        <table class="table table-centered table-nowrap mb-0 rounded align-items-center">
            <thead class="thead-light">
                <tr>
                    <th class="border-0 rounded-start">Título</th>
                    <th class="border-0">Mensaje</th>
                    <th class="border-0">Estado</th>
                    <th class="border-0">Recibido</th>
                    <th class="border-0 rounded-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($notifications as $notification)
                    <tr wire:key="notification-{{ $notification->notification_id }}">
                        <td>
                            <span class="fw-bold text-gray-900">{{ $notification->tittle ?? 'Sin título' }}</span>
                        </td>
                        <td>
                            <span class="fw-normal text-truncate d-inline-block" style="max-width: 400px;">
                                {{ $notification->message }}
                            </span>
                        </td>
                        <td>
                            @if ($notification->read_at)
                                <span class="fw-bold text-success">Leída</span>
                            @else
                                <span class="fw-bold text-warning">No leída</span>
                            @endif
                        </td>
                        <td>
                            <span class="fw-normal">{{ optional($notification->created_at)->format('d/m/Y H:i') }}</span>
                        </td>
                        <td>
                            <div class="btn-group">
                                <button
                                    class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                                    data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <svg class="icon icon-xs" fill="currentColor"
                                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z">
                                        </path>
                                    </svg>
                                </button>
                                <div class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1">
                                    <button class="dropdown-item d-flex align-items-center view-notification-detail"
                                        type="button"
                                        data-notification-id="{{ $notification->notification_id }}"
                                        data-notification-title="{{ $notification->tittle ?? 'Sin título' }}"
                                        data-notification-message="{{ $notification->message }}"
                                        data-notification-process="{{ $notification->request->process->name ?? 'N/D' }}"
                                        data-notification-folio="{{ $notification->request_id ?? 'N/D' }}"
                                        data-notification-status="{{ $notification->read_at ? 'Leída' : 'No leída' }}"
                                        data-notification-created="{{ optional($notification->created_at)->format('d/m/Y H:i') }}">
                                        @icon('action.view', 'dropdown-icon text-gray-400 me-2')
                                        Ver detalles
                                    </button>
                                    @if (!$notification->read_at)
                                        <div role="separator" class="dropdown-divider my-1"></div>
                                        <button
                                            class="dropdown-item text-primary d-flex align-items-center"
                                            type="button"
                                            wire:click="markAsRead({{ $notification->notification_id }})"
                                            wire:loading.attr="disabled"
                                            wire:target="markAsRead">
                                            <span class="spinner-border spinner-border-sm me-2"
                                                role="status" aria-hidden="true" wire:loading
                                                wire:target="markAsRead"></span>
                                            @icon('state.success', 'dropdown-icon text-primary me-2')
                                            Marcar como leída
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">
                            <div class="text-gray-500">
                                <div class="mb-3">
                                    @icon('notif.bell', 'fa-2x')
                                </div>
                                <p class="fw-bold">No hay notificaciones para mostrar</p>
                                <p class="small">Aquí aparecerán los mensajes relacionados con tus trámites</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
            @if($notifications->hasPages())
                <nav aria-label="Page navigation" class="mb-3 mb-lg-0">
                    {{ $notifications->links() }}
                </nav>
            @endif
            <div class="fw-normal small mt-0 mt-lg-0 ms-lg-auto">
                Mostrando <b>{{ $notifications->firstItem() ?? 0 }}</b> a
                <b>{{ $notifications->lastItem() ?? 0 }}</b> de <b>{{ $notifications->total() }}</b> notificaciones
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-primary me-2',
                    cancelButton: 'btn btn-gray'
                },
                buttonsStyling: false
            });

            // Event listener to view notification details
            document.addEventListener('click', function (e) {
                if (e.target.closest('.view-notification-detail')) {
                    e.preventDefault();
                    const button = e.target.closest('.view-notification-detail');
                    const title = button.getAttribute('data-notification-title');
                    const message = button.getAttribute('data-notification-message');
                    const process = button.getAttribute('data-notification-process');
                    const folio = button.getAttribute('data-notification-folio');
                    const status = button.getAttribute('data-notification-status');
                    const created = button.getAttribute('data-notification-created');

                    const htmlContent = `
                        <div class="text-start">
                            <p class="mb-2"><span class="fw-bold">Título:</span> ${title}</p>
                            <p class="mb-2"><span class="fw-bold">Mensaje:</span> ${message}</p>
                            <p class="mb-2"><span class="fw-bold">Trámite:</span> ${process}</p>
                            <p class="mb-2"><span class="fw-bold">Folio:</span> ${folio}</p>
                            <p class="mb-2"><span class="fw-bold">Estado:</span> <span class="fw-bold ${status === 'Leída' ? 'text-success' : 'text-warning'}">${status}</span></p>
                            <p class="mb-0"><span class="fw-bold">Recibido:</span> ${created}</p>
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
</div>
