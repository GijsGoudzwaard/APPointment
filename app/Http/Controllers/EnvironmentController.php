<?php

namespace App\Http\Controllers;

use App\Models\Environment;
use Illuminate\Http\Request;

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
		$environment = Environment::find($environment_id);
		$environment->fill($request->all());
		$environment->save();

		return redirect('environments');
	}

}
