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
                <span class="small text-gray-600 me-2">Estado:</span>
                <select wire:model.live="statusFilter" class="form-select" style="min-width: 200px;">
                    <option value="">Todos</option>
                    <option value="activa">Activa</option>
                    <option value="permanente">Permanente</option>
                    <option value="proxima">Próxima</option>
                </select>
            </div>
            <div class="ms-auto">
                <button wire:click="clearFilters" type="button"
                    class="btn btn-sm btn-gray-300 d-inline-flex align-items-center">
                    @icon('refresh', 'me-2')
                    Limpiar filtros
                </button>
            </div>
        </div>
    </div>

    {{-- Listado --}}
    <div class="card card-body border-0 shadow">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h5 mb-0">Convocatorias</h2>
        </div>
        <div class="table-responsive">
            <table class="table table-centered table-nowrap mb-0 rounded user-table">
                <thead class="thead-light">
                    <tr>
                        <th class="border-0 rounded-start">Título</th>
                        <th class="border-0">Periodo</th>
                        <th class="border-0">Estado</th>
                        <th class="border-0">Documentos</th>
                        <th class="border-0 rounded-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($convocatorias as $convocatoria)
                        @php
                            $isActiva = $convocatoria->status === 'activa';
                            $isPermanente = $convocatoria->status === 'permanente';
                            $isProxima = $convocatoria->status === 'proxima';
                        @endphp
                        <tr>
                            <td>
                                <div class="fw-bold text-gray-900">{{ $convocatoria->title }}</div>
                                <div class="text-gray-600 small">{{ Str::limit($convocatoria->description, 80) }}</div>
                            </td>
                            <td>
                                <div class="fw-normal">
                                    {{ $convocatoria->start_date ? $convocatoria->start_date->format('d/m/Y') : 'N/A' }}
                                    @if($convocatoria->end_date)
                                        <span class="text-gray-500"> - </span>
                                        {{ $convocatoria->end_date->format('d/m/Y') }}
                                    @else
                                        <div class="text-gray-500 small">Sin fecha fin</div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if($isActiva)
                                    <span class="fw-bold text-success">Activa</span>
                                @elseif($isPermanente)
                                    <span class="fw-bold text-info">Permanente</span>
                                @elseif($isProxima)
                                    <span class="fw-bold text-warning">Próxima</span>
                                @else
                                    <span class="fw-bold text-secondary">{{ ucfirst($convocatoria->status) }}</span>
                                @endif
                            </td>
                            <td>
                                @if($convocatoria->documents->count() > 0)
                                    <span class="small text-gray-700">{{ $convocatoria->documents->count() }} documentos</span>
                                @else
                                    <span class="small text-gray-500">Sin documentos</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button
                                        class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <svg class="icon icon-xs" fill="currentColor"
                                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z">
                                            </path>
                                        </svg>
                                    </button>
                                    <div class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1">
                                        <button class="dropdown-item d-flex align-items-center view-convocatoria-detail"
                                            type="button"
                                            data-title="{{ $convocatoria->title }}"
                                            data-description="{{ $convocatoria->description }}"
                                            data-start="{{ $convocatoria->start_date ? $convocatoria->start_date->format('d/m/Y') : 'N/A' }}"
                                            data-end="{{ $convocatoria->end_date ? $convocatoria->end_date->format('d/m/Y') : 'Sin fecha fin' }}"
                                            data-status="{{ $convocatoria->status }}"
                                            data-docs="{{ $convocatoria->documents->count() }}">
                                            @icon('view', 'dropdown-icon text-gray-400 me-2')
                                            Ver detalles
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
                                    @icon('announcement', 'fa-2x')
                                    </div>
                                    <p class="fw-bold">No hay convocatorias para mostrar</p>
                                    <p class="small">Revisa más tarde, pronto habrá nuevas convocatorias.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div
            class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
            @if($convocatorias->hasPages())
                <nav aria-label="Page navigation" class="mb-3 mb-lg-0">
                    {{ $convocatorias->links() }}
                </nav>
            @endif
            <div class="fw-normal small mt-4 mt-lg-0 ms-lg-auto">
                Mostrando <b>{{ $convocatorias->firstItem() ?? 0 }}</b> a
                <b>{{ $convocatorias->lastItem() ?? 0 }}</b> de <b>{{ $convocatorias->total() }}</b> convocatorias
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.addEventListener('click', function (e) {
            const btn = e.target.closest('.view-convocatoria-detail');
            if (!btn) return;

            const title = btn.getAttribute('data-title') || '';
            const desc = btn.getAttribute('data-description') || '';
            const start = btn.getAttribute('data-start') || 'N/A';
            const end = btn.getAttribute('data-end') || 'Sin fecha fin';
            const status = btn.getAttribute('data-status') || '';
            const docs = btn.getAttribute('data-docs') || '0';

            const htmlContent = `
                <div class="text-start">
                    <p class="mb-2"><span class="fw-bold">Título:</span> ${title}</p>
                    <p class="mb-2"><span class="fw-bold">Descripción:</span><br>${desc}</p>
                    <p class="mb-2"><span class="fw-bold">Fecha inicio:</span> ${start}</p>
                    <p class="mb-2"><span class="fw-bold">Fecha fin:</span> ${end}</p>
                    <p class="mb-0"><span class="fw-bold">Documentos:</span> ${docs}</p>
                </div>
            `;

            if (window.Swal) {
                Swal.fire({
                    title: 'Detalle de la convocatoria',
                    html: htmlContent,
                    icon: 'info',
                    confirmButtonText: 'Cerrar'
                });
            } else {
                alert(`Título: ${title}\nDescripción: ${desc}\nInicio: ${start}\nFin: ${end}\nDocumentos: ${docs}`);
            }
        });
    });
</script>
