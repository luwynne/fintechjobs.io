<?php

namespace App\Http\Middleware;

use Closure;

class SuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        $env = explode(",", env('APP_SUPER_ADMIN_GROUP_EMAILS'));
        if(in_array(request()->user()->email, $env) && request()->user()->role == 'admin'){
            return $next($request);  
        }else{
            return redirect('admin/home');
        }
        
    }
}
