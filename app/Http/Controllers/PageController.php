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
		// dd(\App\Http\Requests\UrlParser::getHost(null, false, false, false));
	    return view('pages.dashboard');
	}

}
