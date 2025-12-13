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
* Modified by: Claude Code |
* Description: Refactored notifications table to match users table design with actions menu
* - ID: 002 | Modified on: 12/12/2025 |
* Modified by: Claude Code |
* Description: Updated breadcrumb navigation and added status filter following system standards
--}}

<div wire:poll.10s="refreshList">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item">
                        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.dashboard.index') }}">
                            @icon('home', 'fa-xs')
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Notificaciones</li>
                </ol>
            </nav>
            <h2 class="h4">Mis notificaciones</h2>
            <p class="mb-0">Mensajes y avisos relacionados con tus tr&aacute;mites.</p>
        </div>
    </div>

    <div class="table-settings mb-4">
        <div class="d-flex flex-wrap gap-3 align-items-center">
            <div class="input-group fmxw-300">
                <span class="input-group-text">@icon('search', 'icon icon-xs')</span>
                <input wire:model.live.debounce.300ms="search" type="text" class="form-control"
                    placeholder="Buscar notificaciones">
            </div>
            <div class="d-flex align-items-center text-nowrap">
                <span class="small text-gray-600 me-2">Filtrar por estado:</span>
                <select wire:model.live="statusFilter" class="form-select" style="min-width: 200px;">
                    <option value="all">Todas</option>
                    <option value="unread">No le&iacute;das</option>
                    <option value="read">Le&iacute;das</option>
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

    <div class="card card-body shadow border-0 table-wrapper table-responsive overflow-visible">
        <table class="table table-centered table-nowrap mb-0 rounded user-table align-items-center" style="table-layout: fixed;">
            <colgroup>
                <col style="width: 26%">
                <col style="width: 34%">
                <col style="width: 14%">
                <col style="width: 14%">
                <col style="width: 12%; min-width: 72px;">
            </colgroup>
            <thead class="thead-light">
                <tr>
                    <th class="border-0 rounded-start text-start">T&iacute;tulo</th>
                    <th class="border-0 text-start">Mensaje</th>
                    <th class="border-0 text-start">Estado</th>
                    <th class="border-0 text-start">Recibido</th>
                    <th class="border-0 rounded-end text-start">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($notifications as $notification)
                    <tr wire:key="notification-{{ $notification->notification_id }}">
                        <td class="text-start">
                            <span class="fw-bold text-gray-900 text-truncate d-inline-block w-100">{{ $notification->title ?? 'Sin t&iacute;tulo' }}</span>
                        </td>
                        <td class="text-start">
                            <span class="fw-normal text-truncate d-inline-block w-100">{{ $notification->message }}</span>
                        </td>
                        <td class="text-start">
                            @if ($notification->read_at)
                                <span class="fw-bold text-success">Le&iacute;da</span>
                            @else
                                <span class="fw-bold text-warning">No le&iacute;da</span>
                            @endif
                        </td>
                        <td class="text-start">
                            <span class="fw-normal">{{ optional($notification->created_at)->format('d/m/Y H:i') }}</span>
                        </td>
                        <td class="text-start" style="width: 12%; min-width: 72px;">
                            <div class="btn-group">
                                <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                                    data-bs-toggle="dropdown" data-bs-boundary="viewport" aria-haspopup="true" aria-expanded="false">
                                    @icon('menu', 'icon icon-xs')
                                </button>
                                <div class="dropdown-menu dashboard-dropdown dropdown-menu-end mt-2 py-1">
                                    <button class="dropdown-item d-flex align-items-center view-notification-detail"
                                        type="button" data-notification-id="{{ $notification->notification_id }}"
                                        data-notification-title="{{ $notification->title ?? 'Sin t&iacute;tulo' }}"
                                        data-notification-message="{{ $notification->message }}"
                                        data-notification-process="{{ $notification->request->process->name ?? 'N/D' }}"
                                        data-notification-folio="{{ $notification->request_id ?? 'N/D' }}"
                                        data-notification-status="{{ $notification->read_at ? 'Le&iacute;da' : 'No le&iacute;da' }}"
                                        data-notification-created="{{ optional($notification->created_at)->format('d/m/Y H:i') }}">
                                        @icon('view', 'dropdown-icon text-gray-400 me-2')
                                        Ver detalles
                                    </button>
                                    @if (!$notification->read_at)
                                        <div role="separator" class="dropdown-divider my-1"></div>
                                        <button class="dropdown-item text-primary d-flex align-items-center" type="button"
                                            wire:click="markAsRead({{ $notification->notification_id }})"
                                            wire:loading.attr="disabled" wire:target="markAsRead">
                                            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"
                                                wire:loading wire:target="markAsRead"></span>
                                            @icon('success', 'dropdown-icon text-primary me-2')
                                            Marcar como le&iacute;da
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-5">
                            <div class="d-flex flex-column align-items-center justify-content-center text-gray-500">
                                @icon('notification', 'fa-2x mb-3')
                                <p class="fw-bold mb-1">No hay notificaciones para mostrar</p>
                                <p class="small mb-0">Aqu&iacute; aparecer&aacute;n los mensajes relacionados con tus tr&aacute;mites</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div
            class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
            @if($notifications->hasPages())
                <nav aria-label="Page navigation" class="mb-3 mb-lg-0">
                    {{ $notifications->onEachSide(1)->links('components.pagination-users') }}
                </nav>
            @endif
            <div class="fw-normal small mt-4 mt-lg-0 ms-lg-auto">
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
                            <p class="mb-2"><span class="fw-bold">T&iacute;tulo:</span> ${title}</p>
                            <p class="mb-2"><span class="fw-bold">Mensaje:</span> ${message}</p>
                            <p class="mb-2"><span class="fw-bold">Tr&aacute;mite:</span> ${process}</p>
                            <p class="mb-2"><span class="fw-bold">Folio:</span> ${folio}</p>
                            <p class="mb-2"><span class="fw-bold">Estado:</span> <span class="fw-bold ${status === 'Le&iacute;da' ? 'text-success' : 'text-warning'}">${status}</span></p>
                            <p class="mb-0"><span class="fw-bold">Recibido:</span> ${created}</p>
                        </div>
                    `;

                    swalWithBootstrapButtons.fire({
                        title: 'Detalles de la notificaci&oacute;n',
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
