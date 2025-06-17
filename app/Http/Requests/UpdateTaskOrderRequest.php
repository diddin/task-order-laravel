<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
        // Sesuaikan dengan logic akses, misalnya hanya user yang login:
        // return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'task_id' => ['required', 'exists:tasks,id'],
            'status'  => ['required', 'string', 'max:1000'],
        ];
    }

    public function messages()
    {
        return [
            'task_id.required' => 'Task harus dipilih.',
            'task_id.exists'   => 'Task tidak valid.',
            'status.required'  => 'Status progres harus diisi.',
            'status.string'    => 'Status harus berupa teks.',
            'status.max'       => 'Status maksimal 1000 karakter.',
        ];
    }
}
