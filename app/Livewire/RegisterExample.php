<?php
/**
 * Company: CETAM
 * Project: ST
 * File: RegisterExample.php
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

use Livewire\Component;

class RegisterExample extends Component
{
    /**
     * Render the component view.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('modules.register-example')->layout('layouts.app');
    }
}

