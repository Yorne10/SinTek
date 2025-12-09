{{--
* Company: CETAM
* Project: ST
* File: profile.blade.php
* Created on: 06/11/2025
* Created by: Alfonso Angel Garcia Hernandez
* Approved by: Alfonso Angel Garcia Hernandez
--}}

<div>
    {{-- Livewire Note: this view must have ONE single root element --}}
    {{-- Layout is applied from the component with ->layout('layouts.app') --}}

    <div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
            <div class="d-block mb-4 mb-md-0">
                <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                    <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                        <li class="breadcrumb-item">
                            <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.dashboard.index') }}">
                                @icon('nav.home', 'fa-xs')
                            </a>
                        </li>
                        <li class="breadcrumb-item">Secretaría</li>
                        <li class="breadcrumb-item active" aria-current="page">Mi perfil</li>
                    </ol>
                </nav>
                <h2 class="h4">Mi perfil</h2>
                <p class="mb-0">Administra tu información personal y preferencias.</p>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-xl-8">
                @if($showSavedAlert)
                    <div class="alert alert-success" role="alert">
                        ¡Cambios guardados con éxito!
                    </div>
                @endif
                <div class="card card-body border-0 shadow mb-4">
                    <h2 class="h5 mb-4">Información general</h2>
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
                                    <label for="email">Correo</label>
                                    <input wire:model="user.email" class="form-control" id="email" type="email"
                                        placeholder="correo@empresa.com" disabled>
                                    <small class="form-text text-muted">El correo no puede ser modificado</small>
                                </div>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="gender">Género</label>
                                <select wire:model="user.gender" class="form-select mb-0" id="gender"
                                    aria-label="Select gender">
                                    <option selected>Selecciona...</option>
                                    <option value="Female">Femenino</option>
                                    <option value="Male">Masculino</option>
                                    <option value="Other">Otro</option>
                                </select>
                                @error('user.gender') <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <h2 class="h5 my-4">Ubicación</h2>
                        <div class="row">
                            <div class="col-sm-9 mb-3">
                                <div class="form-group">
                                    <label for="address">Dirección</label>
                                    <input wire:model="user.address" class="form-control" id="address" type="text"
                                        placeholder="Calle y colonia">
                                </div>
                                @error('user.address') <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-sm-3 mb-3">
                                <div class="form-group">
                                    <label for="number">Número</label>
                                    <input wire:model="user.number" class="form-control" id="number" type="number"
                                        placeholder="No.">
                                </div>
                                @error('user.number') <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
                                    <label for="zip">Código postal</label>
                                    <input wire:model="user.ZIP" class="form-control" id="zip" type="tel"
                                        placeholder="CP">
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
                            No puedes realizar esta acción en la versión demo.
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
                                <img src="{{ asset('assets/img/team/profile-picture-3.jpg') }}"
                                    class="avatar-xl rounded-circle mx-auto mt-n7 mb-4" alt="Profile Picture">
                                <h4 class="h3">
                                    {{  auth()->user()->first_name ? auth()->user()->first_name . ' ' . auth()->user()->last_name : 'Username'}}
                                </h4>
                                <h5 class="fw-normal">Equipo de secretaría</h5>
                                <p class="text-gray mb-4">{{ auth()->user()->city ?? 'Ciudad' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card border-0 shadow">
                            <div class="card-body">
                                <h2 class="h6 mb-3">Información de la cuenta</h2>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item px-0 d-flex justify-content-between">
                                        <span class="fw-bold me-1">Rol:</span>
                                        <span class="fw-bold text-secondary">Secretaría</span>
                                    </li>
                                    <li class="list-group-item px-0 d-flex justify-content-between">
                                        <span class="fw-bold">Estado:</span>
                                        <span class="badge bg-success">Activo</span>
                                    </li>
                                    <li class="list-group-item px-0 d-flex justify-content-between">
                                        <span class="fw-bold">Correo:</span>
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
</div>
