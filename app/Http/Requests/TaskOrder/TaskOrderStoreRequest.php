<?php

namespace App\Http\Requests\TaskOrder;

use Illuminate\Foundation\Http\FormRequest;

class TaskOrderStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
        // Sesuaikan dengan logic auth kamu, misal cuma user tertentu yang boleh:
        //return auth()->check();
    }

    // protected function prepareForValidation()
    // {
    //     if ($this->latitude === 'null') {
    //         $this->merge(['latitude' => (int) $this->latitude]);
    //     }
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {// dd($this->all());
        return [
            'type'       => ['required', 'in:progress,hold,resume'],
            'status'     => ['required', 'string', 'max:1000'],
            'image'      => ['nullable', 'image', 'max:2048'],
            'latitude'   => ['required', 'numeric', 'between:-90,90'],
            'longitude'  => ['required', 'numeric', 'between:-180,180'],
            'hold_started_at' => ['nullable', 'date'],
            'resumed_at'      => ['nullable', 'date'],
        ];
    }

    public function messages()
    {
        return [
            'task_id.required'   => 'Task harus dipilih.',
            'task_id.exists'     => 'Task tidak valid.',
            'type.required'      => 'Tipe progres harus diisi.',
            'type.in'            => 'Tipe hanya boleh: progress, hold, atau resume.',
            'status.required'    => 'Status progres harus diisi.',
            'status.string'      => 'Status harus berupa teks.',
            'status.max'         => 'Status maksimal 1000 karakter.',
            'image.image'        => 'File harus berupa gambar.',
            'image.max'          => 'Ukuran gambar maksimal 2MB.',
            'latitude.required'  => 'Latitude harus diisi.',
            'latitude.numeric'   => 'Latitude harus berupa angka.',
            'latitude.between'   => 'Latitude harus di antara -90 hingga 90.',
            'longitude.required' => 'Longitude harus diisi.',
            'longitude.numeric'  => 'Longitude harus berupa angka.',
            'longitude.between'  => 'Longitude harus di antara -180 hingga 180.',
        ];
    }
}
