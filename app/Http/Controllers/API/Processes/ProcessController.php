<?php

namespace App\Http\Controllers\API\Processes;

use App\Http\Controllers\RestfulController;
use App\Services\API\Processes\ProcessService;
use Illuminate\Http\Request;

class ProcessController extends RestfulController
{
    protected ProcessService $processService;

    public function __construct(ProcessService $processService)
    {
        $this->processService = $processService;
    }

    public function index(Request $request)
    {
        return $this->processService->index($request);
    }

    public function show(Request $request, $id)
    {
        return $this->processService->show($id);
    }
}
