{{--
* Company: CETAM
* Project: ST
* File: detalle-tramite.blade.php
* Created on: 04/11/2025
* Created by: Alfonso Angel Garca Hernndez
* Approved by: Alfonso Angel Garca Hernndez
*
* Changelog:
* - ID: <ID> | Modified on: 24/11/2025 |
    * Modified by: Codex |
    * Description: Improved design and fixed encoding issues
    --}}
    <div>
        {{-- Breadcrumb y Header --}}
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
            <div class="d-block mb-4 mb-md-0">
                <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                    <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                        <li class="breadcrumb-item">
                            <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.dashboard.index') }}">
                                @icon('home', 'fa-xs')
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.worker.my-procedures') }}">Mis
                                trámites</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Detalle del trámite</li>
                    </ol>
                </nav>
                <h2 class="h4">{{ $request->process->name }}</h2>
                <p class="mb-0">Folio: <span class="fw-bold">#{{ $request->request_id }}</span></p>
            </div>
            <div class="btn-toolbar mb-2 mb-md-0">
                @if($request->status === 'completed')
                    <span class="fw-bold text-success">
                        <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Completado
                    </span>
                @elseif($request->status === 'in_progress')
                    <span class="fw-bold text-info">
                        <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                clip-rule="evenodd"></path>
                        </svg>
                        En proceso
                    </span>
                @elseif($request->status === 'pending')
                    <span class="fw-bold text-warning">
                        <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Pendiente
                    </span>
                @else
                    <span class="fw-bold text-gray-600">{{ ucfirst($request->status) }}</span>
                @endif
            </div>
        </div>

        <div class="row">
            {{-- Columna principal: Pasos del trámite --}}
            <div class="col-12 col-xl-8 mb-4">
                <div class="card border-0 shadow">
                    <div class="card-header bg-white border-0">
                        <h2 class="fs-5 fw-bold mb-0">Seguimiento del trámite</h2>
                        <p class="text-muted small mb-0">Progreso y pasos completados</p>
                    </div>
                    <div class="card-body p-4">
                        {{-- Barra de progreso --}}
                        @php
                            $totalSteps = $request->requestSteps->count();
                            $completedSteps = $request->requestSteps->where('request_step_status', 'completed')->count();
                            $progress = $totalSteps > 0 ? round(($completedSteps / $totalSteps) * 100) : 0;
                        @endphp
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-semibold text-gray-800">Progreso general</span>
                                <span class="fw-bold text-primary">{{ $progress }}%</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $progress }}%"
                                    aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>

                        {{-- Timeline de pasos --}}
                        <div class="timeline timeline-one-side mt-4">
                            @foreach($allSteps as $step)
                                @php
                                    $requestStep = $request->requestSteps->where('step_id', $step->step_id)->first();
                                    $status = $requestStep ? $requestStep->request_step_status : 'pending';
                                    $isCurrent = $status === 'in_progress';
                                @endphp
                                <div class="timeline-item">
                                    <div class="timeline-item-content">
                                        <div class="d-flex">
                                            {{-- Icono del paso --}}
                                            <div class="me-3">
                                                @if($status === 'completed')
                                                    <span class="icon-shape icon-sm bg-success text-white rounded-circle">
                                                        <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                                    </span>
                                                @elseif($status === 'in_progress')
                                                    <span class="icon-shape icon-sm bg-info text-white rounded-circle">
                                                        <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path></svg>
                                                    </span>
                                                @else
                                                    <span class="icon-shape icon-sm bg-gray-200 text-gray-600 rounded-circle">
                                                        {{ $step->order }}
                                                    </span>
                                                @endif
                                            </div>

                                            {{-- Contenido del paso --}}
                                            <div class="flex-grow-1">
                                                <div class="mb-2">
                                                    <h6 class="mb-1 fw-bold">{{ $step->tittle }}</h6>
                                                    @if($step->description)
                                                        <p class="text-gray-600 mb-2">{{ $step->description }}</p>
                                                    @endif

                                                    @if($step->instructions)
                                                        <div class="alert alert-light mb-2" role="alert">
                                                            <small class="fw-semibold">Instrucciones: </small>
                                                            <small>{{ $step->instructions }}</small>
                                                        </div>
                                                    @endif
                                                </div>

                                                {{-- Acciones del paso actual --}}
                                                @if($isCurrent)
                                                    <div class="mt-3">
                                                        @if($step->condition_type === 'upload')
                                                            <div class="mb-3">
                                                                <label class="form-label">Subir documento requerido</label>
                                                                <input type="file" class="form-control" wire:model="file">
                                                                @error('file') <span class="text-danger small">{{ $message }}</span> @enderror
                                                            </div>
                                                            <button type="button" class="btn btn-primary btn-sm" 
                                                                wire:click="uploadFile" 
                                                                wire:loading.attr="disabled"
                                                                wire:target="uploadFile, file">
                                                                <span wire:loading.remove wire:target="uploadFile">Subir y Completar</span>
                                                                <span wire:loading wire:target="uploadFile">Subiendo...</span>
                                                            </button>
                                                        @elseif($step->condition_type === 'conditional')
                                                            <button type="button" class="btn btn-success btn-sm me-2 next-step-btn" data-action="yes">
                                                                Sí / Aprobar
                                                            </button>
                                                            <button type="button" class="btn btn-danger btn-sm reject-step-btn" data-action="no">
                                                                No / Rechazar
                                                            </button>
                                                        @else
                                                            <button type="button" class="btn btn-primary btn-sm continue-step-btn">
                                                                Continuar al siguiente paso
                                                            </button>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Columna lateral: Información del trámite --}}
            <div class="col-12 col-xl-4">
                <div class="card border-0 shadow mb-4">
                    <div class="card-header bg-white border-0">
                        <h2 class="fs-5 fw-bold mb-0">Información del trámite</h2>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <small class="text-gray-600 d-block mb-1">Proceso</small>
                            <p class="mb-0 fw-semibold">{{ $request->process->name }}</p>
                        </div>

                        @if($request->process->category)
                            <div class="mb-3">
                                <small class="text-gray-600 d-block mb-1">Categoría</small>
                                <p class="mb-0">{{ $request->process->category }}</p>
                            </div>
                        @endif

                        @if($request->process->priority)
                            <div class="mb-3">
                                <small class="text-gray-600 d-block mb-1">Prioridad</small>
                                <p class="mb-0">
                                    @if($request->process->priority === 'high')
                                        <span class="fw-bold text-danger">Alta</span>
                                    @elseif($request->process->priority === 'medium')
                                        <span class="fw-bold text-warning">Media</span>
                                    @else
                                        <span class="fw-bold text-info">Baja</span>
                                    @endif
                                </p>
                            </div>
                        @endif

                        <div class="mb-3">
                            <small class="text-gray-600 d-block mb-1">Fecha de inicio</small>
                            <p class="mb-0">
                                {{ $request->start_date ? $request->start_date->format('d/m/Y H:i') : 'N/A' }}
                            </p>
                        </div>

                        @if($request->end_date)
                            <div class="mb-3">
                                <small class="text-gray-600 d-block mb-1">Fecha de finalización</small>
                                <p class="mb-0">{{ $request->end_date->format('d/m/Y H:i') }}</p>
                            </div>
                        @endif

                        <div class="mb-3">
                            <small class="text-gray-600 d-block mb-1">Estado actual</small>
                            <p class="mb-0">
                                @if($request->status === 'completed')
                                    <span class="fw-bold text-success">Completado</span>
                                @elseif($request->status === 'in_progress')
                                    <span class="fw-bold text-info">En proceso</span>
                                @elseif($request->status === 'pending')
                                    <span class="fw-bold text-warning">Pendiente</span>
                                @else
                                    <span class="fw-bold text-gray-600">{{ ucfirst($request->status) }}</span>
                                @endif
                            </p>
                        </div>

                        <div>
                            <small class="text-gray-600 d-block mb-1">Pasos completados</small>
                            <p class="mb-2 fw-semibold">{{ $completedSteps }} / {{ $totalSteps }}</p>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-success" role="progressbar"
                                    style="width: {{ $progress }}%">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card de ayuda --}}
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <div class="d-flex align-items-start">
                            <svg class="icon icon-sm text-info me-3 flex-shrink-0" fill="currentColor"
                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <h6 class="fw-bold mb-2">Necesitas ayuda?</h6>
                                <p class="small text-muted mb-2">Si tienes dudas sobre tu trámite,
                                    contacta al área de
                                    Recursos Humanos.</p>
                                <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.faq') }}"
                                    class="btn btn-sm btn-outline-info">
                                    Ver preguntas frecuentes
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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

            // Botón continuar paso normal
            document.addEventListener('click', function (e) {
                if (e.target.closest('.continue-step-btn')) {
                    e.preventDefault();

                    swalWithBootstrapButtons.fire({
                        title: '¿Continuar al siguiente paso?',
                        text: 'Se marcará este paso como completado y avanzarás al siguiente.',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, continuar',
                        cancelButtonText: 'Cancelar',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            @this.call('nextStep');
                        }
                    });
                }
            });

            // Botón paso condicional - Aprobar
            document.addEventListener('click', function (e) {
                if (e.target.closest('.next-step-btn')) {
                    e.preventDefault();
                    const action = e.target.closest('.next-step-btn').getAttribute('data-action');

                    swalWithBootstrapButtons.fire({
                        title: '¿Aprobar y continuar?',
                        text: 'Se aprobará este paso y se continuará con el flujo.',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, aprobar',
                        cancelButtonText: 'Cancelar',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            @this.call('conditionalStep', action);
                        }
                    });
                }
            });

            // Botón paso condicional - Rechazar
            document.addEventListener('click', function (e) {
                if (e.target.closest('.reject-step-btn')) {
                    e.preventDefault();
                    const action = e.target.closest('.reject-step-btn').getAttribute('data-action');

                    swalWithBootstrapButtons.fire({
                        title: '¿Rechazar este paso?',
                        text: 'Se rechazará este paso y se tomará la acción alternativa.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, rechazar',
                        cancelButtonText: 'Cancelar',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            @this.call('conditionalStep', action);
                        }
                    });
                }
            });

            // Listener para notificaciones de Livewire
            if (window.Livewire) {
                Livewire.on('step-updated', (event) => {
                    const detail = event || {};
                    swalWithBootstrapButtons.fire({
                        icon: detail.type || 'success',
                        title: detail.title || 'Actualizado',
                        text: detail.message || '',
                        confirmButtonText: 'Aceptar'
                    });
                });
            }
        });
    </script>
