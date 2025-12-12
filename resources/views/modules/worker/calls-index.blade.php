{{-- 
* Company: CETAM
* Project: ST
* File: calls-index.blade.php
* Created on: 04/12/2025
* Created by: Claude Code
* Approved by: Alfonso Angel Garcia Hernandez
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
                    <li class="breadcrumb-item active" aria-current="page">Convocatorias</li>
                </ol>
            </nav>
            <h2 class="h4">Convocatorias</h2>
            <p class="mb-0">Accede a las convocatorias vigentes y próximas</p>
        </div>
    </div>

    {{-- Filtros --}}
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
                    placeholder="Buscar convocatorias">
            </div>
            <div class="d-flex align-items-center text-nowrap">
                <span class="small text-gray-600 me-2">Filtrar por estado:</span>
                <select wire:model.live="statusFilter" class="form-select" style="min-width: 200px;">
                    <option value="">Todos</option>
                    <option value="activa">Activa</option>
                    <option value="permanente">Permanente</option>
                    <option value="proxima">Próxima</option>
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

    {{-- Listado en cards (una por fila) --}}
    <div class="row g-3">
        @forelse($convocatorias as $convocatoria)
            @php
                $status = strtolower($convocatoria->status);
                $statusClass = match($status) {
                    'activa' => 'text-success',
                    'permanente' => 'text-info',
                    'proxima' => 'text-warning',
                    default => 'text-secondary'
                };
                $statusLabel = match($status) {
                    'activa' => 'Activa',
                    'permanente' => 'Permanente',
                    'proxima' => 'Próxima',
                    default => ucfirst($status)
                };
                $start = $convocatoria->start_date ? $convocatoria->start_date->format('d/m/Y') : 'N/A';
                $end = $convocatoria->end_date ? $convocatoria->end_date->format('d/m/Y') : 'Sin fecha fin';
            @endphp
            <div class="col-12">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h3 class="h6 mb-0 text-truncate">{{ $convocatoria->title }}</h3>
                            <span class="fw-bold small {{ $statusClass }}">{{ $statusLabel }}</span>
                        </div>
                        <p class="text-muted mb-3">{{ $convocatoria->description }}</p>
                        <div class="mb-3">
                            <div class="small text-gray-700 fw-bold">Periodo</div>
                            <div class="small text-gray-700">{{ $start }} <span class="text-gray">-</span> {{ $end }}</div>
                        </div>
                        <div class="mt-auto d-flex justify-content-between align-items-center">
                            <div class="small text-gray-600 mb-0">
                                <div class="fw-bold text-gray-700">Documentos</div>
                                @if($convocatoria->documents->count() > 0)
                                    <ul class="list-unstyled mb-0">
                                        @foreach($convocatoria->documents as $doc)
                                            <li class="mb-1 small">
                                                <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.convocation-document.download', $doc->convocation_doc_id) }}"
                                                   class="text-decoration-none">
                                                    {{ $doc->file_name ?? 'Documento' }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="text-gray-500">Sin documentos</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        @icon('announcement', 'fa-2x mb-3 text-gray-500')
                        <p class="fw-bold mb-1">No hay convocatorias para mostrar</p>
                        <p class="small text-gray-600 mb-0">Revisa más tarde, pronto habrá nuevas convocatorias.</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    @if($convocatorias->hasPages())
        <div class="d-flex justify-content-center mt-4">
            <nav aria-label="Page navigation">
                {{ $convocatorias->links() }}
            </nav>
        </div>
    @endif
</div>









