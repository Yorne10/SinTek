{{--
* Company: CETAM
* Project: ST
* File: worker-procedures-history.blade.php
* Created on: 10/12/2025
* Created by: Alfonso Angel García Hernández
* Approved by: Alfonso Angel García Hernández
--}}

<div>
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
                    <li class="breadcrumb-item">
                        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.search-workers') }}">
                            Buscar trabajadores
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Historial de trámites</li>
                </ol>
            </nav>
            <h2 class="h4">Historial de Trámites</h2>
            <p class="mb-0">
                Visualizando trámites del trabajador: <strong>{{ $worker->user->name }}</strong>
            </p>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.search-workers') }}"
                class="btn btn-sm btn-gray-800 d-inline-flex align-items-center">
                @icon('backward', 'me-1')
                Regresar
            </a>
        </div>
    </div>

    <div class="table-settings mb-4">
        <div class="d-flex flex-wrap gap-3 align-items-center">
            <div class="input-group fmxw-300">
                <span class="input-group-text">@icon('search', 'icon icon-xs')</span>
                <input wire:model.live.debounce.300ms="search" type="text" class="form-control"
                    placeholder="Buscar por nombre del proceso">
            </div>
            <div class="d-flex align-items-center text-nowrap">
                <span class="small text-gray-600 me-2">Filtrar por estado:</span>
                <select wire:model.live="statusFilter" class="form-select" style="min-width: 200px;"
                    aria-label="Filtrar por estado">
                    <option value="">Todos</option>
                    <option value="pendiente">Pendiente</option>
                    <option value="en_proceso">En proceso</option>
                    <option value="completado">Completado</option>
                    <option value="rechazado">Rechazado</option>
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

    <div class="card card-body border-0 shadow table-wrapper table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th class="border-0 rounded-start">ID</th>
                    <th class="border-0">Proceso</th>
                    <th class="border-0">Fecha Inicio</th>
                    <th class="border-0">Fecha Fin</th>
                    <th class="border-0">Estado</th>
                    <th class="border-0 rounded-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($requests as $requestItem)
                    <tr>
                        <td>{{ $requestItem->request_id }}</td>
                        <td>
                            <span class="fw-bold">{{ $requestItem->process->name ?? 'N/A' }}</span>
                        </td>
                        <td>
                            {{ $requestItem->start_date ? $requestItem->start_date->format('d/m/Y') : '-' }}
                        </td>
                        <td>
                            {{ $requestItem->end_date ? $requestItem->end_date->format('d/m/Y') : '-' }}
                        </td>
                        <td>
                            @if($requestItem->status == 'completado')
                                <span class="badge bg-success">Completado</span>
                            @elseif($requestItem->status == 'en_proceso')
                                <span class="badge bg-warning text-dark">En proceso</span>
                            @elseif($requestItem->status == 'pendiente')
                                <span class="badge bg-secondary">Pendiente</span>
                            @elseif($requestItem->status == 'rechazado')
                                <span class="badge bg-danger">Rechazado</span>
                            @else
                                <span class="badge bg-info">{{ ucfirst($requestItem->status) }}</span>
                            @endif
                        </td>
                        <td>
                            {{-- Placeholder for future actions like viewing details of specific request --}}
                            <span class="text-muted small">Ver detalles (Próximamente)</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <div class="text-gray-500">
                                @icon('documentSign', 'fa-2x mb-3')
                                <p class="fw-bold">No se encontraron trámites</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div
            class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
            @if($requests->hasPages())
                <nav aria-label="Page navigation" class="mb-3 mb-lg-0">
                    {{ $requests->links() }}
                </nav>
            @endif
            <div class="fw-normal small mt-4 mt-lg-0 ms-lg-auto">
                Mostrando <b>{{ $requests->firstItem() ?? 0 }}</b> a <b>{{ $requests->lastItem() ?? 0 }}</b> de
                <b>{{ $requests->total() }}</b> trámites
            </div>
        </div>
    </div>
</div>