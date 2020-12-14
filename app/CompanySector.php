<?php

namespace App;

use App\Company;

use Illuminate\Database\Eloquent\Model;

class CompanySector extends Model{
    
    protected $table = "company_sectors";

    public function companies(){
        return $this->hasMany(Company::class, 'sector_id');
    }

}
