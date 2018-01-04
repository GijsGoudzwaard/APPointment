<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Requests\UrlParser;

class CustomerController extends Controller
{
    /**
     * Show the index
     *
     * @return mixed
     */
    public function index()
    {
        $users = get_company()->users(true);

        return view('pages.customers.index', compact('users'));
    }

    /**
     * Store a new customer
     * This method is only accessed through the api
     *
     * @param  Request $request
     * @return array
     */
    public function store(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return $validator->errors()->all();
        }

        $company = get_company()->id;
        $user = new User;
        $user->fill($request->all());
        $user->password = bcrypt($request->get('password'));
        $user->role = User::role('customer');
        $user->company_id = $company;
        $user->save();

        return [
            'id' => $user->id,
            'firstname' => $user->firstname,
            'surname' => $user->surname,
            'email' => $user->email,
            'phonenumber' => $user->phonenumber
        ];
    }

    /**
     * See if the credentials are correct
     * Send back the user if it is
     *
     * @param  Request $request
     * @return string|User
     */
    public function login(Request $request)
    {
        if (!\Auth::validate(array_merge($request->all(), ['company_id' => get_company()->id])) && $request->get('email') != env('ADMIN_EMAIL')) {
            return 'Invalid user credentials';
        }

        // Only check by email, since it is a unique field
        return User::where('email', $request->get('email'))->select([
            'id',
            'firstname',
            'surname',
            'phonenumber',
            'email'
        ])->first();
    }

    /**
     * Check if a user exists using the email and user id from either google or facebook as password.
     * Create a new user if we can't find one.
     *
     * @param  Request $request
     * @return User|array
     */
    public function socialLogin(Request $request)
    {
        // See if we can find a user.
        $user = $this->login($request);

        // We couldn't fetch the user.
        if (gettype($user) === 'string' || !$user) {
            // Create one.
            $user = $this->store($request);
        }

        // We have a user, return it.
        return $user;
    }

    /**
     * Create a new Validor instance
     *
     * @param  Request $request
     * @return \Illuminate\Validation\Validator
     */
    public function validator($request)
    {
        return Validator::make($request, [
            'firstname' => 'required|max:255',
            'surname' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'phonenumber' => 'max:255',
            'password' => 'min:6',
        ]);
    }
}
