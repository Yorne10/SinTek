<?php
/**
 * Company: CETAM
 * Project: ST
 * File: UpdateProfileRequest.php
 * Created on: 13/12/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 *
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

namespace App\Http\Requests\Profiles;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $userId = auth()->id();

        return [
            'name' => 'sometimes|string|max:255',
            'email' => "sometimes|email|max:255|unique:users,email,{$userId},users_id",
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.string' => 'El nombre debe ser texto',
            'email.email' => 'El correo debe ser válido',
            'email.unique' => 'Este correo ya está en uso',
            'phone.max' => 'El teléfono no puede exceder 20 caracteres',
        ];
    }
}
