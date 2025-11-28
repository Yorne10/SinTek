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
                        @icon('nav.home', 'icon-xxs')
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Bienvenido, {{ Auth::user()->name ?? 'Trabajador' }}</h1>
                <p class="mb-0">Vista general de tus trámites y notificaciones.</p>
            </div>
        </div>
    </div>

    {{-- Métricas principales --}}
    <div class="row">
        {{-- Trámites en proceso --}}
        <div class="col-12 col-sm-6 col-xl-4 mb-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="row d-block d-xl-flex align-items-center">
                        <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                            <div class="icon-shape icon-sm rounded me-4 me-sm-0">
                                @icon('process.docs', 'icon text-info')
                            </div>
                            <div class="d-sm-none">
                                <h2 class="h5">En Proceso</h2>
                                <h3 class="fw-extrabold mb-1">3</h3>
                            </div>
                        </div>
                        <div class="col-12 col-xl-7 px-xl-0">
                            <div class="d-none d-sm-block">
                                <h2 class="h6 text-gray-400 mb-0">Trámites en Proceso</h2>
                                <h3 class="fw-extrabold mb-2">3</h3>
                            </div>
                            <small class="d-flex align-items-center text-gray-500">
                                Trámites activos pendientes
                            </small>
                            <div class="small d-flex mt-1">
                                <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.worker.mis-tramites') }}" class="text-primary">Ver detalles</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Trámites completados --}}
        <div class="col-12 col-sm-6 col-xl-4 mb-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="row d-block d-xl-flex align-items-center">
                        <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                            <div class="icon-shape icon-sm rounded me-4 me-sm-0">
                                @icon('state.success', 'icon text-info')
                            </div>
                            <div class="d-sm-none">
                                <h2 class="fw-extrabold h5">Completados</h2>
                                <h3 class="mb-1">12</h3>
                            </div>
                        </div>
                        <div class="col-12 col-xl-7 px-xl-0">
                            <div class="d-none d-sm-block">
                                <h2 class="h6 text-gray-400 mb-0">Trámites Completados</h2>
                                <h3 class="fw-extrabold mb-2">12</h3>
                            </div>
                            <small class="d-flex align-items-center text-gray-500">
                                Total completados este año
                            </small>
                            <div class="small d-flex mt-1">
                                <span class="text-success fw-bold">Finalizados</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Notificaciones --}}
        <div class="col-12 col-sm-6 col-xl-4 mb-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="row d-block d-xl-flex align-items-center">
                        <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                            <div class="icon-shape icon-sm rounded me-4 me-sm-0">
                                @icon('notif.bell', 'icon text-info')
                            </div>
                            <div class="d-sm-none">
                                <h2 class="fw-extrabold h5">Notificaciones</h2>
                                <h3 class="mb-1">5</h3>
                            </div>
                        </div>
                        <div class="col-12 col-xl-7 px-xl-0">
                            <div class="d-none d-sm-block">
                                <h2 class="h6 text-gray-400 mb-0">Notificaciones</h2>
                                <h3 class="fw-extrabold mb-2">5</h3>
                            </div>
                            <small class="d-flex align-items-center text-gray-500">
                                Mensajes sin leer
                            </small>
                            <div class="small d-flex mt-1">
                                <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.worker.notificaciones') }}" class="text-primary">Ver todas</a>
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
                            <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.worker.tramites-disponibles') }}" class="btn btn-outline-info w-100 d-flex align-items-center justify-content-center" style="min-height: 80px;">
                                <div class="text-center">
                                    @icon('process.docs', 'icon-lg mb-2')
                                    <div class="fw-bold">Nuevo Trámite</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3 mb-3">
                            <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.worker.mis-tramites') }}" class="btn btn-outline-info w-100 d-flex align-items-center justify-content-center" style="min-height: 80px;">
                                <div class="text-center">
                                    @icon('list.checklist', 'icon-lg mb-2')
                                    <div class="fw-bold">Mis Trámites</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3 mb-3">
                            <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.worker.convocatorias') }}" class="btn btn-outline-info w-100 d-flex align-items-center justify-content-center" style="min-height: 80px;">
                                <div class="text-center">
                                    @icon('calendar.generic', 'icon-lg mb-2')
                                    <div class="fw-bold">Convocatorias</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3 mb-3">
                            <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.worker.notificaciones') }}" class="btn btn-outline-info w-100 d-flex align-items-center justify-content-center" style="min-height: 80px;">
                                <div class="text-center">
                                    @icon('notif.bell', 'icon-lg mb-2')
                                    <div class="fw-bold">Ver Notificaciones</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Mis trámites recientes --}}
    <div class="row">
        <div class="col-12 col-lg-8 mb-4">
            <div class="card border-0 shadow">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h2 class="fs-5 fw-bold mb-0">Mis Trámites Recientes</h2>
                        </div>
                        <div class="col text-end">
                            <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.worker.mis-tramites') }}" class="btn btn-sm btn-primary">Ver todos</a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th class="border-bottom" scope="col">Trámite</th>
                                <th class="border-bottom" scope="col">Estado</th>
                                <th class="border-bottom" scope="col">Fecha</th>
                                <th class="border-bottom" scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-bolder text-gray-900">Solicitud de vacaciones</td>
                                <td>
                                    <span class="text-warning fw-bold">En validación</span>
                                </td>
                                <td class="fw-normal text-gray-500">05/11/2025</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-info">Ver detalle</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bolder text-gray-900">Constancia laboral</td>
                                <td>
                                    <span class="text-success fw-bold">Completado</span>
                                </td>
                                <td class="fw-normal text-gray-500">02/11/2025</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-info">Ver detalle</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bolder text-gray-900">Actualización de datos</td>
                                <td>
                                    <span class="text-info fw-bold">Pendiente</span>
                                </td>
                                <td class="fw-normal text-gray-500">28/10/2025</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-info">Ver detalle</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Notificaciones recientes --}}
        <div class="col-12 col-lg-4 mb-4">
            <div class="card border-0 shadow">
                <div class="card-header">
                    <h2 class="fs-5 fw-bold mb-0">Notificaciones</h2>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item px-0 border-bottom">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="icon-shape icon-sm rounded">
                                        @icon('notif.bell', 'icon-xs text-info')
                                    </div>
                                </div>
                                <div class="col ps-0 ms-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h4 class="h6 mb-0 text-small">Tu solicitud requiere documentación adicional</h4>
                                        </div>
                                    </div>
                                    <p class="font-small mt-1 mb-0">Hace 2 horas</p>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item px-0 border-bottom">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="icon-shape icon-sm rounded">
                                        @icon('state.success', 'icon-xs text-info')
                                    </div>
                                </div>
                                <div class="col ps-0 ms-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h4 class="h6 mb-0 text-small">Tu constancia está lista</h4>
                                        </div>
                                    </div>
                                    <p class="font-small mt-1 mb-0">Ayer</p>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item px-0 pb-0">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="icon-shape icon-sm rounded">
                                        @icon('state.info', 'icon-xs text-info')
                                    </div>
                                </div>
                                <div class="col ps-0 ms-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h4 class="h6 mb-0 text-small">Nueva convocatoria disponible</h4>
                                        </div>
                                    </div>
                                    <p class="font-small mt-1 mb-0">Hace 3 días</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.worker.notificaciones') }}" class="btn btn-sm btn-outline-gray-600">Ver todas</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
