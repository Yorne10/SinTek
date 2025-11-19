{{--
 * Company: CETAM
 * Project: ST
 * File: convocatorias-documentos.blade.php
 * Created on: 04/11/2025
 * Created by: Alfonso Angel García Hernández
 * Approved by: Alfonso Angel García Hernández
 *
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
--}}
<div>
    {{-- Page Header --}}
    <div class="py-4">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item">
                    <a href="#">
                        <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                    </a>
                </li>
                <li class="breadcrumb-item"><a href="#">Secretaría</a></li>
                <li class="breadcrumb-item active" aria-current="page">Gestión de convocatorias y documentos</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Gestión de convocatorias y documentos</h1>
                <p class="mb-0">Administra las convocatorias públicas y documentos institucionales</p>
            </div>
        </div>
    </div>

    {{-- Form for creating/editing convocatorias --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <h2 class="fs-5 fw-bold mb-0">Nueva convocatoria</h2>
                    <button type="button" class="btn btn-sm btn-outline-gray-600">
                        <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        Cancelar
                    </button>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="titulo" class="form-label fw-bold">Título de la convocatoria *</label>
                                <input type="text" class="form-control" id="titulo" placeholder="Ej: Convocatoria para plaza de coordinador administrativo">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="descripcion" class="form-label fw-bold">Descripción *</label>
                                <textarea class="form-control" id="descripcion" rows="4" placeholder="Ingrese una descripción detallada de la convocatoria..."></textarea>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="fecha_inicio" class="form-label fw-bold">Fecha de inicio *</label>
                                <input type="date" class="form-control" id="fecha_inicio">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="fecha_fin" class="form-label fw-bold">Fecha de fin *</label>
                                <input type="date" class="form-control" id="fecha_fin">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="documento_convocatoria" class="form-label fw-bold">Documento de la convocatoria (PDF)</label>
                                <input type="file" class="form-control" id="documento_convocatoria" accept=".pdf">
                                <small class="form-text text-muted">Formato permitido: PDF. Tamaño máximo: 5MB</small>
                            </div>

                            <div class="col-md-12 d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-outline-gray-600">Limpiar</button>
                                <button type="submit" class="btn btn-cetam-primary">
                                    <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
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

    {{-- List of existing convocatorias --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fs-5 fw-bold mb-0">Convocatorias publicadas</h2>
                        <p class="small text-gray-500 mb-0 mt-1">Listado de convocatorias activas y pasadas</p>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-outline-cetam-primary">
                            <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd"></path>
                            </svg>
                            Filtrar
                        </button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-centered table-nowrap mb-0 rounded">
                        <thead class="thead-light">
                            <tr>
                                <th class="border-0">Título</th>
                                <th class="border-0">Descripción</th>
                                <th class="border-0">Fecha inicio</th>
                                <th class="border-0">Fecha fin</th>
                                <th class="border-0">Estado</th>
                                <th class="border-0">Documento</th>
                                <th class="border-0">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Sample convocatoria 1 --}}
                            <tr>
                                <td class="fw-bold">Convocatoria para plaza de coordinador administrativo</td>
                                <td>
                                    <p class="small text-gray-700 mb-0">Se convoca a participar en el proceso de selección para el puesto de coordinador del área administrativa...</p>
                                </td>
                                <td>01/11/2025</td>
                                <td>15/11/2025</td>
                                <td><span class="badge bg-success">Activa</span></td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-link text-primary p-0">
                                        <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd"></path>
                                        </svg>
                                        Ver PDF
                                    </a>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-outline-cetam-primary" type="button">
                                            <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                            </svg>
                                            Editar
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-cetam-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span class="visually-hidden">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#">Ver detalles</a></li>
                                            <li><a class="dropdown-item" href="#">Duplicar</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item text-danger" href="#">Desactivar</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>

                            {{-- Sample convocatoria 2 --}}
                            <tr>
                                <td class="fw-bold">Convocatoria de becas académicas 2025</td>
                                <td>
                                    <p class="small text-gray-700 mb-0">El CETAM convoca a los trabajadores a participar en el programa de becas para estudios de posgrado...</p>
                                </td>
                                <td>15/10/2025</td>
                                <td>31/10/2025</td>
                                <td><span class="badge bg-secondary">Cerrada</span></td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-link text-primary p-0">
                                        <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd"></path>
                                        </svg>
                                        Ver PDF
                                    </a>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-outline-cetam-primary" type="button">
                                            <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                            </svg>
                                            Editar
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-cetam-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span class="visually-hidden">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#">Ver detalles</a></li>
                                            <li><a class="dropdown-item" href="#">Duplicar</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item text-warning" href="#">Reactivar</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>

                            {{-- Sample convocatoria 3 --}}
                            <tr>
                                <td class="fw-bold">Proceso de promoción interna 2025</td>
                                <td>
                                    <p class="small text-gray-700 mb-0">Se informa a los trabajadores sobre el proceso de promoción interna para el ejercicio 2025...</p>
                                </td>
                                <td>20/11/2025</td>
                                <td>15/12/2025</td>
                                <td><span class="badge bg-warning">Próxima</span></td>
                                <td>
                                    <span class="small text-gray-500">Sin documento</span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-outline-cetam-primary" type="button">
                                            <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                            </svg>
                                            Editar
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-cetam-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span class="visually-hidden">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#">Ver detalles</a></li>
                                            <li><a class="dropdown-item" href="#">Duplicar</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item text-danger" href="#">Desactivar</a></li>
                                        </ul>
                                    </div>
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
                            <li class="page-item active">
                                <a class="page-link" href="#">1</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">2</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">Siguiente</a>
                            </li>
                        </ul>
                    </nav>
                    <div class="fw-normal small mt-4 mt-lg-0">Mostrando <b>3</b> de <b>8</b> convocatorias</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Section for reglamentos y manuales --}}
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fs-5 fw-bold mb-0">Reglamentos y manuales institucionales</h2>
                        <p class="small text-gray-500 mb-0 mt-1">Documentos normativos y de consulta</p>
                    </div>
                    <button type="button" class="btn btn-sm btn-cetam-primary">
                        <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"></path>
                        </svg>
                        Subir documento
                    </button>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        {{-- Document 1 --}}
                        <div class="list-group-item d-flex align-items-center justify-content-between px-0">
                            <div class="d-flex align-items-center">
                                <div class="icon-shape icon-md icon-shape-danger rounded me-3">
                                    <svg class="icon icon-sm" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="h6 mb-1">Reglamento Interior de Trabajo</h3>
                                    <p class="small text-gray-500 mb-0">Subido el 15/01/2025 • 1.2 MB • <span class="badge bg-primary">Vigente</span></p>
                                </div>
                            </div>
                            <div class="btn-group">
                                <a href="#" class="btn btn-sm btn-outline-cetam-primary">
                                    <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                    Descargar
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-cetam-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="visually-hidden">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Ver documento</a></li>
                                    <li><a class="dropdown-item" href="#">Historial de versiones</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="#">Reemplazar archivo</a></li>
                                    <li><a class="dropdown-item text-danger" href="#">Archivar</a></li>
                                </ul>
                            </div>
                        </div>

                        {{-- Document 2 --}}
                        <div class="list-group-item d-flex align-items-center justify-content-between px-0">
                            <div class="d-flex align-items-center">
                                <div class="icon-shape icon-md icon-shape-danger rounded me-3">
                                    <svg class="icon icon-sm" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="h6 mb-1">Manual de Procedimientos de Recursos Humanos</h3>
                                    <p class="small text-gray-500 mb-0">Subido el 20/02/2025 • 3.5 MB • <span class="badge bg-primary">Vigente</span></p>
                                </div>
                            </div>
                            <div class="btn-group">
                                <a href="#" class="btn btn-sm btn-outline-cetam-primary">
                                    <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                    Descargar
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-cetam-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="visually-hidden">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Ver documento</a></li>
                                    <li><a class="dropdown-item" href="#">Historial de versiones</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="#">Reemplazar archivo</a></li>
                                    <li><a class="dropdown-item text-danger" href="#">Archivar</a></li>
                                </ul>
                            </div>
                        </div>

                        {{-- Document 3 --}}
                        <div class="list-group-item d-flex align-items-center justify-content-between px-0">
                            <div class="d-flex align-items-center">
                                <div class="icon-shape icon-md icon-shape-danger rounded me-3">
                                    <svg class="icon icon-sm" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="h6 mb-1">Código de Ética Institucional</h3>
                                    <p class="small text-gray-500 mb-0">Subido el 10/01/2025 • 850 KB • <span class="badge bg-primary">Vigente</span></p>
                                </div>
                            </div>
                            <div class="btn-group">
                                <a href="#" class="btn btn-sm btn-outline-cetam-primary">
                                    <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                    Descargar
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-cetam-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="visually-hidden">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Ver documento</a></li>
                                    <li><a class="dropdown-item" href="#">Historial de versiones</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="#">Reemplazar archivo</a></li>
                                    <li><a class="dropdown-item text-danger" href="#">Archivar</a></li>
                                </ul>
                            </div>
                        </div>

                        {{-- Document 4 --}}
                        <div class="list-group-item d-flex align-items-center justify-content-between px-0">
                            <div class="d-flex align-items-center">
                                <div class="icon-shape icon-md icon-shape-secondary rounded me-3">
                                    <svg class="icon icon-sm" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="h6 mb-1">Lineamientos de Seguridad e Higiene 2024</h3>
                                    <p class="small text-gray-500 mb-0">Subido el 05/08/2024 • 2.1 MB • <span class="badge bg-secondary">Archivado</span></p>
                                </div>
                            </div>
                            <div class="btn-group">
                                <a href="#" class="btn btn-sm btn-outline-secondary">
                                    <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                    Descargar
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="visually-hidden">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Ver documento</a></li>
                                    <li><a class="dropdown-item" href="#">Historial de versiones</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="#">Restaurar</a></li>
                                    <li><a class="dropdown-item text-danger" href="#">Eliminar permanentemente</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer px-3 border-0 d-flex justify-content-between align-items-center">
                    <div class="fw-normal small">Mostrando <b>4</b> de <b>12</b> documentos</div>
                    <a href="#" class="btn btn-sm btn-link text-primary">Ver todos los documentos</a>
                </div>
            </div>
        </div>
    </div>
</div>
