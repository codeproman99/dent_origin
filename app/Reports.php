<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reports extends Model
{
    /**
     * Base Table
     *
     * @var string
     */
    protected $table = 'reports';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'dentist_id', 'year', 'month', 'flat_price_month', 'rate_month'
    ];

    /**
     * The attributes Date
     *
     * @var array
     */
    protected $dates = [ 'created_at', 'updated_at' ];
}
