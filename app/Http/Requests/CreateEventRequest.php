<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateEventRequest extends FormRequest
{
   
    public function authorize(){
        return true;
    }


    public function rules(){
        
        return [
            
            'name'=>[
                'required',
                'string',
                'max:255'
            ],

            'description'=>[
                'required',
                'string'
            ],

            'start_date'=>[
                'required',
                'date',
                'before:end_date'
            ],

            'end_date'=>[
                'required',
                'date',
                'after:start_date'
            ],

            'address'=>[
                'required',
                'string'
            ],

            'city'=>[
                'required',
                'string'
            ],

            'country_id'=>[
                'required',
                'numeric',
                'exists:countries,id'
            ],

            'fee'=>[
                'nullable',
                'numeric'
            ],

            'url'=>[
                'required',
                'string'
            ],

            'image'=>[
                'required'
            ]

        ];
    }
}
