{{--
* Company: CETAM
* Project: ST
* File: validar-pasos.blade.php
* Created on: 04/11/2025
* Created by: Alfonso Angel Garca Hernndez
* Approved by: Alfonso Angel Garca Hernndez
*
* Changelog:
* - ID: <ID> | Modified on: dd/mm/yyyy |
    * Modified by: <Developer name> |
        * Description: <Brief description of change> |
            *
            * - ID: <ID> | Modified on: dd/mm/yyyy |
                * Modified by: <Developer name> |
                    * Description: <Brief description of change> |
                        --}}

                        {{-- Nota Livewire: esta vista debe tener UN nico elemento raz --}}
                        {{-- El layout se aplica desde el componente con ->layout('layouts.app') --}}

                        <div>
                            <div
                                class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
                                <div class="d-block mb-4 mb-md-0">
                                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                                        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                                            <li class="breadcrumb-item">
                                                <a
                                                    href="{{ route(config('proj.route_name_prefix', 'proj') . '.dashboard.index') }}">
                                                    @icon('nav.home', 'fa-xs')
                                                </a>
                                            </li>
                                            <li class="breadcrumb-item">Secretara</li>
                                            <li class="breadcrumb-item"><a href="#">Panel de solicitudes</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">Validar pasos</li>
                                        </ol>
                                    </nav>
                                    <h2 class="h4">Validación de pasos del trámite</h2>
                                    <p class="mb-0">Revisa y valida cada paso del proceso de solicitud.</p>
                                </div>
                                <div class="btn-toolbar mb-2 mb-md-0">
                                    <a href="#"
                                        class="btn btn-sm btn-outline-gray-600 d-inline-flex align-items-center">
                                        <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        Volver a solicitudes
                                    </a>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 col-xl-8 mb-4">
                                    <div class="card border-0 shadow mb-4">
                                        <div class="card-header border-bottom">
                                            <div class="row align-items-center">
                                                <div class="col">
                                                    <h2 class="fs-5 fw-bold mb-0">Informacin de la solicitud</h2>
                                                </div>
                                                <div class="col-auto">
                                                    <span class="badge bg-warning fs-6">Pendiente revisin</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label fw-bold">Folio</label>
                                                    <p class="text-gray-900">#SV-2025-0102</p>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label fw-bold">Tipo de trámite</label>
                                                    <p class="text-gray-900">Solicitud de vacaciones</p>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label fw-bold">Trabajador</label>
                                                    <div class="d-flex align-items-center">
                                                        <img class="avatar rounded-circle me-2" alt="Avatar"
                                                            src="https://ui-avatars.com/api/?name=Juan+Perez&background=0D8ABC&color=fff">
                                                        <div>
                                                            <p class="mb-0 fw-bold">Juan Prez Garca</p>
                                                            <small class="text-gray-500">CURP: PEGJ850315HMCRR01</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label fw-bold">Fecha de solicitud</label>
                                                    <p class="text-gray-900">04/11/2025 09:30</p>
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <label class="form-label fw-bold">Descripcin de la solicitud</label>
                                                    <p class="text-gray-700">Solicitud de vacaciones del 15 al 22 de
                                                        noviembre de 2025 (8 das hbiles). Motivo: Asuntos personales y
                                                        familiares.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card border-0 shadow mb-4">
                                        <div class="card-header border-bottom">
                                            <h2 class="fs-5 fw-bold mb-0">Progreso del trámite</h2>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between mb-3">
                                                <span class="small fw-bold">2 de 5 pasos completados</span>
                                                <span class="small fw-bold">40%</span>
                                            </div>
                                            <div class="progress mb-4" style="height: 15px;">
                                                <div class="progress-bar bg-primary" role="progressbar"
                                                    style="width: 40%" aria-valuenow="40" aria-valuemin="0"
                                                    aria-valuemax="100"></div>
                                            </div>

                                            <div class="timeline timeline-one-side">
                                                <div class="timeline-item">
                                                    <span class="timeline-badge bg-success">
                                                        <svg class="icon icon-xs" fill="currentColor"
                                                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd"
                                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                    </span>
                                                    <div class="timeline-content">
                                                        <h3 class="h6 mb-1">Paso 1: Recepcin de solicitud</h3>
                                                        <p class="small text-gray-500 mb-0">Completado el 04/11/2025
                                                            09:35</p>
                                                    </div>
                                                </div>
                                                <div class="timeline-item">
                                                    <span class="timeline-badge bg-success">
                                                        <svg class="icon icon-xs" fill="currentColor"
                                                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd"
                                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                    </span>
                                                    <div class="timeline-content">
                                                        <h3 class="h6 mb-1">Paso 2: Validación documental</h3>
                                                        <p class="small text-gray-500 mb-0">Completado el 04/11/2025
                                                            10:15</p>
                                                    </div>
                                                </div>
                                                <div class="timeline-item">
                                                    <span class="timeline-badge bg-warning">
                                                        <svg class="icon icon-xs" fill="currentColor"
                                                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd"
                                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                    </span>
                                                    <div class="timeline-content">
                                                        <h3 class="h6 mb-1 text-warning">Paso 3: Revisin de
                                                            disponibilidad</h3>
                                                        <p class="small text-gray-500 mb-0">En proceso</p>
                                                    </div>
                                                </div>
                                                <div class="timeline-item">
                                                    <span class="timeline-badge bg-secondary">4</span>
                                                    <div class="timeline-content">
                                                        <h3 class="h6 mb-1 text-gray-500">Paso 4: Aprobacin de
                                                            supervisor</h3>
                                                        <p class="small text-gray-500 mb-0">Pendiente</p>
                                                    </div>
                                                </div>
                                                <div class="timeline-item">
                                                    <span class="timeline-badge bg-secondary">5</span>
                                                    <div class="timeline-content">
                                                        <h3 class="h6 mb-1 text-gray-500">Paso 5: Autorizacin final</h3>
                                                        <p class="small text-gray-500 mb-0">Pendiente</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card border-0 shadow">
                                        <div class="card-header border-bottom">
                                            <h2 class="fs-5 fw-bold mb-0">Validación de pasos</h2>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-4 pb-4 border-bottom">
                                                <div class="d-flex align-items-center mb-3">
                                                    <span class="badge bg-success me-3">
                                                        <svg class="icon icon-xs" fill="currentColor"
                                                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd"
                                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                    </span>
                                                    <h3 class="h6 mb-0">Paso 1: Recepcin de solicitud</h3>
                                                </div>
                                                <p class="text-gray-700 mb-2">Verificar que la solicitud est completa y
                                                    cumple con los requisitos iniciales.</p>
                                                <div class="row">
                                                    <div class="col-md-12 mb-3">
                                                        <label class="form-label fw-bold">Resultado</label>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="step1_result" id="step1_si" checked disabled>
                                                            <label class="form-check-label text-success fw-bold"
                                                                for="step1_si">
                                                                Aprobado
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <label class="form-label fw-bold">Observaciones</label>
                                                        <p class="form-control-plaintext text-gray-700">Solicitud
                                                            recibida correctamente. Todos los documentos estn completos.
                                                        </p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-bold">Validado por</label>
                                                        <p class="text-gray-700 mb-0">Mara Lpez Snchez</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-bold">Fecha</label>
                                                        <p class="text-gray-700 mb-0">04/11/2025 09:35</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-4 pb-4 border-bottom">
                                                <div class="d-flex align-items-center mb-3">
                                                    <span class="badge bg-success me-3">
                                                        <svg class="icon icon-xs" fill="currentColor"
                                                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd"
                                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                    </span>
                                                    <h3 class="h6 mb-0">Paso 2: Validación documental</h3>
                                                </div>
                                                <p class="text-gray-700 mb-2">Verificar la autenticidad y vigencia de
                                                    los documentos presentados.</p>
                                                <div class="row">
                                                    <div class="col-md-12 mb-3">
                                                        <label class="form-label fw-bold">Resultado</label>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="step2_result" id="step2_si" checked disabled>
                                                            <label class="form-check-label text-success fw-bold"
                                                                for="step2_si">
                                                                Aprobado
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <label class="form-label fw-bold">Observaciones</label>
                                                        <p class="form-control-plaintext text-gray-700">Documentacin
                                                            verificada y en regla. INE vigente, comprobante de domicilio
                                                            actualizado.</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-bold">Validado por</label>
                                                        <p class="text-gray-700 mb-0">Mara Lpez Snchez</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-bold">Fecha</label>
                                                        <p class="text-gray-700 mb-0">04/11/2025 10:15</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-4 pb-4 border-bottom bg-light p-4 rounded">
                                                <div class="d-flex align-items-center mb-3">
                                                    <span class="badge bg-warning me-3">3</span>
                                                    <h3 class="h6 mb-0">Paso 3: Revisin de disponibilidad</h3>
                                                </div>
                                                <p class="text-gray-700 mb-3">Verificar la disponibilidad de das de
                                                    vacaciones del trabajador y el impacto en el rea.</p>

                                                <form>
                                                    <div class="row">
                                                        <div class="col-md-12 mb-3">
                                                            <label class="form-label fw-bold">Resultado *</label>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="radio"
                                                                    name="step3_result" id="step3_si" value="aprobado">
                                                                <label class="form-check-label" for="step3_si">
                                                                    <svg class="icon icon-xs text-success me-1"
                                                                        fill="currentColor" viewBox="0 0 20 20"
                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                        <path fill-rule="evenodd"
                                                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                                            clip-rule="evenodd"></path>
                                                                    </svg>
                                                                    Aprobar paso
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="step3_result" id="step3_no" value="rechazado">
                                                                <label class="form-check-label" for="step3_no">
                                                                    <svg class="icon icon-xs text-danger me-1"
                                                                        fill="currentColor" viewBox="0 0 20 20"
                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                        <path fill-rule="evenodd"
                                                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                                            clip-rule="evenodd"></path>
                                                                    </svg>
                                                                    Rechazar paso
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 mb-3">
                                                            <label for="step3_observaciones"
                                                                class="form-label fw-bold">Observaciones *</label>
                                                            <textarea class="form-control" id="step3_observaciones"
                                                                rows="4"
                                                                placeholder="Ingrese sus observaciones sobre este paso..."></textarea>
                                                            <small class="form-text text-gray-500">Describa los
                                                                hallazgos encontrados en la revisin de
                                                                disponibilidad.</small>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="alert alert-info d-flex align-items-center"
                                                                role="alert">
                                                                <svg class="icon icon-sm me-2" fill="currentColor"
                                                                    viewBox="0 0 20 20"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path fill-rule="evenodd"
                                                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                                        clip-rule="evenodd"></path>
                                                                </svg>
                                                                <div>
                                                                    <strong>Informacin:</strong> El trabajador tiene 15
                                                                    das de vacaciones disponibles. Las fechas
                                                                    solicitadas no presentan conflicto con el calendario
                                                                    laboral.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 d-flex justify-content-end gap-2">
                                                            <button type="button" class="btn btn-outline-gray-600">
                                                                Cancelar
                                                            </button>
                                                            <button type="submit" class="btn btn-success">
                                                                <svg class="icon icon-xs me-2" fill="currentColor"
                                                                    viewBox="0 0 20 20"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path fill-rule="evenodd"
                                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                                        clip-rule="evenodd"></path>
                                                                </svg>
                                                                Guardar y marcar como completado
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                            <div class="mb-4 pb-4 border-bottom">
                                                <div class="d-flex align-items-center mb-3">
                                                    <span class="badge bg-secondary me-3">4</span>
                                                    <h3 class="h6 mb-0 text-gray-500">Paso 4: Aprobacin de supervisor
                                                    </h3>
                                                </div>
                                                <p class="text-gray-500 mb-0">Este paso estar disponible una vez
                                                    completado el paso anterior.</p>
                                            </div>

                                            <div class="mb-0">
                                                <div class="d-flex align-items-center mb-3">
                                                    <span class="badge bg-secondary me-3">5</span>
                                                    <h3 class="h6 mb-0 text-gray-500">Paso 5: Autorizacin final</h3>
                                                </div>
                                                <p class="text-gray-500 mb-0">Este paso estar disponible una vez
                                                    completados todos los pasos anteriores.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-xl-4">
                                    <div class="card border-0 shadow mb-4">
                                        <div class="card-header border-bottom">
                                            <h2 class="fs-5 fw-bold mb-0">Documentos adjuntos</h2>
                                        </div>
                                        <div class="card-body">
                                            <ul class="list-group list-group-flush">
                                                <li
                                                    class="list-group-item px-0 d-flex align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center">
                                                        <div class="icon-shape icon-sm icon-shape-danger rounded me-2">
                                                            <svg class="icon icon-xs" fill="currentColor"
                                                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
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
                                                        <svg class="icon icon-xs" fill="currentColor"
                                                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd"
                                                                d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                    </button>
                                                </li>
                                                <li
                                                    class="list-group-item px-0 d-flex align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center">
                                                        <div class="icon-shape icon-sm icon-shape-danger rounded me-2">
                                                            <svg class="icon icon-xs" fill="currentColor"
                                                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd"
                                                                    d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                                                    clip-rule="evenodd"></path>
                                                            </svg>
                                                        </div>
                                                        <div>
                                                            <p class="mb-0 fw-bold small">INE_trabajador.pdf</p>
                                                            <small class="text-gray-500">189 KB</small>
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-sm btn-link text-gray-600 p-0">
                                                        <svg class="icon icon-xs" fill="currentColor"
                                                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd"
                                                                d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                    </button>
                                                </li>
                                                <li
                                                    class="list-group-item px-0 d-flex align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center">
                                                        <div class="icon-shape icon-sm icon-shape-danger rounded me-2">
                                                            <svg class="icon icon-xs" fill="currentColor"
                                                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
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
                                                        <svg class="icon icon-xs" fill="currentColor"
                                                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
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
                                                        <div
                                                            class="icon-shape icon-xs icon-shape-success rounded me-2 mt-1">
                                                            <svg class="icon icon-xxs" fill="currentColor"
                                                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd"
                                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                                    clip-rule="evenodd"></path>
                                                            </svg>
                                                        </div>
                                                        <div class="flex-fill">
                                                            <p class="mb-0 small fw-bold">Paso 2 aprobado</p>
                                                            <small class="text-gray-500">Mara Lpez - 04/11/2025
                                                                10:15</small>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item px-0">
                                                    <div class="d-flex align-items-start">
                                                        <div
                                                            class="icon-shape icon-xs icon-shape-success rounded me-2 mt-1">
                                                            <svg class="icon icon-xxs" fill="currentColor"
                                                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd"
                                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                                    clip-rule="evenodd"></path>
                                                            </svg>
                                                        </div>
                                                        <div class="flex-fill">
                                                            <p class="mb-0 small fw-bold">Paso 1 aprobado</p>
                                                            <small class="text-gray-500">Mara Lpez - 04/11/2025
                                                                09:35</small>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item px-0">
                                                    <div class="d-flex align-items-start">
                                                        <div
                                                            class="icon-shape icon-xs icon-shape-primary rounded me-2 mt-1">
                                                            <svg class="icon icon-xxs" fill="currentColor"
                                                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                                                                <path fill-rule="evenodd"
                                                                    d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z"
                                                                    clip-rule="evenodd"></path>
                                                            </svg>
                                                        </div>
                                                        <div class="flex-fill">
                                                            <p class="mb-0 small fw-bold">Solicitud recibida</p>
                                                            <small class="text-gray-500">Juan Prez - 04/11/2025
                                                                09:30</small>
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
                                                    <svg class="icon icon-xs me-2" fill="currentColor"
                                                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd"
                                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                    Rechazar solicitud completa
                                                </button>
                                                <button type="button" class="btn btn-outline-gray-600">
                                                    <svg class="icon icon-xs me-2" fill="currentColor"
                                                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd"
                                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                    Solicitar informacin adicional
                                                </button>
                                                <button type="button" class="btn btn-outline-gray-600">
                                                    <svg class="icon icon-xs me-2" fill="currentColor"
                                                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
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