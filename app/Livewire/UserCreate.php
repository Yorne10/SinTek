<?php

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
        'name.required' => 'El nombre completo es obligatorio.',
        'email.required' => 'El correo electrónico es obligatorio.',
        'email.email' => 'El correo electrónico debe ser válido.',
        'email.unique' => 'Este correo electrónico ya está registrado.',
        'role.required' => 'El rol es obligatorio.',
        'role.in' => 'El rol seleccionado no es válido.',
        'password.required' => 'La contraseña es obligatoria.',
        'password.confirmed' => 'Las contraseñas no coinciden.',
        'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
    ];

    public function save()
    {
        $this->validate();

        try {
            // Create the user
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'role' => $this->role,
                'active' => 1,
            ]);

            // If worker, create empty worker profile (to be completed by user in their profile)
            if ($this->role === 'worker') {
                Worker::create([
                    'user_id' => $user->users_id,
                    'curp' => null,
                    'sex' => null,
                    'phone' => null,
                    'adress' => null,
                    'rfc' => null,
                ]);
            }

            session()->flash('success', 'Usuario creado exitosamente. El usuario podrá completar su información personal desde su perfil.');

            // Redirect to users list
            return redirect()->route(config('proj.route_name_prefix', 'proj') . '.users.index');

        } catch (\Exception $e) {
            session()->flash('error', 'Error al crear el usuario: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.user-create')->layout('layouts.app');
    }
}
