<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Validator;

class UserController extends Controller
{
	/**
	 * @var Int|null
	 */
	private $environment_id = null;

	/**
	 * Set the environment variable so we know only to get the users based on the current environment
	 *
	 * @param Request $request
	 */
	public function __construct(Request $request)
	{
		$this->environment_id = $request->environment_id ?? null;
	}

	/**
	 * Show the index
	 * Only get the users based on the given environment_id or the current environment
	 *
	 * @return Response
	 */
	public function index()
	{
		$environment_id = $this->environment_id ?? get_environment()->id;
		$users = User::where('environment_id', '=', $environment_id)->get();

		return view('pages.users.index', [
			'users' => $users,
			'environment_id' => $this->environment_id
		]);
	}

	/**
	 * Show the edit form
	 *
	 * @param  Int $user_id
	 * @return Response
	 */
	public function edit($user_id)
	{
		$user = User::find($user_id);

		return view('pages.users.edit', compact('user'));
	}

	/**
	 * Update the user information
	 *
	 * @param  Request $request
	 * @param  Int $user_id
	 * @return Response
	 */
	public function update(Request $request, $user_id)
	{
		$validator = $this->validator($request->all());
		if ($validator->fails()) {
			return redirect()->back()->with('errors', $validator->errors()->all())->withInput();
		}

		$user = User::find($user_id);
		$user->fill($request->all());

		if ($request->get('password')) {
			$user->password = bcrypt($request->get('password'));
		}

		$user->save();

		return redirect()->back()->with('success', 'Successfully updated');
	}

	/**
	 * Show the create form
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('pages.users.create');
	}

	/**
	 * Create a new user
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request)
	{
		$validator = $this->validator($request->all());
		if ($validator->fails()) {
			return redirect()->back()->with('errors', $validator->errors()->all())->withInput();
		}

		$user = new User;
		$user->fill($request->all());
		$user->environment_id = $this->environment_id ?? get_environment()->id;
		$user->password = bcrypt($request->get('password'));

		$user->save();

		return redirect('users/' . $user->id . '/edit')->with('success', 'Successfully created');
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
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'min:6',
        ]);
	}

	/**
	 * Login using the $user_id
	 *
	 * @param  Int $environment_id
	 * @param  Int $user_id
	 * @return Response
	 */
	public function loginUsingId($environment_id, $user_id)
	{
		Auth::loginUsingId((int) $user_id);
		return redirect('/');
	}

}
