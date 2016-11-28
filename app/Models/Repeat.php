<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Repeat extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['start', 'end'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'repeated_appointments';

    /**
     * A belongsTo relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function appointment()
    {
        return $this->hasOne(Appointment::class, 'repeated_id');
    }
}
