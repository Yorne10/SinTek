{{--
* Company: CETAM
* Project: ST
* File: documento-form.blade.php
* Created on: 01/12/2025
* Created by: Alfonso Angel García Hernández
* Approved by: Alfonso Angel García Hernández
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
            <p class="mb-0">{{ $documentId ? 'Actualiza los datos del' : 'Sube un nuevo' }} documento</p>
        </div>
    </div>

    {{-- Formulario --}}
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <form wire:submit.prevent="save">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="titulo" class="form-label">Título del documento *</label>
                                <input wire:model="titulo" type="text"
                                    class="form-control @error('titulo') is-invalid @enderror" id="titulo"
                                    placeholder="Ej: Reglamento Interior de Trabajo">
                                @error('titulo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="descripcion" class="form-label">Descripción (opcional)</label>
                                <textarea wire:model="descripcion" class="form-control" id="descripcion"
                                    rows="3" placeholder="Breve descripción del documento..."></textarea>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="categoria" class="form-label">Categoría *</label>
                                <select wire:model="categoria"
                                    class="form-select @error('categoria') is-invalid @enderror" id="categoria">
                                    <option value="reglamento">Reglamento</option>
                                    <option value="manual">Manual</option>
                                    <option value="lineamiento">Lineamiento</option>
                                    <option value="codigo">Código</option>
                                    <option value="otro">Otro</option>
                                </select>
                                @error('categoria') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="version" class="form-label">Versión *</label>
                                <input wire:model="version" type="text"
                                    class="form-control @error('version') is-invalid @enderror" id="version"
                                    placeholder="1.0">
                                @error('version') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="fecha_vigencia" class="form-label">Fecha de vigencia (opcional)</label>
                                <input wire:model="fecha_vigencia" type="date" class="form-control"
                                    id="fecha_vigencia">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="archivo" class="form-label">
                                    Archivo PDF {{ $documentId ? '(opcional - solo si deseas reemplazar)' : '*' }}
                                </label>
                                <input wire:model="archivo" type="file"
                                    class="form-control @error('archivo') is-invalid @enderror" id="archivo"
                                    accept=".pdf">
                                @error('archivo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <small class="form-text text-muted">Máximo 10MB</small>
                            </div>

                            <div class="col-md-12 d-flex justify-content-end gap-2">
                                <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.documents') }}"
                                    class="btn btn-secondary">
                                    @icon('nav.back', 'icon-xs me-1')
                                    Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary" id="saveDocBtn">
                                    @icon('action.save', 'icon-xs me-1')
                                    {{ $documentId ? 'Actualizar' : 'Guardar' }} documento
                                </button>
                            </div>
                        </div>
                    </form>
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
                title: isEdit ? 'Actualizar documento?' : 'Guardar documento?',
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