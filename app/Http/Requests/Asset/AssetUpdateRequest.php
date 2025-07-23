<?php

namespace App\Http\Requests\Asset;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class AssetUpdateRequest extends FormRequest
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
    { //dd($this->all());
        $assetId = $this->route('asset')->id ?? null;
        $maxPorts = intval($this->input('number_of_ports'));

        return [
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048|nullable',
            'validation_date' => 'sometimes|nullable|date', // ok
            'data_collection_time' => 'sometimes|nullable|date', // ok
            'location' => 'sometimes|nullable|string', // ok
            'code' => 'sometimes|required|string|unique:assets,code,' . $assetId, // ok
            'name' => 'sometimes|required|string', // ok
            'label' => 'sometimes|required|string', // ok
            'object_type' => 'nullable|string', // ok
            'construction_location' => 'nullable|string', // ok
            'potential_problem' => 'nullable|string', // ok
            'improvement_recomendation' => 'nullable|string', // ok
            'detail_improvement_recomendation' => 'nullable|string', // ok
            'pop' => 'nullable|string', // ok
            'olt' => 'nullable|string', // ok
            'number_of_ports' => 'required|integer|min:1', // ok

            'number_of_registered_ports' => 'nullable|integer|min:0', // ok
            'number_of_registered_labels' => 'nullable|integer|min:0', // ok

            'data_port' => 'required|array', // ok
            // 'data_port.*' => $dataPortRules,

            'jumper' => 'required|array', // ok
            //'jumper.*' => 'required|integer|min:1|max:' . $maxPorts,
            //'jumper.*' => 'nullable',
            // 'jumper.*' => 'required|integer|min:1|max:' . $this->input('number_of_ports', 48), // ok
        ];
    }
}
