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
                            Preguntas
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ $faqId ? 'Editar pregunta' : 'Nueva pregunta' }}
                    </li>
                </ol>
            </nav>
            <h2 class="h4">Preguntas frecuentes</h2>
            <p class="mb-0">
                Categoría: <strong>{{ $category->name }}</strong>.
                {{ $faqId ? 'Modifica los datos de la pregunta frecuente.' : 'Completa el formulario para agregar una nueva pregunta frecuente.' }}
            </p>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-xl-8">
            <div class="card border-0 shadow mb-4">
                <div class="card-body">
                    <h2 class="h5 mb-4">Información de la pregunta</h2>

                    <div class="mb-3">
                        <label for="faqQuestion" class="form-label">Pregunta <span class="text-danger">*</span></label>
                        <input wire:model="faqQuestion" type="text"
                            class="form-control @error('faqQuestion') is-invalid @enderror" id="faqQuestion"
                            placeholder="Ingresa la pregunta">
                        @error('faqQuestion')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="faqAnswer" class="form-label">Respuesta <span class="text-danger">*</span></label>
                        <textarea wire:model="faqAnswer" class="form-control @error('faqAnswer') is-invalid @enderror" id="faqAnswer"
                            rows="5" placeholder="Ingresa la respuesta"></textarea>
                        @error('faqAnswer')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="faqOrder" class="form-label">Orden de visualización <span
                                class="text-danger">*</span></label>
                        <input wire:model="faqOrder" type="number" min="1"
                            class="form-control @error('faqOrder') is-invalid @enderror" id="faqOrder"
                            placeholder="Ej. 1">
                        @error('faqOrder')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end">
                        <button wire:click="save" class="btn btn-primary">
                            {{ $faqId ? 'Actualizar pregunta' : 'Guardar pregunta' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-4">
            <div class="card border-0 shadow mb-4">
                <div class="card-body">
                    <h2 class="h6 mb-3">Indicaciones</h2>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0">
                            <p class="mb-1"><strong>Pregunta:</strong> redacta de forma clara y breve.</p>
                        </li>
                        <li class="list-group-item px-0">
                            <p class="mb-1"><strong>Respuesta:</strong> usa texto directo; se permite multilinea.</p>
                        </li>
                        <li class="list-group-item px-0">
                            <p class="mb-0"><strong>Orden:</strong> define la posición en la lista (1 es la primera).
                            </p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
