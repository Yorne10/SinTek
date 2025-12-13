{{--
Company: CETAM
Project: ST
File: convocatorias-documentos.blade.php
Created on: 04/11/2025
Created by: Alfonso Angel Garcia Hernandez
Approved by: Alfonso Angel Garcia Hernandez

Changelog:
- ID: <ID> | Date: dd/mm/yyyy
    Modified by: <Developer name>
    Description: <Brief description of change>
--}}
<div>
    {{-- Page Header --}}
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
                    <li class="breadcrumb-item active" aria-current="page">Convocatorias y documentos</li>
                </ol>
            </nav>
            <h2 class="h4">Gestión de convocatorias y documentos</h2>
            <p class="mb-0">Administra las convocatorias públicas y documentos institucionales.</p>
        </div>
    </div>

    {{-- Form para nueva convocatoria --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <h2 class="h5 mb-0">Nueva convocatoria</h2>
                    <button type="button" wire:click="limpiar" class="btn btn-sm btn-outline-gray-600">
                        <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Cancelar
                    </button>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="save">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="titulo" class="form-label">Título de la convocatoria *</label>
                                <input wire:model="titulo" type="text"
                                    class="form-control @error('titulo') is-invalid @enderror" id="titulo"
                                    placeholder="Ej: Convocatoria para plaza de coordinador administrativo">
                                @error('titulo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="descripcion" class="form-label">Descripción *</label>
                                <textarea wire:model="descripcion" class="form-control @error('descripcion') is-invalid @enderror" id="descripcion"
                                    rows="4" placeholder="Descripción detallada de la convocatoria..."></textarea>
                                @error('descripcion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="form-check">
                                    <input wire:model.live="convocatoria_permanente" class="form-check-input"
                                        type="checkbox" id="convocatoria_permanente">
                                    <label class="form-check-label" for="convocatoria_permanente">
                                        Convocatoria permanente (sin fecha de cierre)
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="fecha_inicio" class="form-label">Fecha de inicio *</label>
                                <input wire:model="fecha_inicio" type="date"
                                    class="form-control @error('fecha_inicio') is-invalid @enderror" id="fecha_inicio">
                                @error('fecha_inicio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="fecha_fin" class="form-label">Fecha de fin</label>
                                <input wire:model="fecha_fin" type="date"
                                    class="form-control @error('fecha_fin') is-invalid @enderror" id="fecha_fin"
                                    @if ($convocatoria_permanente) disabled @endif>
                                <small class="form-text text-muted">Dejar vacío si es permanente</small>
                                @error('fecha_fin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Documentos (PDF) <span
                                        class="text-muted small">(Opcional)</span></label>
                                @foreach ($documentos as $index => $documento)
                                    <div class="row mb-2" wire:key="doc-{{ $index }}">
                                        <div class="col-md-5">
                                            <input type="text" wire:model="documentos.{{ $index }}.titulo"
                                                class="form-control @error('documentos.' . $index . '.titulo') is-invalid @enderror"
                                                placeholder="Título del documento">
                                            @error('documentos.' . $index . '.titulo')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <input type="file" wire:model="documentos.{{ $index }}.archivo"
                                                class="form-control @error('documentos.' . $index . '.archivo') is-invalid @enderror"
                                                accept=".pdf">
                                            @error('documentos.' . $index . '.archivo')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-1">
                                            <button type="button" wire:click="removeDocumento({{ $index }})"
                                                class="btn btn-sm btn-danger">
                                                <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd"
                                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                                <button type="button" wire:click="addDocumento"
                                    class="btn btn-sm btn-outline-primary">
                                    <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    Agregar documento
                                </button>
                            </div>

                            <div class="col-md-12 d-flex justify-content-end gap-2">
                                <button type="button" wire:click="limpiar" class="btn btn-secondary">
                                    <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    Limpiar
                                </button>
                                <button type="submit" class="btn btn-primary" id="createConvBtn">
                                    <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    Crear convocatoria
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Lista de convocatorias --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow">
                <div class="card-header border-bottom">
                    <h2 class="h5 mb-0">Convocatorias publicadas</h2>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="border-bottom">Título</th>
                                    <th class="border-bottom">Periodo</th>
                                    <th class="border-bottom">Estado</th>
                                    <th class="border-bottom">Documentos</th>
                                    <th class="border-bottom">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($convocatorias as $convocatoria)
                                    <tr>
                                        <td>
                                            <div class="d-block">
                                                <span class="fw-bold">{{ $convocatoria->title }}</span>
                                                <div class="small text-gray">
                                                    {{ Str::limit($convocatoria->description, 80) }}
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span
                                                class="fw-normal small">{{ $convocatoria->start_date ? $convocatoria->start_date->format('d/m/Y') : 'N/A' }}</span>
                                            @if ($convocatoria->end_date)
                                                <span class="text-gray"> - </span>
                                                <span
                                                    class="fw-normal small">{{ $convocatoria->end_date->format('d/m/Y') }}</span>
                                            @else
                                                <div class="small text-gray">Sin fecha fin</div>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($convocatoria->status === 'activa')
                                                <span class="fw-bold text-success">Activa</span>
                                            @elseif($convocatoria->status === 'cerrada')
                                                <span class="fw-bold text-secondary">Cerrada</span>
                                            @elseif($convocatoria->status === 'proxima')
                                                <span class="fw-bold text-warning">Próxima</span>
                                            @elseif($convocatoria->status === 'permanente')
                                                <span class="fw-bold text-info">Permanente</span>
                                            @else
                                                <span
                                                    class="fw-bold text-gray-600">{{ ucfirst($convocatoria->status) }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($convocatoria->documents->count() > 0)
                                                <div class="d-flex gap-1">
                                                    <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.convocation-document.show', $convocatoria->documents->first()->convocation_document_id) }}"
                                                        target="_blank" class="btn btn-sm btn-outline-primary">
                                                        <svg class="icon icon-xs" fill="currentColor"
                                                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                                            <path fill-rule="evenodd"
                                                                d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                    </a>
                                                    @if ($convocatoria->documents->count() > 1)
                                                        <span
                                                            class="small text-gray align-self-center">+{{ $convocatoria->documents->count() - 1 }}</span>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="small text-gray-500">Sin documentos</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button
                                                    class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                                                    data-bs-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z">
                                                        </path>
                                                    </svg>
                                                </button>
                                                <div
                                                    class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1">
                                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                                        <svg class="dropdown-icon text-gray-400 me-2"
                                                            fill="currentColor" viewBox="0 0 20 20"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                                            <path fill-rule="evenodd"
                                                                d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                        Ver detalles
                                                    </a>
                                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                                        <svg class="dropdown-icon text-gray-400 me-2"
                                                            fill="currentColor" viewBox="0 0 20 20"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                            </path>
                                                        </svg>
                                                        Editar
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <div class="text-gray-500">
                                                <i class="fa-solid fa-table-list fa-2x mb-3"></i>
                                                <p class="fw-bold">No hay convocatorias para mostrar</p>
                                                <p class="small">Crea tu primera convocatoria usando el formulario
                                                    superior
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($convocatorias->hasPages())
                        <div class="card-footer px-3 border-0 d-flex justify-content-between align-items-center">
                            <nav>{{ $convocatorias->links() }}</nav>
                            <div class="fw-normal small">
                                Mostrando <b>{{ $convocatorias->firstItem() ?? 0 }}</b> a
                                <b>{{ $convocatorias->lastItem() ?? 0 }}</b> de <b>{{ $convocatorias->total() }}</b>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Documentos institucionales --}}
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="h5 mb-0">Reglamentos y manuales institucionales</h2>
                        <p class="small text-gray-500 mb-0 mt-1">Documentos normativos y de consulta</p>
                    </div>
                    <button type="button" wire:click="toggleInstitutionalForm" class="btn btn-sm btn-gray-800">
                        <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"
                                clip-rule="evenodd"></path>
                        </svg>
                        {{ $showInstitutionalForm ? 'Cancelar' : 'Subir documento' }}
                    </button>
                </div>

                @if ($showInstitutionalForm)
                    <div class="card-body border-bottom bg-light">
                        <form wire:submit.prevent="saveInstitutionalDocument">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="doc_titulo" class="form-label">Título del documento *</label>
                                    <input wire:model="doc_titulo" type="text"
                                        class="form-control @error('doc_titulo') is-invalid @enderror" id="doc_titulo"
                                        placeholder="Ej: Reglamento Interior de Trabajo">
                                    @error('doc_titulo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="doc_categoria" class="form-label">Categoría *</label>
                                    <select wire:model="doc_categoria"
                                        class="form-select @error('doc_categoria') is-invalid @enderror"
                                        id="doc_categoria">
                                        <option value="reglamento">Reglamento</option>
                                        <option value="manual">Manual</option>
                                        <option value="lineamiento">Lineamiento</option>
                                        <option value="codigo">Código</option>
                                        <option value="otro">Otro</option>
                                    </select>
                                    @error('doc_categoria')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="doc_version" class="form-label">Versión *</label>
                                    <input wire:model="doc_version" type="text"
                                        class="form-control @error('doc_version') is-invalid @enderror"
                                        id="doc_version" placeholder="1.0">
                                    @error('doc_version')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="doc_descripcion" class="form-label">Descripción (opcional)</label>
                                    <textarea wire:model="doc_descripcion" class="form-control" id="doc_descripcion" rows="2"></textarea>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="doc_fecha_vigencia" class="form-label">Fecha de vigencia</label>
                                    <input wire:model="doc_fecha_vigencia" type="date" class="form-control"
                                        id="doc_fecha_vigencia">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="doc_archivo" class="form-label">Archivo PDF *</label>
                                    <input wire:model="doc_archivo" type="file"
                                        class="form-control @error('doc_archivo') is-invalid @enderror"
                                        id="doc_archivo" accept=".pdf">
                                    @error('doc_archivo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Max 10MB</small>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary" id="saveDocBtn">
                                        <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        Guardar documento
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif

                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($institutionalDocuments as $document)
                            <div class="list-group-item d-flex align-items-center justify-content-between px-3 py-3">
                                <div class="d-flex align-items-center">
                                    <svg class="icon icon-lg text-danger me-3" fill="currentColor"
                                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <div>
                                        <h3 class="h6 mb-1">{{ $document->title }}</h3>
                                        <p class="small text-gray-500 mb-0">
                                            {{ $document->created_at->format('d/m/Y') }}
                                            {{ $document->file_size_human }}
                                            <span class="fw-bold text-success">{{ ucfirst($document->status) }}</span>
                                            v{{ $document->version }}
                                        </p>
                                    </div>
                                </div>
                                <div class="btn-group">
                                    <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.institutional-document.show', $document->institutional_document_id) }}"
                                        target="_blank" class="btn btn-sm btn-outline-primary">
                                        <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                            <path fill-rule="evenodd"
                                                d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        Ver
                                    </a>
                                    <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.institutional-document.download', $document->institutional_document_id) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        Descargar
                                    </a>
                                    <button type="button"
                                        class="btn btn-sm btn-outline-primary dropdown-toggle dropdown-toggle-split"
                                        data-bs-toggle="dropdown">
                                        <span class="visually-hidden">Más</span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item text-warning archive-doc-btn" href="#"
                                                data-doc-id="{{ $document->institutional_document_id }}"
                                                data-doc-title="{{ $document->title }}">Archivar</a></li>
                                    </ul>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <i class="fa-solid fa-file fa-2x text-gray-400 mb-3"></i>
                                <p class="fw-bold">No hay documentos institucionales para mostrar</p>
                                <p class="small text-gray-600">Sube tu primer documento usando el botón superior</p>
                            </div>
                        @endforelse
                    </div>
                    @if ($institutionalDocuments->hasPages())
                        <div class="card-footer px-3 border-0 d-flex justify-content-between align-items-center">
                            <nav>{{ $institutionalDocuments->links() }}</nav>
                            <div class="fw-normal small">
                                Mostrando <b>{{ $institutionalDocuments->firstItem() ?? 0 }}</b> a
                                <b>{{ $institutionalDocuments->lastItem() ?? 0 }}</b> de
                                <b>{{ $institutionalDocuments->total() }}</b>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-primary me-2',
                cancelButton: 'btn btn-gray'
            },
            buttonsStyling: false
        });

        // Botón crear convocatoria con confirmación
        document.getElementById('createConvBtn')?.addEventListener('click', function(e) {
            e.preventDefault();
            swalWithBootstrapButtons.fire({
                title: 'Crear convocatoria?',
                text: '¿Deseas publicar esta convocatoria?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, publicar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('save');
                }
            });
        });

        // Botón guardar documento institucional
        document.getElementById('saveDocBtn')?.addEventListener('click', function(e) {
            e.preventDefault();
            swalWithBootstrapButtons.fire({
                title: 'Guardar documento?',
                text: '¿Deseas subir este documento institucional?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, guardar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('saveInstitutionalDocument');
                }
            });
        });

        // Event listener para archivar documentos
        document.addEventListener('click', function(e) {
            if (e.target.closest('.archive-doc-btn')) {
                e.preventDefault();
                const button = e.target.closest('.archive-doc-btn');
                const docId = button.getAttribute('data-doc-id');
                const docTitle = button.getAttribute('data-doc-title');

                swalWithBootstrapButtons.fire({
                    title: 'Archivar documento?',
                    text: `¿Estás seguro de archivar "${docTitle}"?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, archivar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.call('archiveInstitutionalDocument', docId);
                    }
                });
            }
        });

        // Escuchar eventos de notificación
        if (window.Livewire) {
            Livewire.on('convocatoria-notify', (event) => {
                const detail = event || {};
                swalWithBootstrapButtons.fire({
                    icon: detail.type || 'success',
                    title: detail.title || 'Aviso',
                    text: detail.message || '',
                    confirmButtonText: 'Aceptar',
                    showConfirmButton: true
                });
            });
        }
    });
</script>
