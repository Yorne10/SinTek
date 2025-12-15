{{--
Company: CETAM
Project: ST
File: user-edit.blade.php
Created on: 01/12/2025
Created by: Claude AI
Approved by: Alfonso Angel Garcia Hernandez

Changelog:
- ID: <ID> | Date: dd/mm/yyyy
    Modified by: <Developer name>
    Description: <Brief description of change>
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
                    <li class="breadcrumb-item">Administración</li>
                    <li class="breadcrumb-item">
                        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.users.index') }}">
                            Administrar usuarios
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Editar usuario</li>
                </ol>
            </nav>
            <h2 class="h4">Editar usuario</h2>
            <p class="mb-0">Modifica la información del usuario en el sistema.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-xl-8">
            <div class="card card-body border-0 shadow mb-4">
                <h2 class="h5 mb-4">Información del usuario</h2>
                <form wire:submit.prevent="updateUser" action="#" method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div>
                                <label for="name">Nombre completo <span class="text-danger">*</span></label>
                                <input wire:model="name" class="form-control @error('name') is-invalid @enderror"
                                    id="name" type="text" placeholder="Nombre completo">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="email">Correo electrónico <span class="text-danger">*</span></label>
                                <input wire:model="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" type="email" placeholder="correo@institucion.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="role">Rol <span class="text-danger">*</span></label>
                            <select wire:model="role" class="form-select @error('role') is-invalid @enderror"
                                id="role" aria-label="Seleccionar rol">
                                <option value="">Seleccionar...</option>
                                <option value="admin">Administrador</option>
                                <option value="secretary">Secretario(a)</option>
                                <option value="worker">Trabajador(a)</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="is_active">Estado</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" wire:model="is_active" id="is_active">
                                <label class="form-check-label" for="is_active">
                                    Usuario activo
                                </label>
                            </div>
                        </div>
                    </div>

                    <h2 class="h5 my-4">Cambiar contraseña (opcional)</h2>
                    <p class="text-muted small">Deja en blanco si no deseas cambiar la contraseña</p>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="password">Nueva contraseña</label>
                                <input wire:model="password"
                                    class="form-control @error('password') is-invalid @enderror" id="password"
                                    type="password" placeholder="Contrase&ntilde;a">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Mínimo 8 caracteres</small>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="password_confirmation">Confirmar contraseña</label>
                                <input wire:model="password_confirmation"
                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                    id="password_confirmation" type="password" placeholder="Contrase&ntilde;a">
                                @error('password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    @if ($role === 'worker' && auth()->user()->role === 'worker')
                        <h2 class="h5 my-4">Información adicional del trabajador</h2>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="curp">CURP</label>
                                <input wire:model="curp" class="form-control" id="curp" type="text"
                                    placeholder="CURP" maxlength="18">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="rfc">RFC</label>
                                <input wire:model="rfc" class="form-control" id="rfc" type="text"
                                    placeholder="RFC" maxlength="13">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone">Teléfono</label>
                                <input wire:model="phone" class="form-control" id="phone" type="text"
                                    placeholder="Teléfono">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="department">Departamento</label>
                                <input wire:model="department" class="form-control" id="department" type="text"
                                    placeholder="Departamento">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="position">Puesto</label>
                                <input wire:model="position" class="form-control" id="position" type="text"
                                    placeholder="Puesto">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="address">Dirección</label>
                                <input wire:model="address" class="form-control" id="address" type="text"
                                    placeholder="Dirección">
                            </div>
                        </div>
                    @endif

                    <div class="mt-3">
                        <button type="button" id="updateUserBtn" class="btn btn-primary mt-2 animate-up-2">
                            @icon('save', 'fa-xs text-white me-2')
                            Actualizar usuario
                        </button>
                        <button type="button" wire:click="cancel" class="btn btn-gray-300 mt-2 animate-up-2">
                            Cancelar
                        </button>
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
                                    <h3 class="h6">Roles disponibles</h3>
                                    <p class="text-gray-700 small mb-0">
                                        <strong>Administrador:</strong> Acceso completo al sistema.<br>
                                        <strong>Secretario(a):</strong> Gestión de solicitudes y trabajadores.<br>
                                        <strong>Trabajador(a):</strong> Acceso a trámites personales.
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="d-flex align-items-start">
                                @icon('lock', 'fa-xs text-info me-3')
                                <div>
                                    <h3 class="h6">Contraseña</h3>
                                    <p class="text-gray-700 small mb-0">
                                        Solo se actualizará la contraseña si ingresas una nueva. De lo contrario, se
                                        mantendrá la actual.
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="d-flex align-items-start">
                                @icon('user', 'fa-xs text-info me-3')
                                <div>
                                    <h3 class="h6">Información del trabajador</h3>
                                    <p class="text-gray-700 small mb-0">
                                        Los campos adicionales solo se muestran cuando el rol es "Trabajador(a)".
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
    document.addEventListener('DOMContentLoaded', function() {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-primary me-2',
                cancelButton: 'btn btn-gray'
            },
            buttonsStyling: false
        });

        // Botón de actualizar usuario con confirmación
        document.getElementById('updateUserBtn').addEventListener('click', function() {
            swalWithBootstrapButtons.fire({
                title: '¿Estás seguro?',
                text: '¿Deseas actualizar la información de este usuario?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, actualizar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('updateUser');
                }
            });
        });

        // Listen for user-updated event
        Livewire.on('user-updated', () => {
            swalWithBootstrapButtons.fire({
                title: '¡Éxito!',
                text: 'Usuario actualizado correctamente',
                icon: 'success',
                confirmButtonText: 'Aceptar',
                showConfirmButton: true
            }).then((result) => {
                window.location.href =
                    "{{ route(config('proj.route_name_prefix', 'proj') . '.users.index') }}";
            });
        });
    });
</script>
