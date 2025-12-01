<?php

namespace App\Services\API\Profiles;

use App\Models\User;
use App\Models\Worker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileService
{
    public function show(Request $request)
    {
        $user = $request->user();

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

    public function update(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:150',
            'email' => [
                'sometimes',
                'required',
                'email',
                'max:150',
                Rule::unique('users')->ignore($user->users_id, 'users_id')
            ],
            'phone' => 'nullable|string|max:20',
            'sex' => 'nullable|string|max:10',
            'birthdate' => 'nullable|date',
            'curp' => 'nullable|string|max:20',
            'rfc' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user->update($request->only(['name', 'email']));

            if ($user->role === 'worker') {
                $workerData = [
                    'phone' => $request->phone,
                    'sex' => $request->sex,
                    'birthdate' => $request->birthdate,
                    'curp' => $request->curp,
                    'rfc' => $request->rfc,
                    'address' => $request->address,
                ];

                if ($user->worker) {
                    $user->worker->update($workerData);
                } else {
                    Worker::create(array_merge($workerData, ['user_id' => $user->users_id]));
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Perfil actualizado exitosamente',
                'data' => $user->fresh()
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el perfil',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updatePhoto(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'photo' => 'required|image|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = $request->user();
            $path = $request->file('photo')->store('profile-photos', 'public');
            $user->profile_photo_path = $path;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Foto de perfil actualizada',
                'data' => ['profile_photo_path' => $path]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la foto de perfil',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function deletePhoto(Request $request)
    {
        try {
            $user = $request->user();
            $user->profile_photo_path = null;
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
