<?php
/**
 * Company: CETAM
 * Project: ST
 * File: RequestController.php
 * Created on: 10/12/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 *
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

namespace App\Http\Controllers\API\Requests;

use App\Http\Controllers\RestfulController;
use App\Services\API\Requests\RequestService;
use Illuminate\Http\Request;

class RequestController extends RestfulController
{
    protected RequestService $requestService;

    public function __construct(RequestService $requestService)
    {
        $this->requestService = $requestService;
    }

    public function index(Request $request)
    {
        return $this->requestService->index($request);
    }

    public function store(Request $request)
    {
        return $this->requestService->store($request);
    }

    public function show(Request $request, $id)
    {
        return $this->requestService->show($request, $id);
    }

    public function nextStep(Request $request, $id)
    {
        return $this->requestService->nextStep($request, $id);
    }

    public function conditionalStep(Request $request, $id)
    {
        return $this->requestService->conditionalStep($request, $id);
    }

    public function uploadDocument(Request $request, $id)
    {
        return $this->requestService->uploadDocument($request, $id);
    }

    public function cancel(Request $request, $id)
    {
        return $this->requestService->cancel($request, $id);
    }
}
