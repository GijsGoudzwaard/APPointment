<?php

namespace App\Http\Controllers;


class AppointmentController extends Controller
{

	/**
	 * Show the calendar
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('pages.appointments.index');
	}

}
