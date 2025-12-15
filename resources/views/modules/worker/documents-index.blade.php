{{-- 
Company: CETAM
Project: ST
File: documents-index.blade.php
Created on: 04/12/2025
Created by: Alfonso Angel Garcia Hernandez
Approved by: Alfonso Angel Garcia Hernandez

Changelog:
    - ID: <ID> | Date: dd/mm/yyyy
    Modified by: <Developer name>
    Description: <Brief description of change>
--}}

<div>
    {{-- Breadcrumb --}}
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item">
                        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.dashboard.index') }}">
                            @icon('home', 'fa-xs')
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Documentos</li>
                </ol>
            </nav>
            <h2 class="h4">Documentos institucionales</h2>
            <p class="mb-0">Consulta y descarga reglamentos, manuales y formatos institucionales</p>
        </div>
    </div>

    {{-- Filters and table --}}
    <div class="table-settings mb-4">
        <div class="d-flex flex-wrap gap-3 align-items-center">
            <div class="input-group fmxw-300">
                <span class="input-group-text">@icon('search', 'icon icon-xs')</span>
                <input wire:model.live.debounce.300ms="search" type="text" class="form-control"
                    placeholder="Buscar documentos">
            </div>
            <div class="d-flex align-items-center text-nowrap">
                <span class="small text-gray-600 me-2">Filtrar por categor&iacute;a:</span>
                <select wire:model.live="categoryFilter" class="form-select" style="min-width: 180px;"
                    aria-label="Filtrar por categor&iacute;a">
                    <option value="">Todas</option>
                    <option value="Reglamento">Reglamento</option>
                    <option value="Manual">Manual</option>
                    <option value="Lineamiento">Lineamiento</option>
                    <option value="C&oacute;digo">C&oacute;digo</option>
                    <option value="Otro">Otro</option>
                </select>
            </div>
        </div>
    </div>

    <div class="card card-body border-0 shadow">
        <div class="table-responsive">
            <table class="table table-centered mb-0 rounded user-table w-100" style="table-layout: fixed;">
                <colgroup>
                    <col style="width: 42%">
                    <col style="width: 26%">
                    <col style="width: 20%">
                    <col style="width: 12%; min-width: 72px;">
                </colgroup>
                <thead class="thead-light">
                    <tr>
                        <th class="border-0 rounded-start">T&iacute;tulo</th>
                        <th class="border-0">Categor&iacute;a</th>
                        <th class="border-0">Fecha vigencia</th>
                        <th class="border-0 rounded-end text-start">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documents as $document)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span
                                        class="fw-bold text-gray-900 text-truncate d-inline-block w-100">{{ $document->title }}</span>
                                </div>
                            </td>
                            <td><span class="fw-normal">{{ ucfirst($document->category ?? 'N/A') }}</span></td>
                            <td><span
                                    class="fw-normal">{{ $document->effective_date ? \Illuminate\Support\Carbon::parse($document->effective_date)->format('d/m/Y') : 'N/A' }}</span>
                            </td>
                            <td class="text-start" style="width: 12%; min-width: 72px;">
                                <div class="btn-group position-static">
                                    <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        @icon('menu', 'icon icon-xs')
                                    </button>
                                    <div class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1">
                                        <button class="dropdown-item d-flex align-items-center view-document-detail"
                                            type="button" data-title="{{ $document->title }}"
                                            data-category="{{ ucfirst($document->category ?? 'N/A') }}"
                                            data-description="{{ $document->description ?? 'Sin descripción' }}"
                                            data-version="{{ $document->version ?? 'N/A' }}"
                                            data-effective-date="{{ $document->effective_date ? \Illuminate\Support\Carbon::parse($document->effective_date)->format('d/m/Y') : 'N/A' }}"
                                            data-status="{{ $document->status === 'active' ? 'Vigente' : 'Inactivo' }}">
                                            @icon('view', 'dropdown-icon text-gray-400 me-2')
                                            Ver detalles
                                        </button>
                                        <a class="dropdown-item d-flex align-items-center"
                                            href="{{ route(config('proj.route_name_prefix', 'proj') . '.institutional-document.show', $document->institucional_document_id) }}"
                                            target="_blank">
                                            @icon('file', 'dropdown-icon text-gray-400 me-2')
                                            Abrir documento
                                        </a>
                                        <a class="dropdown-item d-flex align-items-center"
                                            href="{{ route(config('proj.route_name_prefix', 'proj') . '.institutional-document.download', $document->institucional_document_id) }}">
                                            @icon('download', 'dropdown-icon text-gray-400 me-2')
                                            Descargar
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-5">
                                <div class="d-flex flex-column align-items-center justify-content-center text-gray-500">
                                    @icon('file', 'fa-2x mb-3')
                                    <p class="fw-bold mb-1">No hay documentos institucionales para mostrar</p>
                                    <p class="small mb-0">Ajusta tu b&uacute;squeda o categor&iacute;a</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div
            class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
            @php
                $isPaginated = $documents instanceof \Illuminate\Contracts\Pagination\Paginator;
                $from = $isPaginated ? $documents->firstItem() ?? 0 : ($documents->isEmpty() ? 0 : 1);
                $to = $isPaginated ? $documents->lastItem() ?? 0 : $documents->count();
                $total = $isPaginated ? $documents->total() : $documents->count();
            @endphp
            @if ($isPaginated && $documents->hasPages())
                <nav aria-label="Page navigation" class="mb-3 mb-lg-0">
                    {{ $documents->links('components.pagination-users') }}
                </nav>
            @endif
            <div class="fw-normal small mt-4 mt-lg-0 ms-lg-auto">
                Mostrando <b>{{ $from }}</b> a
                <b>{{ $to }}</b> de <b>{{ $total }}</b> registros
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-gray'
                },
                buttonsStyling: false
            });

            // Event listener para ver detalles
            document.addEventListener('click', function(e) {
                if (e.target.closest('.view-document-detail')) {
                    e.preventDefault();
                    const button = e.target.closest('.view-document-detail');

                    const title = button.getAttribute('data-title');
                    const category = button.getAttribute('data-category');
                    const description = button.getAttribute('data-description');
                    const version = button.getAttribute('data-version');
                    const effectiveDate = button.getAttribute('data-effective-date');
                    const status = button.getAttribute('data-status');

                    const htmlContent = `
                        <div class="text-start">
                            <p class="mb-2"><span class="fw-bold">Título:</span> ${title}</p>
                            <p class="mb-2"><span class="fw-bold">Categoría:</span> ${category}</p>
                            <p class="mb-2"><span class="fw-bold">Descripción:</span> ${description}</p>
                            <p class="mb-2"><span class="fw-bold">Versión:</span> ${version}</p>
                            <p class="mb-2"><span class="fw-bold">Fecha de vigencia:</span> ${effectiveDate}</p>
                            <p class="mb-0"><span class="fw-bold">Estado:</span> <span class="fw-bold ${status === 'Vigente' ? 'text-success' : 'text-warning'}">${status}</span></p>
                        </div>
                    `;

                    swalWithBootstrapButtons.fire({
                        title: 'Detalles del documento',
                        html: htmlContent,
                        icon: 'info',
                        confirmButtonText: 'Cerrar',
                        showConfirmButton: true,
                        width: '600px'
                    });
                }
            });
        });
    </script>
</div>
