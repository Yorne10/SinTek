{{--
* Company: CETAM
* Project: ST
* File: documents-index.blade.php
* Created on: 04/12/2025
* Created by: Claude Code
* Approved by: Alfonso Angel Garcia Hernandez
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
                    <li class="breadcrumb-item active" aria-current="page">Documentos</li>
                </ol>
            </nav>
            <h2 class="h4">Documentos y reglamentos</h2>
            <p class="mb-0">Consulta y descarga reglamentos, manuales y formatos institucionales</p>
        </div>
    </div>

    {{-- Public Documents Section --}}
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card border-0 shadow">
                <div class="card-header border-bottom">
                    <h2 class="fs-5 fw-bold mb-0">Documentos institucionales</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        {{-- Column 1: Reglamentos (desde BD) --}}
                        <div class="col-md-6 mb-4">
                            <h3 class="h6 fw-bold mb-3">
                                <span class="me-2">@icon('file', 'icon icon-xs')</span>
                                Reglamentos
                            </h3>
                            @if($reglamentos->count() > 0)
                                <div class="list-group list-group-flush">
                                    @foreach($reglamentos as $doc)
                                        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.institutional-document.download', $doc->institutional_document_id) }}"
                                            class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                            <div>
                                                <div class="fw-bold">{{ $doc->title }}</div>
                                                <small class="text-gray-600">
                                                    {{ $doc->effective_date ? 'Vigencia: ' . \Illuminate\Support\Carbon::parse($doc->effective_date)->format('m/Y') : 'Actualizado: ' . $doc->created_at->format('m/Y') }}
                                                </small>
                                            </div>
                                            @icon('download', 'icon icon-xs text-gray-500')
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-gray-500 small">No hay reglamentos disponibles.</div>
                            @endif
                        </div>

                        {{-- Column 2: Manuales y Formatos (desde BD) --}}
                        <div class="col-md-6 mb-4">
                            <h3 class="h6 fw-bold mb-3">
                                <span class="me-2">@icon('file', 'icon icon-xs')</span>
                                Manuales y Formatos
                            </h3>
                            @if($manuales->count() > 0)
                                <div class="list-group list-group-flush">
                                    @foreach($manuales as $doc)
                                        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.institutional-document.download', $doc->institutional_document_id) }}"
                                            class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                            <div>
                                                <div class="fw-bold">{{ $doc->title }}</div>
                                                <small class="text-gray-600">
                                                    {{ $doc->version ? 'Version ' . $doc->version : '' }}{{ $doc->effective_date ? ' - ' . \Illuminate\Support\Carbon::parse($doc->effective_date)->format('m/Y') : '' }}
                                                </small>
                                            </div>
                                            @icon('download', 'icon icon-xs text-gray-500')
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-gray-500 small">No hay manuales ni formatos disponibles.</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
