<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use App\Models\Company;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['firstname', 'surname', 'email', 'phonenumber'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

	/**
	 * All the user roles
	 *
	 * @var array
	 */
	private static $roles = [
		'employee' => 0,
		'admin' => 1,
		'customer' => 2,
	];

	/**
	 * Get the company of the user
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function company()
	{
		return $this->belongsTo(Company::class, 'company_id');
	}

	/**
	 * Get the role of a user
	 *
	 * @param  string $role
	 * @return integer
	 */
	public static function role($role)
	{
	    return static::$roles[$role];
	}
}
