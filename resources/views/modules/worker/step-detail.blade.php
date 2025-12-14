{{--
Company: CETAM
Project: ST
File: step-detail.blade.php
Created on: 13/12/2025
Created by: Alfonso Angel Garcia Hernandez
Approved by: Alfonso Angel Garcia Hernandez

Changelog:
- ID: 001 | Date: 13/12/2025
Modified by: Alfonso Angel Garcia Hernandez
Description: Created step detail view for worker step actions
--}}
<div>
    {{-- Breadcrumb and Header --}}
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
                        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.worker.my-procedures') }}">Mis
                            trámites</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a
                            href="{{ route(config('proj.route_name_prefix', 'proj') . '.worker.procedure-detail', ['id' => $request->request_id]) }}">{{ $request->process->name }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $step->title }}</li>
                </ol>
            </nav>
            <h2 class="h4">{{ $step->title }}</h2>
            <p class="text-muted mb-0">{{ $request->process->name }}</p>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.worker.procedure-detail', ['id' => $request->request_id]) }}"
                class="btn btn-outline-secondary">
                @icon('arrowLeft', 'me-2')
                Volver al trámite
            </a>
        </div>
    </div>

    <div class="row">
        {{-- Main column: Current step --}}
        <div class="col-12 col-xl-8 mb-4">
            <div class="card border-0 shadow">
                <div class="card-header bg-white border-0">
                    <div class="d-flex align-items-center">
                        <span class="icon-shape icon-sm bg-info text-white rounded-circle me-3">
                            @icon('clock', 'icon-xs')
                        </span>
                        <div>
                            <h2 class="fs-5 fw-bold mb-0">Paso actual</h2>
                            <p class="text-muted small mb-0">Completa las acciones requeridas para avanzar</p>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    {{-- Step title and description --}}
                    <div class="mb-4">
                        <h3 class="h5 fw-bold">{{ $step->title }}</h3>
                        @if($step->description)
                            <p class="text-gray-600">{{ $step->description }}</p>
                        @endif
                    </div>

                    {{-- Instructions --}}
                    @if($step->instructions)
                        <div class="alert alert-info mb-4" role="alert">
                            <div class="d-flex">
                                @icon('info', 'me-2')
                                <div>
                                    <strong>Instrucciones:</strong>
                                    <p class="mb-0 mt-1">{{ $step->instructions }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Step actions based on type --}}
                    <div class="step-actions mt-4 pt-4 border-top">
                        @if ($step->condition_type === 'upload')
                            {{-- Upload document --}}
                            <h6 class="fw-bold mb-3">Subir documento requerido</h6>
                            <div class="mb-3">
                                <input type="file" class="form-control" wire:model="file">
                                @error('file')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            <div wire:loading wire:target="file" class="text-info small mb-3">
                                <span class="spinner-border spinner-border-sm me-1"></span>
                                Cargando archivo...
                            </div>
                            <button type="button" class="btn btn-primary" wire:click="uploadFile"
                                wire:loading.attr="disabled" wire:target="uploadFile, file" {{ !$file ? 'disabled' : '' }}>
                                <span wire:loading.remove wire:target="uploadFile">
                                    @icon('upload', 'me-2')
                                    Subir y completar paso
                                </span>
                                <span wire:loading wire:target="uploadFile">
                                    <span class="spinner-border spinner-border-sm me-1"></span>
                                    Subiendo...
                                </span>
                            </button>

                        @elseif($step->condition_type === 'conditional')
                            {{-- Conditional decision --}}
                            <h6 class="fw-bold mb-3">Toma una decisión</h6>
                            <p class="text-muted mb-3">Selecciona una opción para continuar con el trámite.</p>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-success approve-btn">
                                    @icon('check', 'me-2')
                                    Sí / Aprobar
                                </button>
                                <button type="button" class="btn btn-danger reject-btn">
                                    @icon('times', 'me-2')
                                    No / Rechazar
                                </button>
                            </div>

                        @else
                            {{-- Normal step --}}
                            <h6 class="fw-bold mb-3">Confirmar paso</h6>
                            <p class="text-muted mb-3">Una vez que hayas completado las instrucciones, haz clic en el botón
                                para continuar.</p>
                            <button type="button" class="btn btn-primary complete-step-btn">
                                @icon('check', 'me-2')
                                Marcar como completado
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar: Completed steps --}}
        <div class="col-12 col-xl-4">
            <div class="card border-0 shadow mb-4">
                <div class="card-header bg-white border-0">
                    <h2 class="fs-5 fw-bold mb-0">Pasos completados</h2>
                </div>
                <div class="card-body">
                    @if(count($completedSteps) > 0)
                        <ul class="list-unstyled mb-0">
                            @foreach($completedSteps as $completed)
                                <li class="d-flex align-items-start mb-3 {{ $loop->last ? '' : 'pb-3 border-bottom' }}">
                                    <span class="icon-shape icon-xs bg-success text-white rounded-circle me-2 flex-shrink-0">
                                        @icon('check', 'fa-xs')
                                    </span>
                                    <div>
                                        <span class="fw-semibold d-block">{{ $completed['title'] }}</span>
                                        @if($completed['completed_at'])
                                            <small class="text-muted">
                                                {{ \Carbon\Carbon::parse($completed['completed_at'])->format('d/m/Y H:i') }}
                                            </small>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted text-center mb-0">
                            Este es el primer paso del trámite.
                        </p>
                    @endif
                </div>
            </div>

            {{-- Process info --}}
            <div class="card border-0 shadow">
                <div class="card-header bg-white border-0">
                    <h2 class="fs-5 fw-bold mb-0">Información</h2>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-gray-600 d-block mb-1">Trámite</small>
                        <p class="mb-0 fw-semibold">{{ $request->process->name }}</p>
                    </div>
                    <div class="mb-3">
                        <small class="text-gray-600 d-block mb-1">Iniciado</small>
                        <p class="mb-0">{{ $request->start_date ? $request->start_date->format('d/m/Y H:i') : 'N/A' }}
                        </p>
                    </div>
                    <div>
                        <small class="text-gray-600 d-block mb-1">Estado</small>
                        <span class="badge bg-info">En proceso</span>
                    </div>
                </div>
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

        // Complete step button
        document.addEventListener('click', function (e) {
            if (e.target.closest('.complete-step-btn')) {
                e.preventDefault();

                swalWithBootstrapButtons.fire({
                    title: '¿Completar este paso?',
                    text: 'Se marcará como completado y avanzarás al siguiente.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, completar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.call('completeStep');
                    }
                });
            }
        });

        // Approve button
        document.addEventListener('click', function (e) {
            if (e.target.closest('.approve-btn')) {
                e.preventDefault();

                swalWithBootstrapButtons.fire({
                    title: '¿Aprobar?',
                    text: 'Se aprobará y continuará el flujo.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, aprobar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.call('conditionalStep', 'yes');
                    }
                });
            }
        });

        // Reject button
        document.addEventListener('click', function (e) {
            if (e.target.closest('.reject-btn')) {
                e.preventDefault();

                swalWithBootstrapButtons.fire({
                    title: '¿Rechazar?',
                    text: 'Se rechazará y se tomará la acción alternativa.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, rechazar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.call('conditionalStep', 'no');
                    }
                });
            }
        });

        // Listen for step completion
        if (window.Livewire) {
            Livewire.on('step-completed', (event) => {
                const detail = event || {};
                swalWithBootstrapButtons.fire({
                    icon: 'success',
                    title: detail.title || '¡Completado!',
                    text: detail.message || '',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    if (detail.redirectUrl) {
                        window.location.href = detail.redirectUrl;
                    }
                });
            });
        }
    });
</script>