<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSessionRequest extends FormRequest
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
            'name' => 'required|string',
            'weight' => 'required|numeric',
            'height' => 'required|numeric',
            'chest_measurement' => 'required|numeric',
            'waist_measurement' => 'required|numeric',
            'hips_measurement' => 'required|numeric',
            'distance_run' => 'required|integer',
        ];
    }
}
