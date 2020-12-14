<?php
 

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyDescription extends Model{

    protected $table = "companies_descriptions";

    public function company(){
        return $this->belongsTo(Company::class, 'company_id');
    }
    
}
