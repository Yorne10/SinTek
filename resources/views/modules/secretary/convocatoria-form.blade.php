{{--
* Company: CETAM
* Project: ST
* File: convocatoria-form.blade.php
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
                        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.convocatorias-documentos') }}">
                            Convocatorias y Documentos
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ $convocationId ? 'Editar' : 'Nueva' }} Convocatoria
                    </li>
                </ol>
            </nav>
            <h2 class="h4">{{ $convocationId ? 'Editar' : 'Nueva' }} Convocatoria</h2>
            <p class="mb-0">{{ $convocationId ? 'Actualiza los datos de la' : 'Crea una nueva' }} convocatoria</p>
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
                                <label for="titulo" class="form-label">Título de la convocatoria *</label>
                                <input wire:model="titulo" type="text"
                                    class="form-control @error('titulo') is-invalid @enderror" id="titulo"
                                    placeholder="Ej: Convocatoria para plaza de coordinador administrativo">
                                @error('titulo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="descripcion" class="form-label">Descripción *</label>
                                <textarea wire:model="descripcion"
                                    class="form-control @error('descripcion') is-invalid @enderror" id="descripcion"
                                    rows="4" placeholder="Descripción detallada de la convocatoria..."></textarea>
                                @error('descripcion') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="form-check">
                                    <input wire:model.live="convocatoria_permanente" class="form-check-input"
                                        type="checkbox" id="convocatoria_permanente">
                                    <label class="form-check-label" for="convocatoria_permanente">
                                        Convocatoria permanente (sin fecha de cierre)
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="fecha_inicio" class="form-label">Fecha de inicio *</label>
                                <input wire:model="fecha_inicio" type="date"
                                    class="form-control @error('fecha_inicio') is-invalid @enderror" id="fecha_inicio">
                                @error('fecha_inicio') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="fecha_fin" class="form-label">Fecha de fin</label>
                                <input wire:model="fecha_fin" type="date"
                                    class="form-control @error('fecha_fin') is-invalid @enderror" id="fecha_fin"
                                    @if($convocatoria_permanente) disabled @endif>
                                <small class="form-text text-muted">Dejar vacío si es permanente</small>
                                @error('fecha_fin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            @if(!$convocationId)
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Documentos (PDF) <span class="text-muted small">(Opcional)</span></label>
                                    @foreach($documentos as $index => $documento)
                                        <div class="row mb-2" wire:key="doc-{{ $index }}">
                                            <div class="col-md-5">
                                                <input type="text" wire:model="documentos.{{ $index }}.titulo"
                                                    class="form-control @error('documentos.' . $index . '.titulo') is-invalid @enderror"
                                                    placeholder="Título del documento">
                                                @error('documentos.' . $index . '.titulo') <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div> @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <input type="file" wire:model="documentos.{{ $index }}.archivo"
                                                    class="form-control @error('documentos.' . $index . '.archivo') is-invalid @enderror"
                                                    accept=".pdf">
                                                @error('documentos.' . $index . '.archivo') <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div> @enderror
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button" wire:click="removeDocumento({{ $index }})"
                                                    class="btn btn-sm btn-danger">
                                                    @icon('action.delete', 'icon-xs')
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                    <button type="button" wire:click="addDocumento" class="btn btn-sm btn-outline-primary">
                                        @icon('action.create', 'icon-xs me-1')
                                        Agregar documento
                                    </button>
                                </div>
                            @endif

                            <div class="col-md-12 d-flex justify-content-end gap-2">
                                <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.convocatorias-documentos') }}"
                                    class="btn btn-secondary">
                                    @icon('nav.back', 'icon-xs me-1')
                                    Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary" id="saveConvBtn">
                                    @icon('action.save', 'icon-xs me-1')
                                    {{ $convocationId ? 'Actualizar' : 'Crear' }} convocatoria
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
        document.getElementById('saveConvBtn')?.addEventListener('click', function (e) {
            e.preventDefault();
            const isEdit = {{ $convocationId ? 'true' : 'false' }};
            swalWithBootstrapButtons.fire({
                title: isEdit ? 'Actualizar convocatoria?' : 'Crear convocatoria?',
                text: isEdit ? '¿Deseas actualizar los datos de esta convocatoria?' : '¿Deseas publicar esta convocatoria?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: isEdit ? 'Sí, actualizar' : 'Sí, publicar',
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
