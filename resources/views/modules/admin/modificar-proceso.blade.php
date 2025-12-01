{{--
    Company: CETAM
    Project: ST
    File: modificar-proceso.blade.php
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
                            @icon('nav.home', 'icon icon-xxs')
                        </a>
                    </li>
                    <li class="breadcrumb-item">Administracin</li>
                    <li class="breadcrumb-item active" aria-current="page">Modificar proceso</li>
                </ol>
            </nav>
            <h2 class="h4">Modificar proceso</h2>
            <p class="mb-0">Edita o elimina procesos de trmite existentes del sistema.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-xl-8">
            <div class="card card-body shadow border-0 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="h5 mb-0">Seleccionar proceso</h2>
                </div>

                <div class="row mb-4">
                    <div class="col-md-12">
                        <label for="select_process">Proceso a modificar</label>
                        <select class="form-select" id="select_process">
                            <option selected>Seleccionar proceso...</option>
                            <option value="1">SOL-VAC-001 - Solicitud de vacaciones</option>
                            <option value="2">REM-GAS-001 - Reembolso de gastos</option>
                            <option value="3">CAM-PUE-001 - Cambio de puesto</option>
                            <option value="4">PER-AUS-001 - Permiso de ausencia</option>
                            <option value="5">SOL-HOR-001 - Solicitud de horas extras</option>
                        </select>
                        <small class="form-text text-muted">Selecciona el proceso que deseas modificar o eliminar.</small>
                    </div>
                </div>

                <hr class="my-4">

                <h2 class="h5 mb-4">Informacin del proceso</h2>
                <form>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="process_name">Nombre del proceso</label>
                            <input class="form-control" id="process_name" type="text" placeholder="Ej: Solicitud de vacaciones" value="Solicitud de vacaciones">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="process_code">Cdigo del proceso</label>
                            <input class="form-control" id="process_code" type="text" placeholder="Ej: SOL-VAC-001" value="SOL-VAC-001" readonly>
                            <small class="form-text text-muted">El cdigo del proceso no puede ser modificado una vez creado.</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="process_description">Descripcin</label>
                            <textarea class="form-control" id="process_description" rows="4" placeholder="Describe el propsito y alcance del proceso...">Proceso para solicitar das de vacaciones. El trabajador debe especificar las fechas solicitadas y el motivo. Requiere aprobacin del supervisor directo y recursos humanos.</textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="process_category">Categora</label>
                            <select class="form-select" id="process_category">
                                <option>Seleccionar categora</option>
                                <option value="1" selected>Solicitudes</option>
                                <option value="2">Trmites administrativos</option>
                                <option value="3">Recursos humanos</option>
                                <option value="4">Servicios</option>
                                <option value="5">Otros</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="process_priority">Prioridad</label>
                            <select class="form-select" id="process_priority">
                                <option value="low">Baja</option>
                                <option value="medium" selected>Media</option>
                                <option value="high">Alta</option>
                                <option value="urgent">Urgente</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="process_deadline">Tiempo mximo de respuesta (das)</label>
                            <input class="form-control" id="process_deadline" type="number" placeholder="15" min="1" value="15">
                            <small class="form-text text-muted">Das hbiles para completar el proceso.</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="process_department">Departamento responsable</label>
                            <select class="form-select" id="process_department">
                                <option>Seleccionar departamento</option>
                                <option value="1" selected>Recursos Humanos</option>
                                <option value="2">Administracin</option>
                                <option value="3">Operaciones</option>
                                <option value="4">Legal</option>
                            </select>
                        </div>
                    </div>

                    <hr class="my-4">
                    <h2 class="h5 mb-3">Configuracin</h2>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="process_active" checked>
                                <label class="form-check-label" for="process_active">
                                    Proceso activo
                                </label>
                            </div>
                            <small class="form-text text-muted">Los trabajadores podrn iniciar este proceso si est activo.</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="process_notifications" checked>
                                <label class="form-check-label" for="process_notifications">
                                    Enviar notificaciones
                                </label>
                            </div>
                            <small class="form-text text-muted">Notificar automticamente a los usuarios involucrados.</small>
                        </div>
                    </div>

                    <hr class="my-4">
                    <h2 class="h5 mb-3">Estadsticas del proceso</h2>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="card border-light shadow-sm">
                                <div class="card-body text-center">
                                    <h3 class="h5 mb-0">142</h3>
                                    <small class="text-gray">Trmites completados</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card border-light shadow-sm">
                                <div class="card-body text-center">
                                    <h3 class="h5 mb-0">23</h3>
                                    <small class="text-gray">Trmites en proceso</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card border-light shadow-sm">
                                <div class="card-body text-center">
                                    <h3 class="h5 mb-0">8.5 das</h3>
                                    <small class="text-gray">Tiempo promedio</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row align-items-center mt-4">
                        <div class="col">
                            <button class="btn btn-gray-800 mt-2 animate-up-2" type="submit">
                                <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                Guardar cambios
                            </button>
                            <a href="#" class="btn btn-link text-gray-700 ms-2">Cancelar</a>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-danger mt-2" type="button" data-bs-toggle="modal" data-bs-target="#deleteProcessModal">
                                <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                Eliminar proceso
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-12 col-xl-4">
            <div class="card card-body shadow border-0 mb-4">
                <h2 class="h5 mb-4">
                    <svg class="icon icon-xs me-2 text-warning" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                    Advertencia
                </h2>
                <div class="alert alert-warning" role="alert">
                    <div class="d-flex align-items-start">
                        <div>
                            <h3 class="h6 mb-2">Eliminar proceso</h3>
                            <p class="small mb-0">
                                Al eliminar un proceso, se eliminar permanentemente toda la configuracin asociada,
                                incluyendo los pasos definidos. <strong>Los trmites activos no se vern afectados</strong>,
                                pero no podrn iniciarse nuevos trmites con este proceso.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-body shadow border-0 mb-4">
                <h2 class="h5 mb-4">Ayuda</h2>
                <div class="mb-3">
                    <h3 class="h6 mb-2">
                        <svg class="icon icon-xs me-1 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg>
                        Modificar informacin
                    </h3>
                    <p class="small text-gray-700">Puedes cambiar cualquier campo del proceso excepto el cdigo, que es nico y permanente.</p>
                </div>
                <div class="mb-3">
                    <h3 class="h6 mb-2">
                        <svg class="icon icon-xs me-1 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg>
                        Desactivar vs Eliminar
                    </h3>
                    <p class="small text-gray-700">Si solo deseas pausar temporalmente el proceso, desmarca la opcin "Proceso activo" en lugar de eliminarlo.</p>
                </div>
                <div>
                    <h3 class="h6 mb-2">
                        <svg class="icon icon-xs me-1 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg>
                        Modificar pasos
                    </h3>
                    <p class="small text-gray-700">Para modificar los pasos del proceso, dirgete a la seccin "Definir pasos" en el men de administracin.</p>
                </div>
            </div>

            <div class="card border-0 shadow">
                <div class="card-body">
                    <h2 class="h6 mb-3">Actividad reciente</h2>
                    <ul class="list-group list-group-flush list my--3">
                        <li class="list-group-item px-0">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="badge bg-tertiary text-dark">23/10/2025</span>
                                </div>
                                <div class="col">
                                    <small class="text-gray-700">ltima modificacin</small>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="badge bg-tertiary text-dark">15/09/2025</span>
                                </div>
                                <div class="col">
                                    <small class="text-gray-700">Proceso creado</small>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="badge bg-primary">Alfonso Garca</span>
                                </div>
                                <div class="col">
                                    <small class="text-gray-700">Creado por</small>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal de confirmacin para eliminar proceso --}}
    <div class="modal fade" id="deleteProcessModal" tabindex="-1" aria-labelledby="deleteProcessModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="deleteProcessModalLabel">
                        <svg class="icon icon-sm me-2 text-danger" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                        Confirmar eliminacin
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-3">
                        Ests seguro de que deseas eliminar el proceso <strong>"Solicitud de vacaciones (SOL-VAC-001)"</strong>?
                    </p>
                    <div class="alert alert-danger" role="alert">
                        <strong>Esta accin no se puede deshacer.</strong> Se eliminar toda la configuracin y los pasos definidos para este proceso.
                    </div>
                    <p class="small text-gray-700 mb-0">
                        Los trmites activos seguirn existiendo, pero no se podrn iniciar nuevos trmites con este proceso.
                    </p>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-link text-gray-600" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger">
                        <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                        Eliminar proceso
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
