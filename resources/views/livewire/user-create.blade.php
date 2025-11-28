{{--
    Company: CETAM
    Project: ST
    File: user-create.blade.php
    Created on: 06/11/2025
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
                            @icon('nav.home', 'icon icon-xxs')
                        </a>
                    </li>
                    <li class="breadcrumb-item">Administración</li>
                    <li class="breadcrumb-item">
                        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.users.index') }}">
                            Administrar usuarios
                        </a>
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
            <div class="card card-body border-0 shadow mb-4">
                <h2 class="h5 mb-4">Información del usuario</h2>
                <form wire:submit.prevent="save" action="#" method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div>
                                <label for="name">Nombre completo <span class="text-danger">*</span></label>
                                <input wire:model="name" class="form-control @error('name') is-invalid @enderror"
                                    id="name" type="text" placeholder="Nombre completo" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="email">Correo electrónico <span class="text-danger">*</span></label>
                                <input wire:model="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" type="email" placeholder="correo@ejemplo.com" required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="role">Rol <span class="text-danger">*</span></label>
                            <select wire:model="role" class="form-select @error('role') is-invalid @enderror"
                                id="role" aria-label="Seleccionar rol" required>
                                <option value="">Seleccionar...</option>
                                <option value="admin">Administrador</option>
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

                    <div class="mt-3">
                        <button type="button" id="createUserBtn" class="btn btn-primary mt-2 animate-up-2">
                            <span class="icon icon-xs text-white me-2 fas fa-user-plus"></span>
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
                                <span class="icon icon-sm text-info me-3 fas fa-info-circle"></span>
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
                                <span class="icon icon-sm text-info me-3 fas fa-info-circle"></span>
                                <div>
                                    <h3 class="h6">Información adicional</h3>
                                    <p class="text-gray-700 small mb-0">
                                        Los usuarios podrán completar su información personal (CURP, RFC, teléfono, dirección) desde su perfil después del primer acceso.
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="d-flex align-items-start">
                                <span class="icon icon-sm text-info me-3 fas fa-lock"></span>
                                <div>
                                    <h3 class="h6">Seguridad</h3>
                                    <p class="text-gray-700 small mb-0">
                                        Se recomienda que el usuario cambie la contraseña en el primer acceso.
                                    </p>
                                </div>
                            </div>
                        </li>
                    </ul>
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

        // Botón de crear usuario con confirmación
        document.getElementById('createUserBtn').addEventListener('click', function() {
            swalWithBootstrapButtons.fire({
                title: '¿Estás seguro?',
                text: '¿Deseas crear este nuevo usuario?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, crear',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('save');
                }
            });
        });

        // Escuchar evento de usuario creado
        if (window.Livewire) {
            Livewire.on('user-created', (event) => {
                const detail = event || {};
                swalWithBootstrapButtons.fire({
                    icon: detail.type || 'success',
                    title: detail.title || 'Aviso',
                    text: detail.message || '',
                    confirmButtonText: 'Entendido',
                    showConfirmButton: true
                });
            });
        }
    });
    </script>

</div>
