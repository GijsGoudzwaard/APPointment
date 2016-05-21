<?php

namespace App\Models;

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
    protected $fillable = ['name', 'appointment_type_id', 'scheduled_at'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['deleted_at'];

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
