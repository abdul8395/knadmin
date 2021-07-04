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
    return redirect('/login');
});
// Route::get('/kn22' , [kn1::class,'index']);


Auth::routes();
// ------------area_b_demolation    rooutes----------------
Route::get('/switch_layre/{name}' , [kn1::class,'switch_layre'])->name('switch_layre')->middleware('auth');
// ------------kn1 rooutes----------------
Route::post('/switch_layre/switch_layre/insert_area_b_demolation' , [kn1::class,'insert_area_b_demolation']);
Route::get('/switch_layre/switch_layre/editbtn_tbl_area_b_demolitions/{id}' , [kn1::class,'editbtn_tbl_area_b_demolitions'])->middleware('auth');
Route::post('/switch_layre/switch_layre/update_tbl_area_b_demolitions' , [kn1::class,'update_tbl_area_b_demolitions']);
Route::get('/switch_layre/switch_layre/deletebtn_tbl_area_b_demolitions/{id}' , [kn1::class,'deletebtn_tbl_area_b_demolitions'])->middleware('auth');
   
Route::post('/switch_layre/switch_layre/insert_tbl_area_b_nature_reserve' , [kn1::class,'insert_tbl_area_b_nature_reserve']);
Route::get('/switch_layre/switch_layre/editbtn_tbl_area_b_nature_reserve/{id}' , [kn1::class,'editbtn_tbl_area_b_nature_reserve'])->middleware('auth');
Route::post('/switch_layre/switch_layre/update_tbl_area_b_nature_reserve' , [kn1::class,'update_tbl_area_b_nature_reserve'])->middleware('auth');
Route::get('/switch_layre/switch_layre/deletebtn_tbl_area_b_nature_reserve/{id}' , [kn1::class,'deletebtn_tbl_area_b_nature_reserve'])->middleware('auth');
Route::get('/switch_layre/switch_layre/zoombtn_tbl_area_b_nature_reserve/{id}' , [kn1::class,'zoombtn_tbl_area_b_nature_reserve'])->middleware('auth');

Route::post('/switch_layre/switch_layre/insert_tbl_area_a_and_b_combined' , [kn1::class,'insert_tbl_area_a_and_b_combined']);
Route::get('/switch_layre/switch_layre/editbtn_tbl_area_a_and_b_combined/{id}' , [kn1::class,'editbtn_tbl_area_a_and_b_combined'])->middleware('auth');
Route::post('/switch_layre/switch_layre/update_tbl_area_a_and_b_combined' , [kn1::class,'update_tbl_area_a_and_b_combined'])->middleware('auth');
Route::get('/switch_layre/switch_layre/deletebtn_tbl_area_a_and_b_combined/{id}' , [kn1::class,'deletebtn_tbl_area_a_and_b_combined'])->middleware('auth');
Route::get('/switch_layre/switch_layre/zoombtn_tbl_area_a_and_b_combined/{id}' , [kn1::class,'zoombtn_tbl_area_a_and_b_combined'])->middleware('auth');

Route::post('/switch_layre/switch_layre/insert_tbl_area_a_area_b_naturereserve' , [kn1::class,'insert_tbl_area_a_area_b_naturereserve']);
Route::get('/switch_layre/switch_layre/editbtn_tbl_area_a_area_b_naturereserve/{id}' , [kn1::class,'editbtn_tbl_area_a_area_b_naturereserve'])->middleware('auth');
Route::post('/switch_layre/switch_layre/update_tbl_area_a_area_b_naturereserve' , [kn1::class,'update_tbl_area_a_area_b_naturereserve'])->middleware('auth');
Route::get('/switch_layre/switch_layre/deletebtn_tbl_area_a_area_b_naturereserve/{id}' , [kn1::class,'deletebtn_tbl_area_a_area_b_naturereserve'])->middleware('auth');
Route::get('/switch_layre/switch_layre/zoombtn_tbl_area_a_area_b_naturereserve/{id}' , [kn1::class,'zoombtn_tbl_area_a_area_b_naturereserve'])->middleware('auth');

Route::post('/switch_layre/switch_layre/insert_tbl_area_a_poly' , [kn1::class,'insert_tbl_area_a_poly']);
Route::get('/switch_layre/switch_layre/editbtn_tbl_area_a_poly/{id}' , [kn1::class,'editbtn_tbl_area_a_poly'])->middleware('auth');
Route::post('/switch_layre/switch_layre/update_tbl_area_a_poly' , [kn1::class,'update_tbl_area_a_poly'])->middleware('auth');
Route::get('/switch_layre/switch_layre/deletebtn_tbl_area_a_poly/{id}' , [kn1::class,'deletebtn_tbl_area_a_poly'])->middleware('auth');
Route::get('/switch_layre/switch_layre/zoombtn_tbl_area_a_poly/{id}' , [kn1::class,'zoombtn_tbl_area_a_poly'])->middleware('auth');

