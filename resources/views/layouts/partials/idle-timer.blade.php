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
                title: '¿Sigues ahi?',
                html: '<p>Tu sesion esta a punto de expirar debido a la inactividad.</p><p class="text-muted small mb-0">Si no respondes, seras redirigido automaticamente.</p>',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Continuar sesion',
                cancelButtonText: 'Cerrar sesion',
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
                                title: 'Sesion extendida',
                                text: 'Tu sesion ha sido extendida exitosamente',
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
                    title: 'Cerrando sesion...',
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

        const events = ['mousedown', 'mousemove', 'keypress', 'scroll', 'touchstart'];
        events.forEach(event => {
            document.addEventListener(event, function () {
                if (typeof Swal === 'undefined' || !Swal.isVisible()) {
                    startIdleTimer();
                }
            }, true);
        });

        startIdleTimer();
    });
</script>
