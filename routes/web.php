<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\kn1;
use App\Http\Controllers\kn2;
use App\Http\Controllers\superadmin;
use App\Http\Controllers\HomeController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
// Route::get('/kn22' , [kn1::class,'index']);


Route::get('/switch_layre/{name}' , [kn1::class,'switch_layre']);
Route::get('/switch_layre/switch_layre/loadtbledata' , [kn1::class,'loadtbledata']);
Route::get('/switch_layre/switch_layre/deletedata/{id}' , [kn1::class,'deletedata']);
Route::get('/switch_layre/switch_layre/editdata/{id}' , [kn1::class,'editdata']);
Route::get('/switch_layre/switch_layre/updatedata/{data}' , [kn1::class,'updatedata']);
Route::get('/switch_layre/switch_layre/savedata/{data}' , [kn1::class,'savedata']);
Auth::routes();
// ------------kn1 rooutes----------------


// Route::match(['get','post'], '/kn1', [kn1::class, 'index'])->name('kn1')->middleware('kn1');
// // ------------kn2 rooutes----------------
// Route::match(['get','post'], '/kn2', [kn2::class, 'index'])->name('kn2')->middleware('kn2');
// // ------------superadmin rooutes----------------
// Route::match(['get','post'], '/superadmin', [superadmin::class, 'index'])->name('superadmin')->middleware('superadmin');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
