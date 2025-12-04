{{--
* Company: CETAM
* Project: ST
* File: users.blade.php
* Created on: 04/11/2025
* Created by: Alfonso Angel Garca Hernndez
* Approved by: Alfonso Angel Garca Hernndez
*
* Changelog:
* - ID: <ID> | Modified on: dd/mm/yyyy |
    * Modified by: <Developer name> |
        * Description: <Brief description of change> |
            *
            * - ID: <ID> | Modified on: dd/mm/yyyy |
                * Modified by: <Developer name> |
                    * Description: <Brief description of change> |
                        --}}

                        {{-- Nota Livewire: esta vista debe tener UN nico elemento raz --}}
                        {{-- El layout se aplica desde el componente con ->layout('layouts.app') --}}

                        <div>
                            <div
                                class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
                                <div class="d-block mb-4 mb-md-0">
                                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                                        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                                            <li class="breadcrumb-item">
                                                <a
                                                    href="{{ route(config('proj.route_name_prefix', 'proj') . '.dashboard.index') }}">
                                                    @icon('nav.home', 'fa-xs')
                                                </a>
                                            </li>
                                            <li class="breadcrumb-item">Administración</li>
                                            <li class="breadcrumb-item active" aria-current="page">Administrar usuarios
                                            </li>
                                        </ol>
                                    </nav>
                                    <h2 class="h4">Administrar usuarios</h2>
                                    <p class="mb-0">Gestiona los usuarios del sistema, sus roles y permisos.</p>
                                </div>
                                <div class="btn-toolbar mb-2 mb-md-0">
                                    <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.users.create') }}"
                                        class="btn btn-sm btn-gray-800 d-inline-flex align-items-center">
                                        @icon('user.add', 'me-2')
                                        Nuevo usuario
                                    </a>
                                </div>
                            </div>

                            <div class="table-settings mb-4">
                                <div class="d-flex flex-wrap gap-3 align-items-center">
                                    <div class="input-group fmxw-300">
                                        <span class="input-group-text">
                                            <svg class="icon icon-xs" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd"
                                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </span>
                                        <input wire:model.live.debounce.400ms="search" type="text"
                                            class="form-control" placeholder="Buscar usuarios">
                                    </div>
                                    <div class="d-flex align-items-center text-nowrap">
                                        <span class="small text-gray-600 me-2">Filtrar por rol:</span>
                                        <select wire:model.live="roleFilter"
                                            class="form-select"
                                            style="min-width: 200px;"
                                            aria-label="Filtrar por rol">
                                            <option value="">Todos los roles</option>
                                            <option value="admin">Administrador</option>
                                            <option value="secretary">Secretario</option>
                                            <option value="worker">Trabajador</option>
                                        </select>
                                    </div>
                                    <div class="d-flex align-items-center text-nowrap">
                                        <span class="small text-gray-600 me-2">Filtrar por estado:</span>
                                        <select wire:model.live="statusFilter" class="form-select"
                                            style="min-width: 140px;"
                                            aria-label="Filtrar por estado">
                                            <option value="">Todos</option>
                                            <option value="active">Activo</option>
                                            <option value="inactive">Inactivo</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="card card-body shadow border-0 table-wrapper table-responsive">
                                <table class="table table-centered table-nowrap mb-0 rounded user-table align-items-center">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="border-0 rounded-start">Nombre</th>
                                            <th class="border-0">Correo</th>
                                            <th class="border-0">Rol</th>
                                            <th class="border-0">Estado</th>
                                            <th class="border-0">Fecha de registro</th>
                                            <th class="border-0 rounded-end">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($users as $user)
                                            <tr>
                                                <td>
                                                    <span class="fw-bold text-gray-900">{{ $user->name }}</span>
                                                </td>
                                                <td><span class="fw-normal">{{ $user->email }}</span></td>
                                                <td>
                                                    <span
                                                        class="fw-normal text-dark">{{ $this->getRoleLabel($user->role) }}</span>
                                                </td>
                                                <td>
                                                    @if($user->is_active)
                                                        <span class="fw-bold text-success">Activo</span>
                                                    @else
                                                        <span class="fw-bold text-warning">Inactivo</span>
                                                    @endif
                                                </td>
                                                <td><span class="fw-normal">{{ $user->created_at->format('d/m/Y') }}</span>
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button
                                                            class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                                                            data-bs-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            <svg class="icon icon-xs" fill="currentColor"
                                                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z">
                                                                </path>
                                                            </svg>
                                                        </button>
                                                        <div
                                                            class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1">
                                                            <button class="dropdown-item d-flex align-items-center view-user-detail"
                                                                type="button"
                                                                data-user-id="{{ $user->users_id }}"
                                                                data-user-name="{{ $user->name }}"
                                                                data-user-email="{{ $user->email }}"
                                                                data-user-role="{{ $this->getRoleLabel($user->role) }}"
                                                                data-user-active="{{ $user->is_active ? '1' : '0' }}"
                                                                data-user-created="{{ $user->created_at->format('d/m/Y H:i') }}"
                                                                data-user-curp="{{ $user->role === 'worker' && $user->worker ? ($user->worker->curp ?? '') : '' }}"
                                                                data-user-rfc="{{ $user->role === 'worker' && $user->worker ? ($user->worker->rfc ?? '') : '' }}"
                                                                data-user-phone="{{ $user->role === 'worker' && $user->worker ? ($user->worker->phone ?? '') : '' }}"
                                                                data-user-department="{{ $user->role === 'worker' && $user->worker ? ($user->worker->department ?? '') : '' }}"
                                                                data-user-position="{{ $user->role === 'worker' && $user->worker ? ($user->worker->position ?? '') : '' }}"
                                                                data-user-address="{{ $user->role === 'worker' && $user->worker ? ($user->worker->address ?? '') : '' }}"
                                                                data-is-worker="{{ $user->role === 'worker' ? '1' : '0' }}">
                                                                @icon('action.view', 'dropdown-icon text-gray-400 me-2')
                                                                Ver detalles
                                                            </button>
                                                            <a class="dropdown-item d-flex align-items-center"
                                                                href="{{ route(config('proj.route_name_prefix', 'proj') . '.users.edit', $user->users_id) }}">
                                                                @icon('action.edit', 'dropdown-icon text-gray-400 me-2')
                                                                Editar
                                                            </a>
                                                            <div role="separator" class="dropdown-divider my-1"></div>
                                                            <button
                                                                class="dropdown-item {{ $user->is_active ? 'text-warning' : 'text-success' }} d-flex align-items-center toggle-user-status"
                                                                type="button" data-user-id="{{ $user->users_id }}"
                                                                data-user-name="{{ $user->name }}"
                                                                data-user-active="{{ $user->is_active ? '1' : '0' }}"
                                                                wire:loading.attr="disabled" wire:target="toggleUserStatus">
                                                                <span class="spinner-border spinner-border-sm me-2"
                                                                    role="status" aria-hidden="true" wire:loading
                                                                    wire:target="toggleUserStatus"></span>
                                                                @icon($user->is_active ? 'state.warning' : 'state.success', "dropdown-icon {{ $user->is_active ? 'text-warning' : 'text-success' }} me-2")
                                                                {{ $user->is_active ? 'Desactivar' : 'Activar' }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center py-4">
                                                    <div class="text-gray-500">
                                                        <div class="mb-3">
                                                            @icon('user.list', 'fa-3x')
                                                        </div>
                                                        <p class="fw-bold">No se encontraron usuarios</p>
                                                        <p class="small">Intenta ajustar los filtros de búsqueda</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <div class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
                                    @if($users->hasPages())
                                        <nav aria-label="Page navigation" class="mb-3 mb-lg-0">
                                            {{ $users->onEachSide(1)->links('components.pagination-users') }}
                                        </nav>
                                    @endif
                                    <div class="fw-normal small mt-0 mt-lg-0 ms-lg-auto">
                                        Mostrando <b>{{ $users->firstItem() ?? 0 }}</b> a
                                        <b>{{ $users->lastItem() ?? 0 }}</b> de <b>{{ $users->total() }}</b> usuarios
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

                                    // Event listener para ver detalles
                                    document.addEventListener('click', function (e) {
                                        if (e.target.closest('.view-user-detail')) {
                                            e.preventDefault();
                                            const button = e.target.closest('.view-user-detail');
                                            const userName = button.getAttribute('data-user-name');
                                            const userEmail = button.getAttribute('data-user-email');
                                            const userRole = button.getAttribute('data-user-role');
                                            const userActive = button.getAttribute('data-user-active') === '1';
                                            const userCreated = button.getAttribute('data-user-created');
                                            const isWorker = button.getAttribute('data-is-worker') === '1';

                                            let htmlContent = `
                                                <div class="text-start">
                                                    <p class="mb-2"><span class="fw-bold">Nombre:</span> ${userName}</p>
                                                    <p class="mb-2"><span class="fw-bold">Correo:</span> ${userEmail}</p>
                                                    <p class="mb-2"><span class="fw-bold">Rol:</span> ${userRole}</p>
                                                    <p class="mb-2"><span class="fw-bold">Estado:</span> <span class="fw-bold text-${userActive ? 'success' : 'warning'}">${userActive ? 'Activo' : 'Inactivo'}</span></p>
                                                    <p class="mb-2"><span class="fw-bold">Fecha de registro:</span> ${userCreated}</p>
                                            `;

                                            if (isWorker) {
                                                const curp = button.getAttribute('data-user-curp') || 'N/A';
                                                const rfc = button.getAttribute('data-user-rfc') || 'N/A';
                                                const phone = button.getAttribute('data-user-phone') || 'N/A';
                                                const department = button.getAttribute('data-user-department') || 'N/A';
                                                const position = button.getAttribute('data-user-position') || 'N/A';
                                                const address = button.getAttribute('data-user-address') || 'N/A';

                                                htmlContent += `
                                                    <hr class="my-3">
                                                    <h6 class="fw-bold mb-2">Información adicional del trabajador</h6>
                                                    <p class="mb-2"><span class="fw-bold">CURP:</span> ${curp}</p>
                                                    <p class="mb-2"><span class="fw-bold">RFC:</span> ${rfc}</p>
                                                    <p class="mb-2"><span class="fw-bold">Teléfono:</span> ${phone}</p>
                                                    <p class="mb-2"><span class="fw-bold">Departamento:</span> ${department}</p>
                                                    <p class="mb-2"><span class="fw-bold">Puesto:</span> ${position}</p>
                                                    <p class="mb-0"><span class="fw-bold">Dirección:</span> ${address}</p>
                                                `;
                                            }

                                            htmlContent += '</div>';

                                            swalWithBootstrapButtons.fire({
                                                title: 'Detalles del usuario',
                                                html: htmlContent,
                                                icon: 'info',
                                                confirmButtonText: 'Cerrar',
                                                showConfirmButton: true,
                                                width: '600px'
                                            });
                                        }
                                    });

                                    // Event listener para botones de activar/desactivar
                                    document.addEventListener('click', function (e) {
                                        if (e.target.closest('.toggle-user-status')) {
                                            e.preventDefault();
                                            const button = e.target.closest('.toggle-user-status');
                                            const userId = button.getAttribute('data-user-id');
                                            const userName = button.getAttribute('data-user-name');
                                            const isActive = button.getAttribute('data-user-active') === '1';

                                            const action = isActive ? 'desactivar' : 'activar';
                                            const actionTitle = isActive ? 'Desactivar usuario' : 'Activar usuario';
                                            const actionText = isActive
                                                ? `¿Estás seguro de desactivar al usuario ${userName}? El usuario no podrá iniciar sesión.`
                                                : `¿Estás seguro de activar al usuario ${userName}? El usuario podrá iniciar sesión nuevamente.`;
                                            const confirmText = isActive ? 'Sí, desactivar' : 'Sí, activar';

                                            swalWithBootstrapButtons.fire({
                                                title: actionTitle,
                                                text: actionText,
                                                icon: 'question',
                                                showCancelButton: true,
                                                confirmButtonText: confirmText,
                                                cancelButtonText: 'Cancelar',
                                                reverseButtons: true
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    @this.call('toggleUserStatus', userId);
                                                }
                                            });
                                        }
                                    });

                                    // Escuchar evento de notificación de usuarios
                                    if (window.Livewire) {
                                        Livewire.on('users-notify', (event) => {
                                            const detail = event || {};
                                            const iconType = detail.type || 'success';
                                            const confirmText = iconType === 'warning' ? 'Entendido' : 'Aceptar';
                                            swalWithBootstrapButtons.fire({
                                                icon: iconType,
                                                title: detail.title || 'Aviso',
                                                text: detail.message || '',
                                                confirmButtonText: confirmText,
                                                showConfirmButton: true
                                            });
                                        });
                                    }
                                });
                            </script>
                        </div>
