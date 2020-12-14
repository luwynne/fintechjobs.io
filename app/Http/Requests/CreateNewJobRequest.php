<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Job;

class CreateNewJobRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(){
        return request()->user()->can('createJob', Job::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(){
        return [
            'name' => 'required|regex:/(^[A-Za-z0-9 ]+$)+/|max:35',
            'description' => 'required|string',
            'salary' => 'nullable|numeric|between:0,999.99',
            'location' => 'required|string',
            'experience_years' => 'required|numeric'
        ];
    }
}
