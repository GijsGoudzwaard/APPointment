<?php

namespace App\Http\Controllers;

use App\Models\Environment;

class EnvironmentController extends Controller {

	/**
	 * Show the index
	 *
	 * @return Mixed
	 */
	public function index () {
		dd(get_environment());
		$environments = Environment::all();

	    return view('pages.environment.index', [
			'environments' => $environments
		]);
	}

}
