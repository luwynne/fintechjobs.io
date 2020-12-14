<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ExternalEvent extends Model{

    protected $fillable = [
        'company_organiser',
        'name',
        'description',
        'start_date',
        'end_date',
        'city',
        'country_id',
        'fee',
        'url'
    ];

    protected $appends = [
        'clean_image_path',
        'clean_fee',
        'clean_location',
        'year_month'
    ];

    // Relations
    public function country(){
        return $this->belongsTo(Country::class, 'country_id');
    }


    // Functions
    public function getCleanImagePathAttribute(){
        $url = env('APP_URL').'public/images/sample/companies/conference.jpg';
        return $url;
    }

    public function getCleanFeeAttribute(){
        if($this->fee !== null && $this->fee !== ""){
            return (String) $this->fee;
        }else{
            return "No fee";
        }
    }

    public function getCleanLocationAttribute(){
        if($this->country_id == 30){
            return 'Online';
        }else{
            return $this->city == '' ? $this->country->name : $this->city .' - '. $this->country->name;
        }
    }

    public function getYearMonthAttribute(){
        $year = Carbon::parse($this->start_date)->format('Y-m');
        return $year;
    }
    
}
