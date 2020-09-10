<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedules extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'dentist_id', 'calendar_id', 'start', 'end'
    ];

    /**
     * The attributes Date
     *
     * @var array
     */
     protected $dates = ['start', 'end'];

}
