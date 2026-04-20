<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'species' => 'required|string|max:255',
            'breed' => 'required|string|max:255',
            'age' => 'nullable|string|max:50',
            'weight' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:100',
            'gender' => 'nullable|in:Male,Female',
            'microchip' => 'nullable|string|max:255',
        ];
    }
}
