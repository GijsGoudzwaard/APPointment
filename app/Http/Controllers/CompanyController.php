<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CompanyController extends Controller
{
	/**
	 * Show the App\Models\Company based on the current environment
	 *
	 * @return Response
	 */
	public function index()
	{
		$company = get_environment()->company;

		return view('pages.company.index', compact('company'));
	}

	/**
	 * Create a new App\Models\Company
	 *
	 * @param  Request $request
	 * @return Response
	 */
	public function store(Request $request)
	{
		$company = new Company;

		$company->fill($request->all());
		$company->environment_id = get_environment()->id;

		if ($request->hasFile('logo')) {
			$company->logo = $this->upload($request, 'logo') ?? $company->logo;
		}

		$company->save();

		return redirect('company');
	}

	/**
	 * Update a App\Models\Company by its $id
	 *
	 * @param  Request $request
	 * @param  Int $company_id
	 * @return Response
	 */
	public function update(Request $request, $company_id)
	{
		$company = Company::find($company_id);

		$company->fill($request->all());
		$company->environment_id = get_environment()->id;

		if ($request->hasFile('logo')) {
			$company->logo = $this->upload($request, 'logo') ?? $company->logo;
		}

		$company->save();

		return redirect('company')->with('message', 'Successfully stored');
	}

	/**
	 * Upload a file
	 *
	 * @param  Request $request
	 * @param  String $name
	 * @return String|null
	 */
	public function upload($request, $name)
	{
		$logo = $request->file($name);

		if ($logo->isValid()) {
			$filename = $logo->getClientOriginalName() . '.' . $logo->getClientOriginalExtension();
			$url = 'uploads/' . Carbon::now()->format('m-d') . '/';

			$logo->move($url, $filename);

			// Return the url so we can save it in the db
			return $url . $filename;
		}

		return null;
	}
}
