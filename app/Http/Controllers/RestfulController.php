<?php
/**
 * Company: CETAM
 * Project: ST
 * File: RestfulController.php
 * Created on: 12/12/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 *
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Base controller to guarantee the presence of standard RESTful method
 * signatures. Child controllers override the actions they actually support;
 * the defaults return a 405 to avoid unexpected behaviour.
 */
abstract class RestfulController extends Controller
{
    protected function methodNotAllowed(): \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
    {
        return response()->json([
            'message' => 'Method not allowed.',
        ], Response::HTTP_METHOD_NOT_ALLOWED);
    }

    public function index(Request $request)
    {
        return $this->methodNotAllowed();
    }

    public function create()
    {
        return $this->methodNotAllowed();
    }

    public function store(Request $request)
    {
        return $this->methodNotAllowed();
    }

    public function show(Request $request, $id)
    {
        return $this->methodNotAllowed();
    }

    public function edit($id)
    {
        return $this->methodNotAllowed();
    }

    public function update(Request $request, $id = null)
    {
        return $this->methodNotAllowed();
    }

    public function destroy(Request $request, $id)
    {
        return $this->methodNotAllowed();
    }
}
