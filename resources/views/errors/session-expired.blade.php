@extends('layouts.base')

@section('content')
    <main>
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
                            <div class="text-center mb-4">
                                <svg class="icon icon-xxl text-warning" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <h1 class="h3 text-center">Tu sesión ha expirado</h1>
                            <p class="mb-3 text-center">
                                Por seguridad, tu sesión se ha cerrado debido a inactividad.
                            </p>
                            <p class="mb-4 text-center text-muted small">
                                Todos tus cambios guardados están seguros. Simplemente inicia sesión nuevamente para continuar trabajando.
                            </p>
                            <div class="d-grid">
                                <a href="{{ route(config('proj.route_name_prefix', 'proj').'.auth.login') }}" class="btn btn-gray-800">
                                    <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L9.414 9H17a1 1 0 110 2H9.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Iniciar sesión nuevamente
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection