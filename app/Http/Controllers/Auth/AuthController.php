<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Validator;
use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Requests\UrlParser;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

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
            return redirect(str_replace($company->first()->subdomain . '.', '', url('')));
        }

        return view('auth.login');
    }

    /**
     * Handle an authentication attempt.
     *
     * @param Request $request
     * @return mixed
     */
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'active' => 1], (isset($request->remember) ? true : false))) {
            return redirect()->intended('/');
        }

        return redirect()->back()->with('error', 'Email or password is incorrect')->withInput(['email' => $request->get('email')]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * Log the user out
     *
     * @return mixed
     */
    public function logout()
    {
        Auth::logout();

        return redirect()->action('Auth\AuthController@showLoginForm');
    }
}
