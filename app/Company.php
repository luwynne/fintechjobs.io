<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\CompanyUser;
use App\Job;
use App\Plan;
use App\Payment;
use App\CompanySector;
use Carbon\Carbon;


class Company extends Model
{
    protected $today;
    
    protected $fillable = [
        'name', 'sector_id', 'address', 'phone', 'website', 'representative_id', 'plan_id'
    ];

    protected $appends = [
        'clean_url_name',
    ];

    public function __construct(){
        $this->today = Carbon::now();
    }

    protected $with = ['sector', 'description', 'logo'];

    public function user(){
        return $this->hasMany(User::class, 'company_id');
    }

    public function representant(){
        return $this->belongsTo(User::class, 'representative_id');
    }

    public function job(){
        return $this->hasMany(Job::class, 'company_id');
    }

    public function payment(){
        return $this->hasMany(Payment::class, 'company_id');
    }
    
    public function sector(){
        return $this->belongsTo(CompanySector::class, 'sector_id');
    }

    public function description(){
        return $this->hasOne(CompanyDescription::class, 'company_id');
    }

    public function assets(){
        return [
            'logo' => [
                'file_name' => $this->logo->file_name
            ],
            'video' => [
                'path_name' => $this->video->path_name
            ]
        ];
    }
    
    public function logo(){
        return $this->hasOne(CompanyLogo::class, 'company_id');
    }

    public function vimeo_video(){
        return $this->hasOne(CompanyVideo::class, 'company_id')->where('type_id', 1);
    }

    public function youtube_video(){
        return $this->hasOne(CompanyVideo::class, 'company_id')->where('type_id', 2);
    }

    public function social_medias(){
        return $this->hasMany(CompanySocialMedia::class, 'company_id');
    }

    public function facebook(){
        return $this->hasOne(CompanySocialMedia::class, 'company_id')->where('type_id', 1);
    }

    public function linkedin(){
        return $this->hasOne(CompanySocialMedia::class, 'company_id')->where('type_id', 2);
    }

    public function twitter(){
        return $this->hasOne(CompanySocialMedia::class, 'company_id')->where('type_id', 3);
    }

    public function events(){
        return $this->hasMany(Event::class, 'company_id');
    }

    public function education_institute(){
        return $this->hasOne(EducationInstitute::class, 'company_id');
    }



    // Model Attributes
    public function getCleanUrlNameAttribute(){
        return strtolower(str_replace(' ', '-', $this->name));
    }


    // Company plan information

    private function getCompanyValidPaymet(){
        $payment = $this->payment->last();
        if(!$payment){
            return null;
        }
        return $payment;
    }

    public function isPlanExpired(){
        return Carbon::parse($this->payment->last()->expire_date) < $this->today;
    }

    public function getCompanyPlanId(){
        return ! $this->getCompanyValidPaymet() == null ? $this->getCompanyValidPaymet()->plan->id : null;
    }

    public function getCompanyPlanName(){
        return ! $this->getCompanyValidPaymet() == null ? $this->getCompanyValidPaymet()->plan->name : null;
    }

    
    // JOBS
    public function getCompanyJobsAllowance(){
        return ! $this->getCompanyValidPaymet() == null ? $this->getCompanyValidPaymet()->plan->job_allowance : null;
    }

    public function getCompanyJobsCreated(){
        if($this->job()->count() > 0){
            return ! $this->getCompanyValidPaymet() == null ?
                    $this->job()->where('created_at', '>', $this->getCompanyValidPaymet())->count() : 0;
        }else{
            return 0;
        }
    }

    public function getCompanyRemainingJobs(){
        return $this->getCompanyJobsAllowance() ? $this->getCompanyJobsAllowance() - $this->getCompanyJobsCreated() : 0;
    }

    public function hasJobCredits(){
        if($this->getCompanyRemainingJobs() > 0){
            return true;
        }
    }


    // SOCIAL MEDIA
    public function isSocialMediaAllowed(){
        if(!$this->getCompanyValidPaymet() == null){
            return $this->getCompanyValidPaymet()->plan->social_media_allowed == 1 ? true : false;
        }else{
            return false;
        }
    }

    // VIDEO
    public function isVideoAllowed(){
        if(!$this->getCompanyValidPaymet() == null){
            return $this->getCompanyValidPaymet()->plan->video_allowed == 1 ? true : false;
        }else{
            return false;
        }
    }

    
    // EVENTS
    public function getCompanyEventsAllowance(){
        return ! $this->getCompanyValidPaymet() == null ? $this->getCompanyValidPaymet()->plan->events_allowance : null;
    }

    public function getCompanyEventsCreated(){
        if($this->events()->count() > 0){
            return ! $this->getCompanyValidPaymet() == null ?
                    $this->events()->where('created_at', '>', $this->getCompanyValidPaymet())->count() : 0;
        }else{
            return 0;
        }
    }

    public function getCompanyRemainingEvents(){
        return $this->getCompanyEventsAllowance() ? $this->getCompanyEventsAllowance() - $this->getCompanyEventsCreated() : 0;
    }

    public function hasEventCredits(){
        if($this->getCompanyRemainingEvents() > 0){
            return true;
        }
    }

    // Education institutes
    public function isEducationInstitute(){
        return $this->education_institute !== null;
    }

    public function getCompanyCoursesAllowance(){
        return ! $this->getCompanyValidPaymet() == null ? $this->getCompanyValidPaymet()->plan->courses_allowance : null;
    }

    public function getCompanyCoursesCreated(){
        if(!$this->isEducationInstitute()){
            return 0;
        }
        if($this->education_institute->courses()->count() > 0){
            return ! $this->getCompanyValidPaymet() == null ?
                    $this->education_institute->courses()->where('created_at', '>', $this->getCompanyValidPaymet())->count() : 0;
        }else{
            return 0;
        }
    }

    public function getCompanyRemainingCourses(){
        return $this->getCompanyCoursesAllowance() ? $this->getCompanyCoursesAllowance() - $this->getCompanyCoursesCreated() : 0;
    }

    public function hasCourseCredits(){
        if($this->getCompanyRemainingCourses() > 0){
            return true;
        }
    }

}
