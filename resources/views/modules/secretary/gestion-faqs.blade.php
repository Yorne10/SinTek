{{--
* Company: CETAM
* Project: ST
* File: gestion-faqs.blade.php
* Created on: 24/11/2025
* Created by: Codex
* Approved by: Alfonso Angel Garca Hernndez
--}}
<div>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item">
                        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.dashboard.index') }}">
                            @icon('nav.home', 'fa-xs')
                        </a>
                    </li>
                    <li class="breadcrumb-item">Secretara</li>
                    <li class="breadcrumb-item active" aria-current="page">Gestión de FAQs</li>
                </ol>
            </nav>
            <h2 class="h4">Gestión de Preguntas Frecuentes</h2>
            <p class="mb-0">Administra las categoras y preguntas frecuentes que vern los trabajadores.</p>
        </div>
    </div>

    <!-- Tabs -->
    <ul class="nav nav-tabs mb-4" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="categories-tab" data-bs-toggle="tab" data-bs-target="#categories"
                type="button" role="tab">
                <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"></path>
                </svg>
                Categoras
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="faqs-tab" data-bs-toggle="tab" data-bs-target="#faqs" type="button" role="tab">
                <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                        clip-rule="evenodd"></path>
                </svg>
                Preguntas Frecuentes
            </button>
        </li>
    </ul>

    <div class="tab-content">
        <!-- Categories Tab -->
        <div class="tab-pane fade show active" id="categories" role="tabpanel">
            <div class="card border-0 shadow mb-4">
                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                    <h2 class="fs-5 fw-bold mb-0">Categoras de FAQs</h2>
                    <button type="button" class="btn btn-sm btn-primary" wire:click="toggleCategoryForm">
                        <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        {{ $showCategoryForm ? 'Cancelar' : 'Nueva Categora' }}
                    </button>
                </div>

                @if($showCategoryForm)
                    <div class="card-body border-bottom bg-light">
                        <form wire:submit.prevent="saveCategory">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Nombre de la categora</label>
                                    <input type="text" wire:model="categoryName"
                                        class="form-control @error('categoryName') is-invalid @enderror"
                                        placeholder="Ej. Trámites generales">
                                    @error('categoryName') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Orden</label>
                                    <input type="number" wire:model="categoryOrder"
                                        class="form-control @error('categoryOrder') is-invalid @enderror" min="0">
                                    @error('categoryOrder') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label fw-semibold">Descripcin (opcional)</label>
                                    <textarea wire:model="categoryDescription" rows="2"
                                        class="form-control @error('categoryDescription') is-invalid @enderror"
                                        placeholder="Descripcin breve de la categora"></textarea>
                                    @error('categoryDescription') <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">
                                        {{ $editingCategoryId ? 'Actualizar' : 'Guardar' }} Categora
                                    </button>
                                    <button type="button" class="btn btn-gray ms-2"
                                        wire:click="toggleCategoryForm">Cancelar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th class="border-0">Orden</th>
                                    <th class="border-0">Nombre</th>
                                    <th class="border-0">Descripcin</th>
                                    <th class="border-0">FAQs</th>
                                    <th class="border-0">Estado</th>
                                    <th class="border-0">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($categories as $category)
                                    <tr wire:key="category-{{ $category->faq_category_id }}">
                                        <td class="text-center fw-bold">{{ $category->order }}</td>
                                        <td class="fw-semibold">{{ $category->name }}</td>
                                        <td class="text-muted small">{{ $category->description ?? 'Sin descripcin' }}</td>
                                        <td class="text-center">
                                            <span class="fw-bold text-primary">{{ $category->faqs_count }}</span>
                                        </td>
                                        <td>
                                            @if($category->is_active)
                                                <span class="fw-bold text-success">Activa</span>
                                            @else
                                                <span class="fw-bold text-warning">Inactiva</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-info me-1"
                                                wire:click="editCategory({{ $category->faq_category_id }})" title="Editar">
                                                <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                    </path>
                                                </svg>
                                            </button>
                                            <button type="button"
                                                class="btn btn-sm {{ $category->is_active ? 'btn-warning' : 'btn-success' }} me-1"
                                                wire:click="toggleCategoryStatus({{ $category->faq_category_id }})"
                                                title="{{ $category->is_active ? 'Desactivar' : 'Activar' }}">
                                                @if($category->is_active)
                                                    <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd"
                                                            d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                @else
                                                    <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd"
                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                @endif
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger delete-category-btn"
                                                data-category-id="{{ $category->faq_category_id }}" title="Eliminar">
                                                <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd"
                                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">
                                            No hay categoras registradas. Crea una para comenzar.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if($categories->hasPages())
                    <div class="card-footer border-0">
                        {{ $categories->links() }}
                    </div>
                @endif
            </div>
        </div>

        <!-- FAQs Tab -->
        <div class="tab-pane fade" id="faqs" role="tabpanel">
            <div class="card border-0 shadow mb-4">
                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                    <h2 class="fs-5 fw-bold mb-0">Preguntas Frecuentes</h2>
                    <button type="button" class="btn btn-sm btn-primary" wire:click="toggleFaqForm">
                        <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        {{ $showFaqForm ? 'Cancelar' : 'Nueva FAQ' }}
                    </button>
                </div>

                @if($showFaqForm)
                    <div class="card-body border-bottom bg-light">
                        <form wire:submit.prevent="saveFaq">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Categora</label>
                                    <select wire:model="selectedCategoryId"
                                        class="form-select @error('selectedCategoryId') is-invalid @enderror">
                                        <option value="">Seleccionar categora</option>
                                        @foreach($allCategories as $cat)
                                            <option value="{{ $cat->faq_category_id }}">{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('selectedCategoryId') <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Orden</label>
                                    <input type="number" wire:model="faqOrder"
                                        class="form-control @error('faqOrder') is-invalid @enderror" min="0">
                                    @error('faqOrder') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label fw-semibold">Pregunta</label>
                                    <input type="text" wire:model="faqQuestion"
                                        class="form-control @error('faqQuestion') is-invalid @enderror"
                                        placeholder="Cmo puedo...?">
                                    @error('faqQuestion') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label fw-semibold">Respuesta</label>
                                    <textarea wire:model="faqAnswer" rows="4"
                                        class="form-control @error('faqAnswer') is-invalid @enderror"
                                        placeholder="Aqu va la respuesta detallada..."></textarea>
                                    @error('faqAnswer') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">
                                        {{ $editingFaqId ? 'Actualizar' : 'Guardar' }} FAQ
                                    </button>
                                    <button type="button" class="btn btn-gray ms-2"
                                        wire:click="toggleFaqForm">Cancelar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th class="border-0">Orden</th>
                                    <th class="border-0">Categora</th>
                                    <th class="border-0">Pregunta</th>
                                    <th class="border-0">Respuesta</th>
                                    <th class="border-0">Estado</th>
                                    <th class="border-0">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($faqs as $faq)
                                    <tr wire:key="faq-{{ $faq->faq_id }}">
                                        <td class="text-center fw-bold">{{ $faq->order }}</td>
                                        <td>
                                            <span
                                                class="fw-bold text-info">{{ $faq->category->name ?? 'Sin categora' }}</span>
                                        </td>
                                        <td class="fw-semibold">{{ $faq->question }}</td>
                                        <td class="text-muted small text-truncate" style="max-width: 300px;">
                                            {{ $faq->answer }}</td>
                                        <td>
                                            @if($faq->is_active)
                                                <span class="fw-bold text-success">Activa</span>
                                            @else
                                                <span class="fw-bold text-warning">Inactiva</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-info me-1"
                                                wire:click="editFaq({{ $faq->faq_id }})" title="Editar">
                                                <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                    </path>
                                                </svg>
                                            </button>
                                            <button type="button"
                                                class="btn btn-sm {{ $faq->is_active ? 'btn-warning' : 'btn-success' }} me-1"
                                                wire:click="toggleFaqStatus({{ $faq->faq_id }})"
                                                title="{{ $faq->is_active ? 'Desactivar' : 'Activar' }}">
                                                @if($faq->is_active)
                                                    <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd"
                                                            d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                @else
                                                    <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd"
                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                @endif
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger delete-faq-btn"
                                                data-faq-id="{{ $faq->faq_id }}" title="Eliminar">
                                                <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd"
                                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">
                                            No hay preguntas frecuentes registradas. Crea una para comenzar.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if($faqs->hasPages())
                    <div class="card-footer border-0">
                        {{ $faqs->links() }}
                    </div>
                @endif
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

        // Delete category confirmation
        document.addEventListener('click', function (e) {
            if (e.target.closest('.delete-category-btn')) {
                const button = e.target.closest('.delete-category-btn');
                const categoryId = button.getAttribute('data-category-id');

                swalWithBootstrapButtons.fire({
                    title: 'Eliminar categora?',
                    text: 'Esta accin no se puede deshacer.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'S, eliminar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.call('deleteCategory', categoryId);
                    }
                });
            }
        });

        // Delete FAQ confirmation
        document.addEventListener('click', function (e) {
            if (e.target.closest('.delete-faq-btn')) {
                const button = e.target.closest('.delete-faq-btn');
                const faqId = button.getAttribute('data-faq-id');

                swalWithBootstrapButtons.fire({
                    title: 'Eliminar FAQ?',
                    text: 'Esta accin no se puede deshacer.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'S, eliminar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.call('deleteFaq', faqId);
                    }
                });
            }
        });

        // Listen for notifications
        if (window.Livewire) {
            Livewire.on('faq-notify', (event) => {
                const detail = event || {};
                swalWithBootstrapButtons.fire({
                    icon: detail.type || 'info',
                    title: detail.title || 'Aviso',
                    text: detail.message || '',
                    confirmButtonText: 'Aceptar'
                });
            });
        }
    });
</script>