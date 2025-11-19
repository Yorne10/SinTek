{{--
 * Company: CETAM
 * Project: ST
 * File: tramites-disponibles.blade.php
 * Created on: 04/11/2025
 * Created by: Alfonso Angel García Hernández
 * Approved by: Alfonso Angel García Hernández
 *
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
--}}
<div>
    {{-- Page Header --}}
    <div class="py-4">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item">
                    <a href="#">
                        <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Nuevo trámite</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Catálogo de trámites</h1>
                <p class="mb-0">Selecciona el trámite que deseas iniciar</p>
            </div>
        </div>
    </div>

    {{-- Info alert --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-info d-flex align-items-center" role="alert">
                <svg class="icon icon-sm me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <strong>Información importante:</strong> Antes de iniciar un trámite, asegúrate de tener toda la documentación necesaria. Puedes consultar los requisitos en cada trámite.
                </div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5 mb-3 mb-md-0">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                                    </svg>
                                </span>
                                <input type="text" class="form-control" placeholder="Buscar trámite...">
                            </div>
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0">
                            <select class="form-select" id="filter_categoria">
                                <option value="" selected>Todas las categorías</option>
                                <option value="personal">Gestión personal</option>
                                <option value="administrativo">Administrativo</option>
                                <option value="laboral">Laboral</option>
                                <option value="academico">Académico</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-outline-gray-600 w-100">
                                <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"></path>
                                </svg>
                                Limpiar filtros
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tramites catalog --}}
    <div class="row">
        {{-- Tramite 1: Solicitud de vacaciones --}}
        <div class="col-12 col-md-6 col-lg-4 mb-4">
            <div class="card border-0 shadow h-100">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape icon-sm icon-shape-primary rounded me-3">
                            <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <h3 class="h6 mb-0">Solicitud de vacaciones</h3>
                    </div>
                    <span class="badge bg-primary">Disponible</span>
                </div>
                <div class="card-body">
                    <p class="text-gray-700 small mb-3">Solicita tus días de vacaciones especificando el periodo y motivo. Se requiere aprobación del jefe inmediato.</p>
                    <div class="mb-3">
                        <small class="text-gray-600 fw-bold d-block mb-1">Tiempo estimado:</small>
                        <small class="text-gray-600">3-5 días hábiles</small>
                    </div>
                    <div class="mb-3">
                        <small class="text-gray-600 fw-bold d-block mb-1">Documentos requeridos:</small>
                        <ul class="small text-gray-600 mb-0 ps-3">
                            <li>Formato de solicitud firmado</li>
                            <li>Comprobante de antigüedad</li>
                        </ul>
                    </div>
                </div>
                <div class="card-footer border-top d-grid">
                    <a href="#" class="btn btn-primary">
                        <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"></path>
                        </svg>
                        Iniciar trámite
                    </a>
                </div>
            </div>
        </div>

        {{-- Tramite 2: Solicitud de permiso --}}
        <div class="col-12 col-md-6 col-lg-4 mb-4">
            <div class="card border-0 shadow h-100">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape icon-sm icon-shape-success rounded me-3">
                            <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <h3 class="h6 mb-0">Solicitud de permiso</h3>
                    </div>
                    <span class="badge bg-primary">Disponible</span>
                </div>
                <div class="card-body">
                    <p class="text-gray-700 small mb-3">Solicita permiso para ausentarte de tus labores por motivos personales, médicos o familiares.</p>
                    <div class="mb-3">
                        <small class="text-gray-600 fw-bold d-block mb-1">Tiempo estimado:</small>
                        <small class="text-gray-600">1-2 días hábiles</small>
                    </div>
                    <div class="mb-3">
                        <small class="text-gray-600 fw-bold d-block mb-1">Documentos requeridos:</small>
                        <ul class="small text-gray-600 mb-0 ps-3">
                            <li>Formato de solicitud</li>
                            <li>Justificante (si aplica)</li>
                        </ul>
                    </div>
                </div>
                <div class="card-footer border-top d-grid">
                    <a href="#" class="btn btn-primary">
                        <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"></path>
                        </svg>
                        Iniciar trámite
                    </a>
                </div>
            </div>
        </div>

        {{-- Tramite 3: Cambio de adscripción --}}
        <div class="col-12 col-md-6 col-lg-4 mb-4">
            <div class="card border-0 shadow h-100">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape icon-sm icon-shape-warning rounded me-3">
                            <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V8a2 2 0 00-2-2h-5L9 4H4zm7 5a1 1 0 10-2 0v1H8a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <h3 class="h6 mb-0">Cambio de adscripción</h3>
                    </div>
                    <span class="badge bg-primary">Disponible</span>
                </div>
                <div class="card-body">
                    <p class="text-gray-700 small mb-3">Solicita cambio de área o departamento de adscripción. Requiere justificación y aprobación de ambas áreas.</p>
                    <div class="mb-3">
                        <small class="text-gray-600 fw-bold d-block mb-1">Tiempo estimado:</small>
                        <small class="text-gray-600">7-10 días hábiles</small>
                    </div>
                    <div class="mb-3">
                        <small class="text-gray-600 fw-bold d-block mb-1">Documentos requeridos:</small>
                        <ul class="small text-gray-600 mb-0 ps-3">
                            <li>Solicitud formal</li>
                            <li>Carta de motivos</li>
                            <li>Aceptación del área destino</li>
                        </ul>
                    </div>
                </div>
                <div class="card-footer border-top d-grid">
                    <a href="#" class="btn btn-primary">
                        <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"></path>
                        </svg>
                        Iniciar trámite
                    </a>
                </div>
            </div>
        </div>

        {{-- Tramite 4: Registro de incapacidad --}}
        <div class="col-12 col-md-6 col-lg-4 mb-4">
            <div class="card border-0 shadow h-100">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape icon-sm icon-shape-danger rounded me-3">
                            <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <h3 class="h6 mb-0">Registro de incapacidad</h3>
                    </div>
                    <span class="badge bg-primary">Disponible</span>
                </div>
                <div class="card-body">
                    <p class="text-gray-700 small mb-3">Registra tu incapacidad médica emitida por el IMSS o institución de salud autorizada.</p>
                    <div class="mb-3">
                        <small class="text-gray-600 fw-bold d-block mb-1">Tiempo estimado:</small>
                        <small class="text-gray-600">2-3 días hábiles</small>
                    </div>
                    <div class="mb-3">
                        <small class="text-gray-600 fw-bold d-block mb-1">Documentos requeridos:</small>
                        <ul class="small text-gray-600 mb-0 ps-3">
                            <li>Certificado de incapacidad</li>
                            <li>Formato de registro</li>
                        </ul>
                    </div>
                </div>
                <div class="card-footer border-top d-grid">
                    <a href="#" class="btn btn-primary">
                        <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"></path>
                        </svg>
                        Iniciar trámite
                    </a>
                </div>
            </div>
        </div>

        {{-- Tramite 5: Solicitud de beca --}}
        <div class="col-12 col-md-6 col-lg-4 mb-4">
            <div class="card border-0 shadow h-100">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape icon-sm icon-shape-info rounded me-3">
                            <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"></path>
                            </svg>
                        </div>
                        <h3 class="h6 mb-0">Solicitud de beca</h3>
                    </div>
                    <span class="badge badge-category">Temporada</span>
                </div>
                <div class="card-body">
                    <p class="text-gray-700 small mb-3">Solicita apoyo económico para estudios de nivel superior, posgrado o capacitación especializada.</p>
                    <div class="mb-3">
                        <small class="text-gray-600 fw-bold d-block mb-1">Tiempo estimado:</small>
                        <small class="text-gray-600">15-20 días hábiles</small>
                    </div>
                    <div class="mb-3">
                        <small class="text-gray-600 fw-bold d-block mb-1">Documentos requeridos:</small>
                        <ul class="small text-gray-600 mb-0 ps-3">
                            <li>Solicitud formal</li>
                            <li>Carta de motivos</li>
                            <li>Comprobante de inscripción</li>
                            <li>Plan de estudios</li>
                        </ul>
                    </div>
                </div>
                <div class="card-footer border-top d-grid">
                    <a href="#" class="btn btn-primary">
                        <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"></path>
                        </svg>
                        Iniciar trámite
                    </a>
                </div>
            </div>
        </div>

        {{-- Tramite 6: Solicitud de promoción --}}
        <div class="col-12 col-md-6 col-lg-4 mb-4">
            <div class="card border-0 shadow h-100">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape icon-sm icon-shape-secondary rounded me-3">
                            <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11 4a1 1 0 10-2 0v4a1 1 0 102 0V7zm-3 1a1 1 0 10-2 0v3a1 1 0 102 0V8zM8 9a1 1 0 00-2 0v2a1 1 0 102 0V9z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <h3 class="h6 mb-0">Solicitud de promoción</h3>
                    </div>
                    <span class="badge badge-category">Temporada</span>
                </div>
                <div class="card-body">
                    <p class="text-gray-700 small mb-3">Solicita evaluación para promoción de nivel o categoría según convocatoria vigente.</p>
                    <div class="mb-3">
                        <small class="text-gray-600 fw-bold d-block mb-1">Tiempo estimado:</small>
                        <small class="text-gray-600">20-30 días hábiles</small>
                    </div>
                    <div class="mb-3">
                        <small class="text-gray-600 fw-bold d-block mb-1">Documentos requeridos:</small>
                        <ul class="small text-gray-600 mb-0 ps-3">
                            <li>Solicitud de promoción</li>
                            <li>CV actualizado</li>
                            <li>Constancia de antigüedad</li>
                            <li>Evaluaciones de desempeño</li>
                        </ul>
                    </div>
                </div>
                <div class="card-footer border-top d-grid">
                    <a href="#" class="btn btn-primary">
                        <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"></path>
                        </svg>
                        Iniciar trámite
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Help section --}}
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape icon-md icon-shape-primary rounded me-3">
                            <svg class="icon icon-sm" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="flex-grow-1">
                            <h3 class="h6 mb-1">¿Necesitas ayuda?</h3>
                            <p class="mb-0 text-gray-600 small">Si tienes dudas sobre algún trámite, consulta nuestras <a href="#" class="text-primary fw-bold">preguntas frecuentes</a> o contacta al área de Recursos Humanos.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
