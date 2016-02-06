<?php
class AppointmentController extends Controller
{

	/**
	 * Show the calendar
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('pages.appointment.index');
	}

}
