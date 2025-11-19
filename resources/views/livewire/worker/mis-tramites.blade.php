{{--
 * Company: CETAM
 * Project: ST
 * File: mis-tramites.blade.php
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
                <li class="breadcrumb-item active" aria-current="page">Mis trámites</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Bandeja de entrada</h1>
                <p class="mb-0">Consulta el estado de todas tus solicitudes y trámites</p>
            </div>
            <div>
                <a href="#" class="btn btn-sm btn-primary d-inline-flex align-items-center">
                    <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"></path>
                    </svg>
                    Nuevo trámite
                </a>
            </div>
        </div>
    </div>

    {{-- Alerts for pending actions --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-warning d-flex align-items-center" role="alert">
                <svg class="icon icon-sm me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <strong>Atención requerida:</strong> Tienes 2 trámites con documentación pendiente. Revisa los detalles.
                </div>
            </div>
        </div>
    </div>

    {{-- Statistics cards --}}
    <div class="row mb-4">
        <div class="col-12 col-sm-6 col-xl-3 mb-4">
            <div class="card border-0 shadow h-100">
                <div class="card-body">
                    <div class="row d-block d-xl-flex align-items-center">
                        <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                            <div class="icon-shape icon-shape-primary rounded me-4 me-sm-0">
                                <svg class="icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="col-12 col-xl-7 px-xl-0">
                            <div class="d-none d-sm-block">
                                <h2 class="h6 text-gray-400 mb-0">Total</h2>
                                <h3 class="fw-extrabold mb-2">8</h3>
                                <small class="text-gray-500">Trámites totales</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3 mb-4">
            <div class="card border-0 shadow h-100">
                <div class="card-body">
                    <div class="row d-block d-xl-flex align-items-center">
                        <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                            <div class="icon-shape icon-shape-warning rounded me-4 me-sm-0">
                                <svg class="icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="col-12 col-xl-7 px-xl-0">
                            <div class="d-none d-sm-block">
                                <h2 class="h6 text-gray-400 mb-0">En proceso</h2>
                                <h3 class="fw-extrabold mb-2">3</h3>
                                <small class="text-gray-500">En revisión</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3 mb-4">
            <div class="card border-0 shadow h-100">
                <div class="card-body">
                    <div class="row d-block d-xl-flex align-items-center">
                        <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                            <div class="icon-shape icon-shape-success rounded me-4 me-sm-0">
                                <svg class="icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="col-12 col-xl-7 px-xl-0">
                            <div class="d-none d-sm-block">
                                <h2 class="h6 text-gray-400 mb-0">Completados</h2>
                                <h3 class="fw-extrabold mb-2">4</h3>
                                <small class="text-gray-500">Finalizados</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3 mb-4">
            <div class="card border-0 shadow h-100">
                <div class="card-body">
                    <div class="row d-block d-xl-flex align-items-center">
                        <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                            <div class="icon-shape icon-shape-info rounded me-4 me-sm-0">
                                <svg class="icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="col-12 col-xl-7 px-xl-0">
                            <div class="d-none d-sm-block">
                                <h2 class="h6 text-gray-400 mb-0">Notificaciones</h2>
                                <h3 class="fw-extrabold mb-2">5</h3>
                                <small class="text-gray-500">Sin leer</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent notifications --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <h2 class="fs-5 fw-bold mb-0">Notificaciones recientes</h2>
                    <a href="#" class="btn btn-sm btn-link">Ver todas</a>
                </div>
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex align-items-center">
                        <div class="icon-shape icon-sm icon-shape-warning rounded me-3">
                            <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="flex-grow-1">
                            <p class="mb-0 fw-bold small">Documentación faltante en solicitud #SV-2025-0102</p>
                            <small class="text-gray-500">Hace 2 horas</small>
                        </div>
                        <span class="badge bg-warning">Acción requerida</span>
                    </div>
                    <div class="list-group-item d-flex align-items-center">
                        <div class="icon-shape icon-sm icon-shape-success rounded me-3">
                            <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="flex-grow-1">
                            <p class="mb-0 fw-bold small">Tu solicitud #SV-2025-0098 ha sido aprobada</p>
                            <small class="text-gray-500">Hace 5 horas</small>
                        </div>
                        <span class="badge bg-success">Aprobada</span>
                    </div>
                    <div class="list-group-item d-flex align-items-center">
                        <div class="icon-shape icon-sm icon-shape-info rounded me-3">
                            <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="flex-grow-1">
                            <p class="mb-0 fw-bold small">Nuevo comentario en tu solicitud #SV-2025-0096</p>
                            <small class="text-gray-500">Ayer</small>
                        </div>
                        <span class="badge badge-new">Nuevo</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters and search --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                                    </svg>
                                </span>
                                <input type="text" class="form-control" placeholder="Buscar por folio o tipo de trámite...">
                            </div>
                        </div>
                        <div class="col-md-3 mb-3 mb-md-0">
                            <select class="form-select" id="filter_estado">
                                <option value="" selected>Todos los estados</option>
                                <option value="nuevo">Nuevo</option>
                                <option value="proceso">En proceso</option>
                                <option value="completado">Completado</option>
                                <option value="rechazado">Rechazado</option>
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

    {{-- Tramites list --}}
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <h2 class="fs-5 fw-bold mb-0">Mis trámites</h2>
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-outline-gray-600 active">Todos</button>
                        <button type="button" class="btn btn-sm btn-outline-gray-600">Activos</button>
                        <button type="button" class="btn btn-sm btn-outline-gray-600">Histórico</button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-centered table-nowrap mb-0 rounded">
                        <thead class="thead-light">
                            <tr>
                                <th class="border-0">Folio</th>
                                <th class="border-0">Tipo de trámite</th>
                                <th class="border-0">Fecha inicio</th>
                                <th class="border-0">Estado</th>
                                <th class="border-0">Progreso</th>
                                <th class="border-0">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Tramite 1 - En proceso con acción requerida --}}
                            <tr>
                                <td class="fw-bold">#SV-2025-0102</td>
                                <td>Solicitud de vacaciones</td>
                                <td>02/11/2025</td>
                                <td>
                                    <span class="badge badge-in-process">En proceso</span>
                                    <span class="badge bg-warning ms-1">Acción requerida</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="me-2 small">2/5</span>
                                        <div class="progress w-100" style="height: 8px;">
                                            <div class="progress-bar bg-warning" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-primary">
                                        <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        Ver detalle
                                    </a>
                                </td>
                            </tr>

                            {{-- Tramite 2 - En proceso --}}
                            <tr>
                                <td class="fw-bold">#SP-2025-0099</td>
                                <td>Solicitud de permiso</td>
                                <td>01/11/2025</td>
                                <td><span class="badge bg-info">En revisión</span></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="me-2 small">3/4</span>
                                        <div class="progress w-100" style="height: 8px;">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-outline-primary">
                                        <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        Ver detalle
                                    </a>
                                </td>
                            </tr>

                            {{-- Tramite 3 - Completado --}}
                            <tr>
                                <td class="fw-bold">#SV-2025-0098</td>
                                <td>Solicitud de vacaciones</td>
                                <td>28/10/2025</td>
                                <td><span class="badge bg-success">Completado</span></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="me-2 small">5/5</span>
                                        <div class="progress w-100" style="height: 8px;">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-outline-gray-600">
                                        <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        Ver detalle
                                    </a>
                                </td>
                            </tr>

                            {{-- Tramite 4 - En proceso con documentación --}}
                            <tr>
                                <td class="fw-bold">#SC-2025-0096</td>
                                <td>Cambio de adscripción</td>
                                <td>25/10/2025</td>
                                <td>
                                    <span class="badge badge-in-process">En proceso</span>
                                    <span class="badge bg-warning ms-1">Documentación pendiente</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="me-2 small">1/6</span>
                                        <div class="progress w-100" style="height: 8px;">
                                            <div class="progress-bar bg-warning" role="progressbar" style="width: 17%" aria-valuenow="17" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-primary">
                                        <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        Ver detalle
                                    </a>
                                </td>
                            </tr>

                            {{-- Tramite 5 - Completado --}}
                            <tr>
                                <td class="fw-bold">#SP-2025-0089</td>
                                <td>Solicitud de permiso</td>
                                <td>20/10/2025</td>
                                <td><span class="badge bg-success">Completado</span></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="me-2 small">4/4</span>
                                        <div class="progress w-100" style="height: 8px;">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-outline-gray-600">
                                        <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        Ver detalle
                                    </a>
                                </td>
                            </tr>

                            {{-- Tramite 6 - Completado --}}
                            <tr>
                                <td class="fw-bold">#SV-2025-0085</td>
                                <td>Solicitud de vacaciones</td>
                                <td>15/10/2025</td>
                                <td><span class="badge bg-success">Completado</span></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="me-2 small">5/5</span>
                                        <div class="progress w-100" style="height: 8px;">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-outline-gray-600">
                                        <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        Ver detalle
                                    </a>
                                </td>
                            </tr>

                            {{-- Tramite 7 - Rechazado --}}
                            <tr>
                                <td class="fw-bold">#SP-2025-0082</td>
                                <td>Solicitud de permiso</td>
                                <td>10/10/2025</td>
                                <td><span class="badge bg-danger">Rechazado</span></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="me-2 small">1/4</span>
                                        <div class="progress w-100" style="height: 8px;">
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-outline-gray-600">
                                        <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        Ver detalle
                                    </a>
                                </td>
                            </tr>

                            {{-- Tramite 8 - Completado --}}
                            <tr>
                                <td class="fw-bold">#SV-2025-0078</td>
                                <td>Solicitud de vacaciones</td>
                                <td>05/10/2025</td>
                                <td><span class="badge bg-success">Completado</span></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="me-2 small">5/5</span>
                                        <div class="progress w-100" style="height: 8px;">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-outline-gray-600">
                                        <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        Ver detalle
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination mb-0">
                            <li class="page-item">
                                <a class="page-link" href="#">Anterior</a>
                            </li>
                            <li class="page-item active">
                                <a class="page-link" href="#">1</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">2</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">Siguiente</a>
                            </li>
                        </ul>
                    </nav>
                    <div class="fw-normal small mt-4 mt-lg-0">Mostrando <b>8</b> de <b>8</b> trámites</div>
                </div>
            </div>
        </div>
    </div>
</div>
