<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class UpdateCompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(Auth::user()->role == 'admin'){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>[
                'required',
                'string'
            ],
            'sector_id'=>[
                'nullable',
                'numeric',
                'exists:company_sectors,id'
            ],
            'address'=>[
                'required',
                'string'
            ],
            'phone'=>[
                'required',
                'string'
            ],
            'website'=>[
                'required',
                'string'
            ],
            'description.content'=>[
                'nullable',
                'string'
            ],
            'facebook.url'=>[
                'nullable',
                'string'
            ],
            'linkedin.url'=>[
                'nullable',
                'string'
            ],
            'twitter.url'=>[
                'nullable',
                'string'
            ]
        ];
    }
}
