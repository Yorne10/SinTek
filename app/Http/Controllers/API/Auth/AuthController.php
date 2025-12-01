<?php

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
