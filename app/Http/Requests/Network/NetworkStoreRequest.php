<?php

namespace App\Http\Requests\Network;

use Illuminate\Foundation\Http\FormRequest;

class NetworkStoreRequest extends FormRequest
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
            'network_number' => 'required|',
            'detail' => 'nullable|string|max:1000',
            'access' => 'nullable|string|max:10000',
            'data_core' => 'nullable|string|max:10000',
            'customer_id' => 'required|exists:customers,id',
        ];
    }
}
