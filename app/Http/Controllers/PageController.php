<?php

namespace App\Http\Controllers;

class PageController extends Controller {

	/**
	 * Show the dashboard
	 *
	 * @return Mixed
	 */
	public function dashboard () {
	    return view('pages.dashboard');
	}

}
