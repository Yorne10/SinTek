{{--
 * Company: CETAM
 * Project: ST
 * File: reportes.blade.php
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
                        @icon('nav.home', 'fa-xs')
                    </a>
                </li>
                <li class="breadcrumb-item"><a href="#">Secretaría</a></li>
                <li class="breadcrumb-item active" aria-current="page">Reportes</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Reportes y estadísticas</h1>
                <p class="mb-0">Panel de métricas y generación de reportes del sistema</p>
            </div>
            <div>
                <button type="button" class="btn btn-sm btn-outline-gray-600 d-inline-flex align-items-center me-2">
                    <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                    </svg>
                    Filtrar por fecha
                </button>
                <button type="button" class="btn btn-sm btn-primary d-inline-flex align-items-center">
                    <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                    Exportar reporte
                </button>
            </div>
        </div>
    </div>

    {{-- Statistics Overview --}}
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
                                <h2 class="h6 text-gray-400 mb-0">Total trámites</h2>
                                <h3 class="fw-extrabold mb-2">247</h3>
                                <small class="text-gray-500">
                                    <svg class="icon icon-xs text-success" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    12.5% vs mes anterior
                                </small>
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
                                <h3 class="fw-extrabold mb-2">89</h3>
                                <small class="text-gray-500">
                                    <svg class="icon icon-xs text-danger" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    3.2% vs mes anterior
                                </small>
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
                                <h3 class="fw-extrabold mb-2">142</h3>
                                <small class="text-gray-500">
                                    <svg class="icon icon-xs text-success" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    18.3% vs mes anterior
                                </small>
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
                            <div class="icon-shape icon-shape-danger rounded me-4 me-sm-0">
                                <svg class="icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="col-12 col-xl-7 px-xl-0">
                            <div class="d-none d-sm-block">
                                <h2 class="h6 text-gray-400 mb-0">Rechazados</h2>
                                <h3 class="fw-extrabold mb-2">16</h3>
                                <small class="text-gray-500">
                                    <svg class="icon icon-xs text-danger" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    5.8% vs mes anterior
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Report filters --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow">
                <div class="card-header border-bottom">
                    <h2 class="fs-5 fw-bold mb-0">Filtros de reporte</h2>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="filter_periodo" class="form-label">Periodo</label>
                                <select class="form-select" id="filter_periodo">
                                    <option value="hoy">Hoy</option>
                                    <option value="semana">Esta semana</option>
                                    <option value="mes" selected>Este mes</option>
                                    <option value="trimestre">Este trimestre</option>
                                    <option value="anio">Este año</option>
                                    <option value="personalizado">Personalizado</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="filter_tipo_tramite" class="form-label">Tipo de trámite</label>
                                <select class="form-select" id="filter_tipo_tramite">
                                    <option value="" selected>Todos</option>
                                    <option value="vacaciones">Solicitud de vacaciones</option>
                                    <option value="permiso">Permiso</option>
                                    <option value="incapacidad">Incapacidad</option>
                                    <option value="cambio_adscripcion">Cambio de adscripción</option>
                                    <option value="promocion">Promoción</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="filter_departamento" class="form-label">Departamento</label>
                                <select class="form-select" id="filter_departamento">
                                    <option value="" selected>Todos</option>
                                    <option value="rh">Recursos Humanos</option>
                                    <option value="ti">Tecnologías de la Información</option>
                                    <option value="admin">Administrativo</option>
                                    <option value="juridico">Jurídico</option>
                                    <option value="contabilidad">Contabilidad</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="filter_estado" class="form-label">Estado</label>
                                <select class="form-select" id="filter_estado">
                                    <option value="" selected>Todos</option>
                                    <option value="pendiente">Pendiente</option>
                                    <option value="proceso">En proceso</option>
                                    <option value="completado">Completado</option>
                                    <option value="rechazado">Rechazado</option>
                                </select>
                            </div>
                            <div class="col-md-12 d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-outline-gray-600">
                                    <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"></path>
                                    </svg>
                                    Limpiar filtros
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                                    </svg>
                                    Aplicar filtros
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Trámites por tipo --}}
    <div class="row mb-4">
        <div class="col-12 col-lg-6 mb-4 mb-lg-0">
            <div class="card border-0 shadow h-100">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <h2 class="fs-5 fw-bold mb-0">Trámites por tipo</h2>
                    <button type="button" class="btn btn-sm btn-link text-gray-600 p-0">
                        <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <div class="card-body">
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="icon-shape icon-sm icon-shape-primary rounded me-3">
                                <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="mb-0 fw-bold">Solicitud de vacaciones</p>
                                <small class="text-gray-500">95 trámites</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <span class="fw-bold text-gray-900">38.5%</span>
                        </div>
                    </div>
                    <div class="progress mb-3" style="height: 8px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 38.5%" aria-valuenow="38.5" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>

                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="icon-shape icon-sm icon-shape-success rounded me-3">
                                <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="mb-0 fw-bold">Permiso</p>
                                <small class="text-gray-500">62 trámites</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <span class="fw-bold text-gray-900">25.1%</span>
                        </div>
                    </div>
                    <div class="progress mb-3" style="height: 8px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 25.1%" aria-valuenow="25.1" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>

                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="icon-shape icon-sm icon-shape-warning rounded me-3">
                                <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="mb-0 fw-bold">Incapacidad</p>
                                <small class="text-gray-500">45 trámites</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <span class="fw-bold text-gray-900">18.2%</span>
                        </div>
                    </div>
                    <div class="progress mb-3" style="height: 8px;">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 18.2%" aria-valuenow="18.2" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>

                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="icon-shape icon-sm icon-shape-info rounded me-3">
                                <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="mb-0 fw-bold">Cambio de adscripción</p>
                                <small class="text-gray-500">28 trámites</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <span class="fw-bold text-gray-900">11.3%</span>
                        </div>
                    </div>
                    <div class="progress mb-3" style="height: 8px;">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 11.3%" aria-valuenow="11.3" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>

                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="icon-shape icon-sm icon-shape-secondary rounded me-3">
                                <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="mb-0 fw-bold">Otros</p>
                                <small class="text-gray-500">17 trámites</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <span class="fw-bold text-gray-900">6.9%</span>
                        </div>
                    </div>
                    <div class="progress mb-0" style="height: 8px;">
                        <div class="progress-bar bg-secondary" role="progressbar" style="width: 6.9%" aria-valuenow="6.9" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tiempo promedio de resolución --}}
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow h-100">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <h2 class="fs-5 fw-bold mb-0">Tiempo promedio de resolución</h2>
                    <button type="button" class="btn btn-sm btn-link text-gray-600 p-0">
                        <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                            <div>
                                <h3 class="h6 mb-1">Solicitud de vacaciones</h3>
                                <p class="small text-gray-500 mb-0">Meta: 3 días</p>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-success">2.5 días</span>
                            </div>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                            <div>
                                <h3 class="h6 mb-1">Permiso</h3>
                                <p class="small text-gray-500 mb-0">Meta: 1 día</p>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-success">0.8 días</span>
                            </div>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                            <div>
                                <h3 class="h6 mb-1">Incapacidad</h3>
                                <p class="small text-gray-500 mb-0">Meta: 2 días</p>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-warning">2.3 días</span>
                            </div>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                            <div>
                                <h3 class="h6 mb-1">Cambio de adscripción</h3>
                                <p class="small text-gray-500 mb-0">Meta: 7 días</p>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-danger">8.5 días</span>
                            </div>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                            <div>
                                <h3 class="h6 mb-1">Promoción</h3>
                                <p class="small text-gray-500 mb-0">Meta: 15 días</p>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-success">12.2 días</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Detailed table --}}
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fs-5 fw-bold mb-0">Detalle de trámites por periodo</h2>
                        <p class="small text-gray-500 mb-0 mt-1">Resumen mensual del año en curso</p>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-primary">
                        <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        Exportar Excel
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table table-centered table-nowrap mb-0 rounded">
                        <thead class="thead-light">
                            <tr>
                                <th class="border-0">Mes</th>
                                <th class="border-0">Total</th>
                                <th class="border-0">Pendientes</th>
                                <th class="border-0">En proceso</th>
                                <th class="border-0">Completados</th>
                                <th class="border-0">Rechazados</th>
                                <th class="border-0">Tasa de éxito</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-bold">Noviembre 2025</td>
                                <td>78</td>
                                <td>12</td>
                                <td>23</td>
                                <td>40</td>
                                <td>3</td>
                                <td>
                                    <span class="badge bg-success">93.0%</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Octubre 2025</td>
                                <td>92</td>
                                <td>0</td>
                                <td>0</td>
                                <td>85</td>
                                <td>7</td>
                                <td>
                                    <span class="badge bg-success">92.4%</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Septiembre 2025</td>
                                <td>85</td>
                                <td>0</td>
                                <td>0</td>
                                <td>79</td>
                                <td>6</td>
                                <td>
                                    <span class="badge bg-success">92.9%</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Agosto 2025</td>
                                <td>105</td>
                                <td>0</td>
                                <td>0</td>
                                <td>98</td>
                                <td>7</td>
                                <td>
                                    <span class="badge bg-success">93.3%</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Julio 2025</td>
                                <td>118</td>
                                <td>0</td>
                                <td>0</td>
                                <td>108</td>
                                <td>10</td>
                                <td>
                                    <span class="badge bg-success">91.5%</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Junio 2025</td>
                                <td>95</td>
                                <td>0</td>
                                <td>0</td>
                                <td>88</td>
                                <td>7</td>
                                <td>
                                    <span class="badge bg-success">92.6%</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer px-3 border-0 d-flex justify-content-between align-items-center">
                    <div class="fw-normal small">Mostrando <b>6</b> de <b>11</b> meses</div>
                    <a href="#" class="btn btn-sm btn-link text-primary">Ver todos los meses</a>
                </div>
            </div>
        </div>
    </div>
</div>
