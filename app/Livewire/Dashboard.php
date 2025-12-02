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
use App\Models\User;
use App\Models\Process;
use App\Models\Request as TramiteRequest;
use App\Models\Convocation;
use App\Models\Log;
use Carbon\Carbon;

class Dashboard extends Component
{
    public function render()
    {
        $user = Auth::user();

        // Redireccionar según el rol del usuario
        if ($user->hasRole('admin')) {
            return $this->renderAdminDashboard();
        } elseif ($user->hasRole('secretary')) {
            return $this->renderSecretaryDashboard();
        } elseif ($user->hasRole('worker')) {
            return $this->renderWorkerDashboard();
        }

        // Vista por defecto si no tiene un rol específico
        return view('dashboard')->layout('layouts.app');
    }

    private function renderAdminDashboard()
    {
        $data = [
            // Usuarios
            'totalUsers' => User::count(),
            'activeUsers' => User::where('is_active', 1)->count(),
            'inactiveUsers' => User::where('is_active', 0)->count(),
            'usersByRole' => [
                'admin' => User::where('role', 'admin')->count(),
                'secretary' => User::where('role', 'secretary')->count(),
                'worker' => User::where('role', 'worker')->count(),
            ],

            // Procesos
            'totalProcesses' => Process::count(),
            'activeProcesses' => Process::where('active', 1)->count(),

            // Solicitudes/Trámites
            'totalRequests' => TramiteRequest::count(),
            'pendingRequests' => TramiteRequest::where('status', 'pendiente')->count(),
            'inProgressRequests' => TramiteRequest::where('status', 'en_proceso')->count(),
            'completedRequests' => TramiteRequest::where('status', 'completado')->count(),
            'rejectedRequests' => TramiteRequest::where('status', 'rechazado')->count(),

            // Estadísticas del mes actual
            'requestsThisMonth' => TramiteRequest::whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)
                ->count(),

            // Actividad reciente
            'recentLogs' => Log::with('user')
                ->orderByDesc('created_at')
                ->limit(5)
                ->get(),

            // Convocatorias
            'totalConvocations' => Convocation::count(),
            'activeConvocations' => Convocation::where('status', 'activa')->count(),
        ];

        return view('modules.admin.dashboard', $data)->layout('layouts.app');
    }

    private function renderSecretaryDashboard()
    {
        $data = [
            'totalRequests' => TramiteRequest::count(),
            'pendingRequests' => TramiteRequest::where('status', 'pendiente')->count(),
            'inProgressRequests' => TramiteRequest::where('status', 'en_proceso')->count(),
            'completedRequests' => TramiteRequest::where('status', 'completado')->count(),
            'totalConvocations' => Convocation::count(),
            'activeConvocations' => Convocation::where('status', 'activa')->count(),
        ];

        return view('modules.secretary.dashboard', $data)->layout('layouts.app');
    }

    private function renderWorkerDashboard()
    {
        $userId = Auth::id();
        $workerId = \App\Models\Worker::where('user_id', $userId)->value('workers_id');

        $data = [
            'myRequests' => TramiteRequest::where('worker_id', $workerId)->count(),
            'myPendingRequests' => TramiteRequest::where('worker_id', $workerId)
                ->where('status', 'pendiente')
                ->count(),
            'myInProgressRequests' => TramiteRequest::where('worker_id', $workerId)
                ->where('status', 'en_proceso')
                ->count(),
            'myCompletedRequests' => TramiteRequest::where('worker_id', $workerId)
                ->where('status', 'completado')
                ->count(),
            'availableProcesses' => Process::where('active', 1)->count(),
            'activeConvocations' => Convocation::where('status', 'activa')->count(),
        ];

        return view('modules.worker.dashboard', $data)->layout('layouts.app');
    }
}

