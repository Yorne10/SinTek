{{--
 * Company: CETAM
 * Project: ST
 * File: preguntas-frecuentes.blade.php
 * Created on: 04/11/2025
 * Created by: Alfonso Angel Garca Hernndez
 * Approved by: Alfonso Angel Garca Hernndez
 *
 * Changelog:
 * - ID: <ID> | Modified on: 24/11/2025 |
 * Modified by: Codex |
 * Description: Updated to use database FAQs with categories |
--}}

<div>
    {{-- Breadcrumb --}}
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item">
                        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.dashboard.index') }}">
                            @icon('home', 'fa-xs')
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Preguntas frecuentes</li>
                </ol>
            </nav>
            <h2 class="h4">Preguntas frecuentes (FAQ)</h2>
            <p class="mb-0">Encuentra respuestas a las preguntas m&aacute;s comunes sobre el sistema y tr&aacute;mites</p>
        </div>
    </div>

    {{-- Search and Filter --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8 mb-3 mb-md-0">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                                    </svg>
                                </span>
                                <input type="text" wire:model.live.debounce.300ms="search" class="form-control" placeholder="Buscar en preguntas frecuentes...">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <select wire:model.live="selectedCategoryId" class="form-select">
                                <option value="">Todas las categor&iacute;as</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->faq_category_id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- FAQs by Category --}}
    @forelse($categories as $category)
        @php
            $categoryFaqs = $faqs->get($category->faq_category_id, collect());
        @endphp

        @if($categoryFaqs->isNotEmpty() || (!$search && !$selectedCategoryId))
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow">
                        <div class="card-header border-bottom">
                            <div class="d-flex align-items-center">
                                <div class="icon-shape icon-sm icon-shape-primary rounded me-3">
                                    <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="fs-5 fw-bold mb-0">{{ $category->name }}</h2>
                                    @if($category->description)
                                        <p class="text-muted small mb-0">{{ $category->description }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            @if($categoryFaqs->isNotEmpty())
                                <div class="accordion" id="faqCategory{{ $category->faq_category_id }}">
                                    @foreach($categoryFaqs as $faq)
                                        <div class="accordion-item">
                                            <h3 class="accordion-header" id="heading{{ $faq->faq_id }}">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $faq->faq_id }}" aria-expanded="false" aria-controls="collapse{{ $faq->faq_id }}">
                                                    {{ $faq->question }}
                                                </button>
                                            </h3>
                                            <div id="collapse{{ $faq->faq_id }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $faq->faq_id }}" data-bs-parent="#faqCategory{{ $category->faq_category_id }}">
                                                <div class="accordion-body">
                                                    {!! nl2br(e($faq->answer)) !!}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted text-center mb-0">No hay preguntas frecuentes en esta categor&iacute;a.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @empty
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow">
                    <div class="card-body text-center py-5">
                        <svg class="icon icon-lg text-gray-400 mb-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                        </svg>
                        <h3 class="h5">No hay preguntas frecuentes disponibles</h3>
                        <p class="text-muted">Pronto se agregar&aacute;n preguntas frecuentes para ayudarte.</p>
                    </div>
                </div>
            </div>
        </div>
    @endforelse

    {{-- No results message --}}
    @if($search && $faqs->isEmpty())
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow">
                    <div class="card-body text-center py-5">
                        <svg class="icon icon-lg text-gray-400 mb-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                        </svg>
                        <h3 class="h5">No se encontraron resultados</h3>
                        <p class="text-muted">No se encontraron preguntas frecuentes que coincidan con "{{ $search }}".</p>
                        <button type="button" class="btn btn-primary btn-sm" wire:click="$set('search', '')">Limpiar b&uacute;squeda</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