Route::post('/switch_layre/switch_layre/insert_tbl_area_b_poly' , [kn1::class,'insert_tbl_area_b_poly']);
Route::get('/switch_layre/switch_layre/editbtn_tbl_area_b_poly/{id}' , [kn1::class,'editbtn_tbl_area_b_poly'])->middleware('auth');
Route::post('/switch_layre/switch_layre/update_tbl_area_b_poly' , [kn1::class,'update_tbl_area_b_poly'])->middleware('auth');
Route::get('/switch_layre/switch_layre/deletebtn_tbl_area_b_poly/{id}' , [kn1::class,'deletebtn_tbl_area_b_poly'])->middleware('auth');
Route::get('/switch_layre/switch_layre/zoombtn_tbl_area_b_poly/{id}' , [kn1::class,'zoombtn_tbl_area_b_poly'])->middleware('auth');
Route::get('/switch_layre/switch_layre/pageno_tbl_area_b_poly/{id}' , [kn1::class,'pageno_tbl_area_b_poly']);

Route::post('/switch_layre/switch_layre/insert_tbl_area_b_training' , [kn1::class,'insert_tbl_area_b_training']);
Route::get('/switch_layre/switch_layre/editbtn_tbl_area_b_training/{id}' , [kn1::class,'editbtn_tbl_area_b_training'])->middleware('auth');
Route::post('/switch_layre/switch_layre/update_tbl_area_b_training' , [kn1::class,'update_tbl_area_b_training'])->middleware('auth');
Route::get('/switch_layre/switch_layre/deletebtn_tbl_area_b_training/{id}' , [kn1::class,'deletebtn_tbl_area_b_training'])->middleware('auth');

Route::post('/switch_layre/switch_layre/insert_tbl_demolition_orders' , [kn1::class,'insert_tbl_demolition_orders']);
Route::get('/switch_layre/switch_layre/editbtn_tbl_demolition_orders/{id}' , [kn1::class,'editbtn_tbl_demolition_orders'])->middleware('auth');
Route::post('/switch_layre/switch_layre/update_tbl_demolition_orders' , [kn1::class,'update_tbl_demolition_orders'])->middleware('auth');
Route::get('/switch_layre/switch_layre/deletebtn_tbl_demolition_orders/{id}' , [kn1::class,'deletebtn_tbl_demolition_orders'])->middleware('auth');


Route::post('/switch_layre/switch_layre/insert_tbl_expropriation_orders' , [kn1::class,'insert_tbl_expropriation_orders']);
Route::get('/switch_layre/switch_layre/editbtn_tbl_expropriation_orders/{id}' , [kn1::class,'editbtn_tbl_expropriation_orders'])->middleware('auth');
Route::post('/switch_layre/switch_layre/update_tbl_expropriation_orders' , [kn1::class,'update_tbl_expropriation_orders'])->middleware('auth');
Route::get('/switch_layre/switch_layre/deletebtn_tbl_expropriation_orders/{id}' , [kn1::class,'deletebtn_tbl_expropriation_orders'])->middleware('auth');
Route::get('/switch_layre/switch_layre/zoombtn_tbl_expropriation_orders/{id}' , [kn1::class,'zoombtn_tbl_expropriation_orders'])->middleware('auth');

Route::post('/switch_layre/switch_layre/insert_tbl_expropriation_orders_ab' , [kn1::class,'insert_tbl_expropriation_orders_ab']);
Route::get('/switch_layre/switch_layre/editbtn_tbl_expropriation_orders_ab/{id}' , [kn1::class,'editbtn_tbl_expropriation_orders_ab'])->middleware('auth');
Route::post('/switch_layre/switch_layre/update_tbl_expropriation_orders_ab' , [kn1::class,'update_tbl_expropriation_orders_ab'])->middleware('auth');
Route::get('/switch_layre/switch_layre/deletebtn_tbl_expropriation_orders_ab/{id}' , [kn1::class,'deletebtn_tbl_expropriation_orders_ab'])->middleware('auth');
Route::get('/switch_layre/switch_layre/zoombtn_tbl_expropriation_orders_ab/{id}' , [kn1::class,'zoombtn_tbl_expropriation_orders_ab'])->middleware('auth');

Route::post('/switch_layre/switch_layre/insert_tbl_expropriation_orders_not_ab' , [kn1::class,'insert_tbl_expropriation_orders_not_ab']);
Route::get('/switch_layre/switch_layre/editbtn_tbl_expropriation_orders_not_ab/{id}' , [kn1::class,'editbtn_tbl_expropriation_orders_not_ab'])->middleware('auth');
Route::post('/switch_layre/switch_layre/update_tbl_expropriation_orders_not_ab' , [kn1::class,'update_tbl_expropriation_orders_not_ab'])->middleware('auth');
Route::get('/switch_layre/switch_layre/deletebtn_tbl_expropriation_orders_not_ab/{id}' , [kn1::class,'deletebtn_tbl_expropriation_orders_not_ab'])->middleware('auth');
Route::get('/switch_layre/switch_layre/zoombtn_tbl_expropriation_orders_not_ab/{id}' , [kn1::class,'zoombtn_tbl_expropriation_orders_not_ab'])->middleware('auth');

