<?php

namespace App\Http\Controllers;

use App\Http\Requests\UrlParser;

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
