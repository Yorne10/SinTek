<?php
/**
 * Company: CETAM
 * Project: ST
 * File: Profile.php
 * Created on: 04/12/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 *
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

namespace App\Livewire;

use App\Models\User;
use App\Models\Worker;
use App\Models\Position;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Profile extends Component
{
    public User $user;
    public $worker;
    public $showDemoNotification = false;

    // User fields
    public $name;
    public $email;

    // Worker fields (editable)
    public $curp;
    public $rfc;
    public $phone;
    public $address;  // Corrected from 'adress'

    // Worker fields (non-editable)
    public $sex;

    // Position fields
    public $budgetKey = '';
    public $availablePositions = [];

    /**
     * Mostrar confirmación antes de agregar una clave.
     */
    public function confirmAddKey(): void
    {
        $this->dispatch('confirm-add-key');
    }

    /**

     * Rules.

     *

     * @return void

     */

    public function rules()
    {
        $rules = [
            'name' => 'required|string|max:150',
            'email' => ['required', 'email', 'max:150', Rule::unique('users', 'email')->ignore($this->user->users_id, 'users_id')],
        ];

        // Add worker-specific rules if user is a worker
        if ($this->user->role === 'worker') {
            $rules['curp'] = 'nullable|string|max:18';
            $rules['rfc'] = 'nullable|string|max:13';
            $rules['phone'] = 'nullable|string|max:20';
            $rules['address'] = 'nullable|string|max:255';
            $rules['sex'] = ['nullable', Rule::in(['M', 'F'])];
        }

        return $rules;
    }

    protected $messages = [
        'name.required' => 'El campo nombre es obligatorio',
        'name.max' => 'El nombre no debe exceder los 150 caracteres',
        'email.required' => 'El campo correo electronico es obligatorio',
        'email.email' => 'El correo electronico debe ser valido',
        'email.unique' => 'El correo electronico ya esta registrado',
        'email.max' => 'El correo electronico no debe exceder los 150 caracteres',
        'curp.max' => 'El curp no debe exceder los 18 caracteres',
        'rfc.max' => 'El rfc no debe exceder los 13 caracteres',
        'phone.max' => 'El telefono no debe exceder los 20 caracteres',
        'address.max' => 'La direccion no debe exceder los 255 caracteres',
        'sex.in' => 'La opcion seleccionada en sexo no es valida',
    ];

    /**

     * Initialize component state.

     *

     * @return void

     */

    public function mount()
    {
        $this->user = auth()->user();
        $this->name = $this->user->name;
        $this->email = $this->user->email;

        // Load worker data if user is a worker
        if ($this->user->role === 'worker') {
            $this->worker = $this->user->worker ? $this->user->worker->load('positions') : null;
            if ($this->worker) {
                $this->curp = $this->worker->curp;
                $this->rfc = $this->worker->rfc;
                $this->phone = $this->worker->phone;
                $this->address = $this->worker->address;
                $this->sex = $this->worker->sex;
            }
            $this->availablePositions = Position::orderBy('budget_key')->get([
                'positions_id',
                'budget_key',
                'position_name',
            ])->toArray();
        }
    }

    /**

     * Save the data.

     *

     * @return void

     */

    public function save()
    {
        if (env('IS_DEMO')) {
            $this->showDemoNotification = true;
            return;
        }

        $this->validate();

        // Update user
        $this->user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        // Update worker data if user is a worker
        if ($this->user->role === 'worker') {
            if (!$this->worker) {
                // Create worker profile if it doesn't exist
                $this->worker = Worker::create([
                    'user_id' => $this->user->users_id,
                    'curp' => $this->curp,
                    'rfc' => $this->rfc,
                    'phone' => $this->phone,
                    'address' => $this->address,
                    'sex' => $this->sex,
                ]);
            } else {
                // Update existing worker profile
                $this->worker->update([
                    'curp' => $this->curp,
                    'rfc' => $this->rfc,
                    'phone' => $this->phone,
                    'address' => $this->address,
                    'sex' => $this->sex,
                ]);
            }
        }

        $this->dispatch('profile-saved');
    }

    /**

     * Add budget key.

     *

     * @return void

     */

    public function addBudgetKey(): void
    {
        if ($this->user->role !== 'worker') {
            return;
        }

        $this->validate([
            'budgetKey' => 'required|integer|exists:positions,positions_id',
        ], [
            'budgetKey.required' => 'La clave presupuestal es obligatoria.',
            'budgetKey.exists' => 'La clave presupuestal seleccionada no existe.',
        ]);

        if (env('IS_DEMO')) {
            $this->dispatch(
                'profile-notify',
                type: 'warning',
                title: 'Modo Demo',
                message: 'No puedes agregar claves en la versión de demostración.'
            );
            return;
        }

        $positionId = (int) $this->budgetKey;

        if (!$this->worker) {
            $this->worker = Worker::create([
                'user_id' => $this->user->users_id,
                'curp' => $this->curp,
                'rfc' => $this->rfc,
                'phone' => $this->phone,
                'address' => $this->address,
                'sex' => $this->sex,
            ]);
        }

        // Verify si ya tiene esta clave
        if ($this->worker->positions()->where('positions.positions_id', $positionId)->exists()) {
            $this->dispatch(
                'profile-notify',
                type: 'warning',
                title: 'Clave duplicada',
                message: 'Esta clave ya está registrada en tu perfil.'
            );
            return;
        }

        // Agregar la relación en la tabla positions_workers
        $this->worker->positions()->attach($positionId);
        $this->worker = $this->worker->fresh(['positions']);

        $this->reset(['budgetKey']);

        $this->dispatch(
            'profile-notify',
            type: 'success',
            title: 'Clave agregada',
            message: 'Se agregó la clave presupuestal a tu perfil.'
        );
    }

    /**

     * Remove budget key.

     *

     * @param mixed $positionId

     *

     * @return void

     */

    public function removeBudgetKey($positionId): void
    {
        if (!$this->worker) {
            return;
        }

        $this->worker->positions()->detach($positionId);
        $this->worker = $this->worker->fresh(['positions']);

        $this->dispatch(
            'profile-notify',
            type: 'success',
            title: 'Clave eliminada',
            message: 'Se eliminó la clave presupuestal de tu perfil.'
        );
    }

    /**

     * Render the component view.

     *

     * @return \Illuminate\View\View

     */

    public function render()
    {
        return view('modules.profile')->layout('layouts.app');
    }
}
