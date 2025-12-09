<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class DocumentTemplates extends Component
{
    public function render()
    {
        return view('modules.admin.document-templates')->layout('layouts.app');
    }
}

