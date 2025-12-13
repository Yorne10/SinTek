{{--
Company: CETAM
Project: ST
File: create-step.blade.php
Created on: 05/11/2025
Created by: Alfonso Angel Garcia Hernandez
Approved by: Alfonso Angel Garcia Hernandez

Changelog:
- ID: 002 | Modified on: 12/12/2025 |
Modified by: Claude Code |
Description: Simplified form, removed process dropdown, show process info card instead.

- ID: 003 | Modified on: 12/12/2025 |
Modified by: Claude Code |
Description: Added SweetAlert confirmation and success alerts following application standard pattern.
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
                    @if(auth()->user()->role === 'secretary')
                        <li class="breadcrumb-item">Secretaria</li>
                        <li class="breadcrumb-item">
                            <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.processes') }}">
                                Gestionar procesos
                            </a>
                        </li>
                    @else
                        <li class="breadcrumb-item">Administracion</li>
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
            @if($selectedProcess)
                <div class="card border-0 shadow mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            @icon('documentSign', 'fa-lg text-primary me-3')
                            <div>
                                <h3 class="h6 mb-1">{{ $selectedProcess->name }}</h3>
                                <p class="small text-gray mb-0">
                                    @if($selectedProcess->process_code)
                                        CÃ³digo: {{ $selectedProcess->process_code }}
                                    @endif
                                    @if($selectedProcess->category)
                                        | CategorÃ­a: {{ ucfirst($selectedProcess->category) }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Step Form --}}
            <div class="card card-body shadow border-0 mb-4">
                <h2 class="h5 mb-4">InformaciÃ³n del paso</h2>
                <form wire:submit.prevent="save">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="title">TÃ­tulo del paso <span class="text-danger">*</span></label>
                            <input class="form-control @error('title') is-invalid @enderror" id="title" type="text"
                                placeholder="Ej: RevisiÃ³n de documentos" wire:model="title">
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="step_type">Tipo de paso <span class="text-danger">*</span></label>
                            <select class="form-select @error('step_type') is-invalid @enderror" id="step_type"
                                wire:model.live="step_type">
                                <option value="">Seleccionar tipo...</option>
                                <option value="initial">Paso inicial</option>
                                <option value="conditional">Condicional</option>
                                <option value="final">Final</option>
                            </select>
                            @error('step_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="instruction">Instrucciones</label>
                            <textarea class="form-control @error('instruction') is-invalid @enderror" id="instruction"
                                rows="4" placeholder="Instrucciones detalladas para completar este paso..."
                                wire:model="instruction"></textarea>
                            @error('instruction') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="form-text text-muted">Estas instrucciones serÃ¡n mostradas al usuario
                                responsable.</small>
                        </div>
                    </div>

                    {{-- Final step message --}}
                    @if($step_type === 'final')
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="finalization_message">Mensaje de finalizaciÃ³n</label>
                                <textarea class="form-control @error('finalization_message') is-invalid @enderror"
                                    id="finalization_message" rows="3"
                                    placeholder="Mensaje que se mostrarÃ¡ al usuario cuando el proceso termine..."
                                    wire:model="finalization_message"></textarea>
                                @error('finalization_message') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    @endif

                    {{-- Conditional step question --}}
                    @if($step_type === 'conditional')
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="condition_question">Pregunta condicional</label>
                                <input class="form-control @error('condition_question') is-invalid @enderror"
                                    id="condition_question" type="text" placeholder="Ej: Â¿Se aprueba la solicitud?"
                                    wire:model="condition_question">
                                @error('condition_question') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <small class="form-text text-muted">Pregunta que determinarÃ¡ el siguiente paso segÃºn la
                                    respuesta.</small>
                            </div>
                        </div>
                    @endif

                    <h2 class="h5 mb-3 mt-4">Documentos requeridos</h2>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="requires_documents"
                                    wire:model.live="requires_documents">
                                <label class="form-check-label" for="requires_documents">
                                    Este paso requiere documentos
                                </label>
                            </div>
                        </div>
                    </div>

                    @if($requires_documents)
                        <div class="card border-light shadow-sm mb-3">
                            <div class="card-body">
                                @if(count($documents) > 0)
                                    @foreach($documents as $index => $doc)
                                        <div class="d-flex align-items-center mb-2">
                                            <input type="text" class="form-control form-control-sm me-2"
                                                placeholder="Nombre del documento requerido"
                                                wire:model="documents.{{ $index }}.title">
                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                wire:click="removeDocument({{ $index }})">
                                                @icon('delete')
                                            </button>
                                        </div>
                                    @endforeach
                                @endif
                                <button type="button" class="btn btn-sm btn-outline-primary" wire:click="addDocument">
                                    @icon('add', 'me-1') Agregar documento
                                </button>
                            </div>
                        </div>
                    @endif

                    <div class="mt-3 d-flex justify-content-start gap-2">
                        <button type="button" id="saveStepBtn" class="btn btn-primary mt-2 animate-up-2">
                            @icon('save', 'fa-xs text-white me-2')
                            {{ $isEditing ? 'Actualizar' : 'Guardar' }} paso
                        </button>
                        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.admin.define-steps', ['process_id' => $process_id]) }}"
                            class="btn btn-gray-300 mt-2 animate-up-2">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="col-12 col-xl-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <h2 class="h6 mb-3">InformaciÃ³n importante</h2>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0">
                            <div class="d-flex align-items-start">
                                @icon('info', 'fa-xs text-info me-3')
                                <div>
                                    <h3 class="h6">Tipos de paso</h3>
                                    <p class="text-gray-700 small mb-0">
                                        <strong>Paso inicial:</strong> Primer paso del proceso<br>
                                        <strong>Condicional:</strong> Requiere decisiÃ³n SÃ­/No<br>
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
                                        Las conexiones entre pasos se configuran desde "Configurar flujo" en la vista de
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

        // ConfirmaciÃ³n antes de guardar
        const saveBtn = document.getElementById('saveStepBtn');
        if (saveBtn) {
            saveBtn.addEventListener('click', function (e) {
                e.preventDefault();
                console.log('BotÃ³n de guardar clickeado');
                const isEditing = {{ $isEditing ? 'true' : 'false' }};
                swalWithBootstrapButtons.fire({
                    title: isEditing ? 'Â¿Actualizar paso?' : 'Â¿Crear paso?',
                    text: isEditing ? 'Â¿Deseas actualizar este paso?' : 'Â¿Deseas crear este nuevo paso?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: isEditing ? 'SÃ­, actualizar' : 'SÃ­, crear',
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
                                    text: 'OcurriÃ³ un error al procesar la solicitud: ' + (error.message || error),
                                    icon: 'error',
                                    confirmButtonText: 'Entendido'
                                });
                            });
                        } catch (error) {
                            console.error('Error en try-catch:', error);
                            swalWithBootstrapButtons.fire({
                                title: 'Error',
                                text: 'OcurriÃ³ un error: ' + (error.message || error),
                                icon: 'error',
                                confirmButtonText: 'Entendido'
                            });
                        }
                    }
                });
            });
        } else {
            console.error('No se encontrÃ³ el botÃ³n saveStepBtn');
        }

        // Escuchar evento de paso guardado
        Livewire.on('step-saved', (data) => {
            console.log('Evento step-saved recibido:', data);
            swalWithBootstrapButtons.fire({
                title: data.title || 'Ã‰xito',
                text: data.message || 'OperaciÃ³n completada.',
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
                title: data.title || 'Error',
                text: data.message || 'OcurriÃ³ un error inesperado.',
                icon: 'error',
                confirmButtonText: 'Entendido'
            });
        });
    });
</script>
