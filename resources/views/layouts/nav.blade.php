{{--
Company: CETAM
Project: ST
File: nav.blade.php
Created on: 02/11/2025
Created by: Alfonso Angel Garcia Hernandez
Approved by: Alfonso Angel Garcia Hernandez

Changelog:
- ID: <ID> | Date: dd/mm/yyyy
    Modified by: <Developer name>
    Description: <Brief description of change>
--}}
<nav class="navbar navbar-dark navbar-theme-primary px-4 col-12 d-md-none">
    <a class="navbar-brand me-lg-5" href="/index.html">
        <img class="navbar-brand-dark" src="{{ asset('assets/img/brand/sintek.png') }}" alt="{{ config('app.name') }} logo" />
        <img class="navbar-brand-light" src="{{ asset('assets/img/brand/sintek.png') }}" alt="{{ config('app.name') }} logo" />
    </a>
    <div class="d-flex align-items-center">
        <button class="navbar-toggler d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>