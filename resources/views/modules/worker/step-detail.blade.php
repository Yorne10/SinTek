{{--
Company: CETAM
Project: ST
File: step-detail.blade.php
Created on: 13/12/2025
Created by: Alfonso Angel Garcia Hernandez
Approved by: Alfonso Angel Garcia Hernandez

Changelog:
- ID: 001 | Date: 13/12/2025
Modified by: Alfonso Angel Garcia Hernandez
Description: Created step detail view for worker step actions
--}}

<div>
    {{-- Breadcrumb --}}
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
                            tramites</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a
                            href="{{ route(config('proj.route_name_prefix', 'proj') . '.worker.procedure-detail', ['id' => $request->request_id]) }}">{{ $request->process->name }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $step->title }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        {{-- Main column: Current step --}}
        <div class="col-12 col-xl-8 mb-4">
            <div class="card border-0 shadow">
                <div class="card-body p-4">
                    {{-- Step title --}}
                    <div class="mb-4">
                        <h3 class="h5 fw-bold">{{ $step->title }}</h3>
                        @if($step->description)
                            <p class="text-gray-600">{{ $step->description }}</p>
                        @endif
                    </div>

                    {{-- Instructions --}}
                    @if($step->instruction)
                        <div class="mb-4">
                            <h6 class="fw-bold mb-2">Instrucciones:</h6>
                            <p class="text-gray-600 mb-0">{{ $step->instruction }}</p>
                        </div>
                    @endif

                    {{-- Conditional question (for conditional steps) --}}
                    @if($step->step_type === 'conditional' && $step->condition_question)
                        <div class="mb-4">
                            <h6 class="fw-bold mb-2">Pregunta a responder:</h6>
                            <p class="text-gray-600 mb-0">{{ $step->condition_question }}</p>
                        </div>
                    @endif

                    {{-- Provided documents (if any) --}}
                    @if($step->providedDocuments && $step->providedDocuments->count() > 0)
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">Documentos disponibles</h6>
                            <div class="table-responsive">
                                <table class="table table-centered table-nowrap mb-0 rounded">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="border-0 rounded-start">Nombre</th>
                                            <th class="border-0 rounded-end text-start" style="width: 100px;">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($step->providedDocuments as $provDoc)
                                            <tr>
                                                <td>{{ $provDoc->name ?? 'Documento' }}</td>
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
                                                                href="{{ route(config('proj.route_name_prefix', 'proj') . '.step-provided-document.show', $provDoc->document_id) }}"
                                                                target="_blank">
                                                                @icon('file', 'dropdown-icon text-gray-400 me-2')
                                                                Abrir documento
                                                            </a>
                                                            <a class="dropdown-item d-flex align-items-center"
                                                                href="{{ route(config('proj.route_name_prefix', 'proj') . '.step-provided-document.download', $provDoc->document_id) }}">
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

                    {{-- Required documents (if any) --}}
                    @if($step->requiredDocuments && $step->requiredDocuments->count() > 0)
                        @php
                            $stepLocked = in_array($requestStep->request_step_status, ['completed', 'cancelled']) || in_array($request->status, ['completed', 'cancelled']);
                            $uploadedFiles = [];
                            if ($stepLocked) {
                                // First try to get documents by IDs stored in document_path
                                if ($requestStep->document_path) {
                                    $storedDocIds = json_decode($requestStep->document_path, true);
                                    if (is_array($storedDocIds) && count($storedDocIds) > 0) {
                                        $documents = \App\Models\Document::whereIn('document_id', $storedDocIds)->get();
                                        foreach ($documents as $doc) {
                                            $uploadedFiles[] = [
                                                'id' => $doc->document_id,
                                                'name' => $doc->name,
                                            ];
                                        }
                                    }
                                }
                                
                                // If no documents found by IDs, search by request_id and step_id
                                if (count($uploadedFiles) === 0) {
                                    $documents = \App\Models\Document::where('request_id', $requestId)
                                        ->where('step_id', $stepId)
                                        ->get();
                                    foreach ($documents as $doc) {
                                        $uploadedFiles[] = [
                                            'id' => $doc->document_id,
                                            'name' => $doc->name,
                                        ];
                                    }
                                }
                            }
                        @endphp
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">Documentos requeridos</h6>
                            @if($stepLocked)
                                @if(count($uploadedFiles) > 0)
                                    <div class="table-responsive">
                                        <table class="table table-centered table-nowrap mb-0 rounded">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th class="border-0 rounded-start">Nombre</th>
                                                    <th class="border-0 rounded-end text-start" style="width: 120px;">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($uploadedFiles as $file)
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
                                                                        href="{{ route(config('proj.route_name_prefix', 'proj') . '.request-document.show', $file['id']) }}" target="_blank">
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
                                    <p class="text-muted mb-0">No hay documentos cargados para este paso.</p>
                                @endif
                            @else
                                @foreach($step->requiredDocuments as $index => $reqDoc)
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">{{ $reqDoc->title }} <span
                                                class="text-danger">*</span></label>
                                        <input type="file" class="form-control" wire:model="files.{{ $index }}" accept=".pdf" x-data
                                            x-on:livewire-upload-start="window.dispatchEvent(new CustomEvent('file-uploading'))"
                                            x-on:livewire-upload-finish="window.dispatchEvent(new CustomEvent('file-uploaded'))"
                                            x-on:livewire-upload-error="window.dispatchEvent(new CustomEvent('file-uploaded'))">
                                        <div wire:loading wire:target="files.{{ $index }}" class="text-gray-600 small mt-1">
                                            <span class="spinner-border spinner-border-sm me-1"></span>
                                            Cargando archivo...
                                        </div>
                                        @error('files.' . $index)
                                            <span class="text-danger small d-block mt-1">{{ $message }}</span>
                                        @enderror
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    @endif


                    {{-- Step actions based on type --}}
                    <div class="step-actions mt-4">
                        @if($request->status === 'cancelled')
                            {{-- Cancelled request - show message where action button would be --}}
                            <div class="py-3">
                                <p class="text-danger fw-bold mb-0">Este trámite fue cancelado</p>
                            </div>
                        @elseif($request->status === 'completed')
                            {{-- Completed request - show message where action button would be --}}
                            <div class="py-3">
                                <p class="text-success fw-bold mb-0">Este trámite fue completado</p>
                            </div>
                        @elseif($requestStep->request_step_status === 'completed')
                            {{-- Already completed step --}}
                            <div class="py-3">
                                <p class="text-success fw-bold mb-0">Este paso ya fue completado</p>
                            </div>
                        @elseif($requestStep->request_step_status === 'cancelled')
                            {{-- Cancelled step --}}
                            <div class="py-3">
                                <p class="text-danger fw-bold mb-0">Este paso fue cancelado</p>
                            </div>
                        @elseif ($step->step_type === 'conditional')
                            {{-- CONDITIONAL STEP: Show Yes/No decision buttons --}}
                            <p class="text-muted mb-3">Selecciona una opción para continuar con el trámite.</p>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-primary approve-btn">
                                    Sí / Aceptar
                                </button>
                                <button type="button" class="btn btn-secondary text-white reject-btn">
                                    No / Rechazar
                                </button>
                            </div>

                        @elseif($step->step_type === 'final')
                            {{-- FINAL STEP: Show completion message --}}
                            <h6 class="fw-bold mb-3">Finalización del trámite</h6>
                            @if($step->finalization_message)
                                <p class="text-gray-600 mb-3">{{ $step->finalization_message }}</p>
                            @endif
                            <button type="button"
                                class="btn btn-primary complete-step-btn">
                                Finalizar trámite
                            </button>

                        @elseif($step->requiredDocuments && $step->requiredDocuments->count() > 0)
                            {{-- STEP WITH REQUIRED DOCUMENTS - button to submit all files --}}
                            <div wire:loading wire:target="files" class="text-gray-600 small mb-3">
                                <span class="spinner-border spinner-border-sm me-1"></span>
                                Cargando archivos...
                            </div>
                            <button type="button" id="completeWithFilesBtn"
                                class="btn btn-primary d-inline-flex align-items-center" wire:loading.attr="disabled"
                                wire:target="uploadFile, files">
                                <span wire:loading.remove wire:target="uploadFile">
                                    Marcar como completado
                                </span>
                                <span wire:loading wire:target="uploadFile">
                                    <span class="spinner-border spinner-border-sm me-1"></span>
                                    Procesando...
                                </span>
                            </button>

                        @else
                            {{-- INITIAL/NORMAL STEP: Simple completion --}}
                            <button type="button"
                                class="btn btn-primary complete-step-btn d-inline-flex align-items-center">
                                Marcar como completado
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar: Step info --}}
        <div class="col-12 col-xl-4">
            {{-- Step info --}}
            <div class="card border-0 shadow">
                <div class="card-header bg-white border-0">
                    <h2 class="fs-5 fw-bold mb-0">Información del paso</h2>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-gray-600 d-block mb-1">Trámite</small>
                        <p class="mb-0 fw-semibold">{{ $request->process->name }}</p>
                    </div>
                    <div class="mb-3">
                        <small class="text-gray-600 d-block mb-1">Estado del paso</small>
                        <p class="mb-0">
                            @if($requestStep->request_step_status === 'completed')
                                <span class="fw-bold text-success">Completado</span>
                            @elseif($requestStep->request_step_status === 'in_progress')
                                <span class="fw-bold text-info">En proceso</span>
                            @elseif($requestStep->request_step_status === 'cancelled')
                                <span class="fw-bold text-danger">Cancelado</span>
                            @else
                                <span class="fw-bold text-warning">Pendiente</span>
                            @endif
                        </p>
                    </div>
                    @if(($requestStep->request_step_status === 'completed' || $requestStep->request_step_status === 'cancelled') && $requestStep->step_date)
                        <div>
                            <small
                                class="text-gray-600 d-block mb-1">{{ $requestStep->request_step_status === 'cancelled' ? 'Fecha de cancelación' : 'Fecha de completado' }}</small>
                            <p class="mb-0">{{ \Carbon\Carbon::parse($requestStep->step_date)->format('d/m/Y H:i') }}</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Info card when there are required documents --}}
            @if($step->requiredDocuments && $step->requiredDocuments->count() > 0)
                <div class="card border-0 shadow mt-4">
                    <div class="card-body">
                        <h2 class="h6 mb-3">Información importante</h2>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item px-0">
                                <div class="d-flex align-items-start">
                                    @icon('file', 'fa-xs text-info me-3')
                                    <div>
                                        <h3 class="h6">Formato</h3>
                                        <p class="text-gray-700 small mb-0">
                                            Solo se permiten archivos en formato <strong>PDF</strong>.
                                        </p>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item px-0">
                                <div class="d-flex align-items-start">
                                    @icon('info', 'fa-xs text-info me-3')
                                    <div>
                                        <h3 class="h6">Tamaño máximo</h3>
                                        <p class="text-gray-700 small mb-0">
                                            Cada archivo no debe superar los <strong>10 MB</strong>.
                                        </p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            @endif
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

        // File upload tracking
        let fileUploading = false;

        window.addEventListener('file-uploading', () => {
            fileUploading = true;
        });

        window.addEventListener('file-uploaded', () => {
            fileUploading = false;
        });

        // Complete step with files button
        document.getElementById('completeWithFilesBtn')?.addEventListener('click', function (e) {
            e.preventDefault();

            // If files are still uploading, show warning
            if (fileUploading) {
                Swal.fire({
                    title: 'Archivos en proceso',
                    text: 'Por favor espera a que terminen de cargar los archivos antes de continuar.',
                    icon: 'warning',
                    confirmButtonText: 'Entendido',
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    },
                    buttonsStyling: false
                });
                return;
            }

            // Show confirmation and call uploadFile
            swalWithBootstrapButtons.fire({
                title: '¿Completar este paso?',
                text: 'Se guardarán los documentos y se marcará como completado.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, completar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('uploadFile');
                }
            });
        });

        // Complete step button (without files)
        document.addEventListener('click', function (e) {
            if (e.target.closest('.complete-step-btn')) {
                e.preventDefault();

                swalWithBootstrapButtons.fire({
                    title: '¿Completar este paso?',
                    text: 'Se marcará como completado y avanzarás al siguiente.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, completar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.call('completeStep');
                    }
                });
            }
        });

        // Approve button
        document.addEventListener('click', function (e) {
            if (e.target.closest('.approve-btn')) {
                e.preventDefault();

                swalWithBootstrapButtons.fire({
                    title: '¿Confirmas la opción "Sí / Aceptar"?',
                    text: 'Se aprobará esta decisión y continuará el flujo.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, confirmar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.call('conditionalStep', 'yes');
                    }
                });
            }
        });

        // Reject button
        document.addEventListener('click', function (e) {
            if (e.target.closest('.reject-btn')) {
                e.preventDefault();

                swalWithBootstrapButtons.fire({
                    title: '¿Confirmas la opción "No / Rechazar"?',
                    text: 'Se rechazará esta decisión y se tomará la acción alternativa.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, confirmar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.call('conditionalStep', 'no');
                    }
                });
            }
        });

        // Listen for step completion
        if (window.Livewire) {
            Livewire.on('step-completed', (event) => {
                const detail = event || {};
                swalWithBootstrapButtons.fire({
                    icon: 'success',
                    title: detail.title || '¡Completado!',
                    text: detail.message || '',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    if (detail.redirectUrl) {
                        window.location.href = detail.redirectUrl;
                    }
                });
            });

            // Listen for connection errors
            Livewire.hook('request', ({ fail }) => {
                fail(({ status, preventDefault }) => {
                    preventDefault();
                    swalWithBootstrapButtons.fire({
                        icon: 'error',
                        title: 'Error de conexión',
                        text: 'No se pudo conectar con el servidor. Por favor, verifica tu conexión a internet e intenta de nuevo.',
                        confirmButtonText: 'Entendido'
                    });
                });
            });
        }
    });
</script>
