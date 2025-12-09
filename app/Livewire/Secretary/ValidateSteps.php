<?php
/**
 * Company: CETAM
 * Project: ST
 * File: ValidateSteps.php
 * Created on: 04/11/2025
 * Created by: Alfonso Angel García Hernández
 * Approved by: Alfonso Angel García Hernández
 */

namespace App\Livewire\Secretary;

use Livewire\Component;

class ValidateSteps extends Component
{
    public function render()
    {
        return view('modules.secretary.validate-steps')
            ->layout('layouts.app');
    }
}