<?php

namespace App\Http\Controllers;

use App\Models\Company;

class CompanyController extends Controller
{
	public function index()
	{
		$company = Company::where('environment_id', '=', get_environment()->id)->limit(1)->get();

		return view('pages.company.index', compact('company'));
	}
}
