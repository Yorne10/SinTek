<?php
/**
 * Company: CETAM
 * Project: ST
 * File: StoreStepRequest.php
 * Created on: 13/12/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 *
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

namespace App\Http\Requests\Steps;

use Illuminate\Foundation\Http\FormRequest;

class StoreStepRequest extends FormRequest
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
            'process_id' => 'required|exists:processes,process_id',
            'title' => 'required|string|max:255',
            'instruction' => 'required|string',
            'order' => 'required|integer|min:1',
            'step_type' => 'required|in:informativo,documentacion,aprobacion',
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
            'title.required' => 'El título es obligatorio',
            'instruction.required' => 'La instrucción es obligatoria',
            'order.required' => 'El orden es obligatorio',
            'step_type.required' => 'El tipo de paso es obligatorio',
        ];
    }
}
