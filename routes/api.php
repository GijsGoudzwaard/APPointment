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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::group(['middleware' => 'cors'], function () {
    Route::post('customer/new', 'CustomerController@store');
    Route::post('customer/login', 'CustomerController@login');

    Route::post('appointment', 'AppointmentController@book');
    Route::get('appointments/check', 'AppointmentController@check');
    Route::get('appointments/booked', 'AppointmentController@booked');
    Route::get('appointments/timeblocks', 'AppointmentController@timeblocks');

    Route::get('appointmenttypes/get', 'AppointmentTypeController@get');
    Route::get('employees/get', 'Auth\UserController@getEmployee');
});