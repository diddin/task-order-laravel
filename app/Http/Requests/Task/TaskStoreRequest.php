<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class TaskStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        if ($this->action === 'null') {
            $this->merge(['action' => null]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'task_number'  => [
                'required',
                'string',
                Rule::unique('tasks', 'task_number')->ignore($this->task?->id),
            ],
            'detail' => 'required|string|max:1000',
            'category' => ['required', Rule::in(['akses', 'backbone'])],

            // customer_id wajib kalau category 'akses', boleh null kalau 'backbone'
            'customer_id' => [
                Rule::requiredIf(function () {
                    return $this->input('category') === 'akses';
                }),
                'nullable',
                'exists:customers,id',
            ],

            'action' => ['nullable', Rule::in(['in progress', 'completed'])],

            'pic_id' => 'required|exists:users,id',
            'onsite_ids' => 'nullable|array',
            'onsite_ids.*' => 'exists:users,id',
        ];
    }

    public function messages(): array
    {
        return [
            'detail.required' => 'Field detail wajib diisi.',
            'detail.string' => 'Field detail harus berupa teks.',
            'detail.max' => 'Field detail maksimal :max karakter.',

            'category.required' => 'Kategori harus dipilih.',
            'category.in' => 'Kategori harus berupa akses atau backbone.',

            'customer_id.required' => 'Field Jaringan harus dipilih.',
            'customer_id.exists' => 'Jaringan yang dipilih tidak valid.',

            'action.in' => 'Field aksi harus salah satu dari: sedang dikerjakan, selesai.',

            'pic_id.required' => 'Penanggung jawab (PIC) wajib dipilih.',
            'pic_id.exists' => 'Penanggung jawab (PIC) yang dipilih tidak valid.',

            'onsite_ids.array' => 'Field onsite harus berupa array.',
            'onsite_ids.*.exists' => 'Salah satu anggota onsite tidak valid.',
        ];
    }
}
