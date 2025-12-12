<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Configuración de tiempo de inactividad (en minutos)
        // Se obtiene de la configuración de sesión de Laravel
        const sessionLifetime = {{ config('session.lifetime', 120) }};
        
        // Convertir a milisegundos
        const sessionLifetimeMs = sessionLifetime * 60 * 1000;
        const warningDuration = 30 * 1000; // 30 segundos para responder
        
        // Calcular tiempo de espera antes de mostrar la alerta
        // Si el tiempo de sesión es muy corto, aseguramos que al menos se muestre la alerta
        let idleTime = sessionLifetimeMs - warningDuration;
        if (idleTime < 0) idleTime = 0;

        let idleTimer;

        function startIdleTimer() {
            clearTimeout(idleTimer);

            // Iniciar temporizador de inactividad
            idleTimer = setTimeout(showIdleWarning, idleTime);
        }

        function showIdleWarning() {
            if (typeof Swal === 'undefined') {
                console.warn('SweetAlert2 is not loaded yet, retrying in 1 second...');
                setTimeout(showIdleWarning, 1000);
                return;
            }

            Swal.fire({
                title: '¿Sigues ahí?',
                html: '<p>Tu sesión está a punto de expirar debido a la inactividad.</p><p class="text-muted small mb-0">Si no respondes, serás redirigido automáticamente.</p>',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Continuar sesión',
                cancelButtonText: 'Cerrar sesión',
                timer: warningDuration,
                timerProgressBar: true,
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    // Ensure z-index is high enough
                    if (Swal.getPopup()) {
                        Swal.getPopup().style.zIndex = '10000';
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // El usuario quiere continuar, reiniciamos el temporizador
                    // Hacemos una petición ping para mantener la sesión en el servidor
                    fetch('{{ route(config('proj.route_name_prefix', 'proj') . '.dashboard.index') }}', {
                        method: 'HEAD',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    }).then(response => {
                        if (response.status === 401 || response.status === 419) {
                            // Sesión expirada en el servidor
                            logout();
                        } else {
                            // Sesión válida, reiniciar timer
                            Swal.fire({
                                icon: 'success',
                                title: 'Sesión extendida',
                                text: 'Tu sesión ha sido extendida exitosamente',
                                timer: 1500,
                                showConfirmButton: false
                            });
                            startIdleTimer();
                        }
                    }).catch(error => {
                        console.error('Error al verificar sesión:', error);
                        // En caso de error de red, intentar logout
                        logout();
                    });
                } else {
                    // El usuario canceló o el tiempo se agotó (result.dismiss === Swal.DismissReason.timer)
                    logout();
                }
            });
        }

        function logout() {
            // Mostrar mensaje de cierre de sesión
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Cerrando sesión...',
                    text: 'Por favor espera',
                    icon: 'info',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            }

            // Hacer el logout en segundo plano mediante fetch
            fetch('{{ route(config('proj.route_name_prefix', 'proj') . '.auth.logout') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            }).then(() => {
                // Después del logout, redirigir DIRECTAMENTE a session-expired
                window.location.href = '{{ route(config('proj.route_name_prefix', 'proj') . '.errors.session-expired') }}';
            }).catch(error => {
                console.error('Error al cerrar sesión:', error);
                // Incluso si falla el logout, redirigir a session-expired
                window.location.href = '{{ route(config('proj.route_name_prefix', 'proj') . '.errors.session-expired') }}';
            });
        }

        // Reiniciar temporizador en eventos de usuario
        const events = ['mousedown', 'mousemove', 'keypress', 'scroll', 'touchstart'];
        events.forEach(event => {
            document.addEventListener(event, function () {
                // Solo reiniciar si no se está mostrando la alerta
                if (typeof Swal === 'undefined' || !Swal.isVisible()) {
                    startIdleTimer();
                }
            }, true);
        });

        // Iniciar temporizador al cargar
        startIdleTimer();
    });
</script>