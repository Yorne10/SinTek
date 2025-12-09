<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class Requests extends Component
{
    public function render()
    {
        return view('modules.admin.requests')->layout('layouts.app');
    }
}

