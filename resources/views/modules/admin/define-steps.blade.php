{{-- 
    Company: CETAM
    Project: ST
    File: define-steps.blade.php
    Created on: 04/11/2025
    Created by: Alfonso Angel Garcia Hernandez
    Approved by: Alfonso Angel Garcia Hernandez

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
                        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.dashboard.index') }}">
                            @icon('home', 'fa-xs')
                        </a>
                    </li>
                    @if (auth()->user()->role === 'secretary')
                        <li class="breadcrumb-item">Secretaria</li>
                        <li class="breadcrumb-item">
                            <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.processes') }}">
                                Gestionar procesos
                            </a>
                        </li>
                    @else
                        <li class="breadcrumb-item">Administracion</li>
                    @endif
                    <li class="breadcrumb-item active" aria-current="page">Definir pasos</li>
                </ol>
            </nav>
            <h2 class="h4">Definir pasos de proceso</h2>
            <p class="mb-0">Configura el flujo de trabajo y los pasos que componen el proceso.</p>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0 gap-2">
            <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.admin.create-step', ['process_id' => $selectedProcessId]) }}"
                class="btn btn-sm btn-gray-800 d-inline-flex align-items-center">
                @icon('add', 'me-2')
                Agregar paso
            </a>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12 col-xl-8">
            <div class="card border-0 shadow">
                <div class="card-body d-flex flex-column gap-3">
                    @if ($selectedProcess)
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                            <h3 class="h5 mb-2">{{ $selectedProcess->name }}</h3>
                            <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.admin.configure-flow', ['process_id' => $selectedProcessId]) }}"
                                class="btn btn-secondary btn-sm d-inline-flex align-items-center text-white">
                                @icon('process', 'icon-xs me-2 text-white')
                                Configurar flujo
                            </a>
                        </div>

                        @if ($selectedProcess->description)
                            <p class="mb-1"><span>Descripcion: </span><span>{{ $selectedProcess->description }}</span>
                            </p>
                        @endif

                        @if ($selectedProcess->process_code)
                            <p class="mb-1"><span>Codigo: </span><span>{{ $selectedProcess->process_code }}</span></p>
                        @endif

                        <p class="mb-0">
                            <span>Estado: </span>
                            @if ($selectedProcess->active)
                                <span class="text-success fw-bold">Activo</span>
                            @else
                                <span class="text-warning fw-bold">Inactivo</span>
                            @endif
                        </p>
                    @else
                        <div class="alert alert-warning mb-0" role="alert">
                            No hay procesos disponibles. Por favor, crea un proceso primero.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="col-12 col-xl-4">
            <div class="card border-0 shadow">
                <div class="card-body d-flex flex-column gap-3">
                    <h2 class="h6 mb-3">Informacion importante</h2>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0">
                            <div class="d-flex align-items-start">
                                @icon('info', 'fa-xs text-info me-3')
                                <div>
                                    <p class="text-gray-700 small mb-0">
                                        Primero se deben crear los pasos y despues definir el flujo.
                                    </p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-body shadow border-0 table-wrapper table-responsive">
        <table class="table table-centered table-nowrap mb-0 rounded user-table align-items-center"
            style="table-layout: fixed;">
            <colgroup>
                <col style="width: 35%">
                <col style="width: 18%">
                <col style="width: 15%">
                <col style="width: 20%">
                <col style="width: 12%; min-width: 72px;">
            </colgroup>
            <thead class="thead-light">
                <tr>
                    <th class="border-0 rounded-start">Paso</th>
                    <th class="border-0">Tipo</th>
                    <th class="border-0">Estado</th>
                    <th class="border-0">Docs. Requeridos</th>
                    <th class="border-0 rounded-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @if ($selectedProcess && count($steps) > 0)
                    @foreach ($steps as $step)
                        <tr>
                            <td>
                                <div class="d-block">
                                    <span
                                        class="fw-bold text-gray-900 text-truncate d-inline-block w-100">{{ $step->title }}</span>
                                    @if ($step->instruction)
                                        <div class="small text-gray text-truncate">
                                            {{ Str::limit($step->instruction, 80) }}</div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-{{ $this->getStepTypeBadge($step->step_type) }}">
                                    {{ $this->getStepTypeLabel($step->step_type) }}
                                </span>
                            </td>
                            <td>
                                @if ($step->is_initial_step)
                                    <span class="badge bg-primary">Paso inicial</span>
                                @elseif($step->is_linked)
                                    <span class="badge bg-success">Vinculado</span>
                                @else
                                    <span class="badge bg-warning text-dark">Sin vincular</span>
                                @endif
                            </td>
                            <td>
                                @if ($step->requiredDocuments->count() > 0)
                                    <div class="small">
                                        @foreach ($step->requiredDocuments->take(2) as $doc)
                                            <span class="badge bg-secondary me-1 mb-1">{{ $doc->title }}</span>
                                        @endforeach
                                        @if ($step->requiredDocuments->count() > 2)
                                            <span
                                                class="badge bg-gray-300 text-dark">+{{ $step->requiredDocuments->count() - 2 }}</span>
                                        @endif
                                    </div>
                                @else
                                    <span class="small text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group position-static">
                                    <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        @icon('menu', 'icon icon-xs')
                                    </button>
                                    <div class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1">
                                        <a class="dropdown-item d-flex align-items-center"
                                            href="{{ route(config('proj.route_name_prefix', 'proj') . '.admin.create-step', ['step_id' => $step->step_id]) }}">
                                            @icon('edit', 'dropdown-icon text-gray-400 me-2')
                                            Editar
                                        </a>
                                        <div role="separator" class="dropdown-divider my-1"></div>
                                        <a class="dropdown-item text-danger d-flex align-items-center" href="#"
                                            wire:click.prevent="deleteStep({{ $step->step_id }})">
                                            @icon('delete', 'dropdown-icon text-danger me-2')
                                            Eliminar
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="text-center py-4">
                            <div class="text-gray-500">
                                <div class="mb-3">
                                    @icon('documentSign', 'fa-2x text-gray-400')
                                </div>
                                <p class="fw-bold">No hay pasos registrados</p>
                                <p class="small">Este proceso aun no tiene pasos configurados.</p>
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
