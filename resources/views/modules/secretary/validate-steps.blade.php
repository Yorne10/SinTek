{{--
    Company: CETAM
    Project: ST
    File: validate-steps.blade.php
    Created on: 04/11/2025
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
                    <li class="breadcrumb-item active" aria-current="page">Validar pasos</li>
                </ol>
            </nav>
            <h2 class="h4">Validar pasos del proceso</h2>
            <p class="mb-0">Revisa y valida los pasos pendientes del trámite.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-xl-8">
            <div class="card card-body shadow border-0 mb-4">
                <h2 class="h5 mb-4">Paso 3: Revisión de documentación</h2>

                <form wire:submit.prevent="save">
                    <div class="mb-4">
                        <label class="form-label">Estado de revisión</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="statusApproved"
                                    value="approved" checked>
                                <label class="form-check-label" for="statusApproved">Aprobado</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="statusRejected"
                                    value="rejected">
                                <label class="form-check-label" for="statusRejected">Rechazado</label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="observations" class="form-label">Observaciones</label>
                        <textarea class="form-control" id="observations" rows="3" placeholder="Escribe aquí cualquier observación..."></textarea>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <button type="button" class="btn btn-outline-gray-600">
                            Cancelar
                        </button>
                        <button type="submit" class="btn btn-success">
                            <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Guardar y marcar como completado
                        </button>
                    </div>
                </form>
            </div>

            {{-- Pending Steps --}}
            <div class="card card-body shadow border-0 mb-4">
                <div class="mb-4 pb-4 border-bottom">
                    <div class="d-flex align-items-center mb-3">
                        <span class="badge bg-secondary me-3">4</span>
                        <h3 class="h6 mb-0 text-gray-500">Paso 4: Aprobación de supervisor</h3>
                    </div>
                    <p class="text-gray-500 mb-0">Este paso estará disponible cuando se complete el anterior.</p>
                </div>

                <div class="mb-0">
                    <div class="d-flex align-items-center mb-3">
                        <span class="badge bg-secondary me-3">5</span>
                        <h3 class="h6 mb-0 text-gray-500">Paso 5: Autorización final</h3>
                    </div>
                    <p class="text-gray-500 mb-0">Este paso estará disponible cuando se completen los pasos previos.</p>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-4">
            {{-- Sidebar --}}
            <div class="card border-0 shadow mb-4">
                <div class="card-header border-bottom">
                    <h2 class="fs-5 fw-bold mb-0">Documentos adjuntos</h2>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0 d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="icon-shape icon-sm icon-shape-danger rounded me-2">
                                    <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="mb-0 fw-bold small">Solicitud_firmada.pdf</p>
                                    <small class="text-gray-500">245 KB</small>
                                </div>
                            </div>
                            <button class="btn btn-sm btn-link text-gray-600 p-0">
                                <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </li>
                        <li class="list-group-item px-0 d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="icon-shape icon-sm icon-shape-danger rounded me-2">
                                    <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="mb-0 fw-bold small">Identificacion_trabajador.pdf</p>
                                    <small class="text-gray-500">189 KB</small>
                                </div>
                            </div>
                            <button class="btn btn-sm btn-link text-gray-600 p-0">
                                <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </li>
                        <li class="list-group-item px-0 d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="icon-shape icon-sm icon-shape-danger rounded me-2">
                                    <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="mb-0 fw-bold small">Comprobante_domicilio.pdf</p>
                                    <small class="text-gray-500">312 KB</small>
                                </div>
                            </div>
                            <button class="btn btn-sm btn-link text-gray-600 p-0">
                                <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card border-0 shadow mb-4">
                <div class="card-header border-bottom">
                    <h2 class="fs-5 fw-bold mb-0">Historial de acciones</h2>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0">
                            <div class="d-flex align-items-start">
                                <div class="icon-shape icon-xs icon-shape-success rounded me-2 mt-1">
                                    <svg class="icon icon-xxs" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="flex-fill">
                                    <p class="mb-0 small fw-bold">Paso 2 aprobado</p>
                                    <small class="text-gray-500">Maria Lopez - 04/11/2025 10:15</small>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="d-flex align-items-start">
                                <div class="icon-shape icon-xs icon-shape-success rounded me-2 mt-1">
                                    <svg class="icon icon-xxs" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="flex-fill">
                                    <p class="mb-0 small fw-bold">Paso 1 aprobado</p>
                                    <small class="text-gray-500">Maria Lopez - 04/11/2025 09:35</small>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="d-flex align-items-start">
                                <div class="icon-shape icon-xs icon-shape-primary rounded me-2 mt-1">
                                    <svg class="icon icon-xxs" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                                        <path fill-rule="evenodd"
                                            d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="flex-fill">
                                    <p class="mb-0 small fw-bold">Solicitud recibida</p>
                                    <small class="text-gray-500">Juan Perez - 04/11/2025 09:30</small>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card border-0 shadow">
                <div class="card-header border-bottom">
                    <h2 class="fs-5 fw-bold mb-0">Acciones rápidas</h2>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-danger">
                            <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Rechazar solicitud completa
                        </button>
                        <button type="button" class="btn btn-outline-gray-600">
                            <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Solicitar información adicional
                        </button>
                        <button type="button" class="btn btn-outline-gray-600">
                            <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.736 6.979C9.208 6.193 9.696 6 10 6c.304 0 .792.193 1.264.979a1 1 0 001.715-1.029C12.279 4.784 11.232 4 10 4s-2.279.784-2.979 1.95c-.285.475-.507 1-.67 1.55H6a1 1 0 000 2h.013a9.358 9.358 0 000 1H6a1 1 0 100 2h.351c.163.55.385 1.075.67 1.55C7.721 15.216 8.768 16 10 16s2.279-.784 2.979-1.95a1 1 0 10-1.715-1.029c-.472.786-.96.979-1.264.979-.304 0-.792-.193-1.264-.979a4.265 4.265 0 01-.264-.521H10a1 1 0 100-2H8.017a7.36 7.36 0 010-1H10a1 1 0 100-2H8.472c.08-.185.167-.36.264-.521z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Ver historial del trabajador
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
