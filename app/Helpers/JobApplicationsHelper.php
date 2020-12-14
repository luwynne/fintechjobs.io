<?php

namespace App\Helpers;

use App\Job;
use Auth;

class JobApplicationsHelper{

    public static function getApplicationsNumber(){
        $applications = [];
        $jobs = Job::where('company_id', Auth::user()->company->id)->get();
        foreach($jobs as $job){
            array_push($applications, count($job->application));
        }

        return array_sum($applications);

    }

}
