<?php

namespace App\Http\Controllers;

use App\Http\Requests\UrlParser;
use App\Models\AppointmentType;
use App\Models\Company;
use App\Models\User;
use Cache;
use Carbon\Carbon;
use Validator;
use App\Jobs\Verify;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Verify
{
    /**
     * Keep track of the current time.
     *
     * @var Carbon
     */
    private $current_time;

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
     * Get all appointments from your company
     *
     * @param  Request $request
     * @return array
     */
    public function get(Request $request)
    {
        $start = date('Y-m-d H:i:s', $request->get('start'));
        $end = date('Y-m-d H:i:s', $request->get('end'));
        $appointments = get_company()->appointments([$start, $end])->with('appointmentType')->get();

        return $appointments;
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
        $appointment_types = get_company()->appointmentTypes->pluck('name', 'id');
        $users = [];

        foreach (get_company()->users as $user) {
            $users[$user->id] = $user->firstname . ' ' . $user->surname;
        }

        return view('pages.appointments.create', compact('date', 'appointment_types', 'users'));
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

        if (! $request->get('closed')) {
            $request->request->add(['closed' => 0]);
        }

        $appointment = new Appointment;
        $appointment->fill($request->all());
        $appointment->scheduled_at = $this->formatDate($request->scheduled_at);
        $appointment->to = $this->formatDate($request->to);
        $appointment->save();

        return redirect()->route('appointments.edit', $appointment->id)->with('success', 'Successfully created');
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
        $appointment_types = get_company()->appointmentTypes->pluck('name', 'id');
        $users = [];

        foreach (get_company()->users as $user) {
            $users[$user->id] = $user->firstname . ' ' . $user->surname;
        }

        return view('pages.appointments.edit', compact('appointment', 'appointment_types', 'users'));
    }

    /**
     * Update the record by it's $id
     *
     * @param  Request $request
     * @param  int     $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $validator = $this->verify($request->all());

        if ($validator) {
            return $validator;
        }

        if (! $request->get('closed')) {
            $request->request->add(['closed' => 0]);
        }

        $appointment = Appointment::find($id);
        $appointment->fill($request->all());
        $appointment->scheduled_at = $this->formatDate($request->get('scheduled_at'));
        $appointment->to = $this->formatDate($request->to);
        $appointment->save();

        return redirect()->back()->with('success', 'Successfully updated');
    }

    /**
     * Delete an appointment
     *
     * @param  int $id
     * @return mixed
     */
    public function destroy($id)
    {
        $appointment = Appointment::find($id);
        $appointment->delete();

        return redirect()->route('appointments.index')->with('success', 'Successfully deleted');
    }

    /**
     * Create a new Validor instance
     *
     * @param  Request $request
     * @param  mixed   $rules
     * @return Validator
     */
    public function validator($request, $rules = null)
    {
        return Validator::make($request, [
            'name' => 'required|max:255',
            'scheduled_at' => 'required|date'
        ]);
    }

    /**
     * Count all appointments per month of this year
     *
     * @return \Illuminate\Support\Collection
     */
    public function getStats()
    {
        $appointments = [];

        // See if we already have a cache file
        if (Cache::has('appointment_stats')) {
            return Cache::get('appointment_stats');
        }

        for ($i = 1; $i <= 12; $i++) {
            $date = Carbon::create(Carbon::now()->year, $i, 1, 0);

            $appointments[] = get_company()->appointments([
                $date->startOfMonth()->toDateTimeString(),
                $date->endOfMonth()->toDateTimeString()
            ])->selectRaw('count(*) as amount')->where('closed', 0)->get()->pluck('amount')->sum();
        }

        // Store the appointment stats in a cache file for a day
        Cache::store('file')->put('appointment_stats', collect($appointments)->flatten(), 1440);

        return collect($appointments)->flatten();
    }

    /**
     * Get the income of this month
     *
     * @return \Illuminate\Support\Collection
     */
    public function income()
    {
        $appointment_types = get_company()->appointmentTypes->load([
            'appointments' => function ($appointments) {
                return $appointments->whereBetween('scheduled_at', [
                    Carbon::now()->startOfMonth()->toDateTimeString(),
                    Carbon::now()->toDateTimeString()
                ]);
            }
        ]);

        return collect($appointment_types->map(function ($appointment_type) {
            return str_replace(',', '.', $appointment_type->price) * $appointment_type->appointments->count();
        }));
    }

    /**
     * Book a new appointment
     * This method is only accessed through the api
     *
     * @TODO: clean this up
     *
     * @param  Request $request
     * @return string
     */
    public function book(Request $request)
    {
        $appointment = new Appointment;
        $appointment->name = $request->input('user.firstname') . ' ' . $request->input('user.surname') . ' - ' . $request->input('appointment.appointmentType.name');
        $appointment->user_id = $request->input('appointment.employee.id');
        $appointment->appointment_type_id = $request->input('appointment.appointmentType.id');

        $date = Carbon::parse($request->input('appointment.date'));
        list($hour, $minute) = explode(':', $request->input('appointment.from'));
        $date->setTime($hour, $minute);

        $appointment->scheduled_at = $date->toDateTimeString();
        $appointment->save();

        return 'Succesfully booked';
    }

    /**
     * Get all booked dates
     *
     * @param  Request $request
     * @return array
     */
    public function booked(Request $request)
    {
        $booked_days = [];
        $date = Carbon::parse($request->get('timestamp'));
        $company = Company::where('subdomain', UrlParser::getSubdomain())->first();
        $closed_days = array_diff_key($company->days, (array) $company->openingHours());

        for ($i = 1; $i < $date->daysInMonth; $i++) {
            $day = $date->addDays(1);

            if (in_array($day->format('l'), $closed_days)) {
                $booked_days[] = [
                    'start_time' => $day->startOfDay()->toDateTimeString(),
                    'end_time' => $day->endOfDay()->toDateTimeString()
                ];
            }
        }

        return $booked_days;
    }

    /**
     * Check if the current time is occupied.
     *
     * @param  Request $request
     * @return array
     */
    public function check(Request $request)
    {
        return ['exists' => (boolean) Appointment::check((object) $request->all(), $this->current_time)];
    }

    /**
     * Get all available timeblocks
     *
     * @TODO: Remove the json arrays from the request
     *
     * @param  Request $request
     * @return array
     */
    public function timeblocks(Request $request)
    {
        $timeblocks = [];
        $appointment_type = json_decode($request->get('appointmentType'), true);
        $company_hours = (object) get_company()->dayTimes(Carbon::parse($request->get('date'))->startOfDay());
        $this->current_time = $company_hours->from;

        $counter = 0;

        while ($this->current_time->lt($company_hours->to) && $this->current_time->copy()->addMinutes($appointment_type['time'])->lt($company_hours->to)) {
            $appointment = Appointment::check((object) $request->all(), $this->current_time);

            if ($appointment) {
                $this->current_time = Carbon::parse($appointment->scheduled_at)->addMinutes($appointment->appointmentType->time);
                continue;
            }

            if ($counter === 2) {
                $this->current_time->addMinutes($appointment_type['buffer']);
            }

            $timeblocks[] = [
                'from' => $this->current_time->format('H:i'),
                'to' => $this->current_time->addMinutes($appointment_type['time'])->format('H:i')
            ];

            if ($counter === 2) {
                $counter = 0;
                continue;
            }

            $counter++;
        }

        return $timeblocks;
    }
}
