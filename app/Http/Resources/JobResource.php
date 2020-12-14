<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request){

        if ($this->resource == null){
            return null;
        }

        $job = $this->resource;

        return [
            'id' => $job->id,
            'name' => $job->name,
            'description' => $job->description,
            'salary' => $job->salary,
            'location' => $job->location,
            'experience_years' => $job->experience_years,
            'bonus' => $job->bonus,
            'company' => $job->company->name,
            'created_at' => $job->created_at,
            'recruiter' => $job->recruiter->name,
            'applications' => $job->application
        ];

    }
}
