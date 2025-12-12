{{-- 
Company: CETAM
Project: ST
File: faq-category-form.blade.php
Created on: 10/12/2025
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
                    <li class="breadcrumb-item">
                        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.faq.categories') }}">
                            Preguntas frecuentes
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ $categoryId ? 'Editar' : 'Nueva' }} categoría
                    </li>
                </ol>
            </nav>
            <h2 class="h4">{{ $categoryId ? 'Editar' : 'Nueva' }} Categoría</h2>
            <p class="mb-0">{{ $categoryId ? 'Actualiza los detalles de la' : 'Crea una nueva' }} categoría de preguntas frecuentes.</p>
        </div>
    </div>

    <div class="row">
        {{-- Form --}}
        <div class="col-12 col-xl-8">
            <div class="card border-0 shadow mb-4">
                <div class="card-body">
                    <h2 class="h5 mb-4">Información de la categoría</h2>
                    <form wire:submit.prevent="save">
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="categoryName" class="form-label">Nombre de la categoría <span class="text-danger">*</span></label>
                                <input wire:model="categoryName" type="text"
                                    class="form-control @error('categoryName') is-invalid @enderror" id="categoryName"
                                    placeholder="Ej: Trámites generales">
                                @error('categoryName') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="categoryOrder" class="form-label">Orden de visualización <span class="text-danger">*</span></label>
                                <input wire:model="categoryOrder" type="number"
                                    class="form-control @error('categoryOrder') is-invalid @enderror" id="categoryOrder"
                                    min="1" max="{{ $maxOrder }}" placeholder="1">
                                @error('categoryOrder') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="categoryDescription" class="form-label">Descripción</label>
                                <textarea wire:model="categoryDescription"
                                    class="form-control @error('categoryDescription') is-invalid @enderror" id="categoryDescription"
                                    rows="3" placeholder="Descripción breve de la categoría..."></textarea>
                                @error('categoryDescription') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-12 mt-3">
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex flex-wrap align-items-center gap-2">
                                        <button type="button" class="btn btn-primary" id="saveCategoryBtn"
                                            data-max="{{ $maxOrder }}" data-original="{{ $originalOrder ?? $categoryOrder }}">
                                            @icon('save', 'icon-xs me-1')
                                            {{ $categoryId ? 'Actualizar' : 'Guardar' }} categoría
                                        </button>
                                        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.faq.categories') }}"
                                            class="btn btn-gray-300">
                                            Cancelar
                                        </a>
                                    </div>
                                    @if($categoryId)
                                        <div>
                                            <button type="button" id="deleteCategoryBtn" class="btn btn-danger">
                                                @icon('delete', 'icon-xs me-1')
                                                Eliminar categoría
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Info Sidebar --}}
        <div class="col-12 col-xl-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <h2 class="h6 mb-3">Información importante</h2>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0">
                            <div class="d-flex align-items-start">
                                @icon('info', 'fa-xs text-info me-3')
                                <div>
                                    <h3 class="h6">Nombre descriptivo</h3>
                                    <p class="text-gray-700 small mb-0">
                                        Usa un nombre claro que identifique el tema de las preguntas.
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="d-flex align-items-start">
                                @icon('info', 'fa-xs text-info me-3')
                                <div>
                                    <h3 class="h6">Orden de visualización</h3>
                                    <p class="text-gray-700 small mb-0">
                                        Las categorías se mostrarán ordenadas de menor a mayor número.
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="d-flex align-items-start">
                                @icon('info', 'fa-xs text-info me-3')
                                <div>
                                    <h3 class="h6">Eliminar categoría</h3>
                                    <p class="text-gray-700 small mb-0">
                                        Solo se pueden eliminar categorías sin preguntas asociadas.
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
    document.addEventListener('DOMContentLoaded', function () {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-primary me-2',
                cancelButton: 'btn btn-gray'
            },
            buttonsStyling: false
        });

        const isEdit = {{ $categoryId ? 'true' : 'false' }};
        const saveBtn = document.getElementById('saveCategoryBtn');

        const confirmFlow = (message) => swalWithBootstrapButtons.fire({
            icon: 'warning',
            title: 'Aviso',
            text: message,
            confirmButtonText: 'Entendido',
            showCancelButton: false
        });

        const confirmQuestion = () => swalWithBootstrapButtons.fire({
            title: isEdit ? '¿Actualizar categoría?' : '¿Guardar categoría?',
            text: isEdit ? '¿Deseas actualizar los detalles de esta categoría?' : '¿Deseas crear esta categoría?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: isEdit ? 'Sí, actualizar' : 'Sí, guardar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        });

        saveBtn?.addEventListener('click', function (e) {
            e.preventDefault();
            const orderInput = document.getElementById('categoryOrder');
            const desired = parseInt(orderInput.value || '1', 10);
            const max = parseInt(saveBtn.dataset.max || '1', 10);
            const original = parseInt(saveBtn.dataset.original || '1', 10);

            const proceed = () => {
                confirmQuestion().then((result) => {
                    if (result.isConfirmed) {
                        @this.call('save');
                    }
                });
            };

            if (desired > max) {
                confirmFlow(`El orden solicitado supera el máximo (${max}). Se ajustará al último número secuencial.`)
                    .then(() => {
                        orderInput.value = max;
                        @this.set('categoryOrder', max);
                        proceed();
                    });
                return;
            }

            proceed();
        });

        // Confirmation before delete
        document.getElementById('deleteCategoryBtn')?.addEventListener('click', function (e) {
            e.preventDefault();

            const swalWithDangerButton = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-danger me-2',
                    cancelButton: 'btn btn-gray'
                },
                buttonsStyling: false
            });

            swalWithDangerButton.fire({
                title: '¿Eliminar categoría?',
                text: 'Solo se pueden eliminar categorías sin preguntas asociadas.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('deleteCategory');
                }
            });
        });

        // Listeners for alerts
        if (window.Livewire) {
            Livewire.on('category-saved', (detail) => {
                const payload = Array.isArray(detail) ? detail[0] : detail || {};
                swalWithBootstrapButtons.fire({
                    icon: payload.type || 'success',
                    title: payload.title || 'Éxito',
                    text: payload.message || '',
                    confirmButtonText: 'Entendido'
                });
            });

            Livewire.on('category-error', (detail) => {
                const payload = Array.isArray(detail) ? detail[0] : detail || {};
                swalWithBootstrapButtons.fire({
                    icon: payload.type || 'error',
                    title: payload.title || 'Error',
                    text: payload.message || '',
                    confirmButtonText: 'Entendido'
                });
            });
        }
    });
</script>
