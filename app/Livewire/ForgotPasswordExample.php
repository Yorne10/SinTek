<?php

namespace App\Livewire;

use Livewire\Component;

class ForgotPasswordExample extends Component
{
    public function render()
    {
        return view('modules.forgot-password-example')->layout('layouts.app');
    }
}

