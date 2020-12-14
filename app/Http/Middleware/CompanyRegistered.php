<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\Auth;

class CompanyRegistered{

    public function handle($request, Closure $next){

        if(Auth::check()){
            if(Auth::user()->company_id){
                return $next($request);
            }else{
                if(Auth::user()->role !== 'candidate'){
                    return redirect('/auth/companyRegister');
                }else{
                    return redirect('/');
                }
                
            }
        }else{
            return redirect('/login');
        }

    }
}
