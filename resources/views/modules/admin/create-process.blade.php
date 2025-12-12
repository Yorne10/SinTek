{{--
Company: CETAM
Project: ST
File: crear-proceso.blade.php
Created on: 04/11/2025
Created by: Alfonso Angel Garcia Hernandez
Approved by: Alfonso Angel Garcia Hernandez

Changelog:
- ID: <ID> | Date: dd/mm/yyyy
    Modified by: Codex
    Description: Formulario funcional para creación de procesos.
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
                    <li class="breadcrumb-item active" aria-current="page">Crear proceso</li>
                </ol>
            </nav>
            <h2 class="h4">Crear proceso</h2>
            <p class="mb-0">Define un nuevo proceso de trámite para el sistema.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-xl-8">
            <div class="card card-body shadow border-0 mb-4">
                <h2 class="h5 mb-4">Información del proceso</h2>

                @if ($successMessage)
                    <div class="alert alert-success d-flex align-items-center" role="alert">
                        <span class="fa-xs text-success me-2 fas fa-check-circle"></span>
                        <div>{{ $successMessage }}</div>
                    </div>
                @endif

                <form wire:submit.prevent="save">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="process_name">Nombre del proceso <span class="text-danger">*</span></label>
                            <input wire:model.defer="name" class="form-control @error('name') is-invalid @enderror"
                                id="process_name" type="text" placeholder="Ej: Solicitud de vacaciones" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="process_code">Código del proceso</label>
                            <input wire:model.defer="process_code"
                                class="form-control @error('process_code') is-invalid @enderror" id="process_code"
                                    type="text" placeholder="Ej: SOL-VAC-001">
                                <small class="form-text text-muted">Código único para identificar el proceso.</small>
                                @error('process_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="process_description">Descripción</label>
                                <textarea wire:model.defer="description"
                                    class="form-control @error('description') is-invalid @enderror"
                                    id="process_description" rows="4"
                                    placeholder="Describe el propósito y alcance del proceso..."></textarea>
                                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="process_category">Categoría</label>
                                <select wire:model.defer="category"
                                    class="form-select @error('category') is-invalid @enderror" id="process_category">
                                    <option value="">Selecciona una categoría...</option>
                                    @foreach($categoryOptions as $option)
                                        <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                                @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="process_department">Área responsable</label>
                                <select wire:model.defer="department"
                                    class="form-select @error('department') is-invalid @enderror"
                                    id="process_department">
                                    <option value="">Selecciona un área...</option>
                                    @foreach($departmentOptions as $option)
                                        <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                                @error('department') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <hr class="my-4">
                        <h2 class="h5 mb-3">Configuración</h2>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-check form-switch">
                                    <input wire:model="active" class="form-check-input" type="checkbox"
                                        id="process_active" checked>
                                    <label class="form-check-label" for="process_active">
                                        Proceso activo
                                    </label>
                                </div>
                                <small class="form-text text-muted">Los trabajadores podrán iniciar este proceso si está
                                    activo.</small>
                            </div>
                        </div>

                        <div class="row align-items-center mt-4">
                            <div class="col">
                                <button class="btn btn-gray-800 mt-2 animate-up-2" type="submit">
                                    @icon('save', 'me-2')
                                    Guardar proceso
                                </button>
                                <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.admin.manage-procedures') }}"
                                    class="btn btn-link text-gray-700 ms-2">Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-12 col-xl-4">
                <div class="card card-body shadow border-0 mb-4">
                    <h2 class="h5 mb-4">Ayuda</h2>
                    <div class="mb-3">
                        <h3 class="h6 mb-2">
                            @icon('help', 'fa-xs me-1 text-primary')
                            ¿Qué es un proceso?
                        </h3>
                        <p class="small text-gray-700">Un proceso es un flujo de trabajo que define los pasos necesarios
                            para completar un trámite específico.</p>
                    </div>
                    <div class="mb-3">
                        <h3 class="h6 mb-2">
                            @icon('help', 'fa-xs me-1 text-primary')
                            Código del proceso
                        </h3>
                        <p class="small text-gray-700">Usa nombres claros y únicos para identificar fácilmente el
                            proceso.
                        </p>
                    </div>
                    <div>
                        <h3 class="h6 mb-2">
                            @icon('help', 'fa-xs me-1 text-primary')
                            Siguiente paso
                        </h3>
                        <p class="small text-gray-700">Después de crear el proceso, define los pasos específicos en la
                            sección "Definir pasos".</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
