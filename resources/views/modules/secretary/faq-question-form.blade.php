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
                            <div class="col-md-12 mb-3">
                                <label for="faqQuestion">Pregunta <span class="text-danger">*</span></label>
                                <input wire:model="faqQuestion" type="text" class="form-control @error('faqQuestion') is-invalid @enderror"
                                    id="faqQuestion" placeholder="Ingrese la pregunta">
                                @error('faqQuestion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="faqAnswer">Respuesta <span class="text-danger">*</span></label>
                                <textarea wire:model="faqAnswer" class="form-control @error('faqAnswer') is-invalid @enderror"
                                    id="faqAnswer" rows="6" placeholder="Ingrese la respuesta"></textarea>
                                @error('faqAnswer')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="faqOrder">Orden de visualización</label>
                                <input wire:model="faqOrder" type="number" class="form-control @error('faqOrder') is-invalid @enderror"
                                    id="faqOrder" placeholder="0" min="0">
                                @error('faqOrder')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Las preguntas se mostrarán ordenadas por este valor (de menor a mayor).</small>
                            </div>

                            <div class="col-md-12 mt-3">
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex flex-wrap align-items-center gap-2">
                                        <button type="submit" class="btn btn-gray-800 mt-2 animate-up-2">
                                            @icon('save', 'icon-xs me-1')
                                            {{ $faqId ? 'Actualizar pregunta' : 'Guardar pregunta' }}
                                        </button>
                                        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.faq.questions', $categoryId) }}"
                                            class="btn btn-secondary text-white mt-2 animate-up-2">
                                            @icon('arrowLeft', 'icon-xs me-1 text-white')
                                            Cancelar
                                        </a>
                                    </div>
                                    @if($faqId)
                                        <div>
                                            <button type="button" id="deleteFaqBtn"
                                                class="btn btn-danger mt-2 animate-up-2">
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
                    <h2 class="h5 mb-4">
                        @icon('info', 'me-1')
                        Información importante
                    </h2>
                    <p class="small">Complete los campos obligatorios marcados con <span class="text-danger">*</span> para poder guardar la pregunta frecuente.</p>
                    <p class="small mb-0"><strong>Orden de visualización:</strong> Las preguntas con menor número aparecerán primero en la lista para los usuarios.</p>
                    @if($faqId)
                        <hr class="my-3">
                        <p class="small mb-0 text-muted">Al actualizar la pregunta, los cambios serán visibles inmediatamente para todos los usuarios.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('faq-saved', (event) => {
            const detail = Array.isArray(event) ? event[0] : event;
            Swal.fire({
                icon: detail.type,
                title: detail.title,
                text: detail.message,
                showConfirmButton: false,
                timer: 2000
            });
        });

        Livewire.on('faq-error', (event) => {
            const detail = Array.isArray(event) ? event[0] : event;
            Swal.fire({
                icon: detail.type,
                title: detail.title,
                text: detail.message,
                showConfirmButton: true
            });
        });

        Livewire.on('faq-deleted', (event) => {
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

    document.addEventListener('DOMContentLoaded', function () {
        const deleteFaqBtn = document.getElementById('deleteFaqBtn');
        if (deleteFaqBtn) {
            deleteFaqBtn.addEventListener('click', function () {
                Swal.fire({
                    title: '¿Eliminar pregunta?',
                    text: "Esta acción no se puede revertir",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.call('deleteFaq');
                    }
                });
            });
        }
    });
</script>
