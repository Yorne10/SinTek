<?php
/**
 * Company: CETAM
 * Project: ST
 * File: AuthController.php
 * Created on: 28/11/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 *
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\RestfulController;
use App\Services\API\Auth\AuthService;
use Illuminate\Http\Request;

class AuthController extends RestfulController
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(Request $request)
    {
        return $this->authService->register($request);
    }

    public function registerWorker(Request $request)
    {
        return $this->authService->registerWorker($request);
    }

    public function login(Request $request)
    {
        return $this->authService->login($request);
    }

    public function logout(Request $request)
    {
        return $this->authService->logout($request);
    }

    public function me(Request $request)
    {
        return $this->authService->me($request);
    }
}
