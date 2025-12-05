{{--
* Company: CETAM
* Project: ST
* File: notifications.blade.php
* Created on: 04/12/2025
* Created by: Claude Code
* Approved by: Alfonso Angel Garcia Hernandez
*
* Changelog:
* - ID: 001 | Modified on: 04/12/2025 |
* Modified by: Claude Code |
* Description: Componente Livewire para notificaciones con actualización automática cada 10 segundos
--}}

@php
    $user = auth()->user();
    $isWorker = $user && $user->role === 'worker';
    $notificationRoute = route(config('proj.route_name_prefix', 'proj') . '.worker.notificaciones');
@endphp

<div>
    @if($isWorker)
        <div wire:poll.10s="refreshNotifications">
            <li class="nav-item dropdown">
                <a class="nav-link text-white notification-bell dropdown-toggle"
                    data-unread-notifications="{{ $unreadCount > 0 ? 'true' : 'false' }}" href="#" role="button"
                    data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                    <i
                        class="{{ icon('notif.bell') }} fa-2x {{ $unreadCount > 0 ? 'text-secondary' : 'text-primary' }}"></i>
                    @if($unreadCount > 0)
                        <span class="text-secondary fw-bold ms-1">{{ $unreadCount }}</span>
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-center mt-2 py-0" style="max-width: 400px;">
                    <div class="list-group list-group-flush">
                        <a href="{{ $notificationRoute }}"
                            class="text-center text-primary fw-bold border-bottom border-light py-3">Notificaciones</a>
                        <div style="max-height: 350px; overflow-y: auto;">
                            @forelse($notifications as $notification)
                                <a href="{{ $notificationRoute }}" class="list-group-item list-group-item-action border-bottom">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <div
                                                class="icon-shape icon-sm {{ $notification->read_at ? 'icon-shape-secondary' : 'icon-shape-primary' }} rounded">
                                                @icon('state.info', 'fa-xs text-white')
                                            </div>
                                        </div>
                                        <div class="col ps-0 ms-2">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="text-truncate" style="max-width: 200px;">
                                                    <h4 class="h6 mb-0 text-small text-truncate">{{ $notification->tittle ?? 'Notificación' }}
                                                    </h4>
                                                </div>
                                                <div class="text-end ms-2">
                                                    <small class="{{ $notification->read_at ? 'text-muted' : 'text-danger' }}">
                                                        {{ $notification->created_at?->diffForHumans() }}
                                                    </small>
                                                </div>
                                            </div>
                                            <p class="font-small mt-1 mb-0 text-truncate" style="max-width: 280px;">{{ $notification->message }}</p>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="list-group-item border-0 text-center py-4 text-gray-500">Sin notificaciones</div>
                            @endforelse
                        </div>
                        <a href="{{ $notificationRoute }}" class="dropdown-item text-center fw-bold rounded-bottom py-3">
                            @icon('action.view', 'fa-xs text-gray-400 me-1')
                            Ver todas
                        </a>
                    </div>
                </div>
            </li>
        </div>
    @endif
</div>