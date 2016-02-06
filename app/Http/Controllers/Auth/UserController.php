<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class UserController extends Controller
{
	/**
	 * @param App\Models\Environment|null
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

		$user = User::find($user_id);
		$user->fill($request->all());

		if ($request->get('password')) {
			$user->password = bcrypt($request->get('password'));
		}

		$user->save();

		return redirect('users');
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
