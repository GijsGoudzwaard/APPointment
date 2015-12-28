<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Environment extends Model {

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
    protected $fillable = [];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
}
