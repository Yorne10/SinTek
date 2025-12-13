<?php
/**
 * Company: CETAM
 * Project: ST
 * File: Register.php
 * Created on: 03/11/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 *
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use App\Models\Worker;
use App\Models\Position;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Attributes\Rule;

class Register extends Component
{

    // User data
    #[Rule('required|string|max:100')]
    public $first_name = '';

    #[Rule('required|string|max:100')]
    public $last_name = '';

    #[Rule('required|email|unique:users,email')]
    public $email = '';

    // Sexo: M/F
    #[Rule('required|in:M,F')]
    public $gender = '';

    // CURP (18 chars)
    #[Rule('required|regex:/^[A-Z]{4}[0-9]{6}[HM][A-Z]{5}[0-9]{2}$/i')]
    public $curp = '';

    // Claves presupuestales (texto)
    #[Rule('required|string|max:2000')]
    public $budget_keys = '';

    // Auth
    #[Rule('required|min:8')]
    public $password = '';

    #[Rule('required|same:password')]
    public $passwordConfirmation = '';

    /**

     * Initialize component state.

     *

     * @return void

     */

    public function mount()
    {
        if (auth()->user()) {
            return redirect()->intended(route(config('proj.route_name_prefix', 'proj') . '.dashboard.index'));
        }
    }

    /**

     * Updated email.

     *

     * @return void

     */

    public function updatedEmail()
    {
        $this->validate(['email' => 'required|email|unique:users,email']);
    }

    /**

     * Register a new user account.

     *

     * @return \Illuminate\Http\JsonResponse

     */

    public function register()
    {
        $validated = $this->validate();

        DB::transaction(function () use (&$user) {
            $user = User::create([
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'gender' => $this->gender,
                'email' => $this->email,
                'curp' => strtoupper($this->curp),
                'budget_keys' => $this->budget_keys,
                'password' => Hash::make($this->password),
                'remember_token' => Str::random(10),
                // email_verified_at => null (default)
                // approved_at => null (pending secretary approval)
            ]);

            // In local environment, mark as verified and approved for faster dev loop
            if (app()->environment('local')) {
                $user->forceFill([
                    'email_verified_at' => now(),
                    'approved_at' => now(),
                ])->save();
            }

            // Create Worker profile
            $worker = Worker::create([
                'user_id' => $user->id,
                'curp' => strtoupper($this->curp),
                'sexo' => strtoupper($this->gender),
            ]);

            // Parse budget_keys into Position rows
            $keys = preg_split('/[\n,;]+/', (string) $this->budget_keys);
            foreach ($keys as $key) {
                $budgetKey = trim($key);
                if ($budgetKey === '')
                    continue;
                Position::create([
                    'worker_id' => $worker->id,
                    'clave_presupuestal' => $budgetKey,
                    'plaza' => null,
                    'puesto' => null,
                ]);
            }
        });

        // In local env, auto-login and go straight to dashboard
        if (app()->environment('local') && isset($user)) {
            auth()->login($user, true);
            $route = config('proj.route_name_prefix', 'proj') . '.dashboard.index';
            return redirect()->route($route);
        }

        // In non-local env: send email verification and take user to login page
        if (isset($user) && method_exists($user, 'sendEmailVerificationNotification')) {
            try {
                $user->sendEmailVerificationNotification();
            } catch (\Throwable $e) {
                // Log but do not break registration if mail is misconfigured
                logger()->warning('Email verification not sent: ' . $e->getMessage());
            }
        }

        session()->flash('status', __('Hemos enviado un enlace de verificación a tu correo. Tu cuenta quedará activa cuando un secretario la apruebe.'));
        return redirect()->route(config('proj.route_name_prefix', 'proj') . '.auth.login');
    }

    /**

     * Render the component view.

     *

     * @return \Illuminate\View\View

     */

    public function render()
    {
        return view('modules.auth.register')->layout('layouts.app');
    }
}

