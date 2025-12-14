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
                                    <a
                                        href="{{ route(config('proj.route_name_prefix', 'proj') . '.dashboard.index') }}">
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
                </div>

                @if ($process)
                    <div class="row">
                        <div class="col-12 col-xl-8">
                            {{-- Process Info --}}
                            <div class="card border-0 shadow mb-4">
                                <div class="card-body">
                                    <div class="d-flex align-items-start justify-content-between flex-wrap gap-2">
                                        <div>
                                            <h3 class="h6 mb-1">{{ $process->name }}</h3>
                                            @if ($process->process_code)
                                                <p class="small text-gray mb-0">Código: {{ $process->process_code }}</p>
                                            @endif
                                            @if ($process->category)
                                                <p class="small text-gray mb-0">Categoría: {{ ucfirst($process->category) }}</p>
                                            @endif
                                            @if ($process->department)
                                                <p class="small text-gray mb-0">Área responsable: {{ $process->department }}</p>
                                            @endif
                                            @if ($process->description)
                                                <p class="small text-gray-700 mb-0 mt-2">{{ $process->description }}</p>
                                            @endif
                                        </div>
                                        <div class="text-end d-flex flex-column align-items-end gap-2">
                                            @if ($process->active)
                                                <span class="fw-bold text-success">Activo</span>
                                            @else
                                                <span class="fw-bold text-warning">Inactivo</span>
                                            @endif
                                            @if ($isFlowValid)
                                                <span class="text-success fw-bold d-inline-flex align-items-center">
                                                    @icon('success', 'me-2')
                                                    Flujo válido
                                                </span>
                                            @else
                                                <span class="text-warning fw-bold d-inline-flex align-items-center">
                                                    @icon('warning', 'me-2')
                                                    Flujo incompleto
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Initial Step Display --}}
                            <div class="card border-0 shadow mb-4">
                                <div class="card-header bg-white border-0">
                                    <h2 class="h5 mb-0">Paso inicial</h2>
                                </div>
                                <div class="card-body">
                                    @php
                                        $initialStep = $steps->firstWhere('is_initial_step', true);
                                    @endphp
                                    @if ($initialStep)
                                        <p class="mb-0 fw-bold">{{ $initialStep->title }}</p>
                                    @else
                                        <p class="mb-0 text-muted">No se ha registrado un paso inicial.</p>
                                    @endif
                                </div>
                            </div>

                            {{-- Step Connections --}}
                            <div class="card border-0 shadow mb-4">
                                <div class="card-header bg-white border-0">
                                    <h2 class="h5 mb-0">Configurar conexiones</h2>
                                </div>
                                <div class="card-body p-3">
                                    @php
                                        $typeLabel = function ($stepType) {
                                            return match ($stepType) {
                                                'form' => 'Formulario',
                                                'approval' => 'Aprobación',
                                                'file_upload' => 'Carga archivos',
                                                'final' => 'Final',
                                                default => 'Normal',
                                            };
                                        };
                                        $listSteps = $displaySteps ?? $steps;
                                    @endphp
                                    @if ($listSteps->count() > 0)
                                        @foreach ($listSteps as $step)
                                            <div class="p-3 rounded mb-3 bg-white">
                                                <div class="d-flex align-items-start justify-content-between mb-2">
                                                    <div class="d-flex align-items-center">
                                                        @php
                                                            $label = 'Normal';
                                                            $labelClass = 'text-info';
                                                            if ($step->step_type === 'final') {
                                                                $label = 'Final';
                                                                $labelClass = 'text-danger';
                                                            } elseif ($step->step_type === 'conditional') {
                                                                $label = 'Condicional';
                                                                $labelClass = 'text-warning';
                                                            } elseif ($step->step_type === 'normal') {
                                                                $label = 'Normal';
                                                                $labelClass = 'text-info';
                                                            } elseif ($step->step_type === 'initial') {
                                                                $label = 'Inicial';
                                                                $labelClass = 'text-success';
                                                            }
                                                            if ($step->is_initial_step) {
                                                                $label = 'Inicial';
                                                                $labelClass = 'text-success';
                                                            }
                                                        @endphp
                                                        <div>
                                                            <span class="fw-bold">{{ $step->title }}</span>
                                                            <div class="small fw-bold {{ $labelClass }} mt-1">{{ $label }}</div>
                                                        </div>
                                                    </div>

                                                    <div class="d-flex align-items-center gap-2">
                                                        @if ($step->is_linked)
                                                            <span class="fw-bold text-success">Vinculado</span>
                                                        @endif
                                                        <span class="small text-muted">
                                                            Req: {{ $step->requiredDocuments->count() ?? 0 }} |
                                                            Prov: {{ $step->providedDocuments->count() ?? 0 }}
                                                        </span>
                                                    </div>
                                                </div>

                                                @if ($step->step_type === 'final')
                                                    {{-- Paso final: sin mensaje adicional --}}
                                                @elseif($step->step_type === 'conditional')
                                                    {{-- Conditional step - needs both branches --}}
                                                    @if ($step->condition_question)
                                                        <div class="bg-light rounded p-2 mb-2">
                                                            <small class="text-muted">Pregunta condicional:</small>
                                                            <div class="fst-italic">"{{ $step->condition_question }}"</div>
                                                        </div>
                                                    @endif

                                                    <div class="row g-2">
                                                        <div class="col-md-6">
                                                            <label class="form-label small">Si SÍ</label>
                                                            <select class="form-select form-select-sm"
                                                                wire:model.live="connections.{{ $step->step_id }}.next_yes">
                                                                <option value="">Seleccionar siguiente</option>
                                                                @foreach ($steps->where('step_id', '!=', $step->step_id) as $targetStep)
                                                                    <option value="{{ $targetStep->step_id }}">
                                                                        {{ $targetStep->title }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label small">Si NO</label>
                                                            <select class="form-select form-select-sm"
                                                                wire:model.live="connections.{{ $step->step_id }}.next_no">
                                                                <option value="">Seleccionar siguiente</option>
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
                                                                <option value="">Seleccionar siguiente</option>
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

                                    {{-- Save / Cancel buttons --}}
                                    <div class="d-flex gap-2 mt-3">
                                        <button type="button" class="btn btn-primary" id="saveFlowBtn"
                                            wire:loading.attr="disabled">
                                            <span wire:loading wire:target="save"
                                                class="spinner-border spinner-border-sm me-2"></span>
                                            @icon('save', 'me-2')
                                            Guardar configuración
                                        </button>
                                        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.admin.define-steps', ['process_id' => $process_id]) }}"
                                            class="btn btn-gray-300 text-dark">
                                            Cancelar
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-12 col-xl-4">
                            {{-- Validation Panel --}}
                            <div class="card border-0 shadow mb-4">
                                <div class="card-header bg-white border-0">
                                    <h2 class="h5 mb-0">Validación del flujo</h2>
                                </div>
                                <div class="card-body">
                                    @if (count($validationErrors) === 0 && count($validationWarnings) === 0)
                                        <div class="d-flex align-items-start gap-2">
                                            @icon('success', 'text-success')
                                            <div>
                                                <strong class="text-success d-block">Flujo válido</strong>
                                                <p class="small mb-0">Todas las conexiones están configuradas correctamente.</p>
                                            </div>
                                        </div>
                                    @else
                                        @if (count($validationErrors) > 0)
                                            <div class="mb-3">
                                                <strong class="text-danger d-inline-flex align-items-center">
                                                    @icon('error', 'me-2')
                                                    Errores
                                                </strong>
                                                <ul class="mb-0 small ps-3">
                                                    @foreach ($validationErrors as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif

                                        @if (count($validationWarnings) > 0)
                                            <div>
                                                <strong class="text-warning d-inline-flex align-items-center">
                                                    @icon('warning', 'me-2')
                                                    Advertencias
                                                </strong>
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
                        </div>
                    </div>
                @else
                    <div class="alert alert-danger">
                        Proceso no encontrado.
                    </div>
                @endif
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-primary me-2',
                            cancelButton: 'btn btn-gray'
                        },
                        buttonsStyling: false
                    });

                    const saveBtn = document.getElementById('saveFlowBtn');
                    if (saveBtn) {
                        saveBtn.addEventListener('click', function (e) {
                            e.preventDefault();
                            swalWithBootstrapButtons.fire({
                                title: '¿Guardar configuración?',
                                text: 'Se actualizará el flujo del proceso.',
                                icon: 'question',
                                showCancelButton: true,
                                confirmButtonText: 'Sí, guardar',
                                cancelButtonText: 'Cancelar',
                                reverseButtons: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    @this.call('save');
                                }
                            });
                        });
                    }

                    if (window.Livewire) {
                        Livewire.on('flow-saved', (detail) => {
                            swalWithBootstrapButtons.fire({
                                icon: detail.type || 'success',
                                title: detail.title || 'Actualizado',
                                text: detail.message || 'Flujo guardado correctamente.',
                                confirmButtonText: 'Aceptar',
                                showConfirmButton: true
                            }).then(() => {
                                if (detail.redirect) {
                                    window.location.href = detail.redirect;
                                }
                            });
                        });
                    }
                });
            </script>

            {{-- Override confirm to advertir inactividad si el flujo es inválido --}}
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const originalBtn = document.getElementById('saveFlowBtn');
                    if (!originalBtn) return;

                    // Clonar para remover listeners previos y agregar el nuestro
                    const newBtn = originalBtn.cloneNode(true);
                    originalBtn.parentNode.replaceChild(newBtn, originalBtn);

                    const flowValid = @json($isFlowValid);
                    const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-primary me-2',
                            cancelButton: 'btn btn-gray'
                        },
                        buttonsStyling: false
                    });

                    newBtn.addEventListener('click', function (e) {
                        e.preventDefault();
                        const title = '¿Guardar configuración?';
                        const text = flowValid
                            ? 'Se actualizará el flujo del proceso.'
                            : 'El flujo no es válido. El proceso se marcará como INACTIVO hasta que completes el flujo. ¿Deseas continuar?';
                        const icon = 'question';

                        swalWithBootstrapButtons.fire({
                            title,
                            text,
                            icon,
                            showCancelButton: true,
                            confirmButtonText: 'Sí, guardar',
                            cancelButtonText: 'Cancelar',
                            reverseButtons: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                @this.call('save');
                            }
                        });
                    });
                });
            </script>
