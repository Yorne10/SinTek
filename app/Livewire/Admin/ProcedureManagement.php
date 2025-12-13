<?php
/**
 * Company: CETAM
 * Project: ST
 * File: ProcedureManagement.php
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

class ProcedureManagement extends Component
{
    public function render()
    {
        return view('modules.admin.procedure-management')->layout('layouts.app');
    }
}

