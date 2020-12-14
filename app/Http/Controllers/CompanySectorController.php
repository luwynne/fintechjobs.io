<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CompanySector;

class CompanySectorController extends Controller{

    public function getCompanySectors(){
        $company_sectors = CompanySector::all();
        return response()->json($company_sectors, 200);
    }
    
}
