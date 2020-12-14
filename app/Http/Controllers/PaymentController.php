<?php

namespace App\Http\Controllers;

use App\Payment;
use Auth;
use Illuminate\Http\Request;
use App\Http\Resources\PaymentsResource;
use App\Http\Requests\DownloadPaymentRequest;
use PDF;
use Carbon\Carbon;

class PaymentController extends Controller
{

    public function getPayments(){
        $payments = Payment::where('company_id', Auth::user()->company_id)->where('plan_id', '!=', 6)->get();
        return response()->json((New PaymentsResource($payments))->resolve());
    }

    public function  downloadPayment(Payment $payment, DownloadPaymentRequest $request){
        $pdf = PDF::loadView('admin.payment', compact('payment'));
        return $pdf->download(Carbon::now().$payment->id.'.pdf');
    }

}
