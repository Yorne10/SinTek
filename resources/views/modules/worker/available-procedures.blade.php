{{-- 
    Company: CETAM
    Project: ST
    File: available-procedures.blade.php
    Created on: 04/12/2025
    Created by: Alfonso Angel Garcia Hernandez
    Approved by: Alfonso Angel Garcia Hernandez

    Changelog:
    - ID: <ID> | Date: dd/mm/yyyy
      Modified by: <Developer name>
      Description: <Brief description of change>
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
                    <li class="breadcrumb-item active" aria-current="page">Nuevo tramite</li>
                </ol>
            </nav>
            <h2 class="h4">Catalogo de tramites</h2>
            <p class="mb-0">Selecciona el tramite que deseas iniciar</p>
        </div>
    </div>

    {{-- Flash messages --}}
    @if (session()->has('success'))
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-success d-flex align-items-center" role="alert">
                    <svg class="icon icon-sm me-2" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <div>{{ session('success') }}</div>
                </div>
            </div>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <svg class="icon icon-sm me-2" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <div>{{ session('error') }}</div>
                </div>
            </div>
        </div>
    @endif

    {{-- Filters --}}
    <div class="table-settings mb-4">
        <div class="d-flex flex-wrap gap-3 align-items-center">
            <div class="input-group fmxw-300">
                <span class="input-group-text">
                    <svg class="icon icon-xs" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                        aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                            clip-rule="evenodd"></path>
                    </svg>
                </span>
                <input type="text" class="form-control" placeholder="Buscar tramite..."
                    wire:model.live.debounce.300ms="search">
            </div>
            <div class="d-flex align-items-center text-nowrap">
                <span class="small text-gray-600 me-2">Filtrar por categoria:</span>
                <select class="form-select" wire:model.live="categoryFilter" style="min-width: 200px;">
                    <option value="">Todas las categorias</option>
                    <option value="personal">Gestion personal</option>
                    <option value="administrativo">Administrativo</option>
                    <option value="laboral">Laboral</option>
                    <option value="academico">Academico</option>
                </select>
            </div>
            <div class="ms-auto">
                <button type="button" class="btn btn-sm btn-secondary text-white d-inline-flex align-items-center"
                    wire:click="clearFilters">
                    @icon('refresh', 'me-2 text-white')
                    Limpiar filtros
                </button>
            </div>
        </div>
    </div>

    {{-- Tramites catalog --}}
    <div class="row">
        @forelse($processes as $process)
            <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="card border-0 shadow h-100">
                    <div class="card-body d-flex flex-column">
                        <h3 class="h6 mb-2">{{ $process->name }}</h3>
                        <p class="text-gray-700 small mb-3">{{ $process->description }}</p>
                        @if ($process->deadline_days)
                            <div class="mb-3">
                                <small class="text-gray-600 fw-bold d-block mb-1">Tiempo estimado:</small>
                                <small class="text-gray-600">{{ $process->deadline_days }} dias habiles</small>
                            </div>
                        @endif
                        @if ($process->steps->count() > 0)
                            <div class="mb-3">
                                <small class="text-gray-600 fw-bold d-block mb-1">Pasos del proceso:</small>
                                <small class="text-gray-600">{{ $process->steps->count() }} paso(s)</small>
                            </div>
                        @endif
                        @if ($process->category)
                            <div class="mb-3">
                                <small class="text-gray-600 fw-bold d-block mb-1">Categoria:</small>
                                <span class="small fw-bold text-info text-capitalize">{{ $process->category }}</span>
                            </div>
                        @endif
                        <div class="mt-auto d-grid">
                            <button wire:click="startProcedure({{ $process->process_id }})" class="btn btn-gray-800"
                                wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="startProcedure({{ $process->process_id }})">
                                    @icon('add', 'me-2')
                                    Iniciar tramite
                                </span>
                                <span wire:loading wire:target="startProcedure({{ $process->process_id }})">
                                    <span class="spinner-border spinner-border-sm me-2" role="status"
                                        aria-hidden="true"></span>
                                    Iniciando...
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card border-0 shadow">
                    <div class="card-body text-center py-5">
                        <div class="mb-3">
                            @icon('documentSign', 'fa-3x text-gray-400')
                        </div>
                        <h4 class="h5 text-gray-600 mb-2">No hay tramites disponibles</h4>
                        <p class="text-gray-500 mb-0">En este momento no hay tramites que coincidan con tu busqueda.</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if ($processes->hasPages())
        <div class="d-flex flex-column flex-lg-row align-items-center justify-content-between mt-4 gap-3">
            <nav aria-label="Paginacion de tramites">
                {{ $processes->onEachSide(1)->links('components.pagination-users') }}
            </nav>
            <div class="fw-normal small ms-lg-auto">
                Mostrando <b>{{ $processes->firstItem() ?? 0 }}</b> a <b>{{ $processes->lastItem() ?? 0 }}</b> de
                <b>{{ $processes->total() }}</b> tramites
            </div>
        </div>
    @endif
</div>
