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
                    <li class="breadcrumb-item active" aria-current="page">Documentos</li>
                </ol>
            </nav>
            <h2 class="h4">Documentos Institucionales</h2>
            <p class="mb-0">Gestión de documentos institucionales</p>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.document.create') }}"
                class="btn btn-sm btn-gray-800 d-inline-flex align-items-center">
                @icon('add', 'me-2')
                Agregar Documento
            </a>
        </div>
    </div>

    {{-- Filters and Table --}}
    <div class="table-settings mb-4">
        <div class="d-flex flex-wrap gap-3 align-items-center">
            <div class="input-group fmxw-300">
                <span class="input-group-text">@icon('search', 'icon icon-xs')</span>
                <input wire:model.live.debounce.300ms="search" type="text" class="form-control"
                    placeholder="Buscar documentos">
            </div>
            <div class="d-flex align-items-center text-nowrap">
                <span class="small text-gray-600 me-2">Filtrar por categoría:</span>
                <select wire:model.live="categoryFilter" class="form-select" style="min-width: 200px;"
                    aria-label="Filtrar por categoría">
                    <option value="">Todas</option>
                    <option value="Reglamento">Reglamento</option>
                    <option value="Manual">Manual</option>
                    <option value="Lineamiento">Lineamiento</option>
                    <option value="Código">Código</option>
                    <option value="Otro">Otro</option>
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

    <div class="card card-body border-0 shadow">
        <div class="table-responsive">
            <table class="table table-centered mb-0 rounded user-table w-100" style="table-layout: fixed;">
                <colgroup>
                    <col style="width: 42%">
                    <col style="width: 26%">
                    <col style="width: 20%">
                    <col style="width: 12%">
                </colgroup>
                <thead class="thead-light">
                    <tr>
                        <th class="border-0 rounded-start">Título</th>
                        <th class="border-0">Categoría</th>
                        <th class="border-0">Fecha Vigencia</th>
                        <th class="border-0 rounded-end text-start">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documents as $document)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="fw-bold">{{ $document->title }}</span>
                                </div>
                            </td>
                            <td><span class="fw-normal">{{ ucfirst($document->category ?? 'N/A') }}</span></td>
                            <td><span
                                    class="fw-normal">{{ $document->effective_date ? $document->effective_date->format('d/m/Y') : 'N/A' }}</span>
                            </td>
                            <td class="text-start" style="width: 12%; min-width: 72px;">
                                <div class="btn-group position-static">
                                    <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        @icon('menu', 'icon-xs')
                                    </button>
                                    <div class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1">
                                        <a class="dropdown-item d-flex align-items-center"
                                            href="{{ route(config('proj.route_name_prefix', 'proj') . '.institutional-document.show', $document->institucional_document_id) }}"
                                            target="_blank">
                                            @icon('view', 'dropdown-icon text-gray-400 me-2')
                                            Ver documento
                                        </a>
                                        <a class="dropdown-item d-flex align-items-center"
                                            href="{{ route(config('proj.route_name_prefix', 'proj') . '.institutional-document.download', $document->institucional_document_id) }}">
                                            @icon('download', 'dropdown-icon text-gray-400 me-2')
                                            Descargar
                                        </a>
                                        <a class="dropdown-item d-flex align-items-center"
                                            href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.document.edit', $document->institucional_document_id) }}">
                                            @icon('edit', 'dropdown-icon text-gray-400 me-2')
                                            Editar
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4">
                                <div class="text-gray-500">
                                    @icon('file', 'fa-2x mb-3')
                                    <p class="fw-bold">No hay documentos institucionales para mostrar</p>
                                    <p class="small">Sube tu primer documento con el botón superior</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div
            class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
            @if($documents->hasPages())
                <nav aria-label="Page navigation" class="mb-3 mb-lg-0">
                    {{ $documents->links() }}
                </nav>
            @endif
            <div class="fw-normal small mt-4 mt-lg-0 ms-lg-auto">
                Mostrando <b>{{ $documents->firstItem() ?? 0 }}</b> a
                <b>{{ $documents->lastItem() ?? 0 }}</b> de <b>{{ $documents->total() }}</b> registros
            </div>
        </div>
    </div>
</div>

