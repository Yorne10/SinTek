{{--
    Company: CETAM
    Project: ST
    File: profile.blade.php
    Created on: 20/11/2025
    Created by: Alfonso Angel Garcia Hernandez
    Approved by: Alfonso Angel Garcia Hernandez
--}}

{{-- Nota Livewire: esta vista debe tener UN único elemento raíz --}}
{{-- El layout se aplica desde el componente con ->layout('layouts.app') --}}

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
                    <li class="breadcrumb-item active" aria-current="page">Mi perfil</li>
                </ol>
            </nav>
            <h2 class="h4">Mi perfil</h2>
            <p class="mb-0">Gestiona tu información personal y mantén tus datos actualizados.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-xl-8">
            <div class="card card-body border-0 shadow mb-4">
                <h2 class="h5 mb-4">Información general</h2>
                <form id="profileForm" action="#" method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="name">Nombre completo <span class="text-danger">*</span></label>
                                <input wire:model="name" class="form-control @error('name') is-invalid @enderror"
                                    id="name" type="text" placeholder="Nombre completo" readonly>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <small class="form-text text-muted">El nombre no es editable</small>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="email">Correo electrónico <span class="text-danger">*</span></label>
                                <input wire:model="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" type="email" placeholder="correo@ejemplo.com" required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    @if($user->role === 'worker')
                    <h2 class="h5 my-4">Información personal del trabajador</h2>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="sex">Sexo</label>
                                <select wire:model="sex" class="form-select @error('sex') is-invalid @enderror"
                                    id="sex" disabled>
                                    <option value="">No especificado</option>
                                    <option value="M">Masculino</option>
                                    <option value="F">Femenino</option>
                                </select>
                                @error('sex') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <small class="form-text text-muted">El sexo no es editable</small>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="curp">CURP</label>
                                <input wire:model="curp" class="form-control @error('curp') is-invalid @enderror"
                                    id="curp" type="text" placeholder="CURP de 18 caracteres">
                                @error('curp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="rfc">RFC</label>
                                <input wire:model="rfc" class="form-control @error('rfc') is-invalid @enderror"
                                    id="rfc" type="text" placeholder="RFC con homoclave">
                                @error('rfc') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="phone">Teléfono</label>
                                <input wire:model="phone" class="form-control @error('phone') is-invalid @enderror"
                                    id="phone" type="text" placeholder="Número de teléfono">
                                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label for="adress">Dirección</label>
                                <textarea wire:model="adress" class="form-control @error('adress') is-invalid @enderror"
                                    id="adress" rows="3" placeholder="Dirección completa"></textarea>
                                @error('adress') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="mt-3">
                        <button type="button" id="saveProfileBtn" class="btn btn-primary mt-2 animate-up-2">
                            <span class="fas fa-save me-2"></span>
                            Guardar cambios
                        </button>
                    </div>
                </form>
            </div>

            @if($user->role === 'worker')
            <div class="card card-body border-0 shadow mb-4">
                <h2 class="h5 mb-4">Claves presupuestales (plazas)</h2>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="budgetKey" class="form-label">Clave presupuestal <span class="text-danger">*</span></label>
                        <input wire:model.defer="budgetKey" id="budgetKey" type="text" class="form-control @error('budgetKey') is-invalid @enderror" placeholder="Ej. DOC-TIT-001">
                        @error('budgetKey') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="positionName" class="form-label">Nombre de la plaza (opcional)</label>
                        <input wire:model.defer="positionName" id="positionName" type="text" class="form-control @error('positionName') is-invalid @enderror" placeholder="Ej. Docente Titular">
                        @error('positionName') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <button type="button" class="btn btn-outline-primary" wire:click="addBudgetKey" wire:loading.attr="disabled" wire:target="addBudgetKey">
                        <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true" wire:loading wire:target="addBudgetKey"></span>
                        Agregar clave
                    </button>
                    <span class="text-gray-600 small ms-3">Agrega tus plazas para que queden ligadas a tu perfil.</span>
                </div>

                <div class="mt-4">
                    <h6 class="text-gray-700 mb-2">Tus claves registradas</h6>
                    <div class="d-flex flex-wrap gap-2">
                        @if($worker && $worker->positions && $worker->positions->count() > 0)
                            @foreach($worker->positions as $position)
                                <span class="badge bg-light text-dark border">
                                    <span class="fw-bold">{{ $position->budget_key }}</span>
                                    @if($position->position_name)
                                        <small class="text-muted ms-1">{{ $position->position_name }}</small>
                                    @endif
                                </span>
                            @endforeach
                        @else
                            <span class="text-gray-500 small">Aún no registras claves.</span>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>

        <div class="col-12 col-xl-4">
            <div class="card border-0 shadow">
                <div class="card-body text-center">
                    <div class="mb-4">
                        <div class="avatar-xl rounded-circle mx-auto d-flex align-items-center justify-content-center bg-primary text-white fw-bold" style="width: 128px; height: 128px; font-size: 3rem; margin: 0 auto;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}{{ strtoupper(substr(explode(' ', $user->name)[1] ?? '', 0, 1)) }}
                        </div>
                    </div>
                    <h4 class="h5 mb-2">{{ $user->name }}</h4>
                    <p class="text-gray mb-3">
                    @if($user->role === 'admin')
                        <span class="fw-bold text-primary">Administrador</span>
                    @elseif($user->role === 'secretary')
                        <span class="fw-bold text-secondary">Secretario(a)</span>
                    @elseif($user->role === 'worker')
                        <span class="fw-bold text-info">Trabajador(a)</span>
                    @endif
                    </p>
                    <p class="text-sm text-gray-600">{{ $user->email }}</p>
                </div>
            </div>

            @if($user->role === 'worker' && $worker)
            <div class="card border-0 shadow mt-4">
                <div class="card-body">
                    <h2 class="h6 mb-3">Información del trabajador</h2>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-gray-600">CURP:</span>
                            <span class="fw-bold">{{ $worker->curp ?? 'No especificado' }}</span>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-gray-600">RFC:</span>
                            <span class="fw-bold">{{ $worker->rfc ?? 'No especificado' }}</span>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-gray-600">Sexo:</span>
                            <span class="fw-bold">
                                @if($worker->sex === 'M')
                                    Masculino
                                @elseif($worker->sex === 'F')
                                    Femenino
                                @else
                                    No especificado
                                @endif
                            </span>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-gray-600">Teléfono:</span>
                            <span class="fw-bold">{{ $worker->phone ?? 'No especificado' }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            @if($worker->positions && $worker->positions->count() > 0)
            <div class="card border-0 shadow mt-4">
                <div class="card-body">
                    <h2 class="h6 mb-3">Posiciones asignadas</h2>
                    <ul class="list-group list-group-flush">
                        @foreach($worker->positions as $position)
                        <li class="list-group-item px-0">
                            <div class="d-flex align-items-start">
                                <div class="icon icon-shape icon-sm icon-shape-primary rounded me-2">
                                    <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                        <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h6 class="mb-0">{{ $position->position_name }}</h6>
                                    <small class="text-gray-600">Clave: {{ $position->budget_key }}</small>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
            @endif

            @if($user->role === 'worker')
            <div class="card border-0 shadow mt-4">
                <div class="card-body">
                    <h2 class="h6 mb-3">Información importante</h2>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0">
                            <div class="d-flex align-items-start">
                                <span class="icon icon-sm text-info me-3 fas fa-info-circle"></span>
                                <div>
                                    <h6 class="mb-1">Campos no editables</h6>
                                    <p class="text-gray-600 small mb-0">
                                        El nombre y el sexo no pueden ser modificados. Para cambios, contacta al administrador.
                                    </p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-primary me-2',
            cancelButton: 'btn btn-gray'
        },
        buttonsStyling: false
    });

    // Botn de guardar con confirmacin
    document.getElementById('saveProfileBtn').addEventListener('click', function() {
        swalWithBootstrapButtons.fire({
            title: '¿Estás seguro?',
            text: '¿Deseas guardar los cambios realizados en tu perfil?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, guardar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                @this.call('save').then(() => {
                    swalWithBootstrapButtons.fire({
                        icon: 'success',
                        title: '¡Guardado!',
                        text: 'Tu información ha sido actualizada correctamente.',
                        showConfirmButton: true,
                        timer: 2000
                    });
                });
            }
        });
    });

    // Escuchar evento cuando se muestre la notificacin demo
    @if($showDemoNotification)
        swalWithBootstrapButtons.fire({
            icon: 'warning',
            title: 'Modo Demo',
            text: 'No puedes realizar esta acción en la versión de demostración.',
            showConfirmButton: true
        });
    @endif

    if (window.Livewire) {
        Livewire.on('profile-notify', (event) => {
            const detail = event || {};
            swalWithBootstrapButtons.fire({
                icon: detail.type || 'success',
                title: detail.title || 'Aviso',
                text: detail.message || '',
                confirmButtonText: 'Aceptar',
                showConfirmButton: true
            });
        });
    }
});
</script>
