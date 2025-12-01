{{--
    Company: CETAM
    Project: ST
    File: dashboard.blade.php
    Created on: 06/11/2025
    Created by: Alfonso Angel Garcia Hernandez
    Approved by: Alfonso Angel Garcia Hernandez

    Changelog:
    - ID: <ID> | Date: dd/mm/yyyy
      Modified by: <Developer name>
      Description: <Brief description of change>
--}}

<div>
    {{-- Breadcrumbs --}}
    <div class="py-4">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item">
                    <a href="#">
                        @icon('nav.home', 'fa-xs')
                    </a>
                </li>
                <li class="breadcrumb-item"><a href="#">Secretaría</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Panel de Secretaría</h1>
                <p class="mb-0">Gestión y validación de solicitudes de trámites.</p>
            </div>
        </div>
    </div>

    {{-- Métricas principales --}}
    <div class="row">
        {{-- Solicitudes pendientes --}}
        <div class="col-12 col-sm-6 col-xl-4 mb-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="row d-block d-xl-flex align-items-center">
                        <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                            <div class="icon-shape icon-sm rounded me-4 me-sm-0">
                                @icon('process.docs', 'fa-lg text-info')
                            </div>
                            <div class="d-sm-none">
                                <h2 class="h5">Pendientes</h2>
                                <h3 class="fw-extrabold mb-1">18</h3>
                            </div>
                        </div>
                        <div class="col-12 col-xl-7 px-xl-0">
                            <div class="d-none d-sm-block">
                                <h2 class="h6 text-gray-400 mb-0">Solicitudes Pendientes</h2>
                                <h3 class="fw-extrabold mb-2">18</h3>
                            </div>
                            <small class="d-flex align-items-center text-gray-500">
                                Requieren validación
                            </small>
                            <div class="small d-flex mt-1">
                                <span class="text-warning fw-bold">Acción requerida</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Validadas hoy --}}
        <div class="col-12 col-sm-6 col-xl-4 mb-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="row d-block d-xl-flex align-items-center">
                        <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                            <div class="icon-shape icon-sm rounded me-4 me-sm-0">
                                @icon('state.success', 'fa-lg text-info')
                            </div>
                            <div class="d-sm-none">
                                <h2 class="fw-extrabold h5">Validadas Hoy</h2>
                                <h3 class="mb-1">7</h3>
                            </div>
                        </div>
                        <div class="col-12 col-xl-7 px-xl-0">
                            <div class="d-none d-sm-block">
                                <h2 class="h6 text-gray-400 mb-0">Validadas Hoy</h2>
                                <h3 class="fw-extrabold mb-2">7</h3>
                            </div>
                            <small class="d-flex align-items-center text-gray-500">
                                Solicitudes procesadas
                            </small>
                            <div class="small d-flex mt-1">
                                <div>
                                    @icon('nav.up', 'fa-xs text-success')
                                    <span class="text-success fw-bolder">15%</span> vs. ayer
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Trabajadores activos --}}
        <div class="col-12 col-sm-6 col-xl-4 mb-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="row d-block d-xl-flex align-items-center">
                        <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                            <div class="icon-shape icon-sm rounded me-4 me-sm-0">
                                @icon('user.list', 'fa-lg text-info')
                            </div>
                            <div class="d-sm-none">
                                <h2 class="fw-extrabold h5">Trabajadores</h2>
                                <h3 class="mb-1">245</h3>
                            </div>
                        </div>
                        <div class="col-12 col-xl-7 px-xl-0">
                            <div class="d-none d-sm-block">
                                <h2 class="h6 text-gray-400 mb-0">Trabajadores Activos</h2>
                                <h3 class="fw-extrabold mb-2">245</h3>
                            </div>
                            <small class="d-flex align-items-center text-gray-500">
                                Total en el sistema
                            </small>
                            <div class="small d-flex mt-1">
                                <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.busqueda-trabajadores') }}" class="text-primary">Buscar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Acciones rápidas --}}
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card border-0 shadow">
                <div class="card-header">
                    <h2 class="fs-5 fw-bold mb-0">Acciones Rápidas</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-3 mb-3">
                            <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.panel-solicitudes') }}" class="btn btn-outline-info w-100 d-flex align-items-center justify-content-center" style="min-height: 80px;">
                                <div class="text-center">
                                    @icon('process.docs', 'fa-lg mb-2')
                                    <div class="fw-bold">Panel de Solicitudes</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3 mb-3">
                            <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.busqueda-trabajadores') }}" class="btn btn-outline-info w-100 d-flex align-items-center justify-content-center" style="min-height: 80px;">
                                <div class="text-center">
                                    @icon('user.list', 'fa-lg mb-2')
                                    <div class="fw-bold">Buscar Trabajadores</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3 mb-3">
                            <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.convocatorias-documentos') }}" class="btn btn-outline-info w-100 d-flex align-items-center justify-content-center" style="min-height: 80px;">
                                <div class="text-center">
                                    @icon('file.generic', 'fa-lg mb-2')
                                    <div class="fw-bold">Convocatorias y Documentos</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3 mb-3">
                            <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.reportes') }}" class="btn btn-outline-info w-100 d-flex align-items-center justify-content-center" style="min-height: 80px;">
                                <div class="text-center">
                                    @icon('report.bar', 'fa-lg mb-2')
                                    <div class="fw-bold">Reportes</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabla de solicitudes pendientes --}}
    <div class="row">
        <div class="col-12 col-lg-8 mb-4">
            <div class="card border-0 shadow">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h2 class="fs-5 fw-bold mb-0">Solicitudes Pendientes de Validación</h2>
                        </div>
                        <div class="col text-end">
                            <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.panel-solicitudes') }}" class="btn btn-sm btn-primary">Ver todas</a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th class="border-bottom" scope="col">Trabajador</th>
                                <th class="border-bottom" scope="col">Trámite</th>
                                <th class="border-bottom" scope="col">Prioridad</th>
                                <th class="border-bottom" scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-bolder text-gray-900">Juan Pérez González</td>
                                <td class="fw-normal text-gray-500">Alta de trabajador</td>
                                <td>
                                    <span class="text-danger fw-bold">Alta</span>
                                </td>
                                <td>
                                    <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.validar-pasos') }}" class="btn btn-sm btn-info">Validar</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bolder text-gray-900">María López Sánchez</td>
                                <td class="fw-normal text-gray-500">Solicitud de permiso</td>
                                <td>
                                    <span class="text-warning fw-bold">Media</span>
                                </td>
                                <td>
                                    <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.validar-pasos') }}" class="btn btn-sm btn-info">Validar</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bolder text-gray-900">Carlos Ramírez Torres</td>
                                <td class="fw-normal text-gray-500">Constancia laboral</td>
                                <td>
                                    <span class="text-info fw-bold">Baja</span>
                                </td>
                                <td>
                                    <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.validar-pasos') }}" class="btn btn-sm btn-info">Validar</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Estadísticas del Mes --}}
        <div class="col-12 col-lg-4 mb-4">
            <div class="card border-0 shadow">
                <div class="card-header">
                    <h2 class="fs-5 fw-bold mb-0">Estadísticas del Mes</h2>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between border-bottom pb-3 mb-3">
                        <div>
                            <span class="h6 mb-0">Solicitudes validadas</span>
                        </div>
                        <div>
                            <span class="h5 mb-0 fw-bold">156</span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between border-bottom pb-3 mb-3">
                        <div>
                            <span class="h6 mb-0">Promedio de validación</span>
                        </div>
                        <div>
                            <span class="h5 mb-0 fw-bold">2.3 días</span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div>
                            <span class="h6 mb-0">Tasa de aprobación</span>
                        </div>
                        <div>
                            <span class="h5 mb-0 fw-bold">94%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
