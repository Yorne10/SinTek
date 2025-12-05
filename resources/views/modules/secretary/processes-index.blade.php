{{--
Company: CETAM
Project: ST
File: processes-index.blade.php
Created on: 04/12/2025
Created by: Alfonso Angel Garcia Hernandez
Approved by: Alfonso Angel Garcia Hernandez
--}}

<div>
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
                    <li class="breadcrumb-item active" aria-current="page">Gestionar Procesos</li>
                </ol>
            </nav>
            <h2 class="h4">Gestionar Procesos</h2>
            <p class="mb-0">Administra los procesos del sistema, sus pasos y configuración.</p>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.admin.crear-proceso') }}"
                class="btn btn-sm btn-gray-800 d-inline-flex align-items-center">
                @icon('action.create', 'me-2')
                Nuevo proceso
            </a>
        </div>
    </div>

    <div class="table-settings mb-4">
        <div class="d-flex flex-wrap gap-3 align-items-center">
            <div class="input-group fmxw-300">
                <span class="input-group-text">
                    <svg class="icon icon-xs" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                            clip-rule="evenodd"></path>
                    </svg>
                </span>
                <input wire:model.live.debounce.400ms="search" type="text" class="form-control"
                    placeholder="Buscar procesos">
            </div>
            <div class="d-flex align-items-center text-nowrap">
                <span class="small text-gray-600 me-2">Filtrar por estado:</span>
                <select wire:model.live="statusFilter" class="form-select" style="min-width: 140px;"
                    aria-label="Filtrar por estado">
                    <option value="">Todos</option>
                    <option value="active">Activo</option>
                    <option value="inactive">Inactivo</option>
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
                    <th class="border-0 rounded-start">Nombre</th>
                    <th class="border-0">Descripción</th>
                    <th class="border-0">Estado</th>
                    <th class="border-0">Fecha de creación</th>
                    <th class="border-0 rounded-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($processes as $process)
                    <tr>
                        <td>
                            <span class="fw-bold text-gray-900">{{ $process->name }}</span>
                        </td>
                        <td>
                            <span class="fw-normal">{{ Str::limit($process->description, 50) }}</span>
                        </td>
                        <td>
                            @if ($process->active)
                                <span class="fw-bold text-success">Activo</span>
                            @else
                                <span class="fw-bold text-warning">Inactivo</span>
                            @endif
                        </td>
                        <td><span class="fw-normal">{{ $process->created_at->format('d/m/Y') }}</span></td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z">
                                        </path>
                                    </svg>
                                </button>
                                <div class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1">
                                    <button class="dropdown-item d-flex align-items-center view-process-detail"
                                        type="button" data-process-id="{{ $process->process_id }}"
                                        data-process-name="{{ $process->name }}"
                                        data-process-description="{{ $process->description }}"
                                        data-process-active="{{ $process->active ? '1' : '0' }}"
                                        data-process-created="{{ $process->created_at->format('d/m/Y H:i') }}">
                                        @icon('action.view', 'dropdown-icon text-gray-400 me-2')
                                        Ver detalles
                                    </button>
                                    <a class="dropdown-item d-flex align-items-center"
                                        href="{{ route(config('proj.route_name_prefix', 'proj') . '.admin.modificar-proceso', ['process_id' => $process->process_id]) }}">
                                        @icon('action.edit', 'dropdown-icon text-gray-400 me-2')
                                        Editar proceso
                                    </a>
                                    <a class="dropdown-item d-flex align-items-center"
                                        href="{{ route(config('proj.route_name_prefix', 'proj') . '.admin.definir-pasos', ['process_id' => $process->process_id]) }}">
                                        @icon('process.step', 'dropdown-icon text-gray-400 me-2')
                                        Definir pasos
                                    </a>
                                    <div role="separator" class="dropdown-divider my-1"></div>
                                    <button
                                        class="dropdown-item {{ $process->active ? 'text-warning' : 'text-success' }} d-flex align-items-center toggle-process-status"
                                        type="button" data-process-id="{{ $process->process_id }}"
                                        data-process-name="{{ $process->name }}"
                                        data-process-active="{{ $process->active ? '1' : '0' }}"
                                        wire:loading.attr="disabled" wire:target="toggleProcessStatus">
                                        <span class="spinner-border spinner-border-sm me-2" role="status"
                                            aria-hidden="true" wire:loading wire:target="toggleProcessStatus"></span>
                                        @icon($process->active ? 'state.warning' : 'state.success', "dropdown-icon {{ $process->active ? 'text-warning' : 'text-success' }} me-2")
                                        {{ $process->active ? 'Desactivar' : 'Activar' }}
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">
                            <div class="text-gray-500">
                                <div class="mb-3">
                                    @icon('process.flow', 'fa-3x')
                                </div>
                                <p class="fw-bold">No se encontraron procesos</p>
                                <p class="small">Intenta ajustar los filtros de búsqueda</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div
            class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
            @if ($processes->hasPages())
                <nav aria-label="Page navigation" class="mb-3 mb-lg-0">
                    {{ $processes->onEachSide(1)->links('components.pagination-users') }}
                </nav>
            @endif
            <div class="fw-normal small mt-0 mt-lg-0 ms-lg-auto">
                Mostrando <b>{{ $processes->firstItem() ?? 0 }}</b> a
                <b>{{ $processes->lastItem() ?? 0 }}</b> de <b>{{ $processes->total() }}</b> procesos
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

            // Event listener para ver detalles
            document.addEventListener('click', function(e) {
                if (e.target.closest('.view-process-detail')) {
                    e.preventDefault();
                    const button = e.target.closest('.view-process-detail');
                    const processName = button.getAttribute('data-process-name');
                    const processDescription = button.getAttribute('data-process-description');
                    const processActive = button.getAttribute('data-process-active') === '1';
                    const processCreated = button.getAttribute('data-process-created');

                    let htmlContent = `
                        <div class="text-start">
                            <p class="mb-2"><span class="fw-bold">Nombre:</span> ${processName}</p>
                            <p class="mb-2"><span class="fw-bold">Descripción:</span> ${processDescription}</p>
                            <p class="mb-2"><span class="fw-bold">Estado:</span> <span class="fw-bold text-${processActive ? 'success' : 'warning'}">${processActive ? 'Activo' : 'Inactivo'}</span></p>
                            <p class="mb-2"><span class="fw-bold">Fecha de creación:</span> ${processCreated}</p>
                        </div>
                    `;

                    swalWithBootstrapButtons.fire({
                        title: 'Detalles del proceso',
                        html: htmlContent,
                        icon: 'info',
                        confirmButtonText: 'Cerrar',
                        showConfirmButton: true,
                        width: '600px'
                    });
                }
            });

            // Event listener para botones de activar/desactivar
            document.addEventListener('click', function(e) {
                if (e.target.closest('.toggle-process-status')) {
                    e.preventDefault();
                    const button = e.target.closest('.toggle-process-status');
                    const processId = button.getAttribute('data-process-id');
                    const processName = button.getAttribute('data-process-name');
                    const isActive = button.getAttribute('data-process-active') === '1';

                    const actionTitle = isActive ? 'Desactivar proceso' : 'Activar proceso';
                    const actionText = isActive ?
                        `¿Estás seguro de desactivar el proceso ${processName}? El proceso no estará disponible para nuevas solicitudes.` :
                        `¿Estás seguro de activar el proceso ${processName}? El proceso estará disponible para nuevas solicitudes.`;
                    const confirmText = isActive ? 'Sí, desactivar' : 'Sí, activar';

                    swalWithBootstrapButtons.fire({
                        title: actionTitle,
                        text: actionText,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: confirmText,
                        cancelButtonText: 'Cancelar',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            @this.call('toggleProcessStatus', processId);
                        }
                    });
                }
            });

            // Escuchar evento de notificación de procesos
            if (window.Livewire) {
                Livewire.on('processes-notify', (event) => {
                    const detail = event || {};
                    const iconType = detail.type || 'success';
                    const confirmText = iconType === 'warning' ? 'Entendido' : 'Aceptar';
                    swalWithBootstrapButtons.fire({
                        icon: iconType,
                        title: detail.title || 'Aviso',
                        text: detail.message || '',
                        confirmButtonText: confirmText,
                        showConfirmButton: true
                    });
                });
            }
        });
    </script>
</div>
