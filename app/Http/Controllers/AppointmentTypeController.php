<?php

namespace App\Http\Controllers;

use App\Models\AppointmentType;
use Illuminate\Http\Request;
use Validator;

class AppointmentTypeController extends Controller
{

	/**
	 * Show the calendar
	 *
	 * @return Response
	 */
	public function index()
	{
		$appointment_types = get_company()->appointmentTypes;

		return view('pages.appointmenttypes.index', compact('appointment_types'));
	}

	/**
	 * Show the edit form
	 *
	 * @param Int $appointment_type_id
	 * @return Response
	 */
	public function edit($appointment_type_id)
	{
		$appointment_type = AppointmentType::find($appointment_type_id);

		return view('pages.appointmenttypes.edit', compact('appointment_type'));
	}

	/**
	 * Update the appointment_type
	 *
	 * @param  Request $request
	 * @param  Int $appointment_type_id
	 * @return Response
	 */
	public function update(Request $request, $appointment_type_id)
	{
		$validator = $this->validator($request->all());

		if ($validator->fails()) {
			return redirect()->back()->with('errors', $validator->errors()->all())->withInput();
		}

		$appointment_type = AppointmentType::find($appointment_type_id);
		$appointment_type->fill($request->all());
		$appointment_type->save();

		return redirect()->back()->with('success', 'Successfully updated');
	}

	/**
	 * Show the create form
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('pages.appointmenttypes.create');
	}

	/**
	 * Create a new appointment_type
	 *
	 * @param  Request $request
	 * @return Response
	 */
	public function store(Request $request)
	{
		$validator = $this->validator($request->all());

		if ($validator->fails()) {
			return redirect()->back()->with('errors', $validator->errors()->all())->withInput();
		}

		$appointment_type = new AppointmentType;
		$appointment_type->fill($request->all());
		$appointment_type->company_id = get_company()->id;
		$appointment_type->save();

		return redirect('appointmenttypes/' . $appointment_type->id . '/edit')->with('success', 'Successfully updated');
	}


	/**
	 * Create a new Validor instance
	 *
	 * @param  Request $request
	 * @return Validator
	 */
	public function validator($request)
	{
		return Validator::make($request, [
			'name' => 'required|max:255',
			'time' => 'required|integer',
			'price' => 'required|integer'
		]);
	}
}
