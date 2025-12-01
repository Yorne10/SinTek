<?php

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
