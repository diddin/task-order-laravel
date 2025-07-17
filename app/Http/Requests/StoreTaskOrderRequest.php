<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskOrderRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //'task_id'   => ['required', 'exists:tasks,id'],
            'status'    => ['required', 'string', 'max:1000'],
            'image'     => ['nullable', 'image', 'max:2048'], // max 2MB
            'latitude'  => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
        ];
    }

    public function messages()
    {
        return [
            'task_id.required'   => 'Task harus dipilih.',
            'task_id.exists'     => 'Task tidak valid.',
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
