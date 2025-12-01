<?php

namespace App\Http\Controllers\API\Convocations;

use App\Http\Controllers\RestfulController;
use App\Services\API\Convocations\ConvocationService;
use Illuminate\Http\Request;

class ConvocationController extends RestfulController
{
    protected ConvocationService $convocationService;

    public function __construct(ConvocationService $convocationService)
    {
        $this->convocationService = $convocationService;
    }

    public function index(Request $request)
    {
        return $this->convocationService->index();
    }

    public function show(Request $request, $id)
    {
        return $this->convocationService->show($id);
    }

    public function downloadDocument($id)
    {
        return $this->convocationService->downloadDocument($id);
    }
}
