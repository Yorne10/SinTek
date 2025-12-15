{{--
Company: CETAM
Project: ST
File: database-error.blade.php
Created on: 14/12/2025
Created by: Alfonso Angel Garcia Hernandez

Changelog:
- ID: <ID> | Date: dd/mm/yyyy
    Modified by: <Developer name>
    Description: <Brief description of change>
--}}

@extends('layouts.base')

@section('content')
    <main>
        <section class="vh-lg-100 mt-4 mt-lg-0 bg-soft d-flex align-items-center">
            <div class="container">
                <div class="row justify-content-center form-bg-image">
                    <p class="text-center">
                        <a href="{{ $redirectUrl ?? route(config('proj.route_name_prefix', 'proj') . '.auth.login') }}"
                            class="d-flex align-items-center justify-content-center">
                            <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Volver al inicio de sesión
                        </a>
                    </p>
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="signin-inner my-3 my-lg-0 bg-white shadow border-0 rounded p-4 p-lg-5 w-100 fmxw-500">
                            <div class="text-center mb-4">
                                <span class="icon icon-lg text-danger">
                                    <svg class="icon icon-lg" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </span>
                            </div>
                            <h1 class="h3 text-center">Error de conexión</h1>
                            <p class="mb-3 text-center">
                                {{ $message ?? 'No se pudo establecer conexión con la base de datos. Por favor, intenta nuevamente.' }}
                            </p>
                            <p class="mb-4 text-center text-muted small">
                                Si el problema persiste, contacta al administrador del sistema.
                            </p>
                            <div class="d-grid">
                                <a href="{{ $redirectUrl ?? route(config('proj.route_name_prefix', 'proj') . '.auth.login') }}"
                                    class="btn btn-gray-800">
                                    Intentar de nuevo
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection