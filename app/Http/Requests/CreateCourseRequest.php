<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Course;

class CreateCourseRequest extends FormRequest
{
    
    public function authorize(){
        return request()->user()->can('createCourse', Course::class);
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
