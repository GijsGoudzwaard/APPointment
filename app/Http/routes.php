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

Route::group(['middleware' => ['web']], function () {
	Route::auth();
});

Route::group(['middleware' => ['web', 'auth', 'subdomain']], function () {

    Route::get('api/appointments', 'AppointmentController@getStats');
    Route::get('api/appointmenttypes', 'AppointmentTypeController@getStats');

    Route::get('/', ['as' => 'dashboard', 'uses' => 'PageController@dashboard']);

	// This middleware is to prevent people from getting into the restricted area's
	Route::group(['middleware' => ['admin']], function() {
	    Route::resource('companies', 'CompanyController');

	    Route::resource('companies/{company_id}/users', 'Auth\UserController', ['except' => [
			'show'
		]]);

		Route::get('companies/{company_id}/users/{user_id}', 'Auth\UserController@loginUsingId');
	});

	// Appointments
	Route::resource('appointments', 'AppointmentController', ['except' => ['show']]);
	Route::get('appointments/get', 'AppointmentController@get');

	// Appointment types
	Route::resource('appointmenttypes', 'AppointmentTypeController');

	// Users
	Route::resource('users', 'Auth\UserController');

	Route::resource('customers', 'CustomerController', ['only' => ['index', 'show']]);

	Route::resource('company', 'CompanyController', ['only' => [
		'index', 'update'
	]]);

});

Route::group(['middleware' => ['web']], function () {
	Route::get('login', ['as' => 'auth.login', 'uses' => 'Auth\AuthController@showLoginForm']);
	Route::post('login', ['as' => 'auth.login', 'uses' => 'Auth\AuthController@login']);
	Route::get('logout', ['as' => 'auth.logout', 'uses' => 'Auth\AuthController@logout']);

	// Registration Routes...
	Route::get('register', ['as' => 'auth.register', 'uses' => 'Auth\AuthController@showRegistrationForm']);
	Route::post('register', ['as' => 'auth.register', 'uses' => 'Auth\AuthController@register']);

	// Password Reset Routes...
	Route::get('password/reset/{token?}', ['as' => 'auth.password.reset', 'uses' => 'Auth\PasswordController@showResetForm']);
	Route::post('password/email', ['as' => 'auth.password.email', 'uses' => 'Auth\PasswordController@sendResetLinkEmail']);
	Route::post('password/reset', ['as' => 'auth.password.reset', 'uses' => 'Auth\PasswordController@reset']);
});