<?php

namespace App\Helpers;

use App\Company;
    use App\Job;
    use App\Subscription;
    use App\Payment;
    use Auth;
    use Carbon\Carbon;

class CompanyPlanHelper{


    private function getCompanyLastPaymentDate(){
        $payment = Payment::where('company_id', Auth::user()->company->id)->orderBy('id', 'DESC')->first();

        if($payment){
            return $payment->created_at;
        }else{
            return 0;
        }
        // $today = Carbon::now();
        // $diffPaymentDate = $today->diffInDays($payment->created_at);
        //return $diffPaymentDate;

    }


    public function getCompanyPlan(){

        $payment = Payment::where('company_id', Auth::user()->company->id)->orderBy('id', 'DESC')->first();

        if(!$payment){
            return $companyPlan = 0;
        }

        // $today = Carbon::now();
        // $diffPaymentDate = $today->diffInDays($payment->created_at);

        // if($diffPaymentDate <= 30){
        //     $companyPlan = $payment->plan_id;
        // }else{
        //     $companyPlan = 0;
        // }
        if($payment->plan_id == 6){
            $today = Carbon::now();
            $diffPaymentDate = $today->diffInDays($payment->created_at);

            if($diffPaymentDate <= 30){
                $companyPlan = $payment->plan_id;
            }else{
                $companyPlan = 0;
            }
            return $companyPlan;
        }else{
            return $companyPlan = $payment->plan_id;
        }

    }

    public function getJobsAllowance(){

        $company_plan = $this->getCompanyPlan();

        if($company_plan == 0){
            return $jobs_allowed = 0;
        }

        switch ($company_plan) {
            case $company_plan == 1:
                $jobs_allowed = 1;
                break;
            case $company_plan == 2:
                $jobs_allowed = 3;
                break;
            case $company_plan == 3:
                $jobs_allowed = 5;
                break;
            case $company_plan == 4:
                $jobs_allowed = 10;
                break;
            case $company_plan == 5:
                $jobs_allowed = 100;
                break;
            case $company_plan == 6:
                $jobs_allowed = 1;
                break;

        }
        return $jobs_allowed;
    }

    public function getCompanyJobsCreated(){
        $company_jobs = Job::where('company_id', Auth::user()->company_id)->where('created_at', '>', $this->getCompanyLastPaymentDate())->get();
        $jobs_created = $company_jobs->count();
        return $jobs_created;
    }

    public function getJobCredits(){

        $jobs_created = $this->getCompanyJobsCreated();
        $jobs_allowance = $this->getJobsAllowance();

        if($jobs_allowance == 0){
            return 0;
        }

        if($jobs_created < $jobs_allowance){
            $remaining_jobs_credits = $jobs_allowance - $jobs_created;
            return $remaining_jobs_credits;
        }else{
            return 0;
        }

    }

    public function hasJobCredits(){
        if($this->getJobCredits()){
            return true;
        }
    }

    public function companyNotPreviousPlan(){
        $payment = Payment::where('company_id', Auth::user()->company->id)->where('plan_id', '!=', 6)->get();
        return $payment->count() == 0;
    }

}
