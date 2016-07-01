<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
	/**
	 * Show the dashboard
	 *
	 * @return mixed
	 */
	public function dashboard()
	{
	    return view('pages.dashboard');
	}

}
