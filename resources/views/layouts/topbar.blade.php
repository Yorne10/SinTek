<?php
// generated rewrite of topbar to add dynamic notifications
?>
{{--
    Company: CETAM
    Project: ST
    File: topbar.blade.php
    Created on: 05/11/2025
    Created by: Alfonso Angel Garcia Hernandez

    Changelog:
    - ID: <ID> | Date: dd/mm/yyyy
      Modified by: <Developer name>
      Description: <Brief description of change>
--}}
<nav class="navbar navbar-top navbar-expand navbar-dashboard navbar-dark ps-0 pe-2 pb-0">
  <div class="container-fluid px-0">
    <div class="d-flex justify-content-between w-100" id="navbarSupportedContent">
      <div class="d-flex align-items-center">
      </div>
      <!-- Navbar links -->
      <ul class="navbar-nav align-items-center">
        @php
            $user = auth()->user();
            $userNotifications = $user
                ? $user->notifications()->latest()->limit(5)->get()
                : collect();
            $unreadNotifications = $userNotifications->whereNull('read_at')->count();
            $notificationRoute = route(config('proj.route_name_prefix', 'proj') . '.worker.notificaciones');
        @endphp
        <li class="nav-item dropdown">
          <a class="nav-link text-white notification-bell dropdown-toggle"
            data-unread-notifications="{{ $unreadNotifications > 0 ? 'true' : 'false' }}"
            href="#" role="button" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
            @icon('notif.bell', 'icon icon-sm text-primary')
            @if($unreadNotifications > 0)
              <span class="notification-badge bg-danger text-white">{{ $unreadNotifications }}</span>
            @endif
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-center mt-2 py-0">
            <div class="list-group list-group-flush">
              <a href="{{ $notificationRoute }}" class="text-center text-primary fw-bold border-bottom border-light py-3">Notificaciones</a>
              @forelse($userNotifications as $notification)
                <a href="{{ $notificationRoute }}" class="list-group-item list-group-item-action border-bottom">
                  <div class="row align-items-center">
                    <div class="col-auto">
                      <div class="icon-shape icon-sm {{ $notification->read_at ? 'icon-shape-secondary' : 'icon-shape-primary' }} rounded">
                        @icon('state.info', 'icon icon-xs text-white')
                      </div>
                    </div>
                    <div class="col ps-0 ms-2">
                      <div class="d-flex justify-content-between align-items-center">
                        <div>
                          <h4 class="h6 mb-0 text-small">{{ $notification->tittle ?? 'Notificaci�n' }}</h4>
                        </div>
                        <div class="text-end">
                          <small class="{{ $notification->read_at ? 'text-muted' : 'text-danger' }}">
                            {{ $notification->created_at?->diffForHumans() }}
                          </small>
                        </div>
                      </div>
                      <p class="font-small mt-1 mb-0">{{ $notification->message }}</p>
                    </div>
                  </div>
                </a>
              @empty
                <div class="list-group-item border-0 text-center py-4 text-gray-500">Sin notificaciones</div>
              @endforelse
              <a href="{{ $notificationRoute }}" class="dropdown-item text-center fw-bold rounded-bottom py-3">
                @icon('action.view', 'icon icon-xxs text-gray-400 me-1')
                Ver todas
              </a>
            </div>
          </div>
        </li>
        <li class="nav-item dropdown ms-lg-3">
          <a class="nav-link dropdown-toggle pt-1 px-0" href="#" role="button" data-bs-toggle="dropdown"
            aria-expanded="false">
            <div class="media d-flex align-items-center">
              <div class="avatar rounded-circle d-flex align-items-center justify-content-center bg-primary text-white fw-bold" style="width: 40px; height: 40px; font-size: 1rem;">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}{{ strtoupper(substr(explode(' ', auth()->user()->name)[1] ?? '', 0, 1)) }}
              </div>
              <div class="media-body ms-2 text-dark align-items-center d-none d-lg-block">
                <span
                  class="mb-0 font-small fw-bold text-gray-900">{{ auth()->user()->name }}</span>
              </div>
            </div>
          </a>
          <div class="dropdown-menu dashboard-dropdown dropdown-menu-end mt-2 py-1">
            <a class="dropdown-item d-flex align-items-center" href="{{ route(config('proj.route_name_prefix', 'proj') . '.profile.index') }}">
              @icon('user.profile', 'dropdown-icon text-gray-400 me-2')
              Mi perfil
            </a>
            <div role="separator" class="dropdown-divider my-1"></div>
            <a class="dropdown-item d-flex align-items-center">
              <livewire:logout /></a>
          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>
