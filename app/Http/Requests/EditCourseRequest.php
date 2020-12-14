<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Course;

class EditCourseRequest extends FormRequest
{
    
    public function authorize(){
        return true;
    }

    
    public function rules()
    {
        return [
            'name' =>[
                'required',
                'string'
            ],
            'description' =>[
                'required',
                'string'
            ],
            'url' =>[
                'required',
                'string'
            ]
        ];
    }
}
