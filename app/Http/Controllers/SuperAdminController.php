<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{
    Company,
    Plan,
    CompanySector,
    Job,
    Event,
    Course,
    Country,
    ExternalEvent,
    EducationInstitute
};
use Carbon\Carbon;
use Auth;
use App\Http\Requests\{
    CreateEditEventExternalEventRequest,
    CreateEditEducationInstituteRequest
};

class SuperAdminController extends Controller{

    public $countries;

    public function __construct(){
        $countries = Country::where('id', '!=', 30)->orderBy('name')->get();
        $other = Country::find(30);
        $other->name = 'Other / Online';
        $this->countries = $countries->push($other);
    }
    
    public function index(){
        if(Auth::user()->isSuperAdminAdmin()){
            $companies = Company::paginate(8);
            return view('super_admin/home', compact('companies'));
        }
        return redirect('superadmin/external_events');
    }
    
    
    // Companies
    public function showCompany(Company $company){
        //$plans = Plan::all();
        $plans = Plan::whereNotIn('id', [1,2,3,4,5])->get();
        $sectors = CompanySector::all();
        $company_last_plan_id = $company->payment ? $company->payment->last()->plan_id : null;
        return view('super_admin/company-show', compact('company', 'plans', 'company_last_plan_id', 'sectors'));
    }

    public function updateCompany(Request $request, Company $company){
        $company->update([
            'sector_id' => $request->input('sector')
        ]);
        if($company->payment){
            $company_plan = $company->payment->last();
            $company_plan->plan_id = $request->input('plan');
            $company_plan->save();
        }
        return redirect()->back();    
    }

    
    // Jobs
    public function renderJobsPage(){
        $jobs = Job::where('is_approved', false)->paginate(8);
        return view('super_admin/jobs', compact('jobs'));
    }

    public function getNotApprovedJob($job_id){
        $job = Job::find($job_id);
        return view('super_admin/job-show', compact('job'));
    }

    public function approveJob($job_id){
        $job = Job::find($job_id);
        $job->expiration = Carbon::now()->add(30, 'day');
        $job->is_approved = true;
        $job->save();
        return redirect('superadmin/jobs');
    }

    
    // Events
    public function renderEventsPage(){
        $events = Event::where('is_approved', false)->paginate(8);
        return view('super_admin/events', compact('events'));
    }
    
    public function getNotApprovedEvent($event_id){
        $event = Event::find($event_id);
        return view('super_admin/event-show', compact('event'));
    }

    public function approveEvent($event_id){
        $event = Event::find($event_id);
        $event->is_approved = true;
        $event->save();
        return redirect('superadmin/events');
    }

    
    public function renderExternalEventsPage(){
        $events = ExternalEvent::paginate(8);
        return view('super_admin/external-events', compact('events'));
    }


    public function renderCreateEventPage(){
        $countries = $this->countries;
        return view('super_admin/external-event-create', compact('countries'));
    }

    
    public function renderEditEventPage($event_id){
        $countries = $this->countries;
        $event = ExternalEvent::findOrFail($event_id);
        return view('super_admin/external-event-edit', compact('countries','event'));
    }


    public function createEvent(CreateEditEventExternalEventRequest $request){
        $event = $this->saveEditEvent($request, null);
        return redirect('superadmin/edit_event/'.$event->id);
    }

    public function editEvent($event_id, CreateEditEventExternalEventRequest $request){
        $event = $this->saveEditEvent($request, $event_id);
        return redirect('superadmin/edit_event/'.$event->id);
    }

