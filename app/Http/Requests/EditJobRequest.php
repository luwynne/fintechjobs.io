<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditJobRequest extends FormRequest
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
            'description' => 'required|string',
            'salary' => 'nullable|numeric|between:0,999.99',
            'location' => 'required|string',
            'experience_years' => 'required|numeric'
        ];
    }
}
