{{-- Nota Livewire: esta vista debe tener UN único elemento raíz --}}
{{-- El layout se aplica desde el componente con ->layout('layouts.app') --}}

<section class="vh-lg-100 mt-4 mt-lg-0 bg-soft d-flex align-items-center">
    <div class="container">
        <div class="row justify-content-center form-bg-image">
            <p class="text-center">
                <a href="{{ route(config('proj.route_name_prefix', 'proj').'.auth.login') }}" class="d-flex align-items-center justify-content-center">
                    <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                    </svg>
                    Volver al inicio de sesión
                </a>
            </p>
            <div class="col-12 d-flex align-items-center justify-content-center">
                <div class="signin-inner my-3 my-lg-0 bg-white shadow border-0 rounded p-4 p-lg-5 w-100 fmxw-500">
                    <h1 class="h3">¿Olvidaste tu contraseña?</h1>
                                        <p class="mb-4">
                        Solicita restablecimiento en {{ config('app.contact_email', config('mail.from.address', 'contacto@cetam.gob.mx')) }}
                        o al {{ config('app.contact_phone', '(999) 999-9999') }}.
                    </p>
                    <div class="d-grid">
                        <a href="{{ route(config('proj.route_name_prefix', 'proj').'.auth.login') }}" class="btn btn-gray-800">Entendido</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
