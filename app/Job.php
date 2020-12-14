<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Company;
use App\User;
use App\Application;
use Auth;
use Carbon\Carbon;

class Job extends Model{

    protected $append = ['recruiterName'];

    protected $casts = ['salary' => 'float(3,2)'];

    protected $fillable = [
        'name', 'description', 'salary', 'location', 'experience_years', 'bonus', 'expiration', 'company_id','recruiter_id'
    ];

    protected $appends = [
        'clean_url_name',
    ];
    
    public function getRouteKeyName(){
        return 'slug';
    }

    public function company(){
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function recruiter(){
        return $this->belongsTo(User::class, 'recruiter_id');
    }

    public function application(){
        return $this->hasMany(Application::class, 'job_id');
    }

    public function saved_jobs(){
        return $this->belongsToMany(User::class, 'user_saved_jobs');
    }

    // Model methods
    public function recruiterName(){
        return $this->recruiter->name;
    }

    public function isNotExpired(){
        return $this->expiration > Carbon::now();
    }

    public function render_escaped_html_description(){
        return strip_tags($this->description);
    }

    public function getCleanUrlNameAttribute(){
        $job_name = strtolower(str_replace(' ', '-', $this->name));
        $url = env('APP_URL').'job/'.$this->id.'/'.$job_name;
        return $url;
    }

    public function hasBeenSavedByUser(){
        if(Auth::user()){
            $repeated_save_jobs = $this->saved_jobs()->where('user_id', Auth::user()->id);
            if($repeated_save_jobs->count() > 0){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function hasBeenAppliedByUser(){
        if(Auth::user()){
            $repeated_applied_jobs = $this->application->where('user_id', Auth::user()->id);
            if($repeated_applied_jobs->count() > 0){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    
}
