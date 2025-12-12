{{-- 
* Company: CETAM
* Project: ST
* File: dashboard.blade.php
* Created on: 01/12/2025
* Created by: Alfonso Angel Garcia Hernandez
* Approved by: Alfonso Angel Garcia Hernandez
--}}

<div>
    {{-- Header --}}
    <div class="py-4">
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Panel de Secretaría</h1>
                <p class="mb-0">Bienvenido(a), {{ Auth::user()->name }}</p>
            </div>
        </div>
    </div>

    {{-- Métricas principales --}}
    <div class="row">
        <div class="col-12 col-sm-6 col-xl-4 mb-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="row d-block d-xl-flex align-items-center">
                        <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                            <div class="me-4 me-sm-0">
                                @icon('documentSign', 'fa-3x text-info')
                            </div>
                        </div>
                        <div class="col-12 col-xl-7 px-xl-0">
                            <div class="d-none d-sm-block">
                                <h2 class="h6 text-gray-400 mb-0">Total</h2>
                                <h3 class="fw-extrabold mb-1">{{ $totalRequests }}</h3>
                            </div>
                            <small class="text-gray-500">
                                trámites
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
                        <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                            <div class="me-4 me-sm-0">
                                @icon('pending', 'fa-3x text-warning')
                            </div>
                        </div>
                        <div class="col-12 col-xl-7 px-xl-0">
                            <div class="d-none d-sm-block">
                                <h2 class="h6 text-gray-400 mb-0">En progreso</h2>
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

        <div class="col-12 col-sm-6 col-xl-4 mb-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="row d-block d-xl-flex align-items-center">
                        <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
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
                                finalizados
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Resumen y detalle --}}
    <div class="row">
        <div class="col-12 col-lg-6 mb-4">
            <div class="card border-0 shadow h-100">
                <div class="card-header border-bottom">
                    <h2 class="fs-5 fw-bold mb-0">Estado de trámites</h2>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-gray-600">Total de trámites</span>
                        <span class="h5 mb-0 fw-bold text-info">{{ $totalRequests }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-gray-600">En progreso</span>
                        <span class="h5 mb-0 fw-bold text-warning">{{ $inProgressRequests }}</span>
                    </div>
                    <div class="progress mb-3" style="height: 8px;">
                        <div class="progress-bar bg-warning" role="progressbar"
                            style="width: {{ $totalRequests > 0 ? ($inProgressRequests / $totalRequests * 100) : 0 }}%">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-gray-600">Completados</span>
                        <span class="h5 mb-0 fw-bold text-success">{{ $completedRequests }}</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-success" role="progressbar"
                            style="width: {{ $totalRequests > 0 ? ($completedRequests / $totalRequests * 100) : 0 }}%">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
