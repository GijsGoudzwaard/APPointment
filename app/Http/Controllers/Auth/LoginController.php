<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UrlParser;
use App\Models\Company;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Show the login form
     * If we are already on a subdomain, redirect to the host
     *
     * @return mixed
     */
    public function showLoginForm()
    {
        $url = UrlParser::getSubdomain();
        $company = Company::where('subdomain', $url)->get();

        if ($url !== false && ! $company->isEmpty()) {
            $pieces = explode('.', url(''));

            unset($pieces[0]);

            return redirect(get_protocol() . implode('.', $pieces));
        }

        return view('auth.login');
    }
}
