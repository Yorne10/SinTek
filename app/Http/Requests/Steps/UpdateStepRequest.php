<?php
/**
 * Company: CETAM
 * Project: ST
 * File: UpdateStepRequest.php
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

class UpdateStepRequest extends FormRequest
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
            'title' => 'sometimes|string|max:255',
            'instruction' => 'sometimes|string',
            'order' => 'sometimes|integer|min:1',
            'step_type' => 'sometimes|in:informativo,documentacion,aprobacion',
        ];
    }
}
