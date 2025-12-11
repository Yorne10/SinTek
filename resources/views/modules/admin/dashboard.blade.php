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
                <h1 class="h4">Panel de Administración</h1>
                <p class="mb-0">Bienvenido, {{ Auth::user()->name }}</p>
            </div>
        </div>
    </div>

    {{-- Métricas principales --}}
    <div class="row">
        <div class="col-12 col-sm-6 col-xl-4 mb-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="row d-block d-xl-flex align-items-center">
                        <div
                            class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                            <div class="me-4 me-sm-0">
                                @icon('userGroup', 'fa-3x text-info')
                            </div>
                        </div>
                        <div class="col-12 col-xl-7 px-xl-0">
                            <div class="d-none d-sm-block">
                                <h2 class="h6 text-gray-400 mb-0">Usuarios</h2>
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

        <div class="col-12 col-sm-6 col-xl-4 mb-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="row d-block d-xl-flex align-items-center">
                        <div
                            class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                            <div class="me-4 me-sm-0">
                                @icon('pending', 'fa-3x text-warning')
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

        <div class="col-12 col-sm-6 col-xl-4 mb-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="row d-block d-xl-flex align-items-center">
                        <div
                            class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                            <div class="me-4 me-sm-0">
                                @icon('success', 'fa-3x text-success')
                            </div>
                        </div>
                        <div class="col-12 col-xl-7 px-xl-0">
                            <div class="d-none d-sm-block">
                                <h2 class="h6 text-gray-400 mb-0">Completados</h2>
                                <h3 class="fw-extrabold mb-1">{{ $completedRequests }}</h3>
                            </div>
                            <small class="text-gray-500">
                                este mes
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Contenido principal --}}
    <div class="row">
        {{-- Actividad Reciente --}}
        <div class="col-12 col-lg-7 mb-4">
            <div class="card border-0 shadow h-100">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <h2 class="fs-5 fw-bold mb-0">Actividad Reciente</h2>
                    <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.admin.activity-log') }}"
                        class="btn btn-sm btn-secondary text-white">
                        Ver todo
                    </a>
                </div>
                <div class="card-body">
                    @forelse($recentLogs as $log)
                        <div class="d-flex align-items-start mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                            <div class="me-3">
                                <div class="icon-shape icon-sm">
                                    @icon('info', 'text-info')
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <div class="fw-bold">{{ $log->user->name ?? 'Sistema' }}</div>
                                        <div class="text-gray-600 small">
                                            {{ \App\Services\ActivityLogger::getActionLabel($log->action ?? '') }}
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <div class="small text-gray-500">{{ $log->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-gray-500 py-4">
                            @icon('info', 'fa-2x text-gray-400 mb-2')
                            <p class="small mb-0">No hay actividad reciente</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Resumen --}}
        <div class="col-12 col-lg-5 mb-4">
            <div class="card border-0 shadow h-100">
                <div class="card-header border-bottom">
                    <h2 class="fs-5 fw-bold mb-0">Resumen General</h2>
                </div>
                <div class="card-body">
                    {{-- Procesos --}}
                    <div class="mb-4 pb-4 border-bottom">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-gray-600">Procesos activos</span>
                            <span class="h5 mb-0 fw-bold text-success">{{ $activeProcesses }}</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" role="progressbar"
                                style="width: {{ $totalProcesses > 0 ? ($activeProcesses / $totalProcesses * 100) : 0 }}%">
                            </div>
                        </div>
                        <small class="text-gray-500">{{ $totalProcesses }} procesos totales</small>
                    </div>

                    {{-- Convocatorias --}}
                    <div class="mb-4 pb-4 border-bottom">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-gray-600">Convocatorias activas</span>
                            <span class="h5 mb-0 fw-bold text-success">{{ $activeConvocations }}</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" role="progressbar"
                                style="width: {{ $totalConvocations > 0 ? ($activeConvocations / $totalConvocations * 100) : 0 }}%">
                            </div>
                        </div>
                        <small class="text-gray-500">{{ $totalConvocations }} convocatorias totales</small>
                    </div>

                    {{-- Usuarios por Rol --}}
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-gray-600 small">Administradores</span>
                            <span class="fw-bold">{{ $usersByRole['admin'] }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-gray-600 small">Secretarios</span>
                            <span class="fw-bold">{{ $usersByRole['secretary'] }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-gray-600 small">Trabajadores</span>
                            <span class="fw-bold">{{ $usersByRole['worker'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
