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
                        @icon('home', 'fa-xs')
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
        {{-- Solicitudes totales --}}
        <div class="col-12 col-sm-6 col-xl-3 mb-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="row d-block d-xl-flex align-items-center">
                        <div
                            class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                            <div class="icon-shape icon-shape-primary rounded me-4 me-sm-0">
                                @icon('documentSign', 'icon')
                            </div>
                        </div>
                        <div class="col-12 col-xl-7 px-xl-0">
                            <div class="d-none d-sm-block">
                                <h2 class="h6 text-gray-400 mb-0">Total Solicitudes</h2>
                                <h3 class="fw-extrabold mb-1">{{ $totalRequests }}</h3>
                            </div>
                            <small class="text-gray-500">
                                en el sistema
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Solicitudes pendientes --}}
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
                                <h2 class="h6 text-gray-400 mb-0">Pendientes</h2>
                                <h3 class="fw-extrabold mb-1">{{ $pendingRequests }}</h3>
                            </div>
                            <small class="text-gray-500">
                                requieren validación
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- En proceso --}}
        <div class="col-12 col-sm-6 col-xl-3 mb-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="row d-block d-xl-flex align-items-center">
                        <div
                            class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                            <div class="icon-shape icon-shape-info rounded me-4 me-sm-0">
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

        {{-- Completados --}}
        <div class="col-12 col-sm-6 col-xl-3 mb-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="row d-block d-xl-flex align-items-center">
                        <div
                            class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                            <div class="icon-shape icon-shape-success rounded me-4 me-sm-0">
                                @icon('success', 'icon')
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

    {{-- Resumen de Convocatorias --}}
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card border-0 shadow">
                <div class="card-header">
                    <h2 class="fs-5 fw-bold mb-0">Convocatorias</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <div class="d-flex justify-content-between border-end pe-3">
                                <div>
                                    <span class="h6 mb-0">Convocatorias activas</span>
                                </div>
                                <div>
                                    <span class="h5 mb-0 fw-bold text-success">{{ $activeConvocations }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <span class="h6 mb-0">Total convocatorias</span>
                                </div>
                                <div>
                                    <span class="h5 mb-0 fw-bold text-primary">{{ $totalConvocations }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
