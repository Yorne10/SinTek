{{--
    Company: CETAM
    Project: ST
    File: dashboard.blade.php
    Created on: 05/11/2025
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
                <li class="breadcrumb-item"><a href="#">Administración</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Resumen General</h1>
                <p class="mb-0">Vista general del sistema de gestión de trámites.</p>
            </div>
        </div>
    </div>

    {{-- Métricas principales --}}
    <div class="row">
        {{-- Procesos Activos --}}
        <div class="col-12 col-sm-6 col-xl-4 mb-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="row d-block d-xl-flex align-items-center">
                        <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                            <div class="icon-shape icon-sm rounded me-4 me-sm-0">
                                @icon('process.docs', 'fa-lg text-info')
                            </div>
                            <div class="d-sm-none">
                                <h2 class="h5">Procesos Activos</h2>
                                <h3 class="fw-extrabold mb-1">12</h3>
                            </div>
                        </div>
                        <div class="col-12 col-xl-7 px-xl-0">
                            <div class="d-none d-sm-block">
                                <h2 class="h6 text-gray-400 mb-0">Procesos Activos</h2>
                                <h3 class="fw-extrabold mb-2">12</h3>
                            </div>
                            <small class="d-flex align-items-center text-gray-500">
                                Procesos configurados y disponibles
                            </small>
                            <div class="small d-flex mt-1">
                                <span class="text-success fw-bold">Todos operativos</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Solicitudes Recientes --}}
        <div class="col-12 col-sm-6 col-xl-4 mb-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="row d-block d-xl-flex align-items-center">
                        <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                            <div class="icon-shape icon-sm rounded me-4 me-sm-0">
                                @icon('state.success', 'fa-lg text-info')
                            </div>
                            <div class="d-sm-none">
                                <h2 class="fw-extrabold h5">Solicitudes Recientes</h2>
                                <h3 class="mb-1">47</h3>
                            </div>
                        </div>
                        <div class="col-12 col-xl-7 px-xl-0">
                            <div class="d-none d-sm-block">
                                <h2 class="h6 text-gray-400 mb-0">Solicitudes Recientes</h2>
                                <h3 class="fw-extrabold mb-2">47</h3>
                            </div>
                            <small class="d-flex align-items-center text-gray-500">
                                Última semana
                            </small>
                            <div class="small d-flex mt-1">
                                <div>
                                    @icon('nav.up', 'fa-xs text-success')
                                    <span class="text-success fw-bolder">12%</span> vs. semana anterior
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Solicitudes en Trámite --}}
        <div class="col-12 col-sm-6 col-xl-4 mb-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="row d-block d-xl-flex align-items-center">
                        <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                            <div class="icon-shape icon-sm rounded me-4 me-sm-0">
                                @icon('action.view', 'fa-lg text-info')
                            </div>
                            <div class="d-sm-none">
                                <h2 class="fw-extrabold h5">En Trámite</h2>
                                <h3 class="mb-1">28</h3>
                            </div>
                        </div>
                        <div class="col-12 col-xl-7 px-xl-0">
                            <div class="d-none d-sm-block">
                                <h2 class="h6 text-gray-400 mb-0">Solicitudes en Trámite</h2>
                                <h3 class="fw-extrabold mb-2">28</h3>
                            </div>
                            <small class="d-flex align-items-center text-gray-500">
                                Pendientes de validación o finalización
                            </small>
                            <div class="small d-flex mt-1">
                                <span class="text-warning fw-bold">Requieren atención</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Gráficos y estadísticas --}}
    <div class="row">
        {{-- Estadísticas Rápidas --}}
        <div class="col-12 col-xl-6 mb-4">
            <div class="card border-0 shadow">
                <div class="card-header">
                    <h2 class="fs-5 fw-bold mb-0">Estadísticas Rápidas</h2>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between border-bottom pb-3 mb-3">
                        <div>
                            <span class="h6 mb-0">Total de trabajadores registrados</span>
                        </div>
                        <div>
                            <span class="h5 mb-0 fw-bold">245</span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between border-bottom pb-3 mb-3">
                        <div>
                            <span class="h6 mb-0">Trámites completados este mes</span>
                        </div>
                        <div>
                            <span class="h5 mb-0 fw-bold">134</span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div>
                            <span class="h6 mb-0">Tiempo promedio de proceso</span>
                        </div>
                        <div>
                            <span class="h5 mb-0 fw-bold">3.5 días</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Distribución por estado --}}
        <div class="col-12 col-xl-6 mb-4">
            <div class="card border-0 shadow">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h2 class="fs-5 fw-bold mb-0">Distribución por Estado</h2>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    {{-- Progress bars por estado --}}
                    <div class="mb-4">
                        <div class="progress-wrapper">
                            <div class="progress-info">
                                <div class="h6 mb-0">Completados</div>
                                <div class="small fw-bold text-gray-500"><span>65%</span></div>
                            </div>
                            <div class="progress mb-0">
                                <div class="progress-bar bg-success" role="progressbar" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100" style="width: 65%;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="progress-wrapper">
                            <div class="progress-info">
                                <div class="h6 mb-0">En Proceso</div>
                                <div class="small fw-bold text-gray-500"><span>25%</span></div>
                            </div>
                            <div class="progress mb-0">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="progress-wrapper">
                            <div class="progress-info">
                                <div class="h6 mb-0">Pendientes</div>
                                <div class="small fw-bold text-gray-500"><span>8%</span></div>
                            </div>
                            <div class="progress mb-0">
                                <div class="progress-bar bg-info" role="progressbar" aria-valuenow="8" aria-valuemin="0" aria-valuemax="100" style="width: 8%;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="progress-wrapper">
                            <div class="progress-info">
                                <div class="h6 mb-0">Rechazados</div>
                                <div class="small fw-bold text-gray-500"><span>2%</span></div>
                            </div>
                            <div class="progress mb-0">
                                <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="100" style="width: 2%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
