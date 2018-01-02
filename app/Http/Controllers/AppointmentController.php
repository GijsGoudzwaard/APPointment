<?php

namespace App\Http\Controllers;

use Cache;
use Validator;
use Carbon\Carbon;
use App\Jobs\Verify;
use App\Models\User;
use App\Models\Repeat;
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
        $appointments = get_company()->appointments([$start, $end])->with('appointmentType')
            ->where('repeated_id', null)->get();

        $repeated_appointments = Repeat::with('appointment')
            ->where('start', '<', $end)->get()->map(function ($repeat) use ($end) {
                if (!$repeat->appointment) {
                    return null;
                }

                $appointments = [];

                $days = Carbon::parse($repeat->start)->diff(Carbon::parse($end))->days;

                for ($i = 0; $i < $days; $i++) {
                    $append = clone $repeat->appointment;
                    $append->scheduled_at = Carbon::parse($append->scheduled_at)->addDay($i)->format('Y-m-d H:i:s');
                    $append->to = Carbon::parse($append->to)->addDay($i)->format('Y-m-d H:i:s');
                    $appointments[] = $append;

                    if ($repeat->end && Carbon::parse($append->scheduled_at)->gt(Carbon::parse($repeat->end))) {
                        break;
                    }
                }

                return $appointments;
            })->filter()->flatten();

        return $repeated_appointments->merge($appointments);
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

        if (!$request->get('closed')) {
            $request->request->add(['closed' => 0]);
        }

        $appointment = new Appointment;
        $appointment->fill($request->all());
        $appointment->scheduled_at = $this->formatDate($request->scheduled_at);
        $appointment->to = $this->formatDate($request->to);

        if ($request->get('repeat')) {
            $repeat = new Repeat;

            $repeat->start = Carbon::parse($appointment->scheduled_at)->toDateString();
            $repeat->end = $request->get('end') ? Carbon::parse($request->get('end'))->toDateString() : null;
            $repeat->save();

            $appointment->repeated_id = $repeat->id;
        }

        $appointment->save();

        return redirect()->route('appointments.index')->with('success', 'Successfully created');
    }

    /**
     * Show the edit form
     *
     * @param  int $id
     * @return mixed
     */
    public function edit($id)
    {
        $appointment = Appointment::with('repeat')->find($id);
        $company = get_company()->load(['appointmentTypes', 'users']);
        $appointment_types = $company->appointmentTypes->pluck('name', 'id');
        $users = [];

        foreach ($company->users as $user) {
            $users[$user->id] = $user->firstname . ' ' . $user->surname;
        }

        return view('pages.appointments.edit', compact('appointment', 'appointment_types', 'users'));
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

        if (!$request->get('closed')) {
            $request->request->add(['closed' => 0]);
        }

        $appointment = Appointment::find($id);
        $appointment->fill($request->all());
        $appointment->scheduled_at = $this->formatDate($request->get('scheduled_at'));
        $appointment->to = $this->formatDate($request->to);

        if ($request->get('repeat')) {
            $repeat = $appointment->repeated_id ? Repeat::find($appointment->repeated_id) : new Repeat;

            $repeat->start = Carbon::parse($appointment->scheduled_at)->toDateString();
            $repeat->end = $request->get('end') ? Carbon::parse($request->get('end'))->toDateString() : null;
            $repeat->save();

            $appointment->repeated_id = $repeat->id;
        } else {
            $appointment->repeated_id = null;
        }

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
     * @param  mixed $rules
     * @return \Illuminate\Validation\Validator
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
        $cache = 'appointment_stats_' . get_company()->subdomain;

        // See if we already have a cache file
        if (Cache::has($cache)) {
            return Cache::get($cache);
        }

        for ($i = 1; $i <= 12; $i++) {
            $date = Carbon::create(Carbon::now()->year, $i, 1, 0);

            $appointments[] = get_company()->appointments([
                $date->startOfMonth()->toDateTimeString(),
                $date->endOfMonth()->toDateTimeString()
            ])->selectRaw('count(*) as amount')->where('closed', 0)->where('repeated_id', null)->get()->pluck('amount')->sum();
        }

        $appointments = collect($appointments)->flatten();

        // Store the appointment stats in a cache file for a day
        Cache::put($cache, $appointments, 1440);

        return $appointments;
    }

    /**
     * Get the income of this month
     *
     * @return \Illuminate\Support\Collection
     */
    public function income()
    {
        $cache = 'monthly_income_' . get_company()->subdomain;

        // See if we already have a cache file
        if (Cache::has($cache)) {
            return Cache::get($cache);
        }

        $appointment_types = get_company()->appointmentTypes()->with([
            'appointments' => function ($appointments) {
                return $appointments->whereBetween('scheduled_at', [
                    Carbon::now()->startOfMonth()->toDateTimeString(),
                    Carbon::now()->endOfMonth()->toDateTimeString()
                ])->where('repeated_id', null);
            }
        ])->get();

        $total_income = collect($appointment_types->map(function ($appointment_type) {
            return str_replace(',', '.', $appointment_type->price) * $appointment_type->countAppointments();
        }));

        // Store the appointment stats in a cache file for a day
        Cache::put($cache, collect($total_income)->flatten(), 1440);

        return $total_income;
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
        $appointment->employee_id = $request->input('appointment.employee.id');
        $appointment->customer_id = $request->input('user.id');
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
        $company = get_company();
        $closed_days = array_diff_key($company->days, (array)$company->openingHours());

        for ($i = 1; $i <= $date->daysInMonth; $i++) {
            $day = $date->addDays(1);

            if (in_array($day->format('l'), $closed_days) || $this->available($request, $day)) {
                $booked_days[] = [
                    'start_time' => $day->startOfDay()->toDateTimeString(),
                    'end_time' => $day->endOfDay()->toDateTimeString()
                ];
            }
        }

        return $booked_days;
    }

    /**
     * Check if the current date is available.
     *
     * @param  Request $request
     * @param  Carbon $date
     * @return bool
     */
    public function available(Request $request, $date)
    {
        $request->replace(array_merge($request->all(), ['date' => $date]));

        return count($this->timeblocks($request)) === 0;
    }

    /**
     * Check if the current time is occupied.
     *
     * @param  Request $request
     * @return array
     */
    public function check(Request $request)
    {
        if (!User::canBook($request->get('customer_id'))) {
            return ['error' => 'You can only book 3 appointments per hour.'];
        }

        $current_time = Carbon::parse($request->get('date'))->setTime(
            ...explode(':', $request->get('from'))
        );

        $exists = Appointment::check((object)$request->all(), $current_time);

        if ($exists) {
            return ['error' => 'The chosen appointment is not available anymore.'];
        }

        return ['exists' => false];
    }

    /**
     * Get all available timeblocks
     *
     * @TODO: Remove the json arrays from the request
     * @TODO: Clean this up
     *
     * @param  Request $request
     * @return array
     */
    public function timeblocks(Request $request)
    {
        $timeblocks = [];
        $appointment_type = json_decode($request->get('appointmentType'), true);
        $employee = json_decode($request->get('employee'), true);
        $company_hours = (object)get_company()->dayTimes(Carbon::parse($request->get('date'))->startOfDay());
        $this->current_time = $company_hours->from->copy();

        $counter = 0;
        $appointments = Appointment::with('appointmentType')
            ->where(function ($q) use ($company_hours) {
                $q->where(function ($q) use ($company_hours) {
                    $q->where('scheduled_at', '>=', $company_hours->from->copy()->startOfDay());
                    $q->where('scheduled_at', '<=', $company_hours->to->copy()->endOfDay());
                });

                $q->orWhereBetween('scheduled_at', [
                    $company_hours->from,
                    $company_hours->to
                ]);
            })
            ->where(function ($q) use ($employee) {
                $q->where(function ($q) use ($employee) {
                    $q->where('employee_id', $employee['id']);
                    $q->where('closed', 0);
                });

                $q->orWhere('closed', 1);
            })
            ->get();

        $repeated_appointments = Repeat::with('appointment')
            ->where('start', '<', $company_hours->from)
            ->where('end', '>', $company_hours->to)
            ->orWhereNull('end')->get()->map([Appointment::class, 'repeatedAppointments'])->filter();

        $appointments = $repeated_appointments->merge($appointments);

        while ($this->current_time->lte($company_hours->to) && $this->current_time->copy()->addMinutes($appointment_type['time'])->lte($company_hours->to)) {
            $current_time = $this->current_time->copy();
            $appointment = $appointments->filter(function ($appointment) use ($current_time) {
                if (Carbon::parse($appointment->scheduled_at) == $current_time->format('Y-m-d H:i:s') &&
                    (Carbon::parse($appointment->scheduled_at) <= $current_time->copy()->addMinutes($appointment->appointmentType->time)->format('Y-m-d H:i:s') || Carbon::parse($appointment->to) > $current_time)
                ) {
                    return $appointment;
                }
            })->first();
            $counter++;

            if ($appointment) {
                if ($appointment->closed) {
                    $diff = Carbon::parse($appointment->scheduled_at)->diff(Carbon::parse($appointment->to));
                    $minutes = $diff->i + ($diff->h * 60);

                    $counter = 0;
                }

                $this->current_time = $this->current_time->addMinutes($appointment->closed ? $minutes : $appointment->appointmentType->time);
                continue;
            }

            if ($counter > 2) {
                $this->current_time->addMinutes($appointment_type['buffer']);
                $counter = 0;

                continue;
            }

            $day = strtolower($this->current_time->copy()->format('D'));
            $from = $this->current_time->copy()->format('H:i');
            $to = $this->current_time->copy()->addMinutes($appointment_type['time'])->format('H:i');

            // Remove this
            if (in_array($day, ['wed', 'fri']) && $from >= '12:00' && $to < '12:30') {
                continue;
            }

            $timeblocks[] = [
                'from' => $this->current_time->format('H:i'),
                'to' => $this->current_time->addMinutes($appointment_type['time'])->format('H:i')
            ];
        }

        return $timeblocks;
    }
}
