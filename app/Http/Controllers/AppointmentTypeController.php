<?php

namespace App\Http\Controllers;

use App\Http\Requests\UrlParser;
use App\Models\Company;
use Cache;
use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\AppointmentType;

class AppointmentTypeController extends Controller
{

    /**
     * Show the calendar
     *
     * @return mixed
     */
    public function index()
    {
        $appointment_types = get_company()->appointmentTypes;

        return view('pages.appointmenttypes.index', compact('appointment_types'));
    }

    /**
     * Show the edit form
     *
     * @param int $appointment_type_id
     * @return mixed
     */
    public function edit($appointment_type_id)
    {
        $appointment_type = AppointmentType::find($appointment_type_id);
        $active_employees = $appointment_type->users->pluck('id')->toArray();
        $users = get_company()->users->where('role', 1);
        $employees = [];

        foreach ($users as $key => $user) {
            $employees[$user->id] = $user->firstname . ' ' . $user->surname;
        }

        return view('pages.appointmenttypes.edit', compact(
            'appointment_type',
            'employees',
            'active_employees'
        ));
    }

    /**
     * Update the appointment_type
     *
     * @param  Request $request
     * @param  int     $appointment_type_id
     * @return mixed
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

        $appointment_type->users()->sync($request->get('employees'));

        return redirect()->back()->with('success', 'Successfully updated');
    }

    /**
     * Show the create form
     *
     * @return mixed
     */
    public function create()
    {
        $users = get_company()->users->where('role', 1);
        $employees = [];

        foreach ($users as $key => $user) {
            $employees[$user->id] = $user->firstname . ' ' . $user->surname;
        }

        return view('pages.appointmenttypes.create', compact('employees'));
    }

    /**
     * Create a new appointment_type
     *
     * @param  Request $request
     * @return mixed
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

        foreach ($request->get('employees') as $index => $employee) {
            $user = User::find($employee);
            $user->appointmentTypes()->attach($appointment_type->id);
        }

        return redirect('appointmenttypes/' . $appointment_type->id . '/edit')->with('success', 'Successfully updated');
    }

    /**
     * Delete an appointment type
     *
     * @param  int $id
     * @return mixed
     */
    public function destroy($id)
    {
        $appointment_type = AppointmentType::find($id);
        $appointment_type->delete();

        return redirect()->back()->with('success', 'Successfully deleted');
    }

    /**
     * Get all the appointment types for the doughnut chart
     *
     * @return mixed
     */
    public function getStats()
    {
        $cache = 'appointment_type_stats_' . get_company()->subdomain;

        // See if we already have a cache file
        if (Cache::has($cache)) {
            return Cache::get($cache);
        }

        $appointment_types = get_company()->appointmentTypes;

        $stats = collect($appointment_types->map([$this, 'getAppointments']));

        // Store the appointment stats in a cache file for a day
        Cache::put($cache, $stats, 1440);

        return $stats;
    }

    /**
     * Count all the appointments associated with the appointment type
     *
     * @param  AppointmentType $appointment_type
     * @return array
     */
    public function getAppointments(AppointmentType $appointment_type)
    {
        return [
            'name' => $appointment_type->name,
            'amount' => $appointment_type->countAppointments(),
            'price' => $appointment_type->price
        ];
    }

    /**
     * Get all the appointment types based on this company
     *
     * @return mixed
     */
    public function get()
    {
        $company = get_company();

        return $company->appointmentTypes()->select(['id', 'name', 'time', 'buffer'])->get();
    }

    /**
     * Create a new Validor instance
     *
     * @param  Request $request
     * @return Validator
     */
    private function validator($request)
    {
        return Validator::make($request, [
            'name' => 'required|max:255',
            'time' => 'required|integer',
            'price' => 'required',
            'employees' => 'required'
        ]);
    }
}
