{{--
    Company: CETAM
    Project: ST
    File: perfil.blade.php
    Created on: 06/11/2025
    Created by: Alfonso Angel Garcia Hernandez
    Approved by: Alfonso Angel Garcia Hernandez

    Changelog:
    - ID: <ID> | Date: dd/mm/yyyy
      Modified by: <Developer name>
      Description: <Brief description of change>
--}}

{{-- Nota Livewire: esta vista debe tener UN nico elemento raz --}}
{{-- El layout se aplica desde el componente con ->layout('layouts.app') --}}

<div>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item">
                        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.dashboard.index') }}">
                            @icon('nav.home', 'icon icon-xxs')
                        </a>
                    </li>
                    <li class="breadcrumb-item">Administracin</li>
                    <li class="breadcrumb-item active" aria-current="page">Mi perfil</li>
                </ol>
            </nav>
            <h2 class="h4">Mi perfil</h2>
            <p class="mb-0">Gestiona tu informacin personal y preferencias del sistema.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-xl-8">
            @if($showSavedAlert)
            <div class="alert alert-success" role="alert">
                Cambios guardados correctamente!
            </div>
            @endif
            <div class="card card-body border-0 shadow mb-4">
                <h2 class="h5 mb-4">Informacin general</h2>
                <form wire:submit.prevent="save" action="#" method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div>
                                <label for="first_name">Nombre(s)</label>
                                <input wire:model="user.first_name" class="form-control" id="first_name" type="text"
                                    placeholder="Ingresa tu nombre" required>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div>
                                <label for="last_name">Apellidos</label>
                                <input wire:model="user.last_name" class="form-control" id="last_name" type="text"
                                    placeholder="Ingresa tus apellidos">
                            </div>
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="email">Correo electrnico</label>
                                <input wire:model="user.email" class="form-control" id="email" type="email"
                                    placeholder="correo@empresa.com" disabled>
                                <small class="form-text text-muted">El correo no puede ser modificado</small>
                            </div>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="gender">Gnero</label>
                            <select wire:model="user.gender" class="form-select mb-0" id="gender"
                                aria-label="Seleccionar gnero">
                                <option selected>Seleccionar...</option>
                                <option value="Female">Femenino</option>
                                <option value="Male">Masculino</option>
                                <option value="Other">Otro</option>
                            </select>
                            @error('user.gender') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <h2 class="h5 my-4">Ubicacin</h2>
                    <div class="row">
                        <div class="col-sm-9 mb-3">
                            <div class="form-group">
                                <label for="address">Direccin</label>
                                <input wire:model="user.address" class="form-control" id="address" type="text"
                                    placeholder="Calle y colonia">
                            </div>
                            @error('user.address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-sm-3 mb-3">
                            <div class="form-group">
                                <label for="number">Nmero</label>
                                <input wire:model="user.number" class="form-control" id="number" type="number"
                                    placeholder="No.">
                            </div>
                            @error('user.number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <div class="form-group">
                                <label for="city">Ciudad</label>
                                <input wire:model="user.city" class="form-control" id="city" type="text"
                                    placeholder="Ciudad">
                            </div>
                            @error('user.city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="zip">Cdigo Postal</label>
                                <input wire:model="user.ZIP" class="form-control" id="zip" type="tel" placeholder="C.P.">
                            </div>
                        </div>
                        @error('user.ZIP') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-gray-800 mt-2 animate-up-2">Guardar cambios</button>
                    </div>
                </form>
                @if($showDemoNotification)
                <div class="alert alert-info mt-2" role="alert">
                    No puedes hacer esto en la versin de demostracin.
                </div>
                @endif
            </div>
        </div>
        <div class="col-12 col-xl-4">
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="card shadow border-0 text-center p-0">
                        <div wire:ignore.self class="profile-cover rounded-top"
                            data-background="{{ asset('assets/img/profile-cover.jpg') }}"></div>
                        <div class="card-body pb-5">
                            <img src="{{ asset('assets/img/team/profile-picture-1.jpg') }}"
                                class="avatar-xl rounded-circle mx-auto mt-n7 mb-4" alt="Foto de perfil">
                            <h4 class="h3">
                                {{  auth()->user()->first_name ? auth()->user()->first_name . ' ' . auth()->user()->last_name : 'Nombre de Usuario'}}
                            </h4>
                            <h5 class="fw-normal">Administrador del Sistema</h5>
                            <p class="text-gray mb-4">{{ auth()->user()->city ?? 'Ciudad' }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card border-0 shadow">
                        <div class="card-body">
                            <h2 class="h6 mb-3">Informacin de cuenta</h2>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item px-0 d-flex justify-content-between">
                                    <span class="fw-bold">Rol:</span>
                                    <span class="badge bg-primary">Administrador</span>
                                </li>
                                <li class="list-group-item px-0 d-flex justify-content-between">
                                    <span class="fw-bold">Estado:</span>
                                    <span class="badge bg-success">Activo</span>
                                </li>
                                <li class="list-group-item px-0 d-flex justify-content-between">
                                    <span class="fw-bold">Email:</span>
                                    <span class="text-gray-700">{{ auth()->user()->email }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
