<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'detail' => 'required|string|max:1000',
            'network_id' => 'required|exists:networks,id',
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

            'network_id.required' => 'Jaringan harus dipilih.',
            'network_id.exists' => 'Jaringan yang dipilih tidak valid.',

            'action.in' => 'Field aksi harus salah satu dari: sedang dikerjakan, selesai.',
            // 'action.nullable' biasanya gak perlu pesan khusus

            'pic_id.required' => 'PIC wajib dipilih.',
            'pic_id.exists' => 'PIC yang dipilih tidak valid.',

            'onsite_ids.array' => 'Format onsite harus berupa array.',
            'onsite_ids.*.exists' => 'Salah satu onsite teknisi tidak valid.',
        ];
    }
}
