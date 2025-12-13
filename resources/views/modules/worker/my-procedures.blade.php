{{--
    Company: CETAM
    Project: ST
    File: mis-tramites.blade.php
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
    <div class="py-4">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item">
                    <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.dashboard.index') }}">
                        @icon('home', 'fa-xs')
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Mis trámites</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Mis trámites</h1>
                <p class="mb-0">Consulta el estado de todas tus solicitudes y trámites</p>
            </div>
            <div>
                <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.worker.available-procedures') }}"
                    class="btn btn-sm btn-primary d-inline-flex align-items-center">
                    @icon('add', 'icon-xs me-1')
                    Nuevo trámite
                </a>
            </div>
        </div>
    </div>

    {{-- Filtros y búsqueda --}}
    <div class="table-settings mb-4">
        <div class="d-flex flex-wrap gap-3 align-items-center">
            <div class="input-group fmxw-300">
                <span class="input-group-text">
                    <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                            clip-rule="evenodd"></path>
                    </svg>
                </span>
                <input wire:model.live.debounce.300ms="search" type="text" class="form-control"
                    placeholder="Buscar por ID o tipo de trámite...">
            </div>
            <div class="d-flex align-items-center text-nowrap">
                <span class="small text-gray-600 me-2">Filtrar por estado:</span>
                <select wire:model.live="statusFilter" class="form-select" style="min-width: 200px;">
                    <option value="">Todos</option>
                    <option value="in_progress">En proceso</option>
                    <option value="completed">Completado</option>
                    <option value="cancelled">Cancelado</option>
                </select>
            </div>
            <div class="ms-auto">
                <button wire:click="$set('search', ''); $set('statusFilter', '')" type="button"
                    class="btn btn-sm btn-secondary text-white d-inline-flex align-items-center">
                    @icon('refresh', 'me-2 text-white')
                    Limpiar filtros
                </button>
            </div>
        </div>
    </div>

    {{-- Trámites list --}}
    <div class="row">
        <div class="col-12">
            <div class="card card-body shadow border-0 table-wrapper table-responsive">

                <table class="table table-centered table-nowrap mb-0 rounded user-table align-items-center"
                    style="table-layout: fixed;">
                    <colgroup>
                        <col style="width: 32%">
                        <col style="width: 20%">
                        <col style="width: 16%">
                        <col style="width: 20%">
                        <col style="width: 12%; min-width: 72px;">
                    </colgroup>
                    <thead class="thead-light">
                        <tr>
                            <th class="border-0 rounded-start">Tipo de trámite</th>
                            <th class="border-0">Fecha inicio</th>
                            <th class="border-0">Estado</th>
                            <th class="border-0">Progreso</th>
                            <th class="border-0 rounded-end text-start">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requests as $req)
                            <tr>
                                <td>{{ $req->process->name }}</td>
                                <td>{{ $req->start_date ? $req->start_date->format('d/m/Y') : 'N/A' }}</td>
                                @php
                                    $status = strtolower($req->status);
                                    $isCompleted = in_array($status, ['completed', 'completado']);
                                    $isInProgress = in_array($status, ['in_progress', 'en_proceso']);
                                    $isCancelled = in_array($status, ['cancelled', 'cancelado']);
                                @endphp
                                <td>
                                    @if ($isInProgress)
                                        <span class="fw-bold text-warning">En proceso</span>
                                    @elseif($isCompleted)
                                        <span class="fw-bold text-success">Completado</span>
                                    @elseif($isCancelled)
                                        <span class="fw-bold text-danger">Cancelado</span>
                                    @else
                                        <span class="fw-bold text-secondary">{{ ucfirst($status) }}</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $completedSteps = $this->getCompletedSteps($req);
                                        $totalSteps = $this->getTotalSteps($req);
                                        $progressPct = $this->getProgressPercentage($req);

                                        // Si el trámite está marcado como completado pero los pasos no reflejan el avance, ajustamos la visualización.
                                        if ($isCompleted) {
                                            if ($totalSteps > 0) {
                                                $completedSteps = $totalSteps;
                                                $progressPct = 100;
                                            } else {
                                                $completedSteps = 0;
                                                $progressPct = 100;
                                            }
                                        }
                                    @endphp
                                    <div class="d-flex align-items-center">
                                        <span class="me-2 small">{{ $completedSteps }}/{{ $totalSteps }}</span>
                                        <div class="progress w-100" style="height: 8px;">
                                            <div class="progress-bar @if ($isCompleted) bg-success @elseif($isInProgress) bg-warning @elseif($isCancelled) bg-danger @else bg-info @endif"
                                                role="progressbar" style="width: {{ $progressPct }}%"
                                                aria-valuenow="{{ $progressPct }}" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-start" style="width: 12%; min-width: 72px;">
                                    <div class="btn-group position-static">
                                        <button
                                            class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            @icon('menu', 'icon icon-xs')
                                        </button>
                                        <div class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1">
                                            <a class="dropdown-item d-flex align-items-center"
                                                href="{{ route(config('proj.route_name_prefix', 'proj') . '.worker.procedure-detail', ['id' => $req->request_id]) }}">
                                                @icon('view', 'dropdown-icon text-gray-400 me-2')
                                                Ver detalle
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-5">
                                    <div
                                        class="d-flex flex-column align-items-center justify-content-center text-gray-500">
                                        @icon('help', 'fa-2x mb-3 text-gray-400')
                                        <p class="fw-bold mb-1">No hay trámites para mostrar</p>
                                        <p class="small mb-0">Comienza un nuevo trámite haciendo clic en "Nuevo trámite"
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div
                    class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
                    @if ($requests->hasPages())
                        <nav aria-label="Page navigation" class="mb-3 mb-lg-0">
                            {{ $requests->links() }}
                        </nav>
                    @endif
                    <div class="fw-normal small mt-4 mt-lg-0 ms-lg-auto">
                        Mostrando <b>{{ $requests->firstItem() ?? 0 }}</b> a
                        <b>{{ $requests->lastItem() ?? 0 }}</b> de <b>{{ $requests->total() }}</b> trámites
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
