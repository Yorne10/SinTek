{{--
Company: CETAM
Project: ST
File: process-detail.blade.php
Created on: 10/12/2025
Created by: Alfonso Angel Garcia Hernandez
Approved by: Alfonso Angel García Hernández

Changelog:
- ID: <ID> | Date: dd/mm/yyyy
    Modified by: <Developer name>
        Description: <Brief description of change>
            --}}

            <div>
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
                    <div class="d-block mb-4 mb-md-0">
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                                <li class="breadcrumb-item">
                                    <a
                                        href="{{ route(config('proj.route_name_prefix', 'proj') . '.dashboard.index') }}">
                                        @icon('home', 'fa-xs')
                                    </a>
                                </li>
                                <li class="breadcrumb-item">Secretaría</li>
                                <li class="breadcrumb-item">
                                    <a
                                        href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.processes') }}">
                                        Gestionar procesos
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $process->name }}</li>
                            </ol>
                        </nav>
                        <h2 class="h4">Detalles del proceso</h2>
                        <p class="mb-0">Información completa del proceso y sus pasos.</p>
                    </div>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.processes') }}"
                            class="btn btn-sm btn-gray-200 d-inline-flex align-items-center me-2">
                            @icon('arrowLeft', 'me-2')
                            Volver
                        </a>
                        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.admin.modify-process', ['process_id' => $process->process_id]) }}"
                            class="btn btn-sm btn-primary d-inline-flex align-items-center me-2">
                            @icon('edit', 'me-2')
                            Editar proceso
                        </a>
                        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.admin.define-steps', ['process_id' => $process->process_id]) }}"
                            class="btn btn-sm btn-gray-800 d-inline-flex align-items-center">
                            @icon('checkList', 'me-2')
                            Definir pasos
                        </a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-xl-8 mb-4">
                        {{-- Información del proceso --}}
                        <div class="card border-0 shadow mb-4">
                            <div class="card-header border-bottom">
                                <h3 class="h5 mb-0">Información general</h3>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <p class="fw-bold text-gray-700 mb-1">Nombre del proceso</p>
                                    </div>
                                    <div class="col-md-8">
                                        <p class="text-gray-900 mb-0">{{ $process->name }}</p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <p class="fw-bold text-gray-700 mb-1">Descripción</p>
                                    </div>
                                    <div class="col-md-8">
                                        <p class="text-gray-900 mb-0">{{ $process->description ?? 'Sin descripción' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <p class="fw-bold text-gray-700 mb-1">Estado</p>
                                    </div>
                                    <div class="col-md-8">
                                        @if ($process->active)
                                            <span class="badge bg-success">Activo</span>
                                        @else
                                            <span class="badge bg-warning">Inactivo</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <p class="fw-bold text-gray-700 mb-1">Fecha de creación</p>
                                    </div>
                                    <div class="col-md-8">
                                        <p class="text-gray-900 mb-0">{{ $process->created_at->format('d/m/Y H:i') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Pasos del proceso --}}
                        <div class="card border-0 shadow">
                            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                                <h3 class="h5 mb-0">Pasos del proceso</h3>
                                <span class="badge bg-info">{{ $process->steps->count() }} pasos</span>
                            </div>
                            <div class="card-body">
                                @if ($process->steps->count() > 0)
                                    <div class="timeline timeline-one-side" data-timeline-content="axis"
                                        data-timeline-axis-style="dashed">
                                        @foreach ($process->steps as $index => $step)
                                            <div class="timeline-block mb-3">
                                                <span
                                                    class="timeline-step badge-{{ $loop->first ? 'success' : ($loop->last ? 'primary' : 'info') }}">
                                                    <span class="fw-bold">{{ $step->order }}</span>
                                                </span>
                                                <div class="timeline-content">
                                                    <div class="d-flex justify-content-between">
                                                        <div>
                                                            <h6 class="text-sm font-weight-bold mb-1">{{ $step->title }}</h6>
                                                            <p class="text-sm text-gray-600 mb-0">
                                                                {{ $step->description ?? 'Sin descripción' }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-4">
                                        <div class="text-gray-500">
                                            <div class="mb-3">
                                                @icon('checkList', 'fa-2x')
                                            </div>
                                            <p class="fw-bold">No hay pasos definidos</p>
                                            <p class="small mb-3">Este proceso aún no tiene pasos configurados</p>
                                            <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.admin.define-steps', ['process_id' => $process->process_id]) }}"
                                                class="btn btn-sm btn-primary">
                                                @icon('add', 'me-2')
                                                Definir pasos
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-xl-4">
                        {{-- Acciones rápidas --}}
                        <div class="card border-0 shadow mb-4">
                            <div class="card-header border-bottom">
                                <h3 class="h5 mb-0">Acciones rápidas</h3>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.admin.modify-process', ['process_id' => $process->process_id]) }}"
                                        class="btn btn-outline-primary d-flex align-items-center justify-content-center">
                                        @icon('edit', 'me-2')
                                        Editar información
                                    </a>
                                    <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.admin.define-steps', ['process_id' => $process->process_id]) }}"
                                        class="btn btn-outline-primary d-flex align-items-center justify-content-center">
                                        @icon('checkList', 'me-2')
                                        Gestionar pasos
                                    </a>
                                </div>
                            </div>
                        </div>

                        {{-- Estadísticas --}}
                        <div class="card border-0 shadow">
                            <div class="card-header border-bottom">
                                <h3 class="h5 mb-0">Estadísticas</h3>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-gray-600">Total de pasos</span>
                                        <span class="h5 mb-0 fw-bold text-info">{{ $process->steps->count() }}</span>
                                    </div>
                                </div>
                                <hr>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-gray-600">Estado del proceso</span>
                                        <span>
                                            @if ($process->active)
                                                <span class="badge bg-success">Activo</span>
                                            @else
                                                <span class="badge bg-warning">Inactivo</span>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <style>
                    .timeline {
                        position: relative;
                        padding: 0;
                        list-style: none;
                    }

                    .timeline:before {
                        content: '';
                        position: absolute;
                        top: 0;
                        bottom: 0;
                        width: 2px;
                        background: #e9ecef;
                        left: 18px;
                    }

                    .timeline-block {
                        position: relative;
                        padding-left: 50px;
                    }

                    .timeline-step {
                        position: absolute;
                        left: 0;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        width: 36px;
                        height: 36px;
                        border-radius: 50%;
                        font-size: 14px;
                        z-index: 1;
                    }

                    .badge-success {
                        background-color: #10b981;
                        color: white;
                    }

                    .badge-info {
                        background-color: #3b82f6;
                        color: white;
                    }

                    .badge-primary {
                        background-color: #6366f1;
                        color: white;
                    }
                </style>
            </div>