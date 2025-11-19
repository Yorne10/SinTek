{{--
    Company: CETAM
    Project: ST
    File: user-create.blade.php
    Created on: 06/11/2025
    Created by: Alfonso Angel Garcia Hernandez
    Approved by: Alfonso Angel Garcia Hernandez

    Changelog:
    - ID: <ID> | Date: dd/mm/yyyy
      Modified by: <Developer name>
      Description: <Brief description of change>
--}}

{{-- Nota Livewire: esta vista debe tener UN único elemento raíz --}}
{{-- El layout se aplica desde el componente con ->layout('layouts.app') --}}

<div>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item">
                        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.dashboard.index') }}">
                            <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.users.index') }}">Usuarios</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Crear usuario</li>
                </ol>
            </nav>
            <h2 class="h4">Crear nuevo usuario</h2>
            <p class="mb-0">Completa la información para registrar un nuevo usuario en el sistema.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-xl-8">
            @if (session()->has('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
            @endif

            @if (session()->has('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
            @endif

            <div class="card card-body border-0 shadow mb-4">
                <h2 class="h5 mb-4">Información del usuario</h2>
                <form wire:submit.prevent="save" action="#" method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div>
                                <label for="first_name">Nombre(s) <span class="text-danger">*</span></label>
                                <input wire:model="first_name" class="form-control @error('first_name') is-invalid @enderror"
                                    id="first_name" type="text" placeholder="Ingresa el nombre" required>
                                @error('first_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div>
                                <label for="last_name">Apellidos <span class="text-danger">*</span></label>
                                <input wire:model="last_name" class="form-control @error('last_name') is-invalid @enderror"
                                    id="last_name" type="text" placeholder="Ingresa los apellidos" required>
                                @error('last_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="email">Correo electrónico <span class="text-danger">*</span></label>
                                <input wire:model="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" type="email" placeholder="correo@ejemplo.com" required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="role">Rol <span class="text-danger">*</span></label>
                            <select wire:model="role" class="form-select @error('role') is-invalid @enderror"
                                id="role" aria-label="Seleccionar rol" required>
                                <option value="">Seleccionar...</option>
                                <option value="secretary">Secretario(a)</option>
                                <option value="worker">Trabajador(a)</option>
                            </select>
                            @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <h2 class="h5 my-4">Contraseña</h2>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="password">Contraseña <span class="text-danger">*</span></label>
                                <input wire:model="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" type="password" placeholder="Ingresa la contraseña" required>
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <small class="form-text text-muted">Mínimo 8 caracteres</small>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="password_confirmation">Confirmar contraseña <span class="text-danger">*</span></label>
                                <input wire:model="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror"
                                    id="password_confirmation" type="password" placeholder="Confirma la contraseña" required>
                                @error('password_confirmation') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <h2 class="h5 my-4">Información adicional (opcional)</h2>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="gender">Género</label>
                            <select wire:model="gender" class="form-select" id="gender" aria-label="Seleccionar género">
                                <option value="">Seleccionar...</option>
                                <option value="Female">Femenino</option>
                                <option value="Male">Masculino</option>
                                <option value="Other">Otro</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="city">Ciudad</label>
                                <input wire:model="city" class="form-control" id="city" type="text" placeholder="Ciudad">
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary mt-2 animate-up-2">
                            <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"></path>
                            </svg>
                            Crear usuario
                        </button>
                        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.users.index') }}"
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
                    <h2 class="h6 mb-3">Información importante</h2>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0">
                            <div class="d-flex align-items-start">
                                <div class="icon icon-shape icon-sm icon-shape-primary rounded me-3">
                                    <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="h6">Roles disponibles</h3>
                                    <p class="text-gray-700 small mb-0">
                                        <strong>Secretario(a):</strong> Gestión de solicitudes y trabajadores.<br>
                                        <strong>Trabajador(a):</strong> Acceso a trámites personales.
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="d-flex align-items-start">
                                <div class="icon icon-shape icon-sm icon-shape-secondary rounded me-3">
                                    <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="h6">Seguridad</h3>
                                    <p class="text-gray-700 small mb-0">
                                        El usuario recibirá sus credenciales por correo electrónico. Se recomienda cambiar la contraseña en el primer acceso.
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
