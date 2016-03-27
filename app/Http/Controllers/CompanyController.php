<?php

namespace App\Http\Controllers;

use App\Http\File;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
	/**
	 * Show the App\Models\Company based on the current environment
	 *
	 * @return mixed
	 */
	public function index()
	{
		$company = get_environment()->company;

		return view('pages.company.index', compact('company'));
	}

	/**
	 * Update a App\Models\Company by its $id
	 *
	 * @param  Request $request
	 * @param  Int $company_id
	 * @return mixed
	 */
	public function update(Request $request, $company_id)
	{
		$company = Company::find($company_id);
		$opening_hours = [];

		foreach ($request->get('from') as $key => $from) {
			$opening_hours[$key] = [
				'from' => $from,
				'to' => $request->get('to')[$key]
			];
		}

		$company->fill($request->all());
		$company->opening_hours = json_encode($opening_hours);
		$company->environment_id = get_environment()->id;

		if ($request->hasFile('logo')) {
			$path = File::upload($request, 'logo');
			if (is_array($path)) {
				return redirect()->back()->with('errors', $path)->withInput();
			}

			$company->logo = $path ?? $company->logo;
		}

		$company->save();

		return redirect('company')->with('success', 'Successfully updated');
	}
}