Route::post('/switch_layre/switch_layre/insert_tbl_security_orders' , [kn1::class,'insert_tbl_security_orders']);
Route::get('/switch_layre/switch_layre/editbtn_tbl_security_orders/{id}' , [kn1::class,'editbtn_tbl_security_orders'])->middleware('auth');
Route::post('/switch_layre/switch_layre/update_tbl_security_orders' , [kn1::class,'update_tbl_security_orders'])->middleware('auth');
Route::get('/switch_layre/switch_layre/deletebtn_tbl_security_orders/{id}' , [kn1::class,'deletebtn_tbl_security_orders'])->middleware('auth');

Route::post('/switch_layre/switch_layre/insert_tbl_seizure_ab' , [kn1::class,'insert_tbl_seizure_ab']);
Route::get('/switch_layre/switch_layre/editbtn_tbl_seizure_ab/{id}' , [kn1::class,'editbtn_tbl_seizure_ab'])->middleware('auth');
Route::post('/switch_layre/switch_layre/update_tbl_seizure_ab' , [kn1::class,'update_tbl_seizure_ab'])->middleware('auth');
Route::get('/switch_layre/switch_layre/deletebtn_tbl_seizure_ab/{id}' , [kn1::class,'deletebtn_tbl_seizure_ab'])->middleware('auth');
Route::get('/switch_layre/switch_layre/zoombtn_tbl_seizure_ab/{id}' , [kn1::class,'zoombtn_tbl_seizure_ab'])->middleware('auth');

Route::post('/switch_layre/switch_layre/insert_tbl_seizure_all' , [kn1::class,'insert_tbl_seizure_all']);
Route::get('/switch_layre/switch_layre/editbtn_tbl_seizure_all/{id}' , [kn1::class,'editbtn_tbl_seizure_all'])->middleware('auth');
Route::post('/switch_layre/switch_layre/update_tbl_seizure_all' , [kn1::class,'update_tbl_seizure_all'])->middleware('auth');
Route::get('/switch_layre/switch_layre/deletebtn_tbl_seizure_all/{id}' , [kn1::class,'deletebtn_tbl_seizure_all'])->middleware('auth');
Route::get('/switch_layre/switch_layre/zoombtn_tbl_seizure_all/{id}' , [kn1::class,'zoombtn_tbl_seizure_all'])->middleware('auth');
Route::get('/switch_layre/switch_layre/pageno_tbl_seizure_all/{id}' , [kn1::class,'pageno_tbl_seizure_all'])->middleware('auth');

Route::post('/switch_layre/switch_layre/insert_tbl_settlements' , [kn1::class,'insert_tbl_settlements']);
Route::get('/switch_layre/switch_layre/editbtn_tbl_settlements/{id}' , [kn1::class,'editbtn_tbl_settlements'])->middleware('auth');
Route::post('/switch_layre/switch_layre/update_tbl_settlements' , [kn1::class,'update_tbl_settlements'])->middleware('auth');
Route::get('/switch_layre/switch_layre/deletebtn_tbl_settlements/{id}' , [kn1::class,'deletebtn_tbl_settlements'])->middleware('auth');
Route::get('/switch_layre/switch_layre/zoombtn_tbl_settlements/{id}' , [kn1::class,'zoombtn_tbl_settlements'])->middleware('auth');

Route::post('/switch_layre/switch_layre/insert_tbl_area_b_violations' , [kn1::class,'insert_tbl_area_b_violations']);
Route::get('/switch_layre/switch_layre/editbtn_tbl_area_b_violations/{id}' , [kn1::class,'editbtn_tbl_area_b_violations'])->middleware('auth');
Route::post('/switch_layre/switch_layre/update_tbl_area_b_violations' , [kn1::class,'update_tbl_area_b_violations'])->middleware('auth');
Route::get('/switch_layre/switch_layre/deletebtn_tbl_area_b_violations/{id}' , [kn1::class,'deletebtn_tbl_area_b_violations'])->middleware('auth');
// Route::get('/switch_layre/switch_layre/pageno_tbl_area_b_violations/{id}' , [kn1::class,'pageno_tbl_area_b_violations'])->middleware('auth');


// // ------------Upload Shape File rooute----------------
Route::match(['get','post'], '/shaperead', [kn1::class, 'shaperead']);






// Route::get('/switch_layre/switch_layre/savedata/{data}' , [kn1::class,'savedata'])->middleware('auth');

// Route::match(['get','post'], '/kn1', [kn1::class, 'index'])->name('kn1')->middleware('kn1');
// // ------------kn2 rooutes----------------
// Route::match(['get','post'], '/kn2', [kn2::class, 'index'])->name('kn2')->middleware('kn2');
// // ------------superadmin rooutes----------------
// Route::match(['get','post'], '/superadmin', [superadmin::class, 'index'])->name('superadmin')->middleware('superadmin');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');
