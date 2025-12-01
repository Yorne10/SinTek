{{--
* Company: CETAM
* Project: ST
* File: busqueda-trabajadores.blade.php
* Created on: 04/11/2025
* Created by: Alfonso Angel Garca Hernndez
* Approved by: Alfonso Angel Garca Hernndez
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
                    <li class="breadcrumb-item">Secretara</li>
                    <li class="breadcrumb-item active" aria-current="page">Bsqueda de trabajadores</li>
                </ol>
            </nav>
            <h2 class="h4">Bsqueda de trabajadores</h2>
            <p class="mb-0">Busca trabajadores por diferentes criterios y consulta su informacin.</p>
        </div>
    </div>

    <div class="table-settings mb-4">
        <div class="row justify-content-between align-items-center">
            <div class="col-12 col-lg-9 d-flex flex-wrap gap-2">
                <div class="input-group me-2 fmxw-300">
                    <span class="input-group-text">
                        <svg class="icon icon-xs" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </span>
                    <input wire:model.live.debounce.400ms="search" type="text" class="form-control"
                        placeholder="Buscar por nombre o email">
                </div>
                <input wire:model.live.debounce.400ms="searchCurp" type="text" class="form-control fmxw-200"
                    placeholder="CURP" maxlength="18">
                <input wire:model.live.debounce.400ms="searchRfc" type="text" class="form-control fmxw-150"
                    placeholder="RFC" maxlength="13">
                <select wire:model.live="statusFilter" class="form-select fmxw-120" aria-label="Filtrar por estado">
                    <option value="">Todos</option>
                    <option value="active">Activos</option>
                    <option value="inactive">Inactivos</option>
                </select>
                <button wire:click="clearFilters" type="button" class="btn btn-outline-gray-600">
                    <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z"
                            clip-rule="evenodd"></path>
                    </svg>
                    Limpiar
                </button>
            </div>
        </div>
    </div>

    <div class="card card-body shadow border-0 table-wrapper table-responsive">
        <table class="table user-table table-hover align-items-center">
            <thead>
                <tr>
                    <th class="border-bottom">Trabajador</th>
                    <th class="border-bottom">CURP</th>
                    <th class="border-bottom">RFC</th>
                    <th class="border-bottom">Telfono</th>
                    <th class="border-bottom">Claves presupuestales</th>
                    <th class="border-bottom">Estado</th>
                    <th class="border-bottom">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($workers as $worker)
                    <tr>
                        <td>
                            <a href="#" class="d-flex align-items-center">
                                <div class="avatar rounded-circle me-3 d-flex align-items-center justify-content-center bg-primary text-white fw-bold"
                                    style="width: 48px; height: 48px; font-size: 1.2rem;">
                                    {{ strtoupper(substr($worker->user->name, 0, 1)) }}{{ strtoupper(substr(explode(' ', $worker->user->name)[1] ?? '', 0, 1)) }}
                                </div>
                                <div class="d-block">
                                    <span class="fw-bold">{{ $worker->user->name }}</span>
                                    <div class="small text-gray">{{ $worker->user->email }}</div>
                                </div>
                            </a>
                        </td>
                        <td>
                            @if($worker->curp)
                                <span class="font-monospace small">{{ $worker->curp }}</span>
                            @else
                                <span class="text-gray-500 small">No especificado</span>
                            @endif
                        </td>
                        <td>
                            @if($worker->rfc)
                                <span class="font-monospace small">{{ $worker->rfc }}</span>
                            @else
                                <span class="text-gray-500 small">No especificado</span>
                            @endif
                        </td>
                        <td>
                            @if($worker->phone)
                                <span class="fw-normal">{{ $worker->phone }}</span>
                            @else
                                <span class="text-gray-500 small">No especificado</span>
                            @endif
                        </td>
                        <td>
                            @if($worker->positions && $worker->positions->count() > 0)
                                @php
                                    $totalPositions = $worker->positions->count();
                                    $firstTwo = $worker->positions->take(2);
                                @endphp
                                <div class="d-flex flex-column gap-1">
                                    @foreach($firstTwo as $position)
                                        <span class="badge bg-info-soft text-info">{{ $position->budget_key }}</span>
                                    @endforeach
                                    @if($totalPositions > 2)
                                        <span class="small text-gray-600">+{{ $totalPositions - 2 }} ms</span>
                                    @endif
                                </div>
                            @else
                                <span class="text-gray-500 small">Sin asignar</span>
                            @endif
                        </td>
                        <td>
                            @if($worker->user->is_active)
                                <span class="fw-bold text-success">Activo</span>
                            @else
                                <span class="fw-bold text-warning">Inactivo</span>
                            @endif
                        </td>
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
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <svg class="dropdown-icon text-gray-400 me-2" fill="currentColor"
                                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                            <path fill-rule="evenodd"
                                                d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        Ver perfil completo
                                    </a>
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <svg class="dropdown-icon text-gray-400 me-2" fill="currentColor"
                                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                                            <path fill-rule="evenodd"
                                                d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        Ver historial de trámites
                                    </a>
                                    <div role="separator" class="dropdown-divider my-1"></div>
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <svg class="dropdown-icon text-gray-400 me-2" fill="currentColor"
                                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                            </path>
                                        </svg>
                                        Editar informacin
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <div class="text-gray-500">
                                <svg class="icon icon-lg mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                    </path>
                                </svg>
                                <p class="fw-bold">No se encontraron trabajadores</p>
                                <p class="small">Intenta ajustar los filtros de bsqueda</p>
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