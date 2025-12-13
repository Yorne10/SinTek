<?php
/**
 * Company: CETAM
 * Project: ST
 * File: AuthService.php
 * Created on: 30/11/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 *
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

namespace App\Services\API\Auth;

use App\Models\User;
use App\Models\Worker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    /**
     * Register a new user account.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // Default role
        ]);

        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Usuario registrado exitosamente',
            'data' => [
                'user' => $user,
                'token' => $token
            ]
        ], 201);
    }

    /**

     * Register a new worker account.

     *

     * @param Request $request

     *

     * @return void

     */

    public function registerWorker(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            // Add other worker specific validations here if needed
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'worker',
        ]);

        // Assuming there is a Worker model related to User, create it here if needed
        // $worker = Worker::create(['user_id' => $user->id, ...]);

        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Trabajador registrado exitosamente',
            'data' => [
                'user' => $user,
                'token' => $token
            ]
        ], 201);
    }

    /**

     * Authenticate user and generate access token.

     *

     * @param Request $request

     *

     * @return \Illuminate\Http\JsonResponse

     */

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Las credenciales proporcionadas son incorrectas',
            ], 401);
        }

        // Check if user is active if that column exists, otherwise remove this check
        // if (!$user->is_active) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Tu cuenta está inactiva',
        //     ], 403);
        // }

        $token = $user->createToken('auth-token')->plainTextToken;

        if ($user->role === 'worker') {
            $user->load('worker.positions');
        }

        return response()->json([
            'success' => true,
            'message' => 'Inicio de sesión exitoso',
            'data' => [
                'user' => $user,
                'token' => $token
            ]
        ], 200);
    }

    /**

     * Revoke authentication token and log out user.

     *

     * @param Request $request

     *

     * @return \Illuminate\Http\JsonResponse

     */

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cierre de sesión exitoso'
        ], 200);
    }

    /**

     * Get authenticated user information.

     *

     * @param Request $request

     *

     * @return \Illuminate\Http\JsonResponse

     */

    public function me(Request $request)
    {
        $user = $request->user();

        if ($user->role === 'worker') {
            $user->load('worker.positions');
        }

        return response()->json([
            'success' => true,
            'data' => $user
        ], 200);
    }
}
