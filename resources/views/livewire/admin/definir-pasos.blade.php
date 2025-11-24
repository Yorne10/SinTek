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
                            <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                        </a>
                    </li>
                    <li class="breadcrumb-item">Administración</li>
                    <li class="breadcrumb-item active" aria-current="page">Definir pasos</li>
                </ol>
            </nav>
            <h2 class="h4">Definir pasos de proceso</h2>
            <p class="mb-0">Configura el flujo de trabajo y los pasos que componen el proceso.</p>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.admin.crear-paso') }}" class="btn btn-sm btn-gray-800 d-inline-flex align-items-center">
                <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Agregar paso
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-xl-8 mb-4">
            {{-- Selector de proceso --}}
            <div class="card border-0 shadow mb-4">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h2 class="h5 mb-0">Proceso seleccionado</h2>
                        </div>
                        <div class="col text-end">
                            <select class="form-select form-select-sm" style="width: auto; display: inline-block;" wire:model.live="selectedProcessId">
                                @foreach($procesos as $proceso)
                                <option value="{{ $proceso->process_id }}">{{ $proceso->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if($selectedProcess)
                    <div class="d-flex align-items-center">
                        <svg class="icon icon-lg text-primary me-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path></svg>
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
                                    <th class="border-bottom" style="width: 120px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($steps as $step)
                                <tr>
                                    <td>
                                        @if($step->condition_type === 'final')
                                        <div class="d-flex align-items-center justify-content-center">
                                            <svg class="icon icon-sm text-success" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                        </div>
                                        @else
                                        <div class="d-flex align-items-center justify-content-center">
                                            <span class="badge rounded-circle bg-primary" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">{{ $step->order }}</span>
                                        </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-block">
                                            <span class="fw-bold">{{ $step->tittle }}</span>
                                            @if($step->description)
                                            <div class="small text-gray">{{ Str::limit($step->description, 60) }}</div>
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
                                            <span class="fw-bold text-gray-600">{{ ucfirst($step->condition_type) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="small text-gray-700">{{ $step->responsible ?? '—' }}</span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                                </svg>
                                            </button>
                                            <div class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1">
                                                <a class="dropdown-item d-flex align-items-center" href="{{ route(config('proj.route_name_prefix', 'proj') . '.admin.crear-paso', ['step_id' => $step->step_id]) }}">
                                                    <svg class="dropdown-icon text-gray-400 me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path></svg>
                                                    Editar
                                                </a>
                                                <div role="separator" class="dropdown-divider my-1"></div>
                                                <a class="dropdown-item text-danger d-flex align-items-center" href="#" wire:click.prevent="deleteStep({{ $step->step_id }})">
                                                    <svg class="dropdown-icon text-danger me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
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
                        <svg class="icon icon-lg text-gray-400 mb-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
                        </svg>
                        <h5 class="text-gray-700 mb-2">No hay pasos registrados</h5>
                        <p class="text-gray-600 mb-3">Este proceso aún no tiene pasos configurados.</p>
                        @if($selectedProcessId)
                        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.admin.crear-paso', ['process_id' => $selectedProcessId]) }}" class="btn btn-sm btn-gray-800">
                            <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
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
                                <svg class="icon icon-sm text-info me-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path></svg>
                                <div>
                                    <h3 class="h6 mb-1">Formulario</h3>
                                    <p class="small text-gray-600 mb-0">El usuario completa campos de información</p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0 border-bottom pb-3">
                            <div class="d-flex align-items-start">
                                <svg class="icon icon-sm text-warning me-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                <div>
                                    <h3 class="h6 mb-1">Aprobación</h3>
                                    <p class="small text-gray-600 mb-0">Requiere una decisión de aprobación</p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0 border-bottom pb-3">
                            <div class="d-flex align-items-start">
                                <svg class="icon icon-sm text-secondary me-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path></svg>
                                <div>
                                    <h3 class="h6 mb-1">Carga de archivos</h3>
                                    <p class="small text-gray-600 mb-0">Subir documentos requeridos</p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0 pb-0">
                            <div class="d-flex align-items-start">
                                <svg class="icon icon-sm text-success me-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
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
                        <svg class="icon icon-xs text-primary me-2 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                        <p class="small text-gray-700 mb-0">
                            Cada paso debe tener un orden secuencial. Los pasos se ejecutan en el orden definido.
                        </p>
                    </div>
                    <div class="d-flex">
                        <svg class="icon icon-xs text-primary me-2 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                        <p class="small text-gray-700 mb-0">
                            El paso de tipo "Final" debe ser el último paso del proceso.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
