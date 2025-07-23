<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class TaskUpdateRequest extends FormRequest
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
            'action' => 'nullable|in:in progress,completed',
            'pic_id' => 'required|exists:users,id',
            'onsite_ids' => 'nullable|array',
            'onsite_ids.*' => 'exists:users,id',
        ];
    }
}
