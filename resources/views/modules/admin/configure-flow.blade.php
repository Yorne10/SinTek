{{--
Company: CETAM
Project: ST
File: configure-flow.blade.php
Created on: 12/12/2025
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
                    <li class="breadcrumb-item">Administración</li>
                    <li class="breadcrumb-item">
                        <a
                            href="{{ route(config('proj.route_name_prefix', 'proj') . '.admin.define-steps', ['process_id' => $process_id]) }}">
                            Definir pasos
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Configurar flujo</li>
                </ol>
            </nav>
            <h2 class="h4">Configurar flujo del proceso</h2>
            <p class="mb-0">Define las conexiones entre los pasos del proceso.</p>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.admin.define-steps', ['process_id' => $process_id]) }}"
                class="btn btn-sm btn-outline-gray-600 d-inline-flex align-items-center">
                @icon('back', 'me-2')
                Volver
            </a>
        </div>
    </div>

    @if ($process)
        <div class="row">
            <div class="col-12 col-xl-8">
                {{-- Process Info --}}
                <div class="card border-0 shadow mb-4">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            @icon('documentSign', 'fa-lg text-primary me-3')
                            <div>
                                <h3 class="h6 mb-1">{{ $process->name }}</h3>
                                <p class="small text-gray mb-0">
                                    {{ $process->process_code ?? 'Sin código' }}
                                    @if ($isFlowValid)
                                        <span class="badge bg-success ms-2">✅ Flujo válido</span>
                                    @else
                                        <span class="badge bg-warning text-dark ms-2">⚠️ Flujo incompleto</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Initial Step Selection --}}
                <div class="card border-0 shadow mb-4">
                    <div class="card-header border-bottom">
                        <h2 class="h5 mb-0">Paso inicial</h2>
                    </div>
                    <div class="card-body">
                        <label for="initialStep" class="form-label">Selecciona el primer paso del proceso:</label>
                        <select class="form-select" id="initialStep" wire:model.live="initialStepId">
                            <option value="">-- Seleccionar paso inicial --</option>
                            @foreach ($steps->where('step_type', '!=', 'final') as $step)
                                <option value="{{ $step->step_id }}">
                                    {{ $step->title }}
                                </option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Solo los pasos que no son de tipo "Final" pueden ser el paso
                            inicial.</small>
                    </div>
                </div>

                {{-- Step Connections --}}
                <div class="card border-0 shadow mb-4">
                    <div class="card-header border-bottom">
                        <h2 class="h5 mb-0">Configurar conexiones</h2>
                    </div>
                    <div class="card-body p-0">
                        @if ($steps->count() > 0)
                            @foreach ($steps as $step)
                                <div class="border-bottom p-3 {{ $step->step_id == $initialStepId ? 'bg-light' : '' }}">
                                    <div class="d-flex align-items-start justify-content-between mb-2">
                                        <div class="d-flex align-items-center">
                                            {{-- Step Type Icon --}}
                                            @if ($step->step_type === 'form')
                                                <span class="badge bg-info me-2">📝</span>
                                            @elseif($step->step_type === 'approval')
                                                <span class="badge bg-warning text-dark me-2">✓✗</span>
                                            @elseif($step->step_type === 'file_upload')
                                                <span class="badge bg-secondary me-2">📎</span>
                                            @elseif($step->step_type === 'final')
                                                <span class="badge bg-success me-2">🏁</span>
                                            @endif

                                            <div>
                                                <span class="fw-bold">{{ $step->title }}</span>
                                                <span class="small text-muted ms-2">
                                                    ({{ $step->step_type === 'form' ? 'Formulario' : ($step->step_type === 'approval' ? 'Aprobación' : ($step->step_type === 'file_upload' ? 'Carga archivos' : 'Final')) }})
                                                </span>
                                            </div>
                                        </div>

                                        <div>
                                            @if ($step->step_id == $initialStepId)
                                                <span class="badge bg-primary">Paso inicial</span>
                                            @endif
                                            @if ($step->is_linked)
                                                <span class="badge bg-success">Vinculado</span>
                                            @endif
                                        </div>
                                    </div>

                                    @if ($step->step_type === 'final')
                                        {{-- Final steps don't need next step --}}
                                        <div class="alert alert-success py-2 mb-0">
                                            <small>@icon('success', 'me-1') Este es un paso final. Termina el proceso.</small>
                                            @if ($step->finalization_message)
                                                <div class="mt-1 small fst-italic">
                                                    "{{ Str::limit($step->finalization_message, 80) }}"</div>
                                            @endif
                                        </div>
                                    @elseif($step->step_type === 'approval' && $step->condition_question)
                                        {{-- Conditional step - needs both branches --}}
                                        <div class="bg-light rounded p-2 mb-2">
                                            <small class="text-muted">Pregunta condicional:</small>
                                            <div class="fst-italic">"{{ $step->condition_question }}"</div>
                                        </div>

                                        <div class="row g-2">
                                            <div class="col-md-6">
                                                <label class="form-label small text-success fw-bold">
                                                    @icon('success', 'me-1') Si SÍ →
                                                </label>
                                                <select class="form-select form-select-sm"
                                                    wire:model.live="connections.{{ $step->step_id }}.next_yes">
                                                    <option value="">-- Seleccionar --</option>
                                                    @foreach ($steps->where('step_id', '!=', $step->step_id) as $targetStep)
<option value="{{ $targetStep->step_id }}">
                                                            {{ $targetStep->title }}
                                                        </option>
@endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label small text-danger fw-bold">
                                                    @icon('delete', 'me-1') Si NO →
                                                </label>
                                                <select class="form-select form-select-sm"
                                                    wire:model.live="connections.{{ $step->step_id }}.next_no">
                                                    <option value="">-- Seleccionar --</option>
                                                    @foreach ($steps->where('step_id', '!=', $step->step_id) as $targetStep)
<option value="{{ $targetStep->step_id }}">
                                                            {{ $targetStep->title }}
                                                        </option>
@endforeach
                                                </select>
                                            </div>
                                        </div>
@else
{{-- Normal step - single next --}}
                                        <div class="row">
                                            <div class="col-md-8">
                                                <label class="form-label small">Paso siguiente:</label>
                                                <select class="form-select form-select-sm"
                                                    wire:model.live="connections.{{ $step->step_id }}.next_step_id">
                                                    <option value="">-- Seleccionar siguiente paso --</option>
                                                    @foreach ($steps->where('step_id', '!=', $step->step_id) as $targetStep)
                                                        <option value="{{ $targetStep->step_id }}">
                                                            {{ $targetStep->title }}
                                                            @if ($targetStep->step_type === 'final')
                                                                (Final)
                                                            @endif
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-5">
                                @icon('documentSign', 'fa-2x text-gray-400 mb-3')
                                <h5 class="text-gray-700 mb-2">No hay pasos para configurar</h5>
                                <p class="text-gray-600 mb-3">Primero debes crear los pasos del proceso.</p>
                                <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.admin.create-step', ['process_id' => $process_id]) }}"
                                    class="btn btn-sm btn-primary">
                                    @icon('add', 'me-2') Agregar paso
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Save Button --}}
                <div class="d-flex gap-2 mb-4">
                    <button type="button" class="btn btn-primary" wire:click="save" wire:loading.attr="disabled">
                        <span wire:loading wire:target="save" class="spinner-border spinner-border-sm me-2"></span>
                        @icon('save', 'me-2')
                        Guardar configuración
                    </button>
                    <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.admin.define-steps', ['process_id' => $process_id]) }}"
                        class="btn btn-outline-secondary">
                        Cancelar
                    </a>
                </div>
            </div>

            <div class="col-12 col-xl-4">
                {{-- Validation Panel --}}
                <div class="card border-0 shadow mb-4">
                    <div class="card-header border-bottom">
                        <h2 class="h5 mb-0">Validación del flujo</h2>
                    </div>
                    <div class="card-body">
                        @if (count($validationErrors) === 0 && count($validationWarnings) === 0)
                            <div class="alert alert-success mb-0">
                                <strong>✅ Flujo válido</strong>
                                <p class="small mb-0">Todas las conexiones están configuradas correctamente.</p>
                            </div>
                        @else
                            @if (count($validationErrors) > 0)
                                <div class="alert alert-danger">
                                    <strong>❌ Errores</strong>
                                    <ul class="mb-0 small ps-3">
                                        @foreach ($validationErrors as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if (count($validationWarnings) > 0)
                                <div class="alert alert-warning mb-0">
                                    <strong>⚠️ Advertencias</strong>
                                    <ul class="mb-0 small ps-3">
                                        @foreach ($validationWarnings as $warning)
                                            <li>{{ $warning }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>

                {{-- Info Panel --}}
                <div class="card border-0 shadow">
                    <div class="card-header border-bottom">
                        <h2 class="h5 mb-0">Información</h2>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled small mb-0">
                            <li class="mb-2">
                                <span class="badge bg-info me-2">📝</span>
                                <strong>Formulario:</strong> El usuario llena información
                            </li>
                            <li class="mb-2">
                                <span class="badge bg-warning text-dark me-2">✓✗</span>
                                <strong>Aprobación:</strong> Requiere decisión Sí/No
                            </li>
                            <li class="mb-2">
                                <span class="badge bg-secondary me-2">📎</span>
                                <strong>Carga archivos:</strong> El usuario sube documentos
                            </li>
                            <li>
                                <span class="badge bg-success me-2">🏁</span>
                                <strong>Final:</strong> Cierra el proceso
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-danger">
            Proceso no encontrado.
        </div>
    @endif
</div>
