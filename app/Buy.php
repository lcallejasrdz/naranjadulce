<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Buy extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug',
        'email',
        'first_name',
        'last_name',
        'phone',
        'postal_code',
        'state',
        'municipality',
        'colony',
        'street',
        'no_ext',
        'no_int',
        'package',
        'modifications',
        'buy_message',
        'delivery_date',
        'delivery_schedule',
        'how_know_us',
        'how_know_us_other',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    ];

    /**
    * To allow soft deletes
    */
    use SoftDeletes;

    protected $dates = ['deleted_at'];
}