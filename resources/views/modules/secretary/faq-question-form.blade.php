{{--
Company: CETAM
Project: ST
File: faq-question-form.blade.php
Created on: 11/12/2025
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
                    <li class="breadcrumb-item">Secretaría</li>
                    <li class="breadcrumb-item">
                        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.faq.categories') }}">
                            Preguntas frecuentes
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.faq.questions', $categoryId) }}">
                            {{ $category->name }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ $faqId ? 'Editar' : 'Nueva' }} pregunta
                    </li>
                </ol>
            </nav>
            <h2 class="h4">{{ $faqId ? 'Editar' : 'Nueva' }} Pregunta</h2>
            <p class="mb-0">{{ $faqId ? 'Actualiza los detalles de la' : 'Crea una nueva' }} pregunta frecuente en la categoría <strong>{{ $category->name }}</strong>.</p>
        </div>
    </div>

    <div class="row">
        {{-- Form --}}
        <div class="col-12 col-xl-8">
            <div class="card border-0 shadow mb-4">
                <div class="card-body">
                    <h2 class="h5 mb-4">Información de la pregunta</h2>
                    <form wire:submit.prevent="save">
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="faqQuestion" class="form-label">Pregunta <span
                                        class="text-danger">*</span></label>
                                <input wire:model="faqQuestion" type="text"
                                    class="form-control @error('faqQuestion') is-invalid @enderror" id="faqQuestion"
                                    placeholder="Ej: ¿Cómo puedo solicitar una constancia?">
                                @error('faqQuestion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="faqOrder" class="form-label">Orden de visualización <span
                                        class="text-danger">*</span></label>
                                <input wire:model="faqOrder" type="number"
                                    class="form-control @error('faqOrder') is-invalid @enderror" id="faqOrder"
                                    min="1" max="{{ $maxOrder }}" placeholder="1">
                                @error('faqOrder')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="faqAnswer" class="form-label">Respuesta <span
                                        class="text-danger">*</span></label>
                                <textarea wire:model="faqAnswer" class="form-control @error('faqAnswer') is-invalid @enderror"
                                    id="faqAnswer" rows="4" placeholder="Escribe la respuesta a la pregunta..."></textarea>
                                @error('faqAnswer')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mt-3">
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex flex-wrap align-items-center gap-2">
                                        <button type="button" class="btn btn-primary" id="saveFaqBtn"
                                            data-max="{{ $maxOrder }}"
                                            data-original="{{ $originalOrder ?? $faqOrder }}">
                                            @icon('save', 'icon-xs me-1')
                                            {{ $faqId ? 'Actualizar' : 'Guardar' }} pregunta
                                        </button>
                                        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.faq.questions', $categoryId) }}"
                                            class="btn btn-gray-300">
                                            Cancelar
                                        </a>
                                    </div>
                                    @if ($faqId)
                                        <div>
                                            <button type="button" id="deleteFaqBtn" class="btn btn-danger">
                                                @icon('delete', 'icon-xs me-1')
                                                Eliminar pregunta
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
                                    <h3 class="h6">Pregunta clara</h3>
                                    <p class="text-gray-700 small mb-0">
                                        Redacta la pregunta de forma clara y breve para facilitar su comprensión.
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="d-flex align-items-start">
                                @icon('info', 'fa-xs text-info me-3')
                                <div>
                                    <h3 class="h6">Respuesta completa</h3>
                                    <p class="text-gray-700 small mb-0">
                                        Proporciona una respuesta directa y concisa. Se permite texto multilínea.
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
                                        Las preguntas se mostrarán ordenadas de menor a mayor número.
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

        const isEdit = {{ $faqId ? 'true' : 'false' }};
        const saveBtn = document.getElementById('saveFaqBtn');

        const confirmFlow = (message) => swalWithBootstrapButtons.fire({
            icon: 'warning',
            title: 'Aviso',
            text: message,
            confirmButtonText: 'Entendido',
            showCancelButton: false
        });

        const confirmQuestion = () => swalWithBootstrapButtons.fire({
            title: isEdit ? '¿Actualizar pregunta?' : '¿Guardar pregunta?',
            text: isEdit ? '¿Deseas actualizar los detalles de esta pregunta?' :
                '¿Deseas crear esta pregunta?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: isEdit ? 'Sí, actualizar' : 'Sí, guardar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        });

        saveBtn?.addEventListener('click', function(e) {
            e.preventDefault();
            const orderInput = document.getElementById('faqOrder');
            const desired = parseInt(orderInput.value || '1', 10);
            const max = parseInt(saveBtn.dataset.max || '1', 10);

            const proceed = () => {
                confirmQuestion().then((result) => {
                    if (result.isConfirmed) {
                        @this.call('save');
                    }
                });
            };

            if (desired > max) {
                confirmFlow(
                        `El orden solicitado supera el máximo (${max}). Se ajustará al último número secuencial.`
                    )
                    .then(() => {
                        orderInput.value = max;
                        @this.set('faqOrder', max);
                        proceed();
                    });
                return;
            }

            proceed();
        });

        // Confirmation before delete
        document.getElementById('deleteFaqBtn')?.addEventListener('click', function(e) {
            e.preventDefault();
            swalWithBootstrapButtons.fire({
                icon: 'question',
                title: '¿Eliminar pregunta?',
                text: '¿Estás seguro de eliminar esta pregunta? Esta acción no se puede deshacer.',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true,
                customClass: {
                    confirmButton: 'btn btn-danger me-2',
                    cancelButton: 'btn btn-gray'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('deleteFaq');
                }
            });
        });

        // Listeners for alerts
        if (window.Livewire) {
            Livewire.on('faq-saved', (detail) => {
                const payload = Array.isArray(detail) ? detail[0] : detail || {};
                swalWithBootstrapButtons.fire({
                    icon: payload.type || 'success',
                    title: payload.title || 'Éxito',
                    text: payload.message || '',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    if (payload.redirect) {
                        window.location.href = payload.redirect;
                    }
                });
            });

            Livewire.on('faq-error', (detail) => {
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