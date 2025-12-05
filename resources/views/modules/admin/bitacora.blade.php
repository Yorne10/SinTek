{{--
* Company: CETAM
* Project: ST
* File: bitacora.blade.php
* Created on: 05/11/2025
* Created by: Alfonso Angel Garcia Hernandez
* Approved by: Alfonso Angel Garcia Hernandez
*
* Changelog:
* - ID: <ID> | Modified on: dd/mm/yyyy |
    * Modified by: <Developer name> |
        * Description: <Brief description of change> |
            *
            * - ID: <ID> | Modified on: dd/mm/yyyy |
                * Modified by: <Developer name> |
                    * Description: <Brief description of change> |
                        --}}

                        {{-- Nota Livewire: esta vista debe tener UN nico elemento raz --}}
                        {{-- El layout se aplica desde el componente con ->layout('layouts.app') --}}

                        <div wire:poll.10s="refreshList">
                            <div
                                class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
                                <div class="d-block mb-4 mb-md-0">
                                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                                        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                                            <li class="breadcrumb-item">
                                                <a
                                                    href="{{ route(config('proj.route_name_prefix', 'proj') . '.dashboard.index') }}">
                                                    @icon('nav.home', 'fa-xs')
                                                </a>
                                            </li>
                                            <li class="breadcrumb-item">Administración</li>
                                            <li class="breadcrumb-item active" aria-current="page">Bitácora de actividades
                                            </li>
                                        </ol>
                                    </nav>
                                    <h2 class="h4">Bitácora de actividades</h2>
                                    <p class="mb-0">Registro detallado de acciones de trabajadores y secretarios.</p>
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
                                            class="form-control" placeholder="Buscar en bitácora">
                                    </div>
                                    <div class="d-flex align-items-center text-nowrap">
                                        <span class="small text-gray-600 me-2">Filtrar por rol:</span>
                                        <select wire:model.live="roleFilter"
                                            class="form-select"
                                            style="min-width: 200px;"
                                            aria-label="Filtrar por rol">
                                            <option value="">Todos los roles</option>
                                            <option value="admin">Administrador</option>
                                            <option value="secretary">Secretario</option>
                                            <option value="worker">Trabajador</option>
                                        </select>
                                    </div>
                                    <div class="ms-auto">
                                        <button wire:click="clearFilters" class="btn btn-sm btn-gray-300 d-inline-flex align-items-center">
                                            @icon('action.refresh', 'me-2')
                                            Limpiar filtros
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="card card-body shadow border-0 table-wrapper table-responsive">
                                <table class="table table-centered table-nowrap mb-0 rounded user-table align-items-center">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="border-0 rounded-start">Usuario</th>
                                            <th class="border-0">Rol</th>
                                            <th class="border-0">Acción</th>
                                            <th class="border-0">Descripción</th>
                                            <th class="border-0">Fecha</th>
                                            <th class="border-0 rounded-end">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($logs as $log)
                                            <tr>
                                                <td>
                                                    <span class="fw-bold text-gray-900">{{ $log->user->name ?? 'Sistema' }}</span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="fw-normal text-dark">{{ $this->getRoleLabel($log->user->role ?? 'system') }}</span>
                                                </td>
                                                <td>
                                                    <span class="fw-normal">{{ \App\Services\ActivityLogger::getActionLabel($log->action ?? '') }}</span>
                                                </td>
                                                <td>
                                                    <span class="fw-normal text-truncate d-inline-block"
                                                        style="max-width: 300px;"
                                                        title="{{ $log->description ?? '—' }}">{{ $log->description ?? '—' }}</span>
                                                </td>
                                                <td><span class="fw-normal">{{ optional($log->date ?? $log->created_at)->format('d/m/Y H:i') }}</span>
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
                                                        <div
                                                            class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1">
                                                            <button class="dropdown-item d-flex align-items-center view-log-detail"
                                                                type="button"
                                                                data-log-user="{{ $log->user->name ?? 'Sistema' }}"
                                                                data-log-role="{{ $this->getRoleLabel($log->user->role ?? 'system') }}"
                                                                data-log-action="{{ \App\Services\ActivityLogger::getActionLabel($log->action ?? '') }}"
                                                                data-log-description="{{ $log->description ?? '—' }}"
                                                                data-log-date="{{ optional($log->date ?? $log->created_at)->format('d/m/Y H:i') }}">
                                                                @icon('action.view', 'dropdown-icon text-gray-400 me-2')
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
                                                        <svg class="icon icon-lg mb-3" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                            </path>
                                                        </svg>
                                                        <p class="fw-bold">No se encontraron registros</p>
                                                        <p class="small">Intenta ajustar los filtros de búsqueda</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            <div class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
                                @if($logs->hasPages())
                                    <nav aria-label="Page navigation" class="mb-3 mb-lg-0">
                                        {{ $logs->links('components.pagination-users') }}
                                    </nav>
                                @endif
                                <div class="fw-normal small mt-0 mt-lg-0 ms-lg-auto">
                                    Mostrando <b>{{ $logs->firstItem() ?? 0 }}</b> a
                                    <b>{{ $logs->lastItem() ?? 0 }}</b> de <b>{{ $logs->total() }}</b> registros
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

                                    // Event listener para ver detalles
                                    document.addEventListener('click', function (e) {
                                        if (e.target.closest('.view-log-detail')) {
                                            e.preventDefault();
                                            const button = e.target.closest('.view-log-detail');
                                            const userName = button.getAttribute('data-log-user');
                                            const userRole = button.getAttribute('data-log-role');
                                            const action = button.getAttribute('data-log-action');
                                            const description = button.getAttribute('data-log-description');
                                            const date = button.getAttribute('data-log-date');

                                            swalWithBootstrapButtons.fire({
                                                title: 'Detalle del registro',
                                                html: `
                                                    <div class="text-start">
                                                        <p class="mb-2"><span class="fw-bold">Usuario:</span> ${userName}</p>
                                                        <p class="mb-2"><span class="fw-bold">Rol:</span> ${userRole}</p>
                                                        <p class="mb-2"><span class="fw-bold">Acción:</span> ${action}</p>
                                                        <p class="mb-2"><span class="fw-bold">Descripción:</span><br>${description}</p>
                                                        <p class="mb-0"><span class="fw-bold">Fecha:</span> ${date}</p>
                                                    </div>
                                                `,
                                                icon: 'info',
                                                confirmButtonText: 'Cerrar',
                                                showConfirmButton: true
                                            });
                                        }
                                    });
                                });
                            </script>
                        </div>
