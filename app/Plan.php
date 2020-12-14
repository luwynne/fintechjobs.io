<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Company;
use App\Payment;

class Plan extends Model
{

    protected $fillable = [
        'name', 'description', 'job_allowance', 'plain_price', 'vat', 'full_price', 'duration_days'
    ];

    public function company(){
        return $this->hasMany('App\Company');
    }

    public function payment(){
        return $this->hasMany('App\Payment');
    }

    public function type(){
        return $this->belongsTo(PlanType::class, 'type_id');
    }
}
