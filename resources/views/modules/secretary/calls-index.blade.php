{{--
Company: CETAM
Project: ST
File: calls-index.blade.php
Created on: 04/12/2025
Created by: Alfonso Angel Garcia Hernandez
Approved by: Alfonso Angel Garcia Hernandez

Changelog:
- ID: <ID> | Date: dd/mm/yyyy
    Modified by: <Developer name>
        Description: <Brief description of change>
            --}}
            <div>
                {{-- Page Header --}}
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
                    <div class="d-block mb-4 mb-md-0">
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                                <li class="breadcrumb-item">
                                    <a
                                        href="{{ route(config('proj.route_name_prefix', 'proj') . '.dashboard.index') }}">
                                        @icon('home', 'fa-xs')
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
                            @icon('add', 'me-1')
                            Agregar convocatoria
                        </a>
                    </div>
                </div>

                {{-- Filters and Search --}}
                <div class="table-settings mb-4">
                    <div class="d-flex flex-wrap gap-3 align-items-center">
                        <div class="input-group fmxw-300">
                            <span class="input-group-text">@icon('search', 'icon icon-xs')</span>
                            <input wire:model.live.debounce.300ms="search" type="text" class="form-control"
                                placeholder="Buscar por título o descripción">
                        </div>
                        <div class="d-flex align-items-center text-nowrap">
                            <span class="small text-gray-600 me-2">Filtrar por estado:</span>
                            <select wire:model.live="statusFilter" class="form-select" style="min-width: 200px;"
                                aria-label="Filtrar por estado">
                                <option value="">Todos</option>
                                <option value="activa">Activa</option>
                                <option value="proxima">Próxima</option>
                                <option value="permanente">Permanente</option>
                                <option value="cerrada">Cerrada</option>
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

                {{-- Convocations Table --}}
                <div class="card card-body border-0 shadow mb-4">
                    <div class="table-responsive">
                        <table class="table table-centered mb-0 rounded user-table w-100" style="table-layout: fixed;">
                            <colgroup>
                                <col style="width: 40%">
                                <col style="width: 30%">
                                <col style="width: 18%">
                                <col style="width: 12%">
                            </colgroup>
                            <thead class="thead-light">
                                <tr>
                                    <th class="border-0 rounded-start">Título</th>
                                    <th class="border-0">Periodo</th>
                                    <th class="border-0">Estado</th>
                                    <th class="border-0 rounded-end text-start">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($convocations as $convocation)
                                    <tr>
                                        <td>
                                            <span class="fw-bold">{{ $convocation->title }}</span>
                                        </td>
                                        <td>
                                            <span class="fw-normal">
                                                {{ $convocation->start_date ? $convocation->start_date->format('d/m/Y') : 'N/D' }}
                                            </span>
                                            <span class="text-gray"> - </span>
                                            @if ($convocation->end_date)
                                                <span class="fw-normal">{{ $convocation->end_date->format('d/m/Y') }}</span>
                                            @else
                                                <span class="fw-normal text-gray-500">—</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($convocation->status === 'activa')
                                                <span class="fw-bold text-success">Activa</span>
                                            @elseif($convocation->status === 'cerrada')
                                                <span class="fw-bold text-danger">Cerrada</span>
                                            @elseif($convocation->status === 'proxima')
                                                <span class="fw-bold text-warning">Próxima</span>
                                            @elseif($convocation->status === 'permanente')
                                                <span class="fw-bold text-info">Permanente</span>
                                            @else
                                                <span class="fw-bold text-gray-600">{{ ucfirst($convocation->status) }}</span>
                                            @endif
                                        </td>
                                        <td class="text-start" style="width: 12%; min-width: 72px;">
                                            <div class="btn-group position-static">
                                                <button
                                                    class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    @icon('menu', 'icon icon-xs')
                                                </button>
                                                <div class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1">
                                                    <button
                                                        class="dropdown-item d-flex align-items-center view-convocatoria-detail"
                                                        type="button" data-conv-id="{{ $convocation->convocation_id }}"
                                                        data-conv-title="{{ $convocation->title }}"
                                                        data-conv-description="{{ $convocation->description }}"
                                                        data-conv-start="{{ $convocation->start_date ? $convocation->start_date->format('d/m/Y') : 'N/D' }}"
                                                        data-conv-end="{{ $convocation->end_date ? $convocation->end_date->format('d/m/Y') : 'Permanente' }}"
                                                        data-conv-status="{{ ucfirst($convocation->status) }}"
                                                        data-conv-docs="{{ $convocation->documents->count() }}">
                                                        @icon('view', 'dropdown-icon text-gray-400 me-2')
                                                        Ver detalles
                                                    </button>
                                                    @php
                                                        $docsPayload = $convocation->documents->map(function ($doc) {
                                                            return [
                                                                'name' => $doc->file_name ?? 'Documento',
                                                                'show' => route(config('proj.route_name_prefix', 'proj') . '.convocation-document.show', $doc->convocation_doc_id),
                                                                'download' => route(config('proj.route_name_prefix', 'proj') . '.convocation-document.download', $doc->convocation_doc_id),
                                                            ];
                                                        })->values()->toArray();
                                                    @endphp
                                                    @if ($convocation->documents->count() > 0)
                                                        <button class="dropdown-item d-flex align-items-center open-docs-modal"
                                                            type="button" data-conv-title="{{ $convocation->title }}"
                                                            data-docs='@json($docsPayload)'>
                                                            @icon('file', 'dropdown-icon text-gray-400 me-2')
                                                            Documentos ({{ $convocation->documents->count() }})
                                                        </button>
                                                    @endif
                                                    <a class="dropdown-item d-flex align-items-center"
                                                        href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.convocation.edit', $convocation->convocation_id) }}">
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
                                                @icon('announcement', 'fa-2x mb-3')
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
                        @if ($convocations->hasPages())
                            <nav aria-label="Page navigation" class="mb-3 mb-lg-0">
                                {{ $convocations->links('components.pagination-users') }}
                            </nav>
                        @endif
                        <div class="fw-normal small mt-4 mt-lg-0 ms-lg-auto">
                            Mostrando <b>{{ $convocations->firstItem() ?? 0 }}</b> a
                            <b>{{ $convocations->lastItem() ?? 0 }}</b> de <b>{{ $convocations->total() }}</b>
                            convocatorias
                        </div>
                    </div>
                </div>
            </div>

            @section('scripts')
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const swalWithBootstrapButtons = Swal.mixin({
                            customClass: {
                                confirmButton: 'btn btn-primary me-2',
                                cancelButton: 'btn btn-gray'
                            },
                            buttonsStyling: false
                        });

                        // Event listener para ver detalles de la convocatoria
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
                                    title: 'Detalles de la Convocatoria',
                                    html: `
                                <div class="text-start">
                                    <p class="mb-2"><span class="fw-bold">Título:</span> ${title}</p>
                                    <p class="mb-2"><span class="fw-bold">Descripción:</span><br>${description}</p>
                                    <p class="mb-2"><span class="fw-bold">Fecha de inicio:</span> ${start}</p>
                                    <p class="mb-2"><span class="fw-bold">Fecha de fin:</span> ${end}</p>
                                    <p class="mb-2"><span class="fw-bold">Estado:</span> ${status}</p>
                                    <p class="mb-0"><span class="fw-bold">Documentos:</span> ${docs}</p>
                                </div>
                            `,
                                    icon: 'info',
                                    confirmButtonText: 'Cerrar',
                                    showConfirmButton: true
                                });
                            }
                            if (e.target.closest('.open-docs-modal')) {
                                e.preventDefault();
                                const button = e.target.closest('.open-docs-modal');
                                const title = button.getAttribute('data-conv-title') || 'Documentos';
                                const docsRaw = button.getAttribute('data-docs') || '[]';
                                let docs = [];
                                try {
                                    docs = JSON.parse(docsRaw);
                                } catch (err) {
                                    docs = [];
                                }

                                if (!docs.length) {
                                    swalWithBootstrapButtons.fire({
                                        title: `Documentos - ${title}`,
                                        html: '<div class="text-center text-gray-500 py-2">Sin documentos</div>',
                                        icon: 'info',
                                        confirmButtonText: 'Cerrar',
                                        showConfirmButton: true,
                                    });
                                    return;
                                }

                                const listHtml = docs.map((doc) => {
                                    const name = doc.name || 'Documento';
                                    const showUrl = doc.show || '#';
                                    const downloadUrl = doc.download || '#';
                                    return `
                                <div class="d-flex align-items-center justify-content-between py-2 border-bottom">
                                    <div class="me-3">
                                        <div class="fw-bold text-gray-800">${name}</div>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <a class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center" href="${showUrl}" target="_blank" rel="noopener">
                                            @icon('file', 'me-2') Abrir
                                        </a>
                                        <a class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center" href="${downloadUrl}" target="_blank" rel="noopener">
                                            @icon('download', 'me-2') Descargar
                                        </a>
                                    </div>
                                </div>
                            `;
                                }).join('');

                                swalWithBootstrapButtons.fire({
                                    title: `Documentos - ${title}`,
                                    html: `<div class="list-group list-group-flush">${listHtml}</div>`,
                                    icon: 'info',
                                    confirmButtonText: 'Cerrar',
                                    showConfirmButton: true,
                                });
                            }
                        });

                        // Evitar que los botones del swal queden focuseados en gris después del clic
                        document.addEventListener('click', function (e) {
                            const btn = e.target.closest('.swal2-popup .btn-outline-secondary');
                            if (btn) {
                                setTimeout(() => btn.blur(), 50);
                            }
                        });
                    });
                </script>
                <style>
                    /* SweetAlert document buttons hover: text + icon in white */
                    .swal2-popup .btn-outline-secondary:hover,
                    .swal2-popup .btn-outline-secondary:active,
                    .swal2-popup .btn-outline-secondary:focus-visible {
                        background-color: var(--bs-secondary, #6c757d) !important;
                        border-color: var(--bs-secondary, #6c757d) !important;
                        color: #fff !important;
                    }

                    .swal2-popup .btn-outline-secondary:hover .icon,
                    .swal2-popup .btn-outline-secondary:active .icon,
                    .swal2-popup .btn-outline-secondary:focus-visible .icon {
                        color: #fff !important;
                    }
                </style>
            @endsection