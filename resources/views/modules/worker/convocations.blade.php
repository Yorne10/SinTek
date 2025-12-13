{{-- 
Company: CETAM
Project: ST
File: convocations.blade.php
Created on: 04/11/2025
Created by: Alfonso Angel Garcia Hernandez
Approved by: Alfonso Angel Garcia Hernandez

Changelog:
- ID: <ID> | Date: dd/mm/yyyy
    Modified by: <Developer name>
    Description: <Brief description of change>
--}}

<div class="container-fluid px-0">
    {{-- Breadcrumb --}}
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent mb-2">
                    <li class="breadcrumb-item">
                        <a href="#">
                            @icon('home', 'fa-xs')
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Convocatorias</li>
                </ol>
            </nav>
            <h2 class="h4 mb-1">Convocatorias</h2>
            <p class="mb-0">Accede a las convocatorias vigentes y proximas.</p>
        </div>
    </div>

    {{-- Convocations list --}}
    <div class="row mb-4">
        <div class="col-12">
            @forelse($convocations as $convocation)
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
                            <div class="me-auto">
                                <h5 class="mb-1 fw-semibold text-dark">{{ $convocation->title }}</h5>
                                <p class="mb-2 text-gray-700">{{ $convocation->description }}</p>
                                <div class="d-flex flex-wrap gap-3 small text-gray-700">
                                    <div>
                                        <span class="fw-semibold text-gray-600">Periodo:</span>
                                        @php
                                            $start = $convocation->start_date
                                                ? \Illuminate\Support\Carbon::parse($convocation->start_date)->format(
                                                    'd/m/Y',
                                                )
                                                : 'N/D';
                                            $end = $convocation->end_date
                                                ? \Illuminate\Support\Carbon::parse($convocation->end_date)->format(
                                                    'd/m/Y',
                                                )
                                                : 'Sin fecha fin';
                                        @endphp
                                        <span>{{ $start }} - {{ $end }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end">
                                @php
                                    $status = strtolower($convocation->status);
                                    $statusColor = match ($status) {
                                        'activa' => 'text-success',
                                        'proxima' => 'text-warning',
                                        'permanente' => 'text-primary',
                                        'cerrada' => 'text-danger',
                                        default => 'text-gray-600',
                                    };
                                @endphp
                                <div class="fw-semibold {{ $statusColor }} text-capitalize">
                                    {{ $convocation->status }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <div class="fw-semibold small text-gray-600 mb-2">Documentos</div>
                            @if ($convocation->documents->count() > 0)
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach ($convocation->documents as $document)
                                        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.institutional-document.download', $document->institutional_document_id ?? ($document->id ?? $document->convocation_document_id)) }}"
                                            class="btn btn-outline-gray-600 btn-sm d-inline-flex align-items-center gap-2">
                                            @icon('download', 'icon icon-xs')
                                            <span class="text-truncate"
                                                style="max-width: 220px;">{{ $document->title ?? 'Documento' }}</span>
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-gray-500 small">Sin documentos</span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        @icon('info', 'fa-3x text-gray-400 mb-3 d-block')
                        <h5 class="text-gray-600 mb-1">No hay convocatorias para mostrar</h5>
                        <p class="text-gray-500 mb-0">Vuelve mas tarde para ver nuevas convocatorias.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Pagination footer --}}
    @if ($convocations instanceof \Illuminate\Contracts\Pagination\Paginator)
        <div class="d-flex flex-column flex-lg-row align-items-center justify-content-between mb-5 gap-3">
            @if ($convocations->hasPages())
                <nav aria-label="Paginacion de convocatorias" class="mb-0">
                    {{ $convocations->onEachSide(1)->links('components.pagination-users') }}
                </nav>
            @endif
            @php
                $from = $convocations->firstItem() ?? 0;
                $to = $convocations->lastItem() ?? 0;
                $total = $convocations->total();
            @endphp
            <div class="fw-normal small ms-lg-auto">
                Mostrando <b>{{ $from }}</b> a <b>{{ $to }}</b> de <b>{{ $total }}</b>
                convocatorias
            </div>
        </div>
    @endif

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
                            <h3 class="h6 fw-bold mb-3 d-flex align-items-center gap-2">
                                @icon('file', 'icon icon-xs')
                                Reglamentos
                            </h3>
                            @if ($regulations->count() > 0)
                                <div class="list-group list-group-flush">
                                    @foreach ($regulations as $doc)
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
                            <h3 class="h6 fw-bold mb-3 d-flex align-items-center gap-2">
                                @icon('file', 'icon icon-xs')
                                Manuales y formatos
                            </h3>
                            @if ($manuals->count() > 0)
                                <div class="list-group list-group-flush">
                                    @foreach ($manuals as $doc)
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

    {{-- Help Section --}}
    <div class="row">
        <div class="col-12">
            <div class="alert alert-info d-flex align-items-center" role="alert">
                <svg class="icon icon-sm me-3" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                        clip-rule="evenodd"></path>
                </svg>
                <div>
                    <strong>&iquest;Tienes dudas?</strong> Consulta la seccion de <a
                        href="{{ route(config('proj.route_name_prefix', 'proj') . '.faq') }}"
                        class="alert-link">Preguntas frecuentes</a> o contacta al departamento correspondiente para mas
                    informacion sobre convocatorias y documentos.
                </div>
            </div>
        </div>
    </div>
</div>
