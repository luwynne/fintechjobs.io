<?php 

namespace App\Helpers;

use App\{
    Job,
    Event,
    Course,
    ExternalEvent
};

class SuperAdminHelper{

    public static function getJobToApprove(){
        $jobs_to_approve = Job::where('is_approved', false)->get();
        return $jobs_to_approve->count(); 
    }

    public static function getEventToApprove(){
        $events_to_approve = Event::where('is_approved', false)->get();
        return $events_to_approve->count(); 
    }

    public static function getCourseToApprove(){
        $courses_to_approve = Course::where('is_approved', false)->get();
        return $courses_to_approve->count(); 
    }

    public static function getExternalEventToApprove(){
        $external_event = ExternalEvent::where('is_approved', false)->get();
        return $external_event->count();
    }

}