<?php

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
    public $adress;

    // Worker fields (non-editable)
    public $sex;

    // Position fields
    public $budgetKey = '';
    public $positionName = '';

    public function rules()
    {
        $rules = [
            'name' => 'required|string|max:150',
            'email' => ['required', 'email', 'max:150', Rule::unique('users', 'email')->ignore($this->user->users_id, 'users_id')],
        ];

        // Add worker-specific rules if user is a worker
        if ($this->user->role === 'worker') {
            $rules['curp'] = 'nullable|string|max:20';
            $rules['rfc'] = 'nullable|string|max:20';
            $rules['phone'] = 'nullable|string|max:20';
            $rules['adress'] = 'nullable|string|max:255';
            $rules['sex'] = ['nullable', Rule::in(['M', 'F'])];
        }

        return $rules;
    }

    protected $messages = [
        'name.required' => 'El nombre es obligatorio.',
        'email.required' => 'El correo electrónico es obligatorio.',
        'email.email' => 'El correo electrónico debe ser válido.',
        'email.unique' => 'Este correo electrónico ya está registrado.',
        'sex.in' => 'El sexo debe ser Masculino (M) o Femenino (F).',
    ];

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
                $this->adress = $this->worker->adress;
                $this->sex = $this->worker->sex;
            }
        }
    }

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
                    'adress' => $this->adress,
                    'sex' => $this->sex,
                ]);
            } else {
                // Update existing worker profile
                $this->worker->update([
                    'curp' => $this->curp,
                    'rfc' => $this->rfc,
                    'phone' => $this->phone,
                    'adress' => $this->adress,
                    'sex' => $this->sex,
                ]);
            }
        }
    }

    public function addBudgetKey(): void
    {
        if ($this->user->role !== 'worker') {
            return;
        }

        $this->validate([
            'budgetKey' => 'required|string|max:100',
            'positionName' => 'nullable|string|max:150',
        ], [
            'budgetKey.required' => 'La clave presupuestal es obligatoria.',
            'budgetKey.max' => 'La clave presupuestal debe tener máximo 100 caracteres.',
            'positionName.max' => 'El nombre de la plaza debe tener máximo 150 caracteres.',
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

        $budgetKey = trim($this->budgetKey);
        $positionName = trim((string) $this->positionName);

        if ($budgetKey === '') {
            $this->addError('budgetKey', 'La clave presupuestal no puede estar vacía.');
            return;
        }

        if (!$this->worker) {
            $this->worker = Worker::create([
                'user_id' => $this->user->users_id,
                'curp' => $this->curp,
                'rfc' => $this->rfc,
                'phone' => $this->phone,
                'adress' => $this->adress,
                'sex' => $this->sex,
            ]);
        }

        $position = Position::firstOrCreate(
            ['budget_key' => $budgetKey],
            ['position_name' => $positionName ?: $budgetKey]
        );

        $this->worker->positions()->syncWithoutDetaching([$position->positions_id]);
        $this->worker = $this->worker->fresh(['positions']);

        $this->reset(['budgetKey', 'positionName']);

        $this->dispatch(
            'profile-notify',
            type: 'success',
            title: 'Clave agregada',
            message: 'Se agregó la clave presupuestal a tu perfil.'
        );
    }

    public function render()
    {
        return view('modules.profile')->layout('layouts.app');
    }
}

