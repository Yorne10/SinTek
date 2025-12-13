<?php
/**
 * Company: CETAM
 * Project: ST
 * File: StoreProcessRequest.php
 * Created on: 13/12/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 *
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

namespace App\Http\Requests\Processes;

use Illuminate\Foundation\Http\FormRequest;

class StoreProcessRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasAnyRole(['admin', 'secretary']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'sometimes|string|max:100',
            'department' => 'sometimes|string|max:100',
            'active' => 'sometimes|boolean',
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
            'name.required' => 'El nombre del proceso es obligatorio',
            'name.max' => 'El nombre no puede exceder 255 caracteres',
            'description.required' => 'La descripción es obligatoria',
        ];
    }
}
