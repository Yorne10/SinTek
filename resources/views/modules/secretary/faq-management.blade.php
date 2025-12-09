{{--
* Company: CETAM
* Project: ST
* File: faq-management.blade.php
* Created on: 24/11/2025
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
                            @icon('nav.home', 'fa-xs')
                        </a>
                    </li>
                    <li class="breadcrumb-item">Secretaría</li>
                    <li class="breadcrumb-item active" aria-current="page">Preguntas frecuentes</li>
                </ol>
            </nav>
            <h2 class="h4">Preguntas frecuentes</h2>
            <p class="mb-0">Gestiona las preguntas frecuentes y sus categorías.</p>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow">
                <div class="card-header border-bottom d-flex align-items-center justify-content-between">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class="nav-link {{ $activeTab == 'categories' ? 'active' : '' }}" href="#" wire:click="$set('activeTab', 'categories')">Categorías</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $activeTab == 'faqs' ? 'active' : '' }}" href="#" wire:click="$set('activeTab', 'faqs')">Preguntas</a>
                        </li>
                    </ul>
                    <div>
                        @if($activeTab == 'categories')
                            <button wire:click="toggleCategoryForm" class="btn btn-sm btn-gray-800 d-inline-flex align-items-center">
                                @icon('action.create', 'me-1')
                                Nueva categoría
                            </button>
                        @else
                            <button wire:click="toggleFaqForm" class="btn btn-sm btn-gray-800 d-inline-flex align-items-center">
                                @icon('action.create', 'me-1')
                                Nueva pregunta
                            </button>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    
                    {{-- Categories Tab --}}
                    @if($activeTab == 'categories')
                        @if($showCategoryForm)
                            <div class="mb-4 p-4 border rounded bg-light">
                                <h5 class="mb-3">{{ $editingCategoryId ? 'Editar' : 'Nueva' }} categoría</h5>
                                <form wire:submit.prevent="saveCategory">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Nombre *</label>
                                            <input type="text" class="form-control @error('categoryName') is-invalid @enderror" wire:model="categoryName">
                                            @error('categoryName') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Orden</label>
                                            <input type="number" class="form-control @error('categoryOrder') is-invalid @enderror" wire:model="categoryOrder">
                                            @error('categoryOrder') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Descripción</label>
                                            <textarea class="form-control @error('categoryDescription') is-invalid @enderror" wire:model="categoryDescription" rows="2"></textarea>
                                            @error('categoryDescription') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                        <button type="button" class="btn btn-gray-200" wire:click="toggleCategoryForm">Cancelar</button>
                                    </div>
                                </form>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap mb-0 rounded">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="border-0 rounded-start">Nombre</th>
                                        <th class="border-0">Descripción</th>
                                        <th class="border-0">Orden</th>
                                        <th class="border-0">Preguntas</th>
                                        <th class="border-0">Estado</th>
                                        <th class="border-0 rounded-end">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($categories as $category)
                                        <tr>
                                            <td class="fw-bold">{{ $category->name }}</td>
                                            <td>{{ Str::limit($category->description, 50) }}</td>
                                            <td>{{ $category->order }}</td>
                                            <td><span class="badge bg-info">{{ $category->faqs_count }}</span></td>
                                            <td>
                                                <button wire:click="toggleCategoryStatus({{ $category->faq_category_id }})" 
                                                    class="btn btn-xs {{ $category->is_active ? 'btn-success' : 'btn-danger' }}">
                                                    {{ $category->is_active ? 'Activa' : 'Inactiva' }}
                                                </button>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button wire:click="editCategory({{ $category->faq_category_id }})" class="btn btn-sm btn-link text-dark">
                                                        @icon('action.edit', 'icon-xs')
                                                    </button>
                                                    <button onclick="confirmDeleteCategory({{ $category->faq_category_id }})" class="btn btn-sm btn-link text-danger">
                                                        @icon('action.delete', 'icon-xs')
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4">
                                                <div class="text-gray-500">
                                                    @icon('support.help', 'fa-2x mb-2')
                                                    <p class="fw-bold mb-1">No hay categorías para mostrar</p>
                                                    <p class="small mb-0">Crea una nueva categoría para empezar</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="mt-3">
                                {{ $categories->links() }}
                            </div>
                        </div>

                    {{-- FAQs Tab --}}
                    @elseif($activeTab == 'faqs')
                        @if($showFaqForm)
                             <div class="mb-4 p-4 border rounded bg-light">
                                <h5 class="mb-3">{{ $editingFaqId ? 'Editar' : 'Nueva' }} pregunta</h5>
                                <form wire:submit.prevent="saveFaq">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Categoría *</label>
                                            <select class="form-select @error('selectedCategoryId') is-invalid @enderror" wire:model="selectedCategoryId">
                                                <option value="">Selecciona una categoría</option>
                                                @foreach($allCategories as $cat)
                                                    <option value="{{ $cat->faq_category_id }}">{{ $cat->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('selectedCategoryId') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                         <div class="col-md-3 mb-3">
                                            <label class="form-label">Orden</label>
                                            <input type="number" class="form-control @error('faqOrder') is-invalid @enderror" wire:model="faqOrder">
                                            @error('faqOrder') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Pregunta *</label>
                                            <input type="text" class="form-control @error('faqQuestion') is-invalid @enderror" wire:model="faqQuestion">
                                            @error('faqQuestion') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                         <div class="col-md-12 mb-3">
                                            <label class="form-label">Respuesta *</label>
                                            <textarea class="form-control @error('faqAnswer') is-invalid @enderror" wire:model="faqAnswer" rows="4"></textarea>
                                            @error('faqAnswer') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                        <button type="button" class="btn btn-gray-200" wire:click="toggleFaqForm">Cancelar</button>
                                    </div>
                                </form>
                            </div>
                        @endif

                         <div class="table-responsive">
                            <table class="table table-centered table-nowrap mb-0 rounded">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="border-0 rounded-start">Pregunta</th>
                                        <th class="border-0">Categoría</th>
                                        <th class="border-0">Orden</th>
                                        <th class="border-0">Estado</th>
                                        <th class="border-0 rounded-end">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($faqs as $faq)
                                        <tr>
                                            <td class="text-wrap" style="max-width: 300px;">
                                                <span class="fw-bold">{{ $faq->question }}</span>
                                            </td>
                                            <td>{{ $faq->category->name ?? 'N/D' }}</td>
                                            <td>{{ $faq->order }}</td>
                                            <td>
                                                <button wire:click="toggleFaqStatus({{ $faq->faq_id }})" 
                                                    class="btn btn-xs {{ $faq->is_active ? 'btn-success' : 'btn-danger' }}">
                                                    {{ $faq->is_active ? 'Activa' : 'Inactiva' }}
                                                </button>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button wire:click="editFaq({{ $faq->faq_id }})" class="btn btn-sm btn-link text-dark">
                                                        @icon('action.edit', 'icon-xs')
                                                    </button>
                                                    <button onclick="confirmDeleteFaq({{ $faq->faq_id }})" class="btn btn-sm btn-link text-danger">
                                                        @icon('action.delete', 'icon-xs')
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4">
                                                <div class="text-gray-500">
                                                    @icon('support.help', 'fa-2x mb-2')
                                                    <p class="fw-bold mb-1">No hay preguntas para mostrar</p>
                                                    <p class="small mb-0">Agrega tu primera pregunta frecuente</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                             <div class="mt-3">
                                {{ $faqs->links() }}
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('faq-notify', (event) => {
            // Check if event is array or object and extract detail
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

    function confirmDeleteCategory(id) {
        Swal.fire({
            title: 'Delete Category?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                @this.call('deleteCategory', id);
            }
        })
    }

     function confirmDeleteFaq(id) {
        Swal.fire({
            title: 'Delete FAQ?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                @this.call('deleteFaq', id);
            }
        })
    }
</script>
