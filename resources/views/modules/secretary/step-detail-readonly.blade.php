{{--
Company: CETAM
Project: ST
File: step-detail-readonly.blade.php
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
                    <a
                        href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.worker-procedures', $worker->workers_id) }}">Historial</a>
                </li>
                <li class="breadcrumb-item">
                    <a
                        href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.procedure-detail', $request->request_id) }}">Trámite</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ $step->title }}</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">{{ $step->title }}</h1>
                <p class="mb-0">Trabajador: <strong>{{ $worker->user->name }}</strong></p>
            </div>
            <div>
                <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.procedure-detail', $request->request_id) }}"
                    class="btn btn-sm btn-gray-200 d-inline-flex align-items-center">
                    @icon('back', 'me-2')
                    Volver
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Main content --}}
        <div class="col-12 col-xl-8 mb-4">
            <div class="card border-0 shadow">
                <div class="card-header bg-white border-0">
                    <h2 class="h6 fw-bold mb-0">Información del paso</h2>
                </div>
                <div class="card-body">
                    {{-- Step instruction --}}
                    @if ($step->instruction)
                        <div class="mb-4">
                            <h6 class="fw-bold text-gray-700">Instrucciones</h6>
                            <p class="text-gray-600 mb-0">{{ $step->instruction }}</p>
                        </div>
                    @endif

                    {{-- Provided documents (documents that were provided by the step) --}}
                    @if ($step->providedDocuments && $step->providedDocuments->count() > 0)
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">Documentos proporcionados</h6>
                            <div class="table-responsive">
                                <table class="table table-centered table-sm mb-0 rounded">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="border-0 rounded-start">Documento</th>
                                            <th class="border-0 rounded-end text-start" style="width: 120px;">
                                                Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($step->providedDocuments as $doc)
                                            <tr>
                                                <td>{{ $doc->name }}</td>
                                                <td class="text-start">
                                                    <div class="btn-group position-static">
                                                        <button
                                                            class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                                                            data-bs-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            @icon('menu', 'icon-xs')
                                                        </button>
                                                        <div
                                                            class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1">
                                                            <a class="dropdown-item d-flex align-items-center"
                                                                href="{{ route(config('proj.route_name_prefix', 'proj') . '.step-provided-document.show', $doc->document_id) }}"
                                                                target="_blank">
                                                                @icon('file', 'dropdown-icon text-gray-400 me-2')
                                                                Abrir documento
                                                            </a>
                                                            <a class="dropdown-item d-flex align-items-center"
                                                                href="{{ route(config('proj.route_name_prefix', 'proj') . '.step-provided-document.download', $doc->document_id) }}">
                                                                @icon('download', 'dropdown-icon text-gray-400 me-2')
                                                                Descargar
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    {{-- Required documents (documents uploaded by the worker) --}}
                    @if ($step->requiredDocuments && $step->requiredDocuments->count() > 0)
                        @php
                            $uploadedFiles = [];
                            // Get documents from documents table by request_id and step_id
                            $documents = \App\Models\Document::where('request_id', $requestId)
                                ->where('step_id', $stepId)
                                ->get();
                            foreach ($documents as $doc) {
                                $uploadedFiles[] = [
                                    'id' => $doc->document_id,
                                    'name' => $doc->name,
                                ];
                            }
                        @endphp
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">Documentos subidos por el trabajador</h6>
                            @if (count($uploadedFiles) > 0)
                                <div class="table-responsive">
                                    <table class="table table-centered table-sm mb-0 rounded">
                                        <thead class="thead-light">
                                            <tr>
                                                <th class="border-0 rounded-start">Documento</th>
                                                <th class="border-0 rounded-end text-start" style="width: 120px;">
                                                    Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($uploadedFiles as $file)
                                                <tr>
                                                    <td>{{ $file['name'] }}</td>
                                                    <td class="text-start">
                                                        <div class="btn-group position-static">
                                                            <button
                                                                class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                                                                data-bs-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false">
                                                                @icon('menu', 'icon-xs')
                                                            </button>
                                                            <div
                                                                class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1">
                                                                <a class="dropdown-item d-flex align-items-center"
                                                                    href="{{ route(config('proj.route_name_prefix', 'proj') . '.request-document.show', $file['id']) }}"
                                                                    target="_blank">
                                                                    @icon('file', 'dropdown-icon text-gray-400 me-2')
                                                                    Abrir documento
                                                                </a>
                                                                <a class="dropdown-item d-flex align-items-center"
                                                                    href="{{ route(config('proj.route_name_prefix', 'proj') . '.request-document.download', $file['id']) }}">
                                                                    @icon('download', 'dropdown-icon text-gray-400 me-2')
                                                                    Descargar
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
                                <p class="text-muted small mb-0">No se han cargado documentos para este paso.</p>
                            @endif
                        </div>
                    @endif

                    {{-- Conditional step answer --}}
                    @if ($step->step_type === 'conditional' && $requestStep && $requestStep->conditional_answer)
                        <div class="mb-4">
                            <h6 class="fw-bold text-gray-700">Pregunta condicional</h6>
                            <p class="text-gray-600 mb-2">{{ $step->condition_question }}</p>
                            <p class="mb-0">
                                <span class="fw-bold">Respuesta:</span>
                                @if ($requestStep->conditional_answer === 'yes')
                                    <span class="text-success fw-bold">Sí</span>
                                @else
                                    <span class="text-danger fw-bold">No</span>
                                @endif
                            </p>
                        </div>
                    @endif

                    {{-- Final step message --}}
                    @if ($step->step_type === 'final' && $step->finalization_message)
                        <div class="mb-4">
                            <h6 class="fw-bold text-gray-700">Mensaje de finalización</h6>
                            <p class="text-gray-600 mb-0">{{ $step->finalization_message }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="col-12 col-xl-4">
            <div class="card border-0 shadow mb-4">
                <div class="card-header bg-white border-0">
                    <h2 class="fs-5 fw-bold mb-0">Estado del paso</h2>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-gray-600 d-block mb-1">Tipo de paso</small>
                        <p class="mb-0">
                            @if ($step->step_type === 'initial')
                                <span class="fw-bold text-success">Inicial</span>
                            @elseif($step->step_type === 'final')
                                <span class="fw-bold text-danger">Final</span>
                            @elseif($step->step_type === 'conditional')
                                <span class="fw-bold text-warning">Condicional</span>
                            @else
                                <span class="fw-bold text-info">Normal</span>
                            @endif
                        </p>
                    </div>

                    @if ($requestStep)
                        <div class="mb-3">
                            <small class="text-gray-600 d-block mb-1">Estado</small>
                            <p class="mb-0">
                                @if ($requestStep->request_step_status === 'completed')
                                    <span class="fw-bold text-success">Completado</span>
                                @elseif($requestStep->request_step_status === 'in_progress')
                                    <span class="fw-bold text-warning">En proceso</span>
                                @elseif($requestStep->request_step_status === 'cancelled')
                                    <span class="fw-bold text-danger">Cancelado</span>
                                @else
                                    <span class="fw-bold text-secondary">Pendiente</span>
                                @endif
                            </p>
                        </div>

                        @if ($requestStep->step_date)
                            <div class="mb-3">
                                <small class="text-gray-600 d-block mb-1">Fecha</small>
                                <p class="mb-0">
                                    {{ \Carbon\Carbon::parse($requestStep->step_date)->format('d/m/Y H:i') }}</p>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
