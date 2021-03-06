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

Route::auth();

Route::group(['middleware' => ['auth', 'lang', 'subdomain']], function () {

    Route::group(['prefix' => 'api'], function () {
        Route::get('income', 'AppointmentController@income');
        Route::get('appointments', 'AppointmentController@getStats');
        Route::get('appointmenttypes', 'AppointmentTypeController@getStats');
    });

    Route::get('/', ['as' => 'dashboard', 'uses' => 'PageController@dashboard']);

    // This middleware is to prevent people from getting into the restricted area's
    Route::group(['middleware' => ['admin']], function () {
        Route::resource('companies', 'CompanyController');

        Route::resource('companies/{company_id}/users', 'Auth\UserController', ['except' => [
            'show'
        ], 'names' => [
            'index' => 'companies.users.index',
            'create' => 'companies.users.create',
            'store' => 'companies.users.store',
            'edit' => 'companies.users.edit',
            'update' => 'companies.users.update'
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

    Route::get('language/set/{locale}', ['as' => 'setlanguage', 'uses' => '\App\Http\Language@set']);
});

Route::group(['middleware' => ['web']], function () {
    Route::get('login', ['as' => 'auth.login', 'uses' => 'Auth\LoginController@showLoginForm']);
    Route::post('login', ['as' => 'auth.login', 'uses' => 'Auth\LoginController@login']);
    Route::get('logout', ['as' => 'auth.logout', 'uses' => 'Auth\LoginController@logout']);

    // Registration Routes...
    Route::get('register', ['as' => 'auth.register', 'uses' => 'Auth\RegisterController@showRegistrationForm']);
    Route::post('register', ['as' => 'auth.register', 'uses' => 'Auth\RegisterController@register']);

    // Password Reset Routes...
    Route::get('password/reset', ['as' => 'auth.password.reset', 'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm']);
    Route::post('password/reset/{token?}', ['as' => 'auth.password.reset', 'uses' => 'Auth\ResetPasswordController@showResetForm']);
    Route::post('password/email', ['as' => 'auth.password.email', 'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail']);
    Route::post('password/reset', ['as' => 'auth.password.reset', 'uses' => 'Auth\ResetPasswordController@reset']);
});

//Route::get('/', function () {
//    return 'home';
//});
