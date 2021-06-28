<?php 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route; 
use App\Controller\Register;
date_default_timezone_set('America/Chicago');
 


/* Register */
Route::post('register', 'App\Http\Controllers\Register@index'); 

/* Google API */
Route::post('googleapi', 'App\Http\Controllers\GoogleAPI@index');

/* Purchase */
Route::post('purchase', 'App\Http\Controllers\Purchase@index');

/* Check Subscription */
Route::post('checksubscription', 'App\Http\Controllers\CheckSubscription@index');

/* Worker and Cron File */
Route::get('worker', 'App\Http\Controllers\Worker@index');
 
/* Report */
Route::get('report', 'App\Http\Controllers\Report@index');


Route::get('/{all}', function () {
    return view('welcome');
});