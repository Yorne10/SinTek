<?php
/**
 * Company: CETAM
 * Project: ST
 * File: ProcessController.php
 * Created on: 28/11/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 *
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

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
