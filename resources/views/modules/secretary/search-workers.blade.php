{{--
Company: CETAM
Project: ST
File: search-workers.blade.php
Created on: 04/11/2025
Created by: Alfonso Angel Garcia Hernandez
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
                    <li class="breadcrumb-item active" aria-current="page">Buscar trabajadores</li>
                </ol>
            </nav>
            <h2 class="h4">Buscar trabajadores</h2>
            <p class="mb-0">Busca trabajadores por diferentes criterios y consulta su información.</p>
        </div>
    </div>

    {{-- Filters --}}
    <div class="table-settings mb-4">
        <div class="d-flex flex-wrap gap-3 align-items-center">
            <div class="input-group" style="min-width: 270px; max-width: 300px;">
                <span class="input-group-text">@icon('search', 'icon icon-xs')</span>
                <input wire:model.live.debounce.400ms="search" type="text" class="form-control"
                    placeholder="Buscar trabajadores">
            </div>
            <div class="input-group" style="min-width: 190px; max-width: 210px;">
                <span class="input-group-text">@icon('search', 'icon icon-xs')</span>
                <input wire:model.live.debounce.400ms="searchCurp" type="text" class="form-control"
                    placeholder="Buscar por CURP" maxlength="18">
            </div>
            <div class="input-group" style="min-width: 190px; max-width: 210px;">
                <span class="input-group-text">@icon('search', 'icon icon-xs')</span>
                <input wire:model.live.debounce.400ms="searchRfc" type="text" class="form-control"
                    placeholder="Buscar por RFC" maxlength="13">
            </div>
            <div class="d-flex align-items-center text-nowrap">
                <span class="small text-gray-600 me-2">Filtrar por estado:</span>
                <select wire:model.live="statusFilter" class="form-select" style="min-width: 130px; max-width: 150px;"
                    aria-label="Filter by status">
                    <option value="">Todos</option>
                    <option value="active">Activo</option>
                    <option value="inactive">Inactivo</option>
                </select>
            </div>
            <div class="ms-auto">
                <button wire:click="clearFilters"
                    class="btn btn-sm btn-secondary text-white d-inline-flex align-items-center px-3">
                    @icon('refresh', 'me-2 text-white')
                    Limpiar filtros
                </button>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="card card-body shadow border-0 table-wrapper table-responsive">
        <table class="table mb-0 rounded w-100" style="table-layout: fixed;">
            <colgroup>
                <col style="width: 26%">
                <col style="width: 24%">
                <col style="width: 16%">
                <col style="width: 14%">
                <col style="width: 10%">
                <col style="width: 10%">
            </colgroup>
            <thead class="thead-light">
                <tr>
                    <th class="border-0 rounded-start text-start">Nombre</th>
                    <th class="border-0 text-start">Correo</th>
                    <th class="border-0 text-start">CURP</th>
                    <th class="border-0 text-start">RFC</th>
                    <th class="border-0 text-start">Estado</th>
                    <th class="border-0 rounded-end text-start">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($workers as $worker)
                    <tr>
                        <td class="text-start">
                            <span
                                class="fw-bold text-gray-900 text-truncate d-inline-block w-100">{{ $worker->user->name }}</span>
                        </td>
                        <td class="text-start">
                            <span class="small text-truncate d-inline-block w-100">{{ $worker->user->email }}</span>
                        </td>
                        <td class="text-start">
                            @if ($worker->curp)
                                <span
                                    class="font-monospace small text-truncate d-inline-block w-100">{{ $worker->curp }}</span>
                            @else
                                <span class="text-gray-500 small text-truncate d-inline-block w-100">No
                                    especificado</span>
                            @endif
                        </td>
                        <td class="text-start">
                            @if ($worker->rfc)
                                <span
                                    class="font-monospace small text-truncate d-inline-block w-100">{{ $worker->rfc }}</span>
                            @else
                                <span class="text-gray-500 small text-truncate d-inline-block w-100">No
                                    especificado</span>
                            @endif
                        </td>
                        <td class="text-start">
                            @if ($worker->user->is_active)
                                <span class="fw-bold text-success">Activo</span>
                            @else
                                <span class="fw-bold text-warning">Inactivo</span>
                            @endif
                        </td>
                        <td class="text-start" style="width: 12%; min-width: 72px;">
                            <div class="btn-group position-static">
                                <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    @icon('menu', 'icon icon-xs')
                                </button>
                                <div class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1">
                                    <button class="dropdown-item d-flex align-items-center view-worker-detail"
                                        type="button" data-worker-name="{{ $worker->user->name }}"
                                        data-worker-email="{{ $worker->user->email }}"
                                        data-worker-active="{{ $worker->user->is_active ? '1' : '0' }}"
                                        data-worker-curp="{{ $worker->curp ?? 'N/A' }}"
                                        data-worker-rfc="{{ $worker->rfc ?? 'N/A' }}"
                                        data-worker-phone="{{ $worker->phone ?? 'N/A' }}"
                                        data-worker-budget-keys="{{ $worker->positions->pluck('budget_key')->filter()->implode(', ') ?? 'S/D' }}"
                                        data-worker-address="{{ $worker->address ?? 'N/A' }}">
                                        @icon('view', 'dropdown-icon text-gray-400 me-2')
                                        Ver detalles
                                    </button>
                                    <a class="dropdown-item d-flex align-items-center"
                                        href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.worker-procedures', $worker->workers_id) }}">
                                        @icon('documentSign', 'dropdown-icon text-gray-400 me-2')
                                        Ver historial de trámites
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <div class="text-gray-500">
                                @icon('userGroup', 'fa-2x mb-3 text-gray-400')
                                <p class="fw-bold">No hay trabajadores para mostrar</p>
                                <p class="small">Intenta ajustar los filtros de búsqueda</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div
            class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
            @if ($workers->hasPages())
                <nav aria-label="Page navigation" class="mb-3 mb-lg-0">
                    {{ $workers->links() }}
                </nav>
            @endif
            <div class="fw-normal small mt-4 mt-lg-0 ms-lg-auto">
                Mostrando <b>{{ $workers->firstItem() ?? 0 }}</b> a <b>{{ $workers->lastItem() ?? 0 }}</b>
                de
                <b>{{ $workers->total() }}</b> trabajadores
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
                if (e.target.closest('.view-worker-detail')) {
                    e.preventDefault();
                    const button = e.target.closest('.view-worker-detail');

                    const name = button.getAttribute('data-worker-name');
                    const email = button.getAttribute('data-worker-email');
                    const isActive = button.getAttribute('data-worker-active') === '1';
                    const curp = button.getAttribute('data-worker-curp');
                    const rfc = button.getAttribute('data-worker-rfc');
                    const phone = button.getAttribute('data-worker-phone');
                    const budgetKeys = button.getAttribute('data-worker-budget-keys') || 'S/D';
                    const address = button.getAttribute('data-worker-address');

                    const htmlContent = `
                        <div class="text-start">
                            <p class="mb-2"><span class="fw-bold">Nombre:</span> ${name}</p>
                            <p class="mb-2"><span class="fw-bold">Correo:</span> ${email}</p>
                            <p class="mb-2"><span class="fw-bold">Estado:</span> <span class="fw-bold text-${isActive ? 'success' : 'warning'}">${isActive ? 'Activo' : 'Inactivo'}</span></p>
                            
                            <hr class="my-3">
                            <h6 class="fw-bold mb-2">Información del trabajador</h6>
                            <p class="mb-2"><span class="fw-bold">CURP:</span> ${curp}</p>
                            <p class="mb-2"><span class="fw-bold">RFC:</span> ${rfc}</p>
                            <p class="mb-2"><span class="fw-bold">Teléfono:</span> ${phone}</p>
                            <p class="mb-2"><span class="fw-bold">Claves presupuestales:</span> ${budgetKeys}</p>
                            <p class="mb-0"><span class="fw-bold">Dirección:</span> ${address}</p>
                        </div>
                    `;

                    swalWithBootstrapButtons.fire({
                        title: 'Detalles del trabajador',
                        html: htmlContent,
                        icon: 'info',
                        confirmButtonText: 'Aceptar',
                        showConfirmButton: true,
                        width: '600px'
                    });
                }
            });
        });
    </script>
</div>
