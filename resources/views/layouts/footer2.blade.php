{{--
Company: CETAM
Project: ST
File: footer2.blade.php
Created on: 05/11/2025
Created by: Alfonso Angel Garcia Hernandez
Approved by: Alfonso Angel Garcia Hernandez

Changelog:
- ID: <ID> | Date: dd/mm/yyyy
    Modified by: <Developer name>
    Description: <Brief description of change>
--}}
<footer class="p-5 mb-4">
    <div class="container">
        <div class="col-12 d-flex align-items-center justify-content-center">
            <div class="col-12 col-md-8 mb-4 mb-md-0 text-lg-center">
                <ul class="list-inline list-group-flush list-group-borderless">
                    <li class="list-inline-item px-0 px-sm-2">
                        <a href="#">Términos de uso</a>
                    </li>
                    <li class="list-inline-item px-0 px-sm-2">
                        <a href="#">Aviso de privacidad</a>
                    </li>
                    <li class="list-inline-item px-0 px-sm-2">
                        <a href="#">Soporte técnico</a>
                    </li>
                </ul>
                <p class="mb-0 text-center">© <span class="current-year"></span> <a class="text-primary fw-normal"
                        href="#">{{ config('app.name', 'SinTek') }}</a>
                    - Sistema de Gestión de Trámites</p>
                <p class="mb-0 text-center small text-muted mt-2">
                    Contacto: {{ config('app.contact_email', 'contacto@cetam.gob.mx') }} |
                    Tel: {{ config('app.contact_phone', '(999) 999-9999') }}
                </p>
            </div>
        </div>
    </div>
</footer>
