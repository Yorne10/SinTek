<?php
/**
 * Company: CETAM
 * Project: ST
 * File: ForgotPassword.php
 * Created on: 02/11/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 *
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

namespace App\Livewire;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Livewire\Component;
use App\Models\User;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPassword;
use Livewire\Attributes\Rule;

class ForgotPassword extends Component
{
    use Notifiable;

    public $mailSentAlert = false;
    public $showDemoNotification = false;

    #[Rule('required|email|exists:users', message: ['email.exists' => 'The Email Address must be in our database.'])]
    public $email = '';

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
        $this->validate(['email'=>'required|email|exists:users']);
    }
    /**
     * Route notification for mail.
     *
     * @return void
     */
    public function routeNotificationForMail() {
        return $this->email;
    }
    /**
     * Recover password.
     *
     * @return void
     */
    public function recoverPassword() {
        if(env('IS_DEMO')) {
            $this->showDemoNotification = true;
        }
        else {
            $this->validate();
            $user=User::where('email', $this->email)->first();
            $this->notify(new ResetPassword($user->id));
            $this->mailSentAlert = true;
        }
    }

    /**

     * Render the component view.

     *

     * @return \Illuminate\View\View

     */

    public function render()
    {
        return view('modules.forgot-password')->layout('layouts.app');
    }
}

