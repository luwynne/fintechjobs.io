<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Cashier\Billable;
use App\Company;
use App\Job;

class User extends Authenticatable
{
    use Notifiable;
    use Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'phone', 'password','role','company_id','provider', 'provider_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'card_brand',
        'card_last_four',
        'stripe_id',
        'trial_ends',
        'updated_at',
        'created_at',
        'email_verified_at',
        'company_id',
        'provider', 
        'provider_id'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // recruiter relationships
    public function application(){
        return $this->hasMany(Application::class, 'user_id');
    }

    public function company(){
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function job(){
        return $this->hasMany('App\Job');
    }

    public function saved_jobs(){
        return $this->belongsToMany(Job::class, 'user_saved_jobs');
    }

    public function appliedJobs(){
        return $this->hasMany(Application::class, 'user_id');
    }

    public function unregistered_mail(){
        return $this->hasOne(UnregisteredUserMail::class, 'user_id');
    }

    // candidate relationships

    // general methods
    public function isRecruiter(){
        return $this->role == "admin" || $this->role == "user";
    }

    public function isCandidate(){
        return $this->role == "candidate";
    }

    public function isSuperAdminAdmin(){
        $env = explode(",", env('APP_SUPER_ADMIN_ADMIN'));
        return in_array($this->email, $env);
    }

    public function isRegularAdmin(){
        $env = explode(",", env('APP_SUPER_ADMIN_GROUP_EMAILS'));
        return in_array($this->email, $env);
    }
}
