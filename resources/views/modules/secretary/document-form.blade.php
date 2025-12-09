{{--
* Company: CETAM
* Project: ST
* File: document-form.blade.php
* Created on: 01/12/2025
* Created by: Alfonso Angel García Hernández
* Approved by: Alfonso Angel García Hernández
*
* Changelog:
* - ID: 001 | Modified on: 08/12/2025 |
*   Modified by: Claude Code |
*   Description: Reestructurado para seguir patrón de user-create
--}}
<div>
    {{-- Page Header --}}
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item">
                        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.dashboard.index') }}">
                            @icon('nav.home', 'fa-xs')
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
            <p class="mb-0">{{ $documentId ? 'Actualiza los datos del' : 'Sube un nuevo' }} documento institucional</p>
        </div>
    </div>

    {{-- Formulario --}}
    <div class="row">
        <div class="col-12 col-xl-8">
            <div class="card card-body border-0 shadow mb-4">
                <h2 class="h5 mb-4">Información del Documento</h2>
                <form wire:submit.prevent="save">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="titulo" class="form-label">Título del Documento <span class="text-danger">*</span></label>
                            <input wire:model="titulo" type="text"
                                class="form-control @error('titulo') is-invalid @enderror" id="titulo"
                                placeholder="Ej: Reglamento Interior de Trabajo">
                            @error('titulo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea wire:model="descripcion" class="form-control @error('descripcion') is-invalid @enderror"
                                id="descripcion" rows="3" placeholder="Breve descripción del documento..."></textarea>
                            @error('descripcion') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="categoria" class="form-label">Categoría <span class="text-danger">*</span></label>
                            <select wire:model="categoria"
                                class="form-select @error('categoria') is-invalid @enderror" id="categoria">
                                <option value="">Seleccionar...</option>
                                <option value="reglamento">Reglamento</option>
                                <option value="manual">Manual</option>
                                <option value="lineamiento">Lineamiento</option>
                                <option value="codigo">Código</option>
                                <option value="otro">Otro</option>
                            </select>
                            @error('categoria') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="version" class="form-label">Versión <span class="text-danger">*</span></label>
                            <input wire:model="version" type="text"
                                class="form-control @error('version') is-invalid @enderror" id="version"
                                placeholder="1.0">
                            @error('version') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="fecha_vigencia" class="form-label">Fecha de Vigencia</label>
                            <input wire:model="fecha_vigencia" type="date"
                                class="form-control @error('fecha_vigencia') is-invalid @enderror" id="fecha_vigencia">
                            @error('fecha_vigencia') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <h2 class="h5 my-4">Archivo del Documento</h2>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="archivo" class="form-label">
                                Archivo PDF {{ $documentId ? '' : '*' }}
                            </label>
                            <input wire:model="archivo" type="file"
                                class="form-control @error('archivo') is-invalid @enderror" id="archivo"
                                accept=".pdf">
                            @error('archivo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="form-text text-muted">
                                Máximo 10MB. {{ $documentId ? 'Dejar vacío para mantener el archivo actual.' : '' }}
                            </small>
                        </div>
                    </div>

                    <div class="mt-3">
                        <button type="button" id="saveDocBtn" class="btn btn-primary mt-2 animate-up-2">
                            @icon('action.save', 'fa-xs text-white me-2')
                            {{ $documentId ? 'Actualizar' : 'Guardar' }} Documento
                        </button>
                        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.documents') }}"
                            class="btn btn-gray-300 mt-2 animate-up-2">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-12 col-xl-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <h2 class="h6 mb-3">Información Importante</h2>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0">
                            <div class="d-flex align-items-start">
                                @icon('file.generic', 'fa-xs text-info me-3')
                                <div>
                                    <h3 class="h6">Formato de Archivo</h3>
                                    <p class="text-gray-700 small mb-0">
                                        Solo se aceptan archivos en formato PDF con un tamaño máximo de 10MB.
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="d-flex align-items-start">
                                @icon('state.info', 'fa-xs text-info me-3')
                                <div>
                                    <h3 class="h6">Categorías</h3>
                                    <p class="text-gray-700 small mb-0">
                                        <strong>Reglamento:</strong> Normas internas de la institución.<br>
                                        <strong>Manual:</strong> Guías y procedimientos.<br>
                                        <strong>Lineamiento:</strong> Directrices generales.<br>
                                        <strong>Código:</strong> Códigos de ética o conducta.
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="d-flex align-items-start">
                                @icon('notif.bell', 'fa-xs text-info me-3')
                                <div>
                                    <h3 class="h6">Versionado</h3>
                                    <p class="text-gray-700 small mb-0">
                                        Se recomienda usar el formato semántico de versiones (ej: 1.0, 1.1, 2.0) para llevar un control adecuado de las actualizaciones.
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
        document.getElementById('saveDocBtn')?.addEventListener('click', function (e) {
            e.preventDefault();
            const isEdit = {{ $documentId ? 'true' : 'false' }};
            swalWithBootstrapButtons.fire({
                title: isEdit ? '¿Actualizar documento?' : '¿Guardar documento?',
                text: isEdit ? '¿Deseas actualizar los datos de este documento?' : '¿Deseas subir este documento institucional?',
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
        });
    });
</script>
