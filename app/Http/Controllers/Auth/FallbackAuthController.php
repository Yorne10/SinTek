<?php
/**
 * Company: CETAM
 * Project: ST
 * File: FallbackAuthController.php
 * Created on: 12/12/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 *
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\FallbackAuthService;
use Illuminate\Http\Request;

class FallbackAuthController extends Controller
{
    protected FallbackAuthService $fallbackAuthService;

    /**

     * Create a new instance.

     *

     * @param FallbackAuthService $fallbackAuthService

     */

    public function __construct(FallbackAuthService $fallbackAuthService)
    {
        $this->fallbackAuthService = $fallbackAuthService;
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
        return $this->fallbackAuthService->login($request);
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
        return $this->fallbackAuthService->register($request);
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
        return $this->fallbackAuthService->logout($request);
    }
}
