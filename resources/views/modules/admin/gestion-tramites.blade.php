{{--
    Company: CETAM
    Project: ST
    File: gestion-tramites.blade.php
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
            <h2 class="h4">Gestión de trámites</h2>
            <p class="mb-0">Crea y administra los procesos disponibles para los trabajadores.</p>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <button class="btn btn-sm btn-gray-800 d-inline-flex align-items-center" disabled>
                <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Nuevo trámite
            </button>
        </div>
    </div>

    <div class="card card-body shadow border-0 table-wrapper table-responsive">
        <table class="table user-table table-hover align-items-center">
            <thead>
                <tr>
                    <th class="border-bottom">Trámite</th>
                    <th class="border-bottom">Categoría</th>
                    <th class="border-bottom">Estado</th>
                    <th class="border-bottom">Solicitudes activas</th>
                    <th class="border-bottom">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">
                        No hay trámites configurados
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
