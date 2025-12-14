{{--
Company: CETAM
Project: ST
File: document-form.blade.php
Created on: 01/12/2025
Created by: Alfonso Angel Garcia Hernandez
Approved by: Alfonso Angel Garcia Hernandez

Changelog:
- ID: <ID> | Date: dd/mm/yyyy
    Modified by: <Developer name>
    Description: <Brief description of change>
--}}
<div>
    {{-- Encabezado --}}
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item">
                        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.dashboard.index') }}">
                            @icon('home', 'fa-xs')
                        </a>
                    </li>
                    <li class="breadcrumb-item">Secretaría</li>
                    <li class="breadcrumb-item">
                        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.documents') }}">
                            Documentos
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ $documentId ? 'Editar' : 'Nuevo' }} Documento
                    </li>
                </ol>
            </nav>
            <h2 class="h4">{{ $documentId ? 'Editar' : 'Nuevo' }} Documento Institucional</h2>
            <p class="mb-0">{{ $documentId ? 'Actualiza los datos del' : 'Sube un nuevo' }} documento institucional
            </p>
        </div>
    </div>

    {{-- Form --}}
    <div class="row">
        <div class="col-12 col-xl-8">
            <div class="card card-body border-0 shadow mb-4">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <h2 class="h5 mb-4">Información del Documento</h2>
                <form wire:submit.prevent="save">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="titulo" class="form-label">Título del Documento <span
                                    class="text-danger">*</span></label>
                            <input wire:model="titulo" type="text"
                                class="form-control @error('titulo') is-invalid @enderror" id="titulo"
                                placeholder="Ej: Reglamento Interior de Trabajo">
                            @error('titulo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="descripcion" class="form-label">Descripción (opcional)</label>
                            <textarea wire:model="descripcion" class="form-control @error('descripcion') is-invalid @enderror" id="descripcion"
                                rows="3" placeholder="Breve descripción del documento..."></textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="categoria" class="form-label">Categoría <span
                                    class="text-danger">*</span></label>
                            <select wire:model="categoria" class="form-select @error('categoria') is-invalid @enderror"
                                id="categoria">
                                <option value="">Seleccionar...</option>
                                <option value="reglamento">Reglamento</option>
                                <option value="manual">Manual</option>
                                <option value="lineamiento">Lineamiento</option>
                                <option value="codigo">Código</option>
                                <option value="otro">Otro</option>
                            </select>
                            @error('categoria')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="version" class="form-label">Versión <span class="text-danger">*</span></label>
                            <input wire:model="version" type="text"
                                class="form-control @error('version') is-invalid @enderror" id="version"
                                placeholder="Ej: 1.0">
                            @error('version')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="fecha_vigencia" class="form-label">
                                Fecha de Vigencia @if (!$sin_fecha_vigencia)
                                    <span class="text-danger">*</span>
                                @endif
                            </label>
                            <input wire:model="fecha_vigencia" type="date"
                                class="form-control @error('fecha_vigencia') is-invalid @enderror" id="fecha_vigencia"
                                {{ $sin_fecha_vigencia ? 'disabled' : '' }}>
                            @error('fecha_vigencia')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-check mt-2">
                                <input wire:model.live="sin_fecha_vigencia" class="form-check-input" type="checkbox"
                                    id="sin_fecha_vigencia">
                                <label class="form-check-label small" for="sin_fecha_vigencia">
                                    Sin fecha de vigencia
                                </label>
                            </div>
                        </div>
                    </div>

                    @if ($documentId)
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="status">Estado</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" id="status"
                                        {{ $status === 'active' ? 'checked' : '' }} wire:click="toggleStatus">
                                    <label class="form-check-label" for="status">
                                        Documento activo
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endif

                    <h2 class="h5 my-4">Archivo del Documento</h2>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="archivo" class="form-label">
                                Archivo PDF @if (!$documentId)
                                    <span class="text-danger">*</span>
                                @endif
                            </label>
                            @if ($documentId)
                                <div class="small mb-2">
                                    Ya hay un documento cargado. Deja vacío el selector si no deseas cambiarlo.
                                </div>
                            @endif
                            <input wire:model="archivo" type="file"
                                class="form-control @error('archivo') is-invalid @enderror" id="archivo"
                                accept=".pdf" x-data
                                x-on:livewire-upload-start="window.dispatchEvent(new CustomEvent('file-uploading'))"
                                x-on:livewire-upload-finish="window.dispatchEvent(new CustomEvent('file-uploaded'))"
                                x-on:livewire-upload-error="window.dispatchEvent(new CustomEvent('file-uploaded'))">
                            @error('archivo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div wire:loading wire:target="archivo" class="text-primary small mt-1">
                                <span class="spinner-border spinner-border-sm me-1" role="status"></span>
                                Cargando archivo...
                            </div>
                        </div>
                    </div>

                    <div class="mt-3 d-flex justify-content-between align-items-center">
                        <div class="d-flex gap-2">
                            <button type="button" id="saveDocBtn" class="btn btn-primary mt-2 animate-up-2">
                                @icon('save', 'fa-xs text-white me-2')
                                {{ $documentId ? 'Actualizar' : 'Guardar' }} Documento
                            </button>
                            <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.documents') }}"
                                class="btn btn-gray-300 mt-2 animate-up-2">
                                Cancelar
                            </a>
                        </div>
                        @if ($documentId)
                            <div>
                                <button type="button" id="deleteDocBtn" class="btn btn-danger mt-2 animate-up-2">
                                    @icon('delete', 'fa-xs text-white me-2')
                                    Eliminar documento
                                </button>
                            </div>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <div class="col-12 col-xl-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <h2 class="h6 mb-3">Información importante</h2>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0">
                            <div class="d-flex align-items-start">
                                @icon('file', 'fa-xs text-info me-3')
                                <div>
                                    <h3 class="h6">Documento</h3>
                                    <p class="text-gray-700 small mb-0">
                                        Sube el archivo Máximo 10 MB.
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="d-flex align-items-start">
                                @icon('info', 'fa-xs text-info me-3')
                                <div>
                                    <h3 class="h6">Categorías</h3>
                                    <p class="text-gray-700 small mb-0">
                                        <strong>Reglamento</strong>, <strong>Manual</strong>,
                                        <strong>Lineamiento</strong>,
                                        <strong>Código</strong> u <strong>Otro</strong> según corresponda.
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="d-flex align-items-start">
                                @icon('info', 'fa-xs text-info me-3')
                                <div>
                                    <h3 class="h6">Versionado</h3>
                                    <p class="text-gray-700 small mb-0">
                                        Usa un formato semántico (1.0, 1.1, 2.0) para controlar actualizaciones.
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
    document.addEventListener('DOMContentLoaded', function() {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-primary me-2',
                cancelButton: 'btn btn-gray'
            },
            buttonsStyling: false
        });

        let fileUploading = false;
        let fileUploaded = {{ $documentId ? 'true' : 'false' }};

        // Escuchar eventos de carga de archivo
        window.addEventListener('file-uploading', () => {
            fileUploading = true;
            fileUploaded = false;
        });

        window.addEventListener('file-uploaded', () => {
            fileUploading = false;
            fileUploaded = true;
        });

        // Escuchar evento de documento guardado para limpiar el input file y mostrar alerta
        Livewire.on('document-saved', (data) => {
            const fileInput = document.getElementById('archivo');
            if (fileInput) {
                fileInput.value = '';
            }
            fileUploaded = false;

            // Mostrar alerta de éxito con SweetAlert
            swalWithBootstrapButtons.fire({
                title: data.title || 'Éxito',
                text: data.message || 'Operación completada exitosamente.',
                icon: 'success',
                confirmButtonText: 'Entendido'
            }).then(() => {
                window.location.href =
                    "{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.documents') }}";
            });
        });

        // Escuchar evento de error
        Livewire.on('document-error', (data) => {
            swalWithBootstrapButtons.fire({
                title: data.title || 'Error',
                text: data.message || 'Ocurrió un error.',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
        });

        // Confirmación antes de guardar
        document.getElementById('saveDocBtn')?.addEventListener('click', function(e) {
            e.preventDefault();
            const isEdit = {{ $documentId ? 'true' : 'false' }};

            // If el archivo se está cargando, mostrar mensaje de espera
            if (fileUploading) {
                Swal.fire({
                    title: 'Archivo en proceso',
                    text: 'Por favor espera a que termine de cargar el archivo PDF antes de guardar.',
                    icon: 'warning',
                    confirmButtonText: 'Entendido',
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    },
                    buttonsStyling: false
                });
                return;
            }

            // Mostrar confirmación (Livewire manejará la validación del archivo)
            showConfirmation();

            function showConfirmation() {
                swalWithBootstrapButtons.fire({
                    title: isEdit ? '¿Actualizar documento?' : '¿Guardar documento?',
                    text: isEdit ? '¿Deseas actualizar los datos de este documento?' :
                        '¿Deseas subir este documento institucional?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: isEdit ? 'Sí, actualizar' : 'Sí, guardar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.call('save');
                    }
                });
            }
        });

        // Confirmación antes de eliminar
        document.getElementById('deleteDocBtn')?.addEventListener('click', function(e) {
            e.preventDefault();
            swalWithBootstrapButtons.fire({
                title: '¿Eliminar documento?',
                text: 'Esta acción no se puede deshacer. El documento será eliminado permanentemente.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true,
                customClass: {
                    confirmButton: 'btn btn-danger me-2',
                    cancelButton: 'btn btn-gray'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('delete');
                }
            });
        });

        // Escuchar evento de documento eliminado
        Livewire.on('document-deleted', (data) => {
            swalWithBootstrapButtons.fire({
                title: data.title || 'Eliminado',
                text: data.message || 'El documento ha sido eliminado.',
                icon: 'success',
                confirmButtonText: 'Entendido'
            }).then(() => {
                window.location.href =
                    "{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.documents') }}";
            });
        });
    });
</script>
