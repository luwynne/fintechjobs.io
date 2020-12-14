<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Country;

class CountryController extends Controller{

    public function getCountries(){
        $countries = Country::where('id', '!=', 30)->orderBy('name')->get();
        $other = Country::find(30);
        $other->name = 'Other / Online';
        $countries = $countries->push($other);
        return response()->json($countries);
    }
    
}
