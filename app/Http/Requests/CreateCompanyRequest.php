<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCompanyRequest extends FormRequest
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
            'companyname' => [
                'required',
                'string'
            ],
            'companysector' => [
                'required',
                'numeric',
                'exists:company_sectors,id'
            ],
            'companyaddress' => [
                'required',
                'string'
            ],
            'companyphone' => [
                'required',
                'string'
            ],
            'companywebsite' => [
                'required',
                'string'
            ]
        ];
    }
}
