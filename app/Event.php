<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Event extends Model{

    protected $dates = ['start_date', 'end_date'];

    protected $appends = [
        'clean_url_name',
        'clean_image_path',
        'clean_fee',
        'clean_location',
        'year_month'
    ];

    public function getRouteKeyName(){
        return 'slug';
    }

    // Relations
    public function company(){
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function country(){
        return $this->belongsTo(Country::class, 'country_id');
    }

    // Functions
    public function render_escaped_html_description(){
        return strip_tags($this->description);
    }

    public function getCleanUrlNameAttribute(){
        $event_name = strtolower(str_replace(' ', '-', $this->name));
        $url = env('APP_URL').'event/'.$this->id.'/'.$event_name;
        return $url;
    }

    public function getCleanImagePathAttribute(){
        $url = env('APP_URL').'public/admin/img/events/'.$this->file_name;
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
