{{--
Company: CETAM
Project: ST
File: notifications-history.blade.php
Created on: 12/12/2025
Created by: Codex
Approved by: Alfonso Angel Garcia Hernandez
--}}

<div>
    {{-- Page Header --}}
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
                    <li class="breadcrumb-item active" aria-current="page">Notificaciones</li>
                </ol>
            </nav>
            <h2 class="h4">Notificaciones</h2>
            <p class="mb-0">Consulta las notificaciones enviadas a los trabajadores.</p>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.notifications.send') }}"
                class="btn btn-sm btn-gray-800 d-inline-flex align-items-center">
                @icon('send', 'me-2')
                Enviar notificación
            </a>
        </div>
    </div>

    {{-- Filters and Search --}}
    <div class="table-settings mb-4">
        <div class="d-flex flex-wrap gap-3 align-items-center">
            <div class="input-group fmxw-300">
                <span class="input-group-text">@icon('search', 'icon icon-xs')</span>
                <input wire:model.live.debounce.300ms="searchTitle" type="text" class="form-control"
                    placeholder="Buscar por título">
            </div>
            <div class="input-group fmxw-300">
                <span class="input-group-text">@icon('search', 'icon icon-xs')</span>
                <input wire:model.live.debounce.300ms="searchUser" type="text" class="form-control"
                    placeholder="Buscar por usuario">
            </div>
            <div class="d-flex align-items-center text-nowrap">
                <span class="small text-gray-600 me-2">Filtrar por estado:</span>
                <select wire:model.live="statusFilter" class="form-select" style="min-width: 200px;"
                    aria-label="Filtrar por estado">
                    <option value="">Todas</option>
                    <option value="leida">Leída</option>
                    <option value="pendiente">Pendiente</option>
                </select>
            </div>
            <div class="ms-auto">
                <button wire:click="clearFilters" type="button"
                    class="btn btn-sm btn-secondary text-white d-inline-flex align-items-center">
                    @icon('refresh', 'me-2 text-white')
                    Limpiar filtros
                </button>
            </div>
        </div>
    </div>

    {{-- Notifications Table --}}
    <div class="card card-body border-0 shadow mb-4">
        <div class="table-responsive">
            <table class="table table-centered mb-0 rounded user-table w-100" style="table-layout: fixed;">
                <colgroup>
                    <col style="width: 28%">
                    <col style="width: 20%">
                    <col style="width: 22%">
                    <col style="width: 14%">
                    <col style="width: 8%">
                    <col style="width: 8%">
                </colgroup>
                <thead class="thead-light">
                    <tr>
                        <th class="border-0 rounded-start">Título</th>
                        <th class="border-0">Nombre</th>
                        <th class="border-0">Correo</th>
                        <th class="border-0">Fecha</th>
                        <th class="border-0">Estado</th>
                        <th class="border-0 rounded-end text-start">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse( as )
                        <tr>
                            <td>
                                <span class="fw-bold">{{ ->title }}</span>
                            </td>
                            <td>
                                <span class="fw-normal">{{ ->user->name ?? 'N/A' }}</span>
                            </td>
                            <td>
                                <span class="fw-normal">{{ ->user->email ?? 'N/A' }}</span>
                            </td>
                            <td>
                                <span class="fw-normal">{{ ->created_at->format('d/m/Y') }}</span>
                                <span class="text-gray"> - </span>
                                <span class="fw-normal">{{ ->created_at->format('H:i') }}</span>
                            </td>
                            <td>
                                @if(->read_at)
                                    <span class="fw-bold text-success">Leída</span>
                                @else
                                    <span class="fw-bold text-warning">Pendiente</span>
                                @endif
                            </td>
                            <td class="text-start" style="width: 8%; min-width: 72px;">
                                <div class="btn-group position-static">
                                    <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        @icon('menu', 'icon icon-xs')
                                    </button>
                                    <div class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1">
                                        <a class="dropdown-item d-flex align-items-center"
                                            href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.notifications.edit', ->notification_id) }}">
                                            @icon('edit', 'dropdown-icon text-gray-400 me-2')
                                            Editar
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="mb-3">
                                    @icon('notification', 'fa-3x text-gray-400')
                                </div>
                                <h5 class="text-gray-600">No hay notificaciones</h5>
                                <p class="text-gray-500 small mb-0">
                                    Aún no se han enviado notificaciones a los trabajadores.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
            @if(->hasPages())
                <nav aria-label="Page navigation" class="mb-3 mb-lg-0">
                    {{ ->links() }}
                </nav>
            @endif
            <div class="fw-normal small mt-4 mt-lg-0 ms-lg-auto">
                Mostrando <b>{{ ->firstItem() ?? 0 }}</b> a
                <b>{{ ->lastItem() ?? 0 }}</b> de <b>{{ ->total() }}</b> notificaciones
            </div>
        </div>
    </div>
</div>
