<?php
/**
 * Company: CETAM
 * Project: ST
 * File: VerifyEmailController.php
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

use App\Services\Auth\VerifyEmailService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class VerifyEmailController extends Controller
{
    protected VerifyEmailService $verifyEmailService;

    public function __construct(VerifyEmailService $verifyEmailService)
    {
        $this->verifyEmailService = $verifyEmailService;
    }

    public function __invoke(Request $request, $id, $hash)
    {
        return $this->verifyEmailService->handle($request, $id, $hash);
    }
}
