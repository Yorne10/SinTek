<?php
/**
 * Company: CETAM
 * Project: ST
 * File: StoreConvocationRequest.php
 * Created on: 13/12/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 *
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

namespace App\Http\Requests\Convocations;

use Illuminate\Foundation\Http\FormRequest;

class StoreConvocationRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'sometimes|string|max:100',
            'status' => 'sometimes|in:draft,published,closed',
            'opening_date' => 'sometimes|date',
            'closing_date' => 'sometimes|date|after:opening_date',
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
            'title.required' => 'El título es obligatorio',
            'description.required' => 'La descripción es obligatoria',
            'closing_date.after' => 'La fecha de cierre debe ser posterior a la fecha de apertura',
        ];
    }
}
