{{--
Company: CETAM
Project: ST
File: sidenav-secretary.blade.php
Created on: 04/11/2025
Created by: Alfonso Angel García Hernández
Approved by: Alfonso Angel García Hernández

Changelog:
--}}
<nav id="sidebarMenu" class="sidebar d-lg-block bg-gray-800 text-white collapse" data-simplebar>
  <div class="sidebar-inner px-2 pt-3">
    <div class="user-card d-flex d-md-none align-items-center justify-content-between justify-content-md-center pb-4">
      <div class="d-flex align-items-center">
        <div class="avatar-lg me-4">
          <img src="{{ asset('assets/img/team/profile-picture-3.jpg') }}"
            class="card-img-top rounded-circle border-white" alt="{{ auth()->user()->first_name ?? 'Secretario' }}">
        </div>
        <div class="d-block">
          <h2 class="h5 mb-3">Hola, {{ auth()->user()->first_name ?? 'Secretario' }}</h2>
          <form method="POST" action="{{ route(config('proj.route_name_prefix', 'proj') . '.auth.logout') }}">
            @csrf
            <button type="submit" class="btn btn-secondary btn-sm d-inline-flex align-items-center">
              @icon('auth.logout', 'fa-xs me-1')
              Cerrar sesión
            </button>
          </form>
        </div>
      </div>
      <div class="collapse-close d-md-none">
        <a href="#sidebarMenu" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu"
          aria-expanded="true" aria-label="Toggle navigation">
          @icon('nav.close', 'fa-xs')
        </a>
      </div>
    </div>
    <ul class="nav flex-column pt-3 pt-md-0">
      {{-- Logo --}}
      <li class="nav-item">
        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.dashboard.index') }}"
          class="nav-link d-flex align-items-center">
          <span class="sidebar-icon me-3">
            <img src="{{ asset('assets/img/brand/sintek.png') }}" height="20" width="20"
              alt="{{ config('app.name') }} Logo">
          </span>
          <span class="mt-1 ms-1 sidebar-text">
            {{ config('app.name') }}
          </span>
        </a>
      </li>

      {{-- Búsqueda de trabajadores --}}
      <li class="nav-item">
        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.search-workers') }}" class="nav-link">
          <span class="sidebar-icon">
            @icon('user.list', 'me-2')
          </span>
          <span class="sidebar-text">Buscar trabajadores</span>
        </a>
      </li>

      {{-- Gestión de convocatorias --}}
      <li class="nav-item">
        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.calls') }}" class="nav-link">
          <span class="sidebar-icon">
            @icon('process.document', 'me-2')
          </span>
          <span class="sidebar-text">Convocatorias</span>
        </a>
      </li>

      {{-- Gestión de documentos --}}
      <li class="nav-item">
        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.documents') }}" class="nav-link">
          <span class="sidebar-icon">
            @icon('file.generic', 'me-2')
          </span>
          <span class="sidebar-text">Documentos</span>
        </a>
      </li>

      {{-- Enviar notificación --}}
      <li class="nav-item">
        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.notifications') }}" class="nav-link">
          <span class="sidebar-icon">
            @icon('notif.bell', 'me-2')
          </span>
          <span class="sidebar-text">Enviar notificación</span>
        </a>
      </li>

      {{-- Gestión de FAQs --}}
      <li class="nav-item">
        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.faq-management') }}" class="nav-link">
          <span class="sidebar-icon">
            @icon('support.help', 'me-2')
          </span>
          <span class="sidebar-text">Preguntas frecuentes</span>
        </a>
      </li>

      {{-- Gestión de procesos --}}
      <li class="nav-item">
        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.processes') }}" class="nav-link">
          <span class="sidebar-icon">
            @icon('process.flow', 'me-2')
          </span>
          <span class="sidebar-text">Gestionar Procesos</span>
        </a>
      </li>

      {{-- Gestión de Claves Presupuestales --}}
      <li class="nav-item">
        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.budget-keys') }}" class="nav-link">
          <span class="sidebar-icon">
            @icon('finance.budget', 'me-2')
          </span>
          <span class="sidebar-text">Gestionar Claves</span>
        </a>
      </li>

      {{-- Mi perfil --}}
      <li class="nav-item">
        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.profile.index') }}" class="nav-link">
          <span class="sidebar-icon">
            @icon('user.profile', 'me-2')
          </span>
          <span class="sidebar-text">Mi perfil</span>
        </a>
      </li>
    </ul>
  </div>
</nav>
