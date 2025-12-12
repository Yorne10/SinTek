{{--
Company: CETAM
Project: ST
File: budget-keys.blade.php
Created on: 04/12/2025
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
                    <li class="breadcrumb-item">Secretaría</li>
                    <li class="breadcrumb-item active" aria-current="page">Gestionar Claves</li>
                </ol>
            </nav>
            <h2 class="h4">Gestión de Claves Presupuestales</h2>
            <p class="mb-0">Administra las claves presupuestales y puestos disponibles.</p>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <button wire:click="create" class="btn btn-sm btn-gray-800 d-inline-flex align-items-center">
                @icon('add', 'me-2')
                Nueva Clave
            </button>
        </div>
    </div>

    <div class="table-settings mb-4">
        <div class="d-flex flex-wrap gap-3 align-items-center">
            <div class="input-group fmxw-300">
                <span class="input-group-text">@icon('search', 'icon icon-xs')</span>
                <input wire:model.live.debounce.400ms="search" type="text" class="form-control"
                    placeholder="Buscar clave o puesto...">
            </div>
            <div class="ms-auto">
                <button wire:click="$set('search','')" class="btn btn-sm btn-secondary text-white d-inline-flex align-items-center">
                    @icon('refresh','me-2 text-white')
                    Limpiar filtros
                </button>
            </div>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card card-body shadow border-0 table-wrapper table-responsive">
        <table class="table table-centered mb-0 rounded user-table align-items-center w-100" style="table-layout: fixed;">
            <colgroup>
                <col style="width: 35%">
                <col style="width: 45%">
                <col style="width: 20%">
            </colgroup>
            <thead class="thead-light">
                <tr>
                    <th class="border-0 rounded-start">Clave Presupuestal</th>
                    <th class="border-0">Nombre del Puesto</th>
                    <th class="border-0 rounded-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($positions as $position)
                    <tr>
                        <td>
                            <span class="fw-bold text-gray-900">{{ $position->budget_key }}</span>
                        </td>
                        <td>
                            <span class="fw-normal">{{ $position->position_name }}</span>
                        </td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    @icon('menu', 'icon icon-xs')
                                </button>
                                <div class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1">
                                    <button wire:click="edit({{ $position->positions_id }})"
                                        class="dropdown-item d-flex align-items-center" type="button">
                                        @icon('edit', 'dropdown-icon text-gray-400 me-2')
                                        Editar
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center py-4">
                            <div class="text-gray-500">
                                <div class="mb-3">
                                    @icon('jobCredential', 'fa-2x')
                                </div>
                                <p class="fw-bold">No hay claves presupuestales para mostrar</p>
                                <p class="small">Crea una nueva clave o ajusta los filtros de búsqueda</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div
            class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
            @if ($positions->hasPages())
                <nav aria-label="Page navigation" class="mb-3 mb-lg-0">
                    {{ $positions->onEachSide(1)->links('components.pagination-users') }}
                </nav>
            @endif
            <div class="fw-normal small mt-0 mt-lg-0 ms-lg-auto">
                Mostrando <b>{{ $positions->firstItem() ?? 0 }}</b> a
                <b>{{ $positions->lastItem() ?? 0 }}</b> de <b>{{ $positions->total() }}</b> claves
            </div>
        </div>
    </div>
</div>


