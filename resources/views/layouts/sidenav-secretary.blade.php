{{--
  Company: CETAM
  Project: ST
  File: sidenav-secretary.blade.php
  Created on: 04/11/2025
  Created by: Alfonso Angel Garca Hernndez
  Approved by: Alfonso Angel Garca Hernndez

  Changelog:
--}}
<nav id="sidebarMenu" class="sidebar d-lg-block bg-gray-800 text-white collapse" data-simplebar>
  <div class="sidebar-inner px-2 pt-3">
    <div class="user-card d-flex d-md-none align-items-center justify-content-between justify-content-md-center pb-4">
      <div class="d-flex align-items-center">
        <div class="avatar-lg me-4">
          <img src="{{ asset('assets/img/team/profile-picture-3.jpg') }}" class="card-img-top rounded-circle border-white"
            alt="{{ auth()->user()->first_name ?? 'Secretario' }}">
        </div>
        <div class="d-block">
          <h2 class="h5 mb-3">Hola, {{ auth()->user()->first_name ?? 'Secretario' }}</h2>
          <form method="POST" action="{{ route(config('proj.route_name_prefix', 'proj') . '.auth.logout') }}">
            @csrf
            <button type="submit" class="btn btn-secondary btn-sm d-inline-flex align-items-center">
              @icon('auth.logout', 'icon icon-xxs me-1')
              Cerrar sesin
            </button>
          </form>
        </div>
      </div>
      <div class="collapse-close d-md-none">
        <a href="#sidebarMenu" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu"
          aria-expanded="true" aria-label="Toggle navigation">
          @icon('nav.close', 'icon icon-xs')
        </a>
      </div>
    </div>
    <ul class="nav flex-column pt-3 pt-md-0">
      {{-- Logo --}}
      <li class="nav-item">
        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.dashboard.index') }}" class="nav-link d-flex align-items-center">
          <span class="sidebar-icon me-3">
            <img src="{{ asset('assets/img/brand/sintek.png') }}" height="20" width="20" alt="{{ config('app.name') }} Logo">
          </span>
          <span class="mt-1 ms-1 sidebar-text">
            {{ config('app.name') }}
          </span>
        </a>
      </li>

      {{-- Panel de solicitudes --}}
      <li class="nav-item">
        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.panel-solicitudes') }}" class="nav-link">
          <span class="sidebar-icon">
            @icon('process.docs', 'icon icon-xs me-2')
          </span>
          <span class="sidebar-text">Panel de solicitudes</span>
        </a>
      </li>

      {{-- Bsqueda de trabajadores --}}
      <li class="nav-item">
        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.busqueda-trabajadores') }}" class="nav-link">
          <span class="sidebar-icon">
            @icon('user.list', 'icon icon-xs me-2')
          </span>
          <span class="sidebar-text">Buscar trabajadores</span>
        </a>
      </li>

      {{-- Gestin de convocatorias y documentos pblicos --}}
      <li class="nav-item">
        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.convocatorias-documentos') }}" class="nav-link">
          <span class="sidebar-icon">
            @icon('file.generic', 'icon icon-xs me-2')
          </span>
          <span class="sidebar-text">Gestionar convocatorias</span>
        </a>
      </li>

      {{-- Enviar notificacin --}}
      <li class="nav-item">
        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.notificaciones') }}" class="nav-link">
          <span class="sidebar-icon">
            @icon('notif.bell', 'icon icon-xs me-2')
          </span>
          <span class="sidebar-text">Enviar notificacin</span>
        </a>
      </li>

      {{-- Gestin de FAQs --}}
      <li class="nav-item">
        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.gestion-faqs') }}" class="nav-link">
          <span class="sidebar-icon">
            @icon('support.help', 'icon icon-xs me-2')
          </span>
          <span class="sidebar-text">Gestionar FAQs</span>
        </a>
      </li>

      <li role="separator" class="dropdown-divider mt-4 mb-3 border-gray-700"></li>

      {{-- Gestin de procesos --}}
      <li class="nav-item">
        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.admin.crear-proceso') }}" class="nav-link">
          <span class="sidebar-icon">
            @icon('action.create', 'icon icon-xs me-2')
          </span>
          <span class="sidebar-text">Crear proceso</span>
        </a>
      </li>

      {{-- Definir pasos --}}
      <li class="nav-item">
        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.admin.definir-pasos') }}" class="nav-link">
          <span class="sidebar-icon">
            @icon('process.step', 'icon icon-xs me-2')
          </span>
          <span class="sidebar-text">Definir pasos</span>
        </a>
      </li>

      {{-- Modificar proceso --}}
      <li class="nav-item">
        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.admin.modificar-proceso') }}" class="nav-link">
          <span class="sidebar-icon">
            @icon('action.edit', 'icon icon-xs me-2')
          </span>
          <span class="sidebar-text">Modificar proceso</span>
        </a>
      </li>

      <li role="separator" class="dropdown-divider mt-4 mb-3 border-gray-700"></li>

      {{-- Mi perfil --}}
      <li class="nav-item">
        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.profile.index') }}" class="nav-link">
          <span class="sidebar-icon">
            @icon('user.profile', 'icon icon-xs me-2')
          </span>
          <span class="sidebar-text">Mi perfil</span>
        </a>
      </li>
    </ul>
  </div>
</nav>
