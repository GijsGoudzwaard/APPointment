<?php

namespace App\Http\Controllers;

use App\Http\File;
use App\Models\Company;
use Illuminate\Http\Request;
use Validator;

class CompanyController extends Controller
{
	/**
	 * Show the company of the logged in user
	 *
	 * @return mixed
	 */
	public function index(Request $request)
	{
		// Check if we need to show all the companies or not
		if ($request->path() == 'companies') {
			$companies = Company::all();

			return view('pages.company.index', compact('companies'));
		}

		return view('pages.company.edit', [
			'company' => get_company()
		]);
	}

	public function create()
	{
		return view('pages.company.create', [
			'days' => (new Company)->days
		]);
	}

	public function store(Request $request)
	{
		$validator = $this->validator($request->all());
		if ($validator->fails()) {
			return redirect()->back()->with('errors', $validator->errors()->all())->withInput();
		}

		$company = new Company;
		$opening_hours = [];

		foreach ($request->get('from') as $key => $from) {
			$opening_hours[$key] = [
				'from' => $from,
				'to' => $request->get('to')[$key]
			];
		}

		$company->fill($request->all());
		$company->subdomain = clean_string($request->get('subdomain'));
		$company->opening_hours = json_encode($opening_hours);

		if ($request->hasFile('logo')) {
			$path = File::upload($request, 'logo');
			if (is_array($path)) {
				return redirect()->back()->with('errors', $path)->withInput();
			}

			$company->logo = $path ?? $company->logo;
		}

		$company->save();

		return redirect('companies/' . $company->id . '/edit')->with('success', 'Successfully created');
	}

	public function edit($company_id, Request $request)
	{
		$company = Company::find($company_id);
		if (strpos($request->path(), 'companies') !== false) {
			$allowed = true;
		}

		return view('pages.company.edit', [
			'company' => $company,
			'allowed' => $allowed ?? false
		]);
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
		$validator = $this->validator($request->all(), $company);

		if ($validator->fails()) {
			return redirect()->back()->with('errors', $validator->errors()->all())->withInput();
		}

		if (strpos($request->path(), 'companies') !== false) {
			$allowed = true;
		}

		$opening_hours = [];

		foreach ($request->get('from') as $key => $from) {
			$opening_hours[$key] = [
				'from' => $from,
				'to' => $request->get('to')[$key]
			];
		}

		$company->fill($request->all());

		if (isset($allowed) && $allowed) {
			$company->subdomain = clean_string($request->get('subdomain'));
		}

		$company->opening_hours = json_encode($opening_hours);

		if ($request->hasFile('logo')) {
			$path = File::upload($request, 'logo');
			if (is_array($path)) {
				return redirect()->back()->with('errors', $path)->withInput();
			}

			$company->logo = $path ?? $company->logo;
		}

		$company->save();

		return redirect()->back()->with('success', 'Successfully updated');
	}

	/**
	 * Create a new Validor instance
	 *
	 * @param  Request $request
	 * @return Validator
	 */
	public function validator($request, $company = null)
	{
		return Validator::make($request, [
			'name' => 'required|max:255',
			'subdomain' => 'required|max:255',
			'email' => 'required|email|' . (isset($company) && $company->email == $request['email']) ? '' : '|unique:users' . '|max:255',
			'address' => 'required',
			'phonenumber' => 'required'
		]);
	}
}
