<?php

namespace App\Http\Requests\Asset;

use Illuminate\Foundation\Http\FormRequest;

class AssetStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $numberOfPorts = $this->input('number_of_ports', 48); // default 48 jika tidak ada input

        return [
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'validation_date' => 'nullable|date',
            'data_collection_time' => 'nullable|date',
            'location' => 'nullable|string',
            'code' => 'required|string|unique:assets,code',
            'name' => 'required|string',
            'label' => 'required|string',
            'object_type' => 'nullable|string',
            'construction_location' => 'nullable|string',
            'potential_problem' => 'nullable|string',
            'improvement_recomendation' => 'nullable|string',
            'detail_improvement_recomendation' => 'nullable|string',
            'pop' => 'nullable|string',
            'olt' => 'nullable|string',
            'number_of_ports' => 'required|integer|min:1',

            'number_of_registered_ports' => 'nullable|integer|min:0', // ok
            'number_of_registered_labels' => 'nullable|integer|min:0', // ok

            // Validasi untuk array data_port dan jumper
            'data_port' => 'required|array',
            //'data_port.*' => 'required|integer|min:1|max:' . $numberOfPorts,

            'jumper' => 'required|array',
            //'jumper.*' => 'required|integer|min:1|max:' . $numberOfPorts,
        ];
    }
}