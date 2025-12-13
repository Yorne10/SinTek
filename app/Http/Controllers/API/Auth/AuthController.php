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

    /**

     * Create a new instance.

     *

     * @param AuthService $authService

     */

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**

     * Register a new user account.

     *

     * @param Request $request

     *

     * @return \Illuminate\Http\JsonResponse

     */

    public function register(Request $request)
    {
        return $this->authService->register($request);
    }

    /**

     * Register a new worker account.

     *

     * @param Request $request

     *

     * @return void

     */

    public function registerWorker(Request $request)
    {
        return $this->authService->registerWorker($request);
    }

    /**

     * Authenticate user and generate access token.

     *

     * @param Request $request

     *

     * @return \Illuminate\Http\JsonResponse

     */

    public function login(Request $request)
    {
        return $this->authService->login($request);
    }

    /**

     * Revoke authentication token and log out user.

     *

     * @param Request $request

     *

     * @return \Illuminate\Http\JsonResponse

     */

    public function logout(Request $request)
    {
        return $this->authService->logout($request);
    }

    /**

     * Get authenticated user information.

     *

     * @param Request $request

     *

     * @return \Illuminate\Http\JsonResponse

     */

    public function me(Request $request)
    {
        return $this->authService->me($request);
    }
}
