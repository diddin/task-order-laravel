<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerUpdateRequest extends FormRequest
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
            'category' => ['required', Rule::in(['akses', 'backbone'])],

            'name' => [
                Rule::requiredIf(fn () => $this->input('category') === 'akses'),
                'nullable', 'string', 'max:255',
            ],
            'address' => [
                Rule::requiredIf(fn () => $this->input('category') === 'akses'),
                'nullable', 'string', 'max:500',
            ],
            'network_number' => [
                Rule::requiredIf(fn () => $this->input('category') === 'akses'),
                'nullable', 'string', 'max:100',
            ],
            'pic' => [
                Rule::requiredIf(fn () => $this->input('category') === 'akses'),
                'nullable', 'string', 'max:20',
            ],
            'contact_person' => [
                Rule::requiredIf(fn () => $this->input('category') === 'akses'),
                'nullable', 'string', 'max:100',
            ],
            'cluster' => [
                Rule::requiredIf(fn () => $this->input('category') === 'akses'),
                'nullable', Rule::in(['BWA', 'SAST', 'CDA', 'BDA', 'SEOA', 'NEA']),
            ],

            'technical_data' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'category.required' => 'Kategori pelanggan wajib dipilih.',
            'category.in' => 'Kategori harus akses atau backbone.',

            'name.required' => 'Nama pelanggan wajib diisi untuk kategori akses.',
            'address.required' => 'Alamat wajib diisi untuk kategori akses.',
            'network_number.required' => 'Nomor jaringan wajib diisi untuk kategori akses.',
            'pic.required' => 'PIC wajib diisi untuk kategori akses.',
            'contact_person.required' => 'Nama contact person wajib diisi untuk kategori akses.',
            'cluster.required' => 'Cluster wajib dipilih untuk kategori akses.',
            'cluster.in' => 'Cluster tidak valid.',
        ];
    }
}
