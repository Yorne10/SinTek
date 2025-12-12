{{--
* Company: CETAM
{{--
* Company: CETAM
* Project: ST
* File: convocation-form.blade.php
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
                            @icon('home', 'fa-xs')
                        </a>
                    </li>
                    <li class="breadcrumb-item">Secretaría</li>
                    <li class="breadcrumb-item">
                        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.calls') }}">
                            Convocatorias
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ $convocationId ? 'Editar' : 'Nueva' }} convocatoria
                    </li>
                </ol>
            </nav>
            <h2 class="h4">{{ $convocationId ? 'Editar' : 'Nueva' }} Convocatoria</h2>
            <p class="mb-0">{{ $convocationId ? 'Actualiza los detalles de la' : 'Crea una nueva' }} convocatoria en el
                sistema.</p>
        </div>
    </div>

    <div class="row">
        {{-- Form --}}
        <div class="col-12 col-xl-8">
            <div class="card border-0 shadow mb-4">
                <div class="card-body">
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
                    <h2 class="h5 mb-4">Información de la convocatoria</h2>
                    <form wire:submit.prevent="save">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="titulo" class="form-label">Título de la convocatoria <span
                                        class="text-danger">*</span></label>
                                <input wire:model="titulo" type="text"
                                    class="form-control @error('titulo') is-invalid @enderror" id="titulo"
                                    placeholder="Ej: Convocatoria para coordinador administrativo">
                                @error('titulo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="descripcion" class="form-label">Descripción <span
                                        class="text-danger">*</span></label>
                                <textarea wire:model="descripcion"
                                    class="form-control @error('descripcion') is-invalid @enderror" id="descripcion"
                                    rows="4" placeholder="Descripción detallada de la convocatoria..."></textarea>
                                @error('descripcion') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="form-check">
                                    <input wire:model.live="convocatoria_permanente" class="form-check-input"
                                        type="checkbox" id="convocatoria_permanente"
                                        @change="if($el.checked) { $wire.set('fecha_fin', null); }">
                                    <label class="form-check-label" for="convocatoria_permanente">
                                        Convocatoria permanente (sin fecha de cierre)
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="fecha_inicio" class="form-label">Fecha de inicio <span
                                        class="text-danger">*</span></label>
                                <input wire:model="fecha_inicio" type="date"
                                    class="form-control @error('fecha_inicio') is-invalid @enderror" id="fecha_inicio">
                                @error('fecha_inicio') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="fecha_fin" class="form-label">Fecha de fin</label>
                                <input wire:model="fecha_fin" type="date"
                                    class="form-control @error('fecha_fin') is-invalid @enderror" id="fecha_fin"
                                    :disabled="@js($convocatoria_permanente)">
                                <small class="form-text text-muted">Dejar vacío si es permanente</small>
                                @error('fecha_fin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            @if(!$convocationId)
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Documentos (PDF) <span
                                            class="text-muted small">(Opcional)</span></label>
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
                                                    accept=".pdf"
                                                    x-data
                                                    x-on:livewire-upload-start="window.dispatchEvent(new CustomEvent('file-uploading'))"
                                                    x-on:livewire-upload-finish="window.dispatchEvent(new CustomEvent('file-uploaded'))"
                                                    x-on:livewire-upload-error="window.dispatchEvent(new CustomEvent('file-uploaded'))">
                                                @error('documentos.' . $index . '.archivo') <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div> @enderror
                                                <div wire:loading wire:target="documentos.{{ $index }}.archivo" class="text-primary small mt-1">
                                                    <span class="spinner-border spinner-border-sm me-1" role="status"></span>
                                                    Cargando archivo...
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button" wire:click="removeDocumento({{ $index }})"
                                                    class="btn btn-sm btn-danger">
                                                    @icon('delete', 'icon-xs')
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                    <button type="button" wire:click="addDocumento"
                                        class="btn btn-sm btn-outline-primary mt-2">
                                        @icon('add', 'icon-xs me-1')
                                        Agregar documento
                                    </button>
                                </div>
                            @endif

                            <div class="col-md-12 d-flex flex-wrap align-items-center gap-2 mt-3">
                                <button type="submit" class="btn btn-primary" id="saveConvBtn">
                                    @icon('save', 'icon-xs me-1')
                                    {{ $convocationId ? 'Actualizar' : 'Guardar' }} convocatoria
                                </button>
                                <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.calls') }}"
                                    class="btn btn-gray-300">
                                    Cancelar
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Info Sidebar --}}
        <div class="col-12 col-xl-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <h2 class="h6 mb-3">Información importante</h2>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0">
                            <div class="d-flex align-items-start">
                                @icon('info', 'fa-xs text-info me-3')
                                <div>
                                    <h3 class="h6">Tipos de convocatoria</h3>
                                    <p class="text-gray-700 small mb-0">
                                        <strong>Permanente:</strong> No tiene fecha de cierre.<br>
                                        <strong>Temporal:</strong> Tiene fecha de inicio y fin definidas.
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="d-flex align-items-start">
                                @icon('documentSign', 'fa-xs text-info me-3')
                                <div>
                                    <h3 class="h6">Documentación</h3>
                                    <p class="text-gray-700 small mb-0">
                                        Sube los archivos PDF necesarios para la convocatoria. Asegúrate de que no
                                        superen los 5MB.
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

        let fileUploading = false;
        let filesUploaded = true;

        // Escuchar eventos de carga de archivo
        window.addEventListener('file-uploading', () => {
            fileUploading = true;
            filesUploaded = false;
        });

        window.addEventListener('file-uploaded', () => {
            fileUploading = false;
            filesUploaded = true;
        });

        // Confirmation before save
        document.getElementById('saveConvBtn')?.addEventListener('click', function (e) {
            e.preventDefault();
            const isEdit = {{ $convocationId ? 'true' : 'false' }};

            // Si los archivos se están cargando, mostrar mensaje de espera
            if (fileUploading) {
                Swal.fire({
                    title: 'Cargando archivos...',
                    text: 'Por favor espera a que terminen de cargar los documentos PDF',
                    icon: 'info',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();

                        // Esperar a que termine de cargar
                        const checkInterval = setInterval(() => {
                            if (!fileUploading && filesUploaded) {
                                clearInterval(checkInterval);
                                Swal.close();
                                // Mostrar confirmación después de que carguen
                                showConfirmation();
                            }
                        }, 100);
                    }
                });
                return;
            }

            // Si todo está bien, mostrar confirmación
            showConfirmation();

            function showConfirmation() {
                swalWithBootstrapButtons.fire({
                    title: isEdit ? '¿Actualizar convocatoria?' : '¿Guardar convocatoria?',
                    text: isEdit ? '¿Deseas actualizar los detalles de esta convocatoria?' : '¿Deseas publicar esta convocatoria?',
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
    });
</script>