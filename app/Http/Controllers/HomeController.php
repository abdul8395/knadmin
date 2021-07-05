<?php

namespace App\Http\Controllers;
use Auth;


use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
  

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        // return redirect()->route('switch_layre', ['area_b_demolitions']);
        if (Auth::user()) {       
            $role=auth()->user()->role;
            if($role==1){
                // return view('kn1');
                // Route::redirect('switch_layre/', '{{"area_b_demolitions"}}');
                return redirect()->route('switch_layre', ['area_b_demolitions']);
            }elseif($role==2){
                return view('kn2');
            }else{
                return view('auth.login');
            }
        }
        
    }
}
