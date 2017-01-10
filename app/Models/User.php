<?php

namespace App\Models;

use Auth;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['firstname', 'surname', 'email', 'phonenumber', 'active'];

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
        'admin' => 0,
        'employee' => 1,
        'customer' => 2,
    ];

    /**
     * Check if the current user is an admin.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return Auth::user()->role === Auth::user()->role('admin');
    }

    /**
     * Check if the user can book.
     * A user can book 3 appointments per hour.
     *
     * @param  int $id
     * @return bool
     */
    public static function canBook(int $id)
    {
        $appointments = Appointment::where('customer_id', $id)->selectRaw('count(*) as amount')
            ->where('created_at', '>', Carbon::now()->subHour())->get()->pluck('amount')->sum();

        return $appointments <= 3;
    }

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

    /**
     * A belongsToMany relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function appointmentTypes()
    {
        return $this->belongsToMany(AppointmentType::class, 'appointment_type_staff');
    }
}
