<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EducationInstitute extends Model{

    protected $fillable = [
        'name',
        'country_id',
        'url',
        'contact_email',
        'logo_name'
    ];

    protected $appends = [
        'is_registered',
        'clean_url'
    ];

    public function country(){
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function company(){
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function courses(){
        return $this->hasMany(Course::class, 'institute_id');
    }

    // functions
    public function getIsRegisteredAttribute(){
        return $this->company_id !== null;
    }

    // Model Attributes
    public function getCleanUrlName(){
        return strtolower(str_replace(' ', '-', $this->name));
    }

    public function getCleanUrlAttribute(){
        
        if($this->company_id == null){
            return $this->url;
        }
        return env('APP_URL').'education/'.$this->id.'/'.$this->getCleanUrlName();
    }
    
}
