<?php

namespace App\Http\Controllers;

use Validator;
use App\Jobs\Verify;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Verify
{
	/**
	 * Show the calendar
	 *
	 * @return mixed
	 */
	public function index()
	{
		return view('pages.appointments.index');
	}

	/**
	 * Show the create form
	 *
	 * @param  Request $request
	 * @return mixed
	 */
	public function create(Request $request)
	{
		$date = date('Y-m-d H:i:s', $request->get('date'));
		$appointment_types = get_company()->appointmentTypes->lists('name', 'id');

		return view('pages.appointments.create', compact(['date', 'appointment_types']));
	}

	/**
	 * Store a new record
	 *
	 * @param  Request $request
	 * @return mixed
	 */
	public function store(Request $request)
	{
		$validator = $this->verify($request->all());

		if ($validator) {
			return $validator;
		}

		$appointment = new Appointment;
		$appointment->fill($request->all());
		$appointment->save();

		return redirect('appointments/' . $appointment->id . '/edit')->with('success', 'Successfully updated');
	}

	/**
	 * Show the edit form
	 *
	 * @param  int $id
	 * @return mixed
	 */
	public function edit($id)
	{
		$appointment = Appointment::find($id);
		$appointment_types = get_company()->appointmentTypes->lists('name', 'id');

		return view('pages.appointments.edit', compact(['appointment', 'appointment_types']));
	}

	/**
	 * Update the record by it's $id
	 *
	 * @param  Request $request
	 * @param  int $id
	 * @return mixed
	 */
	public function update(Request $request, $id)
	{
		$validator = $this->verify($request->all());

		if ($validator) {
			return $validator;
		}

		$appointment = Appointment::find($id);
		$appointment->fill($request->all());
		$appointment->save();

		return redirect()->back()->with('success', 'Successfully updated');
	}

	/**
	 * Create a new Validor instance
	 *
	 * @param  Request $request
	 * @return Validator
	 */
	public function validator($request, $rules = null)
	{
		return Validator::make($request, [
			'name' => 'required|max:255',
			'scheduled_at' => 'required|date'
		]);
	}
}
