<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', 'AuthController@login');
Route::post('register', 'AuthController@register');
Route::get('testopen', 'TestController@open');
Route::post('staffregister', 'StaffAuthController@register');
Route::post('stafflogin', 'StaffAuthController@login');
Route::get('paypal', 'BookedController@paypal');
Route::get('showcar', 'CarController@showCar');
Route::get('showmotorcycle', 'CarController@showMotorcycle');
Route::get('carbookhistory/{id}', 'BookedController@showCarBookHistory');
Route::get('motorcyclebookhistory/{id}', 'BookedController@showMotorcycleBookHistory');
Route::get('carreturnhistory/{id}', 'ReturnCarController@showCarReturnHistory');
Route::get('motorcyclereturnhistory/{id}', 'ReturnCarController@showMotorcycleReturnHistory');


Route::apiResources([
	'users' => 'UserController',
    'cars' => 'CarController',
    'books' => 'BookedController',
    'returncars' => 'ReturnCarController',
]);

Route::group(['middleware' => ['jwt.auth']], function() {
    Route::post('logout', 'AuthController@logout');
    Route::get('testclosed', 'TestController@closed');
	Route::get('refreshtoken', 'AuthController@refreshtoken');	
});

Route::group([ 'prefix' => 'staff', 'middleware' =>['jwt.auth']], function(){
	Route::get('teststaff', 'TestController@staff');
	Route::post('stafflogout', 'StaffAuthController@logout');
});