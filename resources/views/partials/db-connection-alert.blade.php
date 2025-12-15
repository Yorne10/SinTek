{{--
Company: CETAM
Project: ST
File: db-connection-alert.blade.php
Created on: 14/12/2024
Created by: Alfonso Angel Garcia Hernandez
Approved by: Alfonso Angel Garcia Hernandez

Changelog:
- ID: <ID> | Date: dd/mm/yyyy
    Modified by: <Developer name>
    Description: <Brief description of change>
--}}

@if (session('db_error'))
    <div class="alert alert-danger d-flex align-items-center mb-3" role="alert">
        <svg class="icon icon-xs me-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                clip-rule="evenodd"></path>
        </svg>
        <div>
            <strong>Error de conexión:</strong> {{ session('db_error') }}
        </div>
    </div>
@endif
