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
            <h2 class="h4">Detalles del trámite</h2>
        </div>

    </div>

    <div class="row">
        {{-- Main column: Procedure steps --}}
        <div class="col-12 col-xl-8 mb-4">
            <div class="card border-0 shadow">
                <div
                    class="card-header bg-white border-0 d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <div>
                        <h2 class="h6 fw-bold mb-2">Seguimiento del trámite</h2>
                        <p class="mb-1"><span class="text-muted">Trámite:</span> <span class="fw-semibold">{{ $request->process->name }}</span></p>
                        <p class="text-muted small mb-0">Pasos completados y paso actual</p>
                    </div>
                </div>
                <div class="card-body p-4">
                    @php
                        // Get completed steps
                        $completedSteps = $request->requestSteps->where('request_step_status', 'completed');

                        // Only calculate a current step when the request is active
                        $currentStep = null;
                        if ($request->status !== 'completed' && $request->status !== 'cancelled') {
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
                        {{-- Steps table --}}
                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap mb-0 rounded align-items-center">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="border-0 rounded-start" style="width: 10%">#</th>
                                        <th class="border-0" style="width: 50%">Paso</th>
                                        <th class="border-0" style="width: 20%">Estado</th>
                                        <th class="border-0 rounded-end" style="width: 20%">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($visibleSteps as $step)
                                        @php
                                            $requestStep = $request->requestSteps->where('step_id', $step->step_id)->first();
                                            $status = $requestStep ? $requestStep->request_step_status : 'pending';
                                            $isCurrent = $status === 'in_progress' || ($currentStep && $currentStep->step_id == $step->step_id && $status === 'pending');
                                        @endphp
                                        <tr>
                                            {{-- Step number --}}
                                            <td>
                                                @if ($status === 'completed')
                                                    <span class="fw-bold text-success">{{ $loop->iteration }}</span>
                                                @else
                                                    <span class="fw-bold">{{ $loop->iteration }}</span>
                                                @endif
                                            </td>

                                            {{-- Step title --}}
                                            <td>
                                                <div>
                                                    <span class="fw-bold text-gray-900">{{ $step->title }}</span>
                                                </div>
                                            </td>

                                            {{-- Status --}}
                                            <td>
                                                @if ($status === 'completed')
                                                    <span class="text-success fw-bold">Completado</span>
                                                @elseif ($isCurrent)
                                                    <span class="text-info fw-bold">Paso actual</span>
                                                @else
                                                    <span class="text-secondary fw-bold">Pendiente</span>
                                                @endif
                                            </td>


                                            {{-- Action menu --}}
                                            <td>
                                                @if ($status === 'completed' || $isCurrent)
                                                                                <div class="btn-group position-static">
                                                                                    <button
                                                                                        class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                                                                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                        @icon('menu', 'icon icon-xs')
                                                                                    </button>
                                                                                    <div class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1">
                                                                                        <a class="dropdown-item d-flex align-items-center" href="{{ route(config('proj.route_name_prefix', 'proj') . '.worker.step-detail', [
                                                        'requestId' => $request->request_id,
                                                        'stepId' => $step->step_id,
                                                        'readonly' => $status === 'completed' ? 'true' : 'false'
                                                    ]) }}">
                                                                                            @icon('checkList', 'dropdown-icon text-gray-400 me-2')
                                                                                            @if ($status === 'completed')
                                                                                                Ver paso
                                                                                            @else
                                                                                                Ir al paso
                                                                                            @endif
                                                                                        </a>
                                                                                    </div>
                                                                                </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    @if ($request->status === 'in_progress')
                        <div class="d-flex justify-content-end mt-4 pt-3">
                            <button type="button"
                                class="btn btn-danger btn-sm d-inline-flex align-items-center cancel-procedure-btn">
                                @icon('cancel', 'me-2 text-white')
                                <span class="text-white">Cancelar trámite</span>
                            </button>
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
                    @if ($request->process->category)
                        <div class="mb-3">
                            <small class="text-gray-600 d-block mb-1">Categoría</small>
                            <p class="mb-0">{{ $request->process->category }}</p>
                        </div>
                    @endif

                    @if ($request->process->department)
                        <div class="mb-3">
                            <small class="text-gray-600 d-block mb-1">Área</small>
                            <p class="mb-0">{{ $request->process->department }}</p>
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

            // Check if process is inactive and show warning
            const processActive = @json($request->process->active ?? true);
            if (!processActive) {
                swalWithBootstrapButtons.fire({
                    title: 'Proceso inactivo',
                    text: 'El proceso de este trámite se encuentra temporalmente inactivo. No podrás avanzar hasta que se reactive.',
                    icon: 'warning',
                    confirmButtonText: 'Entendido'
                });
            }

            // Cancel procedure button
            document.addEventListener('click', function (e) {
                if (e.target.closest('.cancel-procedure-btn')) {
                    e.preventDefault();

                    swalWithBootstrapButtons.fire({
                        title: '¿Cancelar trámite?',
                        text: 'Esta acción no se puede deshacer. ¿Estás seguro de que deseas cancelar este trámite?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, cancelar',
                        cancelButtonText: 'Cancelar',
                        reverseButtons: false
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
</div>
