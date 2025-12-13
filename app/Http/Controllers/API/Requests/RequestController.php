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

    /**

     * Create a new instance.

     *

     * @param RequestService $requestService

     */

    public function __construct(RequestService $requestService)
    {
        $this->requestService = $requestService;
    }

    /**

     * List all resources.

     *

     * @param Request $request

     *

     * @return \Illuminate\Http\JsonResponse

     */

    public function index(Request $request)
    {
        return $this->requestService->index($request);
    }

    /**

     * Store a newly created resource.

     *

     * @param Request $request

     *

     * @return \Illuminate\Http\JsonResponse

     */

    public function store(Request $request)
    {
        return $this->requestService->store($request);
    }

    /**

     * Display the specified resource.

     *

     * @param Request $request

     * @param mixed $id

     *

     * @return \Illuminate\Http\JsonResponse

     */

    public function show(Request $request, $id)
    {
        return $this->requestService->show($request, $id);
    }

    /**

     * Next step.

     *

     * @param Request $request

     * @param mixed $id

     *

     * @return void

     */

    public function nextStep(Request $request, $id)
    {
        return $this->requestService->nextStep($request, $id);
    }

    /**

     * Conditional step.

     *

     * @param Request $request

     * @param mixed $id

     *

     * @return void

     */

    public function conditionalStep(Request $request, $id)
    {
        return $this->requestService->conditionalStep($request, $id);
    }

    /**

     * Upload document.

     *

     * @param Request $request

     * @param mixed $id

     *

     * @return void

     */

    public function uploadDocument(Request $request, $id)
    {
        return $this->requestService->uploadDocument($request, $id);
    }

    /**

     * Cancel.

     *

     * @param Request $request

     * @param mixed $id

     *

     * @return void

     */

    public function cancel(Request $request, $id)
    {
        return $this->requestService->cancel($request, $id);
    }
}
