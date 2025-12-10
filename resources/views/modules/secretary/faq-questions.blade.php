{{--
* Company: CETAM
* Project: ST
* File: faq-questions.blade.php
* Created on: 09/12/2025
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
                    <li class="breadcrumb-item">
                        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.faq.categories') }}">
                            Categorías de FAQ
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
                </ol>
            </nav>
            <h2 class="h4">Preguntas: {{ $category->name }}</h2>
            <p class="mb-0">{{ $category->description ?? 'Gestiona las preguntas frecuentes de esta categoría.' }}</p>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.faq.categories') }}" class="btn btn-sm btn-gray-200 d-inline-flex align-items-center me-2">
                @icon('arrowLeft', 'me-2')
                Volver
            </a>
            <button wire:click="toggleFaqForm" class="btn btn-sm btn-gray-800 d-inline-flex align-items-center">
                @icon('add', 'me-2')
                Nueva pregunta
            </button>
        </div>
    </div>

    @if($showFaqForm)
        <div class="card border-0 shadow mb-4">
            <div class="card-body">
                <h5 class="mb-3">{{ $editingFaqId ? 'Editar' : 'Nueva' }} pregunta</h5>
                <form wire:submit.prevent="saveFaq">
                    <div class="row">
                        <div class="col-md-9 mb-3">
                            <label class="form-label">Pregunta *</label>
                            <input type="text" class="form-control @error('faqQuestion') is-invalid @enderror" wire:model="faqQuestion">
                            @error('faqQuestion') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Orden</label>
                            <input type="number" class="form-control @error('faqOrder') is-invalid @enderror" wire:model="faqOrder">
                            @error('faqOrder') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Respuesta *</label>
                            <textarea class="form-control @error('faqAnswer') is-invalid @enderror" wire:model="faqAnswer" rows="5"></textarea>
                            @error('faqAnswer') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <button type="button" class="btn btn-gray-200" wire:click="toggleFaqForm">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <div class="table-settings mb-4">
        <div class="d-flex flex-wrap gap-3 align-items-center">
            <div class="input-group fmxw-300">
                <span class="input-group-text">@icon('search', 'icon icon-xs')</span>
                <input wire:model.live.debounce.400ms="search" type="text"
                    class="form-control" placeholder="Buscar preguntas">
            </div>
            <div class="d-flex align-items-center text-nowrap">
                <span class="small text-gray-600 me-2">Filtrar por estado:</span>
                <select wire:model.live="statusFilter" class="form-select"
                    style="min-width: 140px;"
                    aria-label="Filtrar por estado">
                    <option value="">Todos</option>
                    <option value="active">Activo</option>
                    <option value="inactive">Inactivo</option>
                </select>
            </div>
            <div class="ms-auto">
                <button wire:click="clearFilters" class="btn btn-sm btn-secondary text-white d-inline-flex align-items-center">
                    @icon('refresh', 'me-2 text-white')
                    Limpiar filtros
                </button>
            </div>
        </div>
    </div>

    <div class="card card-body shadow border-0 table-wrapper table-responsive">
        <table class="table table-centered table-nowrap mb-0 rounded" style="table-layout: fixed;">
            <colgroup>
                <col style="width: 40%">
                <col style="width: 40%">
                <col style="width: 8%">
                <col style="width: 12%">
            </colgroup>
            <thead class="thead-light">
                <tr>
                    <th class="border-0 rounded-start">Pregunta</th>
                    <th class="border-0">Respuesta</th>
                    <th class="border-0">Estado</th>
                    <th class="border-0 rounded-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($faqs as $faq)
                    <tr>
                        <td>
                            <span class="fw-bold text-gray-900">{{ $faq->question }}</span>
                        </td>
                        <td>
                            <span class="fw-normal text-truncate d-inline-block w-100">{{ Str::limit($faq->answer, 100) }}</span>
                        </td>
                        <td>
                            @if($faq->is_active)
                                <span class="fw-bold text-success">Activa</span>
                            @else
                                <span class="fw-bold text-warning">Inactiva</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group">
                                <button
                                    class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                                    data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    @icon('menu', 'icon icon-xs')
                                </button>
                                <div class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1">
                                    <button class="dropdown-item d-flex align-items-center view-faq-detail"
                                        type="button"
                                        data-faq-question="{{ $faq->question }}"
                                        data-faq-answer="{{ $faq->answer }}"
                                        data-faq-order="{{ $faq->order }}"
                                        data-faq-active="{{ $faq->is_active ? '1' : '0' }}">
                                        @icon('view', 'dropdown-icon text-gray-400 me-2')
                                        Ver detalles
                                    </button>
                                    <button class="dropdown-item d-flex align-items-center"
                                        type="button"
                                        wire:click="editFaq({{ $faq->faq_id }})">
                                        @icon('edit', 'dropdown-icon text-gray-400 me-2')
                                        Editar
                                    </button>
                                    <div role="separator" class="dropdown-divider my-1"></div>
                                    <button
                                        class="dropdown-item {{ $faq->is_active ? 'text-warning' : 'text-success' }} d-flex align-items-center"
                                        type="button"
                                        wire:click="toggleFaqStatus({{ $faq->faq_id }})">
                                        @icon($faq->is_active ? 'warning' : 'success', "dropdown-icon {{ $faq->is_active ? 'text-warning' : 'text-success' }} me-2")
                                        {{ $faq->is_active ? 'Desactivar' : 'Activar' }}
                                    </button>
                                    <button
                                        class="dropdown-item text-danger d-flex align-items-center"
                                        type="button"
                                        onclick="confirmDeleteFaq({{ $faq->faq_id }})">
                                        @icon('delete', 'dropdown-icon text-danger me-2')
                                        Eliminar
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4">
                            <div class="text-gray-500">
                                <div class="mb-3">
                                    @icon('help', 'fa-2x')
                                </div>
                                <p class="fw-bold">No hay preguntas para mostrar</p>
                                <p class="small">Agrega tu primera pregunta frecuente</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
            @if($faqs->hasPages())
                <nav aria-label="Page navigation" class="mb-3 mb-lg-0">
                    {{ $faqs->onEachSide(1)->links('components.pagination-users') }}
                </nav>
            @endif
            <div class="fw-normal small mt-0 mt-lg-0 ms-lg-auto">
                Mostrando <b>{{ $faqs->firstItem() ?? 0 }}</b> a
                <b>{{ $faqs->lastItem() ?? 0 }}</b> de <b>{{ $faqs->total() }}</b> preguntas
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('faq-notify', (event) => {
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

    document.addEventListener('click', function (e) {
        if (e.target.closest('.view-faq-detail')) {
            e.preventDefault();
            const button = e.target.closest('.view-faq-detail');
            const faqQuestion = button.getAttribute('data-faq-question');
            const faqAnswer = button.getAttribute('data-faq-answer');
            const faqOrder = button.getAttribute('data-faq-order');
            const faqActive = button.getAttribute('data-faq-active') === '1';

            const htmlContent = `
                <div class="text-start">
                    <p class="mb-2"><span class="fw-bold">Pregunta:</span> ${faqQuestion}</p>
                    <p class="mb-2"><span class="fw-bold">Respuesta:</span></p>
                    <div class="p-3 bg-light rounded mb-2">${faqAnswer}</div>
                    <p class="mb-2"><span class="fw-bold">Orden:</span> ${faqOrder}</p>
                    <p class="mb-0"><span class="fw-bold">Estado:</span> <span class="fw-bold text-${faqActive ? 'success' : 'warning'}">${faqActive ? 'Activa' : 'Inactiva'}</span></p>
                </div>
            `;

            Swal.fire({
                title: 'Detalles de la pregunta',
                html: htmlContent,
                icon: 'info',
                confirmButtonText: 'Cerrar',
                showConfirmButton: true,
                width: '600px'
            });
        }
    });

    function confirmDeleteFaq(id) {
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
                @this.call('deleteFaq', id);
            }
        })
    }
</script>
