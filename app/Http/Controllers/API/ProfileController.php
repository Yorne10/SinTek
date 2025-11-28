<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Worker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Get authenticated user's profile
     * GET /api/my-profile
     */
    public function show(Request $request)
    {
        $user = $request->user();

        // Load worker relationship if user is a worker
        if ($user->role === 'worker') {
            $user->load('worker.positions');
        }

        return response()->json([
            'success' => true,
            'data' => [
                'user' => $user,
                'worker' => $user->role === 'worker' ? $user->worker : null,
            ]
        ], 200);
    }

    /**
     * Update authenticated user's profile
     * PUT/PATCH /api/my-profile
     */
    public function update(Request $request)
    {
        $user = $request->user();

        // Log para debugging (puedes quitar esto después)
        \Log::info('Profile Update Request', [
            'user_id' => $user->users_id,
            'request_data' => $request->all(),
        ]);

        // Base validation rules
        $rules = [
            'name' => 'sometimes|required|string|max:150',
            'email' => ['sometimes', 'required', 'email', 'max:150', Rule::unique('users', 'email')->ignore($user->users_id, 'users_id')],
        ];

        // Add worker-specific validation if user is a worker
        if ($user->role === 'worker') {
            $rules['curp'] = 'nullable|string|max:20';
            $rules['rfc'] = 'nullable|string|max:20';
            $rules['phone'] = 'nullable|string|max:20';
            $rules['adress'] = 'nullable|string|max:255';
            $rules['sex'] = ['nullable', Rule::in(['M', 'F'])];
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Update user basic info
            $user->fill($request->only(['name', 'email']));
            $user->save();

            // Update worker data if user is a worker
            if ($user->role === 'worker') {
                $worker = $user->worker;

                if (!$worker) {
                    // Create worker profile if it doesn't exist
                    $worker = Worker::create([
                        'user_id' => $user->users_id,
                        'curp' => $request->input('curp'),
                        'rfc' => $request->input('rfc'),
                        'phone' => $request->input('phone'),
                        'adress' => $request->input('adress'),
                        'sex' => $request->input('sex'),
                    ]);
                } else {
                    // Update existing worker profile - acepta null values
                    $workerData = $request->only(['curp', 'rfc', 'phone', 'adress', 'sex']);

                    // Solo actualizar los campos que vienen en el request
                    foreach ($workerData as $key => $value) {
                        $worker->$key = $value;
                    }

                    $worker->save();
                }

                // Reload relationships
                $user->load('worker.positions');
            }

            return response()->json([
                'success' => true,
                'message' => 'Perfil actualizado exitosamente',
                'data' => [
                    'user' => $user,
                    'worker' => $user->role === 'worker' ? $user->worker : null,
                ]
            ], 200);

        } catch (\Exception $e) {
            \Log::error('Profile Update Error', [
                'user_id' => $user->users_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el perfil',
                'error' => $e->getMessage(),
                'debug' => config('app.debug') ? [
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ] : null
            ], 500);
        }
    }

    /**
     * Update profile photo
     * POST /api/my-profile/photo
     */
    public function updatePhoto(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'profile_photo' => 'required|string', // Base64 encoded image
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $request->user();

        try {
            // Validar que sea una imagen base64 válida
            $base64Image = $request->profile_photo;

            // Remover el prefijo data:image si existe
            if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $type)) {
                $base64Image = substr($base64Image, strpos($base64Image, ',') + 1);
                $type = strtolower($type[1]); // jpg, png, gif

                if (!in_array($type, ['jpg', 'jpeg', 'png', 'gif'])) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Formato de imagen no válido. Solo se permiten JPG, PNG y GIF.'
                    ], 422);
                }
            }

            // Decodificar para validar
            $imageData = base64_decode($base64Image);
            if ($imageData === false) {
                return response()->json([
                    'success' => false,
                    'message' => 'La imagen no es válida.'
                ], 422);
            }

            // Guardar la foto de perfil como base64
            $user->profile_photo = $request->profile_photo;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Foto de perfil actualizada exitosamente',
                'data' => [
                    'profile_photo' => $user->profile_photo
                ]
            ], 200);

        } catch (\Exception $e) {
            \Log::error('Profile Photo Update Error', [
                'user_id' => $user->users_id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la foto de perfil',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete profile photo
     * DELETE /api/my-profile/photo
     */
    public function deletePhoto(Request $request)
    {
        $user = $request->user();

        try {
            $user->profile_photo = null;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Foto de perfil eliminada exitosamente'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la foto de perfil',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update password
     * PUT /api/my-profile/password
     */
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $request->user();

        // Verify current password
        if (!\Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'La contraseña actual es incorrecta'
            ], 401);
        }

        try {
            $user->password = \Hash::make($request->new_password);
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Contraseña actualizada exitosamente'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la contraseña',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
