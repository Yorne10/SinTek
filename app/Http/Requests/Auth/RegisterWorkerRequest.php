<?php
/**
 * Company: CETAM
 * Project: ST
 * File: RegisterWorkerRequest.php
 * Created on: 13/12/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 *
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterWorkerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|in:M,F',
            'email' => 'required|string|email|max:255|unique:users',
            'curp' => 'required|string|size:18|unique:workers,curp',
            'budget_keys' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
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
            'first_name.required' => 'El nombre es obligatorio',
            'last_name.required' => 'El apellido es obligatorio',
            'gender.required' => 'El género es obligatorio',
            'email.required' => 'El correo electrónico es obligatorio',
            'email.unique' => 'Este correo ya está registrado',
            'curp.required' => 'El CURP es obligatorio',
            'curp.size' => 'El CURP debe tener exactamente 18 caracteres',
            'curp.unique' => 'Este CURP ya está registrado',
            'budget_keys.required' => 'Las claves presupuestales son obligatorias',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',
        ];
    }
}
