<?php
/**
 * Company: CETAM
 * Project: ST
 * File: Login.php
 * Created on: 09/12/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 *
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

namespace App\Livewire\Auth;

use App\Models\User;
use Livewire\Component;

class Login extends Component
{

    public $email = '';
    public $password = '';
    public $remember_me = false;

    protected function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ];
    }

    protected function messages()
    {
        return [
            'email.required' => 'El campo correo electrónico es obligatorio',
            'email.email' => 'El correo electrónico debe ser válido',
            'password.required' => 'El campo contraseña es obligatorio',
            'password.min' => 'El campo contraseña debe tener al menos 8 caracteres',
        ];
    }

    //This mounts the default credentials for the admin. Remove this section if you want to make it public.
    /**
     * Initialize component state.
     *
     * @return void
     */
    public function mount()
    {
        if (auth()->user()) {
            // Redirect to dashboard with new route scheme
            return redirect()->intended(route(config('proj.route_name_prefix', 'proj') . '.dashboard.index'));
        }
        // Initialize empty credentials for institutional login
        $this->fill([
            'email' => '',
            'password' => '',
            'remember_me' => false,
        ]);
    }

    /**

     * Authenticate user and generate access token.

     *

     * @return \Illuminate\Http\JsonResponse

     */

    public function login()
    {
        $credentials = $this->validate();
        if (auth()->attempt(['email' => $this->email, 'password' => $this->password], $this->remember_me)) {
            $user = User::where(['email' => $this->email])->first();

            // Block access if user is inactive
            if (!$user->is_active) {
                auth()->logout();
                return $this->addError('email', 'Su cuenta ha sido deshabilitada temporalmente');
            }

            // In local environment, bypass verification/approval to streamline development
            if (!app()->environment('local')) {
                // Enforce email verification
                if (is_null($user->email_verified_at)) {
                    auth()->logout();
                    return $this->addError('email', __('Debes verificar tu correo electrónico antes de iniciar sesión'));
                }
                // Enforce secretary approval
                if (is_null($user->approved_at)) {
                    auth()->logout();
                    return $this->addError('email', __('Tu cuenta aún no ha sido aprobada por un secretario'));
                }
            }
            // Already authenticated by attempt(); redirect to dashboard
            $route = config('proj.route_name_prefix', 'proj') . '.dashboard.index';
            return redirect()->route($route);
        } else {
            return $this->addError('email', trans('auth.failed'));
        }
    }

    /**

     * Render the component view.

     *

     * @return \Illuminate\View\View

     */

    public function render()
    {
        // Apply app layout; content is injected via $slot
        return view('modules.auth.login')->layout('layouts.app');
    }
}

