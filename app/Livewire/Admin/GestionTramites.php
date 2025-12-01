<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class GestionTramites extends Component
{
    public function render()
    {
        return view('modules.admin.gestion-tramites')->layout('layouts.app');
    }
}

