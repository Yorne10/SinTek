{{--
Company: CETAM
Project: ST
File: budget-key-form.blade.php
Created on: 08/12/2025
Created by: Claude Code
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
                    <li class="breadcrumb-item">Secretaría</li>
                    <li class="breadcrumb-item">
                        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.budget-keys') }}">
                            Gestionar Claves
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ $budget_key_id ? 'Editar' : 'Nueva' }} Clave
                    </li>
                </ol>
            </nav>
            <h2 class="h4">{{ $budget_key_id ? 'Editar' : 'Nueva' }} Clave Presupuestal</h2>
            <p class="mb-0">
                {{ $budget_key_id ? 'Modifica los datos de la clave presupuestal' : 'Completa el formulario para crear una nueva clave presupuestal' }}
            </p>
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
            document.getElementById('saveKeyBtn')?.addEventListener('click', function (e) {
                e.preventDefault();
                const isEdit = {{ $budget_key_id ? 'true' : 'false' }};
                swalWithBootstrapButtons.fire({
                    icon: 'question',
                    title: isEdit ? '¿Actualizar clave presupuestal?' : '¿Guardar clave presupuestal?',
                    text: isEdit ? '¿Deseas actualizar esta clave?' : '¿Deseas guardar esta nueva clave?',
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

            // Mostrar alerta de éxito desde Livewire y redirigir
            if (window.Livewire) {
                Livewire.on('budget-key-saved', (detail = {}) => {
                    swalWithBootstrapButtons.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: detail.message || 'Operación realizada correctamente.',
                        confirmButtonText: 'Entendido'
                    }).then(() => {
                        if (detail.redirect) {
                            window.location.href = detail.redirect;
                        }
                    });
                });
            }

            // Confirmación antes de eliminar
            document.getElementById('deleteKeyBtn')?.addEventListener('click', function (e) {
                e.preventDefault();
                swalWithBootstrapButtons.fire({
                    icon: 'question',
                    title: '¿Eliminar clave presupuestal?',
                    text: '¿Estás seguro de eliminar esta clave? Esta acción no se puede deshacer.',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.call('deleteKey');
                    }
                });
            });
        });
    </script>
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
                <h2 class="h5 mb-4">Información de la Clave</h2>

                <form wire:submit.prevent="save">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="budget_key" class="form-label">
                                Clave Presupuestal <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('budget_key') is-invalid @enderror"
                                id="budget_key" wire:model="budget_key" placeholder="Clave presupuestal" required>
                            @error('budget_key')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="position_name" class="form-label">
                                Nombre del Puesto <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('position_name') is-invalid @enderror"
                                id="position_name" wire:model="position_name" placeholder="Nombre del puesto" required>
                            @error('position_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-3 d-flex justify-content-between">
                        <div>
                            <button type="button" id="saveKeyBtn" class="btn btn-primary mt-2 animate-up-2"
                                wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="save">
                                    @icon('save', 'fa-xs text-white me-2')
                                    {{ $budget_key_id ? 'Actualizar' : 'Guardar' }} Clave
                                </span>
                                <span wire:loading wire:target="save">
                                    <span class="spinner-border spinner-border-sm me-2" role="status"
                                        aria-hidden="true"></span>
                                    Guardando...
                                </span>
                            </button>
                            <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.budget-keys') }}"
                                class="btn btn-gray-300 mt-2 animate-up-2">
                                Cancelar
                            </a>
                        </div>
                        @if($budget_key_id)
                            <div>
                                <button type="button" id="deleteKeyBtn" class="btn btn-danger mt-2 animate-up-2">
                                    @icon('delete', 'fa-xs text-white me-2')
                                    Eliminar clave
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
                                @icon('info', 'fa-xs text-info me-3')
                                <div>
                                    <h3 class="h6">Clave única</h3>
                                    <p class="text-gray-700 small mb-0">
                                        La clave presupuestal debe ser única en el sistema y no puede duplicarse.
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="d-flex align-items-start">
                                @icon('info', 'fa-xs text-info me-3')
                                <div>
                                    <h3 class="h6">Nombre del puesto</h3>
                                    <p class="text-gray-700 small mb-0">
                                        Será utilizado para identificar las plazas disponibles en el sistema de
                                        convocatorias.
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