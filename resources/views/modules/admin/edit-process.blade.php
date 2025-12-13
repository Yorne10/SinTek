{{--
Company: CETAM
Project: ST
File: modificar-proceso.blade.php
Created on: 04/11/2025
Created by: Alfonso Angel Garcia Hernandez
Approved by: Alfonso Angel Garcia Hernandez
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
                        <li class="breadcrumb-item">Secretaría</li>
                        <li class="breadcrumb-item">
                            <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.processes') }}">
                                Gestionar procesos
                            </a>
                        </li>
                    @else
                        <li class="breadcrumb-item">Administración</li>
                    @endif
                    <li class="breadcrumb-item active" aria-current="page">Modificar proceso</li>
                </ol>
            </nav>
            <h2 class="h4">Modificar proceso</h2>
            <p class="mb-0">Edita o elimina procesos de trámite existentes del sistema.</p>
        </div>
    </div>

    @if ($selectedProcess)
        <div class="row">
            <div class="col-12 col-xl-8">
                <div class="card card-body shadow border-0 mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="h5 mb-0">Información del proceso</h2>
                        @if (!request()->route('process_id'))
                            <button wire:click="$set('selectedProcessId', null)" class="btn btn-sm btn-outline-secondary">
                                @icon('edit', 'me-1')
                                Cambiar proceso
                            </button>
                        @endif
                    </div>

                    <form wire:submit.prevent="updateProcess">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="process_name">Nombre del proceso</label>
                                <input wire:model="name" class="form-control" id="process_name" type="text"
                                    placeholder="Ej: Solicitud de vacaciones">
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="process_code">Código del proceso</label>
                                <input class="form-control" id="process_code" type="text"
                                    value="{{ $process_code ?? 'N/A' }}" readonly>
                                <small class="form-text text-muted">El código del proceso no puede ser modificado una vez
                                    creado.</small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="process_description">Descripción</label>
                                <textarea wire:model="description" class="form-control" id="process_description" rows="4"
                                    placeholder="Describe el propósito y alcance del proceso..."></textarea>
                                @error('description')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="process_category">Categoría</label>
                                <input wire:model="category" class="form-control" id="process_category" type="text"
                                    placeholder="Ej: Recursos humanos">
                                @error('category')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="process_department">Departamento responsable</label>
                                <input wire:model="department" class="form-control" id="process_department" type="text"
                                    placeholder="Ej: Recursos Humanos">
                                @error('department')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">
                        <h2 class="h5 mb-3">Configuración</h2>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-check form-switch">
                                    <input wire:model="active" class="form-check-input" type="checkbox" id="process_active">
                                    <label class="form-check-label" for="process_active">
                                        Proceso activo
                                    </label>
                                </div>
                                <small class="form-text text-muted">Los trabajadores podrán iniciar este proceso si está
                                    activo.</small>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="row align-items-center mt-4">
                            <div class="col">
                                <button class="btn btn-gray-800 mt-2 animate-up-2" type="submit"
                                    wire:loading.attr="disabled">
                                    <span wire:loading.remove wire:target="updateProcess">
                                        @icon('save', 'me-2')
                                        Guardar cambios
                                    </span>
                                    <span wire:loading wire:target="updateProcess">
                                        <span class="spinner-border spinner-border-sm me-2" role="status"
                                            aria-hidden="true"></span>
                                        Guardando...
                                    </span>
                                </button>
                                <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.processes') }}"
                                    class="btn btn-gray-300 mt-2 animate-up-2">Cancelar</a>
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-danger mt-2" type="button" data-bs-toggle="modal"
                                    data-bs-target="#deleteProcessModal">
                                    @icon('delete', 'me-2')
                                    Eliminar proceso
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-12 col-xl-4">
                <div class="card card-body shadow border-0 mb-4">
                    <h2 class="h5 mb-4">Información importante</h2>
                    <div class="mb-3">
                        <h3 class="h6 mb-2">
                            @icon('help', 'me-1 text-info')
                            Modificar información
                        </h3>
                        <p class="small text-gray-700">Puedes cambiar cualquier campo del proceso excepto el código, que
                            es único y permanente.</p>
                    </div>
                    <div class="mb-3">
                        <h3 class="h6 mb-2">
                            @icon('help', 'me-1 text-info')
                            Desactivar vs Eliminar
                        </h3>
                        <p class="small text-gray-700">Si solo deseas pausar temporalmente el proceso, desmarca la opción
                            "Proceso activo" en lugar de eliminarlo.</p>
                    </div>
                    <div>
                        <h3 class="h6 mb-2">
                            @icon('help', 'me-1 text-info')
                            Modificar pasos
                        </h3>
                        <p class="small text-gray-700">Para modificar los pasos del proceso, dirígete a la sección
                            "Definir pasos" en el menú de administración.</p>
                    </div>
                </div>

                @if ($selectedProcess->created_at)
                    <div class="card border-0 shadow">
                        <div class="card-body">
                            <h2 class="h6 mb-3">Información del proceso</h2>
                            <ul class="list-group list-group-flush list my--3">
                                <li class="list-group-item px-0">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <span
                                                class="badge bg-tertiary text-dark">{{ $selectedProcess->created_at->format('d/m/Y') }}</span>
                                        </div>
                                        <div class="col">
                                            <small class="text-gray-700">Proceso creado</small>
                                        </div>
                                    </div>
                                </li>
                                @if ($selectedProcess->updated_at && $selectedProcess->updated_at != $selectedProcess->created_at)
                                    <li class="list-group-item px-0">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <span
                                                    class="badge bg-tertiary text-dark">{{ $selectedProcess->updated_at->format('d/m/Y') }}</span>
                                            </div>
                                            <div class="col">
                                                <small class="text-gray-700">Última modificación</small>
                                            </div>
                                        </div>
                                    </li>
                                @endif
                                @if ($selectedProcess->creator)
                                    <li class="list-group-item px-0">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <span class="badge bg-primary">{{ $selectedProcess->creator->name }}</span>
                                            </div>
                                            <div class="col">
                                                <small class="text-gray-700">Creado por</small>
                                            </div>
                                        </div>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @else
        {{-- Mostrar selector de proceso solo si no hay uno seleccionado --}}
        <div class="card card-body shadow border-0 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h5 mb-0">Seleccionar proceso</h2>
            </div>

            <div class="row mb-4">
                <div class="col-md-12">
                    <label for="select_process">Proceso a modificar</label>
                    <select wire:model.live="selectedProcessId" class="form-select" id="select_process">
                        <option value="">Seleccionar proceso...</option>
                        @foreach ($processes as $proceso)
                            <option value="{{ $proceso->process_id }}">
                                {{ $proceso->process_code ? $proceso->process_code . ' - ' : '' }}{{ $proceso->name }}
                            </option>
                        @endforeach
                    </select>
                    <small class="form-text text-muted">Selecciona el proceso que deseas modificar o eliminar.</small>
                </div>
            </div>
        </div>
    @endif

    {{-- Modal de confirmación para eliminar proceso --}}
    <div wire:ignore.self class="modal fade" id="deleteProcessModal" tabindex="-1"
        aria-labelledby="deleteProcessModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="deleteProcessModalLabel">
                        @icon('warning', 'me-2 text-danger')
                        Confirmar eliminación
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if ($selectedProcess)
                        <p class="mb-3">
                            ¿Estás seguro de que deseas eliminar el proceso <strong>"{{ $selectedProcess->name }}
                                @if ($selectedProcess->process_code)
                                    ({{ $selectedProcess->process_code }})
                                @endif
                                "</strong>?
                        </p>
                    @endif
                    <div class="alert alert-danger" role="alert">
                        <strong>Esta acción no se puede deshacer.</strong> Se eliminará toda la configuración y los
                        pasos definidos para este proceso.
                    </div>
                    <p class="small text-gray-700 mb-0">
                        Los trámites activos seguirán existiendo, pero no se podrán iniciar nuevos trámites con este
                        proceso.
                    </p>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-link text-gray-600" data-bs-dismiss="modal">Cancelar</button>
                    <button wire:click="deleteProcess" type="button" class="btn btn-danger"
                        wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="deleteProcess">
                            @icon('delete', 'me-2')
                            Eliminar proceso
                        </span>
                        <span wire:loading wire:target="deleteProcess">
                            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                            Eliminando...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.Livewire) {
                Livewire.on('process-updated', (event) => {
                    Swal.fire({
                        icon: 'success',
                        title: event.title || 'Proceso actualizado',
                        text: event.message || 'El proceso se actualizó correctamente.',
                        confirmButtonText: 'Aceptar'
                    });
                });

                Livewire.on('process-deleted', (event) => {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('deleteProcessModal'));
                    if (modal) modal.hide();

                    Swal.fire({
                        icon: 'success',
                        title: event.title || 'Proceso eliminado',
                        text: event.message || 'El proceso se eliminó correctamente.',
                        confirmButtonText: 'Aceptar'
                    }).then(() => {
                        window.location.href = '{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.processes') }}';
                    });
                });

                Livewire.on('process-error', (event) => {
                    Swal.fire({
                        icon: 'error',
                        title: event.title || 'Error',
                        text: event.message || 'Ocurrió un error al procesar la solicitud.',
                        confirmButtonText: 'Aceptar'
                    });
                });
            }
        });
    </script>
</div>