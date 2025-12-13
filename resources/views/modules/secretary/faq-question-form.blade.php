{{-- 
* Company: CETAM
* Project: ST
* File: faq-question-form.blade.php
* Created on: 11/12/2025
* Created by: Codex
* Approved by: Alfonso Angel García Hernández
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
                    <li class="breadcrumb-item active" aria-current="page">{{ $faqId ? 'Editar pregunta' : 'Nueva pregunta' }}</li>
                </ol>
            </nav>
            <h2 class="h4">{{ $faqId ? 'Editar pregunta' : 'Nueva pregunta' }}</h2>
            <p class="mb-0">{{ $faqId ? 'Modifica los datos de la pregunta frecuente.' : 'Completa el formulario para agregar una nueva pregunta frecuente.' }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-xl-8">
            <div class="card border-0 shadow mb-4">
                <div class="card-body">
                    <h2 class="h5 mb-4">Información de la pregunta</h2>
                    <form wire:submit.prevent="save">
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="faqQuestion">Pregunta <span class="text-danger">*</span></label>
                                <input wire:model="faqQuestion" type="text" class="form-control @error('faqQuestion') is-invalid @enderror"
                                    id="faqQuestion" placeholder="Ej: ¿Cómo inicio un trámite?">
                                @error('faqQuestion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="faqOrder">Orden de visualización <span class="text-danger">*</span></label>
                                <input wire:model="faqOrder" type="number" class="form-control @error('faqOrder') is-invalid @enderror"
                                    id="faqOrder" placeholder="1" min="1" max="{{ $maxOrder }}">
                                @error('faqOrder')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="faqAnswer">Respuesta <span class="text-danger">*</span></label>
                                <textarea wire:model="faqAnswer" class="form-control @error('faqAnswer') is-invalid @enderror"
                                    id="faqAnswer" rows="6" placeholder="Ingresa una respuesta clara y breve"></textarea>
                                @error('faqAnswer')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mt-3">
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex flex-wrap align-items-center gap-2">
                                        <button type="button" id="saveQuestionBtn" data-max="{{ $maxOrder }}" class="btn btn-primary">
                                            @icon('save', 'icon-xs me-1')
                                            {{ $faqId ? 'Actualizar pregunta' : 'Guardar pregunta' }}
                                        </button>
                                        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.faq.questions', $categoryId) }}"
                                            class="btn btn-gray-300">
                                            Cancelar
                                        </a>
                                    </div>
                                    @if($faqId)
                                        <div>
                                            <button type="button" id="deleteFaqBtn"
                                                class="btn btn-danger">
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
                                        Usa lenguaje directo que el usuario entienda rápidamente.
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="d-flex align-items-start">
                                @icon('info', 'fa-xs text-info me-3')
                                <div>
                                    <h3 class="h6">Respuesta concisa</h3>
                                    <p class="text-gray-700 small mb-0">
                                        Mantén la respuesta breve y enfocada en resolver la duda.
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
                                        El número define la posición; 1 aparece primero en la lista.
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

        // Listener para faq-saved (crear/editar/eliminar)
        if (window.Livewire) {
            Livewire.on('faq-saved', (event) => {
                const detail = Array.isArray(event) ? event[0] : event;
                swalWithBootstrapButtons.fire({
                    icon: detail.type || 'success',
                    title: detail.title || 'Éxito',
                    text: detail.message || '',
                    confirmButtonText: 'Entendido'
                }).then(() => {
                    if (detail.redirect) {
                        window.location.href = detail.redirect;
                    }
                });
            });

            Livewire.on('faq-error', (event) => {
                const detail = Array.isArray(event) ? event[0] : event;
                swalWithBootstrapButtons.fire({
                    icon: detail.type || 'error',
                    title: detail.title || 'Error',
                    text: detail.message || '',
                    confirmButtonText: 'Entendido'
                });
            });
        }

        // Confirmación antes de eliminar
        const deleteFaqBtn = document.getElementById('deleteFaqBtn');
        if (deleteFaqBtn) {
            deleteFaqBtn.addEventListener('click', function () {
                swalWithBootstrapButtons.fire({
                    title: '¿Eliminar pregunta?',
                    text: '¿Estás seguro de eliminar esta pregunta? Esta acción no se puede deshacer.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.call('deleteFaq');
                    }
                });
            });
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const swalMixin = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-primary me-2',
                cancelButton: 'btn btn-gray'
            },
            buttonsStyling: false
        });

        const saveBtn = document.getElementById('saveQuestionBtn');
        const isEdit = {{ $faqId ? 'true' : 'false' }};
        
        if (saveBtn) {
            saveBtn.addEventListener('click', function (e) {
                e.preventDefault();
                const orderInput = document.getElementById('faqOrder');
                const desired = parseInt(orderInput.value || '1', 10);
                const max = parseInt(saveBtn.dataset.max || '1', 10);

                const confirmAndSave = () => {
                    swalMixin.fire({
                        icon: 'question',
                        title: isEdit ? '¿Actualizar pregunta?' : '¿Guardar pregunta?',
                        text: isEdit ? '¿Deseas actualizar los datos de esta pregunta?' : '¿Deseas guardar esta nueva pregunta?',
                        showCancelButton: true,
                        confirmButtonText: isEdit ? 'Sí, actualizar' : 'Sí, guardar',
                        cancelButtonText: 'Cancelar',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            @this.call('save');
                        }
                    });
                };

                if (desired > max) {
                    swalMixin.fire({
                        icon: 'warning',
                        title: 'Aviso',
                        text: `El orden solicitado supera el máximo (${max}). Se ajustará al último número secuencial.`,
                        confirmButtonText: 'Entendido',
                        showCancelButton: false
                    }).then(() => {
                        orderInput.value = max;
                        @this.set('faqOrder', max);
                        confirmAndSave();
                    });
                    return;
                }

                confirmAndSave();
            });
        }
    });
</script>
