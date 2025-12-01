<?php

/**
 * Company: CETAM
 * Project: ST
 * File: Dashboard.php
 * Created on: 05/11/2025
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
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public function render()
    {
        $user = Auth::user();

        // Redireccionar según el rol del usuario
        if ($user->hasRole('admin')) {
            return view('modules.admin.dashboard')->layout('layouts.app');
        } elseif ($user->hasRole('secretary')) {
            return view('modules.secretary.dashboard')->layout('layouts.app');
        } elseif ($user->hasRole('worker')) {
            return view('modules.worker.dashboard')->layout('layouts.app');
        }

        // Vista por defecto si no tiene un rol específico
        return view('dashboard')->layout('layouts.app');
    }
}

