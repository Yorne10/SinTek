<?php
/**
 * Company: CETAM
 * Project: ST
 * File: StoreRequestRequest.php
 * Created on: 13/12/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 *
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

namespace App\Http\Requests\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequestRequest extends FormRequest
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
        return [
            'process_id' => 'required|exists:processes,process_id',
            'worker_id' => 'sometimes|exists:workers,id',
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
            'process_id.required' => 'El proceso es obligatorio',
            'process_id.exists' => 'El proceso seleccionado no existe',
            'worker_id.exists' => 'El trabajador seleccionado no existe',
        ];
    }
}
