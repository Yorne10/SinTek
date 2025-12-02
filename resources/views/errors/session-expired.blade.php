@extends('layouts.base')

@section('content')
    <main>
        <section class="vh-100 d-flex align-items-center justify-content-center">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center d-flex align-items-center justify-content-center">
                        <div>
                            <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.auth.login') }}">
                                <img class="img-fluid w-75" src="{{ asset('assets/img/illustrations/404.svg') }}"
                                    alt="Session Expired">
                            </a>
                            <h1 class="mt-5">Tu sesión ha expirado</h1>
                            <p class="lead my-4">Por seguridad, tu sesión se ha cerrado debido a inactividad o ha expirado.
                            </p>
                            <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.auth.login') }}"
                                class="btn btn-gray-800 d-inline-flex align-items-center justify-content-center mb-4">
                                <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L9.414 9H17a1 1 0 110 2H9.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Volver al inicio de sesión
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection