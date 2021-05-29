<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class kn1
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // // return $next($request);
        // // dd($next($request));
        
        // if(!Auth::check()){
        //     return redirect()->route('login');
        // }
        // // role 1 = super
        // if(Auth::user()->role==1){
        //     return redirect()->route('superadmin');
            
        // }
        // // role 2 = kn1
        // if(Auth::user()->role==2){
        //     return $next($request);
        // }
        // // role 3 = user
        // if(Auth::user()->role==3){
        //     return redirect()->route('kn2');
        // }

    }
}
