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
                    <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.dashboard.index') }}">
                        @icon('home', 'fa-xs')
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Panel de Administración</h1>
                <p class="mb-0">Resumen general del sistema</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-sm-6 col-xl-3 mb-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="row d-block d-xl-flex align-items-center">
                        <div
                            class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                            <div class="icon-shape icon-shape-primary rounded me-4 me-sm-0">
                                @icon('userGroup', 'icon')
                            </div>
                        </div>
                        <div class="col-12 col-xl-7 px-xl-0">
                            <div class="d-none d-sm-block">
                                <h2 class="h6 text-gray-400 mb-0">Total Usuarios</h2>
                                <h3 class="fw-extrabold mb-1">{{ $totalUsers }}</h3>
                            </div>
                            <small class="text-gray-500">
                                {{ $activeUsers }} activos
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
                        <div
                            class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                            <div class="icon-shape icon-shape-success rounded me-4 me-sm-0">
                                @icon('documentSign', 'icon')
                            </div>
                        </div>
                        <div class="col-12 col-xl-7 px-xl-0">
                            <div class="d-none d-sm-block">
                                <h2 class="h6 text-gray-400 mb-0">Procesos</h2>
                                <h3 class="fw-extrabold mb-1">{{ $activeProcesses }}</h3>
                            </div>
                            <small class="text-gray-500">
                                {{ $totalProcesses }} total
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
                        <div
                            class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                            <div class="icon-shape icon-shape-warning rounded me-4 me-sm-0">
                                @icon('pending', 'icon')
                            </div>
                        </div>
                        <div class="col-12 col-xl-7 px-xl-0">
                            <div class="d-none d-sm-block">
                                <h2 class="h6 text-gray-400 mb-0">En Proceso</h2>
                                <h3 class="fw-extrabold mb-1">{{ $inProgressRequests }}</h3>
                            </div>
                            <small class="text-gray-500">
                                trámites activos
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
                        <div
                            class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                            <div class="icon-shape icon-shape-info rounded me-4 me-sm-0">
                                @icon('documentSign', 'icon')
                            </div>
                        </div>
                        <div class="col-12 col-xl-7 px-xl-0">
                            <div class="d-none d-sm-block">
                                <h2 class="h6 text-gray-400 mb-0">Convocatorias</h2>
                                <h3 class="fw-extrabold mb-1">{{ $activeConvocations }}</h3>
                            </div>
                            <small class="text-gray-500">
                                {{ $totalConvocations }} total
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-12 col-xl-4 mb-4">
            <div class="card border-0 shadow h-100">
                <div class="card-header">
                    <h2 class="fs-5 fw-bold mb-0">Usuarios por Rol</h2>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="small">Administradores</span>
                            <span class="small fw-bold">{{ $usersByRole['admin'] }}</span>
                        </div>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar bg-danger" role="progressbar"
                                style="width: {{ $totalUsers > 0 ? ($usersByRole['admin'] / $totalUsers) * 100 : 0 }}%">
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="small">Secretarios</span>
                            <span class="small fw-bold">{{ $usersByRole['secretary'] }}</span>
                        </div>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar bg-warning" role="progressbar"
                                style="width: {{ $totalUsers > 0 ? ($usersByRole['secretary'] / $totalUsers) * 100 : 0 }}%">
                            </div>
                        </div>
                    </div>
                    <div class="mb-0">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="small">Trabajadores</span>
                            <span class="small fw-bold">{{ $usersByRole['worker'] }}</span>
                        </div>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar bg-primary" role="progressbar"
                                style="width: {{ $totalUsers > 0 ? ($usersByRole['worker'] / $totalUsers) * 100 : 0 }}%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-4 mb-4">
            <div class="card border-0 shadow h-100">
                <div class="card-header">
                    <h2 class="fs-5 fw-bold mb-0">Estado de Trámites</h2>
                </div>
                <div class="card-body">
                    @php
                        $total = $totalRequests > 0 ? $totalRequests : 1;
                    @endphp
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="small">Completados</span>
                            <span class="small fw-bold">{{ $completedRequests }}</span>
                        </div>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar bg-success" role="progressbar"
                                style="width: {{ ($completedRequests / $total) * 100 }}%"></div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="small">En Proceso</span>
                            <span class="small fw-bold">{{ $inProgressRequests }}</span>
                        </div>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar bg-warning" role="progressbar"
                                style="width: {{ ($inProgressRequests / $total) * 100 }}%"></div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="small">Pendientes</span>
                            <span class="small fw-bold">{{ $pendingRequests }}</span>
                        </div>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar bg-info" role="progressbar"
                                style="width: {{ ($pendingRequests / $total) * 100 }}%"></div>
                        </div>
                    </div>
                    <div class="mb-0">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="small">Rechazados</span>
                            <span class="small fw-bold">{{ $rejectedRequests }}</span>
                        </div>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar bg-danger" role="progressbar"
                                style="width: {{ ($rejectedRequests / $total) * 100 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-4 mb-4">
            <div class="card border-0 shadow h-100">
                <div class="card-header">
                    <h2 class="fs-5 fw-bold mb-0">Actividad Reciente</h2>
                </div>
                <div class="card-body">
                    @forelse($recentLogs as $log)
                        <div class="d-flex align-items-start mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                            <div class="me-3">
                                @icon('info', 'text-gray-400')
                            </div>
                            <div class="flex-grow-1">
                                <div class="small fw-bold">{{ $log->user->name ?? 'Sistema' }}</div>
                                <div class="small text-gray-600">
                                    {{ \App\Services\ActivityLogger::getActionLabel($log->action ?? '') }}</div>
                                <div class="small text-gray-500">{{ $log->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-gray-500 py-3">
                            <div class="mb-2">
                                @icon('info', 'fa-2x text-gray-400')
                            </div>
                            <p class="small mb-0">No hay actividad reciente</p>
                        </div>
                    @endforelse
                </div>
                <div class="card-footer">
                    <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.admin.bitacora') }}"
                        class="btn btn-sm btn-link d-flex align-items-center justify-content-center">
                        Ver toda la bitácora
                        @icon('forward', 'ms-2 fa-xs')
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 mb-4">
            <div class="card border-0 shadow">
                <div class="card-header">
                    <h2 class="fs-5 fw-bold mb-0">Resumen General</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <div class="d-flex justify-content-between border-end pe-3">
                                <div>
                                    <span class="h6 mb-0">Total de trámites</span>
                                </div>
                                <div>
                                    <span class="h5 mb-0 fw-bold text-primary">{{ $totalRequests }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0">
                            <div class="d-flex justify-content-between border-end pe-3">
                                <div>
                                    <span class="h6 mb-0">Trámites este mes</span>
                                </div>
                                <div>
                                    <span class="h5 mb-0 fw-bold text-success">{{ $requestsThisMonth }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <span class="h6 mb-0">Tasa de completados</span>
                                </div>
                                <div>
                                    <span class="h5 mb-0 fw-bold text-info">
                                        {{ $totalRequests > 0 ? number_format(($completedRequests / $totalRequests) * 100, 1) : 0 }}%
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
