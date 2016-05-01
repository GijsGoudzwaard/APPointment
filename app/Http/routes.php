<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => 'web'], function () {

	Route::get('login', 'Auth\AuthController@showForm');
	Route::post('login', 'Auth\AuthController@authenticate');

});

Route::group(['middleware' => ['web', 'auth', 'subdomain']], function () {

    Route::get('/', 'PageController@dashboard');

	// This middleware is to prevent people from getting into the restricted area's
	Route::group(['middleware' => 'admin'], function() {
	    Route::resource('companies', 'CompanyController');
	    Route::resource('companies/{company_id}/users', 'Auth\UserController', ['except' => [
			'show'
		]]);
		Route::get('companies/{company_id}/users/{user_id}', 'Auth\UserController@loginUsingId');
	});

	// Appointments
	Route::resource('appointments', 'AppointmentController', ['except' => ['show']]);
	Route::get('appointments/get', 'AppointmentController@get');
	Route::resource('appointmenttypes', 'AppointmentTypeController');

	// Users
	Route::resource('users', 'Auth\UserController');

	Route::resource('staff', 'StaffController');

	Route::resource('company', 'CompanyController', ['only' => [
		'index', 'update'
	]]);

	Route::get('logout', 'Auth\Authcontroller@logout');

});
