<?php
/**
 * Company: CETAM
 * Project: ST
 * File: UserEdit.php
 * Created on: 12/12/2025
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

    /**

     * Initialize component state.

     *

     * @param mixed $id

     *

     * @return void

     */

    public function mount($id)
    {
        $user = User::with('worker')->findOrFail($id);

        $this->userId = $user->users_id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->is_active = $user->is_active;

        // If it is worker, cargar datos adicionales
        if ($user->role === 'worker' && $user->worker) {
            $this->curp = $user->worker->curp ?? '';
            $this->rfc = $user->worker->rfc ?? '';
            $this->phone = $user->worker->phone ?? '';
            $this->address = $user->worker->address ?? '';
            $this->department = $user->worker->department ?? '';
            $this->position = $user->worker->position ?? '';
        }
    }

    /**

     * Update user.

     *

     * @return void

     */

    public function updateUser()
    {
        try {
            // Always enforce the persisted role so it cannot be modified from the UI or requests
            $user = User::with('worker')->findOrFail($this->userId);
            $this->role = $user->role;

            $this->validate([
                'name' => 'required|string|max:150',
                'email' => [
                    'required',
                    'email',
                    'max:150',
                    Rule::unique('users', 'email')->ignore($this->userId, 'users_id')
                ],
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
                'password.min' => 'El campo contrasena debe tener al menos 8 caracteres',
                'password.same' => 'Los campos contrasena y confirmar contrasena deben coincidir',
                'curp.max' => 'El curp no debe exceder los 18 caracteres',
                'rfc.max' => 'El rfc no debe exceder los 13 caracteres',
                'phone.max' => 'El telefono no debe exceder los 20 caracteres',
                'address.max' => 'La direccion no debe exceder los 255 caracteres',
            ]);

            $user->name = $this->name;
            $user->email = $this->email;
            $user->is_active = $this->is_active;

            if (!empty($this->password)) {
                $user->password = Hash::make($this->password);
            }

            $user->save();

            // If it is worker, actualizar datos adicionales
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

            // Disparar evento para mostrar success alert
            $this->dispatch('user-updated');
        } catch (\Throwable $th) {
            session()->flash('error', 'No se pudo actualizar el usuario. Intenta de nuevo.');
        }
    }

    /**

     * Cancel.

     *

     * @return void

     */

    public function cancel()
    {
        return redirect()->route(config('proj.route_name_prefix', 'proj') . '.users.index');
    }

    /**

     * Render the component view.

     *

     * @return \Illuminate\View\View

     */

    public function render()
    {
        return view('modules.user-edit')->layout('layouts.app');
    }
}
