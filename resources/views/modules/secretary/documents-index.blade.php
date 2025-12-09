{{--
* Company: CETAM
* Project: ST
* File: documents-index.blade.php
* Created on: 04/12/2025
* Created by: Alfonso Angel García Hernández
* Approved by: Alfonso Angel García Hernández
--}}
<div>
    {{-- Page Header --}}
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
                    <li class="breadcrumb-item active" aria-current="page">Documentos</li>
                </ol>
            </nav>
            <h2 class="h4">Documentos Institucionales</h2>
            <p class="mb-0">Gestión de documentos institucionales</p>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.document.create') }}"
                class="btn btn-sm btn-gray-800 d-inline-flex align-items-center">
                @icon('action.create', 'me-2')
                Agregar Documento
            </a>
        </div>
    </div>

    {{-- Institutional Documents Table --}}
    <div class="card card-body border-0 shadow">

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
                    @forelse($documents as $document)
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
                                @php
                                    $statusText = match($document->status) {
                                        'active' => 'Activo',
                                        'inactive' => 'Inactivo',
                                        'published' => 'Publicado',
                                        'draft' => 'Borrador',
                                        default => ucfirst($document->status),
                                    };
                                @endphp
                                <span class="fw-bold text-success">{{ $statusText }}</span>
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
                                            href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.document.edit', $document->institutional_document_id) }}">
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
                                    @icon('file.generic', 'fa-2x mb-3')
                                    <p class="fw-bold">No hay documentos institucionales para mostrar</p>
                                    <p class="small">Sube tu primer documento con el botón superior</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($documents->hasPages())
            <div
                class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
                <nav aria-label="Page navigation">
                    {{ $documents->links() }}
                </nav>
                <div class="fw-normal small mt-4 mt-lg-0">
                    Mostrando <b>{{ $documents->firstItem() ?? 0 }}</b> a
                    <b>{{ $documents->lastItem() ?? 0 }}</b> de <b>{{ $documents->total() }}</b> registros
                </div>
            </div>
        @endif
    </div>
</div>
