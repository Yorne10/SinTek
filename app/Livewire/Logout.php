<?php
/**
 * Company: CETAM
 * Project: ST
 * File: Logout.php
 * Created on: 03/11/2025
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

class Logout extends Component
{

    public function logout() {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route(config('proj.route_name_prefix', 'proj') . '.auth.login');
    }
    public function render()
    {
        return view('modules.logout');
    }
}

