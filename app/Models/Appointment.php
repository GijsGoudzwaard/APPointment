<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'closed', 'user_id', 'appointment_type_id', 'scheduled_at', 'to'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['deleted_at'];

    /**
     * A belongsTo relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function appointmentType()
    {
        return $this->belongsTo(AppointmentType::class);
    }

    /**
     * A belongsTo relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function repeat()
    {
        return $this->belongsTo(Repeat::class, 'repeated_id');
    }

    /**
     * Check if the current time is occupied.
     *
     * @param  object      $data
     * @param  null|Carbon $current_time
     * @return mixed
     */
    public static function check($data, $current_time = null)
    {
        $company_hours = (object) get_company()->dayTimes(Carbon::parse($data->date)->startOfDay());

        $appointment = Appointment::with('appointmentType')
            ->whereBetween('scheduled_at',
                [
                    ($current_time ?: $company_hours->from),
                    $company_hours->from->copy()->addMinutes($data->time)
                ])
            ->where('user_id', $data->employee_id)
            ->first();

        return $appointment;
    }

    /**
     * Get the repeated appointments and set their date to the correct date
     *
     * @param  Repeat $repeat
     * @return Appointment
     */
    public static function repeatedAppointments($repeat)
    {
        if (! $repeat->appointment) {
            return;
        }

        $appointment = $repeat->appointment;
        $new_date = Carbon::parse($appointment->scheduled_at);
        $days = $new_date->diff(Carbon::parse(request()->get('date'))->startOfDay())->days + 1;
        $appointment->scheduled_at = $new_date->addDays($days)->format('Y-m-d H:i');
        $appointment->to = Carbon::parse($appointment->to)->addDays($days)->format('Y-m-d H:i');

        return $appointment;
    }
}
