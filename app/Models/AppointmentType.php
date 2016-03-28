<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Company;

class AppointmentType extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'appointment_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'time', 'price'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

	/**
	 * A belongsTo relation
	 *
	 * @return App\Models\Company
	 */
	public function company()
	{
		return $this->belongsTo(Company::class);
	}
}
