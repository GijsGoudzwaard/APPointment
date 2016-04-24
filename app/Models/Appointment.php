<?php

namespace App\Models;

use App\Models\AppointmentType;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'appointment_type_id', 'scheduled_at'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

	/**
	 * A belongsTo relation
	 *
	 * @return App\Models\AppointmentType
	 */
	public function appointmentType()
	{
		return $this->belongsTo(AppointmentType::class);
	}
}
