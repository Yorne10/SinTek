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
                    <li class="breadcrumb-item">
                        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.calls') }}">
                            Convocations
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ $convocationId ? 'Edit' : 'New' }} Convocation
                    </li>
                </ol>
            </nav>
            <h2 class="h4">{{ $convocationId ? 'Edit' : 'New' }} Convocation</h2>
            <p class="mb-0">{{ $convocationId ? 'Update details of the' : 'Create a new' }} convocation</p>
        </div>
    </div>

    {{-- Form --}}
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <form wire:submit.prevent="save">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="titulo" class="form-label">Convocation Title *</label>
                                <input wire:model="titulo" type="text"
                                    class="form-control @error('titulo') is-invalid @enderror" id="titulo"
                                    placeholder="Ex: Convocation for administrative coordinator position">
                                @error('titulo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="descripcion" class="form-label">Description *</label>
                                <textarea wire:model="descripcion"
                                    class="form-control @error('descripcion') is-invalid @enderror" id="descripcion"
                                    rows="4" placeholder="Detailed description of the convocation..."></textarea>
                                @error('descripcion') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="form-check">
                                    <input wire:model.live="convocatoria_permanente" class="form-check-input"
                                        type="checkbox" id="convocatoria_permanente">
                                    <label class="form-check-label" for="convocatoria_permanente">
                                        Permanent convocation (no closing date)
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="fecha_inicio" class="form-label">Start Date *</label>
                                <input wire:model="fecha_inicio" type="date"
                                    class="form-control @error('fecha_inicio') is-invalid @enderror" id="fecha_inicio">
                                @error('fecha_inicio') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="fecha_fin" class="form-label">End Date</label>
                                <input wire:model="fecha_fin" type="date"
                                    class="form-control @error('fecha_fin') is-invalid @enderror" id="fecha_fin"
                                    @if($convocatoria_permanente) disabled @endif>
                                <small class="form-text text-muted">Leave empty if permanent</small>
                                @error('fecha_fin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            @if(!$convocationId)
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Documents (PDF) <span
                                            class="text-muted small">(Optional)</span></label>
                                    @foreach($documentos as $index => $documento)
                                        <div class="row mb-2" wire:key="doc-{{ $index }}">
                                            <div class="col-md-5">
                                                <input type="text" wire:model="documentos.{{ $index }}.titulo"
                                                    class="form-control @error('documentos.' . $index . '.titulo') is-invalid @enderror"
                                                    placeholder="Document Title">
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
                                                    @icon('delete', 'icon-xs')
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                    <button type="button" wire:click="addDocumento" class="btn btn-sm btn-outline-primary">
                                        @icon('add', 'icon-xs me-1')
                                        Agregar documento
                                    </button>
                                </div>
                            @endif

                            <div class="col-md-12 d-flex flex-wrap align-items-center gap-2 mt-3">
                                <button type="submit" class="btn btn-primary" id="saveConvBtn">
                                    @icon('save', 'icon-xs me-1')
                                    {{ $convocationId ? 'Update' : 'Create' }} convocation
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

        // Confirmation before save
        document.getElementById('saveConvBtn')?.addEventListener('click', function (e) {
            e.preventDefault();
            const isEdit = {{ $convocationId ? 'true' : 'false' }};
            swalWithBootstrapButtons.fire({
                title: isEdit ? 'Update convocation?' : 'Create convocation?',
                text: isEdit ? 'Do you want to update the details of this convocation?' : 'Do you want to publish this convocation?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: isEdit ? 'Yes, update' : 'Yes, publish',
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
