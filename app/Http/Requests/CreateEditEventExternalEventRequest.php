<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class CreateEditEventExternalEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->isSuperAdminAdmin() || Auth::user()->isRegularAdmin();
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
            'company'=>[
                'required',
                'string'
            ],
            'description'=>[
                'nullable',
                'string'
            ],
            'start_date'=>[
                'required',
            ],
            'end_date'=>[
                'required'
            ],
            'city'=>[
                'nullable',
                'string'
            ],
            'country'=>[
                'required',
                'numeric',
                'exists:countries,id'
            ]
        ];
    }
}
