{{--
* Company: CETAM
* Project: ST
* File: mis-tramites.blade.php
* Created on: 04/11/2025
* Created by: Alfonso Angel Garca Hernndez
* Approved by: Alfonso Angel Garca Hernndez
*
* Changelog:
* - ID: <ID> | Modified on: dd/mm/yyyy |
    * Modified by: <Developer name> |
        * Description: <Brief description of change> |
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
                                <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"
                                        clip-rule="evenodd"></path>
                                </svg>
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
                            <span class="small text-gray-600 me-2">Estado:</span>
                            <select wire:model.live="statusFilter" class="form-select" style="min-width: 200px;">
                                <option value="">Todos los estados</option>
                                <option value="in_progress">En proceso</option>
                                <option value="completed">Completado</option>
                                <option value="pending">Pendiente</option>
                                <option value="cancelled">Cancelado</option>
                            </select>
                        </div>
                        <div class="ms-auto">
                            <button wire:click="$set('search', ''); $set('statusFilter', '')" type="button"
                                class="btn btn-sm btn-gray-300 d-inline-flex align-items-center">
                                @icon('refresh', 'me-2')
                                Limpiar filtros
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Tramites list --}}
                <div class="row">
                    <div class="col-12">
                        <div class="card card-body shadow border-0 table-wrapper table-responsive">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h2 class="fs-5 fw-bold mb-0">Mis trámites</h2>
                            </div>
                            <table class="table table-centered table-nowrap mb-0 rounded">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="border-0">Tipo de trámite</th>
                                        <th class="border-0">Fecha inicio</th>
                                        <th class="border-0">Estado</th>
                                        <th class="border-0">Progreso</th>
                                        <th class="border-0">Acciones</th>
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
                                                $isPending = in_array($status, ['pending', 'pendiente']);
                                                $isCancelled = in_array($status, ['cancelled', 'cancelado']);
                                            @endphp
                                            <td>
                                                @if($isInProgress)
                                                    <span class="fw-bold text-warning">En proceso</span>
                                                @elseif($isCompleted)
                                                    <span class="fw-bold text-success">Completado</span>
                                                @elseif($isPending)
                                                    <span class="fw-bold text-info">Pendiente</span>
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
                                                        <div class="progress-bar @if($isCompleted) bg-success @elseif($isInProgress) bg-warning @elseif($isCancelled) bg-danger @else bg-info @endif"
                                                            role="progressbar" style="width: {{ $progressPct }}%"
                                                            aria-valuenow="{{ $progressPct }}" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button
                                                        class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                                                        data-bs-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z">
                                                            </path>
                                                        </svg>
                                                    </button>
                                                    <div
                                                        class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1">
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
                                            <td colspan="6" class="text-center py-4">
                                                <div class="text-gray-500">
                                                    <i class="fa-solid fa-clipboard-list fa-2x mb-3"></i>
                                                    <p class="fw-bold">No hay trámites para mostrar</p>
                                                    <p class="small">Comienza un nuevo trámite haciendo clic en "Nuevo
                                                        trámite"</p>
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
                                    Mostrando <b>{{ $requests->firstItem() ?? 0 }}</b> a
                                    <b>{{ $requests->lastItem() ?? 0 }}</b> de <b>{{ $requests->total() }}</b> trámites
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
