<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Models\Worker;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class FallbackAuthService
{
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6'],
        ]);

        $remember = (bool) $request->boolean('remember');
        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']], $remember)) {
            $user = User::where('email', $data['email'])->first();
            if (!app()->environment('local')) {
                if (is_null($user->email_verified_at)) {
                    Auth::logout();
                    return back()->withErrors(['email' => __('Debes verificar tu correo electrónico antes de iniciar sesión.')]);
                }
                if (is_null($user->approved_at)) {
                    Auth::logout();
                    return back()->withErrors(['email' => __('Tu cuenta aún no ha sido aprobada por un secretario.')]);
                }
            }
            return redirect()->route(config('proj.route_name_prefix', 'proj') . '.dashboard.index');
        }

        return back()->withErrors(['email' => trans('auth.failed')]);
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'unique:users,email'],
            'gender' => ['required', 'in:M,F'],
            'curp' => ['required', 'regex:/^[A-Z]{4}[0-9]{6}[HM][A-Z]{5}[0-9]{2}$/i'],
            'budget_keys' => ['required', 'string', 'max:2000'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $user = null;
        DB::transaction(function () use (&$user, $data) {
            $user = User::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'gender' => $data['gender'],
                'email' => $data['email'],
                'curp' => strtoupper($data['curp']),
                'budget_keys' => $data['budget_keys'],
                'password' => Hash::make($data['password']),
                'remember_token' => Str::random(10),
            ]);

            if (app()->environment('local')) {
                $user->forceFill([
                    'email_verified_at' => now(),
                    'approved_at' => now(),
                ])->save();
            }

            $worker = Worker::create([
                'user_id' => $user->id,
                'curp' => strtoupper($data['curp']),
                'sexo' => strtoupper($data['gender']),
            ]);

            $keys = preg_split('/[\n,;]+/', (string) $data['budget_keys']);
            foreach ($keys as $key) {
                $clave = trim($key);
                if ($clave === '') {
                    continue;
                }
                Position::create([
                    'worker_id' => $worker->id,
                    'clave_presupuestal' => $clave,
                ]);
            }
        });

        if (app()->environment('local') && $user) {
            Auth::login($user, true);
            return redirect()->route(config('proj.route_name_prefix', 'proj') . '.dashboard.index');
        }

        if ($user && method_exists($user, 'sendEmailVerificationNotification')) {
            try {
                $user->sendEmailVerificationNotification();
            } catch (\Throwable $e) {
                logger()->warning('Email verification not sent: ' . $e->getMessage());
            }
        }

        return redirect()->route(config('proj.route_name_prefix', 'proj') . '.auth.login')
            ->with('status', __('Hemos enviado un enlace de verificación a tu correo. Tu cuenta quedará activa cuando un secretario la apruebe.'));
    }

    public function logout(Request $request)
    {
        try {
            $isIdle = $request->has('idle');

            Auth::logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            if ($isIdle) {
                return redirect()->route(config('proj.route_name_prefix', 'proj') . '.errors.session-expired');
            }

            return redirect()->route(config('proj.route_name_prefix', 'proj') . '.auth.login');
        } catch (\Throwable $e) {
            Log::error('Logout error: ' . $e->getMessage());
            // Force redirect even on error
            return redirect()->route(config('proj.route_name_prefix', 'proj') . '.errors.session-expired');
        }
    }
}
