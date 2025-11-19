<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserCreate extends Component
{
    public $first_name = '';
    public $last_name = '';
    public $email = '';
    public $role = '';
    public $password = '';
    public $password_confirmation = '';
    public $gender = '';
    public $city = '';

    protected function rules()
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role' => ['required', 'string', 'in:secretary,worker'],
            'password' => ['required', 'string', 'confirmed', Password::min(8)],
            'gender' => ['nullable', 'string', 'in:Male,Female,Other'],
            'city' => ['nullable', 'string', 'max:255'],
        ];
    }

    protected $messages = [
        'first_name.required' => 'El nombre es obligatorio.',
        'last_name.required' => 'Los apellidos son obligatorios.',
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
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'gender' => $this->gender,
                'city' => $this->city,
            ]);

            // Assign the role
            $user->assignRole($this->role);

            session()->flash('success', 'Usuario creado exitosamente.');

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
