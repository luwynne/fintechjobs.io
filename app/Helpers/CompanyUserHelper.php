<?php

namespace App\Helpers;

use App\Company;
use App\User;
use Auth;

class CompanyUserHelper{

    public function getCompanyUsers(){
        $users = User::where('company_id', Auth::user()->company_id);
        if($users->count() >= 3){
            return false;
        }else{
            return true;
        }
    }

    public function canAddUser(){
        return $this->getCompanyUsers();
    }


}
