<?php
/**
 * Empresa: CETAM
 * Proyecto: ST
 * Archivo: Login.php
 * Fecha de creación: 02/11/25
 * Realizado por: Alfonso Angel García Hernández
 * Validado por: Alfonso Angel García Hernández
 */

namespace App\Livewire\Auth;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Rule;

class Login extends Component
{

    #[Rule('required|email')]
    public $email = '';

    #[Rule('required|min:6')]
    public $password = '';

    public $remember_me = false;

    //This mounts the default credentials for the admin. Remove this section if you want to make it public.
    public function mount()
    {
        if (auth()->user()) {
            // Redirigir al dashboard con el nuevo esquema de rutas
            return redirect()->intended(route(config('proj.route_name_prefix', 'proj') . '.dashboard.index'));
        }
        // Initialize empty credentials for institutional login
        $this->fill([
            'email' => '',
            'password' => '',
            'remember_me' => false,
        ]);
    }

    public function login()
    {
        $credentials = $this->validate();
        if (auth()->attempt(['email' => $this->email, 'password' => $this->password], $this->remember_me)) {
            $user = User::where(['email' => $this->email])->first();
            // In local environment, bypass verification/approval to streamline development
            if (!app()->environment('local')) {
                // Enforce email verification
                if (is_null($user->email_verified_at)) {
                    auth()->logout();
                    return $this->addError('email', __('Debes verificar tu correo electrónico antes de iniciar sesión.'));
                }
                // Enforce secretary approval
                if (is_null($user->approved_at)) {
                    auth()->logout();
                    return $this->addError('email', __('Tu cuenta aún no ha sido aprobada por un secretario.'));
                }
            }
            // Ya estamos autenticados por attempt(); redirigir al dashboard
            $route = config('proj.route_name_prefix', 'proj') . '.dashboard.index';
            return redirect()->route($route);
        } else {
            return $this->addError('email', trans('auth.failed'));
        }
    }

    public function render()
    {
        // Aplicar layout de la app; el contenido se inyectará vía $slot
        return view('modules.auth.login')->layout('layouts.app');
    }
}

