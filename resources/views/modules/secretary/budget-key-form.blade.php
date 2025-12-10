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
                    <li class="breadcrumb-item">
                        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.budget-keys') }}">
                            Claves Presupuestales
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ $budget_key_id ? 'Editar' : 'Nueva' }} Clave
                    </li>
                </ol>
            </nav>
            <h2 class="h4">{{ $budget_key_id ? 'Editar' : 'Nueva' }} Clave Presupuestal</h2>
            <p class="mb-0">{{ $budget_key_id ? 'Modifica los datos de la clave presupuestal' : 'Completa el formulario para crear una nueva clave presupuestal' }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-xl-8">
            <div class="card card-body border-0 shadow mb-4">
                <h2 class="h5 mb-4">
                    @icon('money', 'me-2')
                    Información de la Clave
                </h2>

                <form wire:submit.prevent="save">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="budget_key" class="form-label">
                                Clave Presupuestal <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                class="form-control @error('budget_key') is-invalid @enderror"
                                id="budget_key"
                                wire:model="budget_key"
                                placeholder="Ej: 1234-5678"
                                required>
                            @error('budget_key')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Ingresa la clave presupuestal única
                            </small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="position_name" class="form-label">
                                Nombre del Puesto <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                class="form-control @error('position_name') is-invalid @enderror"
                                id="position_name"
                                wire:model="position_name"
                                placeholder="Ej: Coordinador de Recursos Humanos"
                                required>
                            @error('position_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Nombre descriptivo del puesto asociado
                            </small>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex gap-2">
                                <button type="submit"
                                    class="btn btn-gray-800 d-inline-flex align-items-center"
                                    wire:loading.attr="disabled">
                                    <span wire:loading.remove wire:target="save">
                                        @icon('save', 'me-2')
                                        {{ $budget_key_id ? 'Actualizar' : 'Guardar' }} Clave
                                    </span>
                                    <span wire:loading wire:target="save">
                                        <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                        Guardando...
                                    </span>
                                </button>
                                <button type="button"
                                    class="btn btn-link text-gray-600"
                                    wire:click="cancel">
                                    Cancelar
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-12 col-xl-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <h3 class="h6 mb-3">
                        @icon('info', 'me-2')
                        Información
                    </h3>
                    <p class="small text-gray-600 mb-2">
                        <strong>Campos requeridos:</strong> Todos los campos marcados con <span class="text-danger">*</span> son obligatorios.
                    </p>
                    <p class="small text-gray-600 mb-2">
                        <strong>Clave presupuestal:</strong> Debe ser única en el sistema.
                    </p>
                    <p class="small text-gray-600 mb-0">
                        <strong>Nombre del puesto:</strong> Será utilizado para identificar las plazas disponibles en el sistema.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
