<?php

namespace App\Http\Controllers;
use Auth;

use Illuminate\Http\Request;

class superadmin extends Controller
{
    public function index(){
     
        return view('superadmin.index');
    } 
}
