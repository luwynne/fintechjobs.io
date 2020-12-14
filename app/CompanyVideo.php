<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyVideo extends Model{

    protected $casts = [
        'external_id'  =>  'integer'
    ];

    public function company(){
        return $this->belongsTo(Company::class, 'company_id');
    }
    
}
