<?php

namespace App\Http\Controllers;

use App\Plan;
use App\DiscountCoupon;
use App\Payment;
use App\Helpers\CompanyPlanHelper;
use Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PlanController extends Controller{

    private function _getProducts(){
        
        $jobs_products = Plan::where('id', '!=', 6)->where('type_id', '=', 1);
        $profile_products = Plan::where('type_id', '=', 2);
        $event_products = Plan::where('type_id', '=', 3);
        $education_products = Plan::where('type_id', '=', 5);
        
        $last_payment = Payment::where('company_id', Auth::user()->company_id)
                                ->where('expire_date', '>', Carbon::now())
                                ->where('plan_id','!=', 6)
                                ->orderBy('created_at', 'DESC')
                                ->first();

        if($last_payment){

            if(in_array($last_payment->plan_id, [1,2,3,4,5])){

                $jobs_products = $jobs_products->where('id', '>', $last_payment->plan_id)->get();
                $event_products = [];
                $profile_products = [];
                $education_products = [];

            }elseif(in_array($last_payment->plan_id, [9,10,11])){

                $jobs_products = $jobs_products->get();
                $event_products = $event_products->get();
                $profile_products = $profile_products->where('id', '>', $last_payment->plan_id)->get();
                $education_products = [];

            }elseif(in_array($last_payment->plan_id, [12,13,14])){

                $jobs_products = $jobs_products->get();
                $event_products = $event_products->where('id', '>', $last_payment->plan_id)->get();
                $profile_products = [];
                $education_products = [];
            
            }elseif(in_array($last_payment->plan_id, [15])){

                $jobs_products = [];
                $event_products = [];
                $profile_products = [];
                $education_products = $education_products->where('id', '>', $last_payment->plan_id)->get();
            
            }else{
                $jobs_products = $jobs_products->get();
                $event_products = $event_products->get();
                $profile_products = $profile_products->get();
                $education_products = $education_products->get();
            }

        }else{
            if(Auth::user()->company->sector_id == 22){
                $jobs_products = [];
                $event_products = [];
                $profile_products = [];
                $education_products = $education_products->get();
            }else{
                //$jobs_products = $jobs_products->get();
                $jobs_products = [];
                $event_products = $event_products->get();
                $profile_products = $profile_products->get();
                $education_products = [];
            }
            
        }
        
        return $products_array = [
            'jobs_products' => $jobs_products,
            'profile_products' => $profile_products,
            'event_products' => $event_products,
            'education_products' => $education_products
        ];

        //return view ('admin.products')->with(compact('jobs_products', 'profile_products', 'event_products', 'discount'));
    }

    public function getProductsPage(){

        $products_array = $this->_getProducts();
        $jobs_products = $products_array['jobs_products'];
        $profile_products = $products_array['profile_products'];
        $event_products = $products_array['event_products'];
        $education_products = $products_array['education_products'];
        $discount = 0;
        return view ('admin.products')->with(compact('jobs_products', 'profile_products', 'event_products', 'education_products', 'discount'));

    }

    public function getProductsPageWithDiscount(Request $request){

        $products_array = $this->_getProducts();
        $jobs_products = $products_array['jobs_products'];
        $profile_products = $products_array['profile_products'];
        $event_products = $products_array['event_products'];
        $education_products = $products_array['education_products'];
        
        if($request->input('coupon')){
            $discount_coupon = DiscountCoupon::where('code', $request->input('coupon'))->first();
            if($discount_coupon){
                $discount = $discount_coupon->percentage_value;
            }else{
                $discount = 0;
            }
        }else{
            $discount = 0; 
        }
        //return $discount;
        return view ('admin.products')->with(compact('jobs_products', 'profile_products', 'event_products', 'education_products', 'discount'));
        
    }

}
