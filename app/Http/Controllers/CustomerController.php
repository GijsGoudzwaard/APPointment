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

        $company = Company::where('subdomain', UrlParser::getSubdomain())->select('id')->first();

        $user = new User;
        $user->fill($request->all());
        $user->role = User::role('customer');
        $user->company_id = $company->id;
        $user->save();

        return [
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
        if (! \Auth::validate($request->all())) {
            return 'Invalid user credentials';
        }

        // Only check by email, since it is a unique field
        return User::where('email', $request->get('email'))->select([
            'firstname',
            'surname',
            'phonenumber',
            'email'
        ])->first();
    }

    /**
     * Create a new Validor instance
     *
     * @param  Request $request
     * @return Validator
     */
    public function validator($request)
    {
        return Validator::make($request, [
            'firstname' => 'required|max:255',
            'surname' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'phonenumber' => 'required|max:255',
            'password' => 'min:6',
        ]);
    }
}
