{{--
Company: CETAM
Project: ST
File: mis-datos.blade.php
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
    <div class="py-4">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item">
                    <a href="#">
                        @icon('home', 'fa-xs')
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Mis datos</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Mis datos personales</h1>
                <p class="mb-0">Consulta y actualiza tu información personal</p>
            </div>
        </div>
    </div>

    {{-- Info alert --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-info d-flex align-items-center" role="alert">
                <svg class="icon icon-sm me-2" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                        clip-rule="evenodd"></path>
                </svg>
                <div>
                    <strong>Nota:</strong> Algunos campos no pueden ser modificados directamente. Si
                    necesitas actualizar información crítica, contacta al área de Recursos Humanos.
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Left column --}}
        <div class="col-12 col-lg-8">
            {{-- Personal information --}}
            <div class="card border-0 shadow mb-4">
                <div class="card-header border-bottom">
                    <h2 class="fs-5 fw-bold mb-0">Información personal</h2>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label fw-bold">Nombre(s) *</label>
                                <input type="text" class="form-control" id="nombre" value="Juan Carlos" readonly>
                                <small class="form-text text-muted">Campo no editable</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="apellido_paterno" class="form-label fw-bold">Apellido paterno
                                    *</label>
                                <input type="text" class="form-control" id="apellido_paterno" value="Pérez"
                                    readonly>
                                <small class="form-text text-muted">Campo no editable</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="apellido_materno" class="form-label fw-bold">Apellido materno
                                    *</label>
                                <input type="text" class="form-control" id="apellido_materno" value="García"
                                    readonly>
                                <small class="form-text text-muted">Campo no editable</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="curp" class="form-label fw-bold">CURP *</label>
                                <input type="text" class="form-control font-monospace" id="curp"
                                    value="PEGJ850315HMCRR01" readonly>
                                <small class="form-text text-muted">Campo no editable</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="rfc" class="form-label fw-bold">RFC *</label>
                                <input type="text" class="form-control font-monospace" id="rfc"
                                    value="PEGJ850315ABC" readonly>
                                <small class="form-text text-muted">Campo no editable</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="sexo" class="form-label fw-bold">Sexo *</label>
                                <select class="form-select" id="sexo" disabled>
                                    <option value="M" selected>Masculino</option>
                                    <option value="F">Femenino</option>
                                </select>
                                <small class="form-text text-muted">Campo no editable</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="fecha_nacimiento" class="form-label fw-bold">Fecha de nacimiento
                                    *</label>
                                <input type="date" class="form-control" id="fecha_nacimiento" value="1985-03-15"
                                    readonly>
                                <small class="form-text text-muted">Campo no editable</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="estado_civil" class="form-label fw-bold">Estado civil</label>
                                <select class="form-select" id="estado_civil">
                                    <option value="soltero">Soltero/a</option>
                                    <option value="casado" selected>Casado/a</option>
                                    <option value="divorciado">Divorciado/a</option>
                                    <option value="viudo">Viudo/a</option>
                                    <option value="union_libre">Unión libre</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Contact information --}}
            <div class="card border-0 shadow mb-4">
                <div class="card-header border-bottom">
                    <h2 class="fs-5 fw-bold mb-0">Información de contacto</h2>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="telefono" class="form-label fw-bold">Teléfono personal</label>
                                <input type="tel" class="form-control" id="telefono" value="(312) 123-4567"
                                    placeholder="(312) 123-4567">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="telefono_emergencia" class="form-label fw-bold">Teléfono de
                                    emergencia</label>
                                <input type="tel" class="form-control" id="telefono_emergencia"
                                    value="(312) 987-6543" placeholder="(312) 987-6543">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="email" class="form-label fw-bold">Correo electrónico
                                    institucional *</label>
                                <input type="email" class="form-control" id="email"
                                    value="juan.perez@cetam.gob.mx" readonly>
                                <small class="form-text text-muted">Campo no editable</small>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="email_personal" class="form-label fw-bold">Correo electrónico
                                    personal</label>
                                <input type="email" class="form-control" id="email_personal"
                                    value="jcperez@gmail.com" placeholder="correo@institucion.com">
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Address --}}
            <div class="card border-0 shadow mb-4">
                <div class="card-header border-bottom">
                    <h2 class="fs-5 fw-bold mb-0">Domicilio</h2>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="calle" class="form-label fw-bold">Calle</label>
                                <input type="text" class="form-control" id="calle" value="Av. Tecnológico"
                                    placeholder="Nombre de la calle">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="numero_exterior" class="form-label fw-bold">Núm.
                                    exterior</label>
                                <input type="text" class="form-control" id="numero_exterior" value="544"
                                    placeholder="123">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="numero_interior" class="form-label fw-bold">Núm.
                                    interior</label>
                                <input type="text" class="form-control" id="numero_interior"
                                    placeholder="A, B, 1">
                            </div>
                            <div class="col-md-8 mb-3">
                                <label for="colonia" class="form-label fw-bold">Colonia</label>
                                <input type="text" class="form-control" id="colonia" value="Centro"
                                    placeholder="Nombre de la colonia">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="codigo_postal" class="form-label fw-bold">Código postal</label>
                                <input type="text" class="form-control" id="codigo_postal" value="28000"
                                    placeholder="28000">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="municipio" class="form-label fw-bold">Municipio</label>
                                <input type="text" class="form-control" id="municipio" value="Colima"
                                    placeholder="Municipio">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="estado" class="form-label fw-bold">Estado</label>
                                <select class="form-select" id="estado">
                                    <option value="">Seleccionar...</option>
                                    <option value="COL" selected>Colima</option>
                                    <option value="JAL">Jalisco</option>
                                    <option value="MICH">Michoacán</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Plazas presupuestales --}}
            <div class="card border-0 shadow mb-4">
                <div class="card-header border-bottom">
                    <h2 class="fs-5 fw-bold mb-0">Plazas presupuestales</h2>
                </div>
                <div class="table-responsive">
                    <table class="table table-centered table-nowrap mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th class="border-0">Clave presupuestal</th>
                                <th class="border-0">Tipo</th>
                                <th class="border-0">Departamento</th>
                                <th class="border-0">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="font-monospace fw-bold">CP-2025-001</td>
                                <td>Base</td>
                                <td>Recursos Humanos</td>
                                <td><span class="badge bg-success">Activa</span></td>
                            </tr>
                            <tr>
                                <td class="font-monospace fw-bold">CP-2024-156</td>
                                <td>Interinato</td>
                                <td>Administrativo</td>
                                <td><span class="badge bg-warning">Temporal</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer border-0 text-muted small">
                    <strong>Nota:</strong> Para cambios en tus plazas presupuestales, contacta a Recursos
                    Humanos.
                </div>
            </div>

            {{-- Save buttons --}}
            <div class="card border-0 shadow">
                <div class="card-body d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-outline-gray-600">
                        <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Descartar cambios
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Guardar cambios
                    </button>
                </div>
            </div>
        </div>

        {{-- Right column --}}
        <div class="col-12 col-lg-4">
            {{-- Profile photo --}}
            <div class="card border-0 shadow mb-4">
                <div class="card-header border-bottom">
                    <h2 class="fs-5 fw-bold mb-0">Foto de perfil</h2>
                </div>
                <div class="card-body text-center">
                    <img src="https://ui-avatars.com/api/?name=Juan+Perez&size=150&background=0D8ABC&color=fff"
                        alt="Foto de perfil" class="rounded-circle mb-3" width="150" height="150">
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-sm btn-primary">
                            <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Cambiar foto
                        </button>
                        <small class="text-muted">Formatos: JPG, PNG. Máx. 2MB</small>
                    </div>
                </div>
            </div>

            {{-- Account info --}}
            <div class="card border-0 shadow mb-4">
                <div class="card-header border-bottom">
                    <h2 class="fs-5 fw-bold mb-0">Información de cuenta</h2>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-gray-600 fw-bold d-block mb-1">Número de empleado</small>
                        <p class="mb-0 font-monospace">EMP-2025-001</p>
                    </div>
                    <div class="mb-3">
                        <small class="text-gray-600 fw-bold d-block mb-1">Fecha de ingreso</small>
                        <p class="mb-0">15/01/2020</p>
                    </div>
                    <div class="mb-3">
                        <small class="text-gray-600 fw-bold d-block mb-1">Antigüedad</small>
                        <p class="mb-0">5 años, 9 meses</p>
                    </div>
                    <div>
                        <small class="text-gray-600 fw-bold d-block mb-1">Tipo de contrato</small>
                        <p class="mb-0">Base</p>
                    </div>
                </div>
            </div>

            {{-- Security --}}
            <div class="card border-0 shadow">
                <div class="card-header border-bottom">
                    <h2 class="fs-5 fw-bold mb-0">Seguridad</h2>
                </div>
                <div class="card-body">
                    <p class="small text-gray-700 mb-3">Mantén tu cuenta segura actualizando tu contraseña
                        regularmente.</p>
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-outline-primary btn-sm">
                            <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Cambiar contraseña
                        </button>
                    </div>
                    <small class="text-muted d-block mt-2">Última actualización: 15/10/2025</small>
                </div>
            </div>
        </div>
    </div>
</div>
