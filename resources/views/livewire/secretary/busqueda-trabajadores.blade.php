{{--
 * Company: CETAM
 * Project: ST
 * File: busqueda-trabajadores.blade.php
 * Created on: 04/11/2025
 * Created by: Alfonso Angel García Hernández
 * Approved by: Alfonso Angel García Hernández
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

{{-- Nota Livewire: esta vista debe tener UN único elemento raíz --}}
{{-- El layout se aplica desde el componente con ->layout('layouts.app') --}}

<div>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item">
                        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.dashboard.index') }}">
                            <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                        </a>
                    </li>
                    <li class="breadcrumb-item">Secretaría</li>
                    <li class="breadcrumb-item active" aria-current="page">Búsqueda de trabajadores</li>
                </ol>
            </nav>
            <h2 class="h4">Búsqueda de trabajadores</h2>
            <p class="mb-0">Busca trabajadores por diferentes criterios y consulta su historial.</p>
        </div>
    </div>

    <div class="card border-0 shadow mb-4">
        <div class="card-header border-bottom">
            <h2 class="fs-5 fw-bold mb-0">Filtros de búsqueda</h2>
        </div>
        <div class="card-body">
            <form>
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="search_nombre" class="form-label">Nombre completo</label>
                        <input type="text" class="form-control" id="search_nombre" placeholder="Ej: Juan Pérez">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="search_curp" class="form-label">CURP</label>
                        <input type="text" class="form-control" id="search_curp" placeholder="18 caracteres" maxlength="18">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="search_rfc" class="form-label">RFC</label>
                        <input type="text" class="form-control" id="search_rfc" placeholder="13 caracteres" maxlength="13">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="search_clave" class="form-label">Clave presupuestal</label>
                        <input type="text" class="form-control" id="search_clave" placeholder="Ej: CP-2025-001">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="search_departamento" class="form-label">Departamento</label>
                        <select class="form-select" id="search_departamento">
                            <option value="" selected>Todos</option>
                            <option value="rh">Recursos Humanos</option>
                            <option value="admin">Administración</option>
                            <option value="ops">Operaciones</option>
                            <option value="legal">Legal</option>
                            <option value="ti">Tecnología</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="search_status" class="form-label">Estado</label>
                        <select class="form-select" id="search_status">
                            <option value="" selected>Todos</option>
                            <option value="activo">Activo</option>
                            <option value="inactivo">Inactivo</option>
                            <option value="suspendido">Suspendido</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">&nbsp;</label>
                        <button type="submit" class="btn btn-cetam-primary w-100">
                            <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                            Buscar
                        </button>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">&nbsp;</label>
                        <button type="button" class="btn btn-outline-gray-600 w-100">
                            <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"></path></svg>
                            Limpiar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow">
        <div class="card-header border-bottom d-flex justify-content-between align-items-center">
            <h2 class="fs-5 fw-bold mb-0">Resultados de búsqueda</h2>
            <button type="button" class="btn btn-sm btn-outline-gray-600">
                <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                Exportar Excel
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-centered table-hover table-nowrap mb-0 rounded">
                    <thead class="thead-light">
                        <tr>
                            <th class="border-0 rounded-start">Trabajador</th>
                            <th class="border-0">CURP</th>
                            <th class="border-0">RFC</th>
                            <th class="border-0">Clave presupuestal</th>
                            <th class="border-0">Departamento</th>
                            <th class="border-0">Estado</th>
                            <th class="border-0 rounded-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img class="avatar rounded-circle me-2" alt="Avatar" src="https://ui-avatars.com/api/?name=Juan+Perez&background=0D8ABC&color=fff">
                                    <div>
                                        <p class="mb-0 fw-bold">Juan Pérez García</p>
                                        <small class="text-gray-500">juan.perez@cetam.gob.mx</small>
                                    </div>
                                </div>
                            </td>
                            <td><span class="font-monospace small">PEGJ850315HMCRR01</span></td>
                            <td><span class="font-monospace small">PEGJ850315ABC</span></td>
                            <td class="fw-bold">CP-2025-001</td>
                            <td>Recursos Humanos</td>
                            <td><span class="badge bg-success">Activo</span></td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-primary" type="button">
                                        <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path></svg>
                                        Historial
                                    </button>
                                    <button type="button" class="btn btn-sm btn-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="visually-hidden">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">Ver perfil completo</a></li>
                                        <li><a class="dropdown-item" href="#">Ver documentos</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="#">Editar información</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img class="avatar rounded-circle me-2" alt="Avatar" src="https://ui-avatars.com/api/?name=Maria+Lopez&background=6F42C1&color=fff">
                                    <div>
                                        <p class="mb-0 fw-bold">María López Sánchez</p>
                                        <small class="text-gray-500">maria.lopez@cetam.gob.mx</small>
                                    </div>
                                </div>
                            </td>
                            <td><span class="font-monospace small">LOSM900521MDFPNR09</span></td>
                            <td><span class="font-monospace small">LOSM900521XYZ</span></td>
                            <td class="fw-bold">CP-2025-012</td>
                            <td>Administración</td>
                            <td><span class="badge bg-success">Activo</span></td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-primary" type="button">
                                        <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path></svg>
                                        Historial
                                    </button>
                                    <button type="button" class="btn btn-sm btn-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="visually-hidden">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">Ver perfil completo</a></li>
                                        <li><a class="dropdown-item" href="#">Ver documentos</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="#">Editar información</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img class="avatar rounded-circle me-2" alt="Avatar" src="https://ui-avatars.com/api/?name=Carlos+Martinez&background=FD7E14&color=fff">
                                    <div>
                                        <p class="mb-0 fw-bold">Carlos Martínez Ruiz</p>
                                        <small class="text-gray-500">carlos.martinez@cetam.gob.mx</small>
                                    </div>
                                </div>
                            </td>
                            <td><span class="font-monospace small">MARC880712HDFRRL05</span></td>
                            <td><span class="font-monospace small">MARC880712DEF</span></td>
                            <td class="fw-bold">CP-2025-023</td>
                            <td>Operaciones</td>
                            <td><span class="badge bg-success">Activo</span></td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-primary" type="button">
                                        <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path></svg>
                                        Historial
                                    </button>
                                    <button type="button" class="btn btn-sm btn-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="visually-hidden">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">Ver perfil completo</a></li>
                                        <li><a class="dropdown-item" href="#">Ver documentos</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="#">Editar información</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img class="avatar rounded-circle me-2" alt="Avatar" src="https://ui-avatars.com/api/?name=Ana+Rodriguez&background=28A745&color=fff">
                                    <div>
                                        <p class="mb-0 fw-bold">Ana Rodríguez Torres</p>
                                        <small class="text-gray-500">ana.rodriguez@cetam.gob.mx</small>
                                    </div>
                                </div>
                            </td>
                            <td><span class="font-monospace small">ROTA920403MDFDRN02</span></td>
                            <td><span class="font-monospace small">ROTA920403GHI</span></td>
                            <td class="fw-bold">CP-2025-034</td>
                            <td>Legal</td>
                            <td><span class="badge bg-success">Activo</span></td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-primary" type="button">
                                        <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path></svg>
                                        Historial
                                    </button>
                                    <button type="button" class="btn btn-sm btn-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="visually-hidden">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">Ver perfil completo</a></li>
                                        <li><a class="dropdown-item" href="#">Ver documentos</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="#">Editar información</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img class="avatar rounded-circle me-2" alt="Avatar" src="https://ui-avatars.com/api/?name=Luis+Gomez&background=DC3545&color=fff">
                                    <div>
                                        <p class="mb-0 fw-bold">Luis Gómez Hernández</p>
                                        <small class="text-gray-500">luis.gomez@cetam.gob.mx</small>
                                    </div>
                                </div>
                            </td>
                            <td><span class="font-monospace small">GOHL860228HDFMRS08</span></td>
                            <td><span class="font-monospace small">GOHL860228JKL</span></td>
                            <td class="fw-bold">CP-2025-045</td>
                            <td>Tecnología</td>
                            <td><span class="badge bg-warning">Suspendido</span></td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-primary" type="button">
                                        <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path></svg>
                                        Historial
                                    </button>
                                    <button type="button" class="btn btn-sm btn-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="visually-hidden">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">Ver perfil completo</a></li>
                                        <li><a class="dropdown-item" href="#">Ver documentos</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="#">Editar información</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
                <nav aria-label="Page navigation">
                    <ul class="pagination mb-0">
                        <li class="page-item">
                            <a class="page-link" href="#">Anterior</a>
                        </li>
                        <li class="page-item active">
                            <a class="page-link" href="#">1</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">3</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">Siguiente</a>
                        </li>
                    </ul>
                </nav>
                <div class="fw-normal small mt-4 mt-lg-0">
                    Mostrando <b>5</b> de <b>142</b> trabajadores
                </div>
            </div>
        </div>
    </div>
</div>
