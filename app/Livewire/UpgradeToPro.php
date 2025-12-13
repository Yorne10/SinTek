<?php
/**
 * Company: CETAM
 * Project: ST
 * File: UpgradeToPro.php
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

class UpgradeToPro extends Component
{
    public function render()
    {
        return view('modules.upgrade-to-pro')->layout('layouts.app');
    }
}

