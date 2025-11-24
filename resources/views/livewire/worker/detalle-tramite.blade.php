<div>
    <div class="py-4">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item">
                    <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.dashboard.index') }}">
                        <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.worker.mis-tramites') }}">Mis trámites</a>
                </li>
                <li class="breadcrumb-item active">Detalle #{{ $request->request_id }}</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between">
            <div>
                <h1 class="h4">{{ $request->process->name }}</h1>
                <p class="mb-0">Trámite #{{ $request->request_id }}</p>
            </div>
            <div>
                @if($request->status === 'completed')
                    <span class="badge bg-success p-2">Completado</span>
                @elseif($request->status === 'in_progress')
                    <span class="badge bg-warning p-2">En proceso</span>
                @else
                    <span class="badge bg-info p-2">{{ $request->status }}</span>
                @endif
            </div>
        </div>
    </div>

    @if(session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session()->has('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row">
        <div class="col-12 col-lg-8 mb-4">
            <div class="card border-0 shadow">
                <div class="card-header">
                    <h5 class="mb-0">Pasos del trámite</h5>
                </div>
                <div class="card-body">
                    <div class="timeline timeline-one px-2 pt-3 pb-0">
                        @foreach($request->requestSteps->sortBy('step.order') as $requestStep)
                            <div class="timeline-item {{ $requestStep->request_step_status === 'completed' ? 'border-success' : ($requestStep->request_step_status === 'in_progress' ? 'border-warning' : 'border-gray-300') }}">
                                <div class="timeline-item-icon {{ $requestStep->request_step_status === 'completed' ? 'bg-success' : ($requestStep->request_step_status === 'in_progress' ? 'bg-warning' : 'bg-gray-300') }}">
                                    @if($requestStep->request_step_status === 'completed')
                                        <svg class="icon icon-xs text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    @elseif($requestStep->request_step_status === 'in_progress')
                                        <span class="text-white">{{ $requestStep->step->order }}</span>
                                    @else
                                        <span class="text-gray-600">{{ $requestStep->step->order }}</span>
                                    @endif
                                </div>
                                <div class="timeline-item-content">
                                    <h6 class="mb-1">{{ $requestStep->step->tittle }}</h6>
                                    <p class="text-gray-600 mb-2">{{ $requestStep->step->description }}</p>

                                    @if($requestStep->step->instructions)
                                        <p class="small text-muted mb-2">
                                            <strong>Instrucciones:</strong> {{ $requestStep->step->instructions }}
                                        </p>
                                    @endif

                                    @if($requestStep->request_step_status === 'completed')
                                        <span class="badge bg-success">Completado {{ $requestStep->step_date ? $requestStep->step_date->format('d/m/Y H:i') : '' }}</span>
                                    @elseif($requestStep->request_step_status === 'in_progress')
                                        <span class="badge bg-warning">Paso actual</span>

                                        @if($currentStep && $currentStep->step_id === $requestStep->step_id)
                                            <div class="mt-3">
                                                @if($requestStep->step->condition_type === 'conditional')
                                                    <button wire:click="conditionalStep('yes')" class="btn btn-success btn-sm me-2">
                                                        <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                        </svg>
                                                        Sí / Aprobar
                                                    </button>
                                                    <button wire:click="conditionalStep('no')" class="btn btn-danger btn-sm">
                                                        <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                        </svg>
                                                        No / Rechazar
                                                    </button>
                                                @else
                                                    <button wire:click="nextStep" class="btn btn-primary btn-sm">
                                                        Continuar al siguiente paso
                                                        <svg class="icon icon-xs ms-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    </button>
                                                @endif
                                            </div>
                                        @endif
                                    @else
                                        <span class="badge bg-secondary">Pendiente</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Información del trámite</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <span class="small text-gray-600">Proceso:</span>
                        <p class="mb-0 fw-bold">{{ $request->process->name }}</p>
                    </div>
                    <div class="mb-3">
                        <span class="small text-gray-600">Categoría:</span>
                        <p class="mb-0">{{ $request->process->category ?? 'N/A' }}</p>
                    </div>
                    <div class="mb-3">
                        <span class="small text-gray-600">Prioridad:</span>
                        <p class="mb-0">
                            <span class="badge bg-{{ $request->process->priority === 'high' ? 'danger' : ($request->process->priority === 'medium' ? 'warning' : 'info') }}">
                                {{ ucfirst($request->process->priority ?? 'N/A') }}
                            </span>
                        </p>
                    </div>
                    <div class="mb-3">
                        <span class="small text-gray-600">Fecha de inicio:</span>
                        <p class="mb-0">{{ $request->start_date ? $request->start_date->format('d/m/Y') : 'N/A' }}</p>
                    </div>
                    @if($request->end_date)
                        <div class="mb-3">
                            <span class="small text-gray-600">Fecha de finalización:</span>
                            <p class="mb-0">{{ $request->end_date->format('d/m/Y') }}</p>
                        </div>
                    @endif
                    <div>
                        <span class="small text-gray-600">Progreso:</span>
                        @php
                            $totalSteps = $request->requestSteps->count();
                            $completedSteps = $request->requestSteps->where('request_step_status', 'completed')->count();
                            $progress = $totalSteps > 0 ? round(($completedSteps / $totalSteps) * 100) : 0;
                        @endphp
                        <div class="progress mt-2" style="height: 20px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $progress }}%" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
                                {{ $progress }}%
                            </div>
                        </div>
                        <p class="small text-muted mt-1">{{ $completedSteps }} de {{ $totalSteps }} pasos completados</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
