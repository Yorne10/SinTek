{{--
 * Company: CETAM
 * Project: ST
 * File: users.blade.php
 * Created on: 04/11/2025
 * Created by: Alfonso Angel García Hernández
 * Approved by: Alfonso Angel García Hernández
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
                    <li class="breadcrumb-item">Administración</li>
                    <li class="breadcrumb-item active" aria-current="page">Administrar usuarios</li>
                </ol>
            </nav>
            <h2 class="h4">Administrar usuarios</h2>
            <p class="mb-0">Gestiona los usuarios del sistema, sus roles y permisos.</p>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.users.create') }}" class="btn btn-sm btn-gray-800 d-inline-flex align-items-center">
                <span class="fas fa-user-plus me-2"></span>
                Nuevo usuario
            </a>
            <div class="btn-group ms-2 ms-lg-3">
                <button type="button" class="btn btn-sm btn-outline-gray-600">Exportar</button>
            </div>
        </div>
    </div>

    <div class="table-settings mb-4">
        <div class="row justify-content-between align-items-center">
            <div class="col-9 col-lg-8 d-md-flex">
                <div class="input-group me-2 me-lg-3 fmxw-300">
                    <span class="input-group-text">
                        <svg class="icon icon-xs" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                        </svg>
                    </span>
                    <input wire:model.live="search" type="text" class="form-control" placeholder="Buscar usuarios">
                </div>
                <select wire:model.live="roleFilter" class="form-select fmxw-200 d-none d-md-inline" aria-label="Filtrar por rol">
                    <option value="">Todos los roles</option>
                    <option value="admin">Administrador</option>
                    <option value="secretary">Secretario</option>
                    <option value="worker">Trabajador</option>
                </select>
            </div>
            <div class="col-3 col-lg-4 d-flex justify-content-end">
                <select wire:model.live="statusFilter" class="form-select fmxw-100" aria-label="Filtrar por estado">
                    <option value="">Todos</option>
                    <option value="active">Activo</option>
                    <option value="inactive">Inactivo</option>
                </select>
            </div>
        </div>
    </div>

    <div class="card card-body shadow border-0 table-wrapper table-responsive">
        <table class="table user-table table-hover align-items-center">
            <thead>
                <tr>
                    <th class="border-bottom">Nombre</th>
                    <th class="border-bottom">Correo</th>
                    <th class="border-bottom">Rol</th>
                    <th class="border-bottom">Estado</th>
                    <th class="border-bottom">Fecha de registro</th>
                    <th class="border-bottom">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>
                        <a href="#" class="d-flex align-items-center">
                            <div class="avatar rounded-circle me-3 d-flex align-items-center justify-content-center bg-primary text-white fw-bold" style="width: 48px; height: 48px; font-size: 1.2rem;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}{{ strtoupper(substr(explode(' ', $user->name)[1] ?? '', 0, 1)) }}
                            </div>
                            <div class="d-block">
                                <span class="fw-bold">{{ $user->name }}</span>
                                <div class="small text-gray">{{ '@' . strtolower(str_replace(' ', '.', explode(' ', $user->name)[0])) }}</div>
                            </div>
                        </a>
                    </td>
                    <td><span class="fw-normal">{{ $user->email }}</span></td>
                    <td>
                        <span class="fw-normal text-dark">{{ $this->getRoleLabel($user->role) }}</span>
                    </td>
                    <td>
                        @if($user->active)
                            <span class="fw-bold text-success">Activo</span>
                        @else
                            <span class="fw-bold text-danger">Inactivo</span>
                        @endif
                    </td>
                    <td><span class="fw-normal">{{ $user->created_at->format('d/m/Y') }}</span></td>
                    <td>
                        <div class="btn-group">
                            <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                </svg>
                            </button>
                            <div class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1">
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <svg class="dropdown-icon text-gray-400 me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>
                                    Ver detalles
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <svg class="dropdown-icon text-gray-400 me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path></svg>
                                    Editar
                                </a>
                                <div role="separator" class="dropdown-divider my-1"></div>
                                <a class="dropdown-item text-warning d-flex align-items-center" href="#">
                                    <svg class="dropdown-icon text-warning me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd"></path></svg>
                                    Desactivar
                                </a>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4">
                        <div class="text-gray-500">
                            <svg class="icon icon-lg mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
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
            <nav aria-label="Page navigation">
                {{ $users->links() }}
            </nav>
            @endif
            <div class="fw-normal small mt-4 mt-lg-0">
                Mostrando <b>{{ $users->firstItem() ?? 0 }}</b> a <b>{{ $users->lastItem() ?? 0 }}</b> de <b>{{ $users->total() }}</b> usuarios
            </div>
        </div>
    </div>
</div>
