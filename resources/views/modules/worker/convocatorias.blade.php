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
                            @icon('nav.home', 'icon icon-xxs')
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Convocatorias y documentos</li>
                </ol>
            </nav>
            <h2 class="h4">Convocatorias y documentos pblicos</h2>
            <p class="mb-0">Accede a convocatorias vigentes, reglamentos, manuales y documentos descargables</p>
        </div>
    </div>

    {{-- Active Convocatorias --}}
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card border-0 shadow">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <h2 class="fs-5 fw-bold mb-0">Convocatorias activas</h2>
                    <span class="badge bg-success">{{ $convocatorias->count() }} vigentes</span>
                </div>
                <div class="card-body">
                    @forelse($convocatorias as $index => $convocatoria)
                    <div class="card {{ $index < $convocatorias->count() - 1 ? 'mb-4' : 'mb-0' }} border">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h3 class="h5 mb-2">{{ $convocatoria->title }}</h3>
                                    <div class="d-flex align-items-center mb-2">
                                        @if($convocatoria->status === 'activa')
                                            <span class="badge bg-success me-2">Vigente</span>
                                        @elseif($convocatoria->status === 'permanente')
                                            <span class="badge bg-info me-2">Permanente</span>
                                        @elseif($convocatoria->status === 'proxima')
                                            <span class="badge bg-warning me-2">Prximamente</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-primary">
                                    <svg class="icon icon-lg" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9 2a2 2 0 00-2 2v8a2 2 0 002 2h6a2 2 0 002-2V6.414A2 2 0 0016.414 5L14 2.586A2 2 0 0012.586 2H9z"></path>
                                        <path d="M3 8a2 2 0 012-2v10h8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"></path>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-gray-700 mb-3">
                                {{ $convocatoria->description }}
                            </p>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <small class="text-gray-600 fw-bold d-block mb-1">
                                        <svg class="icon icon-xxs me-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                        </svg>
                                        Fecha de inicio:
                                    </small>
                                    <small class="text-gray-700">{{ $convocatoria->start_date ? $convocatoria->start_date->format('d/m/Y') : 'N/A' }}</small>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-gray-600 fw-bold d-block mb-1">
                                        <svg class="icon icon-xxs me-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                        </svg>
                                        Fecha lmite:
                                    </small>
                                    @if($convocatoria->end_date)
                                        <small class="text-danger fw-bold">{{ $convocatoria->end_date->format('d/m/Y') }}</small>
                                    @else
                                        <small class="text-info fw-bold">Sin fecha lmite (Permanente)</small>
                                    @endif
                                </div>
                            </div>

                            @if($convocatoria->documents->count() > 0)
                            <div class="border-top pt-3">
                                <small class="text-gray-600 fw-bold d-block mb-2">Documentos disponibles:</small>
                                <div class="row">
                                    @foreach($convocatoria->documents as $documento)
                                    <div class="col-md-4 mb-2">
                                        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.convocation-document.show', $documento->convocation_document_id) }}" target="_blank" class="btn btn-sm btn-outline-primary w-100 d-flex align-items-center justify-content-between">
                                            <span class="text-truncate">{{ $documento->title }}</span>
                                            <svg class="icon icon-xs ms-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                            </svg>
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
                        {{-- Column 1: Reglamentos --}}
                        <div class="col-md-6 mb-4">
                            <h3 class="h6 fw-bold mb-3">
                                <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                                </svg>
                                Reglamentos
                            </h3>
                            <div class="list-group list-group-flush">
                                <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-bold">Reglamento Interior de Trabajo</div>
                                        <small class="text-gray-600">Actualizado: 01/2025</small>
                                    </div>
                                    <svg class="icon icon-xs text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </a>
                                <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-bold">Reglamento de Seguridad e Higiene</div>
                                        <small class="text-gray-600">Actualizado: 12/2024</small>
                                    </div>
                                    <svg class="icon icon-xs text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </a>
                                <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-bold">Cdigo de tica y Conducta</div>
                                        <small class="text-gray-600">Actualizado: 10/2024</small>
                                    </div>
                                    <svg class="icon icon-xs text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </a>
                                <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-bold">Contrato Colectivo de Trabajo</div>
                                        <small class="text-gray-600">Vigencia: 2024-2026</small>
                                    </div>
                                    <svg class="icon icon-xs text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>

                        {{-- Column 2: Manuales y Formatos --}}
                        <div class="col-md-6 mb-4">
                            <h3 class="h6 fw-bold mb-3">
                                <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9 2a2 2 0 00-2 2v8a2 2 0 002 2h6a2 2 0 002-2V6.414A2 2 0 0016.414 5L14 2.586A2 2 0 0012.586 2H9z"></path>
                                    <path d="M3 8a2 2 0 012-2v10h8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"></path>
                                </svg>
                                Manuales y Formatos
                            </h3>
                            <div class="list-group list-group-flush">
                                <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-bold">Manual de Procedimientos</div>
                                        <small class="text-gray-600">Versin 3.2 - 2025</small>
                                    </div>
                                    <svg class="icon icon-xs text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </a>
                                <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-bold">Formatos de Solicitudes</div>
                                        <small class="text-gray-600">Coleccin completa</small>
                                    </div>
                                    <svg class="icon icon-xs text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </a>
                                <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-bold">Gua del Usuario - Sistema ST</div>
                                        <small class="text-gray-600">Actualizado: 11/2025</small>
                                    </div>
                                    <svg class="icon icon-xs text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </a>
                                <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-bold">Tabulador de Sueldos 2025</div>
                                        <small class="text-gray-600">Vigencia: 01/2025</small>
                                    </div>
                                    <svg class="icon icon-xs text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </a>
                            </div>
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
