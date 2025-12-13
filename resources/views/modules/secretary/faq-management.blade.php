{{-- 
Company: CETAM
Project: ST
File: faq-management.blade.php
Created on: 24/11/2025
Created by: Alfonso Angel Garcia Hernandez
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
                    <li class="breadcrumb-item">Secretaría</li>
                    <li class="breadcrumb-item active" aria-current="page">Preguntas frecuentes</li>
                </ol>
            </nav>
            <h2 class="h4">Categorías de Preguntas frecuentes</h2>
            <p class="mb-0">Gestiona las categorías y sus Preguntas frecuentes.</p>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.faq.category.create') }}"
                class="btn btn-sm btn-gray-800 d-inline-flex align-items-center">
                @icon('add', 'me-2')
                Nueva categoría
            </a>
        </div>
    </div>

    <div class="table-settings mb-4">
        <div class="d-flex flex-wrap gap-3 align-items-center">
            <div class="input-group fmxw-300">
                <span class="input-group-text">@icon('search', 'icon icon-xs')</span>
                <input wire:model.live.debounce.400ms="search" type="text" class="form-control"
                    placeholder="Buscar categorías">
            </div>
            <div class="ms-auto">
                <button wire:click="clearFilters"
                    class="btn btn-sm btn-secondary text-white d-inline-flex align-items-center">
                    @icon('refresh', 'me-2 text-white')
                    Limpiar filtros
                </button>
            </div>
        </div>
    </div>

    <div class="card card-body shadow border-0 table-wrapper table-responsive">
        <table class="table table-centered table-nowrap mb-0 rounded" style="table-layout: fixed;">
            <colgroup>
                <col style="width: 38%">
                <col style="width: 30%">
                <col style="width: 10%">
                <col style="width: 10%">
                <col style="width: 12%">
            </colgroup>
            <thead class="thead-light">
                <tr>
                    <th class="border-0 rounded-start">Nombre</th>
                    <th class="border-0">Descripción</th>
                    <th class="border-0">Orden</th>
                    <th class="border-0">Preguntas</th>
                    <th class="border-0 rounded-end text-start">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td>
                            <span
                                class="fw-bold text-gray-900 text-truncate d-inline-block w-100">{{ $category->name }}</span>
                        </td>
                        <td>
                            <span
                                class="fw-normal text-truncate d-inline-block w-100">{{ $category->description ?? 'Sin descripción' }}</span>
                        </td>
                        <td><span class="fw-normal">{{ $category->order }}</span></td>
                        <td><span class="fw-bold text-info">{{ $category->faqs_count }}</span></td>
                        <td class="text-start" style="width: 12%; min-width: 72px;">
                            <div class="btn-group position-static">
                                <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    @icon('menu', 'icon icon-xs')
                                </button>
                                <div class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1">
                                    <a class="dropdown-item d-flex align-items-center"
                                        href="{{ route(config('proj.route_name_prefix', 'proj') . '.faq.questions', $category->faq_category_id) }}">
                                        @icon('help', 'dropdown-icon text-gray-400 me-2')
                                        Ver preguntas
                                    </a>
                                    <a class="dropdown-item d-flex align-items-center"
                                        href="{{ route(config('proj.route_name_prefix', 'proj') . '.faq.category.edit', $category->faq_category_id) }}">
                                        @icon('edit', 'dropdown-icon text-gray-400 me-2')
                                        Editar categoría
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center align-middle py-4">
                            <div class="text-gray-500 d-flex flex-column align-items-center justify-content-center">
                                @icon('help', 'fa-2x mb-3 text-gray-400')
                                <p class="fw-bold mb-1">No hay categorías para mostrar</p>
                                <p class="small mb-0">Crea una nueva categoría para empezar</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div
            class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
            @if ($categories->hasPages())
                <nav aria-label="Page navigation" class="mb-3 mb-lg-0">
                    {{ $categories->onEachSide(1)->links('components.pagination-users') }}
                </nav>
            @endif
            <div class="fw-normal small mt-0 mt-lg-0 ms-lg-auto">
                Mostrando <b>{{ $categories->firstItem() ?? 0 }}</b> a
                <b>{{ $categories->lastItem() ?? 0 }}</b> de <b>{{ $categories->total() }}</b> categorías
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('faq-notify', (event) => {
            const detail = Array.isArray(event) ? event[0] : event;
            Swal.fire({
                icon: detail.type,
                title: detail.title,
                text: detail.message,
                showConfirmButton: false,
                timer: 2000
            });
        });
    });
</script>
