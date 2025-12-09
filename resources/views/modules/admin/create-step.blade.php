{{--
Company: CETAM
Project: ST
File: crear-paso.blade.php
Created on: 05/11/2025
Created by: Alfonso Angel Garcia Hernandez
Approved by: Alfonso Angel Garcia Hernandez

Changelog:
- ID: <ID> | Date: dd/mm/yyyy
    Modified by: <Developer name>
        Description: <Brief description of change>
            --}}

            {{-- Nota Livewire: esta vista debe tener UN único elemento raíz --}}
            {{-- El layout se aplica desde el componente con ->layout('layouts.app') --}}

            <div>
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
                    <div class="d-block mb-4 mb-md-0">
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                                <li class="breadcrumb-item">
                                    <a
                                        href="{{ route(config('proj.route_name_prefix', 'proj') . '.dashboard.index') }}">
                                        @icon('nav.home', 'fa-xs')
                                    </a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a
                                        href="{{ route(config('proj.route_name_prefix', 'proj') . '.admin.define-steps') }}">Definir
                                        pasos</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ $isEditing ? 'Editar paso' : 'Crear paso' }}
                                </li>
                            </ol>
                        </nav>
                        <h2 class="h4">{{ $isEditing ? 'Editar paso de proceso' : 'Crear paso de proceso' }}</h2>
                        <p class="mb-0">
                            {{ $isEditing ? 'Modifica los detalles del paso seleccionado.' : 'Define un nuevo paso para el flujo de trabajo del proceso.' }}
                        </p>
                    </div>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.admin.define-steps') }}"
                            class="btn btn-sm btn-outline-gray-600 d-inline-flex align-items-center">
                            <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Volver
                        </a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-xl-8">
                        <div class="card card-body shadow border-0 mb-4">
                            <h2 class="h5 mb-4">Información del paso</h2>
                            <form wire:submit.prevent="save">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="proceso">Proceso</label>
                                        <select class="form-select" id="proceso" wire:model.live="process_id"
                                            @if($isEditing) disabled @endif>
                                            <option value="">Seleccionar proceso...</option>
                                            @foreach($procesos as $proceso)
                                                <option value="{{ $proceso->process_id }}">
                                                    {{ $proceso->process_code ?? 'N/A' }} - {{ $proceso->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('process_id') <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                        <small class="form-text text-muted">Selecciona el proceso al que pertenecerá
                                            este paso.</small>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8 mb-3">
                                        <label for="nombre_paso">Nombre del paso</label>
                                        <input class="form-control" id="nombre_paso" type="text"
                                            placeholder="Ej: Revisión de supervisor" wire:model="tittle">
                                        @error('tittle') <span class="text-danger small">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="orden">Orden</label>
                                        <input class="form-control" id="orden" type="number" placeholder="1" min="1"
                                            wire:model="order">
                                        @error('order') <span class="text-danger small">{{ $message }}</span> @enderror
                                        <small class="form-text text-muted">Posición en el flujo.</small>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="descripcion">Descripción</label>
                                        <textarea class="form-control" id="descripcion" rows="3"
                                            placeholder="Describe brevemente el objetivo de este paso..."
                                            wire:model="description"></textarea>
                                        @error('description') <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="tipo_paso">Tipo de paso</label>
                                        <select class="form-select" id="tipo_paso" wire:model.live="condition_type">
                                            <option value="">Seleccionar tipo...</option>
                                            <option value="form">Formulario</option>
                                            <option value="approval">Aprobación</option>
                                            <option value="upload">Carga de archivos</option>
                                            <option value="final">Final</option>
                                        </select>
                                        @error('condition_type') <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="responsable">Responsable</label>
                                        <input class="form-control" id="responsable" type="text"
                                            placeholder="Ej: Recursos Humanos" wire:model="responsible">
                                        @error('responsible') <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="instrucciones">Instrucciones</label>
                                        <textarea class="form-control" id="instrucciones" rows="4"
                                            placeholder="Instrucciones detalladas para completar este paso..."
                                            wire:model="instructions"></textarea>
                                        @error('instructions') <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                        <small class="form-text text-muted">Estas instrucciones serán mostradas al
                                            usuario responsable.</small>
                                    </div>
                                </div>

                                <hr class="my-4">
                                <h2 class="h5 mb-3">Configuración de flujo</h2>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="activar_ramificacion"
                                                wire:model.live="activarRamificacion">
                                            <label class="form-check-label" for="activar_ramificacion">
                                                Activar ramificación condicional
                                            </label>
                                        </div>
                                        <small class="form-text text-muted">Permite que el paso tenga diferentes caminos
                                            según la decisión tomada.</small>
                                    </div>
                                </div>

                                @if($activarRamificacion && $condition_type === 'approval')
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <div class="card border-light shadow-sm">
                                                <div class="card-body">
                                                    <h3 class="h6 mb-3">Configuración de ramificación</h3>
                                                    <p class="small text-gray-700 mb-3">
                                                        <svg class="icon icon-xs text-warning me-1" fill="currentColor"
                                                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd"
                                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                        Este paso puede tener diferentes caminos según la decisión
                                                        (aprobado/rechazado).
                                                    </p>
                                                    @if(count($availableSteps) > 0)
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label for="next_yes">Paso siguiente si APRUEBA</label>
                                                                <select class="form-select form-select-sm" id="next_yes"
                                                                    wire:model="next_yes">
                                                                    <option value="">Seleccionar paso...</option>
                                                                    @foreach($availableSteps as $availableStep)
                                                                        <option value="{{ $availableStep->step_id }}">
                                                                            {{ $availableStep->order }}.
                                                                            {{ $availableStep->tittle }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                @error('next_yes') <span
                                                                class="text-danger small">{{ $message }}</span> @enderror
                                                                <small class="form-text text-muted">Paso al que avanza si
                                                                    aprueba (opcional)</small>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label for="next_no">Paso siguiente si RECHAZA</label>
                                                                <select class="form-select form-select-sm" id="next_no"
                                                                    wire:model="next_no">
                                                                    <option value="">Seleccionar paso...</option>
                                                                    @foreach($availableSteps as $availableStep)
                                                                        <option value="{{ $availableStep->step_id }}">
                                                                            {{ $availableStep->order }}.
                                                                            {{ $availableStep->tittle }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                @error('next_no') <span
                                                                class="text-danger small">{{ $message }}</span> @enderror
                                                                <small class="form-text text-muted">Paso al que avanza si
                                                                    rechaza (opcional)</small>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="alert alert-warning" role="alert">
                                                            <div class="d-flex align-items-start">
                                                                <svg class="icon icon-sm text-warning me-2 mt-1"
                                                                    fill="currentColor" viewBox="0 0 20 20"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path fill-rule="evenodd"
                                                                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                                                        clip-rule="evenodd"></path>
                                                                </svg>
                                                                <div>
                                                                    <h6 class="mb-1">No hay pasos disponibles para ramificar
                                                                    </h6>
                                                                    <p class="small mb-2">Aún no existen otros pasos en este
                                                                        proceso. Puedes:</p>
                                                                    <ul class="small mb-0 ps-3">
                                                                        <li>Guardar este paso ahora y configurar la ramificación
                                                                            después</li>
                                                                        <li>Crear primero otros pasos y luego volver a editar
                                                                            este para configurar la ramificación</li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <hr class="my-4">
                                <h2 class="h5 mb-3">Configuración adicional</h2>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="tiempo_limite">Tiempo límite (días)</label>
                                        <input class="form-control" id="tiempo_limite" type="number" placeholder="3"
                                            min="1" wire:model="deadline_days">
                                        @error('deadline_days') <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                        <small class="form-text text-muted">Días hábiles para completar este
                                            paso.</small>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="prioridad">Prioridad</label>
                                        <select class="form-select" id="prioridad" wire:model="priority">
                                            <option value="baja">Baja</option>
                                            <option value="media">Media</option>
                                            <option value="alta">Alta</option>
                                            <option value="urgente">Urgente</option>
                                        </select>
                                        @error('priority') <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="enviar_notificacion"
                                                wire:model="send_notification">
                                            <label class="form-check-label" for="enviar_notificacion">
                                                Enviar notificacion
                                            </label>
                                        </div>
                                        <small class="form-text text-muted">Notificar al responsable cuando llegue a
                                            este paso.</small>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="requiere_documentos"
                                                wire:model.live="requires_documents"
                                                @if($condition_type === 'upload') checked disabled @endif>
                                            <label class="form-check-label" for="requiere_documentos">
                                                Requiere documentos adjuntos
                                            </label>
                                        </div>
                                        <small class="form-text text-muted">El paso solicita documentos especificos.</small>
                                    </div>
                                </div>

                                @if($requires_documents)
                                    <hr class="my-4">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h3 class="h6 mb-0">Documentos requeridos</h3>
                                        <button type="button" class="btn btn-sm btn-outline-primary"
                                            wire:click="addDocument">
                                            Agregar documento
                                        </button>
                                    </div>
                                    @if(count($documents) === 0)
                                        <p class="text-muted small mb-3">Agrega al menos un documento para solicitar en este paso.</p>
                                    @endif
                                    <div class="row">
                                        @foreach($documents as $index => $document)
                                            <div class="col-12 mb-2">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-grow-1 me-2">
                                                        <input type="text" class="form-control"
                                                            placeholder="Titulo del documento"
                                                            wire:model="documents.{{ $index }}.title">
                                                        @error('documents.' . $index . '.title')
                                                            <span class="text-danger small">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <button type="button" class="btn btn-link text-danger px-2"
                                                        wire:click="removeDocument({{ $index }})">
                                                        Quitar
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                <div class="row align-items-center mt-4">
                                    <div class="col">
                                        <button class="btn btn-gray-800 mt-2 animate-up-2" type="submit">
                                            <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            {{ $isEditing ? 'Actualizar paso' : 'Guardar paso' }}
                                        </button>
                                        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.admin.define-steps') }}"
                                            class="btn btn-link text-gray-700 ms-2">Cancelar</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-12 col-xl-4">
                        <div class="card border-0 shadow mb-4">
                            <div class="card-header border-bottom">
                                <h2 class="h6 mb-0">Tipos de paso</h2>
                            </div>
                            <div class="card-body">
                                <p class="small text-gray-700 mb-3">Cada tipo de paso tiene un propósito específico en
                                    el flujo de trabajo:</p>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item px-0 border-bottom pb-3">
                                        <div class="d-flex align-items-start">
                                            <div class="icon-shape icon-sm icon-shape-info rounded me-2">
                                                <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                                                    <path fill-rule="evenodd"
                                                        d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h3 class="h6 mb-1">Formulario</h3>
                                                <p class="small mb-0">El usuario completa campos y proporciona
                                                    información.</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item px-0 border-bottom pb-3">
                                        <div class="d-flex align-items-start">
                                            <div class="icon-shape icon-sm icon-shape-warning rounded me-2">
                                                <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h3 class="h6 mb-1">Aprobación</h3>
                                                <p class="small mb-0">Requiere una decisión de aprobación (Sí/No). Ideal
                                                    para flujos condicionales.</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item px-0 border-bottom pb-3">
                                        <div class="d-flex align-items-start">
                                            <div class="icon-shape icon-sm icon-shape-primary rounded me-2">
                                                <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd"
                                                        d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h3 class="h6 mb-1">Validación</h3>
                                                <p class="small mb-0">Verificación de requisitos o condiciones
                                                    específicas.</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item px-0 border-bottom pb-3">
                                        <div class="d-flex align-items-start">
                                            <div class="icon-shape icon-sm icon-shape-secondary rounded me-2">
                                                <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd"
                                                        d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h3 class="h6 mb-1">Carga de archivos</h3>
                                                <p class="small mb-0">El usuario debe subir documentos específicos
                                                    requeridos.</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item px-0 border-bottom pb-3">
                                        <div class="d-flex align-items-start">
                                            <div class="icon-shape icon-sm icon-shape-tertiary rounded me-2">
                                                <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z">
                                                    </path>
                                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h3 class="h6 mb-1">Comunicación</h3>
                                                <p class="small mb-0">Envío de notificaciones o información a usuarios.
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item px-0 pb-3">
                                        <div class="d-flex align-items-start">
                                            <div class="icon-shape icon-sm icon-shape-success rounded me-2">
                                                <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h3 class="h6 mb-1">Final</h3>
                                                <p class="small mb-0">Cierra el proceso y notifica el resultado final.
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="card border-0 shadow">
                            <div class="card-body">
                                <h2 class="h6 mb-3">
                                    <svg class="icon icon-xs me-2 text-primary" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    Nota importante
                                </h2>
                                <p class="small text-gray-700 mb-2">
                                    Los pasos condicionales solo pueden ejecutarse si están configurados con
                                    ramificación activada.
                                </p>
                                <p class="small text-gray-700 mb-0">
                                    El tipo "Aprobación" es ideal para flujos condicionales ya que permite definir
                                    diferentes caminos según la decisión tomada (aprobado/rechazado).
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>