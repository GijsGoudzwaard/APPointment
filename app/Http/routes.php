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

Route::group(['middleware' => 'web'], function() {

	Route::get('/login', 'Auth\AuthController@showForm');
	Route::post('/login', 'Auth\AuthController@authenticate');

});


Route::group(['middleware' => ['subdomain', 'web', 'auth']], function() {

    Route::get('/', 'PageController@dashboard');
    Route::get('/info', 'PageController@info');

    // Environment
    Route::resource('/environments', 'EnvironmentController');

});
