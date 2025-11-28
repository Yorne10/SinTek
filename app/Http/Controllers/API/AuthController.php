<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Worker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Register a new user (admin/secretary)
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:150',
            'email' => 'required|string|email|max:150|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,secretary',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_active' => true,
        ]);

        $token = $user->createToken('auth-token', [$request->role])->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'User registered successfully',
            'data' => [
                'user' => $user,
                'token' => $token,
            ]
        ], 201);
    }

    /**
     * Register a new worker with user account
     */
    public function registerWorker(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:150',
            'email' => 'required|string|email|max:150|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'curp' => 'nullable|string|max:20',
            'sex' => 'nullable|string|max:10',
            'phone' => 'nullable|string|max:20',
            'adress' => 'nullable|string|max:255',
            'rfc' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'worker',
            'is_active' => true,
        ]);

        $worker = Worker::create([
            'user_id' => $user->users_id,
            'curp' => $request->curp,
            'sex' => $request->sex,
            'phone' => $request->phone,
            'adress' => $request->adress,
            'rfc' => $request->rfc,
        ]);

        $token = $user->createToken('auth-token', ['worker'])->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Worker registered successfully',
            'data' => [
                'user' => $user,
                'worker' => $worker,
                'token' => $token,
            ]
        ], 201);
    }

    /**
     * Login user (Mobile API - Workers only)
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
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Credenciales inválidas'
            ], 401);
        }

        // Check if user is a worker (Mobile API restriction)
        if ($user->role !== 'worker') {
            return response()->json([
                'success' => false,
                'message' => 'Acceso denegado. Esta aplicación es solo para trabajadores. Los administradores y secretarios deben usar la aplicación web.'
            ], 403);
        }

        if (!$user->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Tu cuenta está inactiva. Contacta al administrador.'
            ], 403);
        }

        // Revoke all previous tokens
        $user->tokens()->delete();

        // Create new token with role ability
        $token = $user->createToken('auth-token', [$user->role])->plainTextToken;

        // Load worker relation with positions
        $user->load('worker.positions');

        return response()->json([
            'success' => true,
            'message' => 'Inicio de sesión exitoso',
            'data' => [
                'user' => $user,
                'worker' => $user->worker,
                'token' => $token,
            ]
        ], 200);
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully'
        ], 200);
    }

    /**
     * Get current authenticated user
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
