<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;
use App\Job;

class ApplicationRequest extends FormRequest{

    public function authorize(){
        $job = Job::findOrFail(request()->route('job_id'));
        return $job->isNotExpired();
    }

    public function rules(){
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'file' => 'required',
        ];
    }
}
