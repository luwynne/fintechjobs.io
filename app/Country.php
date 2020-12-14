<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model{

    public $timestamps = false;

    public function education_institutes(){
        return $this->hasMany(EducationInstitute::class, 'country_id');
    }
    
}
