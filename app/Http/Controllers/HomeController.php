<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\{
    Company,
    Job,
    CompanySector,
    Event,
    EducationInstitute,
    Country,
    ExternalEvent
};

use Carbon\Carbon;
use Mail;
use App\Http\Resources\{
    EventResource,
    EventsResource
};

use App\Importers\Careerjet_API;

// this controller is responsible for the public website data
class HomeController extends Controller
{

    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index(){

        $associations = Company::whereHas('logo')
                                ->where('sector_id', 21)
                                ->whereHas('description', function($q){
                                    $q->where('content', '!=', "");
                                })->get();

        // $jobs = Job::whereDate('expiration', '>', Carbon::now())->orderBy('id', 'DESC')->limit(10)->get();
        /*$db_jobs = Job::orderBy('id', 'DESC')->where('is_approved', true)->limit(10)->get();
        
        $api = new Careerjet_API('en_GB') ;
        $page = 1 ; # Or from parameters.

        $result = $api->search(array(
            'keywords' => 'fintech',
            'location' => 'London',
            'page' => $page ,
            'affid' => '678bdee048',
        ));
        
        $job_objects = [];  
        $counter = 0;    
        foreach($result->jobs as $api_job){
            $counter ++;
            if($counter <= 15){
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
        
        $jobs = collect($job_objects)->take(20);

        $jobs = $jobs->filter(function($job){
            return $job['salary'] !== "";
        });*/
        
        return view('website.home')->with(compact('associations'));
    }

    public function showJob($id){
        $job = Job::findOrFail($id);
        return view('website.job')->with(compact('job'));
    }

    public function showCompany(Company $company){
        //$jobs = $company->job->where('is_approved', true)->sortByDesc('id');
        $jobs = [];
        $call_slug = $company->sector_id == 21 ? 'Association' : 'Company';
        return view('website.company', compact('company', 'jobs', 'call_slug'));
    }

    public function getCompaniesAndSectors(){
        $sectors = CompanySector::whereNotIn('id',[21,22])->get();
        return view('website.companies', compact('sectors'));
    }

    public function getAssociationsPage(){
        return view('website.associations');
    }

    public function getEducationPage(){
        $countries = Country::orderBy('name')->get();
        return view('website.education', compact('countries'));
    }

    public function getEventsPage(){
        $countries = Country::where('id', '!=', 30)->orderBy('name')->get();
        $other = Country::find(30);
        $other->name = 'Other / Online';
        $countries = $countries->push($other);
        return view('website.events', compact('countries'));
    }

    
    // Companies page
    public function getCompanies(Request $request){

        $companies = Company::with('representant')
                            ->whereHas('logo')
                            ->whereNotIn('sector_id', [21,22]);

        if(null != $request->input('name')){
            $name = $request->input('name');
            $companies = $companies->where('name', 'like', '%'.$name.'%');
        }

        if(null != $request->input('sector')){
            $sector_id = $request->input('sector');
            $companies = $companies->whereHas('sector', function($q) use($sector_id){
                $q->where('id', $sector_id);
            });
        }

        $companies = $companies->orderBy('name', 'ASC')->get();
        
        return response($companies->values());    

    }

    
    // Associations page
    public function getAssociations(Request $request){

        $companies = Company::with('representant')->whereHas('logo')->where('sector_id', 21);

        if(null != $request->input('name')){
            $name = $request->input('name');
            $companies = $companies->where('name', 'like', '%'.$name.'%');
        }

        $companies = $companies->orderBy('name', 'ASC')->get();
        
        return response($companies->values());    

    }


    // Education page
    public function getInstitutes(Request $request){
        
        $institutes = EducationInstitute::with('country')->where('logo_name', '!=', '')->where('is_approved', true);

        if(null != $request->input('name')){
            $name = $request->input('name');
            $institutes = $institutes->where('name', 'like', '%'.$name.'%');
        }

        if(null != $request->input('country_id')){
            $country_id = $request->input('country_id');
            $institutes = $institutes->where('country_id', $country_id);
        }

        $institutes = $institutes->orderBy('name', 'ASC')->get();

        return response($institutes->values());

    }

    public function showInstitute(EducationInstitute $institute){
        $courses = $institute->courses->where('is_approved', true)->sortBy('name');
        $jobs = $institute->company->jobs ? $institute->company->jobs->where('is_approved', true)->sortByDesc('id') : collect();
        return view('website.institute', compact('institute','courses','jobs'));
    }

    public function getEvents(Request $request){
        $today = Carbon::now();
        $events = collect();
        $internal_events = Event::query();
        $external_events = ExternalEvent::query();

        if($request->input('country')){
            $internal_events = $internal_events->where('country_id', $request->input('country'));
            $external_events = $external_events->where('country_id', $request->input('country'));
        }

        $internal_events = $internal_events->where('end_date', '>', $today)->where('is_approved',true)->get();
        $external_events = $external_events->where('end_date', '>', $today)->where('is_approved',true)->get();

        if($request->input('month')){
            
            $internal_events = $internal_events->filter(function($internal_event) use($request){
                return $internal_event->year_month == $request->input('month');
            });

            $external_events = $external_events->filter(function($external_event) use($request){
                return $external_event->year_month == $request->input('month');
            });

        }

        
        $internal_events->each(function($event) use($events){
            $events->push([
                'name' => $event->name,
                'organizer' => $event->company->name,
                'location' => $event->clean_location,
                'start_date' => $event->start_date,
                'fee' => $event->clean_fee,
                'url' => $event->clean_url_name,
                'image_path' => $event->clean_image_path,
                'type' => Event::class,
                'year_month' => $event->year_month
            ]);
        });
        
        $external_events->each(function($event) use($events){
            $events->push([
                'name' => $event->name,
                'organizer' => $event->company_organiser,
                'location' => $event->clean_location,
                'start_date' => $event->start_date,
                'fee' => $event->clean_fee,
                'url' => $event->url,
                'image_path' => $event->clean_image_path,
                'type' => ExternalEvent::class,
                'year_month' => $event->year_month
            ]);
        });

        $events = $events->sortBy('start_date');
        
        return response()->json(new EventsResource($events));
    }

    public function showEvent($id){
        $event = Event::findOrFail($id);
        return view('website.event')->with(compact('event'));
    }

}
