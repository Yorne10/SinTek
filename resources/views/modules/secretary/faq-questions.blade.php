{{--
Company: CETAM
Project: ST
File: faq-questions.blade.php
Created on: 09/12/2025
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
                    <li class="breadcrumb-item active" aria-current="page">Preguntas</li>
                </ol>
            </nav>
            <h2 class="h4">Preguntas frecuentes</h2>
            <p class="mb-0">Categoría: <strong>{{ $category->name }}</strong>.
                {{ $category->description ?? 'Gestiona las preguntas frecuentes de esta categoría.' }}
            </p>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.faq.categories') }}"
                class="btn btn-sm btn-gray-200 d-inline-flex align-items-center me-2">
                @icon('back', 'me-2')
                Volver
            </a>
            <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.faq.question.create', $categoryId) }}"
                class="btn btn-sm btn-gray-800 d-inline-flex align-items-center">
                @icon('add', 'me-2')
                Nueva pregunta
            </a>
        </div>
    </div>

    <div class="table-settings mb-4">
        <div class="d-flex flex-wrap gap-3 align-items-center">
            <div class="input-group fmxw-300">
                <span class="input-group-text">@icon('search', 'icon icon-xs')</span>
                <input wire:model.live.debounce.400ms="search" type="text" class="form-control"
                    placeholder="Buscar preguntas">
            </div>
            <div class="ms-auto">
                <button wire:click="clearFilters"
                    class="btn btn-sm btn-secondary text-white d-inline-flex align-items-center">
                    @icon('refresh', 'me-2 text-white')
                    Limpiar filtros
                </button>
            </div>
        </div>
    </div>

    <div class="card card-body shadow border-0 table-wrapper table-responsive">
        <table class="table table-centered table-nowrap mb-0 rounded" style="table-layout: fixed;">
            <colgroup>
                <col style="width: 42%">
                <col style="width: 34%">
                <col style="width: 12%">
                <col style="width: 12%">
            </colgroup>
            <thead class="thead-light">
                <tr>
                    <th class="border-0 rounded-start">Pregunta</th>
                    <th class="border-0">Respuesta</th>
                    <th class="border-0">Orden</th>
                    <th class="border-0 rounded-end text-start">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($faqs as $faq)
                    <tr>
                        <td>
                            <span class="fw-bold text-gray-900">{{ $faq->question }}</span>
                        </td>
                        <td>
                            <span
                                class="fw-normal text-truncate d-inline-block w-100">{{ Str::limit($faq->answer, 100) }}</span>
                        </td>
                        <td><span class="fw-bold text-gray-900">{{ $faq->order }}</span></td>
                        <td class="text-start" style="width: 12%; min-width: 72px;">
                            <div class="btn-group position-static">
                                <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    @icon('menu', 'icon icon-xs')
                                </button>
                                <div class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1">
                                    <button class="dropdown-item d-flex align-items-center view-faq-detail"
                                        type="button" data-faq-question="{{ $faq->question }}"
                                        data-faq-answer="{{ $faq->answer }}" data-faq-order="{{ $faq->order }}">
                                        @icon('view', 'dropdown-icon text-gray-400 me-2')
                                        Ver detalles
                                    </button>
                                    <a class="dropdown-item d-flex align-items-center"
                                        href="{{ route(config('proj.route_name_prefix', 'proj') . '.faq.question.edit', [$categoryId, $faq->faq_id]) }}">
                                        @icon('edit', 'dropdown-icon text-gray-400 me-2')
                                        Editar
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center align-middle py-4">
                            <div class="text-gray-500 d-flex flex-column align-items-center justify-content-center">
                                @icon('help', 'fa-2x mb-3 text-gray-400')
                                <p class="fw-bold mb-1">No hay preguntas para mostrar</p>
                                <p class="small mb-0">Agrega tu primera pregunta frecuente</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div
            class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
            @if ($faqs->hasPages())
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
                confirmButtonText: 'Aceptar'
            });
        });
    });

    document.addEventListener('click', function(e) {
        if (e.target.closest('.view-faq-detail')) {
            e.preventDefault();
            const button = e.target.closest('.view-faq-detail');
            const faqQuestion = button.getAttribute('data-faq-question');
            const faqAnswer = button.getAttribute('data-faq-answer');
            const faqOrder = button.getAttribute('data-faq-order');

            const htmlContent = `
                <div class="text-start">
                    <p class="mb-2"><span class="fw-bold">Pregunta:</span> ${faqQuestion}</p>
                    <p class="mb-2"><span class="fw-bold">Respuesta:</span></p>
                    <div class="p-3 bg-light rounded mb-2">${faqAnswer}</div>
                    <p class="mb-0"><span class="fw-bold">Orden:</span> ${faqOrder}</p>
                </div>
            `;

            Swal.fire({
                title: 'Detalles de la pregunta',
                html: htmlContent,
                icon: 'info',
                confirmButtonText: 'Aceptar',
                showConfirmButton: true,
                width: '600px'
            });
        }
    });
</script>