    public function saveEditEvent($request, $event_id): ExternalEvent{
        //dd($request->input('is_approved'));
        if($event_id == null){
            $event = new ExternalEvent();
        }else{
            $event = ExternalEvent::find($event_id);
        }
        
        $event->name = $request->input('name');
        $event->company_organiser = $request->input('company');
        $event->description = $request->input('description');

        if($request->input('start_time')){
            $event->start_date = Carbon::parse($request->input('start_date').$request->input('start_time'))->format('Y-m-d h:i:s');
        }else{
            $event->start_date = $request->input('start_date');
        }

        if($request->input('end_time')){
            $event->end_date = Carbon::parse($request->input('end_date').$request->input('end_time'))->format('Y-m-d h:i:s');
        }else{
            $event->end_date = $request->input('end_date');
        }
        
        $event->city = $request->input('city');
        $event->country_id = $request->input('country');
        $event->fee = $request->input('fee');
        $event->url = $request->input('url');
        $event->is_approved = $event_id == null ? false : (boolean)$request->input('is_approved');
        $event->save();
        return $event;
    }


    // Courses
    public function renderCoursesPage(){
        $courses = Course::where('is_approved', false)->paginate(8);
        return view('super_admin/courses', compact('courses'));
    }
    
    public function getNotApprovedCourse($course_id){
        $course = Course::find($course_id);
        return view('super_admin/course-show', compact('course'));
    }

    public function approveCourse($course_id){
        $course = Course::find($course_id);
        $course->is_approved = true;
        $course->save();
        return redirect('superadmin/courses');
    }

    
    
    // Education institutes
    public function renderCreateEducationInstitutePage(){
        $countries = $this->countries;
        return view('super_admin/education-institute-create', compact('countries'));
    }


    public function renderEditEducationInstitutePage($institute_id){
        $institute = EducationInstitute::find($institute_id);
        $countries = $this->countries;
        return view('super_admin/education-institute-edit', compact('institute', 'countries'));
    }

    
    public function createEducationInstitute(CreateEditEducationInstituteRequest $request){
        $institute = $this->saveEditEducationInstitute($request, null);
        return redirect('superadmin/edit_education_institute/'.$institute->id);
    }

    
    public function editEducationInstitute($institute_id, CreateEditEducationInstituteRequest $request){
        $institute = $this->saveEditEducationInstitute($request, $institute_id);
        return redirect('superadmin/edit_education_institute/'.$institute->id);
    }


    public function getEducationInstitutes(){
        $institutes = EducationInstitute::paginate(8);
        return view('super_admin/education-institutes', compact('institutes'));
    }

    
    public function saveEditEducationInstitute(Request $request, $institute_id){
        
        if($institute_id == null){
            $institute = new EducationInstitute();
        }else{
            $institute = EducationInstitute::find($institute_id);
        }
        
        $institute->name = $request->input('name');
        $institute->country_id = $request->input('country');
        $institute->url = $request->input('url');
        $institute->contact_email = $request->input('contact_email');
        $institute->is_approved = $institute_id == null ? false : (boolean)$request->input('is_approved');

        if($institute_id !== null){

            if($institute->logo_name !== '' && $request->file('logo')){
                $destinationpath = public_path('images/sample/institutes/');
                $file_path = $destinationpath.$institute->logo_name;
                unlink($file_path);
            }

        }

        if($request->file('logo')){
            $fileName = time().'.'.$request->file('logo')->extension();
            $request->file('logo')->move(public_path('images/sample/institutes/'), $fileName);
            $institute->logo_name = $fileName;
        }

        $institute->save();

        $courses_count = $request->input('courses_count');
        $db_courses_count = $request->input('db_courses_count');

        if($db_courses_count == 0 || $courses_count > 0){
            $institute->courses->each(function($course){
                $course->delete();
            });
        }
        
        if($courses_count > 0){

            for($i = 1; $i <= $courses_count; $i++){
            
                $course_name_string = (string)'course_name_'.$i;
                $course_name = $request->{$course_name_string};
    
                $course_description_string = (string)'course_description_'.$i;
                $course_descripion = $request->{$course_description_string};
    
                $course_url_string = 'course_url_'.$i;
                $course_url = $request->{$course_url_string};

                if($course_name !== null && $course_descripion !== null && $course_url !== null){
                    $course = new Course();
                    $course->institute_id = $institute->id;
                    $course->name = $course_name;
                    $course->description = $course_descripion;
                    $course->url = $course_url;
                    $course->is_approved = true;
                    $course->save();
                }
                
            }

        }

        return $institute;

    }
    
}
