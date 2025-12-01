<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class PlantillasDocumentos extends Component
{
    public function render()
    {
        return view('modules.admin.plantillas-documentos')->layout('layouts.app');
    }
}

