<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Worker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserEdit extends Component
{
    public $userId;
    public $name = '';
    public $email = '';
    public $role = '';
    public $is_active = true;
    public $password = '';
    public $password_confirmation = '';

    // Campos adicionales para Worker
    public $curp = '';
    public $rfc = '';
    public $phone = '';
    public $address = '';
    public $department = '';
    public $position = '';

    public function mount($id)
    {
        $user = User::with('worker')->findOrFail($id);

        $this->userId = $user->users_id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->is_active = $user->is_active;

        // Si es worker, cargar datos adicionales
        if ($user->role === 'worker' && $user->worker) {
            $this->curp = $user->worker->curp ?? '';
            $this->rfc = $user->worker->rfc ?? '';
            $this->phone = $user->worker->phone ?? '';
            $this->address = $user->worker->address ?? '';
            $this->department = $user->worker->department ?? '';
            $this->position = $user->worker->position ?? '';
        }
    }

    public function updateUser()
    {
        $this->validate([
            'name' => 'required|string|max:150',
            'email' => [
                'required',
                'email',
                'max:150',
                Rule::unique('users', 'email')->ignore($this->userId, 'users_id')
            ],
            'role' => 'required|in:admin,secretary,worker',
            'password' => 'nullable|min:8|same:password_confirmation',
            'curp' => 'nullable|string|max:18',
            'rfc' => 'nullable|string|max:13',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ], [
            'name.required' => 'El campo nombre es obligatorio',
            'name.max' => 'El nombre no debe exceder los 150 caracteres',
            'email.required' => 'El campo correo electronico es obligatorio',
            'email.email' => 'El correo electronico debe ser valido',
            'email.unique' => 'El correo electronico ya esta registrado',
            'email.max' => 'El correo electronico no debe exceder los 150 caracteres',
            'role.required' => 'El campo rol es obligatorio',
            'role.in' => 'La opcion seleccionada en rol no es valida',
            'password.min' => 'El campo contrasena debe tener al menos 8 caracteres',
            'password.same' => 'Los campos contrasena y confirmar contrasena deben coincidir',
            'curp.max' => 'El curp no debe exceder los 18 caracteres',
            'rfc.max' => 'El rfc no debe exceder los 13 caracteres',
            'phone.max' => 'El telefono no debe exceder los 20 caracteres',
            'address.max' => 'La direccion no debe exceder los 255 caracteres',
        ]);

        try {
            $user = User::findOrFail($this->userId);

            $user->name = $this->name;
            $user->email = $this->email;
            $user->role = $this->role;
            $user->is_active = $this->is_active;

            if (!empty($this->password)) {
                $user->password = Hash::make($this->password);
            }

            $user->save();

            // Si es worker, actualizar datos adicionales
            if ($this->role === 'worker') {
                Worker::updateOrCreate(
                    ['user_id' => $user->users_id],
                    [
                        'curp' => $this->curp,
                        'rfc' => $this->rfc,
                        'phone' => $this->phone,
                        'address' => $this->address,
                        'department' => $this->department,
                        'position' => $this->position,
                    ]
                );
            }

            session()->flash('success', 'Usuario actualizado correctamente');
            return redirect()->route(config('proj.route_name_prefix', 'proj') . '.users.index');
        } catch (\Throwable $th) {
            session()->flash('error', 'No se pudo actualizar el usuario. Intenta de nuevo.');
        }
    }

    public function cancel()
    {
        return redirect()->route(config('proj.route_name_prefix', 'proj') . '.users.index');
    }

    public function render()
    {
        return view('modules.user-edit')->layout('layouts.app');
    }
}
