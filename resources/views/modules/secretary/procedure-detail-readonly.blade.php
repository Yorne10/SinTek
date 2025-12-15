{{--
Company: CETAM
Project: ST
File: procedure-detail-readonly.blade.php
Created on: 14/12/2025
Created by: Alfonso Angel Garcia Hernandez
Approved by: Alfonso Angel Garcia Hernandez

Changelog:
- ID: <ID> | Date: dd/mm/yyyy
    Modified by: <Developer name>
    Description: <Brief description of change>
--}}
<div>
    {{-- Page Header --}}
    <div class="py-4">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item">
                    <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.dashboard.index') }}">
                        @icon('home', 'fa-xs')
                    </a>
                </li>
                <li class="breadcrumb-item">Secretaría</li>
                <li class="breadcrumb-item">
                    <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.search-workers') }}">Buscar
                        trabajadores</a>
                </li>
                <li class="breadcrumb-item">
                    <a
                        href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.worker-procedures', $worker->workers_id) }}">Historial</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Detalle del trámite</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Detalle del trámite</h1>
                <p class="mb-0">Trabajador: <strong>{{ $worker->user->name }}</strong></p>
            </div>
            <div>
                <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.worker-procedures', $worker->workers_id) }}"
                    class="btn btn-sm btn-gray-200 d-inline-flex align-items-center">
                    @icon('back', 'me-2')
                    Volver
                </a>
            </div>
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
                        <p class="mb-1"><span class="text-muted">Trámite:</span> <span
                                class="fw-semibold">{{ $request->process->name }}</span></p>
                        <p class="text-muted small mb-0">Vista de solo lectura</p>
                    </div>
                </div>
                <div class="card-body p-4">
                    @php
                        // Get all request steps (completed, in_progress, cancelled)
                        $visibleRequestSteps = $request->requestSteps->whereIn('request_step_status', [
                            'completed',
                            'in_progress',
                            'cancelled',
                        ]);

                        // Get visible step IDs
                        $visibleStepIds = $visibleRequestSteps->pluck('step_id')->toArray();

                        // Filter allSteps to show only visible ones and keep order
                        $visibleSteps = $allSteps->whereIn('step_id', $visibleStepIds)->sortBy('order');
                    @endphp

                    @if ($visibleSteps->isEmpty())
                        <div class="text-center py-5">
                            <div class="mb-3">
                                @icon('tasks', 'fa-3x text-gray-400')
                            </div>
                            <p class="text-muted">No hay pasos registrados en este trámite.</p>
                        </div>
                    @else
                        {{-- Steps table --}}
                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap mb-0 rounded align-items-center">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="border-0 rounded-start" style="width: 10%">#</th>
                                        <th class="border-0" style="width: 40%">Paso</th>
                                        <th class="border-0" style="width: 20%">Estado</th>
                                        <th class="border-0" style="width: 15%">Fecha</th>
                                        <th class="border-0 rounded-end" style="width: 15%">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($visibleSteps as $step)
                                        @php
                                            $requestStep = $request->requestSteps
                                                ->where('step_id', $step->step_id)
                                                ->first();
                                            $status = $requestStep ? $requestStep->request_step_status : 'pending';
                                        @endphp
                                        <tr>
                                            {{-- Step number --}}
                                            <td>
                                                @if ($status === 'completed')
                                                    <span class="fw-bold text-success">{{ $loop->iteration }}</span>
                                                @elseif ($status === 'cancelled')
                                                    <span class="fw-bold text-danger">{{ $loop->iteration }}</span>
                                                @else
                                                    <span class="fw-bold text-warning">{{ $loop->iteration }}</span>
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
                                                @elseif ($status === 'in_progress')
                                                    <span class="text-warning fw-bold">En proceso</span>
                                                @elseif ($status === 'cancelled')
                                                    <span class="text-danger fw-bold">Cancelado</span>
                                                @else
                                                    <span class="text-secondary fw-bold">Pendiente</span>
                                                @endif
                                            </td>

                                            {{-- Date --}}
                                            <td>
                                                @if ($requestStep && $requestStep->step_date)
                                                    <span
                                                        class="small">{{ \Carbon\Carbon::parse($requestStep->step_date)->format('d/m/Y') }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>

                                            {{-- Action menu --}}
                                            <td>
                                                <div class="btn-group position-static">
                                                    <button
                                                        class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                                                        data-bs-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        @icon('menu', 'icon icon-xs')
                                                    </button>
                                                    <div
                                                        class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1">
                                                        <a class="dropdown-item d-flex align-items-center"
                                                            href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.step-detail', [
                                                                'requestId' => $request->request_id,
                                                                'stepId' => $step->step_id,
                                                            ]) }}">
                                                            @icon('view', 'dropdown-icon text-gray-400 me-2')
                                                            Ver paso
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
                        <small class="text-gray-600 d-block mb-1">Trabajador</small>
                        <p class="mb-0 fw-semibold">{{ $worker->user->name }}</p>
                    </div>

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
</div>
