<?php
/**
 * Company: CETAM
 * Project: ST
 * File: ConvocationEvents.php
 * Created on: 03/11/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 *
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

namespace App\Livewire\Admin;

use Livewire\Component;

class ConvocationEvents extends Component
{
    /**
     * Render the component view.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('modules.admin.convocation-events')->layout('layouts.app');
    }
}

