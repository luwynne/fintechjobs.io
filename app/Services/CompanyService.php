<?php

namespace App\Services;

use App\{
    Company,
    CompanyDescription,
    CompanySocialMedia,
    Payment
};
use Carbon\Carbon;

class CompanyService{

    public static function websiteUrlCleansing($url):String{

        if (strlen(strstr($url,"https://")) > 0) {
            $url = str_replace("https://", "", $url);
        }elseif(strlen(strstr($url,"http://"))>0){
            $url = str_replace("http://", "", $$url);
        }else{
            $url = $url;
        } 
        return $url;
    }

    public static function createBasePackage(int $company_id):Payment{
        $package = Payment::create([
            'company_id' => $company_id,
            'plan_id' => 6,
            'amount' => 0,
            'expire_date' => Carbon::now()->add(30, 'day')
         ]);
         return $package;
    }

    public static function createCompanyPlaceHolders(Company $company):void{

        $description = new CompanyDescription();
        $description->company_id = $company->id;
        $description->content = " ";
        $description->save();

        $company_facebook = new CompanySocialMedia();
        $company_facebook->company_id = $company->id;
        $company_facebook->type_id = 1;
        $company_facebook->url = '';
        $company_facebook->save();

        $company_linkedin = new CompanySocialMedia();
        $company_linkedin->company_id = $company->id;
        $company_linkedin->type_id = 2;
        $company_linkedin->url = '';
        $company_linkedin->save();

        $company_twitter = new CompanySocialMedia();
        $company_twitter->company_id = $company->id;
        $company_twitter->type_id = 3;
        $company_twitter->url = '';
        $company_twitter->save();

    }

}