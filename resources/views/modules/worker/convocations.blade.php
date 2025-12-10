{{--
 * Company: CETAM
 * Project: ST
 * File: convocatorias.blade.php
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
    {{-- Breadcrumb --}}
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item">
                        <a href="#">
                            @icon('home', 'fa-xs')
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Convocatorias y documentos</li>
                </ol>
            </nav>
            <h2 class="h4">Convocatorias y documentos pblicos</h2>
            <p class="mb-0">Accede a convocatorias vigentes, reglamentos, manuales y documentos descargables</p>
        </div>
    </div>
                                        </a>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @else
                            <div class="border-top pt-3">
                                <small class="text-gray-500 fst-italic">No hay documentos disponibles para esta convocatoria</small>
                            </div>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-5">
                        <svg class="icon icon-xxl text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h5 class="text-gray-600">No hay convocatorias disponibles</h5>
                        <p class="text-gray-500">Por el momento no hay convocatorias activas. Consulta prximamente.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- Public Documents Section --}}
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card border-0 shadow">
                <div class="card-header border-bottom">
                    <h2 class="fs-5 fw-bold mb-0">Documentos y reglamentos generales</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        {{-- Column 1: Reglamentos (desde BD) --}}
                        <div class="col-md-6 mb-4">
                            <h3 class="h6 fw-bold mb-3">
                                <span class="me-2">@icon('file', 'icon icon-xs')</span>
                                Reglamentos
                            </h3>
                            @if($regulations->count() > 0)
                                <div class="list-group list-group-flush">
                                    @foreach($regulations as $doc)
                                        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.institutional-document.download', $doc->institutional_document_id) }}"
                                            class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                            <div>
                                                <div class="fw-bold">{{ $doc->title }}</div>
                                                <small class="text-gray-600">
                                                    {{ $doc->effective_date ? 'Vigencia: ' . \Illuminate\Support\Carbon::parse($doc->effective_date)->format('m/Y') : 'Actualizado: ' . $doc->created_at->format('m/Y') }}
                                                </small>
                                            </div>
                                            @icon('download', 'icon icon-xs text-gray-500')
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-gray-500 small">No hay reglamentos disponibles.</div>
                            @endif
                        </div>

                        {{-- Column 2: Manuales y Formatos (desde BD) --}}
                        <div class="col-md-6 mb-4">
                            <h3 class="h6 fw-bold mb-3">
                                <span class="me-2">@icon('file', 'icon icon-xs')</span>
                                Manuales y Formatos
                            </h3>
                            @if($manuals->count() > 0)
                                <div class="list-group list-group-flush">
                                    @foreach($manuals as $doc)
                                        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.institutional-document.download', $doc->institutional_document_id) }}"
                                            class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                            <div>
                                                <div class="fw-bold">{{ $doc->title }}</div>
                                                <small class="text-gray-600">
                                                    {{ $doc->version ? 'Version ' . $doc->version : '' }}{{ $doc->effective_date ? ' - ' . \Illuminate\Support\Carbon::parse($doc->effective_date)->format('m/Y') : '' }}
                                                </small>
                                            </div>
                                            @icon('download', 'icon icon-xs text-gray-500')
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-gray-500 small">No hay manuales ni formatos disponibles.</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Help Section --}}
    <div class="row">
        <div class="col-12">
            <div class="alert alert-info d-flex align-items-center" role="alert">
                <svg class="icon icon-sm me-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <strong>Tienes dudas?</strong> Consulta la seccin de <a href="#" class="alert-link">Preguntas Frecuentes</a> o
                    contacta al Departamento de Recursos Humanos para ms informacin sobre convocatorias y documentos.
                </div>
            </div>
        </div>
    </div>
</div>
