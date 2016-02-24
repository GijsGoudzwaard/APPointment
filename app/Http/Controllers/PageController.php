<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
	/**
	 * Show the dashboard
	 *
	 * @return Response
	 */
	public function dashboard()
	{
	    return view('pages.dashboard');
	}

}
