<?php

namespace App\Jobs;

use App\Http\Controllers\Controller;

abstract class Verify extends Controller
{
	/**
	 * Verify if the given request is valid according to the validator
	 *
	 * @param  array $request
	 * @param  mixed $rules
	 * @return mixed
	 */
	public function verify($request, $rules = null)
	{
		$validator = $this->validator($request, $rules);

		if ($validator->fails()) {
			return redirect()->back()->with('errors', $validator->errors()->all())->withInput();
		}
	}

	abstract function validator($request, $rules);
}
