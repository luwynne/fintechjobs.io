<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model{

    public function institute(){
        return $this->belongsTo(EducationInstitute::class, 'institute_id');
    }

    public function render_escaped_html_description(){
        return strip_tags($this->description);
    }

    
    
}
