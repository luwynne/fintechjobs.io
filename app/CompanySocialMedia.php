<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanySocialMedia extends Model
{
    protected $table = 'company_social_medias';
    
    public function company(){
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function type(){
        return $this->belongsTo(CompanySocialMediaType::class, 'company_id');
    }
}
