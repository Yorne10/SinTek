<?php
/**
 * Company: CETAM
 * Project: ST
 * File: ValidarPasos.php
 * Created on: 04/11/2025
 * Created by: Alfonso Angel García Hernández
 * Approved by: Alfonso Angel García Hernández
 *
 * Changelog:
 */

namespace App\Livewire\Secretary;

use Livewire\Component;

class ValidarPasos extends Component
{
    public function render()
    {
        return view('modules.secretary.validar-pasos')
            ->layout('layouts.app');
    }
}

