<?php

namespace App\Http\Controllers\Auth;

use App\Models\AppointmentType;
use Auth;
use Validator;
use App\Http\File;
use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * @var int|null
     */
    private $company_id = null;

    /**
     * Set the company variable so we know only to get the users based on the current company
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->company_id = $request->company_id ?? null;
    }

    /**
     * Show the index
     * Only get the users based on the given company_id or by the company of the logged in user
     *
     * @return mixed
     */
    public function index()
    {
        $company_id = $this->company_id ?? get_company()->id;
        $company = $this->company_id ? Company::with('users')->find($company_id) : get_company()->load('users');

        $users = $company->users->where('role', User::role('employee'));

        return view('pages.users.index', compact('users', 'company', 'company_id'));
    }

    /**
     * Show the edit form
     *
     * @param  int $user_id
     * @return mixed
     */
    public function edit($user_id)
    {
        $user = User::find($user_id);

        return view('pages.users.edit', compact('user', 'company_id'));
    }

    /**
     * Update the user information
     *
     * @param  Request $request
     * @param  int     $user_id
     * @return mixed
     */
    public function update(Request $request, $user_id)
    {
        $user = User::find($user_id);
        $validator = $this->validator($request->all(), $user);

        if ($validator->fails()) {
            return redirect()->back()->with('errors', $validator->errors()->all())->withInput();
        }

        $user->fill($request->all());

        if ($request->get('password')) {
            $user->password = bcrypt($request->get('password'));
        }

        if ($request->hasFile('avatar')) {
            $path = File::upload($request, 'avatar');

            if (is_array($path)) {
                return redirect()->back()->with('errors', $path)->withInput();
            }

            $user->avatar = $path ?? $user->avatar;
        }

        $user->save();

        return redirect()->back()->with('success', 'Successfully updated');
    }

    /**
     * Show the create form
     *
     * @return mixed
     */
    public function create()
    {
        return view('pages.users.create', [
            'company_id' => $this->company_id ?? ''
        ]);
    }

    /**
     * Create a new user
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return redirect()->back()->with('errors', $validator->errors()->all())->withInput();
        }

        $user = new User;
        $user->fill($request->all());
        $user->company_id = $request->get('company_id') ?: get_company()->id;
        $user->password = bcrypt($request->get('password'));
        $user->role = $user::role('employee');
        $user->active = 1;

        $user->save();

        return redirect('users/' . $user->id . '/edit')->with('success', 'Successfully created');
    }

    /**
     * Delete a user
     *
     * @param  int $id
     * @return mixed
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect()->back()->with('success', 'Successfully deleted');
    }

    /**
     * Create a new Validor instance
     *
     * @param  Request   $request
     * @param  User|null $user
     * @return Validator
     */
    public function validator($request, $user = null)
    {
        return Validator::make($request, [
            'firstname' => 'required|max:255',
            'surname' => 'required|max:255',
            'email' => 'required|email|max:255' . (isset($user) && $user->email == $request['email'] ? '' : '|unique:users'),
            'phonenumber' => 'required|max:255',
            'password' => 'min:6',
        ]);
    }

    /**
     * Login using the $user_id
     *
     * @param  int $company_id
     * @param  int $user_id
     * @return mixed
     */
    public function loginUsingId($company_id, $user_id)
    {
        Auth::loginUsingId($user_id);

        return redirect()->route('dashboard');
    }

    /**
     * Get the employees based on the appointment type id
     *
     * @param  Request $request
     * @return mixed
     */
    public function getEmployee(Request $request)
    {
        $appointment_type = AppointmentType::find($request->get('appointment_type'));
        $users = $appointment_type->users()->select(['id', 'firstname', 'surname'])->get();

        return $users->pluck('attributes');
    }
}
