<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class ProcedureManagement extends Component
{
    public function render()
    {
        return view('modules.admin.procedure-management')->layout('layouts.app');
    }
}

