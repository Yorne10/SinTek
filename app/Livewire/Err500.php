<?php
/**
 * Company: CETAM
 * Project: ST
 * File: Err500.php
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

class Err500 extends Component
{
    public function render()
    {
        return view('errors.500')->layout('layouts.app');
    }
}
