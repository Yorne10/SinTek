{{--
* Company: CETAM
* Project: ST
* File: calls-index.blade.php
* Created on: 04/12/2025
* Created by: Alfonso Angel García Hernández
* Approved by: Alfonso Angel García Hernández
--}}
<div>
    {{-- Page Header --}}
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
                    <li class="breadcrumb-item active" aria-current="page">Convocatorias</li>
                </ol>
            </nav>
            <h2 class="h4">Convocatorias</h2>
            <p class="mb-0">Gestión de convocatorias públicas</p>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.convocation.create') }}"
                class="btn btn-sm btn-gray-800 d-inline-flex align-items-center">
                @icon('action.create', 'me-1')
                Agregar convocatoria
            </a>
        </div>
    </div>

    {{-- Filters and Search --}}
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
                    placeholder="Buscar por título o descripción">
            </div>
            <div class="d-flex align-items-center text-nowrap">
                <span class="small text-gray-600 me-2">Estado:</span>
                <select wire:model.live="statusFilter" class="form-select" style="min-width: 200px;">
                    <option value="">Todas</option>
                    <option value="activa">Activa</option>
                    <option value="proxima">Próxima</option>
                    <option value="permanente">Permanente</option>
                    <option value="cerrada">Cerrada</option>
                </select>
            </div>
            <div class="ms-auto">
                <button wire:click="clearFilters" type="button"
                    class="btn btn-sm btn-gray-300 d-inline-flex align-items-center">
                    @icon('action.refresh', 'me-2')
                    Limpiar filtros
                </button>
            </div>
        </div>
    </div>

    {{-- Convocations Table --}}
    <div class="card card-body border-0 shadow mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h5 mb-0">Lista de convocatorias</h2>
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
                    @forelse($convocations as $convocation)
                        <tr>
                            <td>
                                <div class="d-block">
                                    <span class="fw-bold">{{ $convocation->title }}</span>
                                    <div class="small text-gray">
                                        {{ Str::limit($convocation->description, 60) }}
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span
                                    class="fw-normal">{{ $convocation->start_date ? $convocation->start_date->format('d/m/Y') : 'N/D' }}</span>
                                @if($convocation->end_date)
                                    <span class="text-gray"> - </span>
                                    <span class="fw-normal">{{ $convocation->end_date->format('d/m/Y') }}</span>
                                @else
                                    <div class="small text-gray">Sin fecha de fin</div>
                                @endif
                            </td>
                            <td>
                                @if($convocation->status === 'activa')
                                    <span class="fw-bold text-success">Activa</span>
                                @elseif($convocation->status === 'cerrada')
                                    <span class="fw-bold text-secondary">Cerrada</span>
                                @elseif($convocation->status === 'proxima')
                                    <span class="fw-bold text-warning">Próxima</span>
                                @elseif($convocation->status === 'permanente')
                                    <span class="fw-bold text-info">Permanente</span>
                                @else
                                    <span class="fw-bold text-gray-600">{{ ucfirst($convocation->status) }}</span>
                                @endif
                            </td>
                            <td>
                                @if($convocation->documents->count() > 0)
                                    @php
                                        $docsToShow = $convocation->documents->take(2);
                                        $extraDocs = $convocation->documents->count() - $docsToShow->count();
                                    @endphp
                                    <div class="d-flex flex-column gap-1">
                                        @foreach($docsToShow as $doc)
                                            <a class="small d-inline-flex align-items-center"
                                                href="{{ route(config('proj.route_name_prefix', 'proj') . '.convocation-document.download', $doc->convocation_document_id) }}">
                                                @icon('file.download', 'icon-xs text-primary me-1')
                                                <span class="fw-normal text-primary">{{ $doc->title }}</span>
                                            </a>
                                        @endforeach
                                        @if($extraDocs > 0)
                                            <span class="small text-gray-500">+{{ $extraDocs }} documentos más</span>
                                        @endif
                                    </div>
                                @else
                                    <span class="small text-gray-500">Sin documentos</span>
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
                                        <button class="dropdown-item d-flex align-items-center view-convocatoria-detail"
                                            type="button" data-conv-id="{{ $convocation->convocation_id }}"
                                            data-conv-title="{{ $convocation->title }}"
                                            data-conv-description="{{ $convocation->description }}"
                                            data-conv-start="{{ $convocation->start_date ? $convocation->start_date->format('d/m/Y') : 'N/D' }}"
                                            data-conv-end="{{ $convocation->end_date ? $convocation->end_date->format('d/m/Y') : 'Permanente' }}"
                                            data-conv-status="{{ ucfirst($convocation->status) }}"
                                            data-conv-docs="{{ $convocation->documents->count() }}">
                                            @icon('action.view', 'dropdown-icon text-gray-400 me-2')
                                            Ver detalles
                                        </button>
                                        <a class="dropdown-item d-flex align-items-center"
                                            href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.convocation.edit', $convocation->convocation_id) }}">
                                            @icon('action.edit', 'dropdown-icon text-gray-400 me-2')
                                            Editar
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <div class="text-gray-500">
                                    @icon('process.document', 'fa-2x mb-3')
                                    <p class="fw-bold">No hay convocatorias para mostrar</p>
                                    <p class="small">Crea tu primera convocatoria con el botón superior</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div
            class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
            @if($convocations->hasPages())
                <nav aria-label="Page navigation" class="mb-3 mb-lg-0">
                    {{ $convocations->links() }}
                </nav>
            @endif
            <div class="fw-normal small mt-4 mt-lg-0 ms-lg-auto">
                Mostrando <b>{{ $convocations->firstItem() ?? 0 }}</b> a
                <b>{{ $convocations->lastItem() ?? 0 }}</b> de <b>{{ $convocations->total() }}</b> convocatorias
            </div>
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

        // Event listener to view convocation details
        document.addEventListener('click', function (e) {
            if (e.target.closest('.view-convocatoria-detail')) {
                e.preventDefault();
                const button = e.target.closest('.view-convocatoria-detail');
                const title = button.getAttribute('data-conv-title');
                const description = button.getAttribute('data-conv-description');
                const start = button.getAttribute('data-conv-start');
                const end = button.getAttribute('data-conv-end');
                const status = button.getAttribute('data-conv-status');
                const docs = button.getAttribute('data-conv-docs');

                swalWithBootstrapButtons.fire({
                    title: 'Convocation Details',
                    html: `
                        <div class="text-start">
                            <p class="mb-2"><span class="fw-bold">Title:</span> ${title}</p>
                            <p class="mb-2"><span class="fw-bold">Description:</span><br>${description}</p>
                            <p class="mb-2"><span class="fw-bold">Start Date:</span> ${start}</p>
                            <p class="mb-2"><span class="fw-bold">End Date:</span> ${end}</p>
                            <p class="mb-2"><span class="fw-bold">Status:</span> ${status}</p>
                            <p class="mb-0"><span class="fw-bold">Documents:</span> ${docs}</p>
                        </div>
                    `,
                    icon: 'info',
                    confirmButtonText: 'Close',
                    showConfirmButton: true
                });
            }
        });
    });
</script>
