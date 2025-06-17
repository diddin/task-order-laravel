<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'detail' => 'required|string|max:1000',
            'network_id' => 'required|exists:networks,id',
            'assigned_to' => 'nullable|exists:users,id',
            //'created_by' => 'required|exists:users,id',
            'action' => 'nullable|in:null,in progress,completed',
        ];
    }
}
