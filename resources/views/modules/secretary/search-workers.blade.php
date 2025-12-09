{{--
* Company: CETAM
* Project: ST
* File: secretary.search-workers.blade.php
* Created on: 04/11/2025
* Created by: Alfonso Angel Garcia Hernandez
* Approved by: Alfonso Angel Garcia Hernandez
--}}

<div>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-3">
        <div class="d-block mb-4 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item">
                        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.dashboard.index') }}">
                            @icon('nav.home', 'fa-xs')
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

    <div class="table-settings mb-4">
        <div class="d-flex flex-wrap gap-3 align-items-center">
            <div class="input-group fmxw-300">
                <span class="input-group-text">@icon('action.search', 'icon icon-xs')</span>
                <input wire:model.live.debounce.400ms="search" type="text" class="form-control"
                    placeholder="Buscar trabajadores">
            </div>
            <div class="d-flex align-items-center text-nowrap">
                <input wire:model.live.debounce.400ms="searchCurp" type="text" class="form-control"
                    style="min-width: 180px;" placeholder="CURP" maxlength="18">
            </div>
            <div class="d-flex align-items-center text-nowrap">
                <input wire:model.live.debounce.400ms="searchRfc" type="text" class="form-control"
                    style="min-width: 140px;" placeholder="RFC" maxlength="13">
            </div>
            <div class="d-flex align-items-center text-nowrap">
                <span class="small text-gray-600 me-2">Filtrar por estado:</span>
                <select wire:model.live="statusFilter" class="form-select" style="min-width: 150px;"
                    aria-label="Filter by status">
                    <option value="">Todos</option>
                    <option value="active">Activo</option>
                    <option value="inactive">Inactivo</option>
                </select>
            </div>
        </div>
    </div>

    <div class="card card-body shadow border-0 table-wrapper table-responsive">
        <table class="table table-nowrap mb-0 rounded">
            <thead class="thead-light">
                <tr>
                    <th class="border-0 rounded-start text-start">Nombre</th>
                    <th class="border-0 text-start">CURP</th>
                    <th class="border-0 text-start">RFC</th>
                    <th class="border-0 text-start">Correo</th>
                    <th class="border-0 text-start">Estado</th>
                    <th class="border-0 rounded-end text-start">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($workers as $worker)
                    <tr>
                        <td class="text-start">
                            <span class="fw-bold text-gray-900">{{ $worker->user->name }}</span>
                        </td>
                        <td class="text-start">
                            @if($worker->curp)
                                <span class="font-monospace small">{{ $worker->curp }}</span>
                            @else
                                <span class="text-gray-500 small">No especificado</span>
                            @endif
                        </td>
                        <td class="text-start">
                            @if($worker->rfc)
                                <span class="font-monospace small">{{ $worker->rfc }}</span>
                            @else
                                <span class="text-gray-500 small">No especificado</span>
                            @endif
                        </td>
                        <td class="text-start">
                            <span class="small">{{ $worker->user->email }}</span>
                        </td>
                        <td class="text-start">
                            @if($worker->user->is_active)
                                <span class="fw-bold text-success">Activo</span>
                            @else
                                <span class="fw-bold text-warning">Inactivo</span>
                            @endif
                        </td>
                        <td class="text-start">
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
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        @icon('action.view', 'dropdown-icon text-gray-400 me-2')
                                        Ver perfil completo
                                    </a>
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        @icon('process.docs', 'dropdown-icon text-gray-400 me-2')
                                        Ver historial de trámites
                                    </a>
                                    <div role="separator" class="dropdown-divider my-1"></div>
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        @icon('action.edit', 'dropdown-icon text-gray-400 me-2')
                                        Editar información
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <div class="text-gray-500">
                                <i class="fa-solid fa-user-group fa-2x mb-3"></i>
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
            @if($workers->hasPages())
                <nav aria-label="Page navigation">
                    {{ $workers->links() }}
                </nav>
            @endif
            <div class="fw-normal small mt-4 mt-lg-0">
                Mostrando <b>{{ $workers->firstItem() ?? 0 }}</b> a <b>{{ $workers->lastItem() ?? 0 }}</b> de
                <b>{{ $workers->total() }}</b> trabajadores
            </div>
        </div>
    </div>
</div>
