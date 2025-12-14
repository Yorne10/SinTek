{{--
Company: CETAM
Project: ST
File: procedure-detail.blade.php
Created on: 04/11/2025
Created by: Alfonso Angel Garcia Hernandez
Approved by: Alfonso Angel Garcia Hernandez

Changelog:
- ID: 001 | Date: 13/12/2025
Modified by: Alfonso Angel Garcia Hernandez
Description: Redesigned view - removed folio, progress bar, help card. Added 'Go to step' button.
--}}
<div>
    {{-- Breadcrumb and Header --}}
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
        </div>

    </div>

    <div class="row">
        {{-- Main column: Procedure steps --}}
        <div class="col-12 col-xl-8 mb-4">
            <div class="card border-0 shadow">
                <div class="card-header bg-white border-0">
                    <h2 class="fs-5 fw-bold mb-0">Seguimiento del trámite</h2>
                    <p class="text-muted small mb-0">Pasos completados y paso actual</p>
                </div>
                <div class="card-body p-4">
                    @php
                        // Get completed steps
                        $completedSteps = $request->requestSteps->where('request_step_status', 'completed');

                        // Get current step (in_progress OR first pending if no in_progress)
                        $currentStep = $request->requestSteps->where('request_step_status', 'in_progress')->first();

                        // If no step is in_progress, find the first pending step as current
                        if (!$currentStep) {
                            $firstPendingStep = $request->requestSteps
                                ->where('request_step_status', 'pending')
                                ->sortBy(function ($reqStep) use ($allSteps) {
                                    $step = $allSteps->where('step_id', $reqStep->step_id)->first();
                                    return $step ? $step->order : 999;
                                })
                                ->first();
                            $currentStep = $firstPendingStep;
                        }

                        // Combine completed and current
                        $visibleStepIds = $completedSteps->pluck('step_id')->toArray();
                        if ($currentStep) {
                            $visibleStepIds[] = $currentStep->step_id;
                        }

                        // Filter allSteps to show only visible ones
                        $visibleSteps = $allSteps->whereIn('step_id', $visibleStepIds);
                    @endphp

                    @if($visibleSteps->isEmpty())
                        <div class="text-center py-5">
                            <div class="mb-3">
                                @icon('tasks', 'fa-3x text-gray-400')
                            </div>
                            <p class="text-muted">No hay pasos visibles en este momento.</p>
                        </div>
                    @else
                        {{-- Steps timeline --}}
                        <div class="timeline timeline-one-side">
                            @foreach ($visibleSteps as $step)
                                @php
                                    $requestStep = $request->requestSteps->where('step_id', $step->step_id)->first();
                                    $status = $requestStep ? $requestStep->request_step_status : 'pending';
                                    // Mark as current if in_progress OR if it's pending and is the currentStep
                                    $isCurrent = $status === 'in_progress' || ($currentStep && $currentStep->step_id == $step->step_id && $status === 'pending');
                                @endphp
                                <div class="timeline-item {{ $isCurrent ? 'current-step' : '' }}">
                                    <div class="timeline-item-content">
                                        <div class="d-flex">
                                            {{-- Step icon --}}
                                            <div class="me-3">
                                                @if ($status === 'completed')
                                                    <span class="icon-shape icon-sm bg-success text-white rounded-circle">
                                                        @icon('check', 'icon-xs')
                                                    </span>
                                                @elseif($isCurrent)
                                                    <span class="icon-shape icon-sm bg-info text-white rounded-circle">
                                                        @icon('clock', 'icon-xs')
                                                    </span>
                                                @endif
                                            </div>

                                            {{-- Step content --}}
                                            <div class="flex-grow-1">
                                                <div class="mb-2">
                                                    <h6 class="mb-1 fw-bold">
                                                        {{ $step->title }}
                                                        @if($isCurrent)
                                                            <span class="badge bg-info ms-2">Paso actual</span>
                                                        @endif
                                                    </h6>
                                                    @if ($step->description)
                                                        <p class="text-gray-600 mb-2">{{ $step->description }}</p>
                                                    @endif

                                                    @if ($status === 'completed' && $requestStep && $requestStep->step_date)
                                                        <small class="text-success">
                                                            @icon('check', 'me-1')
                                                            Completado el
                                                            {{ \Carbon\Carbon::parse($requestStep->step_date)->format('d/m/Y H:i') }}
                                                        </small>
                                                    @endif
                                                </div>

                                                {{-- Current step action button --}}
                                                @if ($isCurrent)
                                                    <div class="mt-3">
                                                        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.worker.step-detail', ['requestId' => $request->request_id, 'stepId' => $step->step_id]) }}"
                                                            class="btn btn-secondary">
                                                            Ir al paso
                                                            @icon('arrowRight', 'ms-2')
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Sidebar: Procedure information --}}
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

                    @if ($request->process->category)
                        <div class="mb-3">
                            <small class="text-gray-600 d-block mb-1">Categoría</small>
                            <p class="mb-0">{{ $request->process->category }}</p>
                        </div>
                    @endif

                    @if ($request->process->priority)
                        <div class="mb-3">
                            <small class="text-gray-600 d-block mb-1">Prioridad</small>
                            <p class="mb-0">
                                @if ($request->process->priority === 'high')
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

                    @if ($request->end_date)
                        <div class="mb-3">
                            <small class="text-gray-600 d-block mb-1">Fecha de finalización</small>
                            <p class="mb-0">{{ $request->end_date->format('d/m/Y H:i') }}</p>
                        </div>
                    @endif

                    <div class="mb-3">
                        <small class="text-gray-600 d-block mb-1">Estado actual</small>
                        <p class="mb-0">
                            @if ($request->status === 'completed')
                                <span class="fw-bold text-success">Completado</span>
                            @elseif($request->status === 'in_progress')
                                <span class="fw-bold text-warning">En proceso</span>
                            @elseif($request->status === 'pending')
                                <span class="fw-bold text-warning">Pendiente</span>
                            @elseif($request->status === 'cancelled')
                                <span class="fw-bold text-danger">Cancelado</span>
                            @else
                                <span class="fw-bold text-gray-600">{{ ucfirst($request->status) }}</span>
                            @endif
                        </p>
                    </div>

                    {{-- Action buttons --}}
                    @if ($request->status === 'in_progress')
                        <div class="mt-4 pt-3 border-top">
                            <button type="button" class="btn btn-outline-danger btn-sm w-100 cancel-procedure-btn">
                                @icon('times', 'me-2')
                                Cancelar trámite
                            </button>
                        </div>
                    @endif
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

            // Cancel procedure button
            document.addEventListener('click', function (e) {
                if (e.target.closest('.cancel-procedure-btn')) {
                    e.preventDefault();

                    swalWithBootstrapButtons.fire({
                        title: '¿Cancelar trámite?',
                        text: 'Esta acción no se puede deshacer. ¿Estás seguro de que deseas cancelar este trámite?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, cancelar',
                        cancelButtonText: 'No, mantener',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            @this.call('cancelProcedure');
                        }
                    });
                }
            });

            // Listener for Livewire notifications
            if (window.Livewire) {
                Livewire.on('procedure-updated', (event) => {
                    const detail = event || {};
                    swalWithBootstrapButtons.fire({
                        icon: detail.type || 'success',
                        title: detail.title || 'Actualizado',
                        text: detail.message || '',
                        confirmButtonText: 'Aceptar'
                    }).then(() => {
                        if (detail.redirect) {
                            window.location.href = detail.redirect;
                        }
                    });
                });
            }
        });
    </script>

    <style>
        .current-step {
            background-color: rgba(var(--bs-info-rgb), 0.05);
            border-radius: 0.5rem;
            padding: 1rem;
            margin-left: -1rem;
            margin-right: -1rem;
        }
    </style>
</div>