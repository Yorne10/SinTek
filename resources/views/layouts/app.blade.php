{{--
Company: CETAM
Project: ST
File: app.blade.php
Created on: 02/11/2025
Created by: Alfonso Angel Garcia Hernandez
Approved by: Alfonso Angel Garcia Hernandez

Changelog:
- ID: <ID> | Date: dd/mm/yyyy
    Modified by: <Developer name>
        Description: <Brief description of change>
            --}}
            @extends('layouts.base')

            @section('content')
            @php($routeName = request()->route()?->getName())
            @php($prefix = config('proj.route_name_prefix', 'proj'))
            @php($isAppShell = in_array($routeName, [
                // Rutas app principales con navegacin completa
                $prefix . '.dashboard.index',
                $prefix . '.profile.index',
                $prefix . '.profile.example',
                $prefix . '.users.index',
                $prefix . '.users.create',
                $prefix . '.users.edit',
                $prefix . '.ui.bootstrap-tables',
                $prefix . '.billing.transactions',
                $prefix . '.ui.buttons',
                $prefix . '.ui.forms',
                $prefix . '.ui.modals',
                $prefix . '.ui.notifications',
                $prefix . '.ui.typography',
                $prefix . '.marketing.upgrade-to-pro',
                // Rutas de trabajadores
                $prefix . '.worker.available-procedures',
                $prefix . '.worker.my-procedures',
                $prefix . '.worker.procedure-detail',
                $prefix . '.worker.convocations',
                $prefix . '.worker.calls',
                $prefix . '.worker.documents',
                $prefix . '.worker.notifications',
                // Rutas de secretarios
                $prefix . '.secretary.validate-steps',
                $prefix . '.secretary.search-workers',
                $prefix . '.secretary.calls',
                $prefix . '.secretary.documents',
                $prefix . '.secretary.convocation.create',
                $prefix . '.secretary.convocation.edit',
                $prefix . '.secretary.document.create',
                $prefix . '.secretary.document.edit',
                $prefix . '.secretary.reports',
                $prefix . '.secretary.notifications',
                $prefix . '.secretary.faq-management',
                $prefix . '.secretary.processes',
                $prefix . '.secretary.budget-keys',
                $prefix . '.secretary.budget-key.create',
                $prefix . '.secretary.budget-key.edit',
                // Rutas de administradores
                $prefix . '.admin.create-process',
                $prefix . '.admin.define-steps',
                $prefix . '.admin.create-step',
                $prefix . '.admin.modify-process',
                $prefix . '.admin.manage-procedures',
                $prefix . '.admin.requests',
                $prefix . '.admin.convocations-events',
                $prefix . '.admin.document-templates',
                $prefix . '.admin.activity-log',
                $prefix . '.admin.configuration',
                $prefix . '.admin.alerts-preview',
                // Rutas compartidas
                $prefix . '.faq',
            ]))
            @php($isAuthShell = in_array($routeName, [
                // Rutas de autenticacin/landing
                $prefix . '.auth.register',
                $prefix . '.examples.register',
                $prefix . '.auth.login',
                $prefix . '.examples.login',
                $prefix . '.auth.forgot-password',
                $prefix . '.examples.forgot-password',
                $prefix . '.auth.reset-password',
                $prefix . '.examples.reset-password',
            ]))
            @php($isMinimalShell = in_array($routeName, [
                // Pginas minimalistas
                $prefix . '.errors.404',
                $prefix . '.errors.500',
                $prefix . '.auth.lock',
            ]))

            @if($isAppShell)
                {{-- Nav --}}
                @include('layouts.nav')
                {{-- SideNav --}}
                @include('layouts.sidenav')
                <main class="content">
                    {{-- TopBar --}}
                    @include('layouts.topbar')
                    @hasSection('page')
                        @yield('page')
                    @else
                        {{ $slot ?? '' }}
                    @endif
                    {{-- Footer --}}
                    @include('layouts.footer')

                    {{-- Idle Timer --}}
                    @auth
                        @include('layouts.partials.idle-timer')
                    @endauth
                </main>
            @elseif($isAuthShell)
                @hasSection('page')
                    @yield('page')
                @else
                    {{ $slot ?? '' }}
                @endif
                {{-- Footer alternativo --}}
                @include('layouts.footer2')

                {{-- Keep Alive Script for Auth Pages --}}
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        // Ping server every 30 seconds to keep session alive on login/register pages
                        setInterval(function () {
                            fetch(window.location.href, {
                                method: 'HEAD',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            }).catch(e => console.error('Keep-alive failed', e));
                        }, 30000);
                    });
                </script>
            @elseif($isMinimalShell)
                @hasSection('page')
                    @yield('page')
                @else
                    {{ $slot ?? '' }}
                @endif
            @else
                {{-- Fallback: contenido plano --}}
                @hasSection('page')
                    @yield('page')
                @else
                    {{ $slot ?? '' }}
                @endif
            @endif
            @endsection