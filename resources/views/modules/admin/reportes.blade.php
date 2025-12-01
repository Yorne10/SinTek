{{--
Company: CETAM
Project: ST
File: reportes.blade.php
Created on: 04/11/2025
Created by: Alfonso Angel Garcia Hernandez
Approved by: Alfonso Angel Garcia Hernandez

Changelog:
- ID: <ID> | Date: dd/mm/yyyy
    Modified by: <Developer name>
        Description: <Brief description of change>
            --}}

            {{-- Nota Livewire: esta vista debe tener UN nico elemento raz --}}
            {{-- El layout se aplica desde el componente con ->layout('layouts.app') --}}

            <div>
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
                    <div class="d-block mb-4 mb-md-0">
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                                <li class="breadcrumb-item">
                                    <a
                                        href="{{ route(config('proj.route_name_prefix', 'proj') . '.dashboard.index') }}">
                                        @icon('nav.home', 'fa-xs')
                                    </a>
                                </li>
                                <li class="breadcrumb-item">Administracin</li>
                                <li class="breadcrumb-item active" aria-current="page">Reportes globales</li>
                            </ol>
                        </nav>
                        <h2 class="h4">Reportes globales</h2>
                        <p class="mb-0">Analiza mtricas y estadsticas del sistema.</p>
                    </div>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <button type="button" class="btn btn-sm btn-gray-800 d-inline-flex align-items-center me-2">
                            <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Exportar PDF
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-gray-600 d-inline-flex align-items-center">
                            <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Exportar Excel
                        </button>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label for="report_period" class="form-label">Periodo</label>
                        <select class="form-select" id="report_period">
                            <option value="today">Hoy</option>
                            <option value="week">Esta semana</option>
                            <option value="month" selected>Este mes</option>
                            <option value="quarter">Este trimestre</option>
                            <option value="year">Este ao</option>
                            <option value="custom">Personalizado</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label for="date_from" class="form-label">Desde</label>
                        <input type="date" class="form-control" id="date_from" value="2025-10-01">
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label for="date_to" class="form-label">Hasta</label>
                        <input type="date" class="form-control" id="date_to" value="2025-11-04">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">&nbsp;</label>
                        <button type="button" class="btn btn-primary w-100">
                            <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Actualizar
                        </button>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12 col-sm-6 col-xl-3 mb-4">
                        <div class="card border-0 shadow h-100">
                            <div class="card-body">
                                <div class="row d-block d-xl-flex align-items-center">
                                    <div
                                        class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                                        <div class="icon-shape icon-shape-primary rounded me-4 me-sm-0">
                                            <svg class="icon" fill="currentColor" viewBox="0 0 20 20"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                                                <path fill-rule="evenodd"
                                                    d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="col-12 col-xl-7 px-xl-0">
                                        <div class="d-none d-sm-block">
                                            <h2 class="h6 text-gray-400 mb-0">Total trámites</h2>
                                            <h3 class="fw-extrabold mb-2">1,247</h3>
                                            <small class="text-success">
                                                <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd"
                                                        d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                18.2% vs mes anterior
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
                                    <div
                                        class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                                        <div class="icon-shape icon-shape-success rounded me-4 me-sm-0">
                                            <svg class="icon" fill="currentColor" viewBox="0 0 20 20"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="col-12 col-xl-7 px-xl-0">
                                        <div class="d-none d-sm-block">
                                            <h2 class="h6 text-gray-400 mb-0">Completados</h2>
                                            <h3 class="fw-extrabold mb-2">892</h3>
                                            <small class="text-gray-500">
                                                71.5% del total
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
                                    <div
                                        class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                                        <div class="icon-shape icon-shape-warning rounded me-4 me-sm-0">
                                            <svg class="icon" fill="currentColor" viewBox="0 0 20 20"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="col-12 col-xl-7 px-xl-0">
                                        <div class="d-none d-sm-block">
                                            <h2 class="h6 text-gray-400 mb-0">En proceso</h2>
                                            <h3 class="fw-extrabold mb-2">287</h3>
                                            <small class="text-gray-500">
                                                23.0% del total
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
                                    <div
                                        class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                                        <div class="icon-shape icon-shape-info rounded me-4 me-sm-0">
                                            <svg class="icon" fill="currentColor" viewBox="0 0 20 20"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="col-12 col-xl-7 px-xl-0">
                                        <div class="d-none d-sm-block">
                                            <h2 class="h6 text-gray-400 mb-0">Tiempo promedio</h2>
                                            <h3 class="fw-extrabold mb-2">7.3 das</h3>
                                            <small class="text-danger">
                                                <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd"
                                                        d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd"></path>
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

                <div class="row">
                    <div class="col-12 col-xl-8 mb-4">
                        <div class="card border-0 shadow">
                            <div class="card-header border-bottom">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h2 class="fs-5 fw-bold mb-0">Trámites por periodo</h2>
                                    </div>
                                    <div class="col text-end">
                                        <select class="form-select form-select-sm w-auto d-inline-block">
                                            <option value="week">ltima semana</option>
                                            <option value="month" selected>ltimo mes</option>
                                            <option value="quarter">ltimo trimestre</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-centered table-nowrap mb-0 rounded">
                                        <thead class="thead-light">
                                            <tr>
                                                <th class="border-0">Semana</th>
                                                <th class="border-0">Iniciados</th>
                                                <th class="border-0">Completados</th>
                                                <th class="border-0">En proceso</th>
                                                <th class="border-0">Rechazados</th>
                                                <th class="border-0">Tasa de xito</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="fw-bold">Semana 1</td>
                                                <td>87</td>
                                                <td><span class="badge bg-success">76</span></td>
                                                <td><span class="badge bg-warning">8</span></td>
                                                <td><span class="badge bg-danger">3</span></td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <span class="me-2">87.4%</span>
                                                        <div class="progress w-100" style="height: 8px;">
                                                            <div class="progress-bar bg-success" role="progressbar"
                                                                style="width: 87.4%" aria-valuenow="87.4"
                                                                aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Semana 2</td>
                                                <td>102</td>
                                                <td><span class="badge bg-success">89</span></td>
                                                <td><span class="badge bg-warning">10</span></td>
                                                <td><span class="badge bg-danger">3</span></td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <span class="me-2">87.3%</span>
                                                        <div class="progress w-100" style="height: 8px;">
                                                            <div class="progress-bar bg-success" role="progressbar"
                                                                style="width: 87.3%" aria-valuenow="87.3"
                                                                aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Semana 3</td>
                                                <td>94</td>
                                                <td><span class="badge bg-success">81</span></td>
                                                <td><span class="badge bg-warning">9</span></td>
                                                <td><span class="badge bg-danger">4</span></td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <span class="me-2">86.2%</span>
                                                        <div class="progress w-100" style="height: 8px;">
                                                            <div class="progress-bar bg-success" role="progressbar"
                                                                style="width: 86.2%" aria-valuenow="86.2"
                                                                aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Semana 4</td>
                                                <td>76</td>
                                                <td><span class="badge bg-success">65</span></td>
                                                <td><span class="badge bg-warning">7</span></td>
                                                <td><span class="badge bg-danger">4</span></td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <span class="me-2">85.5%</span>
                                                        <div class="progress w-100" style="height: 8px;">
                                                            <div class="progress-bar bg-success" role="progressbar"
                                                                style="width: 85.5%" aria-valuenow="85.5"
                                                                aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-xl-4 mb-4">
                        <div class="card border-0 shadow h-100">
                            <div class="card-header border-bottom">
                                <h2 class="fs-5 fw-bold mb-0">Procesos ms utilizados</h2>
                            </div>
                            <div class="card-body">
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="small">Solicitud de vacaciones</span>
                                        <span class="small fw-bold">342</span>
                                    </div>
                                    <div class="progress" style="height: 10px;">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 85%"
                                            aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="small">Reembolso de gastos</span>
                                        <span class="small fw-bold">278</span>
                                    </div>
                                    <div class="progress" style="height: 10px;">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 69%"
                                            aria-valuenow="69" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="small">Permiso de ausencia</span>
                                        <span class="small fw-bold">189</span>
                                    </div>
                                    <div class="progress" style="height: 10px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 47%"
                                            aria-valuenow="47" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="small">Solicitud de horas extras</span>
                                        <span class="small fw-bold">156</span>
                                    </div>
                                    <div class="progress" style="height: 10px;">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 39%"
                                            aria-valuenow="39" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="small">Cambio de puesto</span>
                                        <span class="small fw-bold">82</span>
                                    </div>
                                    <div class="progress" style="height: 10px;">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 20%"
                                            aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-xl-6 mb-4">
                        <div class="card border-0 shadow">
                            <div class="card-header border-bottom">
                                <h2 class="fs-5 fw-bold mb-0">Tiempos de respuesta por proceso</h2>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-centered table-nowrap mb-0 rounded">
                                        <thead class="thead-light">
                                            <tr>
                                                <th class="border-0">Proceso</th>
                                                <th class="border-0">Tiempo promedio</th>
                                                <th class="border-0">Tiempo mximo</th>
                                                <th class="border-0">Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="fw-bold">Solicitud de vacaciones</td>
                                                <td>5.2 das</td>
                                                <td>15 das</td>
                                                <td><span class="badge bg-success">ptimo</span></td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Reembolso de gastos</td>
                                                <td>8.7 das</td>
                                                <td>30 das</td>
                                                <td><span class="badge bg-warning">Normal</span></td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Permiso de ausencia</td>
                                                <td>3.1 das</td>
                                                <td>7 das</td>
                                                <td><span class="badge bg-success">ptimo</span></td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Solicitud de horas extras</td>
                                                <td>12.4 das</td>
                                                <td>20 das</td>
                                                <td><span class="badge bg-danger">Lento</span></td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Cambio de puesto</td>
                                                <td>18.9 das</td>
                                                <td>45 das</td>
                                                <td><span class="badge bg-warning">Normal</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-xl-6 mb-4">
                        <div class="card border-0 shadow">
                            <div class="card-header border-bottom">
                                <h2 class="fs-5 fw-bold mb-0">Usuarios ms activos (este mes)</h2>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-centered table-nowrap mb-0 rounded">
                                        <thead class="thead-light">
                                            <tr>
                                                <th class="border-0">Usuario</th>
                                                <th class="border-0">Rol</th>
                                                <th class="border-0">Trámites</th>
                                                <th class="border-0">Completados</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img class="avatar rounded-circle me-2" alt="Avatar"
                                                            src="https://ui-avatars.com/api/?name=Maria+Lopez&background=6F42C1&color=fff">
                                                        <span class="fw-bold">María López</span>
                                                    </div>
                                                </td>
                                                <td><span class="badge bg-secondary">Secretaria</span></td>
                                                <td>67</td>
                                                <td><span class="text-success fw-bold">94%</span></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img class="avatar rounded-circle me-2" alt="Avatar"
                                                            src="https://ui-avatars.com/api/?name=Juan+Perez&background=FD7E14&color=fff">
                                                        <span class="fw-bold">Juan Pérez</span>
                                                    </div>
                                                </td>
                                                <td><span class="badge bg-primary">Trabajador</span></td>
                                                <td>54</td>
                                                <td><span class="text-success fw-bold">89%</span></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img class="avatar rounded-circle me-2" alt="Avatar"
                                                            src="https://ui-avatars.com/api/?name=Ana+Rodriguez&background=28A745&color=fff">
                                                        <span class="fw-bold">Ana Rodríguez</span>
                                                    </div>
                                                </td>
                                                <td><span class="badge bg-secondary">Secretaria</span></td>
                                                <td>48</td>
                                                <td><span class="text-success fw-bold">92%</span></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img class="avatar rounded-circle me-2" alt="Avatar"
                                                            src="https://ui-avatars.com/api/?name=Carlos+Martinez&background=DC3545&color=fff">
                                                        <span class="fw-bold">Carlos Martínez</span>
                                                    </div>
                                                </td>
                                                <td><span class="badge bg-primary">Trabajador</span></td>
                                                <td>42</td>
                                                <td><span class="text-warning fw-bold">76%</span></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img class="avatar rounded-circle me-2" alt="Avatar"
                                                            src="https://ui-avatars.com/api/?name=Luis+Sanchez&background=17A2B8&color=fff">
                                                        <span class="fw-bold">Luis Sánchez</span>
                                                    </div>
                                                </td>
                                                <td><span class="badge bg-primary">Trabajador</span></td>
                                                <td>38</td>
                                                <td><span class="text-success fw-bold">87%</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="card border-0 shadow">
                            <div class="card-header border-bottom">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h2 class="fs-5 fw-bold mb-0">Resumen mensual detallado</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-centered table-hover table-nowrap mb-0 rounded">
                                        <thead class="thead-light">
                                            <tr>
                                                <th class="border-0">Mes</th>
                                                <th class="border-0">Total trámites</th>
                                                <th class="border-0">Completados</th>
                                                <th class="border-0">En proceso</th>
                                                <th class="border-0">Rechazados</th>
                                                <th class="border-0">Tiempo promedio</th>
                                                <th class="border-0">Tasa de éxito</th>
                                                <th class="border-0">Tendencia</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="fw-bold">Noviembre 2025</td>
                                                <td>359</td>
                                                <td><span class="badge bg-success">311</span></td>
                                                <td><span class="badge bg-warning">32</span></td>
                                                <td><span class="badge bg-danger">16</span></td>
                                                <td>7.3 días</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <span class="me-2 small">86.6%</span>
                                                        <div class="progress w-100" style="height: 6px;">
                                                            <div class="progress-bar bg-success" role="progressbar"
                                                                style="width: 86.6%" aria-valuenow="86.6"
                                                                aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="text-success">
                                                        <svg class="icon icon-xs" fill="currentColor"
                                                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd"
                                                                d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                        +18%
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Octubre 2025</td>
                                                <td>304</td>
                                                <td><span class="badge bg-success">267</span></td>
                                                <td><span class="badge bg-warning">25</span></td>
                                                <td><span class="badge bg-danger">12</span></td>
                                                <td>6.9 días</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <span class="me-2 small">87.8%</span>
                                                        <div class="progress w-100" style="height: 6px;">
                                                            <div class="progress-bar bg-success" role="progressbar"
                                                                style="width: 87.8%" aria-valuenow="87.8"
                                                                aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="text-success">
                                                        <svg class="icon icon-xs" fill="currentColor"
                                                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd"
                                                                d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                        +12%
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Septiembre 2025</td>
                                                <td>271</td>
                                                <td><span class="badge bg-success">232</span></td>
                                                <td><span class="badge bg-warning">28</span></td>
                                                <td><span class="badge bg-danger">11</span></td>
                                                <td>7.1 días</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <span class="me-2 small">85.6%</span>
                                                        <div class="progress w-100" style="height: 6px;">
                                                            <div class="progress-bar bg-success" role="progressbar"
                                                                style="width: 85.6%" aria-valuenow="85.6"
                                                                aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="text-danger">
                                                        <svg class="icon icon-xs" fill="currentColor"
                                                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd"
                                                                d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                        -5%
                                                    </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>