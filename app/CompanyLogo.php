<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyLogo extends Model{

    protected $appends = [
        'full_path'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function company(){
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function getFullPathAttribute(){
        // change when deployd
        return "/fintechjobs.io/public/admin/img/logos/".$this->file_name;
    }
    
}
