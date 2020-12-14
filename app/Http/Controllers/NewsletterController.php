<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Newsletter;
use App\Http\Requests\JobAlertRequest;

class NewsletterController extends Controller{

    public function subscribePage(){
        return view('website.subscribe');
    }
    
    public function createAjaxNewsletter(JobAlertRequest $request){

        if(Newsletter::create([
            'job_search' => $request->input('job_search') ? $request->input('job_search') : '',
            'email' => $request->input('email'),
            'often' => $request->input('often') ? (int)$request->input('often') : null
        ])){
            return response()->json(['message'=>'Newsletter has been created'], 200);
        }else{
            //return response()->json(['message'=>'Somethign went wrong'], 500);
            return response();
        }

    }
    
    public function deleteNewsletter($newsletterId){
        $newsletter = Newsletter::find($newsletterId);
        if($newsletter){
            $newsletter->delete();
            $found = true;
            $message = 'Newsletter has been deleted';
            return view ('website.delete-newsletter', compact('message', 'found'));
        }else{
            $found = false;
            $message = 'Newsletter has not been found';
            return view ('website.delete-newsletter', compact('message', 'found'));
        }
    }

}
