{{--
    Company: CETAM
    Project: ST
    File: dashboard.blade.php
    Created on: 01/12/2025
    Created by: Alfonso Angel Garcia Hernandez
    Approved by: Alfonso Angel Garcia Hernandez
--}}

<div>
    {{-- Header --}}
    <div class="py-4">
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Panel de Secretaría</h1>
                <p class="mb-0">Bienvenido, {{ Auth::user()->name }}</p>
            </div>
        </div>
    </div>

    {{-- Métricas principales --}}
    <div class="row">
        <div class="col-12 col-sm-6 col-xl-3 mb-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="row d-block d-xl-flex align-items-center">
                        <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                            <div class="icon-shape icon-shape-primary rounded me-4 me-sm-0">
                                @icon('process.docs', 'icon')
                            </div>
                        </div>
                        <div class="col-12 col-xl-7 px-xl-0">
                            <div class="d-none d-sm-block">
                                <h2 class="h6 text-gray-400 mb-0">Total</h2>
                                <h3 class="fw-extrabold mb-1">{{ $totalRequests }}</h3>
                            </div>
                            <small class="text-gray-500">
                                solicitudes
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3 mb-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="row d-block d-xl-flex align-items-center">
                        <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                            <div class="icon-shape icon-shape-warning rounded me-4 me-sm-0">
                                @icon('state.pending', 'icon')
                            </div>
                        </div>
                        <div class="col-12 col-xl-7 px-xl-0">
                            <div class="d-none d-sm-block">
                                <h2 class="h6 text-gray-400 mb-0">Pendientes</h2>
                                <h3 class="fw-extrabold mb-1">{{ $pendingRequests }}</h3>
                            </div>
                            <small class="text-gray-500">
                                por validar
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3 mb-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="row d-block d-xl-flex align-items-center">
                        <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                            <div class="icon-shape icon-shape-info rounded me-4 me-sm-0">
                                @icon('state.in_progress', 'icon')
                            </div>
                        </div>
                        <div class="col-12 col-xl-7 px-xl-0">
                            <div class="d-none d-sm-block">
                                <h2 class="h6 text-gray-400 mb-0">En Proceso</h2>
                                <h3 class="fw-extrabold mb-1">{{ $inProgressRequests }}</h3>
                            </div>
                            <small class="text-gray-500">
                                activos
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3 mb-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="row d-block d-xl-flex align-items-center">
                        <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                            <div class="icon-shape icon-shape-success rounded me-4 me-sm-0">
                                @icon('state.success', 'icon')
                            </div>
                        </div>
                        <div class="col-12 col-xl-7 px-xl-0">
                            <div class="d-none d-sm-block">
                                <h2 class="h6 text-gray-400 mb-0">Completados</h2>
                                <h3 class="fw-extrabold mb-1">{{ $completedRequests }}</h3>
                            </div>
                            <small class="text-gray-500">
                                finalizados
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Acciones Rápidas y Resumen --}}
    <div class="row">
        {{-- Acciones Rápidas --}}
        <div class="col-12 col-lg-8 mb-4">
            <div class="card border-0 shadow">
                <div class="card-header">
                    <h2 class="fs-5 fw-bold mb-0">Acciones Rápidas</h2>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.busqueda-trabajadores') }}"
                                class="btn btn-outline-primary w-100 py-3">
                                <div class="d-flex flex-column align-items-center">
                                    @icon('user.list', 'fa-2x mb-2')
                                    <span class="fw-bold">Buscar Trabajadores</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.convocatorias-documentos') }}"
                                class="btn btn-outline-primary w-100 py-3">
                                <div class="d-flex flex-column align-items-center">
                                    @icon('file.generic', 'fa-2x mb-2')
                                    <span class="fw-bold">Convocatorias</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.notificaciones') }}"
                                class="btn btn-outline-primary w-100 py-3">
                                <div class="d-flex flex-column align-items-center">
                                    @icon('notif.bell', 'fa-2x mb-2')
                                    <span class="fw-bold">Notificaciones</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.gestion-faqs') }}"
                                class="btn btn-outline-primary w-100 py-3">
                                <div class="d-flex flex-column align-items-center">
                                    @icon('support.help', 'fa-2x mb-2')
                                    <span class="fw-bold">Gestión FAQs</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.admin.crear-proceso') }}"
                                class="btn btn-outline-primary w-100 py-3">
                                <div class="d-flex flex-column align-items-center">
                                    @icon('action.create', 'fa-2x mb-2')
                                    <span class="fw-bold">Crear Proceso</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.admin.definir-pasos') }}"
                                class="btn btn-outline-primary w-100 py-3">
                                <div class="d-flex flex-column align-items-center">
                                    @icon('process.step', 'fa-2x mb-2')
                                    <span class="fw-bold">Definir Pasos</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Resumen --}}
        <div class="col-12 col-lg-4 mb-4">
            <div class="card border-0 shadow h-100">
                <div class="card-header">
                    <h2 class="fs-5 fw-bold mb-0">Resumen</h2>
                </div>
                <div class="card-body">
                    <div class="mb-4 pb-4 border-bottom">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-gray-600">Convocatorias activas</span>
                            <span class="h5 mb-0 fw-bold text-success">{{ $activeConvocations }}</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" role="progressbar"
                                style="width: {{ $totalConvocations > 0 ? ($activeConvocations / $totalConvocations * 100) : 0 }}%"></div>
                        </div>
                        <small class="text-gray-500">{{ $totalConvocations }} convocatorias totales</small>
                    </div>

                    <div>
                        <h6 class="text-gray-600 mb-3">Estado de Solicitudes</h6>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="small text-gray-600">Pendientes</span>
                            <span class="small fw-bold">{{ $totalRequests > 0 ? round($pendingRequests / $totalRequests * 100) : 0 }}%</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="small text-gray-600">En Proceso</span>
                            <span class="small fw-bold">{{ $totalRequests > 0 ? round($inProgressRequests / $totalRequests * 100) : 0 }}%</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="small text-gray-600">Completados</span>
                            <span class="small fw-bold">{{ $totalRequests > 0 ? round($completedRequests / $totalRequests * 100) : 0 }}%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
