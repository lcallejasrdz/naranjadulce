<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ViewBuy extends Model
{
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
        'delivery_schedule',
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
        'status_id',
    ];

    public function scopeData($query)
    {
        return $query->get();
    }
}
