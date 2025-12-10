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
                <h1 class="h4">Bienvenido, {{ Auth::user()->name }}</h1>
                <p class="mb-0">Gestiona tus trámites y consulta convocatorias</p>
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
                                @icon('documentSign', 'fa-3x text-primary')
                            </div>
                        </div>
                        <div class="col-12 col-xl-7 px-xl-0">
                            <div class="d-none d-sm-block">
                                <h2 class="h6 text-gray-400 mb-0">Mis Trámites</h2>
                                <h3 class="fw-extrabold mb-1">{{ $myRequests }}</h3>
                            </div>
                            <small class="text-gray-500">
                                total
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
                                <h3 class="fw-extrabold mb-1">{{ $myInProgressRequests }}</h3>
                            </div>
                            <small class="text-gray-500">
                                en curso
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
                                <h3 class="fw-extrabold mb-1">{{ $myCompletedRequests }}</h3>
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


        {{-- Información --}}
        <div class="col-12 col-lg-4 mb-4">
            <div class="card border-0 shadow h-100">
                <div class="card-header">
                    <h2 class="fs-5 fw-bold mb-0">Disponibles</h2>
                </div>
                <div class="card-body">
                    <div class="mb-4 pb-4 border-bottom">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-gray-600">Procesos disponibles</span>
                            <span class="h5 mb-0 fw-bold text-primary">{{ $availableProcesses }}</span>
                        </div>
                        <small class="text-gray-500">para iniciar trámites</small>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-gray-600">Convocatorias activas</span>
                            <span class="h5 mb-0 fw-bold text-success">{{ $activeConvocations }}</span>
                        </div>
                        <small class="text-gray-500">publicadas actualmente</small>
                    </div>

                    <div>
                        <h6 class="text-gray-600 mb-3">Progreso</h6>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="small text-gray-600">Completados</span>
                            <span
                                class="small fw-bold">{{ $myRequests > 0 ? round($myCompletedRequests / $myRequests * 100) : 0 }}%</span>
                        </div>
                        <div class="progress mb-2" style="height: 8px;">
                            <div class="progress-bar bg-success" role="progressbar"
                                style="width: {{ $myRequests > 0 ? ($myCompletedRequests / $myRequests * 100) : 0 }}%">
                            </div>
                        </div>
                        <small class="text-gray-500">{{ $myCompletedRequests }} de {{ $myRequests }} trámites</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
