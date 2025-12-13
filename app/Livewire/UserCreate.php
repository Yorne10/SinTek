<?php
/**
 * Company: CETAM
 * Project: ST
 * File: UserCreate.php
 * Created on: 24/11/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 *
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Worker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserCreate extends Component
{
    public $name = '';
    public $email = '';
    public $role = '';
    public $password = '';
    public $password_confirmation = '';

    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'string', 'email', 'max:150', 'unique:users'],
            'role' => ['required', 'string', 'in:admin,secretary,worker'],
            'password' => ['required', 'string', 'confirmed', Password::min(8)],
        ];
    }

    protected $messages = [
        'name.required' => 'El campo nombre es obligatorio',
        'name.max' => 'El nombre no debe exceder los 150 caracteres',
        'email.required' => 'El campo correo electrónico es obligatorio',
        'email.email' => 'El correo electrónico debe ser válido',
        'email.unique' => 'El correo electrónico ya está registrado',
        'email.max' => 'El correo electrónico no debe exceder los 150 caracteres',
        'role.required' => 'El campo rol es obligatorio',
        'role.in' => 'La opción seleccionada en rol no es válida',
        'password.required' => 'El campo contraseña es obligatorio',
        'password.confirmed' => 'Los campos contraseña y confirmar contraseña deben coincidir',
        'password.min' => 'El campo contraseña debe tener al menos 8 caracteres',
    ];

    /**

     * Save the data.

     *

     * @return void

     */

    public function save()
    {
        $this->validate();

        try {
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'role' => $this->role,
                'is_active' => true,
            ]);

            if ($this->role === 'worker') {
                Worker::create([
                    'user_id' => $user->users_id,
                    'curp' => null,
                    'sex' => null,
                    'phone' => null,
                    'address' => null,
                    'rfc' => null,
                ]);
            }

            // Guardar el nombre antes de limpiar
            $userName = $this->name;

            // Limpiar el formulario
            $this->reset(['name', 'email', 'role', 'password', 'password_confirmation']);

            $this->dispatch(
                'user-created',
                type: 'success',
                title: '¡Usuario creado exitosamente!',
                message: 'El usuario ' . $userName . ' ha sido registrado correctamente. Podrá completar su información personal desde su perfil.'
            );

        } catch (\Exception $e) {
            $this->dispatch(
                'user-created',
                type: 'error',
                title: 'Error al crear el usuario',
                message: $e->getMessage()
            );
        }
    }

    /**

     * Render the component view.

     *

     * @return \Illuminate\View\View

     */

    public function render()
    {
        return view('modules.user-create')->layout('layouts.app');
    }
}

