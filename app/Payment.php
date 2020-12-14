<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Company;
use App\Plan;

class Payment extends Model
{

    protected $fillable = [
        'company_id', 'plan_id', 'amount', 'expire_date'
    ];

    public function company(){
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function plan(){
        return $this->belongsTo(Plan::class, 'plan_id');
    }
}
