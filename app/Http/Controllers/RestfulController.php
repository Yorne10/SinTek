<?php

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

    public function index()
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

    public function show($id)
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

    public function destroy($id)
    {
        return $this->methodNotAllowed();
    }
}
