<?php

namespace App\Http\Controllers;

use App\Models\Environment;
use Illuminate\Http\Request;
use Validator;

class EnvironmentController extends Controller
{

	/**
	 * Show the index
	 *
	 * @return Response
	 */
	public function index()
	{
		$environments = Environment::all();

	    return view('pages.environment.index', [
			'environments' => $environments
		]);
	}

	/**
	 * Show the edit form
	 *
	 * @param  Int $environment_id
	 * @return Response
	 */
	public function edit($environment_id)
	{
		$environment = Environment::find($environment_id);

		return view('pages.environment.edit', [
			'environment' => $environment
		]);
	}

	/**
	 * Update the environment based on the $environment_id
	 *
	 * @param  Request $request
	 * @param  Int $environment_id
	 * @return Response
	 */
	public function update(Request $request, $environment_id)
	{
		$validator = $this->validator($request->all());
		if ($validator->fails()) {
			return redirect()->back()->with('errors', $validator->errors()->all())->withInput();
		}

		$environment = Environment::find($environment_id);
		$environment->fill($request->all());
		$environment->save();

		return redirect('environments');
	}

	/**
	 * Show the create form
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('pages.environment.create');
	}

	/**
	 * Create a new environment
	 *
	 * @param  Request $request
	 * @return Response
	 */
	public function store(Request $request)
	{
		$validator = $this->validator($request->all());
		if ($validator->fails()) {
			return redirect()->back()->with('errors', $validator->errors()->all())->withInput();
		}

		$environment = new Environment;
		$environment->fill($request->all());
		$environment->save();

		return redirect('environments/' . $environment->id . '/edit')->with('success', 'Successfully created');
	}

	/**
	 * Create a new Validor instance
	 *
	 * @param  Request $request
	 * @param  User|null $user
	 * @return Validator
	 */
	public function validator($request)
	{
		return Validator::make($request, [
            'name' => 'required|max:255',
            'subdomain' => 'required|unique:environments|max:255'
        ]);
	}

}
