{{--
* Company: CETAM
* Project: ST
* File: tramites-disponibles.blade.php
* Created on: 04/11/2025
* Created by: Alfonso Angel Garca Hernndez
* Approved by: Alfonso Angel Garca Hernndez
*
* Changelog:
* - ID: <ID> | Modified on: dd/mm/yyyy |
    * Modified by: <Developer name> |
        * Description: <Brief description of change> |
            --}}
            <div>
                {{-- Page Header --}}
                <div class="py-4">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                            <li class="breadcrumb-item">
                                <a href="#">
                                    @icon('nav.home', 'fa-xs')
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Nuevo trámite</li>
                        </ol>
                    </nav>
                    <div class="d-flex justify-content-between w-100 flex-wrap">
                        <div class="mb-3 mb-lg-0">
                            <h1 class="h4">Catálogo de trámites</h1>
                            <p class="mb-0">Selecciona el trámite que deseas iniciar</p>
                        </div>
                    </div>
                </div>

                {{-- Flash messages --}}
                @if(session()->has('success'))
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

                @if(session()->has('error'))
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
                                <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </span>
                            <input type="text" class="form-control" placeholder="Buscar trámite..."
                                wire:model.live="search">
                        </div>
                        <div class="d-flex align-items-center text-nowrap">
                            <span class="small text-gray-600 me-2">Categoría:</span>
                            <select class="form-select" wire:model.live="categoryFilter" style="min-width: 200px;">
                                <option value="" selected>Todas las categorías</option>
                                <option value="personal">Gestión personal</option>
                                <option value="administrativo">Administrativo</option>
                                <option value="laboral">Laboral</option>
                                <option value="academico">Académico</option>
                            </select>
                        </div>
                        <div>
                            <button type="button" class="btn btn-outline-gray-600" wire:click="clearFilters">
                                <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Limpiar
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Tramites catalog --}}
                <div class="row">
                    @forelse($procesos as $proceso)
                        <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <div class="card border-0 shadow h-100">
                                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="icon-shape icon-sm icon-shape-{{ $proceso->priority == 'alta' ? 'danger' : ($proceso->priority == 'media' ? 'warning' : 'primary') }} rounded me-3">
                                            <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                    d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <h3 class="h6 mb-0">{{ $proceso->name }}</h3>
                                    </div>
                                    <span class="badge bg-primary">Disponible</span>
                                </div>
                                <div class="card-body">
                                    <p class="text-gray-700 small mb-3">{{ $proceso->description }}</p>
                                    @if($proceso->deadline_days)
                                        <div class="mb-3">
                                            <small class="text-gray-600 fw-bold d-block mb-1">Tiempo estimado:</small>
                                            <small class="text-gray-600">{{ $proceso->deadline_days }} das hbiles</small>
                                        </div>
                                    @endif
                                    @if($proceso->steps->count() > 0)
                                        <div class="mb-3">
                                            <small class="text-gray-600 fw-bold d-block mb-1">Pasos del proceso:</small>
                                            <small class="text-gray-600">{{ $proceso->steps->count() }} paso(s)</small>
                                        </div>
                                    @endif
                                    @if($proceso->category)
                                        <div class="mb-3">
                                            <small class="text-gray-600 fw-bold d-block mb-1">Categora:</small>
                                            <span class="badge bg-secondary text-capitalize">{{ $proceso->category }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="card-footer border-top d-grid">
                                    <button wire:click="iniciarTramite({{ $proceso->process_id }})" class="btn btn-primary">
                                        <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        Iniciar trámite
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="card border-0 shadow">
                                <div class="card-body text-center py-5">
                                    <svg class="icon icon-xl text-gray-400 mb-3" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V8a2 2 0 00-2-2h-5L9 4H4zm7 5a1 1 0 10-2 0v1H8a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V9z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <h4 class="h5 text-gray-600 mb-2">No hay trámites disponibles</h4>
                                    <p class="text-gray-500 mb-0">En este momento no hay trámites que coincidan con tu
                                        búsqueda.</p>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>

                {{-- Help section --}}
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card border-0 shadow">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="icon-shape icon-md icon-shape-primary rounded me-3">
                                        <svg class="icon icon-sm" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h3 class="h6 mb-1">Necesitas ayuda?</h3>
                                        <p class="mb-0 text-gray-600 small">Si tienes dudas sobre algún trámite,
                                            consulta nuestras <a href="#" class="text-primary fw-bold">preguntas
                                                frecuentes</a> o contacta al área de Recursos Humanos.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>