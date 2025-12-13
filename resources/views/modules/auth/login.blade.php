{{--
Company: CETAM
Project: ST
File: login.blade.php
Created on: 12/12/2025
Created by: Alfonso Angel Garcia Hernandez
Approved by: Alfonso Angel Garcia Hernandez

Changelog:
- ID: <ID> | Date: dd/mm/yyyy
  Modified by: <Developer name>
  Description: <Brief description of change>
--}}

@section('title', 'Iniciar sesión - ' . config('app.name'))

<section class="vh-lg-100 mt-5 mt-lg-0 bg-soft d-flex align-items-center">
    <div class="container">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        {{-- <p class="text-center"><a href="{{ route('dashboard') }}" class="text-gray-700"><i
                    class="fas fa-angle-left me-2"></i> Back to homepage</a></p> --}}
        <div class="row justify-content-center form-bg-image">
            <div class="col-12 d-flex align-items-center justify-content-center">
                <div class="bg-white shadow-soft border rounded border-light p-4 p-lg-5 w-100 fmxw-500">
                    <div class="text-center text-md-center mb-4 mt-md-0">
                        <h1 class="mb-3 h3">Inicia sesión en {{ config('app.name') }}</h1>
                        <p class="mb-0">Accede con tu correo institucional y contraseña.</p>
                    </div>
                    <form wire:submit="login" class="mt-4">
                        <!-- Form -->
                        <div class="form-group mb-4">
                            <label for="email">Correo electrónico</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><svg class="icon icon-xs text-gray-600"
                                        fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z">
                                        </path>
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                    </svg></span>
                                <input wire:model="email" type="text"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="correo@institucion.com" id="email" autofocus>
                            </div>
                            @error('email')
                                <div class="invalid-feedback d-block"> {{ $message }} </div>
                            @enderror
                        </div>
                        <!-- End of Form -->
                        <div class="form-group">
                            <!-- Form -->
                            <div class="form-group mb-4">
                                <label for="password">Contraseña</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon2"><svg
                                            class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                                clip-rule="evenodd"></path>
                                        </svg></span>
                                    <input wire:model.lazy="password" type="password" placeholder="Contrase&ntilde;a"
                                        class="form-control @error('password') is-invalid @enderror" id="password">
                                </div>
                                @error('password')
                                    <div class="invalid-feedback d-block"> {{ $message }} </div>
                                @enderror
                            </div>
                            <!-- End of Form -->
                            <div class="d-flex justify-content-end mb-4">
                                <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.auth.forgot-password') }}"
                                    class="small">¿Olvidaste tu contraseña?</a>
                            </div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-gray-800">Iniciar sesión</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
