{{--
    Company: CETAM
    Project: ST
    File: solicitudes.blade.php
    Created on: 03/11/2025
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
            <h2 class="h4">Solicitudes</h2>
            <p class="mb-0">Revisa, aprueba o rechaza las solicitudes de los trabajadores.</p>
        </div>
    </div>

    <div class="table-settings mb-4">
        <div class="row justify-content-between align-items-center">
            <div class="col-9 col-lg-8 d-md-flex">
                <div class="input-group me-2 me-lg-3 fmxw-300">
                    <span class="input-group-text">
                        <svg class="icon icon-xs" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                        </svg>
                    </span>
                    <input type="text" class="form-control" placeholder="Buscar solicitudes">
                </div>
                <select class="form-select fmxw-200 d-none d-md-inline">
                    <option selected>Todos</option>
                    <option value="1">Pendientes</option>
                    <option value="2">Aprobadas</option>
                    <option value="3">Rechazadas</option>
                </select>
            </div>
        </div>
    </div>

    <div class="card card-body shadow border-0 table-wrapper table-responsive">
        <table class="table user-table table-hover align-items-center">
            <thead>
                <tr>
                    <th class="border-bottom">Folio</th>
                    <th class="border-bottom">Trabajador</th>
                    <th class="border-bottom">Trámite</th>
                    <th class="border-bottom">Fecha</th>
                    <th class="border-bottom">Estado</th>
                    <th class="border-bottom">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        No hay solicitudes pendientes
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
