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
        $appointment_type = json_decode($data->appointmentType, true);
        $employee = json_decode($data->employee, true);
        $company_hours = (object) get_company()->dayTimes(Carbon::parse($data->date)->startOfDay());

        $appointment = Appointment::with('appointmentType')
            ->whereBetween('scheduled_at',
                [
                    ($current_time ?: $company_hours->from),
                    $current_time->copy()->addMinutes($appointment_type['time'])
                ])
            ->where('user_id', $employee['id'])
            ->first();


        if (! $appointment) {
            $repeated = Repeat::with('appointment')
                ->where('start', '<', $current_time)
                ->where('end', '>', $current_time)
                ->orWhereNull('end')->get();

            foreach ($repeated as $repeat) {
                if ($current_time->format('H:i') == Carbon::parse($repeat->appointment->scheduled_at)->format('H:i')) {
                    $appointment = $repeat->appointment;

                    $new_date = Carbon::parse($appointment->scheduled_at);
                    $days = $new_date->diff($current_time)->days;
                    $appointment->scheduled_at = $new_date->addDays($days)->format('Y-m-d H:i');
                    $appointment->to = Carbon::parse($appointment->to)->addDays($days)->format('Y-m-d H:i');

                }
            }
        }

        if ($appointment && $appointment->name == 'Pauze 2') {
//            dd($current_time, $appointment);
        }

        return $appointment;
    }
}
