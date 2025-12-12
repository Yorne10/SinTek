{{--
Company: CETAM
Project: ST
File: definir-pasos.blade.php
Created on: 04/11/2025
Created by: Alfonso Angel Garcia Hernandez
Approved by: Alfonso Angel Garcia Hernandez
--}}

<div>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item">
                        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.dashboard.index') }}">
                            @icon('home', 'fa-xs')
                        </a>
                    </li>
                    @if(auth()->user()->role === 'secretary')
                        <li class="breadcrumb-item">Secretaría</li>
                        <li class="breadcrumb-item">
                            <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.processes') }}">
                                Gestionar procesos
                            </a>
                        </li>
                    @else
                        <li class="breadcrumb-item">Administración</li>
                    @endif
                    <li class="breadcrumb-item active" aria-current="page">Definir pasos</li>
                </ol>
            </nav>
            <h2 class="h4">Definir pasos de proceso</h2>
            <p class="mb-0">Configura el flujo de trabajo y los pasos que componen el proceso.</p>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.admin.create-step') }}"
                class="btn btn-sm btn-gray-800 d-inline-flex align-items-center">
                @icon('add', 'me-2')
                Agregar paso
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-xl-8 mb-4">
            {{-- Selector de proceso o Título --}}
            <div class="card border-0 shadow mb-4">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                        </div>
                    </div>
                    <div class="card-body">
                        @if($selectedProcess)
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    @icon('documentSign', 'fa-lg text-primary me-3')
                                    <div>
                                        <h3 class="h6 mb-1">{{ $selectedProcess->name }}</h3>
                                        <p class="small text-gray mb-0">
                                            @if($selectedProcess->process_code)
                                                Código: {{ $selectedProcess->process_code }}
                                            @endif
                                            @if($selectedProcess->category)
                                                | Categoría: {{ ucfirst($selectedProcess->category) }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                @if(request()->route('process_id'))
                                    <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.admin.define-steps') }}"
                                        class="btn btn-sm btn-outline-secondary">
                                        @icon('edit', 'me-1')
                                        Cambiar proceso
                                    </a>
                                @endif
                            </div>
                        @else
                            <div class="alert alert-warning mb-0" role="alert">
                                No hay procesos disponibles. Por favor, crea un proceso primero.
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Lista de pasos --}}
                <div class="card border-0 shadow">
                    <div class="card-header border-bottom">
                        <h2 class="h5 mb-0">Pasos del proceso</h2>
                    </div>
                    <div class="card-body p-0">
                        @if($selectedProcess && count($steps) > 0)
                            <div class="table-responsive">
                                <table class="table table-hover align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="border-bottom" style="width: 70px;">Orden</th>
                                            <th class="border-bottom">Paso</th>
                                            <th class="border-bottom">Tipo</th>
                                            <th class="border-bottom">Responsable</th>
                                            <th class="border-bottom">Docs. Requeridos</th>
                                            <th class="border-bottom" style="width: 120px;">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($steps as $step)
                                            <tr>
                                                <td>
                                                    @if($step->condition_type === 'final')
                                                        <div class="d-flex align-items-center justify-content-center">
                                                            @icon('success', 'text-success')
                                                        </div>
                                                    @else
                                                        <div class="d-flex align-items-center justify-content-center">
                                                            <span class="badge rounded-circle bg-primary"
                                                                style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">{{ $step->order }}</span>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-block">
                                                        <span class="fw-bold">{{ $step->title }}</span>
                                                        @if($step->description)
                                                            <div class="small text-gray">{{ Str::limit($step->description, 60) }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    @if($step->condition_type === 'form')
                                                        <span class="fw-bold text-info">Formulario</span>
                                                    @elseif($step->condition_type === 'approval')
                                                        <span class="fw-bold text-warning">Aprobación</span>
                                                    @elseif($step->condition_type === 'upload')
                                                        <span class="fw-bold text-secondary">Carga de archivos</span>
                                                    @elseif($step->condition_type === 'final')
                                                        <span class="fw-bold text-success">Final</span>
                                                    @else
                                                        <span
                                                            class="fw-bold text-gray-600">{{ ucfirst($step->condition_type) }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="small text-gray-700">{{ $step->responsible ?? '' }}</span>
                                                </td>
                                                <td>
                                                    @if($step->requiredDocuments->count() > 0)
                                                        <ul class="list-unstyled mb-0 small">
                                                            @foreach($step->requiredDocuments as $doc)
                                                                <li>
                                                                    @icon('upload', 'fa-xs text-secondary me-1')
                                                                    {{ $doc->title }}
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        <span class="small text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button
                                                            class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                                                            data-bs-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z">
                                                                </path>
                                                            </svg>
                                                        </button>
                                                        <div
                                                            class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1">
                                                            <a class="dropdown-item d-flex align-items-center"
                                                                href="{{ route(config('proj.route_name_prefix', 'proj') . '.admin.create-step', ['step_id' => $step->step_id]) }}">
                                                                @icon('edit', 'dropdown-icon text-gray-400 me-2')
                                                                Editar
                                                            </a>
                                                            <div role="separator" class="dropdown-divider my-1"></div>
                                                            <a class="dropdown-item text-danger d-flex align-items-center"
                                                                href="#" wire:click.prevent="deleteStep({{ $step->step_id }})">
                                                                @icon('delete', 'dropdown-icon text-danger me-2')
                                                                Eliminar
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                @icon('documentSign', 'fa-2x text-gray-400 mb-3')
                                <h5 class="text-gray-700 mb-2">No hay pasos registrados</h5>
                                <p class="text-gray-600 mb-3">Este proceso aún no tiene pasos configurados.</p>
                                @if($selectedProcessId)
                                    <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.admin.create-step', ['process_id' => $selectedProcessId]) }}"
                                        class="btn btn-sm btn-gray-800">
                                        @icon('add', 'me-2')
                                        Agregar primer paso
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="col-12 col-xl-4">
                {{-- Tipos de paso --}}
                <div class="card border-0 shadow mb-4">
                    <div class="card-header border-bottom">
                        <h2 class="h6 mb-0">Tipos de paso</h2>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item px-0 border-bottom pb-3">
                                <div class="d-flex align-items-start">
                                    @icon('documentSign', 'text-info me-3')
                                    <div>
                                        <h3 class="h6 mb-1">Formulario</h3>
                                        <p class="small text-gray-600 mb-0">El usuario completa campos de información
                                        </p>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item px-0 border-bottom pb-3">
                                <div class="d-flex align-items-start">
                                    @icon('success', 'text-warning me-3')
                                    <div>
                                        <h3 class="h6 mb-1">Aprobación</h3>
                                        <p class="small text-gray-600 mb-0">Requiere una decisión de aprobación</p>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item px-0 border-bottom pb-3">
                                <div class="d-flex align-items-start">
                                    @icon('upload', 'text-secondary me-3')
                                    <div>
                                        <h3 class="h6 mb-1">Carga de archivos</h3>
                                        <p class="small text-gray-600 mb-0">Subir documentos requeridos</p>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item px-0 pb-0">
                                <div class="d-flex align-items-start">
                                    @icon('success', 'text-success me-3')
                                    <div>
                                        <h3 class="h6 mb-1">Final</h3>
                                        <p class="small text-gray-600 mb-0">Cierra y completa el proceso</p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Ayuda --}}
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <h2 class="h6 mb-3">Ayuda</h2>
                        <div class="d-flex mb-3">
                            @icon('info', 'fa-xs text-primary me-2 mt-1 flex-shrink-0')
                            <p class="small text-gray-700 mb-0">
                                Cada paso debe tener un orden secuencial. Los pasos se ejecutan en el orden definido.
                            </p>
                        </div>
                        <div class="d-flex">
                            @icon('info', 'fa-xs text-primary me-2 mt-1 flex-shrink-0')
                            <p class="small text-gray-700 mb-0">
                                El paso de tipo "Final" debe ser el último paso del proceso.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>