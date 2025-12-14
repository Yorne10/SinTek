{{--
Company: CETAM
Project: ST
File: footer.blade.php
Created on: 05/11/2025
Created by: Alfonso Angel Garcia Hernandez
Approved by: Alfonso Angel Garcia Hernandez

Changelog:
- ID: <ID> | Date: dd/mm/yyyy
    Modified by: <Developer name>
    Description: <Brief description of change>
--}}
<footer class="bg-white rounded shadow p-5 mb-4 mt-4">
    <div class="row">
        <div class="col-12 col-md-4 col-xl-6 mb-4 mb-md-0">
            <p class="mb-0 text-center text-lg-start">© <span class="current-year"></span> <a
                    class="text-primary fw-normal" href="#">{{ config('app.name', 'SinTek') }}</a> - Sistema
                de Gestión de Trámites</p>
            <p class="mb-0 text-center text-lg-start small text-muted mt-2">
                Contacto: {{ config('app.contact_email', 'contacto@cetam.gob.mx') }} |
                Tel: {{ config('app.contact_phone', '(999) 999-9999') }}
            </p>
        </div>
        <div class="col-12 col-md-8 col-xl-6 text-center text-lg-start">
            <ul class="list-inline list-group-flush list-group-borderless text-md-end mb-0">
                <li class="list-inline-item px-0 px-sm-2">
                    <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.faq') }}">Preguntas
                        frecuentes</a>
                </li>
            </ul>
        </div>
    </div>
</footer>
