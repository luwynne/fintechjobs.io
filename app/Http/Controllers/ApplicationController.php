<?php

namespace App\Http\Controllers;

use App\Application;
use App\Job;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\ApplicationRequest;
use Mail;
use Auth;
use App\Http\Resources\JobsResource;
use Carbon\Carbon;
use App\Events\ApplicationCreatedEvent;

class ApplicationController extends Controller{

    public function apply(ApplicationRequest $request, $job_id){

        $file = $request->file('file');
        
        $application = new Application();
        $application->job_id = $job_id;
        $application->name = $request->input('name');
        $application->email = $request->input('email');
        $application->phone = $request->input('phone');
        $application->linkedin = $request->input('linkedin');
        $application->cover_letter = $request->input('cover_letter');
        
        if(Auth::user() && Auth::user()->isCandidate()){
            $application->user_id = Auth::user()->id;
        }

        $application->save();

        $job_applied = $application->job;
        $recruiter = $job_applied->recruiter;
        $recruiter_email = $recruiter->email;
        $recruiter_name = $recruiter->name;

        $data = array(
            'job_id' => $request->input('job_id'),
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'linkedin' => $request->input('linkedin'),
            'cover_letter' => $request->input('cover_letter'),
            'job_applied' => $job_applied->name,
            'newsletter' => false
        );

         if($application){
            if(Auth::user() && Auth::user()->isCandidate()){
                $this->checkJobIsSavedAndDelete(Auth::user(), $request->input('job_id'));
            }
            event(new ApplicationCreatedEvent($application, $data, $file, $recruiter_email, $recruiter_name));
            return response()->json(['message'=>'You application has been made'], 200);
         }else{
            return response()->json(['message'=>'No application has been done']);
         }

    }


    private function checkJobIsSavedAndDelete($user, $job_id){
        $user->saved_jobs()->detach($job_id);
    }

    public function getApplications(){
        $jobs = Job::where('company_id', Auth::user()->company->id)->with('application')->get();
        return response()->json((New JobsResource($jobs))->resolve(['with_application']));
    }



}
