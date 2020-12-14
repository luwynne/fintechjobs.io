<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\CompanyPlanHelper;
use App\Job;
use App\Company;
use App\User;
use Auth;
use Carbon\Carbon;
use App\Http\Requests\{
    CreateNewJobRequest,
    EditJobRequest
};
use App\Http\Resources\JobsResource;
use Mail;
use App\Importers\Careerjet_API;

class JobController extends Controller{


    public function search(Request $request){
        $job_name = $request->input('job_name');
        $job_location = null !== $request->input('job_location') ? $request->input('job_location') : '';
        $jobs = $this->_searchRequest($job_name, $job_location);
        return view ('website.search')->with(compact('jobs', 'job_name'));
    }


    public function getJobSearch($job_name){
        $jobs = $this->_searchRequest($job_name, '');
        return view ('website.search')->with(compact('jobs', 'job_name'));
    }


    private function _searchRequest($title = '', $location = ''){

        $api = new Careerjet_API('en_GB') ;
        $page = 1 ; # Or from parameters.

        $result = $api->search(array(
            'keywords' => $title,
            'location' => $location,
            'page' => $page ,
            'affid' => '678bdee048',
        ));
        
        $job_objects = [];  
        $counter = 0;    
        foreach($result->jobs as $api_job){
            $counter ++;
            if($counter <= 20){
                $job_object = [];
                $jobs_object['name'] = $api_job->title;
                $jobs_object['company'] = $api_job->company;
                $jobs_object['salary'] = str_replace('&pound;', '', $api_job->salary);
                $jobs_object['location'] = $api_job->locations;
                $jobs_object['url'] = $api_job->url;
                $jobs_object['is_external'] = true;
                $job_objects[] = $jobs_object;
            }
        } 

        $db_jobs = Job::where('name', 'like', '%' . $title . '%')->where('location', 'like', '%' . $location . '%')->where('is_approved', true)->get();
        
        foreach($db_jobs as $job){
            $job_object = [];
            $jobs_object['name'] = $job->name;
            $jobs_object['company_name'] = $job->company->name;
            $jobs_object['company_id'] = $job->company->id;
            $jobs_object['salary'] = str_replace('.0', '', (string)$job->salary).'000 per year';
            $jobs_object['location'] = $job->location ? $job->location : $job->company->address;
            $jobs_object['url'] = $job->clean_url_name;
            $jobs_object['is_external'] = false;
            $job_objects[] = $jobs_object;
        }
        
        $jobs = collect($job_objects)->take(40);

        $jobs = $jobs->filter(function($job){
            return $job['salary'] !== "" && $job['location'] !== "";
        });

        return $jobs;

    }


    public function getCompanyJobs(){
        $jobs = Job::where('company_id', '=', Auth::user()->company->id)->with('recruiter')->get();
        if($jobs){
            return response()->json((New JobsResource($jobs))->resolve());
        }else{
            return response()->json(['message'=>'No jobs found'], 401);
        }
    }


    public function createJob(CreateNewJobRequest $request){

        $expiration = Carbon::now()->add(30, 'day');
        
        $job = Job::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'salary' => $request->input('salary'),
            'location' => $request->input('location'),
            'experience_years' => $request->input('experience_years'),
            'bonus' => $request->input('bonus'),
            'expiration' => $expiration,
            'company_id' => Auth::user()->company->id,
            'recruiter_id' => Auth::user()->id
        ]);

        return response()->json(200);

    }


    public function jobEdit($id){
        $job = Job::findOrFail($id);
        return view('admin.job-edit', compact('job'));
    }

    public function editJob(EditJobRequest $request, $jobId){
        $job = Job::findOrFail($jobId);
        $job->salary = $request->input('salary');
        $job->location = $request->input('location');
        $job->experience_years = $request->input('experience_years');
        $job->bonus = $request->input('bonus');
        $job->description = $request->input('description');
        $job->save();
        return response()->json();
    }


    public function saveUserJob($job_id){
        $job = Job::findOrFail($job_id);
        $user = Auth::user();

        $repeated_save_jobs = $user->saved_jobs()->where('job_id', $job->id);
        if($repeated_save_jobs->count() > 0){
            return response()->json(['message'=>'This job has already been saved'], 403);
        }
        
        $user->saved_jobs()->attach($job->id);
        return response()->json(['message'=>'Job has been saved'], 200);
    }

    public function unsaveUserJob($job_id){
        $job = Job::findOrFail($job_id);
        $user = Auth::user();

        $save_jobs = $user->saved_jobs()->where('job_id', $job->id);
        if(!$save_jobs->count() > 0){
            return response()->json(['message'=>'This is not saved'], 403);
        }
        
        $user->saved_jobs()->detach($job->id);
        return response()->json(['message'=>'Job has been saved'], 200);
    }

    public function userSavedJobs(){
        if(!Auth::user()){
            return redirect('/');
        }else{
            $jobs = Auth::user()->saved_jobs;
            return view('website.candidate.mysavedjobs', compact('jobs'));
        }
    }

    public function userAppliedJobs(){
        if(!Auth::user()){
            return redirect('/');
        }else{
            $applications = Auth::user()->appliedJobs;
            $jobs = collect();
            $applications->each(function($application) use($jobs){
                $jobs->push($application->job);
            });
            return view('website.candidate.myappliedjobs', compact('jobs'));
        }
    }


}
