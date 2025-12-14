{{--
Company: CETAM
Project: ST
File: create-step.blade.php
Created on: 05/11/2025
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
                                @if (auth()->user()->role === 'secretary')
                                    <li class="breadcrumb-item">Secretaria</li>
                                    <li class="breadcrumb-item">
                                        <a
                                            href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.processes') }}">
                                            Gestionar procesos
                                        </a>
                                    </li>
                                @else
                                    <li class="breadcrumb-item">Administración</li>
                                @endif
                                <li class="breadcrumb-item">
                                    <a
                                        href="{{ route(config('proj.route_name_prefix', 'proj') . '.admin.define-steps', ['process_id' => $process_id]) }}">
                                        Definir pasos
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ $isEditing ? 'Editar paso' : 'Nuevo paso' }}
                                </li>
                            </ol>
                        </nav>
                        <h2 class="h4">{{ $isEditing ? 'Editar paso' : 'Crear nuevo paso' }}</h2>
                        <p class="mb-0">
                            {{ $isEditing ? 'Modifica los detalles del paso seleccionado.' : 'Define un nuevo paso para el flujo de trabajo.' }}
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-xl-8">
                        {{-- Process Info Card --}}
                        @php
                            $selectedProcess = App\Models\Process::find($process_id);
                        @endphp
                        @if ($selectedProcess)
                            <div class="card border-0 shadow mb-4">
                                <div class="card-body">
                                    <div>
                                        <h3 class="h6 mb-1">{{ $selectedProcess->name }}</h3>
                                        @if ($selectedProcess->process_code)
                                            <p class="small text-gray mb-0">Código: {{ $selectedProcess->process_code }}</p>
                                        @endif
                                        @if ($selectedProcess->category)
                                            <p class="small text-gray mb-0">Categoría: {{ ucfirst($selectedProcess->category) }}
                                            </p>
                                        @endif
                                        @if ($selectedProcess->department)
                                            <p class="small text-gray mb-0">Área responsable: {{ $selectedProcess->department }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Step Form --}}
                        <div class="card card-body shadow border-0 mb-4">
                            <h2 class="h5 mb-4">Información del paso</h2>
                            <form wire:submit.prevent="save">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="title">Título del paso <span class="text-danger">*</span></label>
                                        <input class="form-control @error('title') is-invalid @enderror" id="title"
                                            type="text" placeholder="Ej: Revisión de documentos" wire:model="title">
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="step_type">Tipo de paso <span class="text-danger">*</span></label>
                                        @php
                                            // Count initial steps for this process (excluding current if editing)
                                            $initialStepCount = \App\Models\Step::where('process_id', $process_id)
                                                ->where(function ($q) {
                                                    $q->where('step_type', 'initial')
                                                        ->orWhere('is_initial_step', 1);
                                                })
                                                ->where('step_id', '!=', $step_id ?? 0)
                                                ->count();
                                            $showInitialOption = ($initialStepCount == 0) || ($step_type === 'initial');
                                        @endphp
                                        <select class="form-select @error('step_type') is-invalid @enderror"
                                            id="step_type" wire:model.live="step_type" @if($isEditing) disabled @endif>
                                            <option value="">Seleccionar tipo...</option>
                                            @if($showInitialOption)
                                                <option value="initial">Paso inicial</option>
                                            @endif
                                            <option value="normal">Paso normal</option>
                                            <option value="conditional">Condicional</option>
                                            <option value="final">Final</option>
                                        </select>
                                        @if($isEditing)
                                            <input type="hidden" wire:model="step_type">
                                        @endif
                                        @error('step_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="instruction">Instrucciones <span class="text-danger">*</span></label>
                                        <textarea class="form-control @error('instruction') is-invalid @enderror"
                                            id="instruction" rows="4"
                                            placeholder="Instrucciones detalladas para completar este paso..."
                                            wire:model="instruction"></textarea>
                                        @error('instruction')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Final step message --}}
                                @if ($step_type === 'final')
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="finalization_message">Mensaje de finalización <span class="text-danger">*</span></label>
                                            <textarea
                                                class="form-control @error('finalization_message') is-invalid @enderror"
                                                id="finalization_message" rows="3"
                                                placeholder="Mensaje que se mostrará al usuario cuando el proceso termine..."
                                                wire:model="finalization_message"></textarea>
                                            @error('finalization_message')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                @endif

                                {{-- Conditional step question --}}
                                @if ($step_type === 'conditional')
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="condition_question">Pregunta condicional <span class="text-danger">*</span></label>
                                            <input class="form-control @error('condition_question') is-invalid @enderror"
                                                id="condition_question" type="text"
                                                placeholder="Ej: ¿Se aprueba la solicitud?" wire:model="condition_question">
                                            @error('condition_question')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">Pregunta que determinará el siguiente paso
                                                según
                                                la
                                                respuesta.</small>
                                        </div>
                                    </div>
                                @endif

                                {{-- Documents sections only for initial and normal steps --}}
                                @if (in_array($step_type, ['initial', 'normal']))
                                    {{-- Provided Documents Section --}}
                                    <h2 class="h5 mb-3 mt-4">Documentos proporcionados</h2>
                                    <p class="small text-muted mb-3">Documentos PDF que se proporcionarán al usuario en este
                                        paso.</p>

                                    @if ($isEditing && !empty($existingProvidedDocuments))
                                        <div class="mb-4">
                                            <label class="form-label fw-bold small">Documentos actuales</label>
                                            @foreach ($existingProvidedDocuments as $docExistente)
                                                <div class="mb-2 d-flex justify-content-between align-items-center small"
                                                    wire:key="existing-provided-{{ $docExistente['id'] }}">
                                                    <div>
                                                        <span>{{ $docExistente['titulo'] }}</span>
                                                    </div>
                                                    <button type="button" class="btn btn-sm btn-danger"
                                                        wire:click="removeExistingProvidedDocument({{ $docExistente['id'] }})">
                                                        @icon('delete', 'icon-xs')
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    @foreach ($providedDocuments as $index => $documento)
                                        <div class="mb-3" wire:key="provided-doc-{{ $index }}">
                                            <label class="form-label small">Título del documento <span class="text-danger">*</span></label>
                                            <input type="text" wire:model="providedDocuments.{{ $index }}.titulo"
                                                class="form-control @error('providedDocuments.' . $index . '.titulo') is-invalid @enderror"
                                                placeholder="Ej: Formato de solicitud">
                                            @error('providedDocuments.' . $index . '.titulo')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror

                                            <label class="form-label small mt-2">Archivo PDF <span class="text-danger">*</span></label>
                                            <div class="d-flex gap-2 align-items-start">
                                                <div class="flex-grow-1">
                                                    <input type="file" wire:model="providedDocuments.{{ $index }}.archivo"
                                                        class="form-control @error('providedDocuments.' . $index . '.archivo') is-invalid @enderror"
                                                        accept=".pdf">
                                                    @error('providedDocuments.' . $index . '.archivo')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <div wire:loading wire:target="providedDocuments.{{ $index }}.archivo"
                                                        class="text-primary small mt-1">
                                                        <span class="spinner-border spinner-border-sm me-1"
                                                            role="status"></span>
                                                        Cargando archivo...
                                                    </div>
                                                </div>
                                                <button type="button" wire:click="removeProvidedDocument({{ $index }})"
                                                    class="btn btn-sm btn-danger">
                                                    @icon('delete', 'icon-xs')
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach

                                    <div class="mt-3 mb-4">
                                        <button type="button" wire:click="addProvidedDocument"
                                            class="btn btn-sm btn-secondary text-white d-inline-flex align-items-center">
                                            @icon('add', 'icon-xs me-1') Agregar documento
                                        </button>
                                    </div>

                                    {{-- Required Documents Section --}}
                                    <h2 class="h5 mb-3 mt-4">Documentos requeridos</h2>
                                    <p class="small text-muted mb-3">Documentos que el usuario deberá subir para completar
                                        este paso.</p>

                                    @if (count($documents) > 0)
                                        @foreach ($documents as $index => $doc)
                                            <div class="mb-3" wire:key="doc-{{ $index }}">
                                                <div class="d-flex align-items-center">
                                                    <input type="text"
                                                        class="form-control form-control-sm me-2 @error('documents.' . $index . '.title') is-invalid @enderror"
                                                        placeholder="Nombre del documento requerido"
                                                        wire:model="documents.{{ $index }}.title">
                                                    <button type="button" class="btn btn-sm btn-danger"
                                                        wire:click="removeDocument({{ $index }})">
                                                        @icon('delete', 'icon-xs')
                                                    </button>
                                                </div>
                                                @error('documents.' . $index . '.title')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        @endforeach
                                    @endif
                                    <div class="mt-3">
                                        <button type="button"
                                            class="btn btn-sm btn-secondary text-white d-inline-flex align-items-center"
                                            wire:click="addDocument">
                                            @icon('add', 'icon-xs me-1') Agregar documento
                                        </button>
                                    </div>
                                @endif

                                <div class="mt-3 d-flex justify-content-start gap-2 align-items-center flex-wrap">
                                    <button type="button" id="saveStepBtn" class="btn btn-primary mt-2 animate-up-2">
                                        @icon('save', 'fa-xs text-white me-2')
                                        {{ $isEditing ? 'Actualizar' : 'Guardar' }} paso
                                    </button>
                                    <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.admin.define-steps', ['process_id' => $process_id]) }}"
                                        class="btn btn-gray-300 mt-2 animate-up-2">
                                        Cancelar
                                    </a>
                                    @if ($isEditing)
                                        <button type="button" id="deleteStepBtn"
                                            class="btn btn-danger mt-2 animate-up-2 ms-md-auto">
                                            @icon('delete', 'fa-xs text-white me-2')
                                            Eliminar paso
                                        </button>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Sidebar --}}
                    <div class="col-12 col-xl-4">
                        <div class="card border-0 shadow">
                            <div class="card-body">
                                <h2 class="h6 mb-3">Información importante</h2>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item px-0">
                                        <div class="d-flex align-items-start">
                                            @icon('info', 'fa-xs text-info me-3')
                                            <div>
                                                <h3 class="h6">Tipos de paso</h3>
                                                <p class="text-gray-700 small mb-0">
                                                    <strong>Paso inicial:</strong> Primer paso del proceso<br>
                                                    <strong>Condicional:</strong> Requiere decisión Sí/No<br>
                                                    <strong>Final:</strong> Cierra el proceso
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item px-0">
                                        <div class="d-flex align-items-start">
                                            @icon('info', 'fa-xs text-info me-3')
                                            <div>
                                                <h3 class="h6">Configurar flujo</h3>
                                                <p class="text-gray-700 small mb-0">
                                                    Las conexiones entre pasos se configuran desde "Configurar flujo" en
                                                    la vista de
                                                    definir pasos.
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
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

                    // Confirmación antes de guardar
                    const saveBtn = document.getElementById('saveStepBtn');
                    if (saveBtn) {
                        saveBtn.addEventListener('click', function (e) {
                            e.preventDefault();
                            console.log('Botón de guardar clickeado');
                            const isEditing = {{ $isEditing ? 'true' : 'false' }};
                            swalWithBootstrapButtons.fire({
                                title: isEditing ? '¿Actualizar paso?' : '¿Crear paso?',
                                text: isEditing ? '¿Deseas actualizar este paso?' :
                                    '¿Deseas crear este nuevo paso?',
                                icon: 'question',
                                showCancelButton: true,
                                confirmButtonText: isEditing ? 'Sí, actualizar' : 'Sí, crear',
                                cancelButtonText: 'Cancelar',
                                reverseButtons: true
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    console.log('Confirmado, llamando a save()');
                                    try {
                                        @this.call('save').then(() => {
                                            console.log('Save llamado exitosamente');
                                        }).catch((error) => {
                                            console.error('Error al llamar save:', error);
                                            swalWithBootstrapButtons.fire({
                                                title: 'Error',
                                                text: 'Ocurrió un error al procesar la solicitud: ' +
                                                    (error.message || error),
                                                icon: 'error',
                                                confirmButtonText: 'Entendido'
                                            });
                                        });
                                    } catch (error) {
                                        console.error('Error en try-catch:', error);
                                        swalWithBootstrapButtons.fire({
                                            title: 'Error',
                                            text: 'Ocurrió un error: ' + (error.message || error),
                                            icon: 'error',
                                            confirmButtonText: 'Entendido'
                                        });
                                    }
                                }
                            });
                        });
                    } else {
                        console.error('No se encontró el botón saveStepBtn');
                    }

                    // Confirmación para eliminar
                    const deleteBtn = document.getElementById('deleteStepBtn');
                    if (deleteBtn) {
                        deleteBtn.addEventListener('click', function (e) {
                            e.preventDefault();
                            const isInitial = {{ $is_initial_step ? 'true' : 'false' }};
                            const confirmText = isInitial
                                ? 'Este es el paso inicial del proceso. Si lo eliminas, el proceso se desactivará. ¿Deseas continuar?'
                                : '¿Estás seguro de que deseas eliminar este paso?';
                            
                            swalWithBootstrapButtons.fire({
                                title: '¿Eliminar paso?',
                                text: confirmText,
                                icon: 'question',
                                showCancelButton: true,
                                confirmButtonText: 'Sí, eliminar',
                                cancelButtonText: 'Cancelar',
                                reverseButtons: true
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    @this.call('deleteStep');
                                }
                            });
                        });
                    }

                    // Escuchar evento de paso guardado
                    Livewire.on('step-saved', (data) => {
                        console.log('Evento step-saved recibido:', data);
                        swalWithBootstrapButtons.fire({
                            title: data.title || 'Éxito',
                            text: data.message || 'Operación completada.',
                            icon: 'success',
                            confirmButtonText: 'Entendido'
                        }).then(() => {
                            if (data.redirect) {
                                window.location.href = data.redirect;
                            }
                        });
                    });

                    // Escuchar evento de error
                    Livewire.on('step-error', (data) => {
                        console.error('Evento step-error recibido:', data);
                        swalWithBootstrapButtons.fire({
                            title: data.title || 'Aviso',
                            text: data.message || 'Ocurrió un error inesperado.',
                            icon: 'warning',
                            confirmButtonText: 'Entendido'
                        });
                    });
                });
            </script>
