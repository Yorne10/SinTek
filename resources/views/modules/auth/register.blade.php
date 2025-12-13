{{--
Company: CETAM
Project: ST
File: register.blade.php
Created on: 28/11/2025
Created by: Alfonso Angel Garcia Hernandez
Approved by: Alfonso Angel Garcia Hernandez

Changelog:
- ID: <ID> | Date: dd/mm/yyyy
  Modified by: <Developer name>
  Description: <Brief description of change>
--}}

{{-- Nota Livewire: esta vista debe tener UN nico elemento raz --}}
{{-- El layout se aplica desde el componente con ->layout('layouts.app') --}}

@section('title', 'Crear cuenta - ' . config('app.name'))

<section class="min-vh-100 py-5 bg-soft d-flex align-items-center">
    <div class="container mb-5">
        {{-- <p class="text-center"><a href="{{ route('dashboard') }}" class="text-gray-700"><i
                    class="fas fa-angle-left me-2"></i> Back to homepage</a></p> --}}
        <div class="row justify-content-center form-bg-image"
            style="background: url('/assets/img/illustrations/signin.svg') center center no-repeat; background-size: cover;">
            <div class="col-12 d-flex align-items-center justify-content-center">
                <div class="bg-white shadow border-0 rounded border-light p-4 p-lg-5 w-100 fmxw-500">
                    <div class="text-center text-md-center mb-4 mt-md-0">
                        <h1 class="mb-0 h3">Crear cuenta</h1>
                        <p class="mb-0">Proporciona tus datos institucionales. Te enviaremos un correo de verificacin y
                            un secretario aprobar tu alta.</p>
                    </div>
                    <form wire:submit="register">
                        <!-- Nombre -->
                        <div class="form-group mt-3 mb-3">
                            <label for="first_name">Nombre(s)</label>
                            <input wire:model="first_name" id="first_name" type="text" class="form-control"
                                placeholder="Nombre(s)" required>
                            @error('first_name') <div class="invalid-feedback"> {{ $message }} </div> @enderror
                        </div>
                        <!-- Apellidos -->
                        <div class="form-group mb-3">
                            <label for="last_name">Apellidos</label>
                            <input wire:model="last_name" id="last_name" type="text" class="form-control"
                                placeholder="Apellidos" required>
                            @error('last_name') <div class="invalid-feedback"> {{ $message }} </div> @enderror
                        </div>
                        <!-- Correo institucional -->
                        <div class="form-group mb-3">
                            <label for="email">Correo institucional</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon3"><svg class="icon icon-xs text-gray-600"
                                        fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z">
                                        </path>
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                    </svg></span>
                                <input wire:model="email" id="email" type="email" class="form-control"
                                    placeholder="correo@institucion.com" required>
                            </div>
                            @error('email') <div class="invalid-feedback"> {{ $message }} </div> @enderror
                        </div>
                        <!-- CURP -->
                        <div class="form-group mb-3">
                            <label for="curp">CURP</label>
                            <input wire:model="curp" id="curp" type="text" class="form-control"
                                placeholder="Ej: PEGA800101HDFRRN09" maxlength="18" required>
                            @error('curp') <div class="invalid-feedback"> {{ $message }} </div> @enderror
                        </div>
                        <!-- Sexo -->
                        <div class="form-group mb-3">
                            <label for="gender">Sexo</label>
                            <select wire:model="gender" id="gender" class="form-select" required>
                                <option value="" disabled>Selecciona</option>
                                <option value="M">Masculino</option>
                                <option value="F">Femenino</option>
                            </select>
                            @error('gender') <div class="invalid-feedback"> {{ $message }} </div> @enderror
                        </div>
                        <!-- Claves presupuestales -->
                        <div class="form-group mb-3">
                            <label for="budget_keys">Claves presupuestales</label>
                            <textarea wire:model="budget_keys" id="budget_keys" class="form-control" rows="3"
                                placeholder="Describe tus claves presupuestales" required></textarea>
                            @error('budget_keys') <div class="invalid-feedback"> {{ $message }} </div> @enderror
                        </div>
                        <!-- Contraseña -->
                        <div class="form-group mb-3">
                            <label for="password">Contraseña</label>
                            <div class="input-group">
                                d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0
                                012-2zm8-2v2H7V7a3 3 0 016 0z"
                                clip-rule="evenodd"></path>
                                </svg></span>
                                <input name="password_confirmation" wire:model.lazy="passwordConfirmation"
                                    type="password" placeholder="Contrase&ntilde;a" class="form-control"
                                    id="confirm_password" required>
                            </div>
                        </div>
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-gray-800">Crear cuenta</button>
                        </div>
                    </form>
                    <div class="d-flex justify-content-center align-items-center mt-4">
                        <span class="fw-normal">
                            Ya tienes cuenta?
                            <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.auth.login') }}"
                                class="fw-bold">Inicia sesin</a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
</section>
