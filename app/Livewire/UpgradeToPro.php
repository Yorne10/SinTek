<?php

namespace App\Livewire;

use Livewire\Component;

class UpgradeToPro extends Component
{
    public function render()
    {
        return view('modules.upgrade-to-pro')->layout('layouts.app');
    }
}

