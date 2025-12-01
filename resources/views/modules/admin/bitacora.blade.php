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
                                <li class="breadcrumb-item active" aria-current="page">Auditoría</li>
                            </ol>
                        </nav>
                        <h2 class="h4">Bitácora de actividades</h2>
                        <p class="mb-0">Registro detallado de acciones y eventos del sistema.</p>
                    </div>
                </div>

                <div class="card border-0 shadow mb-4">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap mb-0 rounded">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="border-0 rounded-start">Usuario</th>
                                        <th class="border-0">Acción</th>
                                        <th class="border-0">Descripción</th>
                                        <th class="border-0">IP</th>
                                        <th class="border-0">Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Contenido de la tabla --}}
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <div class="text-gray-500">No hay registros para mostrar</div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
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
                                                <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                                                    <path fill-rule="evenodd"
                                                        d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                            <span class="fw-normal small">Inicio de sesión</span>
                                        </div>
                                        <span class="fw-bold">342</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="icon icon-shape icon-xs icon-shape-success rounded me-2">
                                                <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                            <span class="fw-normal small">Aprobación</span>
                                        </div>
                                        <span class="fw-bold">189</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="icon icon-shape icon-xs icon-shape-info rounded me-2">
                                                <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <span class="fw-normal small">Actualización</span>
                                        </div>
                                        <span class="fw-bold">156</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="icon icon-shape icon-xs icon-shape-success rounded me-2">
                                                <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd"
                                                        d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                            <span class="fw-normal small">Creación</span>
                                        </div>
                                        <span class="fw-bold">124</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="icon icon-shape icon-xs icon-shape-danger rounded me-2">
                                                <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd"
                                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
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
                                            <img class="avatar rounded-circle me-2" alt="Avatar"
                                                src="https://ui-avatars.com/api/?name=Alfonso+Garcia&background=0D8ABC&color=fff">
                                            <div class="d-flex flex-column">
                                                <span class="fw-bold small">Alfonso García</span>
                                                <small class="text-gray-500">Administrador</small>
                                            </div>
                                        </div>
                                        <span class="badge bg-primary">47 acciones</span>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                                        <div class="d-flex align-items-center">
                                            <img class="avatar rounded-circle me-2" alt="Avatar"
                                                src="https://ui-avatars.com/api/?name=Maria+Lopez&background=6F42C1&color=fff">
                                            <div class="d-flex flex-column">
                                                <span class="fw-bold small">María López</span>
                                                <small class="text-gray-500">Secretaria</small>
                                            </div>
                                        </div>
                                        <span class="badge bg-primary">35 acciones</span>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                                        <div class="d-flex align-items-center">
                                            <img class="avatar rounded-circle me-2" alt="Avatar"
                                                src="https://ui-avatars.com/api/?name=Juan+Perez&background=FD7E14&color=fff">
                                            <div class="d-flex flex-column">
                                                <span class="fw-bold small">Juan Pérez</span>
                                                <small class="text-gray-500">Trabajador</small>
                                            </div>
                                        </div>
                                        <span class="badge bg-primary">28 acciones</span>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                                        <div class="d-flex align-items-center">
                                            <img class="avatar rounded-circle me-2" alt="Avatar"
                                                src="https://ui-avatars.com/api/?name=Ana+Rodriguez&background=28A745&color=fff">
                                            <div class="d-flex flex-column">
                                                <span class="fw-bold small">Ana Rodríguez</span>
                                                <small class="text-gray-500">Secretaria</small>
                                            </div>
                                        </div>
                                        <span class="badge bg-primary">21 acciones</span>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <img class="avatar rounded-circle me-2" alt="Avatar"
                                                src="https://ui-avatars.com/api/?name=Carlos+Martinez&background=DC3545&color=fff">
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
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: 62%"
                                                aria-valuenow="62" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between mb-1">
                                            <span class="small">Usuarios</span>
                                            <span class="small fw-bold">48%</span>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: 48%"
                                                aria-valuenow="48" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between mb-1">
                                            <span class="small">Procesos</span>
                                            <span class="small fw-bold">35%</span>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 35%"
                                                aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between mb-1">
                                            <span class="small">Documentos</span>
                                            <span class="small fw-bold">28%</span>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar bg-warning" role="progressbar" style="width: 28%"
                                                aria-valuenow="28" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="d-flex justify-content-between mb-1">
                                            <span class="small">Configuración</span>
                                            <span class="small fw-bold">15%</span>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: 15%"
                                                aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>