<?php
/**
 * Company: CETAM
 * Project: ST
 * File: ConvocationController.php
 * Created on: 28/11/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 *
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

namespace App\Http\Controllers\API\Convocations;

use App\Http\Controllers\RestfulController;
use App\Services\API\Convocations\ConvocationService;
use Illuminate\Http\Request;

class ConvocationController extends RestfulController
{
    protected ConvocationService $convocationService;

    /**

     * Create a new instance.

     *

     * @param ConvocationService $convocationService

     */

    public function __construct(ConvocationService $convocationService)
    {
        $this->convocationService = $convocationService;
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
        return $this->convocationService->index();
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
        return $this->convocationService->show($id);
    }

    /**

     * Download document.

     *

     * @param mixed $id

     *

     * @return void

     */

    public function downloadDocument($id)
    {
        return $this->convocationService->downloadDocument($id);
    }
}
