<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class VerifyEmailService
{
    public function handle(Request $request, $id, $hash)
    {
        $user = User::findOrFail($id);

        if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            abort(403, 'Invalid verification link.');
        }

        if (is_null($user->email_verified_at)) {
            $user->forceFill(['email_verified_at' => Date::now()])->save();
        }

        return redirect()->route(config('proj.route_name_prefix', 'proj') . '.auth.login')
            ->with('status', __('Correo verificado. Ya puedes iniciar sesión cuando tu cuenta sea aprobada.'));
    }
}
