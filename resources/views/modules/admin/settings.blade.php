{{--
Company: CETAM
Project: ST
File: configuracion.blade.php
Created on: 04/11/2025
Created by: Alfonso Angel Garcia Hernandez
Approved by: Alfonso Angel Garcia Hernandez

Changelog:
- ID: <ID> | Date: dd/mm/yyyy
    Modified by: <Developer name>
        Description: <Brief description of change>
            --}}

            {{-- Nota Livewire: esta vista debe tener UN nico elemento raz --}}
            {{-- El layout se aplica desde el componente con ->layout('layouts.app') --}}

            <div>
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
                    <div class="d-block mb-4 mb-md-0">
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                                <li class="breadcrumb-item">
                                    <a
                                        href="{{ route(config('proj.route_name_prefix', 'proj') . '.dashboard.index') }}">
                                        @icon('home', 'fa-xs')
                                    </a>
                                </li>
                                <li class="breadcrumb-item">Administración</li>
                                <li class="breadcrumb-item active" aria-current="page">Parámetros y configuración</li>
                            </ol>
                        </nav>
                        <h2 class="h4">Parámetros y configuración</h2>
                        <p class="mb-0">Administra parámetros generales del sistema.</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-xl-8">
                        <div class="card card-body shadow border-0 mb-4">
                            <h2 class="h5 mb-4">Información general</h2>
                            <form>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div>
                                            <label for="institution_name">Nombre de la institución</label>
                                            <input wire:model="institution_name"
                                                class="form-control @error('institution_name') is-invalid @enderror"
                                                id="institution_name" type="text" placeholder="Nombre de la institución">
                                            @error('institution_name') <div class="invalid-feedback">{{ $message }}
                                            </div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div>
                                            <label for="system_name">Nombre del sistema</label>
                                            <input wire:model="system_name"
                                                class="form-control @error('system_name') is-invalid @enderror"
                                                id="system_name" type="text" placeholder="Nombre del sistema">
                                            @error('system_name') <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div>
                                            <label for="contact_email">Correo de contacto</label>
                                            <input wire:model="contact_email"
                                                class="form-control @error('contact_email') is-invalid @enderror"
                                                id="contact_email" type="email" placeholder="correo@institucion.com">
                                            @error('contact_email') <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div>
                                            <label for="contact_phone">Teléfono</label>
                                            <input wire:model="contact_phone"
                                                class="form-control @error('contact_phone') is-invalid @enderror"
                                                id="contact_phone" type="text" placeholder="(999) 999-9999">
                                            @error('contact_phone') <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row align-items-center">
                                    <div class="col">
                                        <button type="button" id="saveGeneralBtn"
                                            class="btn btn-gray-800 mt-2 animate-up-2">
                                            <span class="fas fa-save me-2"></span>
                                            Guardar cambios
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="card card-body shadow border-0 mb-4">
                            <h2 class="h5 mb-4">Seguridad</h2>
                            <form>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div>
                                            <label for="session_timeout">Tiempo de inactividad para cierre de sesión
                                                (minutos)</label>
                                            <input wire:model="session_timeout"
                                                class="form-control @error('session_timeout') is-invalid @enderror"
                                                id="session_timeout" type="number" placeholder="120" min="1" max="1440">
                                            @error('session_timeout') <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">Si el usuario permanece inactivo por
                                                este tiempo, se le pedirá confirmar si sigue ahí.</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row align-items-center">
                                    <div class="col">
                                        <button type="button" id="saveSecurityBtn"
                                            class="btn btn-gray-800 mt-2 animate-up-2">
                                            <span class="fas fa-save me-2"></span>
                                            Guardar cambios
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-12 col-xl-4">
                        <div class="card card-body shadow border-0 mb-4">
                            <h2 class="h5 mb-4">Mantenimiento</h2>
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div>
                                    <h3 class="h6 mb-1">Modo mantenimiento</h3>
                                    <p class="small mb-0">Desactiva el acceso al sistema</p>
                                </div>
                                <div class="form-check form-switch">
                                    <input wire:model.live="maintenanceMode" wire:change="toggleMaintenanceMode"
                                        class="form-check-input" type="checkbox" id="maintenance_mode">
                                    <label class="form-check-label" for="maintenance_mode"></label>
                                </div>
                            </div>
                        </div>

                        <div class="card card-body shadow border-0">
                            <h2 class="h5 mb-4">Información del sistema</h2>
                            <ul class="list-group list-group-flush">
                                <li
                                    class="list-group-item d-flex align-items-center justify-content-between px-0 border-bottom">
                                    <div>
                                        <h3 class="h6 mb-1">Versión</h3>
                                        <p class="small mb-0">1.0.0</p>
                                    </div>
                                </li>
                                <li
                                    class="list-group-item d-flex align-items-center justify-content-between px-0 border-bottom">
                                    <div>
                                        <h3 class="h6 mb-1">Laravel</h3>
                                        <p class="small mb-0">12.36.1</p>
                                    </div>
                                </li>
                                <li
                                    class="list-group-item d-flex align-items-center justify-content-between px-0 border-bottom">
                                    <div>
                                        <h3 class="h6 mb-1">PHP</h3>
                                        <p class="small mb-0">{{ phpversion() }}</p>
                                    </div>
                                </li>
                                <li class="list-group-item d-flex align-items-center justify-content-between px-0">
                                    <div>
                                        <h3 class="h6 mb-1">Base de datos</h3>
                                        <p class="small mb-0">MySQL</p>
                                    </div>
                                </li>
                            </ul>
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

                        // Botón de guardar información general
                        document.getElementById('saveGeneralBtn')?.addEventListener('click', function () {
                            swalWithBootstrapButtons.fire({
                                title: '¿Guardar cambios?',
                                text: '¿Deseas guardar los cambios en la información general?',
                                icon: 'question',
                                showCancelButton: true,
                                confirmButtonText: 'Sí, guardar',
                                cancelButtonText: 'Cancelar',
                                reverseButtons: true
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    @this.call('saveGeneralInfo');
                                }
                            });
                        });

                        // Botón de guardar configuración de seguridad
                        document.getElementById('saveSecurityBtn')?.addEventListener('click', function () {
                            swalWithBootstrapButtons.fire({
                                title: '¿Actualizar configuración?',
                                text: '¿Deseas actualizar la configuración de seguridad?',
                                icon: 'question',
                                showCancelButton: true,
                                confirmButtonText: 'Sí, actualizar',
                                cancelButtonText: 'Cancelar',
                                reverseButtons: true
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    @this.call('saveSecurityConfig');
                                }
                            });
                        });

                        // Escuchar evento de notificación de configuración
                        if (window.Livewire) {
                            Livewire.on('config-notify', (event) => {
                                const detail = event || {};
                                swalWithBootstrapButtons.fire({
                                    icon: detail.type || 'success',
                                    title: detail.title || 'Aviso',
                                    text: detail.message || '',
                                    confirmButtonText: 'Aceptar',
                                    showConfirmButton: true
                                });
                            });
                        }
                    });
                </script>
            </div>
