<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class TaskUpdateRequest extends FormRequest
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
            'task_number' => 'required|string|unique:tasks,task_number,' . $this->task->id,
            'detail' => 'required|string|max:1000',
            'category' => 'required|in:akses,backbone',
            'customer_id' => 'nullable|exists:customers,id',
            'action' => 'nullable|in:in progress,completed',
            'pic_id' => 'required|exists:users,id',
            'onsite_ids' => 'nullable|array',
            'onsite_ids.*' => 'exists:users,id',
        ];
    }

    public function messages()
    {
        return [
            'detail.required' => 'Detail wajib diisi.',
            'detail.string' => 'Detail harus berupa teks.',
            'detail.max' => 'Detail maksimal :max karakter.',

            'category.required' => 'Kategori harus dipilih.',
            'category.in' => 'Kategori harus berupa akses atau backbone.',

            'customer_id' => [
                Rule::requiredIf(function () {
                    return $this->input('category') === 'akses';
                }),
                'nullable',
                'exists:customers,id',
            ],

            'action.in' => 'Field aksi harus salah satu dari: sedang dikerjakan, selesai.',
            // 'action.nullable' biasanya gak perlu pesan khusus

            'pic_id.required' => 'PIC wajib dipilih.',
            'pic_id.exists' => 'PIC yang dipilih tidak valid.',

            'onsite_ids.array' => 'Format onsite harus berupa array.',
            'onsite_ids.*.exists' => 'Salah satu onsite teknisi tidak valid.',
        ];
    }
}
