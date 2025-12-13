<?php
/**
 * Company: CETAM
 * Project: ST
 * File: Reports.php
 * Created on: 04/11/2025
 * Created by: Alfonso Angel García Hernández
 * Approved by: Alfonso Angel García Hernández
 * 
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

namespace App\Livewire\Secretary;

use Livewire\Component;

class Reports extends Component
{
    /**
     * Render the component view.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('modules.secretary.reports')->layout('layouts.app');
    }
}