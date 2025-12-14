{{--
Company: CETAM
Project: ST
File: idle-timer.blade.php
Created on: 11/12/2025
Created by: Alfonso Angel Garcia Hernandez
Approved by: Alfonso Angel Garcia Hernandez

Changelog:
- ID: <ID> | Date: dd/mm/yyyy
    Modified by: <Developer name>
    Description: <Brief description of change>
--}}

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sessionLifetime = {{ config('session.lifetime', 120) }};
        const sessionLifetimeMs = sessionLifetime * 60 * 1000;
        const warningDuration = 30 * 1000;
        let idleTime = sessionLifetimeMs - warningDuration;
        if (idleTime < 0) idleTime = 0;

        let idleTimer;

        function startIdleTimer() {
            clearTimeout(idleTimer);
            idleTimer = setTimeout(showIdleWarning, idleTime);
        }

        function showIdleWarning() {
            if (typeof Swal === 'undefined') {
                setTimeout(showIdleWarning, 1000);
                return;
            }

            Swal.fire({
                title: '¿Sigues ahí?',
                html: '<p>Tu sesión está a punto de expirar debido a la inactividad.</p><p class="text-muted small mb-0">Si no respondes, serás redirigido automáticamente.</p>',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Continuar sesión',
                cancelButtonText: 'Cerrar sesión',
                timer: warningDuration,
                timerProgressBar: true,
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    if (Swal.getPopup()) {
                        Swal.getPopup().style.zIndex = '10000';
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('{{ route(config('proj.route_name_prefix', 'proj') . '.dashboard.index') }}', {
                        method: 'HEAD',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                    }).then(response => {
                        if (response.status === 401 || response.status === 419) {
                            logout();
                        } else {
                            Swal.fire({
                                icon: 'success',
                                title: 'Sesión extendida',
                                text: 'Tu sesión ha sido extendida exitosamente',
                                timer: 1500,
                                showConfirmButton: false
                            });
                            startIdleTimer();
                        }
                    }).catch(() => logout());
                } else {
                    logout();
                }
            });
        }

        function logout() {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Cerrando sesión...',
                    text: 'Por favor espera',
                    icon: 'info',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => { Swal.showLoading(); }
                });
            }

            fetch('{{ route(config('proj.route_name_prefix', 'proj') . '.auth.logout') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            }).then(() => {
                window.location.href = '{{ route(config('proj.route_name_prefix', 'proj') . '.errors.session-expired') }}';
            }).catch(() => {
                window.location.href = '{{ route(config('proj.route_name_prefix', 'proj') . '.errors.session-expired') }}';
            });
        }

        const events = ['mousedown', 'mousemove', 'keypress', 'scroll', 'touchstart', 'click'];
        events.forEach(event => {
            document.addEventListener(event, function () {
                if (typeof Swal === 'undefined' || !Swal.isVisible()) {
                    startIdleTimer();
                }
            }, true);
        });

        // Resetear timer en eventos de Livewire
        if (window.Livewire) {
            // Cuando Livewire empieza a procesar una petición
            document.addEventListener('livewire:init', () => {
                Livewire.hook('commit', ({ component, commit, respond, succeed, fail }) => {
                    succeed(({ snapshot, effect }) => {
                        // Resetear el timer cuando Livewire completa una acción
                        if (typeof Swal === 'undefined' || !Swal.isVisible()) {
                            startIdleTimer();
                        }
                    });
                });
            });
        }

        // Monitorear peticiones fetch/AJAX
        const originalFetch = window.fetch;
        window.fetch = function(...args) {
            if (typeof Swal === 'undefined' || !Swal.isVisible()) {
                startIdleTimer();
            }
            return originalFetch.apply(this, args);
        };

        startIdleTimer();
    });
</script>
