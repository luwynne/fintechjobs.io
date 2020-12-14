<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use App\User;

class CompanyResource extends JsonResource{
    
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

        $company = $this->resource;
        $company_rep = User::find($company->representative_id);

        return [
            'company' => $company,
            'company_rep' => $company_rep,
            'company_plan' => [
                'id' => $company->getCompanyPlanId(),
                'name' => $company->getCompanyPlanName(),
            ],
            'company_isPlanExpired' => $company->isPlanExpired(),
            'company_jobsAllowance' => $company->getCompanyJobsAllowance(),
            'company_jobs_created' => $company->getCompanyJobsCreated(),
            'company_remaining_jobs' => $company->getCompanyRemainingJobs(),
            'company_social_media_allowed' => $company->isSocialMediaAllowed(),
            'company_video_allowed' => $company->isVideoAllowed(),

            'company_eventsAllowance' => $company->getCompanyEventsAllowance(),
            'company_events_created' => $company->getCompanyEventsCreated(),
            'company_remaining_events' => $company->getCompanyRemainingEvents(),

            'company_coursesAllowance' => $company->getCompanyCoursesAllowance(),
            'company_courses_created' => $company->getCompanyCoursesCreated(),
            'company_remaining_courses' => $company->getCompanyRemainingCourses(),

            'company_social_medias' => [
                'facebook' => $company->facebook ? $company->facebook->url : '',
                'linkedin' => $company->linkedin ? $company->linkedin->url : '',
                'twitter' => $company->twitter ? $company->twitter->url : '',
            ]
        ];
            
    }
}
