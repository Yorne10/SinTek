{{--
    Company: CETAM
    Project: ST
    File: bitacora.blade.php
    Created on: 04/11/2025
    Created by: Alfonso Angel Garcia Hernandez
    Approved by: Alfonso Angel Garcia Hernandez

    Changelog:
    - ID: <ID> | Date: dd/mm/yyyy
      Modified by: <Developer name>
      Description: <Brief description of change>
--}}

{{-- Nota Livewire: esta vista debe tener UN único elemento raíz --}}
{{-- El layout se aplica desde el componente con ->layout('layouts.app') --}}

<div>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item">
                        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.dashboard.index') }}">
                            @icon('nav.home', 'icon icon-xxs')
                        </a>
                    </li>
                    <li class="breadcrumb-item">Administración</li>
                    <li class="breadcrumb-item active" aria-current="page">Bitácora de auditoría</li>
                </ol>
            </nav>
            <h2 class="h4">Bitácora de auditoría</h2>
            <p class="mb-0">Registro completo de todas las acciones realizadas en el sistema.</p>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <button type="button" class="btn btn-sm btn-gray-800 d-inline-flex align-items-center">
                <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd"></path></svg>
                Exportar CSV
            </button>
        </div>
    </div>

    <div class="card border-0 shadow mb-4">
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="input-group">
                        <span class="input-group-text">
                            <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                        </span>
                        <input type="text" class="form-control" placeholder="Buscar en bitácora...">
                    </div>
                </div>
                <div class="col-md-3 mb-3 mb-md-0">
                    <select class="form-select" id="filter_action_type">
                        <option value="" selected>Todas las acciones</option>
                        <option value="create">Creación</option>
                        <option value="update">Actualización</option>
                        <option value="delete">Eliminación</option>
                        <option value="login">Inicio de sesión</option>
                        <option value="logout">Cierre de sesión</option>
                        <option value="approve">Aprobación</option>
                        <option value="reject">Rechazo</option>
                    </select>
                </div>
                <div class="col-md-2 mb-3 mb-md-0">
                    <input type="date" class="form-control" placeholder="Desde">
                </div>
                <div class="col-md-2 mb-3 mb-md-0">
                    <input type="date" class="form-control" placeholder="Hasta">
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-secondary w-100">
                        <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"></path></svg>
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-centered table-hover table-nowrap mb-0 rounded">
                    <thead class="thead-light">
                        <tr>
                            <th class="border-0 rounded-start">#</th>
                            <th class="border-0">Fecha y hora</th>
                            <th class="border-0">Usuario</th>
                            <th class="border-0">Acción</th>
                            <th class="border-0">Módulo</th>
                            <th class="border-0">Descripción</th>
                            <th class="border-0">IP</th>
                            <th class="border-0 rounded-end">Detalles</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-gray-900">1287</td>
                            <td class="text-gray-900">
                                <div class="d-flex flex-column">
                                    <span class="fw-bold">04/11/2025</span>
                                    <small class="text-gray-500">14:32:15</small>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-2">
                                        <img class="avatar rounded-circle" alt="Avatar" src="https://ui-avatars.com/api/?name=Alfonso+Garcia&background=0D8ABC&color=fff">
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold">Alfonso García</span>
                                        <small class="text-gray-500">alfonso.garcia@cetam.gob.mx</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-success">Creación</span>
                            </td>
                            <td class="text-gray-900">Procesos</td>
                            <td class="text-gray-700">
                                Creó el proceso "Solicitud de vacaciones" (SOL-VAC-001)
                            </td>
                            <td class="text-gray-500">192.168.1.105</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-link text-gray-600 p-0">
                                    <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-gray-900">1286</td>
                            <td class="text-gray-900">
                                <div class="d-flex flex-column">
                                    <span class="fw-bold">04/11/2025</span>
                                    <small class="text-gray-500">14:28:42</small>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-2">
                                        <img class="avatar rounded-circle" alt="Avatar" src="https://ui-avatars.com/api/?name=Maria+Lopez&background=6F42C1&color=fff">
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold">María López</span>
                                        <small class="text-gray-500">maria.lopez@cetam.gob.mx</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-approved">Aprobación</span>
                            </td>
                            <td class="text-gray-900">Trámites</td>
                            <td class="text-gray-700">
                                Aprobó la solicitud de vacaciones #SV-2025-0045
                            </td>
                            <td class="text-gray-500">192.168.1.112</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-link text-gray-600 p-0">
                                    <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-gray-900">1285</td>
                            <td class="text-gray-900">
                                <div class="d-flex flex-column">
                                    <span class="fw-bold">04/11/2025</span>
                                    <small class="text-gray-500">14:15:23</small>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-2">
                                        <img class="avatar rounded-circle" alt="Avatar" src="https://ui-avatars.com/api/?name=Juan+Perez&background=FD7E14&color=fff">
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold">Juan Pérez</span>
                                        <small class="text-gray-500">juan.perez@cetam.gob.mx</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-info">Actualización</span>
                            </td>
                            <td class="text-gray-900">Usuarios</td>
                            <td class="text-gray-700">
                                Actualizó el perfil del usuario "Laura Hernández"
                            </td>
                            <td class="text-gray-500">192.168.1.098</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-link text-gray-600 p-0">
                                    <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-gray-900">1284</td>
                            <td class="text-gray-900">
                                <div class="d-flex flex-column">
                                    <span class="fw-bold">04/11/2025</span>
                                    <small class="text-gray-500">13:58:07</small>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-2">
                                        <img class="avatar rounded-circle" alt="Avatar" src="https://ui-avatars.com/api/?name=Carlos+Martinez&background=DC3545&color=fff">
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold">Carlos Martínez</span>
                                        <small class="text-gray-500">carlos.martinez@cetam.gob.mx</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-secondary">Inicio de sesión</span>
                            </td>
                            <td class="text-gray-900">Autenticación</td>
                            <td class="text-gray-700">
                                Inició sesión en el sistema
                            </td>
                            <td class="text-gray-500">192.168.1.087</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-link text-gray-600 p-0">
                                    <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-gray-900">1283</td>
                            <td class="text-gray-900">
                                <div class="d-flex flex-column">
                                    <span class="fw-bold">04/11/2025</span>
                                    <small class="text-gray-500">13:42:31</small>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-2">
                                        <img class="avatar rounded-circle" alt="Avatar" src="https://ui-avatars.com/api/?name=Ana+Rodriguez&background=28A745&color=fff">
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold">Ana Rodríguez</span>
                                        <small class="text-gray-500">ana.rodriguez@cetam.gob.mx</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-danger">Eliminación</span>
                            </td>
                            <td class="text-gray-900">Documentos</td>
                            <td class="text-gray-700">
                                Eliminó el documento "Convocatoria 2024-Q4.pdf"
                            </td>
                            <td class="text-gray-500">192.168.1.073</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-link text-gray-600 p-0">
                                    <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-gray-900">1282</td>
                            <td class="text-gray-900">
                                <div class="d-flex flex-column">
                                    <span class="fw-bold">04/11/2025</span>
                                    <small class="text-gray-500">13:20:18</small>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-2">
                                        <img class="avatar rounded-circle" alt="Avatar" src="https://ui-avatars.com/api/?name=Luis+Sanchez&background=17A2B8&color=fff">
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold">Luis Sánchez</span>
                                        <small class="text-gray-500">luis.sanchez@cetam.gob.mx</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-rejected">Rechazo</span>
                            </td>
                            <td class="text-gray-900">Trámites</td>
                            <td class="text-gray-700">
                                Rechazó la solicitud de reembolso #RG-2025-0089
                            </td>
                            <td class="text-gray-500">192.168.1.105</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-link text-gray-600 p-0">
                                    <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-gray-900">1281</td>
                            <td class="text-gray-900">
                                <div class="d-flex flex-column">
                                    <span class="fw-bold">04/11/2025</span>
                                    <small class="text-gray-500">12:55:44</small>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-2">
                                        <img class="avatar rounded-circle" alt="Avatar" src="https://ui-avatars.com/api/?name=Sofia+Torres&background=6610F2&color=fff">
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold">Sofía Torres</span>
                                        <small class="text-gray-500">sofia.torres@cetam.gob.mx</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-success">Creación</span>
                            </td>
                            <td class="text-gray-900">Usuarios</td>
                            <td class="text-gray-700">
                                Creó el usuario "Pedro Ramírez" con rol de Trabajador
                            </td>
                            <td class="text-gray-500">192.168.1.098</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-link text-gray-600 p-0">
                                    <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-gray-900">1280</td>
                            <td class="text-gray-900">
                                <div class="d-flex flex-column">
                                    <span class="fw-bold">04/11/2025</span>
                                    <small class="text-gray-500">12:38:09</small>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-2">
                                        <img class="avatar rounded-circle" alt="Avatar" src="https://ui-avatars.com/api/?name=Roberto+Diaz&background=FFC107&color=000">
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold">Roberto Díaz</span>
                                        <small class="text-gray-500">roberto.diaz@cetam.gob.mx</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-info">Actualización</span>
                            </td>
                            <td class="text-gray-900">Configuración</td>
                            <td class="text-gray-700">
                                Modificó parámetros de seguridad del sistema
                            </td>
                            <td class="text-gray-500">192.168.1.112</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-link text-gray-600 p-0">
                                    <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
                <nav aria-label="Page navigation example">
                    <ul class="pagination mb-0">
                        <li class="page-item">
                            <a class="page-link" href="#">Anterior</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">1</a>
                        </li>
                        <li class="page-item active">
                            <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">3</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">4</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">5</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">Siguiente</a>
                        </li>
                    </ul>
                </nav>
                <div class="fw-normal small mt-4 mt-lg-0">
                    Mostrando <b>8</b> de <b>1287</b> registros
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-xl-4 mb-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h2 class="h6 mb-0">Acciones más frecuentes</h2>
                        <span class="badge bg-secondary">Últimos 30 días</span>
                    </div>
                    <div class="mt-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex align-items-center">
                                <div class="icon icon-shape icon-xs icon-shape-primary rounded me-2">
                                    <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path></svg>
                                </div>
                                <span class="fw-normal small">Inicio de sesión</span>
                            </div>
                            <span class="fw-bold">342</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex align-items-center">
                                <div class="icon icon-shape icon-xs icon-shape-success rounded me-2">
                                    <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                </div>
                                <span class="fw-normal small">Aprobación</span>
                            </div>
                            <span class="fw-bold">189</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex align-items-center">
                                <div class="icon icon-shape icon-xs icon-shape-info rounded me-2">
                                    <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path></svg>
                                </div>
                                <span class="fw-normal small">Actualización</span>
                            </div>
                            <span class="fw-bold">156</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex align-items-center">
                                <div class="icon icon-shape icon-xs icon-shape-success rounded me-2">
                                    <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                                </div>
                                <span class="fw-normal small">Creación</span>
                            </div>
                            <span class="fw-bold">124</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="icon icon-shape icon-xs icon-shape-danger rounded me-2">
                                    <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                </div>
                                <span class="fw-normal small">Eliminación</span>
                            </div>
                            <span class="fw-bold">43</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-4 mb-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h2 class="h6 mb-0">Usuarios más activos</h2>
                        <span class="badge bg-secondary">Hoy</span>
                    </div>
                    <div class="mt-3">
                        <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                            <div class="d-flex align-items-center">
                                <img class="avatar rounded-circle me-2" alt="Avatar" src="https://ui-avatars.com/api/?name=Alfonso+Garcia&background=0D8ABC&color=fff">
                                <div class="d-flex flex-column">
                                    <span class="fw-bold small">Alfonso García</span>
                                    <small class="text-gray-500">Administrador</small>
                                </div>
                            </div>
                            <span class="badge bg-primary">47 acciones</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                            <div class="d-flex align-items-center">
                                <img class="avatar rounded-circle me-2" alt="Avatar" src="https://ui-avatars.com/api/?name=Maria+Lopez&background=6F42C1&color=fff">
                                <div class="d-flex flex-column">
                                    <span class="fw-bold small">María López</span>
                                    <small class="text-gray-500">Secretaria</small>
                                </div>
                            </div>
                            <span class="badge bg-primary">35 acciones</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                            <div class="d-flex align-items-center">
                                <img class="avatar rounded-circle me-2" alt="Avatar" src="https://ui-avatars.com/api/?name=Juan+Perez&background=FD7E14&color=fff">
                                <div class="d-flex flex-column">
                                    <span class="fw-bold small">Juan Pérez</span>
                                    <small class="text-gray-500">Trabajador</small>
                                </div>
                            </div>
                            <span class="badge bg-primary">28 acciones</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                            <div class="d-flex align-items-center">
                                <img class="avatar rounded-circle me-2" alt="Avatar" src="https://ui-avatars.com/api/?name=Ana+Rodriguez&background=28A745&color=fff">
                                <div class="d-flex flex-column">
                                    <span class="fw-bold small">Ana Rodríguez</span>
                                    <small class="text-gray-500">Secretaria</small>
                                </div>
                            </div>
                            <span class="badge bg-primary">21 acciones</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <img class="avatar rounded-circle me-2" alt="Avatar" src="https://ui-avatars.com/api/?name=Carlos+Martinez&background=DC3545&color=fff">
                                <div class="d-flex flex-column">
                                    <span class="fw-bold small">Carlos Martínez</span>
                                    <small class="text-gray-500">Trabajador</small>
                                </div>
                            </div>
                            <span class="badge bg-primary">18 acciones</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-4 mb-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h2 class="h6 mb-0">Módulos más utilizados</h2>
                        <span class="badge bg-secondary">Esta semana</span>
                    </div>
                    <div class="mt-3">
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="small">Trámites</span>
                                <span class="small fw-bold">62%</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 62%" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="small">Usuarios</span>
                                <span class="small fw-bold">48%</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 48%" aria-valuenow="48" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="small">Procesos</span>
                                <span class="small fw-bold">35%</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 35%" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="small">Documentos</span>
                                <span class="small fw-bold">28%</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 28%" aria-valuenow="28" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div>
                            <div class="d-flex justify-content-between mb-1">
                                <span class="small">Configuración</span>
                                <span class="small fw-bold">15%</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 15%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
