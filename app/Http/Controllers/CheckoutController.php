<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Company;
use App\Payment;
use App\Plan;
use Auth;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;
use Carbon\Carbon;
use Mail;


class CheckoutController extends Controller{

    public function __construct(){
        $this->middleware('companyAdmin');
    }

    public function subscribe_process(Request $request){

    try {

        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $user = User::find(Auth::user()->id);
        if($request->input('discount') > 0){
            $user->newSubscription('main', $request->input('package'))->withCoupon('fintech-association-2020')->create($request->stripeToken);
        }else{
            $user->newSubscription('main', $request->input('package'))->create($request->stripeToken);
        }


        $package_name = $request->input('package');

        $package = Plan::where('stripe_value', $package_name)->first();

        if(!$package){
            return response()->json(['error' => 'Package was not found'], 422);
        }
        
        $package_id = $package->id;
        $package_amount = $package->full_price;

        if($request->input('discount') > 0){
            $package_amount = $package_amount - (($package_amount * $request->input('discount')) / 100);
        }

        $payment = Payment::create([
            'company_id' => Auth::user()->company->id,
            'plan_id' => $package_id,
            'amount' => $package_amount,
            'expire_date' => Carbon::now()->addDays($package->duration_days)
        ]);

        $user_email = $user->email;
        $user_name = $user->name;
        $payment_package = Plan::find($payment->plan_id);
        $payment_date = Carbon::parse($payment->created_at)->format('d/m/Y');

        $data = array(
            'payment_package' => $payment_package->name,
            'payment_date' => $payment_date,
            'payment_amount' => $package_amount,
            'newsletter' => false
        );

        Mail::send('mails.payment', $data, function($message) use ($user_email, $user_name){
            $message->to($user_email, $user_name)->subject('Payment Received | Fintechjobs.io');
            $message->from('info@fintechjobs.io','Fintechjobs.io');
         });

         // send email to customer with payment receipt

        return redirect('admin/subscribe_success');

    } catch (\Exception $ex) {
        return $ex->getMessage();
    }

}

}
