{{--
* Company: CETAM
* Project: ST
* File: convocatorias-documentos.blade.php
* Created on: 01/12/2025
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
                    <li class="breadcrumb-item active" aria-current="page">Convocatorias y Documentos</li>
                </ol>
            </nav>
            <h2 class="h4">Convocatorias y Documentos</h2>
            <p class="mb-0">Gestión de convocatorias públicas y documentos institucionales</p>
        </div>
    </div>

    {{-- Tabla de Convocatorias --}}
    <div class="card card-body border-0 shadow mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h5 mb-0">Convocatorias</h2>
            <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.convocatoria.create') }}"
               class="btn btn-sm btn-gray-800">
                @icon('action.create', 'me-1')
                Agregar nueva convocatoria
            </a>
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
                        <tr>
                            <td>
                                <div class="d-block">
                                    <span class="fw-bold">{{ $convocatoria->title }}</span>
                                    <div class="small text-gray">
                                        {{ Str::limit($convocatoria->description, 60) }}
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="fw-normal">{{ $convocatoria->start_date ? $convocatoria->start_date->format('d/m/Y') : 'N/A' }}</span>
                                @if($convocatoria->end_date)
                                    <span class="text-gray"> - </span>
                                    <span class="fw-normal">{{ $convocatoria->end_date->format('d/m/Y') }}</span>
                                @else
                                    <div class="small text-gray">Sin fecha fin</div>
                                @endif
                            </td>
                            <td>
                                @if($convocatoria->status === 'activa')
                                    <span class="fw-bold text-success">Activa</span>
                                @elseif($convocatoria->status === 'cerrada')
                                    <span class="fw-bold text-secondary">Cerrada</span>
                                @elseif($convocatoria->status === 'proxima')
                                    <span class="fw-bold text-warning">Próxima</span>
                                @elseif($convocatoria->status === 'permanente')
                                    <span class="fw-bold text-info">Permanente</span>
                                @else
                                    <span class="fw-bold text-gray-600">{{ ucfirst($convocatoria->status) }}</span>
                                @endif
                            </td>
                            <td>
                                @if($convocatoria->documents->count() > 0)
                                    @php
                                        $docsToShow = $convocatoria->documents->take(2);
                                        $extraDocs = $convocatoria->documents->count() - $docsToShow->count();
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
                                        @icon('action.more', 'icon-xs')
                                    </button>
                                    <div class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1">
                                        <button class="dropdown-item d-flex align-items-center view-convocatoria-detail"
                                            type="button"
                                            data-conv-id="{{ $convocatoria->convocation_id }}"
                                            data-conv-title="{{ $convocatoria->title }}"
                                            data-conv-description="{{ $convocatoria->description }}"
                                            data-conv-start="{{ $convocatoria->start_date ? $convocatoria->start_date->format('d/m/Y') : 'N/A' }}"
                                            data-conv-end="{{ $convocatoria->end_date ? $convocatoria->end_date->format('d/m/Y') : 'Permanente' }}"
                                            data-conv-status="{{ ucfirst($convocatoria->status) }}"
                                            data-conv-docs="{{ $convocatoria->documents->count() }}">
                                            @icon('action.view', 'dropdown-icon text-gray-400 me-2')
                                            Ver detalles
                                        </button>
                                        <a class="dropdown-item d-flex align-items-center"
                                            href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.convocatoria.edit', $convocatoria->convocation_id) }}">
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
                                    @icon('process.document', 'fa-3x mb-3')
                                    <p class="fw-bold">No hay convocatorias registradas</p>
                                    <p class="small">Crea tu primera convocatoria usando el botón superior</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($convocatorias->hasPages())
            <div class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
                <nav aria-label="Page navigation">
                    {{ $convocatorias->links() }}
                </nav>
                <div class="fw-normal small mt-4 mt-lg-0">
                    Mostrando <b>{{ $convocatorias->firstItem() ?? 0 }}</b> a
                    <b>{{ $convocatorias->lastItem() ?? 0 }}</b> de <b>{{ $convocatorias->total() }}</b> registros
                </div>
            </div>
        @endif
    </div>

    {{-- Tabla de Documentos Institucionales --}}
    <div class="card card-body border-0 shadow">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h2 class="h5 mb-0">Documentos Institucionales</h2>
                <p class="small text-gray-500 mb-0 mt-1">Reglamentos, manuales y lineamientos</p>
            </div>
            <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.documento.create') }}"
               class="btn btn-sm btn-gray-800">
                @icon('action.create', 'me-1')
                Agregar nuevo documento
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-centered table-nowrap mb-0 rounded user-table">
                <thead class="thead-light">
                    <tr>
                        <th class="border-0 rounded-start">Título</th>
                        <th class="border-0">Categoría</th>
                        <th class="border-0">Versión</th>
                        <th class="border-0">Fecha</th>
                        <th class="border-0">Estado</th>
                        <th class="border-0 rounded-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($institutionalDocuments as $document)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    @icon('file.generic', 'text-danger me-2')
                                    <span class="fw-bold">{{ $document->title }}</span>
                                </div>
                            </td>
                            <td><span class="fw-normal">{{ ucfirst($document->category ?? 'N/A') }}</span></td>
                            <td><span class="fw-normal">v{{ $document->version }}</span></td>
                            <td><span class="fw-normal">{{ $document->created_at->format('d/m/Y') }}</span></td>
                            <td>
                                <span class="fw-bold text-success">{{ ucfirst($document->status) }}</span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        @icon('action.more', 'icon-xs')
                                    </button>
                                    <div class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1">
                                        <a class="dropdown-item d-flex align-items-center"
                                            href="{{ route(config('proj.route_name_prefix', 'proj') . '.institutional-document.show', $document->institutional_document_id) }}"
                                            target="_blank">
                                            @icon('action.view', 'dropdown-icon text-gray-400 me-2')
                                            Ver documento
                                        </a>
                                        <a class="dropdown-item d-flex align-items-center"
                                            href="{{ route(config('proj.route_name_prefix', 'proj') . '.institutional-document.download', $document->institutional_document_id) }}">
                                            @icon('file.download', 'dropdown-icon text-gray-400 me-2')
                                            Descargar
                                        </a>
                                        <a class="dropdown-item d-flex align-items-center"
                                            href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.documento.edit', $document->institutional_document_id) }}">
                                            @icon('action.edit', 'dropdown-icon text-gray-400 me-2')
                                            Editar
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <div class="text-gray-500">
                                    @icon('file.generic', 'fa-3x mb-3')
                                    <p class="fw-bold">No hay documentos institucionales</p>
                                    <p class="small">Sube tu primer documento usando el botón superior</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($institutionalDocuments->hasPages())
            <div class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
                <nav aria-label="Page navigation">
                    {{ $institutionalDocuments->links() }}
                </nav>
                <div class="fw-normal small mt-4 mt-lg-0">
                    Mostrando <b>{{ $institutionalDocuments->firstItem() ?? 0 }}</b> a
                    <b>{{ $institutionalDocuments->lastItem() ?? 0 }}</b> de <b>{{ $institutionalDocuments->total() }}</b> registros
                </div>
            </div>
        @endif
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

        // Event listener para ver detalles de convocatoria
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
                    title: 'Detalle de la Convocatoria',
                    html: `
                        <div class="text-start">
                            <p class="mb-2"><span class="fw-bold">Título:</span> ${title}</p>
                            <p class="mb-2"><span class="fw-bold">Descripción:</span><br>${description}</p>
                            <p class="mb-2"><span class="fw-bold">Fecha inicio:</span> ${start}</p>
                            <p class="mb-2"><span class="fw-bold">Fecha fin:</span> ${end}</p>
                            <p class="mb-2"><span class="fw-bold">Estado:</span> ${status}</p>
                            <p class="mb-0"><span class="fw-bold">Documentos:</span> ${docs}</p>
                        </div>
                    `,
                    icon: 'info',
                    confirmButtonText: 'Cerrar',
                    showConfirmButton: true
                });
            }
        });
    });
</script>
