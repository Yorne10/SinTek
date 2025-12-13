{{--
Company: CETAM
Project: ST
File: faq-category-form.blade.php
Created on: 10/12/2025
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
                    <li class="breadcrumb-item">Secretaria</li>
                    <li class="breadcrumb-item">
                        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.faq.categories') }}">
                            Preguntas frecuentes
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ $categoryId ? 'Editar' : 'Nueva' }} categoria
                    </li>
                </ol>
            </nav>
            <h2 class="h4">{{ $categoryId ? 'Editar' : 'Nueva' }} Categoria</h2>
            <p class="mb-0">{{ $categoryId ? 'Actualiza los detalles de la' : 'Crea una nueva' }} categoria de
                preguntas frecuentes.</p>
        </div>
    </div>

    <div class="row">
        {{-- Form --}}
        <div class="col-12 col-xl-8">
            <div class="card border-0 shadow mb-4">
                <div class="card-body">
                    <h2 class="h5 mb-4">Informacion de la categoria</h2>
                    <form wire:submit.prevent="save">
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="categoryName" class="form-label">Nombre de la categoria <span
                                        class="text-danger">*</span></label>
                                <input wire:model="categoryName" type="text"
                                    class="form-control @error('categoryName') is-invalid @enderror" id="categoryName"
                                    placeholder="Ej: Tramites generales">
                                @error('categoryName')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="categoryOrder" class="form-label">Orden de visualizacion <span
                                        class="text-danger">*</span></label>
                                <input wire:model="categoryOrder" type="number"
                                    class="form-control @error('categoryOrder') is-invalid @enderror" id="categoryOrder"
                                    min="1" max="{{ $maxOrder }}" placeholder="1">
                                @error('categoryOrder')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="categoryDescription" class="form-label">Descripcion <span
                                        class="text-danger">*</span></label>
                                <textarea wire:model="categoryDescription" class="form-control @error('categoryDescription') is-invalid @enderror"
                                    id="categoryDescription" rows="3" placeholder="Descripcion breve de la categoria..."></textarea>
                                @error('categoryDescription')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mt-3">
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex flex-wrap align-items-center gap-2">
                                        <button type="button" class="btn btn-primary" id="saveCategoryBtn"
                                            data-max="{{ $maxOrder }}"
                                            data-original="{{ $originalOrder ?? $categoryOrder }}">
                                            @icon('save', 'icon-xs me-1')
                                            {{ $categoryId ? 'Actualizar' : 'Guardar' }} categoria
                                        </button>
                                        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.faq.categories') }}"
                                            class="btn btn-gray-300">
                                            Cancelar
                                        </a>
                                    </div>
                                    @if ($categoryId)
                                        <div>
                                            <button type="button" id="deleteCategoryBtn" class="btn btn-danger">
                                                @icon('delete', 'icon-xs me-1')
                                                Eliminar categoria
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
                    <h2 class="h6 mb-3">Informacion importante</h2>
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
                                    <h3 class="h6">Orden de visualizacion</h3>
                                    <p class="text-gray-700 small mb-0">
                                        Las categorias se mostraran ordenadas de menor a mayor numero.
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
    document.addEventListener('DOMContentLoaded', function() {
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
            title: isEdit ? '¿Actualizar categoria?' : '¿Guardar categoria?',
            text: isEdit ? '¿Deseas actualizar los detalles de esta categoria?' :
                '¿Deseas crear esta categoria?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: isEdit ? 'Si, actualizar' : 'Si, guardar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        });

        saveBtn?.addEventListener('click', function(e) {
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
                confirmFlow(
                        `El orden solicitado supera el maximo (${max}). Se ajustara al ultimo numero secuencial.`
                        )
                    .then(() => {
                        orderInput.value = max;
                        @this.set('categoryOrder', max);
                        proceed();
                    });
                return;
            }

            proceed();
        });
        // Confirmation before delete - llama al backend que decide el flujo
        document.getElementById('deleteCategoryBtn')?.addEventListener('click', function(e) {
            e.preventDefault();
            @this.call('deleteCategory');
        });

        // Listeners for alerts
        if (window.Livewire) {
            Livewire.on('category-saved', (detail) => {
                const payload = Array.isArray(detail) ? detail[0] : detail || {};
                swalWithBootstrapButtons.fire({
                    icon: payload.type || 'success',
                    title: payload.title || 'Exito',
                    text: payload.message || '',
                    confirmButtonText: 'Entendido'
                }).then(() => {
                    if (payload.redirect) {
                        window.location.href = payload.redirect;
                    }
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

            Livewire.on('category-has-faqs', (detail) => {
                const payload = Array.isArray(detail) ? detail[0] : detail || {};
                const count = payload.count || 0;

                // Primero warning informativo
                swalWithBootstrapButtons.fire({
                    icon: 'warning',
                    title: 'Atencion',
                    text: `Esta categoria tiene ${count} pregunta(s) frecuente(s) asociada(s) que tambien se eliminaran.`,
                    confirmButtonText: 'Entendido'
                }).then(() => {
                    // Despues question de confirmacion
                    swalWithBootstrapButtons.fire({
                        icon: 'question',
                        title: '¿Eliminar categoria?',
                        text: '¿Estas seguro de eliminar esta categoria y sus preguntas frecuentes?',
                        showCancelButton: true,
                        confirmButtonText: 'Si, eliminar',
                        cancelButtonText: 'Cancelar',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            @this.call('confirmDeleteWithFaqs');
                        }
                    });
                });
            });

            // Para categorias SIN FAQs - solo question
            Livewire.on('category-no-faqs', () => {
                swalWithBootstrapButtons.fire({
                    icon: 'question',
                    title: '¿Eliminar categoria?',
                    text: '¿Estas seguro de eliminar esta categoria? Esta accion no se puede deshacer.',
                    showCancelButton: true,
                    confirmButtonText: 'Si, eliminar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.call('confirmDelete');
                    }
                });
            });
        }
    });
</script>
