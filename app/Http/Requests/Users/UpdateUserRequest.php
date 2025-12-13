<?php
/**
 * Company: CETAM
 * Project: ST
 * File: UpdateUserRequest.php
 * Created on: 13/12/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 *
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $userId = $this->route('id') ?? $this->route('user');

        return [
            'name' => 'sometimes|string|max:255',
            'email' => "sometimes|email|unique:users,email,{$userId},users_id",
            'password' => 'sometimes|string|min:8',
            'role' => 'sometimes|in:admin,secretary,worker',
            'is_active' => 'sometimes|boolean',
        ];
    }
}
