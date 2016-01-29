<?php

namespace App\Http\Controllers;

use App\Models\Environment;
use Illuminate\Http\Request;

class EnvironmentController extends Controller
{

	/**
	 * Show the index
	 *
	 * @return Mixed
	 */
	public function index ()
	{
		$environments = Environment::all();

	    return view('pages.environment.index', [
			'environments' => $environments
		]);
	}

	public function edit ($id)
	{
		$environment = Environment::find($id);

		return view('pages.environment.edit', [
			'environment' => $environment
		]);
	}

	public function update (Request $request, $id)
	{
		$environment = Environment::find($id);
		$environment->fill($request->all());
		$environment->save();

		return redirect('environments');
	}

}
