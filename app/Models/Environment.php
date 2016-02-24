<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Company;

class Environment extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'environments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'subdomain'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

	/**
	 * A has one relation
	 *
	 * @return App\Models\Company
	 */
	public function company()
	{
		return $this->hasOne(Company::class);
	}

}
