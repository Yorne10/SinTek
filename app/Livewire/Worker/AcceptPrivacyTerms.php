<?php
/**
 * Company: CETAM
 * Project: ST
 * File: AcceptPrivacyTerms.php
 * Created on: 13/12/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 *
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

namespace App\Livewire\Worker;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Services\ActivityLogger;

class AcceptPrivacyTerms extends Component
{
    /**
     * Accept privacy terms and update worker record.
     *
     * @return void
     */
    public function acceptTerms()
    {
        $user = Auth::user();
        $worker = $user->worker;

        if (!$worker) {
            $this->dispatch(
                'terms-error',
                type: 'error',
                title: 'Error',
                message: 'No se encontró el perfil de trabajador.'
            );
            return;
        }

        // Update privacy acceptance timestamp
        $worker->update([
            'privacy_accepted_at' => now(),
        ]);

        // Log privacy acceptance
        ActivityLogger::log(
            'usuario.privacidad.aceptar',
            "Usuario aceptó los términos de privacidad",
            $user->users_id
        );

        // Send redirect URL via dispatch for JavaScript to handle
        $prefix = config('proj.route_name_prefix', 'proj');
        $this->dispatch(
            'terms-accepted',
            redirectUrl: route($prefix . '.dashboard.index')
        );
    }

    /**
     * Reject privacy terms and logout user.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function rejectTerms()
    {
        // Logout user
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        // Redirect to login with message
        $prefix = config('proj.route_name_prefix', 'proj');
        return redirect()->route($prefix . '.auth.login')
            ->with('message', 'Debes aceptar los términos de privacidad para usar el sistema.');
    }

    /**
     * Render the component view.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.worker.accept-privacy-terms')
            ->layout('layouts.app');
    }
}
