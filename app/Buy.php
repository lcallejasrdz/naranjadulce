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
        'thematic',
        'modifications',
        'buy_message',
        'delivery_date',
        'schedule_id',
        'observations',
        'how_know_us',
        'how_know_us_other',
        'address_references',
        'address_type',
        'parking',
        'who_sends',
        'who_receives',
        'return_reason',
        'delivery_man',
        'status_id',
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
