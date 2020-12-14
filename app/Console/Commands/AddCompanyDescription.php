<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\{
    Company,
    CompanyDescription,
    CompanySocialMedia
};

class AddCompanyDescription extends Command
{

    protected $signature = 'company:add_description';

    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

    
    public function handle(){

        $companies = Company::all();
        $companies->each(function($company){
            if(!$company->description){
                $description = new CompanyDescription();
                $description->company_id = $company->id;
                $description->content = " ";
                $description->save();
            }

            if($company->social_medias){
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
            
        });
        
    }
}

