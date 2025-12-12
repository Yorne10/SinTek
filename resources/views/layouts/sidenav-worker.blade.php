{{--
Empresa: CETAM
Proyecto: ST
Archivo: sidenav-worker.blade.php
Fecha de creacin: 03/11/25
Realizado por: Alfonso Angel Garca Hernndez
Validado por: Alfonso Angel Garca Hernndez
--}}
<nav id="sidebarMenu" class="sidebar d-lg-block bg-gray-800 text-white collapse" data-simplebar>
  <div class="sidebar-inner px-2 pt-3">
    <div class="user-card d-flex d-md-none align-items-center justify-content-between justify-content-md-center pb-4">
      <div class="d-flex align-items-center">
        <div class="avatar-lg me-4">
          <img src="{{ asset('assets/img/team/profile-picture-3.jpg') }}"
            class="card-img-top rounded-circle border-white" alt="{{ auth()->user()->first_name ?? 'Usuario' }}">
        </div>
        <div class="d-block">
          <h2 class="h5 mb-3">Hola, {{ auth()->user()->first_name ?? 'Usuario' }}</h2>
          <form method="POST" action="{{ route(config('proj.route_name_prefix', 'proj') . '.auth.logout') }}">
            @csrf
            <button type="submit" class="btn btn-secondary btn-sm d-inline-flex align-items-center">
            @icon('logout', 'fa-xs me-1')
              Cerrar sesin
            </button>
          </form>
        </div>
      </div>
      <div class="collapse-close d-md-none">
        <a href="#sidebarMenu" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu"
          aria-expanded="true" aria-label="Toggle navigation">
          @icon('close', 'fa-xs')
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

      {{-- Mis trámites --}}
      <li class="nav-item">
        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.worker.my-procedures') }}" class="nav-link">
          <span class="sidebar-icon">
            @icon('recordList', 'me-2')
          </span>
          <span class="sidebar-text">Mis trámites</span>
        </a>
      </li>

      {{-- Nuevo trámite --}}
      <li class="nav-item">
        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.worker.available-procedures') }}"
          class="nav-link">
          <span class="sidebar-icon">
            @icon('documentSign', 'me-2')
          </span>
          <span class="sidebar-text">Nuevo trámite</span>
        </a>
      </li>

      {{-- Convocatorias --}}
      <li class="nav-item">
        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.worker.convocations') }}" class="nav-link">
          <span class="sidebar-icon">
            @icon('announcement', 'me-2')
          </span>
          <span class="sidebar-text">Convocatorias</span>
        </a>
      </li>

      {{-- Documentos --}}
      <li class="nav-item">
        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.worker.documents') }}" class="nav-link">
          <span class="sidebar-icon">
            @icon('file', 'me-2')
          </span>
          <span class="sidebar-text">Documentos</span>
        </a>
      </li>

      {{-- Mi perfil --}}
      <li class="nav-item">
        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.profile.index') }}" class="nav-link">
          <span class="sidebar-icon">
            @icon('user', 'me-2')
          </span>
          <span class="sidebar-text">Mi perfil</span>
        </a>
      </li>
    </ul>
  </div>
</nav>
